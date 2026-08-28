@extends('front.layouts.lyovial-home')

@php
    use App\Support\ThemePageDefaults;
    use App\Support\SiteImages;
    $seo = $page->seo ?? null;
    $x = ThemePageDefaults::mergePage($page->extra ?? null, \App\Models\Page::TYPE_PRIVACY);
    $heading = $page->heading ?: $page->title ?: 'Privacy Policy';
    $bannerImage = SiteImages::resolve($page->banner_image, SiteImages::get('banner_default'));
    $content = filled($page->content) ? $page->content : ThemePageDefaults::privacyContent();
@endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => false])
@include('front.partials.page-banner', [
    'bannerTitle' => $heading,
    'bannerSubtitle' => 'How we collect, use, and protect your information',
    'bannerImage' => $bannerImage,
    'align' => 'start',
])

<section class="lv-legal">
    <div class="container">
        <div class="lv-legal-wrap">
            @if(filled($x['effective_date'] ?? null) || filled($x['last_updated'] ?? null) || filled($x['change_log'] ?? null))
                <p class="lv-legal-meta">
                    @if(filled($x['effective_date'] ?? null))
                        <span>Effective {{ $x['effective_date'] }}</span>
                    @endif
                    @if(filled($x['last_updated'] ?? null))
                        <span>Last updated {{ $x['last_updated'] }}</span>
                    @endif
                    @if(filled($x['change_log'] ?? null))
                        <span>Change log {{ $x['change_log'] }}</span>
                    @endif
                </p>
            @endif

            <div class="lv-legal-body">
                {!! $content !!}
            </div>

            @if(filled($x['last_updated'] ?? null) || filled($x['change_log'] ?? null))
                <p class="lv-legal-foot">
                    @if(filled($x['last_updated'] ?? null))
                        Last updated on {{ $x['last_updated'] }}.
                    @endif
                    @if(filled($x['change_log'] ?? null))
                        Change log: {{ $x['change_log'] }}
                    @endif
                </p>
            @endif
        </div>
    </div>
</section>
@endsection
