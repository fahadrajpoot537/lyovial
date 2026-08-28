@extends('front.layouts.lyovial-home')

@php
    use App\Support\ThemePageDefaults;
    use App\Support\SiteImages;

    $seo = $page->seo ?? null;
    $x = ThemePageDefaults::mergePage($page->extra ?? null, \App\Models\Page::TYPE_ABOUT);
    $defaults = ThemePageDefaults::aboutExtra();

    $heroSrc = SiteImages::resolve($page->banner_image ?: ($x['hero_image'] ?? null), $defaults['hero_image']);
    $originSrc = SiteImages::resolve($x['origin_image'] ?? null, $defaults['origin_image']);
    $expertiseSrc = SiteImages::resolve($x['expertise_image'] ?? null, $defaults['expertise_image']);

    $heroAlt = $x['hero_image_alt'] ?? $defaults['hero_image_alt'];
    $originAlt = $x['origin_image_alt'] ?? $defaults['origin_image_alt'];
    $expertiseAlt = $x['expertise_image_alt'] ?? $defaults['expertise_image_alt'];

    $heroIsDefault = str_contains($heroSrc, 'lyovial-freeze-drying-facility-kanata-north-ottawa');
    $originIsDefault = str_contains($originSrc, 'lyovial-pilot-scale-freeze-drying-development');
    $expertiseIsDefault = str_contains($expertiseSrc, 'lyovial-thermal-assessment-cryoprotectant-selection');

    $ctaLink = $x['cta_link'] ?? '/contact';
    if ($ctaLink && ! str_starts_with($ctaLink, 'http') && ! str_starts_with($ctaLink, '#')) {
        $ctaLink = url($ctaLink);
    }
@endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => false])
<link rel="stylesheet" href="{{ asset('assets/front/css/lyovial-about.css') }}?v={{ filemtime(public_path('assets/front/css/lyovial-about.css')) }}">

