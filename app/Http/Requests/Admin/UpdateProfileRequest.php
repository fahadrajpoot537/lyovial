<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user()?->id),
            ],
            'phone' => ['nullable', 'string', 'max:50'],
        ], $this->imageOrPathRules('avatar'));
    }

    protected function imageOrPathRules(string $field, int $maxKb = 5120): array
    {
        return [
            $field => [
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
            ],
        ];
    }
}
