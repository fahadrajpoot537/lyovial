<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'location',
        'title',
        'url',
        'route_name',
        'type',
        'target',
        'css_class',
        'icon',
        'is_active',
        'open_in_new_tab',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'open_in_new_tab' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort_order');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', $location);
    }

    public function scopeRoots(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function getResolvedUrlAttribute(): string
    {
        if ($this->route_name && \Illuminate\Support\Facades\Route::has($this->route_name)) {
            return self::normalizeFrontUrl(route($this->route_name));
        }

        return self::normalizeFrontUrl($this->url ?: '#');
    }

    public static function normalizeFrontUrl(string $url): string
    {
        if ($url === '' || $url === '#') {
            return $url;
        }

        $replacements = [
            '/services/' => '/capabilities/',
            '/services' => '/capabilities',
            'services.html' => '/capabilities',
            'services-2.html' => '/industries',
            'about.html' => '/about',
            'contact.html' => '/contact',
            'faq.html' => '/specimen-library-preservation',
            'index-2.html' => '/',
            'index.html' => '/',
        ];

        foreach ($replacements as $from => $to) {
            if ($url === $from || str_ends_with($url, $from)) {
                // path-only or full URL ending with legacy path
                if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
                    $parts = parse_url($url);
                    $path = $parts['path'] ?? '';
                    $path = str_replace(array_keys($replacements), array_values($replacements), $path);
                    $url = ($parts['scheme'] ?? 'https').'://'.($parts['host'] ?? '').$path;
                } else {
                    $url = str_replace($from, $to, $url);
                }
            }
        }

        // Catch any remaining /services segment
        $url = preg_replace('#(^|://[^/]+)/services(?=/|$)#', '$1/capabilities', $url) ?? $url;
        if (str_starts_with($url, '/services')) {
            $url = '/capabilities'.substr($url, strlen('/services'));
        }

        return $url;
    }

    public static function tree(string $location = 'header')
    {
        return Cache::rememberForever("menus.{$location}", function () use ($location) {
            return static::query()
                ->location($location)
                ->active()
                ->roots()
                ->with(['children' => fn ($q) => $q->active()->orderBy('sort_order')])
                ->orderBy('sort_order')
                ->get();
        });
    }

    protected static function booted(): void
    {
        static::saved(fn (Menu $menu) => Cache::forget("menus.{$menu->location}"));
        static::deleted(fn (Menu $menu) => Cache::forget("menus.{$menu->location}"));
    }
}
