<?php

namespace App\Traits;

use App\Models\SeoMeta;
use App\Support\SeoHelper;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSeo
{
    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    public function syncSeo(array $data): SeoMeta
    {
        $seo = $this->seo()->updateOrCreate(
            [
                'seoable_type' => static::class,
                'seoable_id' => $this->getKey(),
            ],
            collect($data)->only(SeoHelper::fields())->toArray()
        );

        return $seo;
    }

    public function getSeoAttributeValue(string $key, mixed $default = null): mixed
    {
        return $this->seo?->{$key} ?? $default;
    }

    public function robotsDirective(): string
    {
        if ($this->seo?->robots_meta) {
            return $this->seo->robots_meta;
        }

        $index = ($this->seo?->indexable ?? true) ? 'index' : 'noindex';
        $follow = ($this->seo?->followable ?? true) ? 'follow' : 'nofollow';

        return "{$index}, {$follow}";
    }
}
