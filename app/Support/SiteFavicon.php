<?php

namespace App\Support;

use App\Models\Setting;

class SiteFavicon
{
    /** Basenames that are full wordmarks — never use as tab icons. */
    private const WORDMARK_NAMES = [
        'logo.png',
        'lyovial-logo.png',
        'logo-white.png',
        'logo-white.webp',
    ];

    /**
     * @return array{href:string,type:string,png32:string,png16:string,apple:string}
     */
    public static function resolve(): array
    {
        $candidates = array_filter([
            '/images/site/favicon-icon.svg',
            '/images/site/favicon-icon.png',
            self::cmsFaviconCandidate(),
            '/theme/assets/images/lyovial/favicon-icon.svg',
            '/favicon-32x32.png',
            '/favicon.png',
        ]);

        $primary = null;
        $diskPath = null;

        foreach ($candidates as $candidate) {
            $full = self::publicPath($candidate);
            if ($full && is_file($full) && filesize($full) > 200) {
                $relative = parse_url($candidate, PHP_URL_PATH) ?: $candidate;
                $primary = asset(ltrim($relative, '/'));
                $diskPath = $full;
                break;
            }
        }

        if (! $primary) {
            $primary = asset('images/site/favicon-icon.svg');
            $diskPath = public_path('images/site/favicon-icon.svg');
        }

        $ext = strtolower(pathinfo(parse_url($primary, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));
        $type = match ($ext) {
            'svg' => 'image/svg+xml',
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'webp' => 'image/webp',
            'ico' => 'image/x-icon',
            default => 'image/png',
        };

        $version = ($diskPath && is_file($diskPath)) ? filemtime($diskPath) : time();
        $href = $primary.(str_contains($primary, '?') ? '&' : '?').'v='.$version;

        $png32Path = public_path('favicon-32x32.png');
        $png16Path = public_path('favicon-16x16.png');
        $applePath = public_path('apple-touch-icon.png');

        $png32 = is_file($png32Path)
            ? asset('favicon-32x32.png').'?v='.filemtime($png32Path)
            : $href;
        $png16 = is_file($png16Path)
            ? asset('favicon-16x16.png').'?v='.filemtime($png16Path)
            : $png32;
        $apple = is_file($applePath)
            ? asset('apple-touch-icon.png').'?v='.filemtime($applePath)
            : $png32;

        return compact('href', 'type', 'png32', 'png16', 'apple');
    }

    public static function icoPublicPath(): ?string
    {
        foreach (['favicon-32x32.png', 'images/site/favicon-icon.png', 'favicon.png'] as $relative) {
            $full = public_path($relative);
            if (is_file($full)) {
                return $full;
            }
        }

        return null;
    }

    private static function cmsFaviconCandidate(): ?string
    {
        $cmsFavicon = Setting::get('favicon', null, 'general');
        if (! $cmsFavicon || self::isWordmark($cmsFavicon)) {
            return null;
        }

        return $cmsFavicon;
    }

    private static function isWordmark(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        $base = strtolower(basename(parse_url($path, PHP_URL_PATH) ?: $path));

        return in_array($base, self::WORDMARK_NAMES, true);
    }

    private static function publicPath(string $candidate): ?string
    {
        $url = storage_url($candidate) ?: $candidate;
        if (! $url) {
            return null;
        }

        $relative = parse_url($url, PHP_URL_PATH) ?: $url;
        if (str_starts_with($relative, '/storage/')) {
            return public_path('storage/'.ltrim(substr($relative, 9), '/'));
        }

        return public_path(ltrim($relative, '/'));
    }
}
