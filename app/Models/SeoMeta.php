<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Cache;

class SeoMeta extends Model
{
    protected $table = 'seo_meta';

    protected $fillable = [
        'seoable_type',
        'seoable_id',
        'seo_title',
        'browser_title',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'slug',
        'focus_keyword',
        'secondary_keywords',
        'schema_json',
        'structured_data_type',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'twitter_card',
        'robots_meta',
        'breadcrumb_title',
        'h1_title',
        'author',
        'publish_date',
        'seo_updated_date',
        'reading_time',
        'indexable',
        'followable',
    ];

    protected function casts(): array
    {
        return [
            'indexable' => 'boolean',
            'followable' => 'boolean',
            'publish_date' => 'date',
            'seo_updated_date' => 'date',
            'reading_time' => 'integer',
        ];
    }

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function booted(): void
    {
        static::saved(function () {
            Cache::forget('sitemap.xml');
            Cache::forget('seo.head_scripts');
            Cache::forget('home.sections');
        });
        static::deleted(function () {
            Cache::forget('sitemap.xml');
            Cache::forget('seo.head_scripts');
            Cache::forget('home.sections');
        });
    }
}
