<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        return view('articles.index', [
            'articles' => Article::query()
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderByDesc('published_at')
                ->get(),
        ]);
    }

    public function show(Article $article)
    {
        abort_unless($article->is_published, 404);

        return view('articles.show', [
            'article' => $article,
            'relatedArticles' => Article::query()
                ->where('is_published', true)
                ->where('id', '!=', $article->id)
                ->orderBy('sort_order')
                ->orderByDesc('published_at')
                ->take(3)
                ->get(),
        ]);
    }
}
