<?php

namespace App\Console\Commands;

use App\Models\SeoMeta;
use App\Support\SeoHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class FixLiveFrontCommand extends Command
{
    protected $signature = 'lyovial:fix-live-front';

    protected $description = 'Clear caches and rewrite localhost/services SEO URLs for production';

    public function handle(): int
    {
        $n = 0;
        foreach (SeoMeta::query()->whereNotNull('canonical_url')->get() as $meta) {
            $before = (string) $meta->canonical_url;
            $after = SeoHelper::normalizePublicUrl($before);
            // Prefer production host when APP_URL is set to lyovial.com
            $after = str_replace(
                ['http://localhost', 'https://localhost', 'http://127.0.0.1:8000', 'http://127.0.0.1'],
                [rtrim((string) config('app.url'), '/'), rtrim((string) config('app.url'), '/'), rtrim((string) config('app.url'), '/'), rtrim((string) config('app.url'), '/')],
                $after
            );
            $after = preg_replace('#/services(?=/|$)#', '/capabilities', $after) ?? $after;
            if ($after !== $before) {
                $meta->canonical_url = $after;
                $meta->save();
                $n++;
                $this->line("seo #{$meta->id}: {$before} => {$after}");
            }
        }

        foreach (['header', 'footer'] as $location) {
            Cache::forget("menus.{$location}");
        }
        Cache::forget('home.sections');
        Cache::forget('app.settings');
        Cache::forget('sitemap.xml');

        // Drop compiled route/config cache files if present
        foreach ([
            base_path('bootstrap/cache/routes-v7.php'),
            base_path('bootstrap/cache/routes.php'),
            base_path('bootstrap/cache/config.php'),
        ] as $file) {
            if (File::exists($file)) {
                File::delete($file);
                $this->warn('Deleted '.$file);
            }
        }

        Artisan::call('optimize:clear');
        $this->info(trim(Artisan::output()));
        $this->info("Updated {$n} SEO canonical URLs.");
        $this->info('Done. Verify: /capabilities and /about');

        return self::SUCCESS;
    }
}
