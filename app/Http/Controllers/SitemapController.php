<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = collect([
            [
                'loc' => route('home'),
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
            [
                'loc' => route('services.index'),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ],
            [
                'loc' => route('case-studies.index'),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ],
            [
                'loc' => route('contact.index'),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            [
                'loc' => route('wizard.index'),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            [
                'loc' => route('blog.index'),
                'changefreq' => 'daily',
                'priority' => '0.8',
            ],
            [
                'loc' => route('labs.index'),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ],
            [
                'loc' => route('status.index'),
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ],
        ]);

        Article::query()
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->get(['slug', 'updated_at', 'published_at'])
            ->each(function (Article $article) use ($urls): void {
                $urls->push([
                    'loc' => route('blog.show', $article->slug),
                    'lastmod' => ($article->updated_at ?? $article->published_at)?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ]);
            });

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
