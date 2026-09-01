<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Support\Str;
use Throwable;

class ArticleToc
{
    /**
     * @return array{html: string, headings: list<array{id: string, text: string, level: int}>}
     */
    public static function prepare(?string $html): array
    {
        $html = trim((string) $html);
        if ($html === '') {
            return ['html' => '', 'headings' => []];
        }

        try {
            return self::build($html);
        } catch (Throwable $e) {
            report($e);

            return ['html' => $html, 'headings' => []];
        }
    }

    /**
     * @return array{html: string, headings: list<array{id: string, text: string, level: int}>}
     */
    protected static function build(string $html): array
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $wrapped = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>'.$html.'</body></html>';
        $loaded = $dom->loadHTML($wrapped, LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();

        $root = $loaded ? $dom->getElementsByTagName('body')->item(0) : null;
        if (! $root) {
            return ['html' => $html, 'headings' => []];
        }

        $xpath = new DOMXPath($dom);
        $images = $xpath->query('.//img', $root);
        if ($images) {
            foreach ($images as $image) {
                if (! $image instanceof DOMElement) {
                    continue;
                }
                if (! $image->hasAttribute('loading')) {
                    $image->setAttribute('loading', 'lazy');
                }
                if (! $image->hasAttribute('decoding')) {
                    $image->setAttribute('decoding', 'async');
                }
            }
        }

        $nodes = $xpath->query('.//h1|.//h2|.//h3', $root);
        $headings = [];
        $used = [];

        if ($nodes) {
            foreach ($nodes as $node) {
                if (! $node instanceof DOMElement) {
                    continue;
                }

                $raw = (string) ($node->textContent ?? '');
                try {
                    $text = trim(preg_replace('/\s+/u', ' ', $raw) ?? '');
                } catch (Throwable) {
                    $text = trim(preg_replace('/\s+/', ' ', $raw) ?? '');
                }
                if ($text === '') {
                    continue;
                }

                $id = $node->getAttribute('id') ?: Str::slug($text);
                if ($id === '') {
                    $id = 'section';
                }

                $base = $id;
                $n = 2;
                while (isset($used[$id])) {
                    $id = $base.'-'.$n;
                    $n++;
                }
                $used[$id] = true;
                $node->setAttribute('id', $id);

                $headings[] = [
                    'id' => $id,
                    'text' => $text,
                    'level' => (int) substr($node->tagName, 1) ?: 2,
                ];
            }
        }

        $inner = '';
        foreach ($root->childNodes as $child) {
            $inner .= $dom->saveHTML($child);
        }

        return [
            'html' => $inner !== '' ? $inner : $html,
            'headings' => $headings,
        ];
    }
}
