@extends('front.layouts.lyovial-home')

@php
    use App\Support\ThemePageDefaults;
    use App\Support\SiteImages;
    $seo = $service->seo;
    $x = ThemePageDefaults::mergeService($service->extra ?? null, $service->slug);
    $bannerTitle = $service->page_heading ?: $service->title;
    $lead = $service->short_description ?: '';
    $introHeading = !empty($x['intro_heading']) ? $x['intro_heading'] : ($service->page_heading ?: $service->title);
    $sidebarServices = $sidebarServices ?? collect();

    $bannerImage = SiteImages::resolve($service->banner_image, SiteImages::serviceBanner($service->slug));
    $featureImg = SiteImages::resolve($service->featured_image, SiteImages::serviceFeature($service->slug));
@endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])
@include('front.partials.page-banner', [
    'bannerTitle' => $bannerTitle,
    'bannerImage' => $bannerImage,
])

<link rel="stylesheet" href="{{ asset('assets/front/css/lyovial-theme-pages.css') }}">

<div class="lv-theme">
  <div class="service-layout">
    <div class="container">
      <div class="main-content">
        <div class="feature-image">
          <img src="{{ $featureImg }}" alt="{{ $service->title }}">
        </div>

        @if(!empty($x['eyebrow']))
          <div class="eyebrow">{{ $x['eyebrow'] }}</div>
        @endif
        <h2>{{ $introHeading }}</h2>
        @if($lead)
          <p class="lead">{{ $lead }}</p>
        @elseif($service->long_description)
          <div class="lead">{!! $service->long_description !!}</div>
        @endif

        @if(!empty($x['includes']))
          <h3 class="heading-bold" style="font-size:19px;margin-bottom:18px;">{{ $x['includes_heading'] ?: 'What This Service Includes' }}</h3>
          <div class="includes-grid">
            @foreach($x['includes'] as $card)
              @continue(empty($card['title']))
              <div class="include-card">
                <div class="icon"><i class="bi bi-check-lg"></i></div>
                <h4 class="heading-bold">{{ $card['title'] }}</h4>
                <p>{{ $card['body'] ?? '' }}</p>
              </div>
            @endforeach
          </div>
        @endif

        @if(!empty($x['why_bullets']))
          <div class="why-block">
            <h3 class="heading-bold">{{ $x['why_heading'] ?: 'Why This Matters for Your Project' }}</h3>
            <ul>
              @foreach($x['why_bullets'] as $bullet)
                @continue(!filled($bullet))
                <li><i class="bi bi-check2" style="color:var(--green-500)"></i> {{ $bullet }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if(!empty($x['steps']))
          <h4 class="heading-bold" style="font-size:19px;margin-bottom:6px;">{{ $x['steps_heading'] ?: 'How It Works' }}</h4>
          @if(!empty($x['steps_intro']))
            <p style="font-size:14px;margin-bottom:22px;">{{ $x['steps_intro'] }}</p>
          @endif
          <div class="steps-row">
            @foreach($x['steps'] as $step)
              @continue(empty($step['title']))
              <div class="step-sm">
                <div class="num">{{ $step['num'] ?? str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                <h4 class="heading-bold">{{ $step['title'] }}</h4>
                <p>{{ $step['body'] ?? '' }}</p>
              </div>
            @endforeach
          </div>
        @endif

        @if($others->count())
          <div class="related">
            <h3 class="heading-bold">{{ $x['related_heading'] ?: 'Related Services' }}</h3>
            <div class="related-grid">
              @foreach($others->take(2) as $other)
                <a class="related-card" href="{{ url('/capabilities/'.$other->slug) }}">
                  <div class="icon"><i class="bi bi-arrow-right"></i></div>
                  <h4 class="heading-bold">{{ $other->title }}</h4>
                </a>
              @endforeach
            </div>
          </div>
        @endif

        <div class="bottom-cta" style="--cta-bg-image:url('{{ $bannerImage }}')">
          <div>
            <h3 class="heading-bold">{{ $x['bottom_cta_heading'] ?: 'Ready to talk?' }}</h3>
            <p>{{ $x['bottom_cta_body'] ?? '' }}</p>
          </div>
          <a href="{{ url($service->button_link ?: '/contact') }}" class="btn">{{ $x['bottom_cta_button'] ?: ($service->button_text ?: 'Request a Quote') }}</a>
        </div>
      </div>

      <aside class="sidebar">
        <div>
          <ul class="service-list">
            @foreach($sidebarServices as $item)
              <li>
                <a href="{{ $item['url'] }}" @class(['active' => $item['active'] ?? false])>{{ $item['title'] }}</a>
              </li>
            @endforeach
          </ul>
        </div>

        <div class="cta-box" id="quote" style="--cta-bg-image:url('{{ $featureImg }}')">
          <h4 class="heading-bold">{{ $x['sidebar_cta_title'] }}</h4>
          <p>{{ $x['sidebar_cta_body'] }}</p>
          <a href="{{ url($service->button_link ?: '/contact') }}" class="btn block">{{ $x['sidebar_cta_button'] ?: ($service->button_text ?: 'Request a Quote') }}</a>
        </div>

        <div class="contact-box">
          <h4 class="heading-bold">Get In Touch</h4>
          <ul>
            @if($sitePhone)
              <li>
                <i class="bi bi-telephone" style="color:var(--green-500)"></i>
                <div>
                  <strong><a href="tel:{{ preg_replace('/\D+/', '', $sitePhone) }}">{{ $sitePhone }}</a></strong>
                  Mon–Fri, 9am–6pm
                </div>
              </li>
            @endif
            @if($siteEmail)
              <li>
                <i class="bi bi-envelope" style="color:var(--green-500)"></i>
                <div>
                  <strong><a href="mailto:{{ $siteEmail }}">{{ $siteEmail }}</a></strong>
                  We reply within 1 business day
                </div>
              </li>
            @endif
          </ul>
        </div>
      </aside>
    </div>
  </div>
</div>
@endsection
