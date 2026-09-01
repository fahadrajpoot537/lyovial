<?php

namespace App\Models;

use App\Traits\HasSeo;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasSeo, HasSlug, SoftDeletes;

    public const TYPE_CUSTOM = 'custom';

    public const TYPE_QUALITY_COMPLIANCE = 'quality_compliance';

    public const TYPE_SPECIMEN_LIBRARY = 'specimen_library';

    public const TYPE_PARTNERSHIPS = 'partnerships';

    public const TYPE_PRIVACY = 'privacy';

    public const TYPE_ABOUT = 'about';

    protected $fillable = [
        'title',
        'slug',
        'type',
        'banner_image',
        'heading',
        'content',
        'extra',
        'status',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'extra' => 'array',
            'status' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public static function types(): array
    {
        return [
            self::TYPE_CUSTOM => 'Custom Page',
            self::TYPE_QUALITY_COMPLIANCE => 'Quality & Compliance',
            self::TYPE_SPECIMEN_LIBRARY => 'Specimen Library Preservation',
            self::TYPE_PARTNERSHIPS => 'Partnerships',
            self::TYPE_ABOUT => 'About Us',
            self::TYPE_PRIVACY => 'Privacy Policy',
        ];
    }

    public static function defaultSlugForType(string $type): ?string
    {
        return match ($type) {
            self::TYPE_ABOUT => 'about',
            self::TYPE_PRIVACY => 'privacy-policy',
            self::TYPE_QUALITY_COMPLIANCE => 'quality-compliance',
            self::TYPE_SPECIMEN_LIBRARY => 'specimen-library-preservation',
            self::TYPE_PARTNERSHIPS => 'partnerships',
            default => null,
        };
    }

    public static function reservedSlugs(): array
    {
        return [
            'admin', 'blog', 'articles', 'capabilities', 'services', 'industries',
            'contact', 'newsletter', 'storage', 'uploads', 'sitemap', 'theme',
            'up', 'build', 'vendor', 'assets', 'images', 'login', 'register',
        ];
    }

    public function publicPath(): string
    {
        $slug = filled($this->slug)
            ? $this->slug
            : (self::defaultSlugForType((string) $this->type) ?: 'page');

        return '/'.ltrim((string) $slug, '/');
    }

    public function publicUrl(): string
    {
        return url($this->publicPath());
    }

    public static function publicUrlForType(string $type, string $fallbackPath): string
    {
        $page = static::query()->ofType($type)->first();

        return $page ? $page->publicUrl() : url('/'.ltrim($fallbackPath, '/'));
    }
}
