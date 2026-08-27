<?php

namespace App\Support;

class SiteImages
{
    /** Real images live under /public/images/site (copied from public assets). */
    public const BASE = '/images/site';

    public static function url(string $name): string
    {
        return self::preferWebp(self::BASE.'/'.ltrim($name, '/'));
    }

    /**
     * Serve a WebP sibling when it exists (homepage / theme photos).
     */
    public static function preferWebp(string $path): string
    {
        if (! filled($path) || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $relative = ltrim(str_replace('\\', '/', parse_url($path, PHP_URL_PATH) ?: $path), '/');
        if (! preg_match('/\.(jpe?g|png)$/i', $relative)) {
            return $path;
        }

        $webpRelative = preg_replace('/\.(jpe?g|png)$/i', '.webp', $relative);
        if ($webpRelative && is_file(public_path($webpRelative))) {
            return '/'.$webpRelative;
        }

        return $path;
    }

    /** @return array{0:?int,1:?int} */
    public static function dimensions(string $path): array
    {
        $relative = ltrim(str_replace('\\', '/', parse_url($path, PHP_URL_PATH) ?: $path), '/');
        $full = public_path($relative);
        if (! is_file($full)) {
            return [null, null];
        }
        $info = @getimagesize($full);

        return $info ? [(int) $info[0], (int) $info[1]] : [null, null];
    }

    /**
     * Prefer an uploaded CMS path only when the file exists and is a real image
     * (demo stubs are ~700 bytes and look blank). Otherwise use $fallback.
     */
    public static function resolve(?string $uploaded, string $fallback): string
    {
        if (! filled($uploaded)) {
            return $fallback;
        }

        $path = str_replace('\\', '/', trim($uploaded));

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            if (str_contains($path, 'images.unsplash.com')) {
                return $fallback;
            }

            return $path;
        }

        $relative = ltrim($path, '/');
        if (str_starts_with($relative, 'storage/')) {
            $relative = substr($relative, strlen('storage/'));
        }

        $candidates = [];
        if (str_starts_with($path, '/')) {
            $candidates[] = public_path(ltrim($path, '/'));
        }
        $candidates[] = public_path('storage/'.$relative);
        $candidates[] = storage_path('app/public/'.$relative);
        $candidates[] = public_path($relative);

        foreach ($candidates as $full) {
            if (is_file($full) && filesize($full) > 5000) {
                if (str_starts_with($path, '/')) {
                    return self::preferWebp($path);
                }

                return self::preferWebp('/storage/'.$relative);
            }
        }

        return $fallback;
    }

    public static function map(): array
    {
        return [
            'home_hero' => self::url('hero.png'),
            'home_about' => self::url('about.jpg'),
            'home_why' => self::url('why-lg.jpg'),
            'home_why_sm' => self::url('why-sm.jpg'),
            'home_partner' => self::url('partner.jpg'),
            'home_process' => self::url('process.jpg'),
            'home_facility' => self::url('facility-ottawa.jpg'),
            'home_kanata' => self::url('kanata-park.jpg'),

            'banner_default' => self::url('banner-ab.jpg'),
            'banner_about' => self::url('about.jpg'),
            'banner_contact' => self::url('hero.png'),
            'banner_industries' => self::url('ind-1.jpg'),
            'banner_articles' => self::url('process.jpg'),
            'banner_quality' => self::url('why-lg.jpg'),
            'banner_specimen' => self::url('process.jpg'),
            'banner_capabilities' => self::url('svc-1.jpg'),

            'svc_formulation_banner' => self::url('svc-1.jpg'),
            'svc_formulation_feature' => self::url('why-lg.jpg'),
            'svc_pilot_banner' => self::url('svc-2.jpg'),
            'svc_pilot_feature' => self::url('facility-ottawa.jpg'),
            'svc_scaleup_banner' => self::url('svc-3.jpg'),
            'svc_scaleup_feature' => self::url('process.jpg'),

            'ind_1' => self::url('ind-1.jpg'),
            'ind_2' => self::url('ind-2.jpg'),
            'ind_3' => self::url('ind-3.jpg'),
            'ind_4' => self::url('ind-4.jpg'),
            'ind_5' => self::url('ind-5.jpg'),
            'ind_6' => self::url('ind-6.jpg'),
        ];
    }

    public static function get(string $key): string
    {
        return self::map()[$key] ?? self::url('banner-ab.jpg');
    }

    public static function serviceBanner(string $slug): string
    {
        return match ($slug) {
            'formulation-lyo-cycle-development' => self::get('svc_formulation_banner'),
            'pilot-batch-vial-lyophilization' => self::get('svc_pilot_banner'),
            'scale-up-technology-transfer' => self::get('svc_scaleup_banner'),
            default => self::get('banner_capabilities'),
        };
    }

    public static function serviceFeature(string $slug): string
    {
        return match ($slug) {
            'formulation-lyo-cycle-development' => self::get('svc_formulation_feature'),
            'pilot-batch-vial-lyophilization' => self::get('svc_pilot_feature'),
            'scale-up-technology-transfer' => self::get('svc_scaleup_feature'),
            default => self::get('svc_formulation_feature'),
        };
    }

    public static function industryImage(int $index = 0): string
    {
        $n = ($index % 6) + 1;

        return self::url("ind-{$n}.jpg");
    }
}
