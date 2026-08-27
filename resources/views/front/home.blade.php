@extends('front.layouts.lyovial-home')

@php
    $hero = $sections['hero'] ?? null;
    $about = $sections['about'] ?? null;
    $stats = $sections['stats'] ?? null;
    $servicesIntro = $sections['services'] ?? null;
    $industriesIntro = $sections['industries'] ?? null;
    $whyIntro = $sections['why_choose'] ?? null;
    $partner = $sections['partner'] ?? null;
    $testimonialsIntro = $sections['testimonials'] ?? null;
    $process = $sections['process'] ?? null;
    $faqIntro = $sections['faq'] ?? null;
    $articlesIntro = $sections['articles'] ?? null;

    $resolveImg = function (?string $path, string $fallback) {
        return \App\Support\SiteImages::resolve($path, $fallback);
    };

    $themeArticleThumbs = [
        \App\Support\SiteImages::url('process.jpg'),
        \App\Support\SiteImages::url('svc-1.jpg'),
        \App\Support\SiteImages::url('why-lg.jpg'),
    ];

    $usableImg = function (?string $path) {
        if (! filled($path)) {
            return null;
        }
        // Dead / expired Unsplash theme URLs → use local fallback instead
        if (str_contains($path, 'images.unsplash.com')) {
            return null;
        }

        return $path;
    };

    $heroBg = \App\Support\SiteImages::resolve($usableImg($hero?->image), \App\Support\SiteImages::get('home_hero'));
    $heroLcpMobile = (str_contains($heroBg, '/images/site/hero') && is_file(public_path('images/site/hero-800.webp')))
        ? '/images/site/hero-800.webp'
        : $heroBg;
    [$heroW, $heroH] = \App\Support\SiteImages::dimensions($heroBg);
    $aboutImg = \App\Support\SiteImages::resolve($usableImg($about?->image), \App\Support\SiteImages::get('home_about'));
    [$aboutW, $aboutH] = \App\Support\SiteImages::dimensions($aboutImg);
    $whyImg = \App\Support\SiteImages::resolve($usableImg($whyIntro?->image), \App\Support\SiteImages::get('home_why'));
    $whyImgSm = \App\Support\SiteImages::get('home_why_sm');
    $partnerBg = \App\Support\SiteImages::resolve($usableImg($partner?->image), \App\Support\SiteImages::get('home_partner'));
    $processImg = \App\Support\SiteImages::resolve($usableImg($process?->image), \App\Support\SiteImages::get('home_process'));

    $themeServiceImgs = [
        \App\Support\SiteImages::url('svc-1.jpg'),
        \App\Support\SiteImages::url('svc-2.jpg'),
        \App\Support\SiteImages::url('svc-3.jpg'),
    ];
    $themeIndustryImgs = [
        \App\Support\SiteImages::url('ind-1.jpg'),
        \App\Support\SiteImages::url('ind-2.jpg'),
        \App\Support\SiteImages::url('ind-3.jpg'),
        \App\Support\SiteImages::url('ind-4.jpg'),
        \App\Support\SiteImages::url('ind-5.jpg'),
        \App\Support\SiteImages::url('ind-6.jpg'),
    ];

    $statItems = $stats?->extra['items'] ?? [
        ['num' => '250+', 'label' => 'Lyo Cycles<br/>Completed', 'icon' => 'flask'],
        ['num' => '20+', 'label' => 'Client<br/>Programs', 'icon' => 'doc'],
        ['num' => '4+', 'label' => 'Vial Formats<br/>Supported', 'icon' => 'vial'],
    ];
    $partnerCards = $partner?->extra['cards'] ?? [];
    $processSteps = $process?->extra['steps'] ?? [];

    $statIcons = [
        'flask' => '<path d="M10 2v7.31M14 9.3V2M8.5 2h7M14 9.3a6.5 6.5 0 1 1-4 0"/>',
        'doc' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="15" x2="15" y2="15"/><line x1="9" y1="11" x2="15" y2="11"/>',
        'vial' => '<rect x="4" y="6" width="16" height="14" rx="1"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M9 12h6M9 16h6"/>',
        'check' => '<polyline points="20 6 9 17 4 12"/>',
    ];
    $serviceIcons = [
        '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
        '<path d="M4 4h6l2 3h8v13H4z"/>',
        '<path d="M12 2v6M9 5h6M6 8h12l-2 12H8z"/>',
    ];
    $whyIcons = [
        '<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>',
        '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/>',
    ];
    $partnerIcons = [
        'target' => '<path d="M12 2v20M2 12h20"/><circle cx="12" cy="12" r="9"/>',
        'flask-beaker' => '<path d="M9 11H5a2 2 0 0 0-2 2v7h18v-7a2 2 0 0 0-2-2h-4M9 11V4a3 3 0 0 1 6 0v7M9 11h6"/>',
    ];

    $heroHeading = $hero?->heading ?? 'Contract Lyophilization Services — Pilot-Scale Vial Freeze-Drying';

    $phoneDisplay = $sitePhone ?: '+1 613 800 8060';
