@extends('front.layouts.lyovial-home')

@php
    use App\Support\SiteImages;
    $seo = $industry->seo;
    $industryBanner = SiteImages::resolve(
        $industry->banner_image ?: $industry->image,
        SiteImages::get('banner_industries')
    );
    $industryImg = SiteImages::resolve($industry->image, $industryBanner);
@endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])
@include('front.partials.page-banner', [
    'bannerTitle' => $industry->heading ?: $industry->title,
    'bannerSubtitle' => $industry->short_description,
    'bannerImage' => $industryBanner,
])

<section class="section" style="padding:70px 0;background:#fff">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-8">
        <img src="{{ $industryImg }}" alt="{{ $industry->title }}" class="img-fluid mb-4 w-100" style="max-height:420px;object-fit:cover">
        <div class="content-block" style="color:#4A5A67;line-height:1.75">{!! $industry->description !!}</div>
      </div>
      <div class="col-lg-4">
        <div style="background:#f3f5f7;padding:24px">
          <h2 style="font-size:18px;font-weight:700;color:#0e7c86;margin-bottom:16px">More industries</h2>
          <ul class="list-unstyled mb-0">
            @foreach($others as $other)
              <li class="mb-2"><a href="{{ route('industries.show', $other->slug) }}" style="color:#0e7c86;font-weight:500;text-decoration:none">{{ $other->title }}</a></li>
            @endforeach
          </ul>
          <a href="{{ route('contact') }}" class="btn btn-primary mt-3" style="width:100%">Discuss your project</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
