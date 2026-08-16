<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $seo = $seo ?? null;
        $metaTitle = $seo?->meta_title ?? $seo?->seo_title ?? ($defaultSeo['default_meta_title'] ?? $siteName);
        $metaDescription = $seo?->meta_description ?? ($defaultSeo['default_meta_description'] ?? '');
        $metaKeywords = $seo?->meta_keywords ?? ($defaultSeo['default_meta_keywords'] ?? '');
        $canonical = $seo?->canonical_url ?? url()->current();
        $canonical = \App\Support\SeoHelper::normalizePublicUrl((string) $canonical);
        $ogTitle = $seo?->og_title ?? $metaTitle;
        $ogDescription = $seo?->og_description ?? $metaDescription;
        $ogImage = storage_url($seo?->og_image ?? ($defaultSeo['default_og_image'] ?? null));
        $robots = $seo?->robots_meta ?: ((($seo?->indexable ?? true) ? 'index' : 'noindex').', '.(($seo?->followable ?? true) ? 'follow' : 'nofollow'));
        $twitterImage = storage_url($seo?->twitter_image) ?: $ogImage;
    @endphp

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    @if($metaKeywords)<meta name="keywords" content="{{ $metaKeywords }}">@endif
    <meta name="robots" content="{{ $robots }}">
    <link rel="canonical" href="{{ $canonical }}">

    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonical }}">
    @if($ogImage)<meta property="og:image" content="{{ $ogImage }}">@endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo?->twitter_title ?? $ogTitle }}">
    <meta name="twitter:description" content="{{ $seo?->twitter_description ?? $ogDescription }}">
    @if($twitterImage)
        <meta name="twitter:image" content="{{ $twitterImage }}">
    @endif

    @if(!empty($seo?->schema_json))
        <script type="application/ld+json">{!! $seo->schema_json !!}</script>
    @endif

    @include('front.partials.favicon')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/front/css/site.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    @include('front.partials.header')

    <main>
        @if(session('success'))
            <div class="container pt-3">
                <div class="alert alert-success mb-0">{{ session('success') }}</div>
            </div>
        @endif
        @yield('content')
    </main>

    @include('front.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
