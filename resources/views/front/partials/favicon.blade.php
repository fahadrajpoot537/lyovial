@php
    $cmsFavicon = setting('favicon', null, 'general');
    $wordmarkNames = ['logo.png', 'lyovial-logo.png', 'logo-white.png'];
    $isWordmark = static function (?string $path) use ($wordmarkNames): bool {
        if (! $path) {
            return false;
        }
        $base = strtolower(basename(parse_url($path, PHP_URL_PATH) ?: $path));

        return in_array($base, $wordmarkNames, true);
    };

    $candidates = array_filter([
        '/images/site/favicon-icon.svg',
        '/images/site/favicon-icon.png',
        $isWordmark($cmsFavicon) ? null : $cmsFavicon,
        '/theme/assets/images/lyovial/favicon-icon.svg',
        '/favicon-32x32.png',
        '/favicon.png',
        '/apple-touch-icon.png',
    ]);

    $primary = null;
    $diskPath = null;
    foreach ($candidates as $candidate) {
        $url = storage_url($candidate) ?: $candidate;
        if (! $url) {
            continue;
        }
        $relative = parse_url($url, PHP_URL_PATH) ?: $url;
        if (str_starts_with($relative, '/storage/')) {
            $full = public_path('storage/'.ltrim(substr($relative, 9), '/'));
        } else {
            $full = public_path(ltrim($relative, '/'));
        }
        if (is_file($full) && filesize($full) > 200) {
            $primary = str_starts_with($url, 'http') ? $url : asset(ltrim($relative, '/'));
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
    $png32 = is_file(public_path('favicon-32x32.png')) ? asset('favicon-32x32.png').'?v='.filemtime(public_path('favicon-32x32.png')) : $primary;
    $apple = is_file(public_path('apple-touch-icon.png')) ? asset('apple-touch-icon.png').'?v='.filemtime(public_path('apple-touch-icon.png')) : $primary;
    $href = $primary.(str_contains($primary, '?') ? '&' : '?').'v='.$version;
@endphp
<link rel="icon" href="{{ $href }}" type="{{ $type }}">
<link rel="shortcut icon" href="{{ $href }}" type="{{ $type }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ $png32 }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ is_file(public_path('favicon-16x16.png')) ? asset('favicon-16x16.png').'?v='.filemtime(public_path('favicon-16x16.png')) : $png32 }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ $apple }}">
