<?php

use App\Http\Controllers\ClearCacheController;
use App\Http\Controllers\Front\ArticleController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\IndustryController;
use App\Http\Controllers\Front\NewsletterController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\ServiceController;
use App\Http\Controllers\Front\ThemeDataController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\StorageFileController;
use App\Models\Article;
use App\Support\SiteFavicon;
use Illuminate\Support\Facades\Route;

Route::get('/clear-cache/{token}', ClearCacheController::class)
    ->where('token', '[A-Za-z0-9\-_]+')
    ->name('clear-cache');

Route::get('/storage/{path}', StorageFileController::class)
    ->where('path', '.*')
    ->name('storage.serve');

Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::get('/favicon.ico', function () {
    $path = SiteFavicon::icoPublicPath();
    abort_unless($path, 404);

    return response()->file($path, [
        'Content-Type' => 'image/png',
        'Cache-Control' => 'public, max-age=31536000, immutable',
    ]);
})->name('favicon.ico');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/sitemap', [SeoController::class, 'htmlSitemap'])->name('sitemap.html');

Route::get('/theme/cms-data', ThemeDataController::class)->name('theme.cms-data');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/blog', [ArticleController::class, 'index'])->name('blog.index');
Route::permanentRedirect('/blog/freeze-drying-of-liposomal-particles-2', '/blog/freeze-drying-of-liposomal-particles');
Route::get('/blog/{article:slug}', [ArticleController::class, 'show'])->name('blog.show');
Route::permanentRedirect('/articles', '/blog');
Route::permanentRedirect('/articles/freeze-drying-of-liposomal-particles-2', '/blog/freeze-drying-of-liposomal-particles');
Route::get('/articles/{article:slug}', function (Article $article) {
    return redirect()->route('blog.show', $article, 301);
});

Route::get('/capabilities', [ServiceController::class, 'index'])->name('capabilities.index');
Route::get('/capabilities/{slug}', [ServiceController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('capabilities.show');

// Legacy /services path — same CMS pages (not old theme HTML)
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('services.show');

Route::get('/industries', [IndustryController::class, 'index'])->name('industries.index');
Route::permanentRedirect('/industries/diagnostic-reagent-lyophilization', '/industries/diagnostic-assay-reagent-manufacturers');
Route::permanentRedirect('/industries/calibrator-control-lyophilization', '/industries/calibrator-control-producers');
Route::permanentRedirect('/industries/microbiology-media-freeze-drying', '/industries/microbiology-media-supplement-suppliers');
Route::permanentRedirect('/industries/analytical-reference-material-lyophilization', '/industries/analytical-testing-laboratories');
Route::permanentRedirect('/industries/research-sample-lyophilization', '/industries/university-institutional-rd-groups');
Route::permanentRedirect('/industries/cosmetic-ingredient-lyophilization', '/industries/cosmetic-ingredient-formulators');
Route::get('/industries/{slug}', [IndustryController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('industries.show');

Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/quality-compliance', [PageController::class, 'quality'])->name('pages.quality');
Route::get('/specimen-library-preservation', [PageController::class, 'specimen'])->name('pages.specimen');
Route::get('/partnerships', [PageController::class, 'partnerships'])->name('pages.partnerships');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('pages.privacy');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

Route::fallback(function (\Illuminate\Http\Request $request) {
    $slug = trim($request->path(), '/');
    abort_unless(preg_match('/^[A-Za-z0-9\-]+$/', $slug) === 1, 404);

    return app(PageController::class)->show($slug);
})->name('pages.show');
