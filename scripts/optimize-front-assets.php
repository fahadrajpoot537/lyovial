<?php

/**
 * One-shot optimizer: WebP image variants + self-hosted Inter latin fonts.
 */
ini_set('memory_limit', '512M');

$root = dirname(__DIR__);
$public = $root.DIRECTORY_SEPARATOR.'public';

function load_image(string $path)
{
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    return match ($ext) {
        'jpg', 'jpeg' => @imagecreatefromjpeg($path),
        'png' => @imagecreatefrompng($path),
        'webp' => @imagecreatefromwebp($path),
        'gif' => @imagecreatefromgif($path),
        default => false,
    };
}

function resize_to_max($im, int $maxW)
{
    $w = imagesx($im);
    $h = imagesy($im);
    if ($w <= $maxW) {
        return $im;
    }
    $nw = $maxW;
    $nh = (int) round($h * ($maxW / $w));
    $out = imagecreatetruecolor($nw, $nh);
    imagealphablending($out, false);
    imagesavealpha($out, true);
    imagecopyresampled($out, $im, 0, 0, 0, 0, $nw, $nh, $w, $h);
    imagedestroy($im);

    return $out;
}

function write_webp($im, string $dest, int $quality): bool
{
    $dir = dirname($dest);
    if (! is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    return imagewebp($im, $dest, $quality);
}

$jobs = [
    // [relative public path, max width, quality]
    ['images/site/hero.png', 1600, 72],
    ['images/site/hero-bg.jpg', 1600, 72],
    ['assets/front/images/lyovial-home/hero-bg.jpg', 1600, 72],
    ['images/site/about.jpg', 900, 75],
    ['assets/front/images/lyovial-home/about.jpg', 900, 75],
    ['images/site/why-lg.jpg', 1000, 75],
    ['assets/front/images/lyovial-home/why-lg.jpg', 1000, 75],
    ['images/site/why-sm.jpg', 700, 75],
    ['assets/front/images/lyovial-home/why-sm.jpg', 700, 75],
    ['images/site/partner.jpg', 1200, 75],
    ['assets/front/images/lyovial-home/partner.jpg', 1200, 75],
    ['images/site/process.jpg', 900, 75],
    ['assets/front/images/lyovial-home/process.jpg', 900, 75],
    ['images/site/facility-ottawa.jpg', 1400, 72],
    ['images/site/svc-1.jpg', 800, 75],
    ['images/site/svc-2.jpg', 800, 75],
    ['images/site/svc-3.jpg', 800, 75],
    ['assets/front/images/lyovial-home/svc-1.jpg', 800, 75],
    ['assets/front/images/lyovial-home/svc-2.jpg', 800, 75],
    ['assets/front/images/lyovial-home/svc-3.jpg', 800, 75],
    ['images/site/ind-1.jpg', 800, 75],
    ['images/site/ind-2.jpg', 800, 75],
    ['images/site/ind-3.jpg', 800, 75],
    ['images/site/ind-4.jpg', 800, 75],
    ['images/site/ind-5.jpg', 800, 75],
    ['images/site/ind-6.jpg', 800, 75],
    ['assets/front/images/lyovial-home/ind-1.jpg', 800, 75],
    ['assets/front/images/lyovial-home/ind-2.jpg', 800, 75],
    ['assets/front/images/lyovial-home/ind-3.jpg', 800, 75],
    ['assets/front/images/lyovial-home/ind-4.jpg', 800, 75],
    ['assets/front/images/lyovial-home/ind-5.jpg', 800, 75],
    ['assets/front/images/lyovial-home/ind-6.jpg', 800, 75],
    ['images/site/banner-ab.jpg', 1400, 75],
    ['images/site/kanata-park.jpg', 1000, 75],
    ['assets/front/images/lyovial-home/logo-white.png', 400, 80],
    ['images/site/logo-white.png', 400, 80],
];

$extraHeroMobile = [
    ['images/site/hero.png', 800, 70, 'images/site/hero-800.webp'],
];

echo "Optimizing images...\n";
foreach ($jobs as [$rel, $maxW, $quality]) {
    $src = $public.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $rel);
    if (! is_file($src)) {
        echo "  skip missing {$rel}\n";
        continue;
    }
    $destRel = preg_replace('/\.(jpe?g|png|gif)$/i', '.webp', $rel);
    $dest = $public.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $destRel);
    $im = load_image($src);
    if (! $im) {
        echo "  fail read {$rel}\n";
        continue;
    }
    $im = resize_to_max($im, $maxW);
    if (write_webp($im, $dest, $quality)) {
        echo '  '.$destRel.'  '.round(filesize($dest) / 1024).'KB  (from '.round(filesize($src) / 1024)."KB)\n";
    } else {
        echo "  fail write {$destRel}\n";
    }
    imagedestroy($im);
}

foreach ($extraHeroMobile as [$rel, $maxW, $quality, $destRel]) {
    $src = $public.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $rel);
    if (! is_file($src)) {
        continue;
    }
    $dest = $public.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $destRel);
    $im = load_image($src);
    if (! $im) {
        continue;
    }
    $im = resize_to_max($im, $maxW);
    if (write_webp($im, $dest, $quality)) {
        echo '  '.$destRel.'  '.round(filesize($dest) / 1024)."KB (mobile LCP)\n";
    }
    imagedestroy($im);
}

echo "Downloading Inter latin fonts...\n";
$fontDir = $public.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'front'.DIRECTORY_SEPARATOR.'fonts';
if (! is_dir($fontDir)) {
    mkdir($fontDir, 0775, true);
}

$fontFiles = [
    'inter-latin-400.woff2' => 'https://cdn.jsdelivr.net/fontsource/fonts/inter@5.2.5/latin-400-normal.woff2',
    'inter-latin-600.woff2' => 'https://cdn.jsdelivr.net/fontsource/fonts/inter@5.2.5/latin-600-normal.woff2',
    'inter-latin-700.woff2' => 'https://cdn.jsdelivr.net/fontsource/fonts/inter@5.2.5/latin-700-normal.woff2',
];

$ctx = stream_context_create([
    'http' => [
        'timeout' => 30,
        'header' => "User-Agent: Mozilla/5.0\r\n",
    ],
    'ssl' => ['verify_peer' => true, 'verify_peer_name' => true],
]);

foreach ($fontFiles as $name => $url) {
    $dest = $fontDir.DIRECTORY_SEPARATOR.$name;
    $data = @file_get_contents($url, false, $ctx);
    if ($data && strlen($data) > 1000) {
        file_put_contents($dest, $data);
        echo '  '.$name.'  '.round(strlen($data) / 1024)."KB\n";
    } else {
        echo "  fail {$name}\n";
    }
}

echo "Done.\n";
