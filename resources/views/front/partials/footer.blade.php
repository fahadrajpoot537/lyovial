@php
    $footerCms = $homeFooter ?? null;
    $talk = $readyToTalk ?? null;
    $footerLogo = $footerCms?->image;
    if (filled($footerLogo) && ! str_starts_with($footerLogo, 'http') && ! str_starts_with($footerLogo, '/')) {
        $footerLogo = storage_url($footerLogo);
    }
    if (! filled($footerLogo) && filled($siteLogo)) {
        $footerLogo = storage_url($siteLogo);
    }
    $footerLogo = $footerLogo ?: asset('assets/front/images/lyovial-home/logo-white.png');
    $footerTagline = filled($footerCms?->description)
        ? strip_tags($footerCms->description)
        : ($footerCms?->heading ?: 'Pilot-scale vial lyophilization for diagnostics, reagents, and research across Canada.');
    $exploreHeading = $footerCms?->extra['explore_heading'] ?? 'Explore';
    $capsHeading = $footerCms?->extra['capabilities_heading'] ?? 'Capabilities';
    $talkHeading = $talk?->heading ?: ($footerCms?->extra['cta_heading'] ?? 'Ready to talk?');
    $talkBody = filled($talk?->description) ? strip_tags($talk->description) : 'Share your product goals and our Kanata team will help map the next step.';
    $talkBtn = $talk?->button_primary_text ?: ($footerCms?->button_primary_text ?: 'Contact LyoVial');
    $talkLink = $talk?->button_primary_link ?: ($footerCms?->button_primary_link ?: route('contact'));
    if ($talkLink && ! str_starts_with($talkLink, 'http') && ! str_starts_with($talkLink, 'tel:') && ! str_starts_with($talkLink, '#')) {
        $talkLink = url($talkLink);
    }
    $copyright = $footerCms?->extra['copyright'] ?? $siteCopyright;
    $legalLabel = $footerCms?->extra['legal_label'] ?? 'Privacy Policy';
    $legalUrl = $footerCms?->extra['legal_url'] ?? url('/privacy-policy');
    $credit = $footerCms?->extra['credit'] ?? 'Created by <a href="https://kodrank.com/" target="_blank" rel="noopener noreferrer">KodRank</a>';
@endphp
<footer class="site-footer">
    <div class="container footer-inner">
        <div class="footer-grid">
            <div>
                <a href="{{ route('home') }}" class="d-inline-block" style="display:inline-block;margin-bottom:1rem">
                    <img
                        src="{{ $footerLogo }}"
                        alt="{{ $footerCms?->small_title ?: $siteName }}"
                        class="footer-logo"
                        width="160"
                        height="36"
                    >
                </a>
                <p class="footer-text" style="margin-bottom:1rem">{{ $footerTagline }}</p>
                <p class="footer-text" style="margin-bottom:.35rem">
                    <svg class="footer-ico" viewBox="0 0 16 16" aria-hidden="true"><path fill="currentColor" d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>
                    {!! nl2br(e($siteAddress)) !!}
                </p>
                @if($sitePhone)
                    <p class="footer-text" style="margin-bottom:.35rem">
                        <svg class="footer-ico" viewBox="0 0 16 16" aria-hidden="true"><path fill="currentColor" d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58z"/></svg>
                        <a href="tel:{{ preg_replace('/\D+/', '', $sitePhone) }}">{{ $sitePhone }}</a>
                    </p>
                @endif
                @if($siteEmail)
                    <p class="footer-text" style="margin-bottom:0">
                        <svg class="footer-ico" viewBox="0 0 16 16" aria-hidden="true"><path fill="currentColor" d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z"/></svg>
                        <a href="mailto:{{ $siteEmail }}">{{ $siteEmail }}</a>
                    </p>
                @endif
            </div>
            <div>
                <h4 style="margin:0 0 1rem;text-transform:uppercase;letter-spacing:.04em">{{ $exploreHeading }}</h4>
                <ul class="footer-links">
                    @forelse($footerMenus as $item)
                        <li><a href="{{ $item->resolved_url }}">{{ $item->title }}</a></li>
                    @empty
                        <li><a href="{{ url('/about') }}">About</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    @endforelse
                </ul>
            </div>
            <div>
                <h4 style="margin:0 0 1rem;text-transform:uppercase;letter-spacing:.04em">{{ $capsHeading }}</h4>
                <ul class="footer-links">
                    @foreach($navServices as $service)
                        <li><a href="{{ url('/capabilities/'.$service->slug) }}">{{ $service->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            @if(!$talk || $talk->is_active)
            <div class="footer-cta">
                <h4 style="margin:0 0 1rem;text-transform:uppercase;letter-spacing:.04em">{{ $talkHeading }}</h4>
                <p class="footer-text">{{ $talkBody }}</p>
                <a href="{{ $talkLink }}" class="btn btn-brand">{{ $talkBtn }}</a>
            </div>
            @endif
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <span>{{ $copyright }}</span>
            <nav class="footer-legal" aria-label="Legal">
                <a href="{{ $legalUrl }}">{{ $legalLabel }}</a>
            </nav>
            <span class="footer-credit">{!! $credit !!}</span>
        </div>
    </div>
</footer>
