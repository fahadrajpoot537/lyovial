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
            if (filled($article->slug) && strlen((string) $article->slug) > 255) {
                $article->slug = rtrim(substr((string) $article->slug, 0, 255), '-');
            }
        });
    }

    public static function uniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $base = $slug !== '' ? $slug : 'article';
        if (strlen($base) > 255) {
            $base = rtrim(substr($base, 0, 255), '-');
        }

        $candidate = $base;

        static::onlyTrashed()
            ->where('slug', $candidate)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->get()
            ->each(function (self $row): void {
                $freed = $row->slug.'-archived-'.$row->id;
                if (strlen($freed) > 255) {
                    $freed = 'archived-'.$row->id;
                }
                $row->slug = $freed;
                $row->saveQuietly();
            });

        $n = 2;
        while (static::withTrashed()
            ->where('slug', $candidate)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $suffix = '-'.$n;
            $candidate = substr($base, 0, 255 - strlen($suffix)).$suffix;
            $n++;
        }

        return $candidate;
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
            $q->whereNull('published_at')
                ->orWhereDate('published_at', '<=', now()->toDateString());
        });
    }
}
