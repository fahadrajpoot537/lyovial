@extends('front.layouts.lyovial-home')

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])

@include('front.partials.page-banner', [
    'bannerTitle' => 'Articles',
    'bannerSubtitle' => 'Latest lyophilization insights & case notes',
    'bannerImage' => \App\Support\SiteImages::get('banner_articles'),
])

<section class="section">
    <div class="container py-5">
        <div class="row g-4">
            @forelse($articles as $article)
                @php
                    $thumb = \App\Support\SiteImages::resolve($article->featured_image, \App\Support\SiteImages::url('process.jpg'));
                @endphp
                <div class="col-md-6 col-lg-4">
                    <article class="card-soft h-100">
                        <a href="{{ route('articles.show', $article) }}" class="text-decoration-none text-dark">
                            <img src="{{ $thumb }}" alt="{{ $article->title }}" loading="lazy">
                            <div class="body">
                                <p class="small text-secondary mb-2">
                                    @if($article->published_at){{ $article->published_at->format('M j, Y') }}@endif
                                    @if($article->author_name) · {{ $article->author_name }}@endif
                                </p>
                                <h2 class="h5" style="color:#0e7c86">{{ $article->title }}</h2>
                                @if($article->excerpt)
                                    <p class="text-secondary mb-3">{{ $article->excerpt }}</p>
                                @endif
                                <span class="fw-semibold" style="color:#0e7c86">Read more →</span>
                            </div>
                        </a>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-secondary mb-0">No articles published yet.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    </div>
</section>
@endsection
