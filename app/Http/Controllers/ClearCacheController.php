<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class ClearCacheController extends Controller
{
    public function __invoke(Request $request, ?string $token = null): Response
    {
        $expected = (string) config('app.cache_clear_token', env('CACHE_CLEAR_TOKEN', ''));
        $provided = (string) ($token ?: $request->query('token', ''));

        if ($expected === '' || ! hash_equals($expected, $provided)) {
            abort(403, 'Invalid cache clear token.');
        }

        $cleared = [];

        $commands = [
            'optimize:clear',
            'cache:clear',
            'config:clear',
            'route:clear',
            'view:clear',
            'event:clear',
        ];

        foreach ($commands as $command) {
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

        $body = "Cache cleared at ".now()->toDateTimeString()."\n\n".implode("\n", $cleared)."\n";

        return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