@endphp

@push('head')
<link rel="preload" as="image" href="{{ $heroLcpMobile }}" imagesrcset="{{ $heroLcpMobile }} 800w, {{ $heroBg }} 1600w" imagesizes="100vw" fetchpriority="high">
@endpush

@push('styles')
<style>
.why-visual-hex-lg { background-image: url('{{ $whyImg }}') !important; background-size: cover; background-position: center; }
.why-visual-hex-sm { background-image: url('{{ $whyImgSm }}') !important; background-size: cover; background-position: center; }
.partner {
    background:
      linear-gradient(180deg, rgba(14,124,134,.92) 0%, rgba(14,124,134,.92) 100%),
      url('{{ $partnerBg }}') center/cover no-repeat !important;
}
.coverage-image { background-image: url('{{ $processImg }}') !important; background-size: cover; background-position: center; }
</style>
@endpush

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])

{{-- HERO --}}
@if(!$hero || $hero->is_active)
<section class="hero">
  <img
    class="hero-media"
    src="{{ $heroLcpMobile }}"
    srcset="{{ $heroLcpMobile }} 800w, {{ $heroBg }} 1600w"
    sizes="100vw"
    alt="{{ $heroHeading }}"
    width="{{ $heroW ?: 1600 }}"
    height="{{ $heroH ?: 900 }}"
    fetchpriority="high"
    decoding="async"
  >
  <div class="container">
    <div class="hero-content">
      <h1>{{ $heroHeading }}</h1>
      <p>{{ strip_tags($hero?->description ?? '') }}</p>
      @if($hero?->button_primary_text)
        <a href="{{ url($hero->button_primary_link ?: '/contact') }}" class="btn btn-primary">{{ $hero->button_primary_text }}</a>
      @endif
    </div>
  </div>
</section>
@endif

{{-- ABOUT --}}
@if($about?->is_active)
<section class="about" id="about">
  <div class="container">
    <div class="about-grid">
      <div class="about-img">
        <div class="about-img-inner">
          <img src="{{ $aboutImg }}" alt="{{ $about->image_alt ?: ($about->heading ?: 'About LyoVial') }}" class="about-img-fallback" width="{{ $aboutW ?: 900 }}" height="{{ $aboutH ?: 900 }}" loading="lazy" decoding="async">
        </div>
      </div>
      <div>
        @if($about->small_title)<div class="eyebrow">{{ $about->small_title }}</div>@endif
        <h2>{{ $about->heading }}</h2>
        {!! $about->description !!}
        @if($about->button_primary_text)
          <a href="{{ url($about->button_primary_link ?: '#') }}" class="btn btn-primary" style="margin-top:20px">{{ $about->button_primary_text }}</a>
        @endif
      </div>
    </div>
  </div>
</section>
@endif

{{-- STATS --}}
@if(!$stats || $stats->is_active)
<section class="stats">
  <div class="container">
    <div class="stats-grid">
      @foreach($statItems as $stat)
        @php $iconKey = $stat['icon'] ?? 'flask'; @endphp
        <div class="stat">
          <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $statIcons[$iconKey] ?? $statIcons['flask'] !!}</svg>
          </div>
          <div class="stat-num">{{ $stat['num'] ?? '' }}</div>
          <div class="stat-label">{!! $stat['label'] ?? '' !!}</div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- SERVICES --}}
<section class="section services">
  <div class="container">
    <div class="section-head">
      @if($servicesIntro?->small_title)<div class="eyebrow">{{ $servicesIntro->small_title }}</div>@endif
      <h2>{{ $servicesIntro?->heading ?? 'Three services covering the full lyophilization workflow' }}</h2>
      <p>{{ strip_tags($servicesIntro?->description ?? '') }}</p>
    </div>
    <div class="service-grid is-carousel">
      @foreach($services as $i => $service)
        @php
          $svcImg = $resolveImg($usableImg($service->featured_image), $themeServiceImgs[$i % count($themeServiceImgs)]);
        @endphp
        <a href="{{ url('/capabilities/'.$service->slug) }}" class="service-card" style="display:block;color:inherit">
          <div class="service-img">
            <img src="{{ $svcImg }}" alt="{{ $service->title }}" width="800" height="450" loading="lazy" decoding="async">
          </div>
          <div class="service-body">
            <div class="service-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $serviceIcons[$i % count($serviceIcons)] !!}</svg>
            </div>
            <h3>{{ $service->title }}</h3>
            <p>{{ $service->short_description }}</p>
          </div>
        </a>
      @endforeach
    </div>
    <div class="home-swipe-hint">Swipe to see more</div>
  </div>
