<?php

namespace App\Http\Requests\Admin;

use App\Support\AdminSlug;
use App\Support\SeoHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $serviceId = $this->route('service')?->id ?? $this->route('service');

        return array_merge([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('services', 'slug')->ignore($serviceId),
            ],
            'banner_image' => $this->imageOrPathRule(),
            'featured_image' => $this->imageOrPathRule(),
            'page_heading' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'long_description' => ['nullable', 'string'],
            'extra' => ['nullable', 'array'],
            'extra.eyebrow' => ['nullable', 'string', 'max:255'],
            'extra.intro_heading' => ['nullable', 'string', 'max:500'],
            'extra.includes_heading' => ['nullable', 'string', 'max:255'],
            'extra.includes' => ['nullable', 'array'],
            'extra.includes.*.title' => ['nullable', 'string', 'max:255'],
            'extra.includes.*.body' => ['nullable', 'string', 'max:2000'],
            'extra.why_heading' => ['nullable', 'string', 'max:255'],
            'extra.why_bullets' => ['nullable', 'array'],
            'extra.why_bullets.*' => ['nullable', 'string', 'max:1000'],
            'extra.steps_heading' => ['nullable', 'string', 'max:255'],
            'extra.steps_intro' => ['nullable', 'string', 'max:1000'],
            'extra.steps' => ['nullable', 'array'],
            'extra.steps.*.num' => ['nullable', 'string', 'max:10'],
            'extra.steps.*.title' => ['nullable', 'string', 'max:255'],
            'extra.steps.*.body' => ['nullable', 'string', 'max:1000'],
            'extra.related_heading' => ['nullable', 'string', 'max:255'],
            'extra.sidebar_cta_title' => ['nullable', 'string', 'max:255'],
            'extra.sidebar_cta_body' => ['nullable', 'string', 'max:1000'],
            'extra.sidebar_cta_button' => ['nullable', 'string', 'max:100'],
            'extra.bottom_cta_heading' => ['nullable', 'string', 'max:255'],
            'extra.bottom_cta_body' => ['nullable', 'string', 'max:1000'],
            'extra.bottom_cta_button' => ['nullable', 'string', 'max:100'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:500'],
            'breadcrumb_title' => ['nullable', 'string', 'max:255'],
            'show_on_home' => ['nullable', 'boolean'],
            'status' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'home_sort_order' => ['nullable', 'integer', 'min:0'],
            'galleries' => ['nullable', 'array'],
            'galleries.*.id' => ['nullable', 'integer', 'exists:service_galleries,id'],
            'galleries.*.image' => ['nullable'],
            'galleries.*.alt_text' => ['nullable', 'string', 'max:255'],
            'galleries.*.title' => ['nullable', 'string', 'max:255'],
            'galleries.*.sort_order' => ['nullable', 'integer', 'min:0'],
        ], SeoHelper::validationRules(includeSlug: false));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->boolean('status'),
            'show_on_home' => $this->boolean('show_on_home'),
            'is_featured' => $this->boolean('is_featured'),
            'indexable' => $this->boolean('indexable', true),
            'followable' => $this->boolean('followable', true),
            'sort_order' => $this->input('sort_order', 0),
            'home_sort_order' => $this->input('home_sort_order', 0),
            'slug' => filled($this->input('slug')) ? AdminSlug::normalize($this->input('slug')) : null,
        ]);
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
