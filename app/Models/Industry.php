<?php

namespace App\Models;

use App\Traits\HasSeo;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industry extends Model
{
    use HasSeo, HasSlug, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'banner_image',
        'image',
        'heading',
        'short_description',
        'description',
        'show_on_home',
        'status',
        'sort_order',
        'home_sort_order',
    ];

    protected function casts(): array
    {
        return [
            'show_on_home' => 'boolean',
            'status' => 'boolean',
            'sort_order' => 'integer',
            'home_sort_order' => 'integer',
        ];
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
