@extends('front.layouts.lyovial-home')

@php
    use App\Support\SiteImages;

    $themeThumbs = [
        SiteImages::url('process.jpg'),
        SiteImages::url('svc-1.jpg'),
        SiteImages::url('why-lg.jpg'),
    ];
@endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])

@include('front.partials.page-banner', [
    'bannerTitle' => $homeArticlesIntro?->heading ?: 'Blog',
    'bannerSubtitle' => filled($homeArticlesIntro?->description) ? strip_tags($homeArticlesIntro->description) : ($homeArticlesIntro?->small_title ?: 'Latest lyophilization insights & case notes'),
    'bannerImage' => SiteImages::resolve($homeArticlesIntro?->image, SiteImages::get('banner_articles')),
])

<link rel="stylesheet" href="{{ asset('assets/front/css/lyovial-article.css') }}?v={{ filemtime(public_path('assets/front/css/lyovial-article.css')) }}">

<section class="lv-blog-index">
  <div class="container">
    @if($articles->count())
      <div class="blog-grid">
        @foreach($articles as $i => $article)
          @php
            $rawThumb = $article->featured_image;
            if (filled($rawThumb) && str_contains($rawThumb, 'images.unsplash.com')) {
                $rawThumb = null;
            }
            $thumb = SiteImages::resolve($rawThumb, $themeThumbs[$i % count($themeThumbs)]);
            $avatarUrl = SiteImages::authorAvatar($article->author_avatar);
            $day = $article->published_at?->format('d') ?? '01';
            $month = $article->published_at?->format('M') ?? 'Jan';
          @endphp
          <article class="blog-card">
            <a href="{{ route('blog.show', $article) }}" class="blog-card-link">
              <div class="blog-thumb" style="background-image:url('{{ $thumb }}')">
                <div class="blog-date">
                  <strong>{{ $day }}</strong><span>{{ $month }}</span>
                </div>
              </div>
              <div class="blog-body">
                <div class="blog-author">
                  <div class="blog-author-avatar" style="background-image:url('{{ $avatarUrl }}')" role="img" aria-label="{{ $article->author_name }}"></div>
                  <div>
                    <strong>{{ $article->author_name }}</strong>
                    <span>{{ $article->author_role }}</span>
                  </div>
                </div>
                <h3>{{ $article->title }}</h3>
                @if($article->excerpt)
                  <p class="blog-excerpt">{{ $article->excerpt }}</p>
                @endif
                <span class="read-more">Read More <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
              </div>
            </a>
          </article>
        @endforeach
      </div>

      @if($articles->hasPages())
        <div class="lv-blog-pager">
          {{ $articles->links() }}
        </div>
      @endif
    @else
      <div class="lv-blog-empty">No articles published yet.</div>
    @endif
  </div>
</section>
@endsection
