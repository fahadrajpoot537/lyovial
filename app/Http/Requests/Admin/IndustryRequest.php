<?php

namespace App\Http\Requests\Admin;

use App\Support\AdminHtml;
use App\Support\AdminSlug;
use App\Support\SeoHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class IndustryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $industryId = $this->route('industry')?->id ?? $this->route('industry');

        return array_merge([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('industries', 'slug')->ignore($industryId)->whereNull('deleted_at'),
            ],
            'banner_image' => $this->imageOrPathRule(),
            'image' => $this->imageOrPathRule(),
            'heading' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'show_on_home' => ['nullable', 'boolean'],
            'status' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'home_sort_order' => ['nullable', 'integer', 'min:0'],
            'extra' => ['nullable', 'array'],
            'extra.nav_title' => ['nullable', 'string', 'max:255'],
            'extra.hero_eyebrow' => ['nullable', 'string', 'max:255'],
            'extra.hero_h1' => ['nullable', 'string', 'max:500'],
            'extra.hero_lede' => ['nullable', 'string', 'max:2000'],
            'extra.spec_heading' => ['nullable', 'string', 'max:255'],
            'extra.spec_items' => ['nullable', 'array'],
            'extra.spec_items.*.title' => ['nullable', 'string', 'max:255'],
            'extra.spec_items.*.body' => ['nullable', 'string', 'max:2000'],
            'extra.lead_eyebrow' => ['nullable', 'string', 'max:255'],
            'extra.lead_heading' => ['nullable', 'string', 'max:500'],
            'extra.lead_paras' => ['nullable', 'array'],
            'extra.lead_paras.*' => ['nullable', 'string', 'max:4000'],
            'extra.needs_eyebrow' => ['nullable', 'string', 'max:255'],
            'extra.needs' => ['nullable', 'array'],
            'extra.needs.*.n' => ['nullable', 'string', 'max:20'],
            'extra.needs.*.title' => ['nullable', 'string', 'max:255'],
            'extra.needs.*.body' => ['nullable', 'string', 'max:2000'],
            'extra.process_eyebrow' => ['nullable', 'string', 'max:255'],
            'extra.process_heading' => ['nullable', 'string', 'max:500'],
            'extra.process_intro' => ['nullable', 'string', 'max:2000'],
            'extra.steps' => ['nullable', 'array'],
            'extra.steps.*.title' => ['nullable', 'string', 'max:255'],
            'extra.steps.*.body' => ['nullable', 'string', 'max:2000'],
            'extra.why_eyebrow' => ['nullable', 'string', 'max:255'],
            'extra.why_heading' => ['nullable', 'string', 'max:500'],
            'extra.why_body' => ['nullable', 'string', 'max:4000'],
            'extra.why_items' => ['nullable', 'array'],
            'extra.why_items.*' => ['nullable', 'string', 'max:2000'],
            'extra.related_intro' => ['nullable', 'string', 'max:1000'],
            'extra.workflow_heading' => ['nullable', 'string', 'max:255'],
            'extra.other_industries_heading' => ['nullable', 'string', 'max:255'],
            'extra.faq_eyebrow' => ['nullable', 'string', 'max:255'],
            'extra.faq_heading' => ['nullable', 'string', 'max:500'],
            'extra.faq_intro' => ['nullable', 'string', 'max:2000'],
            'extra.faqs' => ['nullable', 'array'],
            'extra.faqs.*.q' => ['nullable', 'string', 'max:500'],
            'extra.faqs.*.a' => ['nullable', 'string', 'max:4000'],
            'extra.cta_eyebrow' => ['nullable', 'string', 'max:255'],
            'extra.cta_heading' => ['nullable', 'string', 'max:500'],
            'extra.cta_body' => ['nullable', 'string', 'max:2000'],
            'extra.cta_button' => ['nullable', 'string', 'max:150'],
            'extra.cta_link' => ['nullable', 'string', 'max:500'],
            'extra.swipe_needs' => ['nullable', 'string', 'max:255'],
            'extra.swipe_steps' => ['nullable', 'string', 'max:255'],
        ], SeoHelper::validationRules(includeSlug: false));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->boolean('status'),
            'show_on_home' => $this->boolean('show_on_home'),
            'indexable' => $this->boolean('indexable', true),
            'followable' => $this->boolean('followable', true),
            'sort_order' => $this->input('sort_order', 0),
            'home_sort_order' => $this->input('home_sort_order', 0),
            'slug' => filled($this->input('slug')) ? AdminSlug::normalize($this->input('slug')) : null,
            'heading' => AdminHtml::emptyToBlank($this->input('heading')),
            'short_description' => AdminHtml::emptyToBlank($this->input('short_description')),
            'description' => AdminHtml::emptyToBlank($this->input('description')),
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
