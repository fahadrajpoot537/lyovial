<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Str;

class SeoHelper
{
    /**
     * Fix localhost /services leftovers in stored canonicals for live hosts.
     */
    public static function normalizePublicUrl(string $url): string
    {
        if ($url === '') {
            return url()->current();
        }

        $url = preg_replace('#/services(?=/|$)#', '/capabilities', $url) ?? $url;

        $host = parse_url($url, PHP_URL_HOST);
        if (in_array($host, ['localhost', '127.0.0.1'], true) || blank($host)) {
            $path = parse_url($url, PHP_URL_PATH) ?: '/';
            $query = parse_url($url, PHP_URL_QUERY);
            $url = url($path.($query ? '?'.$query : ''));
        }

        return $url;
    }

    public static function fields(): array
    {
        return [
            'seo_title',
            'browser_title',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'canonical_url',
            'slug',
            'focus_keyword',
            'secondary_keywords',
            'schema_json',
            'structured_data_type',
            'og_title',
            'og_description',
            'og_image',
            'twitter_title',
            'twitter_description',
            'twitter_image',
            'twitter_card',
            'robots_meta',
            'breadcrumb_title',
            'h1_title',
            'author',
            'publish_date',
            'seo_updated_date',
            'reading_time',
            'indexable',
            'followable',
        ];
    }

