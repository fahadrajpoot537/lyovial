<?php

namespace Database\Seeders\Concerns;

use App\Models\Media;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait SeedsDemoMedia
{
    protected function demoImage(string $relativePath, string $alt, string $title, ?string $caption = null): string
    {
        $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');
        $relativePath = preg_replace('#^storage/#', '', $relativePath) ?: $relativePath;

        $disk = Storage::disk('public');
        $directory = dirname($relativePath);

        if ($directory !== '.' && ! $disk->exists($directory)) {
            $disk->makeDirectory($directory);
        }

        $fullPath = $disk->path($relativePath);

        if (! File::exists($fullPath)) {
            File::ensureDirectoryExists(dirname($fullPath));
            File::put($fullPath, $this->svgPlaceholder($title));
        }

        Media::query()->updateOrCreate(
            ['path' => $relativePath],
            [
                'disk' => 'public',
                'filename' => basename($relativePath),
                'original_name' => basename($relativePath),
                'mime_type' => 'image/svg+xml',
                'extension' => 'svg',
                'size' => File::size($fullPath),
                'width' => 1200,
                'height' => 800,
                'alt_text' => $alt,
                'title' => $title,
                'caption' => $caption ?? $title,
                'seo_name' => Str::slug(pathinfo($relativePath, PATHINFO_FILENAME)),
                'folder' => $directory === '.' ? 'demo' : $directory,
            ]
        );

        return $relativePath;
    }

    protected function svgPlaceholder(string $label): string
    {
        $safe = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="800" viewBox="0 0 1200 800">
  <defs>
    <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#0f766e"/>
      <stop offset="100%" stop-color="#134e4a"/>
    </linearGradient>
  </defs>
  <rect width="1200" height="800" fill="url(#g)"/>
  <circle cx="980" cy="140" r="90" fill="#14b8a6" opacity="0.25"/>
  <circle cx="180" cy="680" r="120" fill="#99f6e4" opacity="0.18"/>
  <text x="60" y="120" fill="#ecfdf5" font-family="Arial, sans-serif" font-size="42" font-weight="700">LyoVial</text>
  <text x="60" y="190" fill="#ccfbf1" font-family="Arial, sans-serif" font-size="28">{$safe}</text>
</svg>
SVG;
    }

    protected function mapEmbed(): string
    {
        return '<iframe src="https://www.google.com/maps?q=105+Schneider+Road+Unit+123+Kanata+Ontario+K2K+1Y3&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
    }

    protected function addressBlock(): string
    {
        return "105 Schneider Road, Unit 123\nKanata, Ontario K2K 1Y3\nCanada";
    }
}
