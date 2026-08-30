<?php

namespace App\Http\Requests\Admin;

use App\Support\SeoHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class HomeSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge([
            'small_title' => ['nullable', 'string', 'max:255'],
            'heading' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => $this->imageOrPathRule(),
            'image_alt' => ['nullable', 'string', 'max:255'],
            'button_primary_text' => ['nullable', 'string', 'max:100'],
            'button_primary_link' => ['nullable', 'string', 'max:500'],
            'button_secondary_text' => ['nullable', 'string', 'max:100'],
            'button_secondary_link' => ['nullable', 'string', 'max:500'],
            'map_embed' => ['nullable', 'string'],
            'extra' => ['nullable', 'array'],
            'stat_items' => ['nullable', 'array'],
            'stat_items.*.num' => ['nullable', 'string', 'max:50'],
            'stat_items.*.label' => ['nullable', 'string', 'max:255'],
            'stat_items.*.icon' => ['nullable', 'string', 'max:50'],
            'partner_cards' => ['nullable', 'array'],
            'partner_cards.*.title' => ['nullable', 'string', 'max:255'],
            'partner_cards.*.description' => ['nullable', 'string'],
            'partner_cards.*.icon' => ['nullable', 'string', 'max:50'],
            'process_steps' => ['nullable', 'array'],
            'process_steps.*.num' => ['nullable', 'string', 'max:20'],
            'process_steps.*.title' => ['nullable', 'string', 'max:255'],
            'coverage_points' => ['nullable', 'array'],
            'coverage_points.*.title' => ['nullable', 'string', 'max:255'],
            'coverage_points.*.text' => ['nullable', 'string', 'max:500'],
            'extra.explore_heading' => ['nullable', 'string', 'max:255'],
            'extra.capabilities_heading' => ['nullable', 'string', 'max:255'],
            'extra.legal_label' => ['nullable', 'string', 'max:255'],
            'extra.legal_url' => ['nullable', 'string', 'max:500'],
            'extra.copyright' => ['nullable', 'string', 'max:1000'],
            'extra.credit' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], SeoHelper::validationRules());
    }

    protected function prepareForValidation(): void
    {
        $extra = $this->input('extra');
        if (is_string($extra)) {
            $trimmed = trim($extra);
            if ($trimmed === '') {
                $extra = null;
            } else {
                $decoded = json_decode($trimmed, true);
                $extra = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
            }
        }

        $key = $this->route('key') ?? $this->input('section_key');

        if ($key === 'stats' && $this->has('stat_items')) {
            $extra = [
                'items' => collect($this->input('stat_items', []))
                    ->map(fn ($row) => [
                        'num' => trim((string) ($row['num'] ?? '')),
                        'label' => trim((string) ($row['label'] ?? '')),
                        'icon' => trim((string) ($row['icon'] ?? 'flask')),
                    ])
                    ->filter(fn ($row) => $row['num'] !== '' || $row['label'] !== '')
                    ->values()
                    ->all(),
            ];
        } elseif ($key === 'partner' && $this->has('partner_cards')) {
            $extra = [
                'cards' => collect($this->input('partner_cards', []))
                    ->map(fn ($row) => [
                        'title' => trim((string) ($row['title'] ?? '')),
                        'description' => trim((string) ($row['description'] ?? '')),
                        'icon' => trim((string) ($row['icon'] ?? '')),
                    ])
                    ->filter(fn ($row) => $row['title'] !== '' || $row['description'] !== '')
                    ->values()
                    ->all(),
            ];
        } elseif ($key === 'process' && $this->has('process_steps')) {
            $extra = [
                'steps' => collect($this->input('process_steps', []))
                    ->map(fn ($row) => [
                        'num' => trim((string) ($row['num'] ?? '')),
                        'title' => trim((string) ($row['title'] ?? '')),
                    ])
                    ->filter(fn ($row) => $row['num'] !== '' || $row['title'] !== '')
                    ->values()
                    ->all(),
            ];
        } elseif ($key === 'canada_coverage' && $this->has('coverage_points')) {
            $extra = [
                'points' => collect($this->input('coverage_points', []))
                    ->map(fn ($row) => [
                        'title' => trim((string) ($row['title'] ?? '')),
                        'text' => trim((string) ($row['text'] ?? '')),
                    ])
                    ->filter(fn ($row) => $row['title'] !== '' || $row['text'] !== '')
                    ->values()
                    ->all(),
            ];
        }

        $this->merge([
            'extra' => $extra,
            'is_active' => $this->boolean('is_active'),
            'indexable' => $this->boolean('indexable', true),
            'followable' => $this->boolean('followable', true),
            'sort_order' => $this->input('sort_order', 0),
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
