<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Support\ThemePageDefaults;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        $extra = ThemePageDefaults::aboutExtra();

        $page = Page::query()->updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About Us',
                'type' => Page::TYPE_ABOUT,
                'heading' => 'A lyophilization specialist, not a generalist CDMO',
                'content' => '',
                'extra' => $extra,
                'status' => true,
                'sort_order' => 5,
            ]
        );

        $page->syncSeo([
            'seo_title' => 'About LyoVial | Pilot-Scale Freeze Drying in Ottawa',
            'meta_title' => 'About LyoVial | A lyophilization specialist, not a generalist CDMO',
            'meta_description' => 'LyoVial is part of the Evik Diagnostics group. Pilot-scale glass-vial freeze drying in Kanata North, Ottawa — cycle development, formulation, and early supply.',
            'meta_keywords' => 'about LyoVial, freeze drying Ottawa, lyophilization specialist, Evik Diagnostics, Kanata North',
            'canonical_url' => url('/about'),
            'slug' => 'about',
            'focus_keyword' => 'about LyoVial',
            'og_title' => 'About LyoVial',
            'og_description' => 'A lyophilization specialist, not a generalist CDMO. Pilot-scale freeze drying in Kanata North, Ottawa.',
            'og_image' => $extra['hero_image'],
            'twitter_title' => 'About LyoVial',
            'twitter_description' => 'A lyophilization specialist, not a generalist CDMO.',
            'twitter_image' => $extra['hero_image'],
            'breadcrumb_title' => 'About Us',
            'robots_meta' => 'index, follow',
            'indexable' => true,
            'followable' => true,
            'schema_json' => json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'AboutPage',
                'name' => 'About LyoVial',
                'url' => url('/about'),
                'isPartOf' => ['@type' => 'WebSite', 'name' => 'LyoVial', 'url' => url('/')],
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        ]);
    }
}
