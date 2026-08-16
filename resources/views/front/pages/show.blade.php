@extends('front.layouts.lyovial-home')

@php $seo = $page->seo ?? null; @endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])
@include('front.partials.page-banner', [
    'bannerTitle' => $page->heading ?: $page->title,
    'bannerImage' => \App\Support\SiteImages::get('banner_default'),
])

<section class="section" style="padding:70px 0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="content-block" style="color:#4A5A67;line-height:1.75;font-size:16px">{!! $page->content !!}</div>
            </div>
        </div>
    </div>
</section>
@endsection