</section>

{{-- WHO WE SERVE --}}
<section class="section serve" id="industries">
  <div class="container">
    <div class="section-head">
      @if($industriesIntro?->small_title)<div class="eyebrow">{{ $industriesIntro->small_title }}</div>@endif
      <h2>{{ $industriesIntro?->heading ?? 'Teams that turn to LyoVial for contract freeze-drying' }}</h2>
      <p>{{ strip_tags($industriesIntro?->description ?? '') }}</p>
    </div>
    <div class="serve-grid is-carousel">
      @foreach($industries as $i => $industry)
        @php
          $indImg = $resolveImg($usableImg($industry->image), $themeIndustryImgs[$i % count($themeIndustryImgs)]);
          $indNav = \App\Support\IndustryPageDefaults::navTitle($industry->extra ?? null, $industry->slug, $industry->title);
        @endphp
        <a href="{{ url('/industries/'.$industry->slug) }}" class="serve-card">
          <div class="serve-card-thumb">
            <img src="{{ $indImg }}" alt="{{ $industry->title }}" width="800" height="600" loading="lazy" decoding="async">
          </div>
          <div class="serve-card-hover">
            <h3 class="serve-card-title">{{ $indNav }}</h3>
            @if($industry->short_description)
              <p class="serve-card-text">{{ $industry->short_description }}</p>
            @endif
          </div>
        </a>
      @endforeach
    </div>
    <div class="home-swipe-hint">Swipe to see more</div>
  </div>
</section>

{{-- WHY CHOOSE --}}
@if(!$whyIntro || $whyIntro->is_active)
<section class="why">
  <div class="container">
    <div class="why-grid">
      <div class="why-content">
        @if($whyIntro?->small_title)<div class="eyebrow">{{ $whyIntro->small_title }}</div>@endif
        <h2>{{ $whyIntro?->heading ?? 'Why teams choose LyoVial for contract lyophilization services' }}</h2>
        <p>{{ strip_tags($whyIntro?->description ?? '') }}</p>
        <div class="why-features">
          @foreach($whyChoose as $i => $item)
            <div class="why-feature">
              <div class="why-feature-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $whyIcons[$i % count($whyIcons)] !!}</svg>
              </div>
              <h3>{{ $item->title }}</h3>
              <p>{{ $item->description }}</p>
            </div>
          @endforeach
        </div>
        @if($whyIntro?->button_primary_text)
          <a href="{{ url($whyIntro->button_primary_link ?: '#') }}" class="btn btn-primary">{{ $whyIntro->button_primary_text }}</a>
        @endif
      </div>
      <div class="why-visual">
        <div class="why-visual-hex-lg" style="background-image:url('{{ $whyImg }}');background-size:cover;background-position:center;background-repeat:no-repeat;"></div>
        <div class="why-visual-hex-sm" style="background-image:url('{{ $whyImgSm }}');background-size:cover;background-position:center;background-repeat:no-repeat;"></div>
      </div>
    </div>
  </div>
</section>
@endif

