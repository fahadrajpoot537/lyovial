<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HTML Sitemap | {{ setting('site_name', 'LyoVial', 'general') }}</title>
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/sitemap') }}">
    <style>
        body { font-family: Georgia, serif; max-width: 840px; margin: 40px auto; padding: 0 20px; color: #222; }
        h1 { font-size: 2rem; margin-bottom: .25rem; }
        h2 { margin-top: 2rem; font-size: 1.25rem; }
        ul { padding-left: 1.2rem; }
        a { color: #0b5; }
    </style>
</head>
<body>
    <h1>Sitemap</h1>
    <p>Browse key pages on {{ setting('site_name', 'LyoVial', 'general') }}.</p>

    <h2>Main</h2>
    <ul>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ url('/capabilities') }}">Capabilities</a></li>
        <li><a href="{{ url('/industries') }}">Industries</a></li>
        <li><a href="{{ url('/about') }}">About Us</a></li>
        <li><a href="{{ url('/quality-compliance') }}">Quality &amp; Compliance</a></li>
        <li><a href="{{ url('/specimen-library-preservation') }}">Specimen Library Preservation</a></li>
        <li><a href="{{ url('/contact') }}">Contact</a></li>
    </ul>

    @if ($pages->isNotEmpty())
        <h2>Pages</h2>
        <ul>
            @foreach ($pages as $page)
                <li><a href="{{ url('/'.$page->slug) }}">{{ $page->seo?->breadcrumb_title ?: $page->title }}</a></li>
            @endforeach
        </ul>
    @endif

    @if ($services->isNotEmpty())
        <h2>Services</h2>
        <ul>
            @foreach ($services as $service)
                <li><a href="{{ url('/capabilities/'.$service->slug) }}">{{ $service->seo?->breadcrumb_title ?: $service->title }}</a></li>
            @endforeach
        </ul>
    @endif

    @if ($industries->isNotEmpty())
        <h2>Industries</h2>
        <ul>
            @foreach ($industries as $industry)
                <li><a href="{{ url('/industries/'.$industry->slug) }}">{{ $industry->seo?->breadcrumb_title ?: $industry->title }}</a></li>
            @endforeach
        </ul>
    @endif
</body>
</html>
