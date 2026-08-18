@extends('front.layouts.lyovial-home')

@php
    use App\Support\ThemePageDefaults;
    use App\Support\SiteImages;
    $seo = $page->seo ?? null;
    $x = ThemePageDefaults::mergePage($page->extra ?? null, \App\Models\Page::TYPE_SPECIMEN_LIBRARY);
    $heading = $page->heading ?: $page->title;
    $bannerImage = SiteImages::resolve($page->banner_image, SiteImages::get('banner_specimen'));
@endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])
@include('front.partials.page-banner', [
    'bannerTitle' => $page->title ?: 'Specimen Library Preservation',
    'bannerSubtitle' => $x['hero_eyebrow'] ?? null,
    'bannerImage' => $bannerImage,
    'align' => 'start',
])
<link rel="stylesheet" href="{{ asset('assets/front/css/lyovial-theme-pages.css') }}">

<div class="lv-theme">
  @if(!empty($x['hero_sub']))
  <section class="approach" style="padding:50px 0 20px">
    <div class="container">
      <h2 style="font-size:28px;color:var(--navy-900);margin-bottom:14px">{{ $heading }}</h2>
      <p style="color:var(--text-muted)">{{ $x['hero_sub'] }}</p>
      <a href="{{ route('contact') }}" class="btn" style="margin-top:18px">{{ $x['hero_button'] ?: 'Talk to Us About Your Collection' }}</a>
    </div>
  </section>
  @endif

  @if(!empty($x['benefits']))
  <div class="benefit-strip">
    <div class="container">
      @php
        $benefitIcons = ['bi-truck', 'bi-piggy-bank', 'bi-shield-check', 'bi-clock-history'];
      @endphp
      @foreach($x['benefits'] as $benefit)
        @continue(empty($benefit['title']))
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="bi {{ $benefitIcons[$loop->index] ?? 'bi-check-circle' }}"></i>
          </div>
          <h4>{{ $benefit['title'] }}</h4>
        </div>
      @endforeach
    </div>
  </div>
  @endif

  <section class="challenge">
    <div class="container">
      <div>
        <div class="eyebrow">{{ $x['challenge_eyebrow'] ?? '' }}</div>
        <h2>{{ $x['challenge_heading'] ?? '' }}</h2>
        <p>{{ $x['challenge_body'] ?? '' }}</p>
      </div>
      <div class="challenge-visual" style="background:url('{{ SiteImages::get('home_facility') }}') center/cover no-repeat">
        <div class="pulse-dot"></div>
      </div>
    </div>
  </section>

  <section class="solution">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow">{{ $x['solution_eyebrow'] ?? '' }}</div>
        <h2>{{ $x['solution_heading'] ?? '' }}</h2>
      </div>
      @foreach(($x['solution_steps'] ?? []) as $step)
        @continue(empty($step['title']))
        <div @class(['zig', 'reverse' => $loop->iteration % 2 === 0])>
          <div class="zig-text">
            <div class="zig-num">{{ $step['label'] ?? ('Step '.$loop->iteration) }}</div>
            <h3>{{ $step['title'] }}</h3>
            <p>{{ $step['body'] ?? '' }}</p>
          </div>
          <div class="zig-visual" style="background:url('{{ SiteImages::industryImage($loop->index) }}') center/cover no-repeat"></div>
        </div>
      @endforeach
    </div>
  </section>

  @if(!empty($x['stats']))
  <div class="statband">
    <div class="container">
      @php
        $statIcons = ['bi-box-seam', 'bi-thermometer-half', 'bi-clipboard-data', 'bi-hdd-rack'];
      @endphp
      @foreach($x['stats'] as $stat)
        @continue(!filled($stat))
        <div class="statband-item">
          <div class="statband-icon">
            <i class="bi {{ $statIcons[$loop->index] ?? 'bi-check2-circle' }}"></i>
          </div>
          <h4>{{ $stat }}</h4>
        </div>
      @endforeach
    </div>
  </div>
  @endif

  @if(!empty($x['faqs']))
  <section class="faq">
    <div class="container">
    <div class="section-head" style="margin-bottom:36px;">
      <div class="eyebrow">{{ $x['faq_eyebrow'] ?? '' }}</div>
      <h2>{{ $x['faq_heading'] ?? '' }}</h2>
    </div>
    @foreach($x['faqs'] as $faq)
      @continue(empty($faq['question']))
      <details @if($loop->first) open @endif>
        <summary>{{ $faq['question'] }}</summary>
        <p>{{ $faq['answer'] ?? '' }}</p>
      </details>
    @endforeach
    </div>
  </section>
  @endif

  <div class="container">
  <div class="cta-banner" id="contact" style="background:linear-gradient(180deg,rgba(14,124,134,.9),rgba(14,124,134,.86)),url('{{ SiteImages::get('home_process') }}') center/cover no-repeat">
    <h3 class="heading-bold">{{ $x['cta_heading'] ?? '' }}</h3>
    <p>{{ $x['cta_body'] ?? '' }}</p>
    <a href="{{ route('contact') }}" class="btn">{{ $x['cta_button'] ?: 'Request a Consultation' }}</a>
  </div>
  </div>
</div>
@endsection
