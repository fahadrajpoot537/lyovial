<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class TestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string'],
            'avatar' => $this->imageOrPathRule(),
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'status' => ['nullable', 'boolean'],
            'show_on_home' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->boolean('status'),
            'show_on_home' => $this->boolean('show_on_home'),
            'rating' => (int) $this->input('rating', 5),
            'sort_order' => $this->input('sort_order', 0),
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
