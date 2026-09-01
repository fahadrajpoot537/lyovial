<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Models\SeoMeta;
use App\Models\SeoRedirect;
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
    protected function payloadWithoutSeo(array $validated, array $alsoExcept = [], ?string $currentSlug = null): array
    {
        $data = collect($validated)->except(array_merge(SeoHelper::fields(), $alsoExcept))->all();

        if (array_key_exists('title', $validated) || array_key_exists('title', $data)) {
            if (filled($validated['slug'] ?? null)) {
                $data['slug'] = (string) $validated['slug'];
            } elseif (filled($currentSlug)) {
                $data['slug'] = $currentSlug;
            } else {
                $data['slug'] = Str::slug((string) ($validated['title'] ?? $data['title'] ?? ''));
            }

            if (filled($data['slug'] ?? null) && strlen((string) $data['slug']) > 255) {
                $data['slug'] = rtrim(substr((string) $data['slug'], 0, 255), '-');
            }
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

    protected function rememberSlugRedirect(?string $oldSlug, ?string $newSlug, string $prefix = ''): void
    {
        $from = trim((string) $oldSlug, '/');
        $to = trim((string) $newSlug, '/');
        if ($from === '' || $to === '' || $from === $to) {
            return;
        }

        $fromPath = '/'.trim($prefix.'/'.$from, '/');
        $toUrl = url('/'.trim($prefix.'/'.$to, '/'));

        SeoRedirect::query()->updateOrCreate(
            ['from_path' => SeoRedirect::normalizePath($fromPath)],
            [
                'to_url' => $toUrl,
                'status_code' => 301,
                'is_active' => true,
                'notes' => 'Auto redirect after slug change',
            ]
        );
    }
}
