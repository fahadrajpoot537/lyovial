@extends('front.layouts.lyovial-home')

@php
    use App\Support\ThemePageDefaults;
    $seo = $page->seo ?? null;
    $x = ThemePageDefaults::mergePage($page->extra ?? null, \App\Models\Page::TYPE_PARTNERSHIPS);
    $partners = $x['partners'] ?? [];
    $heading = $x['hero_heading'] ?: ($page->heading ?: $page->title);
    $accent = $x['hero_accent'] ?? '';
    if ($accent && str_contains($heading, $accent)) {
        $headingHtml = str_replace($accent, '<span class="lp-accent">'.e($accent).'</span>', e($heading));
    } else {
        $headingHtml = e($heading);
    }
@endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => false])

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/front/css/lyovial-partnerships.css') }}?v={{ filemtime(public_path('assets/front/css/lyovial-partnerships.css')) }}">

<div class="lp-page">
  <main>
    <section class="lp-hero lp-wrap">
      <div class="lp-eyebrow">{{ $x['hero_eyebrow'] ?? 'Partnerships' }}</div>
      <h1 class="lp-title">{!! $headingHtml !!}</h1>
      <p class="lp-lede">{{ $x['hero_lede'] ?? '' }}</p>
    </section>

    <section class="lp-grid lp-wrap">
      @foreach($partners as $partner)
        @continue(empty($partner['name']))
        <article class="lp-card">
          <div class="lp-card-inner">
            @if(!empty($partner['logo']))
              <div class="lp-card-logo">
                <img class="lp-logo" src="{{ $partner['logo'] }}" alt="{{ $partner['name'] }} logo">
              </div>
            @endif
            <div class="lp-card-body">
              <div class="lp-meta">
                <div>
                  <div class="lp-role-name">{{ $partner['name'] }}</div>
                  <div class="lp-role-title">{{ $partner['location'] ?? '' }}</div>
                </div>
              </div>
              <h2 class="lp-card-title">{{ $partner['title'] ?? '' }}</h2>
              <p class="lp-card-text">{{ $partner['summary'] ?? '' }}</p>
              <a href="#{{ $partner['anchor'] ?? ('partner-'.$loop->iteration) }}" class="lp-read-more">
                READ MORE
                <span class="lp-arrow">
                  <svg viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
              </a>
            </div>
          </div>
          <div class="lp-badge">
            <span class="lp-badge-n">{{ $partner['num'] ?? str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
            <span class="lp-badge-t">Partner</span>
          </div>
        </article>
      @endforeach
    </section>

    @foreach($partners as $partner)
      @continue(empty($partner['name']))
      <section class="lp-detail lp-wrap" id="{{ $partner['anchor'] ?? ('partner-'.$loop->iteration) }}">
        <div class="lp-detail-head">
          @if(!empty($partner['logo']))
            <img class="lp-detail-logo" src="{{ $partner['logo'] }}" alt="{{ $partner['name'] }}">
          @endif
          <span class="lp-idx">{{ $partner['num'] ?? str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          <h3 class="lp-detail-name">{{ $partner['name'] }}</h3>
          @if(!empty($partner['location']))
            <span class="lp-pill">{{ $partner['location'] }}</span>
          @endif
          @if(!empty($partner['website']))
            <a href="{{ $partner['website'] }}" target="_blank" rel="noopener" class="lp-visit">Learn more ↗</a>
          @endif
        </div>

        <div class="lp-detail-grid">
          <div>
            @foreach(($partner['sections'] ?? []) as $section)
              @continue(empty($section['heading']))
              <h4 class="lp-section-h">{{ $section['heading'] }}</h4>
              <p class="lp-section-p">{{ $section['body'] ?? '' }}</p>
            @endforeach
            @if(!empty($partner['callout_body']))
              <div class="lp-callout">
                @if(!empty($partner['callout_label']))
                  <span class="lp-callout-label">{{ $partner['callout_label'] }}</span>
                @endif
                {{ $partner['callout_body'] }}
              </div>
            @endif
          </div>
          <div>
            @if(!empty($partner['bullets']))
              <ul class="lp-spec">
                @foreach($partner['bullets'] as $bullet)
                  @continue(!filled($bullet))
                  <li><span class="lp-dot"></span>{{ $bullet }}</li>
                @endforeach
              </ul>
            @endif
            @if(!empty($partner['methods']))
              <table class="lp-methods">
                @foreach($partner['methods'] as $method)
                  @continue(empty($method['name']))
                  <tr>
                    <td class="lp-m-name">{{ $method['name'] }}</td>
                    <td class="lp-m-desc">{{ $method['desc'] ?? '' }}</td>
                  </tr>
                @endforeach
              </table>
            @endif
          </div>
        </div>
      </section>
    @endforeach

    <section class="lp-cta lp-wrap">
      <div class="lp-cta-inner">
        <div>
          <h2 class="lp-cta-title">{{ $x['cta_heading'] ?? '' }}</h2>
          <p class="lp-cta-text">{{ $x['cta_body'] ?? '' }}</p>
          <a href="{{ route('contact') }}" class="lp-cta-btn">
            {{ strtoupper($x['cta_button'] ?: 'GET IN TOUCH') }}
            <span class="lp-arrow lp-arrow-dark">
              <svg viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
          </a>
        </div>
        <div class="lp-cta-paths">
          @foreach(($x['cta_paths'] ?? []) as $path)
            @continue(empty($path['tag']))
            <div class="lp-cta-path">
              <span class="lp-tag">{{ $path['tag'] }}</span>
              {{ $path['text'] ?? '' }}
            </div>
          @endforeach
        </div>
      </div>
    </section>
  </main>
</div>
@endsection
