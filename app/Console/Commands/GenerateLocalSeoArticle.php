<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Services\GeminiArticleService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateLocalSeoArticle extends Command
{
    protected $signature = 'app:generate-local-seo-article
                            {--keyword= : Birincil SEO anahtar kelimesi (ör. bursa yazılım şirketi)}
                            {--angle= : Makale odağı / açıklama (opsiyonel)}
                            {--all : config/local_seo.php içindeki tüm konuları üret}
                            {--force : Aynı anahtar kelime için yeniden üret}';

    protected $description = 'Gemini ile Bursa odaklı yerel SEO blog makalesi üretir';

    public function __construct(
        private readonly GeminiArticleService $geminiArticleService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        if ($this->option('all')) {
            return $this->generateAll();
        }

        $keyword = $this->option('keyword');

        if (empty($keyword)) {
            $this->error('Bir anahtar kelime girin: --keyword="bursa yazılım şirketi" veya --all kullanın.');

            return self::FAILURE;
        }

        return $this->generateOne($keyword, $this->option('angle'));
    }

    private function generateAll(): int
    {
        $topics = config('local_seo.topics', []);
        $failures = 0;

        foreach ($topics as $topic) {
            $keyword = $topic['keyword'] ?? null;

            if (empty($keyword)) {
                continue;
            }

            $this->newLine();
            $this->info("▶ {$keyword}");

            $result = $this->generateOne($keyword, $topic['angle'] ?? null, quiet: true);

            if ($result !== self::SUCCESS) {
                $failures++;
            }

            sleep(2);
        }

        $this->newLine();
        $this->info('Tamamlandı.');

        return $failures > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function generateOne(string $keyword, ?string $angle = null, bool $quiet = false): int
    {
        $sourceKey = 'local-seo:'.Str::slug($keyword);

        if (! $this->option('force') && Article::query()->where('original_source_url', $sourceKey)->exists()) {
            if (! $quiet) {
                $this->warn("Bu anahtar kelime zaten işlenmiş: {$keyword} (--force ile yeniden üretebilirsiniz)");
            } else {
                $this->line("  Atlandı (zaten var): {$keyword}");
            }

            return self::SUCCESS;
        }

        if (! $quiet) {
            $this->info("Gemini ile yerel SEO makalesi üretiliyor: {$keyword}");
        }

        $generated = $this->geminiArticleService->generateLocalSeoArticle($keyword, $angle);

        if ($generated === null) {
            if (! $quiet) {
                $this->error('Makale üretilemedi. GEMINI_API_KEY ve logları kontrol edin.');
            } else {
                $this->error("  Hata: {$keyword}");
            }

            return self::FAILURE;
        }

        if ($this->option('force')) {
            Article::query()->where('original_source_url', $sourceKey)->delete();
        }

        $slug = $this->uniqueSlug(Str::slug($generated['title']));

        $article = Article::query()->create([
            'title' => $generated['title'],
            'slug' => $slug,
            'content' => $generated['content'],
            'original_source_url' => $sourceKey,
            'image_url' => null,
            'published_at' => now(),
        ]);

        if (! $quiet) {
            $this->info("Makale oluşturuldu: {$article->title}");
            $this->line("Slug: {$article->slug}");
            $this->line('Blog: '.url("/blog/{$article->slug}"));

            if (! empty($generated['meta_description'])) {
                $this->line('Meta: '.$generated['meta_description']);
            }
        } else {
            $this->line("  ✓ {$article->title}");
        }

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
