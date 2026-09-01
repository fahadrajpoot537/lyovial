<?php

namespace App\Support;

class AdminHtml
{
    /**
     * Treat empty editor HTML (TinyMCE leftover tags) as a blank string so cleared fields stay cleared.
     */
    public static function emptyToBlank(mixed $value): mixed
    {
        if (! is_string($value)) {
            return $value;
        }

        $text = html_entity_decode(str_replace("\xc2\xa0", ' ', $value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = trim(preg_replace('/\s+/', ' ', strip_tags($text)) ?? '');

        return $text === '' ? '' : $value;
    }
}
