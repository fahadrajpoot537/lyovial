<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Models\SeoMeta;
use App\Support\SeoHelper;
use Illuminate\Http\Request;

trait HandlesSeoUploads
{
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
