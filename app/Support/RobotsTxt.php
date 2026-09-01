<?php

namespace App\Support;

class RobotsTxt
{
    public const DEFAULT_BODY = "User-agent: *\nAllow: /";

    public static function build(?string $custom = null): string
    {
        $lines = [];
        $custom = trim((string) $custom);

        if ($custom === '') {
            $lines = ['User-agent: *', 'Allow: /'];
        } else {
            foreach (preg_split('/\r\n|\r|\n/', $custom) as $line) {
                $trimmed = trim($line);
                if ($trimmed === '') {
                    if ($lines !== [] && end($lines) !== '') {
                        $lines[] = '';
                    }

                    continue;
                }
                if (stripos($trimmed, 'Sitemap:') === 0) {
                    continue;
                }
                $lines[] = $trimmed;
            }
        }

        if (! self::hasDirective($lines, 'User-agent')) {
            array_unshift($lines, 'User-agent: *');
        }
        if (! self::hasDirective($lines, 'Allow') && ! self::hasDirective($lines, 'Disallow')) {
            $lines[] = 'Allow: /';
        }

        while ($lines !== [] && end($lines) === '') {
            array_pop($lines);
        }

        $lines[] = '';
        $lines[] = 'Sitemap: '.self::sitemapUrl();

        return implode("\n", $lines)."\n";
    }

    public static function sitemapUrl(): string
    {
        $host = strtolower((string) (request()->getHost() ?: parse_url((string) config('app.url'), PHP_URL_HOST)));

        if (in_array($host, ['lyovial.com', 'www.lyovial.com'], true)) {
            return 'https://lyovial.com/sitemap.xml';
        }

        $base = rtrim((string) config('app.url', url('/')), '/');
        if (in_array(parse_url($base, PHP_URL_HOST), ['lyovial.com', 'www.lyovial.com'], true)) {
            return 'https://lyovial.com/sitemap.xml';
        }

        return $base.'/sitemap.xml';
    }

    /**
     * @param  list<string>  $lines
     */
    private static function hasDirective(array $lines, string $name): bool
    {
        $prefix = strtolower($name).':';

        foreach ($lines as $line) {
            if (str_starts_with(strtolower(ltrim($line)), $prefix)) {
                return true;
            }
        }

        return false;
    }
}
