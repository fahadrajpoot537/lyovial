<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Support\ThemePageDefaults;
use Illuminate\Database\Seeder;

class PrivacyPolicySeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::query()->updateOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'title' => 'Privacy Policy',
                'type' => Page::TYPE_PRIVACY,
                'heading' => 'Privacy Policy',
                'content' => ThemePageDefaults::privacyContent(),
                'extra' => ThemePageDefaults::privacyExtra(),
                'status' => true,
                'sort_order' => 20,
            ]
        );

        $page->syncSeo([
            'seo_title' => 'Privacy Policy | LyoVial',
            'meta_title' => 'Privacy Policy | LyoVial',
            'meta_description' => 'Learn how LyoVial collects, uses, stores, and protects personal information submitted through lyovial.ca.',
            'meta_keywords' => 'privacy policy, personal information, LyoVial, lyovial.ca, PIPEDA',
            'canonical_url' => url('/privacy-policy'),
            'slug' => 'privacy-policy',
            'focus_keyword' => 'privacy policy',
            'og_title' => 'Privacy Policy | LyoVial',
            'og_description' => 'How LyoVial collects, uses, and protects personal information on lyovial.ca.',
            'twitter_title' => 'Privacy Policy | LyoVial',
            'twitter_description' => 'How LyoVial collects, uses, and protects personal information on lyovial.ca.',
            'breadcrumb_title' => 'Privacy Policy',
            'robots_meta' => 'index, follow',
            'indexable' => true,
            'followable' => true,
            'schema_json' => json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Privacy Policy',
                'url' => url('/privacy-policy'),
                'isPartOf' => ['@type' => 'WebSite', 'name' => 'LyoVial', 'url' => url('/')],
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        ]);
    }
}
