<?php

namespace App\Support;

use App\Models\Article;
use App\Models\ContactPage;
use App\Models\HomeSection;
use App\Models\Industry;
use App\Models\Page;
use App\Models\SeoRedirect;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SeoPageDefaults
{
    public const GENERIC_TITLE = 'LyoVial | Pilot-Scale Vial Lyophilization in Canada';

    public const LIPOSOMAL_SLUG = 'freeze-drying-of-liposomal-particles';

    /**
     * Unique title/description for a public path.
     *
     * @return array{title:string,description:string}|null
     */
    public static function forPath(?string $path = null): ?array
    {
        $path = self::normalize($path ?? request()->path());

        $pages = self::staticPages();
        if (isset($pages[$path])) {
            return $pages[$path];
        }

        if (preg_match('#^/industries/([^/]+)$#', $path, $m)) {
            $industry = Industry::query()->where('slug', $m[1])->first();
            if ($industry) {
                return [
                    'title' => self::fitTitle($industry->title ?: 'Industry'),
                    'description' => self::clip($industry->short_description ?: $industry->heading ?: $industry->title, 150),
                ];
            }
        }

        if (preg_match('#^/capabilities/([^/]+)$#', $path, $m)) {
            $service = Service::query()->where('slug', $m[1])->first();
            if ($service) {
                return [
                    'title' => self::fitTitle($service->title ?: 'Capability'),
                    'description' => self::clip($service->short_description ?: $service->page_heading ?: $service->title, 150),
                ];
            }
        }

        if (preg_match('#^/blog/([^/]+)$#', $path, $m)) {
            $article = Article::query()->where('slug', $m[1])->first();
            if ($article) {
                return [
                    'title' => self::fitTitle($article->title ?: 'Article'),
                    'description' => self::clip($article->excerpt ?: $article->title, 150),
                ];
            }
        }

        return null;
    }

    /**
     * @return array<string, array{title:string, description:string}>
     */
    public static function staticPages(): array
    {
        $homeDescription = (string) Setting::get(
            'default_meta_description',
            'LyoVial provides formulation support, lyo cycle development, scale-up, technology transfer, and pilot-batch vial lyophilization from Kanata, Ontario.',
            'seo'
        );

        $liposomal = [
            'title' => 'Freeze-Drying of Liposomal Particles | LyoVial',
            'description' => 'How to freeze-dry liposomes without losing structure or stability — cryoprotectants, cake formation, and reconstitution tips from LyoVial.',
        ];

        return [
            '/' => [
                'title' => self::GENERIC_TITLE,
                'description' => $homeDescription,
            ],
            '/industries' => [
                'title' => 'Industries We Serve | LyoVial Canada',
                'description' => 'Contract lyophilization for diagnostics, biotech, QC controls, microbiology, labs, R&D and cosmetics — the industries LyoVial serves across Canada.',
            ],
            '/partnerships' => [
                'title' => 'Partner With LyoVial | Lyophilization Canada',
                'description' => 'Partner with LyoVial for pilot-scale vial freeze-drying. Reliable contract lyophilization capacity for labs and manufacturers across Canada.',
            ],
            '/capabilities' => [
                'title' => 'Lyophilization Capabilities | LyoVial Canada',
                'description' => 'Formulation, lyo cycle development, scale-up, and pilot-batch vial freeze-drying. Explore LyoVial\'s contract lyophilization capabilities in Canada.',
            ],
            '/blog' => [
                'title' => 'Lyophilization Blog & Case Notes | LyoVial',
                'description' => 'Freeze-drying insights, cycle development tips, and case notes from LyoVial\'s lyophilization specialists. Read the latest on the blog.',
            ],
            '/blog/'.self::LIPOSOMAL_SLUG => $liposomal,
            '/blog/'.self::LIPOSOMAL_SLUG.'-2' => $liposomal,
            '/contact' => [
                'title' => 'Contact LyoVial | Kanata, Ontario',
                'description' => 'Contact LyoVial at (613) 614-8733 or vlad@evik.ca. Visit 105 Schneider Road, Unit 123, Kanata for lyophilization project support.',
            ],
            '/quality-compliance' => [
                'title' => 'Quality & Compliance | LyoVial Canada',
                'description' => 'Quality-minded documentation, batch accountability, and transfer-ready process controls for LyoVial lyophilization projects in Canada.',
            ],
            '/about' => [
                'title' => 'About LyoVial | Freeze Drying Ottawa',
                'description' => 'LyoVial is a lyophilization specialist in Kanata North, Ottawa — formulation, cycle development, and pilot-scale vial freeze-drying.',
            ],
            '/privacy-policy' => [
                'title' => 'Privacy Policy | LyoVial Canada',
                'description' => 'How LyoVial collects, uses, stores, and protects personal information submitted through lyovial.com and related project inquiries.',
            ],
            '/specimen-library-preservation' => [
                'title' => 'Specimen Library Preservation | LyoVial',
                'description' => 'Move specimen libraries off the freezer with LyoVial lyophilization development and pilot vial production from Kanata, Ontario.',
            ],
        ];
    }

    public static function normalize(?string $path): string
    {
        $path = trim((string) $path);
        $parsed = parse_url($path, PHP_URL_PATH);
        if (is_string($parsed) && $parsed !== '') {
            $path = $parsed;
        }

        $path = '/'.ltrim($path, '/');
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        $path = preg_replace('#^/services$#', '/capabilities', $path) ?? $path;
        $path = preg_replace('#^/services/#', '/capabilities/', $path) ?? $path;
        $path = preg_replace('#^/articles$#', '/blog', $path) ?? $path;
        $path = preg_replace('#^/articles/#', '/blog/', $path) ?? $path;

        return $path === '' ? '/' : $path;
    }

    public static function isGenericTitle(?string $title): bool
    {
        $title = trim((string) $title);
        if ($title === '') {
            return true;
        }

        $generics = array_unique(array_filter([
            self::GENERIC_TITLE,
            (string) Setting::get('default_meta_title', '', 'seo'),
        ]));

        foreach ($generics as $generic) {
            if (strcasecmp($title, trim($generic)) === 0) {
                return true;
            }
        }

        return false;
    }

    public static function isGenericDescription(?string $description): bool
    {
        $description = trim((string) $description);
        if ($description === '') {
            return true;
        }

        $generic = trim((string) Setting::get('default_meta_description', '', 'seo'));

        return $generic !== '' && strcasecmp($description, $generic) === 0;
    }

    public static function fitTitle(string $name, string $brand = 'LyoVial', int $max = 50): string
    {
        $name = trim(preg_replace('/\s+/u', ' ', $name) ?? $name);
        $suffix = ' | '.$brand;
        if ($name === '') {
            return mb_substr($brand, 0, $max);
        }
        if (Str::endsWith(mb_strtolower($name), mb_strtolower($suffix))) {
            return mb_strlen($name) <= $max ? $name : self::fitTitle(mb_substr($name, 0, mb_strlen($name) - mb_strlen($suffix)), $brand, $max);
        }

        $budget = $max - mb_strlen($suffix);
        if ($budget < 8) {
            return mb_substr($name, 0, $max);
        }
        if (mb_strlen($name) <= $budget) {
            return $name.$suffix;
        }

        $cut = rtrim((string) preg_replace('/\s+\S*$/u', '', mb_substr($name, 0, $budget))) ?: mb_substr($name, 0, $budget);

        return rtrim($cut, ' -|').$suffix;
    }

    public static function clip(string $text, int $max = 150): string
    {
        $text = trim((string) preg_replace('/\s+/u', ' ', strip_tags($text)));
        if ($text === '' || mb_strlen($text) <= $max) {
            return $text;
        }

        $cut = rtrim((string) preg_replace('/\s+\S*$/u', '', mb_substr($text, 0, $max))) ?: mb_substr($text, 0, $max);

        return rtrim($cut, ' .,;:-');
    }

    /**
     * Reclaim the canonical liposomal slug and 301 the -2 URL.
     */
    public static function fixLiposomalSlug(): ?string
    {
        $canonical = self::LIPOSOMAL_SLUG;
        $stale = $canonical.'-2';

        $canonicalLive = Article::query()->where('slug', $canonical)->first();
        $staleLive = Article::query()->where('slug', $stale)->first();

        if ($canonicalLive && $staleLive && $canonicalLive->id !== $staleLive->id) {
            self::ensureRedirect('/blog/'.$stale, '/blog/'.$canonical);

            return $canonical;
        }

        if ($staleLive && ! $canonicalLive) {
            $staleLive->slug = Article::uniqueSlug($canonical, $staleLive->id);
            $staleLive->save();
            self::ensureRedirect('/blog/'.$stale, '/blog/'.$staleLive->slug);

            return $staleLive->slug;
        }

        self::ensureRedirect('/blog/'.$stale, '/blog/'.$canonical);

        return $canonicalLive?->slug;
    }

    /**
     * Write unique titles into CMS rows. Specified listing/article pages are forced;
     * other public records are filled only when the stored title/description is empty or generic.
     */
    public static function persistFrontUniques(): void
    {
        $forced = [
            [HomeSection::byKey('industries'), '/industries'],
            [HomeSection::byKey('services'), '/capabilities'],
            [HomeSection::byKey('articles'), '/blog'],
            [Page::query()->ofType(Page::TYPE_PARTNERSHIPS)->first(), '/partnerships'],
        ];

        foreach ($forced as [$model, $path]) {
            $meta = self::forPath($path);
            if ($meta) {
                self::applyTo($model, $meta, true, $path);
            }
        }

        $liposomal = Article::query()
            ->whereIn('slug', [self::LIPOSOMAL_SLUG, self::LIPOSOMAL_SLUG.'-2'])
            ->first();
        if ($liposomal) {
            self::applyTo($liposomal, self::forPath('/blog/'.$liposomal->slug), true, '/blog/'.$liposomal->slug);
        }

        $optional = [
            [ContactPage::query()->first(), '/contact'],
            [Page::query()->ofType(Page::TYPE_QUALITY_COMPLIANCE)->first(), '/quality-compliance'],
            [Page::query()->ofType(Page::TYPE_ABOUT)->first(), '/about'],
            [Page::query()->ofType(Page::TYPE_PRIVACY)->first(), '/privacy-policy'],
            [Page::query()->ofType(Page::TYPE_SPECIMEN_LIBRARY)->first(), '/specimen-library-preservation'],
        ];

        foreach ($optional as [$model, $path]) {
            $meta = self::forPath($path);
            if ($meta) {
                self::applyTo($model, $meta, false, $path);
            }
        }

        Industry::query()->with('seo')->get()->each(function (Industry $industry): void {
            $path = '/industries/'.$industry->slug;
            $meta = self::forPath($path);
            if ($meta) {
                self::applyTo($industry, $meta, false, $path);
            }
        });

        Service::query()->with('seo')->get()->each(function (Service $service): void {
            $path = '/capabilities/'.$service->slug;
            $meta = self::forPath($path);
            if ($meta) {
                self::applyTo($service, $meta, false, $path);
            }
        });

        Article::query()->with('seo')->whereNull('deleted_at')->get()->each(function (Article $article): void {
            if (in_array($article->slug, [self::LIPOSOMAL_SLUG, self::LIPOSOMAL_SLUG.'-2'], true)) {
                return;
            }
            $path = '/blog/'.$article->slug;
            $meta = self::forPath($path);
            if ($meta) {
                self::applyTo($article, $meta, false, $path);
            }
        });
    }

    /**
     * @param  array{title:string, description:string}|null  $meta
     */
    public static function applyTo(?Model $model, ?array $meta, bool $force = false, ?string $path = null): void
    {
        if (! $model || ! $model->exists || ! $meta || ! method_exists($model, 'syncSeo')) {
            return;
        }

        $seo = $model->seo;
        $payload = [];

        $currentTitle = trim((string) ($seo?->meta_title ?: $seo?->seo_title ?: $seo?->browser_title ?: ''));
        if ($force || self::isGenericTitle($currentTitle)) {
            $payload['meta_title'] = $meta['title'];
            $payload['seo_title'] = $meta['title'];
            $payload['browser_title'] = $meta['title'];
            if ($force || self::isGenericTitle($seo?->og_title)) {
                $payload['og_title'] = $meta['title'];
            }
            if ($force || self::isGenericTitle($seo?->twitter_title)) {
                $payload['twitter_title'] = $meta['title'];
            }
        }

        $currentDesc = trim((string) ($seo?->meta_description ?: ''));
        if ($force || self::isGenericDescription($currentDesc)) {
            $payload['meta_description'] = $meta['description'];
            if ($force || self::isGenericDescription($seo?->og_description)) {
                $payload['og_description'] = $meta['description'];
            }
            if ($force || self::isGenericDescription($seo?->twitter_description)) {
                $payload['twitter_description'] = $meta['description'];
            }
        }

        if ($path) {
            $canonical = trim((string) ($seo?->canonical_url ?: ''));
            if ($force || $canonical === '') {
                $payload['canonical_url'] = url($path);
            }
            if ($force || trim((string) ($seo?->slug ?: '')) === '') {
                $payload['slug'] = trim($path, '/');
            }
        }

        if ($payload === []) {
            return;
        }

        $model->syncSeo($payload);
    }

    protected static function ensureRedirect(string $from, string $to): void
    {
        SeoRedirect::query()->updateOrCreate(
            ['from_path' => SeoRedirect::normalizePath($from)],
            [
                'to_url' => SeoRedirect::normalizePath($to),
                'status_code' => 301,
                'is_active' => true,
                'notes' => 'Canonical liposomal freeze-drying article; avoid duplicate URLs',
            ]
        );
    }
}
