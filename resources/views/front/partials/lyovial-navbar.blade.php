@php
    $navLogo = $siteLogo ? storage_url($siteLogo) : asset('assets/front/images/lyovial-home/logo-white.png');
    $transparent = $transparent ?? true;
@endphp
<header class="header lyovial-nav{{ $transparent ? ' is-transparent' : '' }}" id="lyovialNav">
  <div class="container header-inner">
    <a href="{{ route('home') }}" class="logo">
      <img src="{{ $navLogo }}" alt="{{ $siteName }}" class="nav-logo-img" width="160" height="36" decoding="async" />
    </a>
    <nav class="header-nav" id="lyovialHeaderNav" aria-label="Main">
      <a href="{{ route('home') }}">Home</a>

      <div class="nav-dropdown">
        <button type="button" class="nav-drop-toggle" aria-expanded="false" data-nav-toggle>Capabilities</button>
        <div class="nav-drop-menu">
          <div class="nav-drop-heading">Capabilities</div>
          @foreach($navServices as $service)
            <a href="{{ url('/capabilities/'.$service->slug) }}">{{ $service->title }}</a>
          @endforeach
        </div>
      </div>

      <div class="nav-dropdown">
        <button type="button" class="nav-drop-toggle" aria-expanded="false" data-nav-toggle>Industries</button>
        <div class="nav-drop-menu">
          <div class="nav-drop-heading">Industries</div>
          @foreach($navIndustries ?? [] as $navIndustry)
            <a href="{{ url('/industries/'.$navIndustry->slug) }}">{{ \App\Support\IndustryPageDefaults::navTitle($navIndustry->extra, $navIndustry->slug, $navIndustry->title) }}</a>
          @endforeach
        </div>
      </div>
      <a href="{{ url('/quality-compliance') }}">Compliance</a>

      <div class="nav-dropdown">
        <button type="button" class="nav-drop-toggle" aria-expanded="false" data-nav-toggle>Media</button>
        <div class="nav-drop-menu">
          <div class="nav-drop-heading">Media</div>
          <a href="{{ url('/specimen-library-preservation') }}">Specimen Library Preservation</a>
          <a href="{{ route('blog.index') }}">Blog</a>
        </div>
      </div>

      <a href="{{ url('/partnerships') }}">Partner</a>
    </nav>
    <div class="header-cta">
      <a href="{{ route('contact') }}" class="nav-contact-btn">Get A Quote</a>
      <button class="hamburger" type="button" aria-label="Menu" aria-expanded="false" aria-controls="lyovialHeaderNav"><span></span><span></span><span></span></button>
    </div>
  </div>
</header>
