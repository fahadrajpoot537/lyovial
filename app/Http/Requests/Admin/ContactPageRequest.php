<?php

namespace App\Http\Requests\Admin;

use App\Support\AdminHtml;
use App\Support\SeoHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class ContactPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge([
            'banner_image' => $this->imageOrPathRule(),
            'heading' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'form_heading' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'map_embed' => ['nullable', 'string'],
            'what_to_include_heading' => ['nullable', 'string', 'max:255'],
            'what_to_include_content' => ['nullable', 'string'],
            'how_can_we_help_heading' => ['nullable', 'string', 'max:255'],
            'how_can_we_help_content' => ['nullable', 'string'],
        ], SeoHelper::validationRules(includeSlug: false));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'indexable' => $this->boolean('indexable', true),
            'followable' => $this->boolean('followable', true),
            'heading' => AdminHtml::emptyToBlank($this->input('heading')),
            'description' => AdminHtml::emptyToBlank($this->input('description')),
            'what_to_include_content' => AdminHtml::emptyToBlank($this->input('what_to_include_content')),
            'how_can_we_help_content' => AdminHtml::emptyToBlank($this->input('how_can_we_help_content')),
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
