<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // HTML checkboxes send "on" which fails Laravel's boolean rule
        if ($this->has('remember')) {
            $this->merge([
                'remember' => filter_var($this->input('remember'), FILTER_VALIDATE_BOOLEAN)
                    || $this->input('remember') === 'on'
                    || $this->input('remember') === '1',
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
            'g-recaptcha-response' => ['nullable', 'string'],
        ];
    }
}
