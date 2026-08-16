@extends('front.layouts.lyovial-home')

@php $seo = null; @endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])
@php use App\Support\SiteImages; @endphp
@include('front.partials.page-banner', [
    'bannerTitle' => 'Capabilities',
    'bannerSubtitle' => 'Pilot-scale vial lyophilization capabilities across formulation, cycle development, and technology transfer.',
    'bannerImage' => SiteImages::get('banner_capabilities'),
])

<section class="section" style="padding:70px 0">
  <div class="container">
    <div class="row g-4">
      @forelse($services as $service)
        <div class="col-md-6 col-lg-4">
          <a href="{{ url('/capabilities/'.$service->slug) }}" class="service-card" style="display:block;color:inherit;text-decoration:none;background:#fff;border:1px solid #e8ecee;padding:24px;height:100%">
            <img src="{{ SiteImages::resolve($service->featured_image, SiteImages::serviceFeature($service->slug)) }}" alt="{{ $service->title }}" class="w-100 mb-3" style="height:180px;object-fit:cover">
            <h3 style="color:#0e7c86;font-size:20px;font-weight:700">{{ $service->title }}</h3>
            <p style="color:#4A5A67;font-size:14px;line-height:1.7">{{ $service->short_description }}</p>
          </a>
        </div>
      @empty
        <div class="col-12"><p>No capabilities published yet.</p></div>
      @endforelse
    </div>
  </div>
</section>
@endsection
