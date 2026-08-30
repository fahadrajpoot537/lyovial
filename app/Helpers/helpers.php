<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null, ?string $group = null): mixed
    {
        return Setting::get($key, $default, $group);
    }
}

if (! function_exists('setting_group')) {
    function setting_group(string $group): array
    {
        return Setting::group($group);
    }
}

if (! function_exists('storage_url')) {
    function storage_url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        // Keep external CDN / Unsplash URLs intact
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return $path;
        }

        $relative = ltrim(str_replace('\\', '/', $path), '/');
        if (str_starts_with($relative, 'storage/')) {
            $relative = substr($relative, strlen('storage/'));
        }

        // Prefer a public copy so shared hosts work without storage:link
        if (is_file(public_path('uploads/'.$relative))) {
            return '/uploads/'.$relative;
        }

        return '/storage/'.$relative;
    }
}

if (! function_exists('admin_asset')) {
    function admin_asset(string $path): string
    {
        return asset('assets/admin/'.$path);
    }
}
