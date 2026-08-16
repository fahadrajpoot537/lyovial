<footer class="site-footer">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <a href="{{ route('home') }}" class="d-inline-block mb-3">
                    <img
                        src="{{ asset('assets/front/images/lyovial-home/logo-white.png') }}"
                        alt="{{ $siteName }}"
                        class="footer-logo"
                        style="filter:brightness(0) invert(1) opacity(.95);height:36px;width:auto"
                    >
                </a>
                <p class="footer-text mb-3">Pilot-scale vial lyophilization for diagnostics, reagents, and research across Canada.</p>
                <p class="footer-text mb-1"><i class="bi bi-geo-alt me-2"></i>{!! nl2br(e($siteAddress)) !!}</p>
                @if($sitePhone)<p class="footer-text mb-1"><i class="bi bi-telephone me-2"></i><a href="tel:{{ preg_replace('/\D+/', '', $sitePhone) }}">{{ $sitePhone }}</a></p>@endif
                @if($siteEmail)<p class="footer-text mb-0"><i class="bi bi-envelope me-2"></i><a href="mailto:{{ $siteEmail }}">{{ $siteEmail }}</a></p>@endif
            </div>
            <div class="col-6 col-lg-2">
                <h4 class="h6 text-uppercase mb-3">Explore</h4>
                <ul class="list-unstyled footer-links">
                    @foreach($footerMenus as $item)
                        @continue(str_contains(strtolower($item->title), 'capabilities') || str_contains(strtolower($item->title), 'services'))
                        <li><a href="{{ $item->resolved_url }}">{{ $item->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-6 col-lg-3">
                <h4 class="h6 text-uppercase mb-3">Capabilities</h4>
                <ul class="list-unstyled footer-links">
                    @foreach($navServices as $service)
                        <li><a href="{{ url('/capabilities/'.$service->slug) }}">{{ $service->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3">
                <h4 class="h6 text-uppercase mb-3">Ready to talk?</h4>
                <p class="footer-text">Share your product goals and our Kanata team will help map the next step.</p>
                <a href="{{ route('contact') }}" class="btn btn-brand">Contact LyoVial</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container py-3 d-flex flex-column flex-md-row justify-content-between gap-2 small">
            <span>{{ $siteCopyright }}</span>
        </div>
    </div>
</footer>
