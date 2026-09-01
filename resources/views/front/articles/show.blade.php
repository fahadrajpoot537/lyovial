@extends('front.layouts.lyovial-home')

@php
    use App\Support\ArticleToc;
    use App\Support\SiteImages;

    $seo = $article->seo ?? null;
    $prepared = ArticleToc::prepare($article->content);
    $articleHtml = $prepared['html'];
    $headings = $prepared['headings'];
    $shareUrl = url()->current();
    $shareTitle = $article->title;
    $heroImg = SiteImages::get('banner_articles');
    $featureImg = filled($article->featured_image)
        ? SiteImages::resolve($article->featured_image, '')
        : '';
    $avatar = SiteImages::authorAvatar($article->author_avatar);
    $encodedUrl = rawurlencode($shareUrl);
    $encodedTitle = rawurlencode($shareTitle);
@endphp

@section('content')
@include('front.partials.lyovial-navbar', ['transparent' => true])

@include('front.partials.page-banner', [
    'bannerTitle' => $article->title,
    'bannerSubtitle' => $article->published_at?->format('F j, Y'),
    'bannerImage' => $heroImg,
])

<link rel="stylesheet" href="{{ asset('assets/front/css/lyovial-article.css') }}?v={{ filemtime(public_path('assets/front/css/lyovial-article.css')) }}">

<section class="lv-article-page">
  <div class="container lv-article{{ count($headings) ? '' : ' is-solo' }}">
    @if(count($headings))
      <nav class="lv-article-toc" id="lvArticleToc" aria-label="On this page">
        <details class="lv-toc-details">
          <summary class="lv-toc-label">On this page</summary>
          <ul>
            @foreach($headings as $heading)
              <li class="is-h{{ $heading['level'] }}{{ $loop->first ? ' is-active' : '' }}">
                <a href="#{{ $heading['id'] }}">{{ $heading['text'] }}</a>
              </li>
            @endforeach
          </ul>
        </details>
      </nav>
    @endif

    <div class="lv-article-main">
      @if($featureImg)
        <img class="lv-article-hero-img" src="{{ $featureImg }}" alt="{{ $article->title }}" width="1200" height="675" loading="eager" decoding="async">
      @endif

      <div class="lv-article-body content-block">
        {!! $articleHtml !!}
      </div>

      <div class="lv-article-author">
        <div class="lv-author-row">
          <div class="lv-author-avatar" style="background-image:url('{{ $avatar }}')" role="img" aria-label="{{ $article->author_name ?: 'Author' }}"></div>
          <div>
            @if($article->author_name)
              <h3 class="lv-author-name">{{ $article->author_name }}</h3>
            @endif
            @if($article->author_role)
              <p class="lv-author-role">{{ $article->author_role }}</p>
            @endif
          </div>
        </div>

        <div class="lv-article-share">
          <div class="lv-share-label">Share this article</div>
          <div class="lv-share-icons">
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $encodedUrl }}" target="_blank" rel="noopener" aria-label="Share on LinkedIn">
              <i class="bi bi-linkedin"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" target="_blank" rel="noopener" aria-label="Share on X">
              <i class="bi bi-twitter-x"></i>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" target="_blank" rel="noopener" aria-label="Share on Facebook">
              <i class="bi bi-facebook"></i>
            </a>
            <a href="mailto:?subject={{ $encodedTitle }}&body={{ $encodedUrl }}" aria-label="Share by email">
              <i class="bi bi-envelope"></i>
            </a>
            <button type="button" id="lvCopyLink" data-url="{{ $shareUrl }}" aria-label="Copy link">
              <i class="bi bi-link-45deg"></i>
            </button>
          </div>
        </div>
      </div>

      <a href="{{ route('blog.index') }}" class="lv-article-back">← Back to blog</a>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
  const toc = document.getElementById('lvArticleToc');
  const details = toc?.querySelector('.lv-toc-details');
  if (details) {
    const desktop = window.matchMedia('(min-width: 993px)');
    const syncToc = () => { details.open = desktop.matches; };
    if (desktop.addEventListener) desktop.addEventListener('change', syncToc);
    else desktop.addListener(syncToc);
    syncToc();
  }
  if (toc) {
    const links = Array.from(toc.querySelectorAll('a[href^="#"]'));
    const sections = links
      .map((link) => document.getElementById(decodeURIComponent(link.hash.slice(1))))
      .filter(Boolean);

    const setActive = (id) => {
      links.forEach((link) => {
        const match = decodeURIComponent(link.hash.slice(1)) === id;
        link.parentElement.classList.toggle('is-active', match);
      });
    };

    links.forEach((link) => {
      link.addEventListener('click', (e) => {
        const el = document.getElementById(decodeURIComponent(link.hash.slice(1)));
        if (!el) return;
        e.preventDefault();
        const top = el.getBoundingClientRect().top + window.scrollY - 96;
        window.scrollTo({ top, behavior: 'smooth' });
        history.replaceState(null, '', link.hash);
        setActive(el.id);
        if (details && window.matchMedia('(max-width: 992px)').matches) {
          details.open = false;
        }
      });
    });

    const onScroll = () => {
      const offset = 120;
      let current = sections[0] ? sections[0].id : null;
      sections.forEach((el) => {
        if (el.getBoundingClientRect().top - offset <= 0) {
          current = el.id;
        }
      });
      if (current) setActive(current);
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  const copyBtn = document.getElementById('lvCopyLink');
  copyBtn?.addEventListener('click', async () => {
    const url = copyBtn.getAttribute('data-url') || window.location.href;
    try {
      await navigator.clipboard.writeText(url);
      copyBtn.classList.add('is-copied');
      copyBtn.setAttribute('aria-label', 'Link copied');
      setTimeout(() => {
        copyBtn.classList.remove('is-copied');
        copyBtn.setAttribute('aria-label', 'Copy link');
      }, 1600);
    } catch (err) {
      window.prompt('Copy this link', url);
    }
  });
})();
</script>
@endpush
