<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title') | {{ setting('site_name', 'LyoVial', 'general') }}</title>
    @php $favicon = \App\Support\SiteFavicon::resolve(); @endphp
    <link rel="icon" href="{{ $favicon['href'] }}" type="{{ $favicon['type'] }}">
    <link rel="shortcut icon" href="{{ $favicon['href'] }}" type="{{ $favicon['type'] }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $favicon['png32'] }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $favicon['png16'] }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $favicon['apple'] }}">
    <link rel="preload" href="{{ asset('assets/front/fonts/inter-latin-400.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/front/fonts/inter-latin-700.woff2') }}" as="font" type="font/woff2" crossorigin>
    <style>
        @font-face{
            font-family:'Inter';
            font-style:normal;
            font-weight:400;
            font-display:swap;
            src:url('{{ asset('assets/front/fonts/inter-latin-400.woff2') }}') format('woff2');
        }
        @font-face{
            font-family:'Inter';
            font-style:normal;
            font-weight:700;
            font-display:swap;
            src:url('{{ asset('assets/front/fonts/inter-latin-700.woff2') }}') format('woff2');
        }
        *,*::before,*::after{box-sizing:border-box}
        body{
            margin:0;
            min-height:100vh;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            padding:2rem 1.25rem;
            font-family:'Inter',system-ui,sans-serif;
            color:#4A5A67;
            background:#fff;
            text-align:center;
        }
        .error-logo{display:block;margin:0 auto 2rem;max-width:180px;height:auto}
        .error-code{
            margin:0 0 .5rem;
            font-size:clamp(3rem,12vw,4.5rem);
            font-weight:800;
            line-height:1;
            color:#0e7c86;
        }
        .error-message{
            margin:0 0 1.25rem;
            font-size:1.125rem;
            font-weight:600;
            color:#1a2b36;
        }
        .error-copy{
            margin:0 auto 2rem;
            max-width:28rem;
            font-size:1rem;
            line-height:1.6;
        }
        .error-actions{display:flex;flex-wrap:wrap;gap:.75rem;justify-content:center}
        .error-btn{
            display:inline-block;
            padding:.75rem 1.5rem;
            border-radius:999px;
            font-weight:600;
            font-size:.9375rem;
            text-decoration:none;
            transition:background .2s,color .2s;
        }
        .error-btn-primary{background:#0e7c86;color:#fff}
        .error-btn-primary:hover{background:#0a6269;color:#fff}
        .error-btn-secondary{background:#f0f4f6;color:#0e7c86}
        .error-btn-secondary:hover{background:#e2eaee}
    </style>
</head>
<body>
    @php
        $siteName = setting('site_name', 'LyoVial', 'general');
        $logoUrl = asset('images/site/favicon-icon.svg');
        $cmsLogo = setting('logo', null, 'general');
        if ($cmsLogo) {
            $relative = parse_url(storage_url($cmsLogo) ?: $cmsLogo, PHP_URL_PATH) ?: $cmsLogo;
            $full = public_path(ltrim($relative, '/'));
            if (is_file($full) && ! str_contains(strtolower(basename($relative)), 'logo-white')) {
                $logoUrl = asset(ltrim($relative, '/'));
            }
        }
    @endphp
    <a href="{{ url('/') }}">
        <img src="{{ $logoUrl }}" alt="{{ $siteName }}" class="error-logo" width="180" height="40" decoding="async">
    </a>
    @yield('content')
</body>
</html>
