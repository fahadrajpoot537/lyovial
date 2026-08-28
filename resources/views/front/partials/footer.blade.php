<footer class="site-footer">
    <div class="container footer-inner">
        <div class="footer-grid">
            <div>
                <a href="{{ route('home') }}" class="d-inline-block" style="display:inline-block;margin-bottom:1rem">
                    <img
                        src="{{ asset('assets/front/images/lyovial-home/logo-white.png') }}"
                        alt="{{ $siteName }}"
                        class="footer-logo"
                        width="160"
                        height="36"
                    >
                </a>
                <p class="footer-text" style="margin-bottom:1rem">Pilot-scale vial lyophilization for diagnostics, reagents, and research across Canada.</p>
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
                <h4 style="margin:0 0 1rem;text-transform:uppercase;letter-spacing:.04em">Explore</h4>
                <ul class="footer-links">
                    @php
                        $exploreTitles = collect($footerMenus)->pluck('title')->map(fn ($title) => strtolower($title));
                    @endphp
                    @foreach($footerMenus as $item)
                        @continue(str_contains(strtolower($item->title), 'capabilities') || str_contains(strtolower($item->title), 'services'))
                        <li><a href="{{ $item->resolved_url }}">{{ $item->title }}</a></li>
                    @endforeach
                    @unless($exploreTitles->contains('about'))
                        <li><a href="{{ url('/about') }}">About</a></li>
                    @endunless
                    @unless($exploreTitles->contains('contact'))
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    @endunless
                </ul>
            </div>
            <div>
                <h4 style="margin:0 0 1rem;text-transform:uppercase;letter-spacing:.04em">Capabilities</h4>
                <ul class="footer-links">
                    @foreach($navServices as $service)
                        <li><a href="{{ url('/capabilities/'.$service->slug) }}">{{ $service->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="footer-cta">
                <h4 style="margin:0 0 1rem;text-transform:uppercase;letter-spacing:.04em">Ready to talk?</h4>
                <p class="footer-text">Share your product goals and our Kanata team will help map the next step.</p>
                <a href="{{ route('contact') }}" class="btn btn-brand">Contact LyoVial</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <span>{{ $siteCopyright }}</span>
            <nav class="footer-legal" aria-label="Legal">
                <a href="{{ route('pages.privacy') }}">Privacy Policy</a>
            </nav>
            <span class="footer-credit">Created by <a href="https://kodrank.com/" target="_blank" rel="noopener noreferrer">KodRank</a></span>
        </div>
    </div>
</footer>
