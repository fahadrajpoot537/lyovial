<?php

namespace App\Http\Requests\Admin;

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
                Rule::unique('industries', 'slug')->ignore($industryId),
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
        ], SeoHelper::validationRules());
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
            'slug' => filled($this->input('slug')) ? $this->input('slug') : null,
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
