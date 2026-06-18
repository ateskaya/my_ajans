<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Blog/Index', [
            'articles' => Article::query()
                ->orderByDesc('published_at')
                ->get(['id', 'title', 'slug', 'content', 'image_url', 'published_at']),
        ]);
    }

    public function show(Article $article): Response
    {
        $plain = preg_replace('/\s+/', ' ', strip_tags($article->content)) ?? '';

        return Inertia::render('Blog/Show', [
            'article' => $article,
            'metaDescription' => Str::limit(trim($plain), 158, '…'),
        ]);
    }
}
