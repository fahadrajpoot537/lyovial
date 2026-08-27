<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $seo = $seo ?? null;
        $metaTitle = $seo?->meta_title ?? $seo?->seo_title ?? ($defaultSeo['default_meta_title'] ?? $siteName);
        $metaDescription = $seo?->meta_description ?? ($defaultSeo['default_meta_description'] ?? '');
        $metaKeywords = $seo?->meta_keywords ?? ($defaultSeo['default_meta_keywords'] ?? '');
        $canonical = $seo?->canonical_url ?? url()->current();
        $canonical = \App\Support\SeoHelper::normalizePublicUrl((string) $canonical);
        $ogTitle = $seo?->og_title ?? $metaTitle;
        $ogDescription = $seo?->og_description ?? $metaDescription;
        $ogImage = storage_url($seo?->og_image ?? ($defaultSeo['default_og_image'] ?? null));
        $robots = $seo?->robots_meta ?: ((($seo?->indexable ?? true) ? 'index' : 'noindex').', '.(($seo?->followable ?? true) ? 'follow' : 'nofollow'));
        $twitterImage = storage_url($seo?->twitter_image) ?: $ogImage;
    @endphp

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    @if($metaKeywords)<meta name="keywords" content="{{ $metaKeywords }}">@endif
    <meta name="robots" content="{{ $robots }}">
    <link rel="canonical" href="{{ $canonical }}">

    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonical }}">
    @if($ogImage)<meta property="og:image" content="{{ $ogImage }}">@endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo?->twitter_title ?? $ogTitle }}">
    <meta name="twitter:description" content="{{ $seo?->twitter_description ?? $ogDescription }}">
    @if($twitterImage)
        <meta name="twitter:image" content="{{ $twitterImage }}">
    @endif

    @if(!empty($seo?->schema_json))
        <script type="application/ld+json">{!! $seo->schema_json !!}</script>
    @endif

    @include('front.partials.favicon')

    @php $liteFront = ! empty($liteFront); @endphp
    <link rel="preload" href="{{ asset('assets/front/fonts/inter-latin-400.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/front/fonts/inter-latin-700.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link href="{{ asset('assets/front/css/lyovial-home.css') }}?v={{ filemtime(public_path('assets/front/css/lyovial-home.css')) }}" rel="stylesheet">
    @unless($liteFront)
      <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" media="print" onload="this.media='all'">
      <noscript><link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"></noscript>
    @endunless
    @stack('head')
    <style>
        /* Brand + typography overrides (beat Bootstrap / site.css) */
        body.lyovial-home-page {
            font-family: 'Inter', sans-serif !important;
            color: #4A5A67 !important;
            background: #fff !important;
        }
        body.lyovial-home-page h1,
        body.lyovial-home-page h2,
        body.lyovial-home-page h3,
        body.lyovial-home-page .brand-text,
        body.lyovial-home-page .display-font {
            font-family: 'Inter', sans-serif !important;
        }
        body.lyovial-home-page a { color: inherit; text-decoration: none; }
        body.lyovial-home-page a:hover { color: inherit; }

        /* Navbar — match HTML theme (avoid Bootstrap .nav) */
        @media (min-width: 993px) {
            .lyovial-home-page .header .header-nav {
                align-items: center;
                gap: 28px;
                margin: 0;
                padding: 0;
                list-style: none;
            }
            .lyovial-home-page .header .header-nav > a,
            .lyovial-home-page .header .header-nav .nav-drop-toggle {
                font-size: 14px !important;
                font-weight: 500 !important;
            }
        }
        .lyovial-home-page .header .header-nav > a,
        .lyovial-home-page .header .header-nav .nav-drop-toggle {
            color: #fff !important;
            letter-spacing: .2px;
            background: transparent !important;
            border: 0 !important;
            box-shadow: none !important;
        }
        @media (max-width: 992px) {
            .lyovial-home-page .header .header-nav {
                display: none !important;
            }
            .lyovial-home-page .header.nav-open .header-nav {
                display: flex !important;
            }
            .lyovial-home-page .header .nav-dropdown:hover > .nav-drop-menu,
            .lyovial-home-page .header .nav-dropdown:focus-within > .nav-drop-menu {
                display: none !important;
            }
            .lyovial-home-page .header .nav-dropdown.is-open > .nav-drop-menu {
                display: block !important;
            }
        }
        .lyovial-home-page .header .header-nav > a:hover,
        .lyovial-home-page .header .header-nav .nav-drop-toggle:hover {
            color: #14a0ad !important;
        }
        .lyovial-home-page .header .nav-drop-menu a {
            white-space: normal !important;
            padding: 10px 18px !important;
            color: #fff !important;
        }
        .lyovial-home-page .header .nav-drop-menu a:hover {
            background: rgba(255,255,255,.12) !important;
            color: #fff !important;
        }
        .lyovial-home-page .header .nav-drop-heading {
            color: rgba(255,255,255,.55) !important;
        }
        .lyovial-home-page .header-cta,
        .lyovial-home-page .header-cta a,
        .lyovial-home-page .header-cta strong {
            color: #fff !important;
        }
        .lyovial-home-page .header-cta .phone-icon { color: #fff !important; }
        .lyovial-home-page .header-cta .phone-txt small { color: #fff !important; opacity: 1 !important; }
        .lyovial-home-page .header-cta a.nav-contact-btn {
            color: #0e7c86 !important;
            background: #fff !important;
        }
        .lyovial-home-page .header-cta a.nav-contact-btn:hover {
            color: #fff !important;
            background: transparent !important;
            outline: 1.5px solid #fff;
        }

        /* Buttons */
        .lyovial-home-page .btn.btn-primary,
        .lyovial-home-page a.btn.btn-primary {
            background: #0e7c86 !important;
            border: 1.5px solid #0e7c86 !important;
            color: #fff !important;
            box-shadow: 0 4px 14px rgba(14,124,134,.35) !important;
            border-radius: 6px !important;
            padding: 16px 32px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
        }
        .lyovial-home-page .btn.btn-primary:hover,
        .lyovial-home-page a.btn.btn-primary:hover,
        .lyovial-home-page .partner a.btn.btn-primary:hover {
            background: #fff !important;
            border-color: #fff !important;
            color: #0e7c86 !important;
        }
        .lyovial-home-page .partner a.btn.btn-primary {
            background: #0e7c86 !important;
            border: 1.5px solid #fff !important;
            color: #fff !important;
        }
        .lyovial-home-page .about a.btn.btn-primary {
            background: #0e7c86 !important;
            border: 1.5px solid #0e7c86 !important;
            color: #fff !important;
        }
        .lyovial-home-page .about a.btn.btn-primary:hover {
            background: #fff !important;
            border-color: #0e7c86 !important;
            color: #0e7c86 !important;
        }
        .lyovial-home-page .btn-brand {
            background: #0e7c86 !important;
            border: 1.5px solid #0e7c86 !important;
            color: #fff !important;
        }
        .lyovial-home-page .btn-brand:hover {
            background: #fff !important;
            border-color: #0e7c86 !important;
            color: #0e7c86 !important;
        }

        /* Section headings / dark text → brand teal */
        .lyovial-home-page .eyebrow,
        .lyovial-home-page .section-head h2,
        .lyovial-home-page .why-content h2,
        .lyovial-home-page .coverage-head h2,
        .lyovial-home-page .service-body h3,
        .lyovial-home-page .why-feature h3,
        .lyovial-home-page .partner-card h3,
        .lyovial-home-page .blog-body h3,
        .lyovial-home-page .coverage-item strong,
        .lyovial-home-page .blog-author strong,
        .lyovial-home-page .read-more,
        .lyovial-home-page .lyovial-faq .section-title {
            color: #0e7c86 !important;
        }
        .lyovial-home-page .read-more:hover {
            background: #0e7c86 !important;
            color: #fff !important;
        }
        .lyovial-home-page .read-more:hover svg {
            stroke: #fff !important;
            color: #fff !important;
        }
        .lyovial-home-page .eyebrow::before {
            background: #0e7c86 !important;
        }
        .lyovial-home-page .blog-head {
            text-align: left !important;
        }
        .lyovial-home-page .blog-head h2 {
            text-align: left !important;
            color: #0e7c86 !important;
        }
        .lyovial-home-page .section-head p,
        .lyovial-home-page .why-content > p,
        .lyovial-home-page .why-feature p,
        .lyovial-home-page .service-body p,
        .lyovial-home-page .partner-card p,
        .lyovial-home-page .coverage-head p {
            color: #4A5A67 !important;
        }
        .lyovial-home-page .about { background: #fff !important; color: #000 !important; }
        .lyovial-home-page .about .eyebrow { color: #0e7c86 !important; }
        .lyovial-home-page .about .eyebrow::before { background: #0e7c86 !important; }
        .lyovial-home-page .about h2 { color: #0e7c86 !important; }
        .lyovial-home-page .about p { color: #000 !important; }
        .lyovial-home-page .stats { background: #0e7c86 !important; }
        .lyovial-home-page .stat,
        .lyovial-home-page .stat-num,
        .lyovial-home-page .stat-label { color: #fff !important; }
        .lyovial-home-page .stat-icon { color: #fff !important; background: rgba(255,255,255,.15) !important; }
        .lyovial-home-page .stat-icon svg { stroke: #fff !important; }
        .lyovial-home-page .hero h1,
        .lyovial-home-page .hero p { color: #fff !important; }
        .lyovial-home-page .partner-head h2 { color: #fff !important; }
        .lyovial-home-page .partner-head .eyebrow { color: #fff !important; }
        .lyovial-home-page .partner-head .eyebrow::before { background: #fff !important; }

        .lyovial-home-page .site-footer {
            position: relative;
            z-index: 5;
            background: #0e7c86 !important;
            color: #fff !important;
        }
        .lyovial-home-page .site-footer .brand-text,
        .lyovial-home-page .site-footer h3,
        .lyovial-home-page .site-footer h4 {
            color: #fff !important;
            font-family: 'Inter', sans-serif !important;
            font-weight: 600 !important;
            letter-spacing: .04em;
        }
        .lyovial-home-page .site-footer a {
            color: #fff !important;
            font-weight: 400 !important;
        }
        .lyovial-home-page .site-footer a:hover { color: #fff !important; opacity: .9; }
        .lyovial-home-page .site-footer .footer-text {
            color: #fff !important;
            font-size: 1rem !important;
            font-weight: 400 !important;
            line-height: 1.65 !important;
            opacity: 1 !important;
        }
        .lyovial-home-page .site-footer .footer-links a {
            font-size: .95rem !important;
            font-weight: 400 !important;
        }
        .lyovial-home-page .site-footer .footer-bottom {
            color: #fff !important;
            font-weight: 400 !important;
            border-top: 1px solid rgba(255,255,255,.28) !important;
        }
        .lyovial-home-page .site-footer .btn-brand {
            background: #fff !important;
            border-color: #fff !important;
            color: #0e7c86 !important;
            font-weight: 700 !important;
        }
        .lyovial-home-page .site-footer .btn-brand:hover {
            background: transparent !important;
            border-color: #fff !important;
            color: #fff !important;
        }

        .lyovial-faq {
            background: var(--off-white, #F5F7F8);
            padding: 100px 0;
        }
        .lyovial-faq .section-title { color: #0e7c86 !important; font-size: 38px; font-weight: 800; font-family: 'Inter', sans-serif !important; }
        .lyovial-faq .eyebrow { color: #0e7c86 !important; }
        .lyovial-faq p,
        .lyovial-faq .text-secondary { color: #000 !important; }
        .lyovial-faq .accordion-button { color: #000 !important; font-family: 'Inter', sans-serif !important; font-weight: 600 !important; }
        .lyovial-faq .accordion-button:not(.collapsed) { background: #fff; color: #000 !important; box-shadow: none; }
        .lyovial-faq .accordion-button:focus { box-shadow: none; border-color: var(--border, #E1E6E9); }
        .lyovial-faq .accordion-item { border-color: var(--border, #E1E6E9); }
        .lyovial-faq .accordion-body,
        .lyovial-faq .accordion-body.text-secondary { color: #000 !important; }
    </style>
    @stack('styles')
</head>
<body class="lyovial-home-page">
    @if(session('success'))
        <div class="container pt-3" style="position:relative;z-index:30">
            <div class="alert alert-success mb-0">{{ session('success') }}</div>
        </div>
    @endif

    @yield('content')

    @include('front.partials.footer')

    @unless($liteFront)
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    @endunless
    <script>
        (function () {
            const header = document.getElementById('lyovialNav') || document.querySelector('.header.lyovial-nav');
            if (!header) return;

            const hamburger = header.querySelector('.hamburger');
            const nav = header.querySelector('.header-nav');
            const mobileNav = window.matchMedia('(max-width: 992px)');
            let lockScrollY = 0;

            const closeDropdowns = () => {
                header.querySelectorAll('.nav-dropdown.is-open').forEach((el) => {
                    el.classList.remove('is-open');
                    const btn = el.querySelector('[data-nav-toggle]');
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                });
            };

            const lockPage = (lock) => {
                const locked = document.body.classList.contains('nav-drawer-open');
                if (lock) {
                    if (locked) return;
                    lockScrollY = window.scrollY || 0;
                    document.body.classList.add('nav-drawer-open');
                    document.body.style.top = '-' + lockScrollY + 'px';
                    document.body.style.position = 'fixed';
                    document.body.style.width = '100%';
                    return;
                }
                if (!locked) return;
                document.body.classList.remove('nav-drawer-open');
                document.body.style.position = '';
                document.body.style.top = '';
                document.body.style.width = '';
                window.scrollTo(0, lockScrollY);
            };

            const closeMenu = () => {
                header.classList.remove('nav-open');
                closeDropdowns();
                if (hamburger) hamburger.setAttribute('aria-expanded', 'false');
                lockPage(false);
            };

            hamburger?.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const open = !header.classList.contains('nav-open');
                header.classList.toggle('nav-open', open);
                this.setAttribute('aria-expanded', open ? 'true' : 'false');
                if (open) {
                    closeDropdowns();
                    lockPage(true);
                } else {
                    closeMenu();
                }
            });

            header.querySelectorAll('[data-nav-toggle]').forEach((btn) => {
                btn.addEventListener('click', function (e) {
                    if (!mobileNav.matches) return;
                    e.preventDefault();
                    e.stopPropagation();
                    const wrap = this.closest('.nav-dropdown');
                    const willOpen = !wrap.classList.contains('is-open');
                    closeDropdowns();
                    if (willOpen) {
                        wrap.classList.add('is-open');
                        this.setAttribute('aria-expanded', 'true');
                        window.requestAnimationFrame(() => {
                            wrap.scrollIntoView({ block: 'nearest', inline: 'nearest' });
                        });
                    }
                    this.blur();
                });
            });

            nav?.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => {
                    if (mobileNav.matches) closeMenu();
                });
            });

            document.addEventListener('click', (e) => {
                if (!header.contains(e.target)) closeMenu();
            });

            let resizeTimer = 0;
            window.addEventListener('resize', () => {
                window.clearTimeout(resizeTimer);
                resizeTimer = window.setTimeout(() => {
                    if (!mobileNav.matches) closeMenu();
                }, 150);
            });

            let stickyTicking = false;
            const onScroll = () => {
                if (document.body.classList.contains('nav-drawer-open')) return;
                if (stickyTicking) return;
                stickyTicking = true;
                window.requestAnimationFrame(() => {
                    header.classList.toggle('is-sticky', window.scrollY > 40);
                    stickyTicking = false;
                });
            };
            onScroll();
            window.addEventListener('scroll', onScroll, { passive: true });
        })();
    </script>
    @stack('scripts')
</body>
</html>
