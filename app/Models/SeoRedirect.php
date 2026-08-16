<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SeoRedirect extends Model
{
    protected $fillable = [
        'from_path',
        'to_url',
        'status_code',
        'is_active',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'status_code' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    protected static function booted(): void
    {
        $forget = function (SeoRedirect $redirect) {
            Cache::forget('seo.redirect.'.SeoRedirect::normalizePath($redirect->from_path));
            if ($redirect->wasChanged('from_path') && $redirect->getOriginal('from_path')) {
                Cache::forget('seo.redirect.'.SeoRedirect::normalizePath((string) $redirect->getOriginal('from_path')));
            }
        };

        static::saved($forget);
        static::deleted(fn (SeoRedirect $redirect) => Cache::forget('seo.redirect.'.SeoRedirect::normalizePath($redirect->from_path)));
    }

    public static function normalizePath(string $path): string
    {
        $path = trim(parse_url($path, PHP_URL_PATH) ?: $path);
        $path = '/'.ltrim($path, '/');

        return $path === '/' ? '/' : rtrim($path, '/');
    }
}
