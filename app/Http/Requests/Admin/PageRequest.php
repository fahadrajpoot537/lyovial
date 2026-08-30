<?php

namespace App\Http\Requests\Admin;

use App\Models\Page;
use App\Support\AdminSlug;
use App\Support\SeoHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pageId = $this->route('page')?->id ?? $this->route('page');

        return array_merge([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', Rule::in(array_keys(Page::types()))],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('pages', 'slug')->ignore($pageId),
                Rule::notIn(Page::reservedSlugs()),
            ],
            'banner_image' => $this->imageOrPathRule(),
            'hero_image_upload' => $this->imageOrPathRule(),
            'origin_image_upload' => $this->imageOrPathRule(),
            'expertise_image_upload' => $this->imageOrPathRule(),
            'heading' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'extra' => ['nullable', 'array'],
            'extra.effective_date' => ['nullable', 'string', 'max:50'],
            'extra.last_updated' => ['nullable', 'string', 'max:50'],
            'extra.change_log' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], SeoHelper::validationRules(includeSlug: false));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->boolean('status'),
            'indexable' => $this->boolean('indexable', true),
            'followable' => $this->boolean('followable', true),
            'sort_order' => $this->input('sort_order', 0),
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
