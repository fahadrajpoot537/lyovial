@extends('front.layouts.lyovial-home')

@php
    $about = $about ?? null;
    $seo = $about?->seo;
    $aboutImg = \App\Support\SiteImages::resolve($about?->image, \App\Support\SiteImages::get('home_about'));
@endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])
@include('front.partials.page-banner', [
    'bannerTitle' => $about?->heading ?: 'About Us',
    'bannerSubtitle' => $about?->small_title,
    'bannerImage' => \App\Support\SiteImages::resolve($about?->image, \App\Support\SiteImages::get('banner_about')),
])

<section class="about" style="padding:80px 0">
  <div class="container">
    <div class="about-grid">
      <div class="about-img">
        <div class="about-img-inner" style="background-image:url('{{ $aboutImg }}');background-size:cover;background-position:center">
          <img src="{{ $aboutImg }}" alt="{{ $about?->image_alt ?: 'About LyoVial' }}" class="about-img-fallback" loading="lazy">
        </div>
      </div>
      <div>
        @if($about?->small_title)<div class="eyebrow">{{ $about->small_title }}</div>@endif
        <h2>{{ $about?->heading ?: 'Who Is LyoVial' }}</h2>
        {!! $about?->description !!}
        @if($about?->button_primary_text)
          <a href="{{ url($about->button_primary_link ?: '/contact') }}" class="btn btn-primary">{{ $about->button_primary_text }}</a>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