    public static function validationRules(bool $slugRequired = false, bool $includeSlug = true): array
    {
        $rules = [
            'seo_title' => ['nullable', 'string', 'max:255'],
            'browser_title' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'canonical_url' => ['nullable', 'url', 'max:500'],
            'focus_keyword' => ['nullable', 'string', 'max:150'],
            'secondary_keywords' => ['nullable', 'string', 'max:500'],
            'schema_json' => ['nullable', 'string'],
            'structured_data_type' => ['nullable', 'string', 'max:100'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable'],
            'og_image_upload' => ['nullable', 'image', 'max:5120'],
            'twitter_title' => ['nullable', 'string', 'max:255'],
            'twitter_description' => ['nullable', 'string', 'max:500'],
            'twitter_image' => ['nullable'],
            'twitter_image_upload' => ['nullable', 'image', 'max:5120'],
            'twitter_card' => ['nullable', 'string', 'max:50'],
            'robots_meta' => ['nullable', 'string', 'max:100'],
            'breadcrumb_title' => ['nullable', 'string', 'max:255'],
            'h1_title' => ['nullable', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'publish_date' => ['nullable', 'date'],
            'seo_updated_date' => ['nullable', 'date'],
            'reading_time' => ['nullable', 'integer', 'min:0', 'max:600'],
            'indexable' => ['nullable', 'boolean'],
            'followable' => ['nullable', 'boolean'],
        ];

        if ($includeSlug) {
            $rules['slug'] = [$slugRequired ? 'required' : 'nullable', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'];
        }

        return $rules;
    }

    public static function extract(array $data): array
    {
        $seo = collect($data)->only(self::fields())->toArray();
        $seo['indexable'] = filter_var($seo['indexable'] ?? true, FILTER_VALIDATE_BOOLEAN);
        $seo['followable'] = filter_var($seo['followable'] ?? true, FILTER_VALIDATE_BOOLEAN);

        if (! empty($seo['schema_json'])) {
            $decoded = json_decode($seo['schema_json'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $seo['schema_json'] = json_encode($decoded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            } else {
                $seo['schema_json'] = strip_tags($seo['schema_json']);
            }
        }

        foreach (['seo_title', 'browser_title', 'meta_title', 'meta_description', 'meta_keywords', 'focus_keyword', 'secondary_keywords', 'og_title', 'og_description', 'twitter_title', 'twitter_description', 'breadcrumb_title', 'h1_title', 'author', 'robots_meta'] as $key) {
            if (isset($seo[$key]) && is_string($seo[$key])) {
                $seo[$key] = trim(strip_tags($seo[$key]));
            }
        }

        return $seo;
    }

    public static function defaults(): array
    {
        return [
            'meta_title' => Setting::get('default_meta_title', Setting::get('site_name', config('app.name')), 'seo'),
            'meta_description' => Setting::get('default_meta_description', null, 'seo'),
            'meta_keywords' => Setting::get('default_meta_keywords', null, 'seo'),
            'og_title' => Setting::get('default_og_title', null, 'seo'),
            'og_description' => Setting::get('default_og_description', null, 'seo'),
            'og_image' => Setting::get('default_og_image', null, 'seo'),
            'twitter_title' => Setting::get('default_twitter_title', Setting::get('default_og_title', null, 'seo'), 'seo'),
            'twitter_description' => Setting::get('default_twitter_description', Setting::get('default_og_description', null, 'seo'), 'seo'),
            'twitter_image' => Setting::get('default_twitter_image', Setting::get('default_og_image', null, 'seo'), 'seo'),
            'twitter_card' => Setting::get('default_twitter_card', 'summary_large_image', 'seo'),
            'canonical_url' => Setting::get('default_canonical_url', url('/'), 'seo'),
        ];
    }

    public static function schemaTypes(): array
    {
        return [
            'Organization' => 'Organization',
            'LocalBusiness' => 'Local Business',
            'WebPage' => 'Web Page',
            'ContactPage' => 'Contact Page',
            'Service' => 'Service',
            'FAQPage' => 'FAQ',
            'BreadcrumbList' => 'Breadcrumb',
            'Article' => 'Article',
            'Product' => 'Product (Future Ready)',
        ];
    }

    public static function slugify(string $value): string
    {
        return Str::slug($value);
    }

    /**
     * Build a live SEO score and recommendations from form/meta values.
     *
     * @param  array<string, mixed>  $data
     * @return array{score:int,grade:string,checks:array<int,array{key:string,label:string,status:string,message:string}>}
     */
    public static function analyze(array $data): array
    {
        $title = (string) ($data['meta_title'] ?: $data['seo_title'] ?: $data['browser_title'] ?: '');
        $description = (string) ($data['meta_description'] ?? '');
        $focus = (string) ($data['focus_keyword'] ?? '');
        $slug = (string) ($data['slug'] ?? '');
        $canonical = (string) ($data['canonical_url'] ?? '');
        $schema = (string) ($data['schema_json'] ?? '');
        $ogTitle = (string) ($data['og_title'] ?? '');
        $ogDesc = (string) ($data['og_description'] ?? '');
        $ogImage = (string) ($data['og_image'] ?? '');
        $twitterTitle = (string) ($data['twitter_title'] ?? '');
        $h1 = (string) ($data['h1_title'] ?? '');

        $checks = [];
        $score = 0;
        $max = 0;

        $add = function (string $key, string $label, bool $pass, string $ok, string $fail, int $weight = 10) use (&$checks, &$score, &$max): void {
            $max += $weight;
            if ($pass) {
                $score += $weight;
            }
            $checks[] = [
                'key' => $key,
                'label' => $label,
                'status' => $pass ? 'pass' : 'fail',
                'message' => $pass ? $ok : $fail,
            ];
        };

        $titleLen = mb_strlen($title);
        $add('title', 'Title length', $titleLen >= 30 && $titleLen <= 60, 'Title length is optimal (30–60).', 'Aim for 30–60 characters in the meta/SEO title.', 15);
        $descLen = mb_strlen($description);
        $add('description', 'Meta description', $descLen >= 120 && $descLen <= 160, 'Meta description length is optimal.', 'Aim for 120–160 characters in the meta description.', 15);
        $add('focus', 'Focus keyword', $focus !== '', 'Focus keyword is set.', 'Add a focus keyword.', 10);
        if ($focus !== '') {
            $inTitle = Str::contains(Str::lower($title), Str::lower($focus));
            $add('focus_title', 'Keyword in title', $inTitle, 'Focus keyword appears in the title.', 'Include the focus keyword in the title.', 10);
            $inDesc = Str::contains(Str::lower($description), Str::lower($focus));
            $add('focus_desc', 'Keyword in description', $inDesc, 'Focus keyword appears in the description.', 'Include the focus keyword in the meta description.', 5);
        }
        $add('h1', 'H1 title', $h1 !== '', 'H1 title is set.', 'Set an H1 title for clearer heading structure.', 5);
        $add('slug', 'Slug', $slug === '' || (bool) preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug), 'Slug is URL-friendly.', 'Use a lowercase hyphenated slug.', 5);
        $add('canonical', 'Canonical URL', $canonical !== '', 'Canonical URL is set.', 'Add a canonical URL.', 10);
        $add('schema', 'Schema JSON-LD', $schema !== '', 'Schema markup is present.', 'Add JSON-LD schema for rich results.', 10);
        $add('og', 'Open Graph', $ogTitle !== '' && $ogDesc !== '' && $ogImage !== '', 'Open Graph fields look complete.', 'Complete OG title, description, and image.', 10);
        $add('twitter', 'Twitter card', $twitterTitle !== '' || $ogTitle !== '', 'Twitter card fields are covered.', 'Add Twitter title or rely on OG title.', 5);

        $pct = $max > 0 ? (int) round(($score / $max) * 100) : 0;
        $grade = match (true) {
            $pct >= 85 => 'Excellent',
            $pct >= 70 => 'Good',
            $pct >= 50 => 'Needs work',
            default => 'Poor',
        };

        return [
            'score' => $pct,
            'grade' => $grade,
            'checks' => $checks,
        ];
    }

    public static function organizationSchema(): array
    {
        $name = Setting::get('organization_name', Setting::get('site_name', 'LyoVial', 'general'), 'seo');
        $logo = Setting::get('organization_logo', Setting::get('logo', null, 'general'), 'seo');
        $phone = Setting::get('organization_phone', Setting::get('phone', null, 'general'), 'seo');
        $email = Setting::get('organization_email', Setting::get('email', null, 'general'), 'seo');
        $address = Setting::get('organization_address', Setting::get('address', null, 'general'), 'seo');

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $name,
            'url' => url('/'),
        ];

        if ($logo) {
            $schema['logo'] = storage_url($logo);
        }
        if ($phone) {
            $schema['telephone'] = $phone;
        }
        if ($email) {
            $schema['email'] = $email;
        }
        if ($address) {
            $schema['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => strip_tags((string) $address),
            ];
        }

        return $schema;
    }
}