<div class="lv-about">
  <section class="lv-about-hero">
    <div class="lv-about-hero-media" aria-hidden="true">
      @if($heroIsDefault)
        <picture>
          <source type="image/webp"
                  srcset="{{ asset('images/site/lyovial-freeze-drying-facility-kanata-north-ottawa-1280.webp') }} 1280w,
                          {{ asset('images/site/lyovial-freeze-drying-facility-kanata-north-ottawa-1920.webp') }} 1920w"
                  sizes="100vw">
          <img src="{{ asset('images/site/lyovial-freeze-drying-facility-kanata-north-ottawa-1920.jpg') }}"
               srcset="{{ asset('images/site/lyovial-freeze-drying-facility-kanata-north-ottawa-1280.jpg') }} 1280w,
                       {{ asset('images/site/lyovial-freeze-drying-facility-kanata-north-ottawa-1920.jpg') }} 1920w"
               sizes="100vw"
               width="1920" height="1080"
               alt=""
               decoding="async">
        </picture>
      @else
        <img src="{{ $heroSrc }}" alt="" decoding="async">
      @endif
    </div>
    <div class="lv-about-hero-overlay"></div>
    <div class="container">
      @if(!empty($x['hero_eyebrow']))
        <p class="lv-about-eyebrow">{{ $x['hero_eyebrow'] }}</p>
      @endif
      <h1>{!! nl2br(e($x['hero_heading'] ?: ($page->heading ?: 'About LyoVial'))) !!}</h1>
      @if(!empty($x['hero_sub']))
        <p class="lv-about-sub">{{ $x['hero_sub'] }}</p>
      @endif
    </div>
  </section>

  @if(!empty($x['cards']))
    <div class="container">
      <div class="lv-about-cards">
        @foreach($x['cards'] as $card)
          @continue(empty($card['title']))
          <div class="lv-about-card">
            <h3>{{ $card['title'] }}</h3>
            @if(!empty($card['text']))<p>{{ $card['text'] }}</p>@endif
          </div>
        @endforeach
      </div>
    </div>
  @endif

  <div class="container">
    <div class="lv-about-row origin">
      <div>
        @if(!empty($x['origin_eyebrow']))<p class="lv-about-eyebrow">{{ $x['origin_eyebrow'] }}</p>@endif
        <h2>{!! nl2br(e($x['origin_heading'] ?? '')) !!}</h2>
        @if(!empty($x['origin_body']))<p class="lv-about-body">{{ $x['origin_body'] }}</p>@endif
        @if(!empty($x['origin_quote']))<div class="lv-about-quote">{{ $x['origin_quote'] }}</div>@endif
      </div>
      <div class="lv-about-media">
        @if($originIsDefault)
          <picture>
            <source type="image/webp"
                    srcset="{{ asset('images/site/lyovial-pilot-scale-freeze-drying-development-800.webp') }} 800w,
                            {{ asset('images/site/lyovial-pilot-scale-freeze-drying-development-1200.webp') }} 1200w"
                    sizes="(max-width:820px) 100vw, 50vw">
            <img src="{{ asset('images/site/lyovial-pilot-scale-freeze-drying-development-1200.jpg') }}"
                 srcset="{{ asset('images/site/lyovial-pilot-scale-freeze-drying-development-800.jpg') }} 800w,
                         {{ asset('images/site/lyovial-pilot-scale-freeze-drying-development-1200.jpg') }} 1200w"
                 sizes="(max-width:820px) 100vw, 50vw"
                 width="1200" height="1600"
                 alt="{{ $originAlt }}"
                 loading="lazy" decoding="async">
          </picture>
        @else
          <img src="{{ $originSrc }}" alt="{{ $originAlt }}" loading="lazy" decoding="async">
        @endif
      </div>
    </div>
  </div>

  <div class="container">
    <div class="lv-about-row expertise">
      <div class="lv-about-media">
        @if($expertiseIsDefault)
          <picture>
            <source type="image/webp"
                    srcset="{{ asset('images/site/lyovial-thermal-assessment-cryoprotectant-selection-1000.webp') }} 1000w,
                            {{ asset('images/site/lyovial-thermal-assessment-cryoprotectant-selection-1600.webp') }} 1600w"
                    sizes="(max-width:820px) 100vw, 50vw">
            <img src="{{ asset('images/site/lyovial-thermal-assessment-cryoprotectant-selection-1600.jpg') }}"
                 srcset="{{ asset('images/site/lyovial-thermal-assessment-cryoprotectant-selection-1000.jpg') }} 1000w,
                         {{ asset('images/site/lyovial-thermal-assessment-cryoprotectant-selection-1600.jpg') }} 1600w"
                 sizes="(max-width:820px) 100vw, 50vw"
                 width="1600" height="2133"
                 alt="{{ $expertiseAlt }}"
                 loading="lazy" decoding="async">
          </picture>
        @else
          <img src="{{ $expertiseSrc }}" alt="{{ $expertiseAlt }}" loading="lazy" decoding="async">
        @endif
      </div>
      <div>
        @if(!empty($x['expertise_eyebrow']))<p class="lv-about-eyebrow">{{ $x['expertise_eyebrow'] }}</p>@endif
        <h2>{!! nl2br(e($x['expertise_heading'] ?? '')) !!}</h2>
        @if(!empty($x['expertise_body']))<p class="lv-about-body">{{ $x['expertise_body'] }}</p>@endif
        @if(!empty($x['steps']))
          <div class="lv-about-steps">
            @foreach($x['steps'] as $i => $step)
              @continue(empty($step['title']))
              <div class="lv-about-step">
                <div class="num">{{ $step['num'] ?? str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                <div>
                  <h4>{{ $step['title'] }}</h4>
                  @if(!empty($step['body']))<p>{{ $step['body'] }}</p>@endif
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>

  @if(!empty($x['band_heading']) || !empty($x['band_body']) || !empty($x['band_tags']))
    <div class="container lv-about-band-wrap">
      <div class="lv-about-band">
        <div>
          @if(!empty($x['band_heading']))<h3>{{ $x['band_heading'] }}</h3>@endif
          @if(!empty($x['band_body']))<p>{{ $x['band_body'] }}</p>@endif
        </div>
        @if(!empty($x['band_tags']))
          <div class="lv-about-tags">
            @foreach($x['band_tags'] as $tag)
              @continue(!filled($tag))
              <span class="lv-about-tag">{{ $tag }}</span>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  @endif

  <div class="container">
    <section class="lv-about-work">
      @if(!empty($x['cta_eyebrow']))<p class="lv-about-eyebrow">{{ $x['cta_eyebrow'] }}</p>@endif
      @if(!empty($x['cta_heading']))<h2>{{ $x['cta_heading'] }}</h2>@endif
      @if(!empty($x['cta_body']))<p class="lv-about-body">{{ $x['cta_body'] }}</p>@endif
      @if(!empty($x['cta_button']))
        <a href="{{ $ctaLink }}" class="lv-about-btn">{{ $x['cta_button'] }}</a>
      @endif
    </section>
  </div>
</div>
@endsection
