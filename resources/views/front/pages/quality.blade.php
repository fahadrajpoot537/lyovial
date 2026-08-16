@extends('front.layouts.lyovial-home')

@php
    use App\Support\ThemePageDefaults;
    use App\Support\SiteImages;
    $seo = $page->seo ?? null;
    $x = ThemePageDefaults::mergePage($page->extra ?? null, \App\Models\Page::TYPE_QUALITY_COMPLIANCE);
    $heading = $page->heading ?: $page->title;
    $bannerImage = SiteImages::resolve($page->banner_image, SiteImages::get('banner_quality'));
@endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])
@include('front.partials.page-banner', [
    'bannerTitle' => $page->title ?: 'Quality & Compliance',
    'bannerSubtitle' => $x['hero_eyebrow'] ?? null,
    'bannerImage' => $bannerImage,
])
<link rel="stylesheet" href="{{ asset('assets/front/css/lyovial-theme-pages.css') }}">

<div class="lv-theme">
  <section class="approach">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow" style="justify-content:center;">{{ $x['approach_eyebrow'] ?? '' }}</div>
        <h2 class="heading-bold">{{ $x['approach_heading'] ?: $heading }}</h2>
        @if(!empty($x['hero_sub']))
          <p style="color:var(--text-muted);margin-top:14px">{{ $x['hero_sub'] }}</p>
        @endif
      </div>
      <div class="approach-row">
        @foreach(($x['approach_cards'] ?? []) as $card)
          @continue(empty($card['title']))
          <div class="approach-card">
            <div class="ring"><i class="bi bi-star" style="font-size:26px"></i></div>
            <h4 class="heading-bold">{{ $card['title'] }}</h4>
            <p>{{ $card['body'] ?? '' }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section class="sterility">
    <div class="container">
      <div class="ring"><i class="bi bi-shield-lock" style="font-size:28px"></i></div>
      <h3 class="heading-bold">{{ $x['sterility_heading'] ?? '' }}</h3>
      <p>{{ $x['sterility_body'] ?? '' }}</p>
    </div>
  </section>

  <section class="fit">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow" style="justify-content:center;">{{ $x['fit_eyebrow'] ?? '' }}</div>
        <h2 class="heading-bold">{{ $x['fit_heading'] ?? '' }}</h2>
      </div>
      <div class="fit-grid">
        <div class="fit-col yes">
          <h4 class="heading-bold"><i class="bi bi-check2"></i> {{ $x['fit_yes_heading'] ?? 'Well Suited To' }}</h4>
          <ul>
            @foreach(($x['fit_yes'] ?? []) as $item)
              @continue(!filled($item))
              <li><i class="bi bi-check2"></i> {{ $item }}</li>
            @endforeach
          </ul>
        </div>
        <div class="fit-col no">
          <h4 class="heading-bold"><i class="bi bi-x-lg"></i> {{ $x['fit_no_heading'] ?? 'Not a Substitute For' }}</h4>
          <ul>
            @foreach(($x['fit_no'] ?? []) as $item)
              @continue(!filled($item))
              <li><i class="bi bi-x-lg"></i> {{ $item }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </section>

  @if(!empty($x['quote']))
  <div class="quote-banner">
    <blockquote>"{{ $x['quote'] }}"</blockquote>
    <span>{{ $x['quote_label'] ?? '' }}</span>
  </div>
  @endif

  <div class="cta-final" id="contact">
    <h3>{{ $x['cta_heading'] ?? '' }}</h3>
    <p>{{ $x['cta_body'] ?? '' }}</p>
    <a href="{{ route('contact') }}" class="btn">{{ $x['cta_button'] ?: 'Ask Us Directly' }}</a>
  </div>
</div>
@endsection
