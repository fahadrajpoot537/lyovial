<?php

namespace App\View\Composers;

use App\Models\Article;
use App\Models\Industry;
use App\Models\Menu;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\View\View;

class FrontLayoutComposer
{
    public function compose(View $view): void
    {
        $view->with([
            'siteName' => Setting::get('site_name', 'LyoVial', 'general'),
            'sitePhone' => Setting::get('phone', '', 'general'),
            'siteEmail' => Setting::get('email', '', 'general'),
            'siteAddress' => Setting::get('address', '', 'general'),
            'siteLogo' => Setting::get('logo', null, 'general'),
            'siteCopyright' => Setting::get('copyright', '', 'general'),
            'social' => Setting::group('social'),
            'defaultSeo' => Setting::group('seo'),
            'headerMenus' => Menu::tree('header'),
            'footerMenus' => Menu::tree('footer'),
            'navServices' => Service::query()->active()->orderBy('sort_order')->get(['id', 'title', 'slug']),
            'navIndustries' => Industry::query()->active()->orderBy('sort_order')->get(['id', 'title', 'slug', 'extra']),
            'navArticles' => Article::query()->active()->published()->orderBy('sort_order')->orderByDesc('published_at')->take(6)->get(['id', 'title', 'slug']),
        ]);
    }
}
