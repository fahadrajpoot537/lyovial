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
        ];
    }
}
