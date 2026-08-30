<?php

namespace App\Http\Controllers;

use App\Support\AppCache;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClearCacheController extends Controller
{
    public function __invoke(Request $request, ?string $token = null): Response
    {
        $expected = (string) config('app.cache_clear_token', env('CACHE_CLEAR_TOKEN', ''));
        $provided = (string) ($token ?: $request->query('token', ''));

        if ($expected === '' || ! hash_equals($expected, $provided)) {
            abort(403, 'Invalid cache clear token.');
        }

        $cleared = AppCache::clear();
        $body = 'Cache cleared at '.now()->toDateTimeString()."\n\n".implode("\n", $cleared)."\n";

        return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
