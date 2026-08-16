<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Enforces HTTPS + apex canonical host for production (lyovial.com).
 * Prefer Apache (.htaccess); this is the Laravel safety net.
 * Single-hop 301 only — no redirect chains.
 */
class EnforceCanonicalHomepage
{
    private const CANONICAL_HOST = 'lyovial.com';

    private const CANONICAL_URL = 'https://lyovial.com';

    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return $next($request);
        }

        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        $host = strtolower($request->getHost());
        $allowed = [self::CANONICAL_HOST, 'www.'.self::CANONICAL_HOST];

        if (! in_array($host, $allowed, true)) {
            return $next($request);
        }

        $path = '/'.trim($request->getPathInfo(), '/');
        if ($path === '//') {
            $path = '/';
        }
        if ($path !== '/') {
            $path = rtrim($path, '/') ?: '/';
        }

        $isHomepagePath = $this->isHomepageDuplicatePath($path);
        $isWww = $host === 'www.'.self::CANONICAL_HOST;
        $isHttp = ! $request->secure();
        $hasQuery = $request->getQueryString() !== null && $request->getQueryString() !== '';

        // Homepage duplicates always land on exact canonical URL (one hop)
        if ($isHomepagePath && ($isWww || $isHttp || $hasQuery || $path !== '/')) {
            return redirect()->away(self::CANONICAL_URL, 301);
        }

        // Bare apex homepage over HTTPS — already canonical
        if ($path === '/' && ! $isWww && ! $isHttp) {
            return $next($request);
        }

        // HTTP and/or www on any other path → https://lyovial.com{path}?{query}
        if ($isWww || $isHttp) {
            $target = self::CANONICAL_URL.($request->getPathInfo() === '/' ? '' : $request->getPathInfo());
            if ($hasQuery) {
                $target .= '?'.$request->getQueryString();
            }

            return redirect()->away($target, 301);
        }

        return $next($request);
    }

    private function shouldSkip(Request $request): bool
    {
        $admin = trim((string) config('admin.prefix', 'admin'), '/');

        // Still force HTTPS/www for admin on production host (security),
        // but never strip admin paths to the homepage.
        return $request->is('api')
            || $request->is('api/*')
            || $request->is('sanctum/*')
            || $request->is('up');
    }

    private function isHomepageDuplicatePath(string $path): bool
    {
        if ($path === '/' || $path === '') {
            return true;
        }

        if ($path === '/index.php' || str_starts_with($path, '/index.php/')) {
            return true;
        }

        return $path === '/public';
    }
}
