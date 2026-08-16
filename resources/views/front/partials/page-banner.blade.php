@php
    $bannerTitle = $bannerTitle ?? 'Page';
    $bannerSubtitle = $bannerSubtitle ?? null;
    $bannerImage = $bannerImage ?? \App\Support\SiteImages::get('home_hero');
@endphp
<section class="page-hero" style="--page-banner:url('{{ $bannerImage }}')">
  <div class="container">
    <h1>{{ $bannerTitle }}</h1>
    @if($bannerSubtitle)
      <p>{{ $bannerSubtitle }}</p>
    @endif
  </div>
</section>
