@extends('front.layouts.lyovial-home')

@php
    use App\Support\IndustryPageDefaults;
    use App\Support\SiteImages;

    $seo = $industry->seo;
    $x = $x ?? IndustryPageDefaults::merge($industry->extra, $industry->slug);
    $capabilities = $capabilities ?? collect();
    $others = $others ?? collect();
    $featureImg = SiteImages::resolve($industry->image ?: $industry->banner_image, SiteImages::industryImage(max(0, (int) $industry->sort_order - 1)));
@endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => false])

<link rel="stylesheet" href="{{ asset('assets/front/css/lyovial-industries.css') }}?v={{ filemtime(public_path('assets/front/css/lyovial-industries.css')) }}">

<div class="lv-ind">
  <header class="ind-hero">
    <div class="container">
      <div class="ind-crumb">
        <a href="{{ route('home') }}">Home</a>
        <span>/</span>
        <a href="{{ route('industries.index') }}">Industries</a>
        <span>/</span>
        {{ $x['nav_title'] ?: $industry->title }}
      </div>
      <div class="ind-hero-grid">
        <div>
          @if(!empty($x['hero_eyebrow']))
            <div class="ind-eyebrow is-light">{{ $x['hero_eyebrow'] }}</div>
          @endif
          <h1>{!! $x['hero_h1'] ?: e($industry->heading ?: $industry->title) !!}</h1>
          <p class="ind-lede">{{ $x['hero_lede'] ?: $industry->short_description }}</p>
          <div class="ind-hero-cta">
            <a class="ind-btn ind-btn-primary" href="{{ route('contact') }}">{{ $x['cta_button'] ?? 'Request a Feasibility Quote →' }}</a>
          </div>
        </div>
        @if(!empty($x['spec_items']))
          <aside class="ind-spec">
            <h4>{{ $x['spec_heading'] ?? 'Formats we freeze-dry' }}</h4>
            <ul>
              @foreach($x['spec_items'] as $item)
                <li>
                  <span class="ind-tick"></span>
                  <span><b>{{ $item['title'] }}</b> — {{ $item['body'] }}</span>
                </li>
              @endforeach
            </ul>
          </aside>
        @endif
      </div>
    </div>
  </header>

  <section class="ind-section">
    <div class="container">
      <div class="ind-lead">
        <div>
          @if(!empty($x['lead_eyebrow']))
            <div class="ind-eyebrow">{{ $x['lead_eyebrow'] }}</div>
          @endif
          @if(!empty($x['lead_heading']))
            <h2>{{ $x['lead_heading'] }}</h2>
          @endif
          @foreach(($x['lead_paras'] ?? []) as $para)
            <p>{{ $para }}</p>
          @endforeach
        </div>
        <div class="ind-visual">
          <img src="{{ $featureImg }}" alt="{{ $industry->title }}">
        </div>
      </div>

      @if(!empty($x['needs']))
        <div class="ind-eyebrow" style="margin-top:56px">{{ $x['needs_eyebrow'] ?? 'What we support' }}</div>
        <div class="ind-needs">
          @foreach($x['needs'] as $need)
            <article class="ind-need">
              <div class="n">{{ $need['n'] }}</div>
              <h3>{{ $need['title'] }}</h3>
              <p>{{ $need['body'] }}</p>
            </article>
          @endforeach
        </div>
        <div class="ind-swipe">Swipe to see more</div>
      @endif
    </div>
  </section>

  @if(!empty($x['steps']))
  <section class="ind-section is-wash">
    <div class="container">
      @if(!empty($x['process_eyebrow']))
        <div class="ind-eyebrow">{{ $x['process_eyebrow'] }}</div>
      @endif
      <h2 class="ind-section-title">{{ $x['process_heading'] }}</h2>
      @if(!empty($x['process_intro']))
        <p class="ind-section-intro">{{ $x['process_intro'] }}</p>
      @endif
      <div class="ind-steps">
        @foreach($x['steps'] as $i => $step)
          <div class="ind-step">
            <div class="dot">{{ $i + 1 }}</div>
            <h3>{{ $step['title'] }}</h3>
            <p>{{ $step['body'] }}</p>
          </div>
        @endforeach
      </div>
      <div class="ind-swipe">Swipe through the stages</div>
    </div>
  </section>
  @endif

  <section class="ind-section">
    <div class="container">
      <div class="ind-why">
        <div class="ind-why-card">
          <div class="ind-eyebrow is-light">Why LyoVial</div>
          <h2>{{ $x['why_heading'] }}</h2>
          <p>{{ $x['why_body'] }}</p>
          @if(!empty($x['why_items']))
            <ul class="ind-why-list">
              @foreach($x['why_items'] as $item)
                <li>{!! $item !!}</li>
              @endforeach
            </ul>
          @endif
        </div>
        <div class="ind-related">
          <h3>The full workflow</h3>
          <p class="sub">{{ $x['related_intro'] ?? '' }}</p>
          @foreach($capabilities as $cap)
            <a class="ind-svc" href="{{ url('/capabilities/'.$cap->slug) }}">
              <span>{{ $cap->title }}</span>
              <span class="arr">→</span>
            </a>
          @endforeach
          @if($others->isNotEmpty())
            <p class="sub" style="margin:16px 0 8px">Other industries we serve</p>
            @foreach($others->take(3) as $other)
              <a class="ind-svc" href="{{ route('industries.show', $other->slug) }}">
                <span>{{ IndustryPageDefaults::navTitle($other->extra, $other->slug, $other->title) }}</span>
                <span class="arr">→</span>
              </a>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </section>

  @if(!empty($x['faqs']))
  <section class="ind-section is-wash">
    <div class="container">
      <div class="ind-faq-grid">
        <div>
          <div class="ind-eyebrow">Common questions</div>
          <h2 class="ind-section-title" style="margin-top:10px">{{ $x['faq_heading'] }}</h2>
          <p class="ind-section-intro">If your question isn't here, send it — we'll answer before a first call.</p>
        </div>
        <div class="ind-faq">
          @foreach($x['faqs'] as $faq)
            <details @if($loop->first) open @endif>
              <summary>{{ $faq['q'] }}</summary>
              <p>{{ $faq['a'] }}</p>
            </details>
          @endforeach
        </div>
      </div>
    </div>
  </section>
  @endif

  <section class="ind-cta" id="quote">
    <div class="container">
      <div class="ind-eyebrow is-light">Ready to talk?</div>
      <h2>{{ $x['cta_heading'] }}</h2>
      <p>{{ $x['cta_body'] }}</p>
      <a class="ind-btn ind-btn-primary" href="{{ route('contact') }}">{{ $x['cta_button'] ?? 'Request a Feasibility Quote →' }}</a>
    </div>
  </section>
</div>
@endsection
