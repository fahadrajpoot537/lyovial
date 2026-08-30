@php
    $navbarCms = $homeNavbar ?? null;
    $cmsLogo = $navbarCms?->image;
    if (filled($cmsLogo) && ! str_starts_with($cmsLogo, 'http') && ! str_starts_with($cmsLogo, '/')) {
        $cmsLogo = storage_url($cmsLogo);
    }
    $navLogo = $cmsLogo
        ?: ($siteLogo ? storage_url($siteLogo) : asset('assets/front/images/lyovial-home/logo-white.png'));
    $transparent = $transparent ?? true;
    $ctaText = $navbarCms?->button_primary_text ?: 'Get A Quote';
    $ctaHref = $navbarCms?->button_primary_link ?: route('contact');
    if ($ctaHref && ! str_starts_with($ctaHref, 'http') && ! str_starts_with($ctaHref, 'tel:') && ! str_starts_with($ctaHref, '#')) {
        $ctaHref = url($ctaHref);
    }
    $menuItems = collect($headerMenus ?? []);
@endphp
<header class="header lyovial-nav{{ $transparent ? ' is-transparent' : '' }}" id="lyovialNav">
  <div class="container header-inner">
    <a href="{{ route('home') }}" class="logo">
      <img src="{{ $navLogo }}" alt="{{ $navbarCms?->heading ?: $siteName }}" class="nav-logo-img" width="160" height="36" decoding="async" />
    </a>
    <nav class="header-nav" id="lyovialHeaderNav" aria-label="Main">
      @forelse($menuItems as $item)
        @php
          $titleHay = strtolower((string) $item->title);
          $classHay = strtolower((string) ($item->css_class ?? ''));
          $skipItem = str_contains($classHay, 'cta')
              || str_contains($titleHay, 'get a quote')
              || str_contains($titleHay, 'feasibility quote');
        @endphp
        @if($skipItem)
          @continue
        @endif
        @php
          $kids = $item->children ?? collect();
          $hay = strtolower(($item->url ?? '').' '.($item->title ?? '').' '.($item->type ?? ''));
          if ($kids->isEmpty() && str_contains($hay, 'capabilit')) {
              $kids = collect($navServices ?? [])->map(fn ($service) => (object) [
                  'title' => $service->title,
                  'resolved_url' => url('/capabilities/'.$service->slug),
              ]);
          }
          if ($kids->isEmpty() && str_contains($hay, 'industr')) {
              $kids = collect($navIndustries ?? [])->map(fn ($industry) => (object) [
                  'title' => \App\Support\IndustryPageDefaults::navTitle($industry->extra ?? null, $industry->slug, $industry->title),
                  'resolved_url' => url('/industries/'.$industry->slug),
              ]);
          }
          if ($kids->isEmpty() && str_contains($hay, 'media')) {
              $kids = collect([
                  (object) ['title' => 'Specimen Library Preservation', 'resolved_url' => url('/specimen-library-preservation')],
                  (object) ['title' => 'Blog', 'resolved_url' => route('blog.index')],
              ]);
          }
        @endphp
        @if($kids->isNotEmpty())
          <div class="nav-dropdown">
            <button type="button" class="nav-drop-toggle" aria-expanded="false" data-nav-toggle>{{ $item->title }}</button>
            <div class="nav-drop-menu">
              <div class="nav-drop-heading">{{ $item->title }}</div>
              @foreach($kids as $child)
                <a href="{{ $child->resolved_url ?? $child->url ?? '#' }}"@if(!empty($child->open_in_new_tab) || ($child->target ?? '') === '_blank') target="_blank" rel="noopener"@endif>{{ $child->title }}</a>
              @endforeach
            </div>
          </div>
        @else
          <a href="{{ $item->resolved_url }}"@if($item->open_in_new_tab || $item->target === '_blank') target="_blank" rel="noopener"@endif>{{ $item->title }}</a>
        @endif
      @empty
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
      @endforelse
    </nav>
    <div class="header-cta">
      <a href="{{ $ctaHref }}" class="nav-contact-btn">{{ $ctaText }}</a>
      <button class="hamburger" type="button" aria-label="Menu" aria-expanded="false" aria-controls="lyovialHeaderNav"><span></span><span></span><span></span></button>
    </div>
  </div>
</header>
