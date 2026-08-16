<?php

namespace App\Models;

use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class HomeSection extends Model
{
    use HasSeo;

    protected $fillable = [
        'section_key',
        'small_title',
        'heading',
        'description',
        'image',
        'image_alt',
        'button_primary_text',
        'button_primary_link',
        'button_secondary_text',
        'button_secondary_link',
        'map_embed',
        'extra',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'extra' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public static function byKey(string $key): ?self
    {
        return static::cached()->firstWhere('section_key', $key);
    }

    public static function cached()
    {
        return Cache::rememberForever('home.sections', function () {
            return static::query()->orderBy('sort_order')->get();
        });
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('home.sections'));
        static::deleted(fn () => Cache::forget('home.sections'));
    }

    public static function sectionKeys(): array
    {
        return [
            'navbar' => 'Navbar / Branding',
            'hero' => 'Hero Section',
            'about' => 'About Section',
            'stats' => 'Stats Section',
            'services' => 'Services Section Intro',
            'industries' => 'Industries Section Intro',
            'why_choose' => 'Why Choose Us Intro',
            'partner' => 'Partner With Us',
            'testimonials' => 'Testimonials Intro',
            'process' => 'Our Process',
            'canada_coverage' => 'Canada Coverage',
            'faq' => 'FAQ Section Intro',
            'articles' => 'Articles Section Intro',
            'ready_to_talk' => 'Ready To Talk',
            'footer' => 'Footer',
        ];
    }
}