{{-- PARTNER --}}
@if(!$partner || $partner->is_active)
<section class="partner">
  <div class="container">
    <div class="partner-head">
      <div>
        @if($partner?->small_title)<div class="eyebrow">{{ $partner->small_title }}</div>@endif
        <h2>{{ $partner?->heading ?? 'Your Canadian partner for pilot-scale contract lyophilization' }}</h2>
      </div>
      @if($partner?->button_primary_text)
        <a href="{{ url($partner->button_primary_link ?: '/contact') }}" class="btn btn-primary">{{ $partner->button_primary_text }}</a>
      @endif
    </div>
    <div class="partner-cards">
      @foreach($partnerCards as $card)
        @php $pIcon = $card['icon'] ?? 'target'; @endphp
        <div class="partner-card">
          <div class="partner-card-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $partnerIcons[$pIcon] ?? $partnerIcons['target'] !!}</svg>
          </div>
          <h3>{{ $card['title'] ?? '' }}</h3>
          <p>{{ $card['description'] ?? '' }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>
<div class="partner-spacer"></div>
@endif

{{-- TESTIMONIALS --}}
@if((!$testimonialsIntro || $testimonialsIntro->is_active) && $testimonials->count())
<section class="testimonials">
  <div class="container testimonials-inner">
    <div class="section-head">
      @if($testimonialsIntro?->small_title)<div class="eyebrow">{{ $testimonialsIntro->small_title }}</div>@endif
      <h2>{{ $testimonialsIntro?->heading ?? 'What our contract lyophilization clients say' }}</h2>
    </div>
    <div class="testimonial-grid is-carousel">
      @foreach($testimonials as $testimonial)
        <div class="testimonial">
          <div class="testimonial-header">
            <div class="testimonial-name">
              <strong>{{ $testimonial->name }}</strong>
              @if($testimonial->role)
                <span>{{ $testimonial->role }}</span>
              @endif
            </div>
          </div>
          <div class="testimonial-body">
            <p>"{{ $testimonial->quote }}"</p>
            <div class="stars">
              @for($s = 0; $s < max(1, min(5, (int) $testimonial->rating)); $s++)
                <svg viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568L24 9.75l-6 5.847 1.416 8.253L12 19.771l-7.416 4.079L6 15.597 0 9.75l8.332-1.595z"/></svg>
              @endfor
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="home-swipe-hint">Swipe to see more</div>
  </div>
</section>
@endif

{{-- PROCESS --}}
@if(!$process || $process->is_active)
<section class="coverage">
  <div class="container">
    <div class="coverage-head">
      @if($process?->small_title)
        <div class="eyebrow" style="justify-content:center;display:inline-flex">{{ $process->small_title }}</div>
      @endif
      <h2>{{ $process?->heading ?? 'How our contract lyophilization services work' }}</h2>
      <p>{{ strip_tags($process?->description ?? '') }}</p>
    </div>
    @php
      $leftSteps = array_slice($processSteps, 0, 2);
      $rightSteps = array_slice($processSteps, 2, 2);
    @endphp
    <div class="coverage-grid">
      <div class="coverage-list">
        @foreach($leftSteps as $step)
          <div class="coverage-item">
            <div class="coverage-num">{{ $step['num'] ?? '' }}</div>
            <strong>{!! nl2br(e($step['title'] ?? '')) !!}</strong>
          </div>
        @endforeach
      </div>
      <div class="coverage-image" style="background-image:url('{{ $processImg }}');background-size:cover;background-position:center;background-repeat:no-repeat;"></div>
      <div class="coverage-list">
        @foreach($rightSteps as $step)
          <div class="coverage-item">
            <div class="coverage-num">{{ $step['num'] ?? '' }}</div>
            <strong>{!! nl2br(e($step['title'] ?? '')) !!}</strong>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif

{{-- EXISTING FAQ (before Articles) --}}
<section class="lyovial-faq" id="faq">
  <div class="container">
    <div class="section-head">
      @if($faqIntro?->small_title)<div class="eyebrow" style="justify-content:center;display:inline-flex;margin:0 auto 12px">{{ $faqIntro->small_title }}</div>@endif
      <h2 class="section-title">{{ $faqIntro?->heading ?? 'FAQ' }}</h2>
      <p style="max-width:640px;margin:0 auto;color:#000">{{ strip_tags($faqIntro?->description ?? '') }}</p>
    </div>
    <div class="lyovial-faq-list">
      @foreach($faqs as $i => $faq)
        <details class="lyovial-faq-item" @if(!$i) open @endif>
          <summary>{{ $faq->question }}</summary>
          <div class="faq-body">{{ $faq->answer }}</div>
        </details>
      @endforeach
    </div>
  </div>
</section>

{{-- BLOGS --}}
@if((!$articlesIntro || $articlesIntro->is_active) && $articles->count())
<section class="blog" id="articles">
  <div class="container">
    <div class="section-head blog-head">
      <div>
        <div class="eyebrow">Blogs</div>
        <h2>{{ $articlesIntro?->heading ?? 'Latest lyophilization insights & case notes' }}</h2>
      </div>
      <a href="{{ route('blog.index') }}" class="btn btn-primary">View All →</a>
    </div>
    <div class="blog-grid is-carousel">
      @foreach($articles as $i => $article)
        @php
          $thumb = $resolveImg($usableImg($article->featured_image), $themeArticleThumbs[$i % count($themeArticleThumbs)]);
          $initials = strtoupper(mb_substr(trim($article->author_name ?: 'LV'), 0, 1));
          $day = $article->published_at?->format('d') ?? '01';
          $month = $article->published_at?->format('M') ?? 'Jan';
        @endphp
        <div class="blog-card">
          <div class="blog-thumb" style="background-image:url('{{ $thumb }}')">
            <div class="blog-date">
              <strong>{{ $day }}</strong><span>{{ $month }}</span>
            </div>
          </div>
          <div class="blog-body">
            <div class="blog-author">
              <div class="blog-author-avatar is-initials" aria-hidden="true">{{ $initials }}</div>
              <div>
                <strong>{{ $article->author_name }}</strong>
                <span>{{ $article->author_role }}</span>
              </div>
            </div>
            <h3>{{ $article->title }}</h3>
            <a href="{{ route('blog.show', $article) }}" class="read-more">Read More <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
          </div>
        </div>
      @endforeach
    </div>
    <div class="home-swipe-hint">Swipe to see more</div>
  </div>
</section>
@endif
@endsection
