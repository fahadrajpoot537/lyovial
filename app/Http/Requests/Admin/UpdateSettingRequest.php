<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $groups = ['general', 'contact', 'social', 'seo', 'analytics', 'scripts'];

        return [
            'group' => ['required', 'string', Rule::in($groups)],
            'site_name' => ['nullable', 'string', 'max:255'],
            'copyright' => ['nullable', 'string', 'max:500'],
            'logo' => $this->imageOrPathRule(),
            'favicon' => $this->imageOrPathRule(),
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'map_embed' => ['nullable', 'string'],
            'facebook' => ['nullable', 'url', 'max:500'],
            'twitter' => ['nullable', 'url', 'max:500'],
            'instagram' => ['nullable', 'url', 'max:500'],
            'linkedin' => ['nullable', 'url', 'max:500'],
            'youtube' => ['nullable', 'url', 'max:500'],
            'site_title' => ['nullable', 'string', 'max:255'],
            'default_canonical_url' => ['nullable', 'url', 'max:500'],
            'organization_name' => ['nullable', 'string', 'max:255'],
            'organization_logo' => $this->imageOrPathRule(),
            'organization_phone' => ['nullable', 'string', 'max:50'],
            'organization_email' => ['nullable', 'email', 'max:255'],
            'organization_address' => ['nullable', 'string', 'max:1000'],
            'default_meta_title' => ['nullable', 'string', 'max:255'],
            'default_meta_description' => ['nullable', 'string', 'max:500'],
            'default_meta_keywords' => ['nullable', 'string', 'max:500'],
            'default_og_title' => ['nullable', 'string', 'max:255'],
            'default_og_description' => ['nullable', 'string', 'max:500'],
            'default_og_image' => $this->imageOrPathRule(),
            'default_twitter_title' => ['nullable', 'string', 'max:255'],
            'default_twitter_description' => ['nullable', 'string', 'max:500'],
            'default_twitter_card' => ['nullable', 'string', 'max:50'],
            'default_twitter_image' => $this->imageOrPathRule(),
            'sitemap_enabled' => ['nullable', 'string', 'max:5'],
            'sitemap_changefreq' => ['nullable', 'string', 'max:50'],
            'google_analytics' => ['nullable', 'string'],
            'google_tag_manager' => ['nullable', 'string'],
            'google_search_console' => ['nullable', 'string', 'max:255'],
            'bing_verification' => ['nullable', 'string', 'max:255'],
            'meta_pixel' => ['nullable', 'string'],
            'linkedin_insight_tag' => ['nullable', 'string'],
            'robots_txt' => ['nullable', 'string'],
            'custom_head_scripts' => ['nullable', 'string'],
            'custom_footer_scripts' => ['nullable', 'string'],
        ];
    }

    protected function imageOrPathRule(int $maxKb = 5120): array
    {
        return [
            'nullable',
            function (string $attribute, mixed $value, \Closure $fail) use ($maxKb): void {
                if ($value instanceof UploadedFile) {
                    if (! str_starts_with((string) $value->getMimeType(), 'image/')) {
                        $fail("The {$attribute} must be an image.");
                    }
                    if ($value->getSize() > $maxKb * 1024) {
                        $fail("The {$attribute} may not be greater than {$maxKb} kilobytes.");
                    }
                } elseif ($value !== null && ! is_string($value)) {
                    $fail("The {$attribute} must be a file or path string.");
                }
            },
        ];
    }
}
