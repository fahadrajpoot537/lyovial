<?php

namespace App\Http\Requests\Admin;

use App\Support\AdminHtml;
use App\Support\AdminSlug;
use App\Support\SeoHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $articleId = $this->route('article')?->id;

        return array_merge([
            'title' => ['required', 'string', 'max:500'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('articles', 'slug')->ignore($articleId)->whereNull('deleted_at'),
            ],
            'excerpt' => ['nullable', 'string', 'max:10000'],
            'content' => ['nullable', 'string'],
            'featured_image' => $this->imageOrPathRule(),
            'author_name' => ['nullable', 'string', 'max:255'],
            'author_role' => ['nullable', 'string', 'max:255'],
            'author_avatar' => $this->imageOrPathRule(),
            'published_at' => ['nullable', 'date'],
            'status' => ['nullable', 'boolean'],
            'show_on_home' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], SeoHelper::validationRules(includeSlug: false));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->boolean('status'),
            'show_on_home' => $this->boolean('show_on_home'),
            'indexable' => $this->boolean('indexable', true),
            'followable' => $this->boolean('followable', true),
            'excerpt' => AdminHtml::emptyToBlank($this->input('excerpt')),
            'content' => is_string($this->input('content'))
                ? AdminHtml::emptyToBlank(str_replace("\0", '', $this->input('content')))
                : $this->input('content'),
            'published_at' => filled($this->input('published_at')) ? $this->input('published_at') : null,
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
