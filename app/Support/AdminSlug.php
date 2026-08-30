<?php

namespace App\Support;

use Illuminate\Support\Str;

class AdminSlug
{
    public static function normalize(mixed $value): ?string
    {
        if (! is_string($value) && ! is_numeric($value)) {
            return null;
        }

        $slug = Str::slug(trim((string) $value));

        return $slug !== '' ? $slug : null;
    }
}
