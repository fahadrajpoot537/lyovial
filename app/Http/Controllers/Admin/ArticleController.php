<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Admin\Concerns\HandlesSeoUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ArticleController extends Controller
{
    use HandlesImageUpload, HandlesSeoUploads;

    public function index(): View
    {
        $items = Article::query()->orderByDesc('published_at')->orderBy('sort_order')->paginate(20);

        return view('admin.articles.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.articles.create');
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $data = $this->payloadWithoutSeo($validated);
        $data['featured_image'] = $this->uploadImage($request, 'featured_image', 'articles');
        $data['author_avatar'] = $this->uploadImage($request, 'author_avatar', 'articles/authors');
        $data['status'] = $request->boolean('status');
        $data['show_on_home'] = $request->boolean('show_on_home');
        $validated['slug'] = $data['slug'];

        $article = Article::create(array_filter($data, fn ($value) => $value !== null));
        $this->syncSeoFromRequest($request, $validated, $article);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article created successfully.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.edit', [
            'item' => $article->load('seo'),
        ]);
    }

    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        $validated = $request->validated();
        $data = $this->payloadWithoutSeo($validated);
        $data['featured_image'] = $this->resolveImageField($request, 'featured_image', 'articles', $article->featured_image);
        $data['author_avatar'] = $this->resolveImageField($request, 'author_avatar', 'articles/authors', $article->author_avatar);
        $data['status'] = $request->boolean('status');
        $data['show_on_home'] = $request->boolean('show_on_home');
        $validated['slug'] = $data['slug'];

        $article->update($data);
        $this->syncSeoFromRequest($request, $validated, $article);

        return back()->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }
}
