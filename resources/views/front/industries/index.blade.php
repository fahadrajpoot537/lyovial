@extends('front.layouts.lyovial-home')

@php
    use App\Support\SiteImages;
    $seo = null;
@endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])
@include('front.partials.page-banner', [
    'bannerTitle' => 'Industries We Serve',
    'bannerSubtitle' => 'Partners across diagnostics, laboratories, research, and specialty formulation.',
    'bannerImage' => SiteImages::get('banner_industries'),
])

<section class="section" style="padding:70px 0">
  <div class="container">
    <div class="row g-4">
      @forelse($industries as $i => $industry)
        @php
          $img = SiteImages::resolve($industry->image ?: $industry->banner_image, SiteImages::industryImage($i));
        @endphp
        <div class="col-md-6 col-lg-4">
          <a href="{{ route('industries.show', $industry->slug) }}" class="service-card" style="display:block;color:inherit;text-decoration:none;background:#fff;border:1px solid #e8ecee;padding:24px;height:100%">
            <img src="{{ $img }}" alt="{{ $industry->title }}" class="w-100 mb-3" style="height:180px;object-fit:cover">
            <h3 style="color:#0e7c86;font-size:20px;font-weight:700">{{ $industry->title }}</h3>
            <p style="color:#4A5A67;font-size:14px;line-height:1.7;margin:0">{{ $industry->short_description }}</p>
          </a>
        </div>
      @empty
        <div class="col-12"><p>No industries published yet.</p></div>
      @endforelse
    </div>
  </div>
</section>
@endsection
