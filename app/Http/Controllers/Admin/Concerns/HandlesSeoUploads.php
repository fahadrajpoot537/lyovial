<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Models\SeoMeta;
use App\Support\SeoHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait HandlesSeoUploads
{
    /**
     * Model payload without SEO columns. Restores slug because SeoHelper::fields()
     * also lists slug, so except() would drop the URL slug and crash on save.
     *
     * @param  array<string, mixed>  $validated
     * @param  list<string>  $alsoExcept
     * @return array<string, mixed>
     */
    protected function payloadWithoutSeo(array $validated, array $alsoExcept = []): array
    {
        $data = collect($validated)->except(array_merge(SeoHelper::fields(), $alsoExcept))->all();

        if (array_key_exists('title', $validated) || array_key_exists('title', $data)) {
            $data['slug'] = filled($validated['slug'] ?? null)
                ? (string) $validated['slug']
                : Str::slug((string) ($validated['title'] ?? $data['title'] ?? ''));
        }

        return $data;
    }

    /**
     * Merge validated SEO fields with optional OG/Twitter image uploads.
     *
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    protected function syncSeoFromRequest(Request $request, array $validated, $model): SeoMeta
    {
        $seo = SeoHelper::extract($validated);

        if (method_exists($this, 'uploadImage')) {
            $existing = $model->seo ?? null;

            if ($request->hasFile('og_image_upload')) {
                $seo['og_image'] = $this->uploadImage($request, 'og_image_upload', 'seo', $existing?->og_image);
            }

            if ($request->hasFile('twitter_image_upload')) {
                $seo['twitter_image'] = $this->uploadImage($request, 'twitter_image_upload', 'seo', $existing?->twitter_image);
            }
        }

        return $model->syncSeo($seo);
    }
}
