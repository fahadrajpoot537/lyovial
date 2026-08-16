@extends('front.layouts.lyovial-home')

@php $seo = $article->seo ?? null; @endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])

@include('front.partials.page-banner', [
    'bannerTitle' => $article->title,
    'bannerSubtitle' => 'Article',
    'bannerImage' => \App\Support\SiteImages::get('banner_articles'),
])

<section class="section">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p class="text-secondary mb-4">
                    @if($article->author_name)<strong>{{ $article->author_name }}</strong>@endif
                    @if($article->author_role) · {{ $article->author_role }}@endif
                    @if($article->published_at) · {{ $article->published_at->format('M j, Y') }}@endif
                </p>
                @if($article->excerpt)
                    <p class="lead">{{ $article->excerpt }}</p>
                @endif
                <div class="content-block" style="color:#4A5A67;line-height:1.75">{!! $article->content !!}</div>
                <a href="{{ route('articles.index') }}" class="btn btn-primary mt-4">← Back to articles</a>
            </div>
        </div>
    </div>
</section>
@endsection
