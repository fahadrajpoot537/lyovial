<?php

namespace App\Models;

use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasSeo, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author_name',
        'author_role',
        'author_avatar',
        'published_at',
        'status',
        'show_on_home',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'status' => 'boolean',
            'show_on_home' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Article $article): void {
            if (blank($article->slug) && filled($article->title)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeOnHome(Builder $query): Builder
    {
        return $query->where('show_on_home', true);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where(function (Builder $q): void {
            $q->whereNull('published_at')->orWhere('published_at', '<=', now());
        });
    }
}
