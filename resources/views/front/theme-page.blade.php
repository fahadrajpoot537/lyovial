@extends('front.layouts.lyovial-home')

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])
@include('front.partials.page-banner', [
    'bannerTitle' => $pageTitle ?: 'Page',
    'bannerImage' => \App\Support\SiteImages::get('banner_default'),
])

<div class="theme-page-wrap">
  {!! $themeContent !!}
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('theme/assets/css/laboix.css') }}">
<link rel="stylesheet" href="{{ asset('theme/assets/vendors/laboix-icons/style.css') }}">
<style>
  .theme-page-wrap { padding-top: 0; background: #fff; }
  .theme-page-wrap .main-header,
  .theme-page-wrap .topbar-one,
  .theme-page-wrap .main-menu,
  .theme-page-wrap .stricked-menu,
  .theme-page-wrap .mobile-nav__wrapper,
  .theme-page-wrap .footer-one,
  .theme-page-wrap .site-footer,
  .theme-page-wrap .preloader,
  .theme-page-wrap .page-header,
  .theme-page-wrap .page-header-two { display: none !important; }
  .theme-page-wrap .main-slider,
  .theme-page-wrap .main-slider-two { display: none !important; }
</style>
@endpush

@push('scripts')
<script src="{{ asset('theme/assets/js/cms-bind.js') }}"></script>
@endpush
