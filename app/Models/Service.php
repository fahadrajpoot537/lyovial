<?php

namespace App\Models;

use App\Traits\HasSeo;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasSeo, HasSlug, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'banner_image',
        'featured_image',
        'page_heading',
        'short_description',
        'long_description',
        'extra',
        'button_text',
        'button_link',
        'breadcrumb_title',
        'show_on_home',
        'status',
        'is_featured',
        'sort_order',
        'home_sort_order',
    ];

    protected function casts(): array
    {
        return [
            'extra' => 'array',
            'show_on_home' => 'boolean',
            'status' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'home_sort_order' => 'integer',
        ];
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(ServiceGallery::class)->orderBy('sort_order');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeOnHome(Builder $query): Builder
    {
        return $query->where('show_on_home', true)->orderBy('home_sort_order');
    }
}
