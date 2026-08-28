<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ContactPage;
use App\Models\Faq;
use App\Models\Industry;
use App\Models\Page;
use App\Models\Service;
use App\Models\Setting;
use App\Support\SeoHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SeoHeadService
{
    /**
     * Resolve SEO meta for the current public request.
     *
     * @return array<string, mixed>
     */
    public function resolve(Request $request, ?string $fallbackTitle = null, ?string $slug = null): array
    {
        $defaults = SeoHelper::defaults();
        $path = '/'.ltrim($request->path(), '/');
        if ($path === '//') {
            $path = '/';
        }

        $model = $this->resolveModel($path, $slug);
        $seo = $model && method_exists($model, 'seo') ? $model->seo : null;

        $siteName = Setting::get('site_name', config('app.name'), 'general');
        $metaTitle = $seo?->browser_title
            ?: $seo?->meta_title
            ?: $seo?->seo_title
            ?: ($defaults['meta_title'] ?? $siteName);

        if ($fallbackTitle && ! $seo?->browser_title && ! $seo?->meta_title && ! $seo?->seo_title) {
            $metaTitle = $fallbackTitle.' | '.$siteName;
        }

        $metaDescription = $seo?->meta_description ?: ($defaults['meta_description'] ?? '');
        $metaKeywords = $seo?->meta_keywords ?: ($defaults['meta_keywords'] ?? '');
        $canonical = $seo?->canonical_url ?: url()->current();
        $canonical = \App\Support\SeoHelper::normalizePublicUrl((string) $canonical);
        $ogTitle = $seo?->og_title ?: ($defaults['og_title'] ?? $metaTitle);
        $ogDescription = $seo?->og_description ?: ($defaults['og_description'] ?? $metaDescription);
        $ogImage = $seo?->og_image ?: ($defaults['og_image'] ?? null);
        $twitterTitle = $seo?->twitter_title ?: ($defaults['twitter_title'] ?? $ogTitle);
        $twitterDescription = $seo?->twitter_description ?: ($defaults['twitter_description'] ?? $ogDescription);
        $twitterImage = $seo?->twitter_image ?: ($defaults['twitter_image'] ?? $ogImage);
        $twitterCard = $seo?->twitter_card ?: ($defaults['twitter_card'] ?? 'summary_large_image');

        $robots = $seo?->robots_meta;
        if (! $robots) {
            $index = ($seo?->indexable ?? true) ? 'index' : 'noindex';
            $follow = ($seo?->followable ?? true) ? 'follow' : 'nofollow';
            $robots = "{$index}, {$follow}";
        }

        $schemaBlocks = [];
        if (! empty($seo?->schema_json)) {
            $schemaBlocks[] = $seo->schema_json;
        } else {
            $auto = $this->autoSchema($model, $path, $metaTitle, $metaDescription);
            if ($auto) {
                $schemaBlocks[] = json_encode($auto, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        }

        $org = SeoHelper::organizationSchema();
        $schemaBlocks[] = json_encode($org, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return [
            'title' => $metaTitle,
            'description' => $metaDescription,
            'keywords' => $metaKeywords,
            'canonical' => $canonical,
            'robots' => $robots,
            'h1' => $seo?->h1_title,
            'author' => $seo?->author,
            'og_title' => $ogTitle,
            'og_description' => $ogDescription,
            'og_image' => $ogImage ? storage_url($ogImage) : null,
            'twitter_title' => $twitterTitle,
            'twitter_description' => $twitterDescription,
            'twitter_image' => $twitterImage ? storage_url($twitterImage) : null,
            'twitter_card' => $twitterCard,
            'schema' => $schemaBlocks,
            'head_scripts' => $this->headScripts(),
            'footer_scripts' => Setting::get('custom_footer_scripts', '', 'scripts') ?: '',
            'verification' => [
                'google' => Setting::get('google_search_console', '', 'analytics'),
                'bing' => Setting::get('bing_verification', '', 'analytics'),
            ],
        ];
    }

    /**
     * Inject SEO tags into a static theme HTML document.
     *
     * @param  array<string, mixed>  $seo
     */
    public function inject(string $html, array $seo): string
    {
        $tags = [];

        if (! empty($seo['title'])) {
            $html = preg_replace('/<title>.*?<\/title>/is', '<title>'.e($seo['title']).'</title>', $html, 1) ?? $html;
        }

        $tags[] = '<meta name="description" content="'.e($seo['description'] ?? '').'">';
        if (! empty($seo['keywords'])) {
            $tags[] = '<meta name="keywords" content="'.e($seo['keywords']).'">';
        }
        $tags[] = '<meta name="robots" content="'.e($seo['robots'] ?? 'index, follow').'">';
        if (! empty($seo['canonical'])) {
            $tags[] = '<link rel="canonical" href="'.e($seo['canonical']).'">';
        }
        if (! empty($seo['author'])) {
            $tags[] = '<meta name="author" content="'.e($seo['author']).'">';
        }

        $tags[] = '<meta property="og:title" content="'.e($seo['og_title'] ?? '').'">';
        $tags[] = '<meta property="og:description" content="'.e($seo['og_description'] ?? '').'">';
        $tags[] = '<meta property="og:type" content="website">';
        $tags[] = '<meta property="og:url" content="'.e($seo['canonical'] ?? url()->current()).'">';
        if (! empty($seo['og_image'])) {
            $tags[] = '<meta property="og:image" content="'.e($seo['og_image']).'">';
        }

        $tags[] = '<meta name="twitter:card" content="'.e($seo['twitter_card'] ?? 'summary_large_image').'">';
        $tags[] = '<meta name="twitter:title" content="'.e($seo['twitter_title'] ?? '').'">';
        $tags[] = '<meta name="twitter:description" content="'.e($seo['twitter_description'] ?? '').'">';
        if (! empty($seo['twitter_image'])) {
            $tags[] = '<meta name="twitter:image" content="'.e($seo['twitter_image']).'">';
        }

        if (! empty($seo['verification']['google'])) {
            $tags[] = '<meta name="google-site-verification" content="'.e($seo['verification']['google']).'">';
        }
        if (! empty($seo['verification']['bing'])) {
            $tags[] = '<meta name="msvalidate.01" content="'.e($seo['verification']['bing']).'">';
        }

        foreach ($seo['schema'] ?? [] as $block) {
            if (is_string($block) && trim($block) !== '') {
                $tags[] = '<script type="application/ld+json">'.$block.'</script>';
            }
        }

        if (! empty($seo['head_scripts'])) {
            $tags[] = $seo['head_scripts'];
        }

        $injection = "\n".implode("\n", $tags)."\n";

        if (Str::contains($html, '</head>')) {
            $html = str_replace('</head>', $injection.'</head>', $html);
        }

        if (! empty($seo['footer_scripts']) && Str::contains($html, '</body>')) {
            $html = str_replace('</body>', "\n".$seo['footer_scripts']."\n</body>", $html);
        }

        return $html;
    }

    protected function resolveModel(string $path, ?string $slug = null): ?Model
    {
        if ($path === '/' || $path === '') {
            return Page::query()->active()->where('slug', 'home')->with('seo')->first()
                ?: Page::query()->active()->ofType(Page::TYPE_CUSTOM)->where('slug', 'home')->with('seo')->first();
        }

        if ($path === '/contact') {
            return ContactPage::query()->with('seo')->first() ?: ContactPage::current();
        }

        if ($path === '/about') {
            return Page::query()->active()->ofType(Page::TYPE_ABOUT)->with('seo')->first();
        }

        if ($path === '/quality-compliance') {
            return Page::query()->active()->ofType(Page::TYPE_QUALITY_COMPLIANCE)->with('seo')->first();
        }

        if ($path === '/specimen-library-preservation') {
            return Page::query()->active()->ofType(Page::TYPE_SPECIMEN_LIBRARY)->with('seo')->first();
        }

        if ($path === '/partnerships') {
            return Page::query()->active()->ofType(Page::TYPE_PARTNERSHIPS)->with('seo')->first();
        }

        if ($path === '/privacy-policy') {
            return Page::query()->active()->ofType(Page::TYPE_PRIVACY)->with('seo')->first();
        }

        if (preg_match('#^/(?:capabilities|services)/([^/]+)$#', $path, $m)) {
            return Service::query()->active()->where('slug', $slug ?: $m[1])->with('seo')->first();
        }

        if (preg_match('#^/industries/([^/]+)$#', $path, $m)) {
            return Industry::query()->active()->where('slug', $slug ?: $m[1])->with('seo')->first();
        }

        if (preg_match('#^/(?:blog|articles)/([^/]+)$#', $path, $m)) {
            return Article::query()->active()->published()->where('slug', $slug ?: $m[1])->with('seo')->first();
        }

        if ($path === '/capabilities' || $path === '/services' || $path === '/industries') {
            return Page::query()->active()->where('slug', ltrim(str_replace('/services', '/capabilities', $path), '/'))->with('seo')->first();
        }

        $pageSlug = trim($path, '/');

        return Page::query()->active()->where('slug', $pageSlug)->with('seo')->first();
    }

    protected function autoSchema(?Model $model, string $path, string $title, string $description): ?array
    {
        if ($model instanceof Service) {
            return [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $model->title ?? $title,
                'description' => strip_tags((string) ($model->short_description ?? $description)),
                'provider' => ['@type' => 'Organization', 'name' => Setting::get('site_name', 'LyoVial', 'general')],
                'url' => url()->current(),
            ];
        }

        if ($model instanceof Article) {
            return [
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => $model->title ?? $title,
                'description' => strip_tags((string) ($model->excerpt ?? $description)),
                'datePublished' => optional($model->published_at)->toAtomString(),
                'author' => [
                    '@type' => 'Person',
                    'name' => $model->author_name ?: Setting::get('site_name', 'LyoVial', 'general'),
                ],
                'url' => url('/blog/'.$model->slug),
            ];
        }

        if ($path === '/contact' || $model instanceof ContactPage) {
            return [
                '@context' => 'https://schema.org',
                '@type' => 'ContactPage',
                'name' => $title,
                'url' => url('/contact'),
            ];
        }

        if ($path === '/' || $path === '') {
            $faqs = Faq::query()->active()->forSection('home')->orderBy('sort_order')->limit(20)->get();
            if ($faqs->isNotEmpty()) {
                return [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => $faqs->map(fn (Faq $faq) => [
                        '@type' => 'Question',
                        'name' => $faq->question,
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => strip_tags((string) $faq->answer),
                        ],
                    ])->values()->all(),
                ];
            }
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $title,
            'description' => $description,
            'url' => url()->current(),
        ];
    }

    protected function headScripts(): string
    {
        return Cache::remember('seo.head_scripts', 600, function () {
            $parts = [];

            $ga = Setting::get('google_analytics', '', 'analytics');
            $gtm = Setting::get('google_tag_manager', '', 'analytics');
            $pixel = Setting::get('meta_pixel', '', 'analytics');
            $linkedin = Setting::get('linkedin_insight_tag', '', 'analytics');
            $custom = Setting::get('custom_head_scripts', '', 'scripts');

            if ($ga) {
                $parts[] = $ga;
            }
            if ($gtm) {
                $parts[] = $gtm;
            }
            if ($pixel) {
                $parts[] = $pixel;
            }
            if ($linkedin) {
                $parts[] = $linkedin;
            }
            if ($custom) {
                $parts[] = $custom;
            }

            return implode("\n", $parts);
        });
    }
}
