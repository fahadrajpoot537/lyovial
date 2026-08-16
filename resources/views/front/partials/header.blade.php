<header class="site-header">
    <div class="top-bar d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center py-2 small">
            <div>
                @if($sitePhone)<a href="tel:{{ preg_replace('/\D+/', '', $sitePhone) }}" class="text-decoration-none me-3"><i class="bi bi-telephone me-1"></i>{{ $sitePhone }}</a>@endif
                @if($siteEmail)<a href="mailto:{{ $siteEmail }}" class="text-decoration-none"><i class="bi bi-envelope me-1"></i>{{ $siteEmail }}</a>@endif
            </div>
            <div class="social-links">
                @foreach(['linkedin','twitter','facebook','instagram','youtube'] as $network)
                    @if(!empty($social[$network]))
                        <a href="{{ $social[$network] }}" target="_blank" rel="noopener" aria-label="{{ $network }}"><i class="bi bi-{{ $network === 'twitter' ? 'twitter-x' : $network }}"></i></a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                @if($siteLogo)
                    <img src="{{ storage_url($siteLogo) }}" alt="{{ $siteName }}" height="40">
                @else
                    <span class="brand-text">{{ $siteName }}</span>
                @endif
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    @foreach($headerMenus as $item)
                        @if($item->children->count())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="{{ $item->resolved_url }}" data-bs-toggle="dropdown">{{ $item->title }}</a>
                                <ul class="dropdown-menu">
                                    @foreach($item->children as $child)
                                        <li><a class="dropdown-item" href="{{ $child->resolved_url }}">{{ $child->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->url() === url($item->url ?: '/') ? 'active' : '' }}" href="{{ $item->resolved_url }}">{{ $item->title }}</a>
                            </li>
                        @endif
                    @endforeach
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('contact') }}" class="btn btn-brand btn-sm">Talk to Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
