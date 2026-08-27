<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Industry;
use App\Models\Page;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SeoController extends Controller
{
    public function robots(): Response
    {
        $content = Setting::get('robots_txt', "User-agent: *\nAllow: /\n", 'analytics');

        return response($content, 200)->header('Content-Type', 'text/plain');
    }

    public function sitemap(): Response
    {
        if ((string) Setting::get('sitemap_enabled', '1', 'seo') === '0') {
            return response('Sitemap disabled.', 404)->header('Content-Type', 'text/plain');
        }

        $changefreq = e(Setting::get('sitemap_changefreq', 'weekly', 'seo') ?: 'weekly');

        $xml = Cache::remember('sitemap.xml', 3600, function () use ($changefreq) {
            $urls = collect();

            $urls->push(['loc' => url('/'), 'priority' => '1.0']);

            Page::query()->active()->with('seo')->orderBy('sort_order')->get()->each(function (Page $page) use ($urls) {
                if ($page->seo && $page->seo->indexable === false) {
                    return;
                }
                $urls->push([
                    'loc' => url('/'.$page->slug),
                    'lastmod' => optional($page->updated_at)->toAtomString(),
                    'priority' => '0.8',
                ]);
            });

            Service::query()->active()->with('seo')->orderBy('sort_order')->get()->each(function (Service $service) use ($urls) {
                if ($service->seo && $service->seo->indexable === false) {
                    return;
                }
                $urls->push([
                    'loc' => url('/capabilities/'.$service->slug),
                    'lastmod' => optional($service->updated_at)->toAtomString(),
                    'priority' => '0.7',
                ]);
            });

            Industry::query()->active()->with('seo')->orderBy('sort_order')->get()->each(function (Industry $industry) use ($urls) {
                if ($industry->seo && $industry->seo->indexable === false) {
                    return;
                }
                $urls->push([
                    'loc' => url('/industries/'.$industry->slug),
                    'lastmod' => optional($industry->updated_at)->toAtomString(),
                    'priority' => '0.7',
                ]);
            });

            $urls->push(['loc' => url('/contact'), 'priority' => '0.6']);
            $urls->push(['loc' => url('/quality-compliance'), 'priority' => '0.6']);
            $urls->push(['loc' => url('/specimen-library-preservation'), 'priority' => '0.6']);
            $urls->push(['loc' => url('/capabilities'), 'priority' => '0.7']);
            $urls->push(['loc' => url('/industries'), 'priority' => '0.7']);
            $urls->push(['loc' => url('/blog'), 'priority' => '0.7']);

            Article::query()->active()->published()->with('seo')->orderByDesc('published_at')->get()->each(function (Article $article) use ($urls) {
                if ($article->seo && $article->seo->indexable === false) {
                    return;
                }
                $urls->push([
                    'loc' => url('/blog/'.$article->slug),
                    'lastmod' => optional($article->updated_at)->toAtomString(),
                    'priority' => '0.6',
                ]);
            });

            $body = $urls->unique('loc')->map(function (array $item) use ($changefreq) {
                $lastmod = isset($item['lastmod']) ? '<lastmod>'.$item['lastmod'].'</lastmod>' : '';

                return '<url><loc>'.e($item['loc']).'</loc>'.$lastmod.'<changefreq>'.$changefreq.'</changefreq><priority>'.$item['priority'].'</priority></url>';
            })->implode('');

            return '<?xml version="1.0" encoding="UTF-8"?>'
                .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
                .$body
                .'</urlset>';
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function htmlSitemap(): View
    {
        $pages = Page::query()->active()->with('seo')->orderBy('sort_order')->get()
            ->filter(fn (Page $page) => ! ($page->seo && $page->seo->indexable === false));
        $services = Service::query()->active()->with('seo')->orderBy('sort_order')->get()
            ->filter(fn (Service $service) => ! ($service->seo && $service->seo->indexable === false));
        $industries = Industry::query()->active()->with('seo')->orderBy('sort_order')->get()
            ->filter(fn (Industry $industry) => ! ($industry->seo && $industry->seo->indexable === false));
        $articles = Article::query()->active()->published()->with('seo')->orderByDesc('published_at')->get()
            ->filter(fn (Article $article) => ! ($article->seo && $article->seo->indexable === false));

        return view('front.sitemap', compact('pages', 'services', 'industries', 'articles'));
    }
}
