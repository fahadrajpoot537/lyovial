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

<section class="section capabilities-index" style="padding:70px 0">
  <div class="container">
    <div class="capabilities-index-grid">
      @forelse($services as $service)
        <a href="{{ url('/capabilities/'.$service->slug) }}" class="service-card capabilities-index-card">
          <img src="{{ SiteImages::resolve($service->featured_image, SiteImages::serviceFeature($service->slug)) }}" alt="{{ $service->title }}" class="w-100 mb-3" style="height:180px;object-fit:cover">
          <h3>{{ $service->title }}</h3>
          <p>{{ $service->short_description }}</p>
        </a>
      @empty
        <p>No capabilities published yet.</p>
      @endforelse
    </div>
  </div>
</section>
@endsection
