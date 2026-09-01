<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\HomeSection;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::query()
            ->active()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(24);

        return view('front.articles.index', [
            'articles' => $articles,
            'seo' => HomeSection::byKey('articles')?->seo,
        ]);
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
