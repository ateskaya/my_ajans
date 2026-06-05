<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Services\GeminiArticleService;
use App\Services\RssFeedService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AutoGenerateArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-generate-articles
                            {--feed= : RSS feed URL}
                            {--force : Regenerate even if source URL exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest tech RSS item and generate an original Turkish blog article via Gemini';

    public function __construct(
        private readonly RssFeedService $rssFeedService,
        private readonly GeminiArticleService $geminiArticleService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $feedUrl = $this->option('feed')
            ?? 'https://techcrunch.com/feed/';

        $this->info("RSS kaynağı okunuyor: {$feedUrl}");

        $item = $this->rssFeedService->fetchLatestItem($feedUrl);

        if ($item === null) {
            $this->error('RSS öğesi alınamadı.');

            return self::FAILURE;
        }

        if (empty($item['link'])) {
            $this->error('RSS öğesinde geçerli bir URL bulunamadı.');

            return self::FAILURE;
        }

        $this->line("Kaynak: {$item['title']}");
        $this->line("URL: {$item['link']}");

        if (
            ! $this->option('force')
            && Article::query()->where('original_source_url', $item['link'])->exists()
        ) {
            $this->warn('Bu kaynak URL zaten işlenmiş. İşlem durduruldu.');

            return self::SUCCESS;
        }

        $this->info('Gemini ile özgün makale üretiliyor...');

        $generated = $this->geminiArticleService->generateFromSource(
            $item['title'],
            $item['description'],
            $item['link'],
        );

        if ($generated === null) {
            $this->error('Gemini makale üretemedi. GEMINI_API_KEY ve logları kontrol edin.');

            return self::FAILURE;
        }

        $slug = $this->uniqueSlug(Str::slug($generated['title']));

        $article = Article::query()->create([
            'title' => $generated['title'],
            'slug' => $slug,
            'content' => $generated['content'],
            'original_source_url' => $item['link'],
            'image_url' => $item['image_url'],
            'published_at' => now(),
        ]);

        $this->info("Makale oluşturuldu: {$article->title}");
        $this->line("Slug: {$article->slug}");
        $this->line('Blog: '.url("/blog/{$article->slug}"));

        return self::SUCCESS;
    }

    private function uniqueSlug(string $baseSlug): string
    {
        $slug = $baseSlug !== '' ? $baseSlug : 'makale';
        $original = $slug;
        $counter = 1;

        while (Article::query()->where('slug', $slug)->exists()) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
