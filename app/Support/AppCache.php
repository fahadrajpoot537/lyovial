<?php

namespace App\Support;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class AppCache
{
    /**
     * @return list<string>
     */
    public static function clear(): array
    {
        $cleared = [];

        foreach ([
            'optimize:clear',
            'cache:clear',
            'config:clear',
            'route:clear',
            'view:clear',
            'event:clear',
        ] as $command) {
            try {
                Artisan::call($command);
                $cleared[] = $command.' OK';
            } catch (\Throwable $e) {
                $cleared[] = $command.' FAIL: '.$e->getMessage();
            }
        }

        foreach ([
            'home.sections',
            'app.settings',
            'sitemap.xml',
            'seo.head_scripts',
            'menus.header',
            'menus.footer',
        ] as $key) {
            Cache::forget($key);
            $cleared[] = 'forget:'.$key;
        }

        foreach ([
            base_path('bootstrap/cache/routes-v7.php'),
            base_path('bootstrap/cache/routes.php'),
            base_path('bootstrap/cache/config.php'),
            base_path('bootstrap/cache/services.php'),
            base_path('bootstrap/cache/packages.php'),
            base_path('bootstrap/cache/events.php'),
        ] as $file) {
            if (File::exists($file)) {
                File::delete($file);
                $cleared[] = 'deleted:'.basename($file);
            }
        }

        return $cleared;
    }
}
