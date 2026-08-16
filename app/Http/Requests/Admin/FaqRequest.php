<?php

namespace App\Http\Requests\Admin;

use App\Support\SeoHelper;
use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge([
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string'],
            'section' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], SeoHelper::validationRules());
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->boolean('status'),
            'indexable' => $this->boolean('indexable', true),
            'followable' => $this->boolean('followable', true),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }
}
