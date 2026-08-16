<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::query()
            ->active()
            ->published()
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->paginate(9);

        return view('front.articles.index', compact('articles'));
    }

    public function show(Article $article): View
    {
        abort_unless($article->status, 404);

        return view('front.articles.show', [
            'article' => $article->load('seo'),
            'seo' => $article->seo,
        ]);
    }
}
