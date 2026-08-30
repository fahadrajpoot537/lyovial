<?php

namespace App\Http\Middleware;

use App\Models\SeoRedirect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class HandleSeoRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is(config('admin.prefix', 'admin').'/*') || $request->is(config('admin.prefix', 'admin'))) {
            return $next($request);
        }

        if ($request->isMethod('GET') || $request->isMethod('HEAD')) {
            if (! Schema::hasTable('seo_redirects')) {
                return $next($request);
            }
            $path = SeoRedirect::normalizePath('/'.$request->path());

            $redirect = Cache::remember("seo.redirect.{$path}", 300, function () use ($path) {
                return SeoRedirect::query()->active()->where('from_path', $path)->first();
            });

            if ($redirect) {
                return redirect()->to($redirect->to_url, $redirect->status_code);
            }
        }

        return $next($request);
    }
}
