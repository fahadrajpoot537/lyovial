<?php
    $logo = setting('logo', null, 'general');
    $cmsFavicon = setting('favicon', null, 'general');

    // Always prefer the brand logo for favicon
    $candidates = array_filter([
        $logo,
        $cmsFavicon,
        '/theme/assets/images/lyovial/logo.png',
        '/lyovial-logo.png',
        '/images/site/logo-white.png',
        '/favicon.png',
    ]);

    $primary = null;
    foreach ($candidates as $candidate) {
        $url = storage_url($candidate) ?: $candidate;
        if (! $url) {
            continue;
        }
        $relative = parse_url($url, PHP_URL_PATH) ?: $url;
        if (str_starts_with($relative, '/storage/')) {
            $diskPath = public_path('storage/'.ltrim(substr($relative, 9), '/'));
        } else {
            $diskPath = public_path(ltrim($relative, '/'));
        }
        if (is_file($diskPath) && filesize($diskPath) > 500) {
            $primary = str_starts_with($url, 'http') ? $url : asset(ltrim($relative, '/'));
            break;
        }
    }

    if (! $primary) {
        $primary = asset('theme/assets/images/lyovial/logo.png');
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
?>
<link rel="icon" href="<?php echo e($primary); ?>" type="<?php echo e($type); ?>">
<link rel="shortcut icon" href="<?php echo e($primary); ?>" type="<?php echo e($type); ?>">
<link rel="icon" type="<?php echo e($type); ?>" sizes="32x32" href="<?php echo e($primary); ?>">
<link rel="icon" type="<?php echo e($type); ?>" sizes="16x16" href="<?php echo e($primary); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo e($primary); ?>">
<?php /**PATH C:\xampp\htdocs\liovine\resources\views/front/partials/favicon.blade.php ENDPATH**/ ?>