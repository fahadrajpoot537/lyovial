<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
    ];

    public static function get(string $key, mixed $default = null, ?string $group = null): mixed
    {
        $settings = static::cached();

        if ($group) {
            return $settings[$group][$key] ?? $default;
        }

        foreach ($settings as $items) {
            if (array_key_exists($key, $items)) {
                return $items[$key];
            }
        }

        return $default;
    }

    public static function set(string $key, mixed $value, string $group = 'general', string $type = 'text'): self
    {
        $setting = static::updateOrCreate(
            ['group' => $group, 'key' => $key],
            ['value' => is_array($value) ? json_encode($value) : $value, 'type' => $type]
        );

        Cache::forget('app.settings');
        Cache::forget('seo.head_scripts');
        Cache::forget('sitemap.xml');

        return $setting;
    }

    public static function setMany(array $data, string $group = 'general'): void
    {
        foreach ($data as $key => $value) {
            $type = is_array($value) ? 'json' : 'text';
            static::set($key, $value, $group, $type);
        }
    }

    public static function group(string $group): array
    {
        return static::cached()[$group] ?? [];
    }

    public static function cached(): array
    {
        return Cache::rememberForever('app.settings', function () {
            return static::query()
                ->get()
                ->groupBy('group')
                ->map(fn ($items) => $items->pluck('value', 'key')->toArray())
                ->toArray();
        });
    }

    public static function flushCache(): void
    {
        Cache::forget('app.settings');
        Cache::forget('seo.head_scripts');
        Cache::forget('sitemap.xml');
    }
}
