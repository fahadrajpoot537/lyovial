(() => {
    const text = (selector, value) => {
        const el = document.querySelector(selector);
        if (el && value) el.textContent = value;
    };

    const html = (selector, value) => {
        const el = document.querySelector(selector);
        if (el && value != null) el.innerHTML = value;
    };

    const attr = (selector, key, value) => {
        const el = document.querySelector(selector);
        if (el && value) el.setAttribute(key, value);
    };

    const textIn = (root, selector, value) => {
        const el = root.querySelector(selector);
        if (el && value) el.textContent = value;
    };

    const storageUrl = (path) => {
        if (!path) return '';
        if (path.startsWith('http') || path.startsWith('/')) return path;
        return `/storage/${path}`;
    };

    /** Seeded demo assets count as placeholders until a real CMS upload exists. */
    const isPlaceholderPath = (path) => {
        if (path == null) return true;
        const value = String(path).trim();
        if (!value) return true;
        const lower = value.toLowerCase();
        return lower.includes('/demo/') || lower.startsWith('demo/') || lower.includes('case-stady') || lower.includes('laboix') || lower.includes('unsplash.com');
    };

    /** Prefer real CMS upload; otherwise content-matched fallback URL. */
    const resolveImg = (path, fallback) => {
        if (isPlaceholderPath(path)) return fallback || '';
        return storageUrl(path);
    };

    const FALLBACK_IMAGES = {
        logo: '/theme/assets/images/lyovial/logo.png',
        hero: '/theme/assets/images/lyovial/banner-ab.jpg',
        about: '/theme/assets/images/lyovial/about.jpg',
        canada: '/theme/assets/images/lyovial/canada.jpg',
        ready: '/theme/assets/images/lyovial/ready.jpg',
        services: [
            '/theme/assets/images/lyovial/svc-1.jpg',
            '/theme/assets/images/lyovial/svc-2.jpg',
            '/theme/assets/images/lyovial/svc-3.jpg',
        ],
        industries: [
            '/theme/assets/images/lyovial/ind-1.jpg',
            '/theme/assets/images/lyovial/ind-2.jpg',
            '/theme/assets/images/lyovial/ind-3.jpg',
            '/theme/assets/images/lyovial/ind-4.jpg',
            '/theme/assets/images/lyovial/ind-5.jpg',
            '/theme/assets/images/lyovial/ind-6.jpg',
        ],
    };

    const stripHtml = (value) => (value || '').replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim();

    const pageKey = (() => {
        const path = window.location.pathname.replace(/\/+$/, '') || '/';
        if (path === '/') return 'home';
        if (path === '/capabilities' || path === '/services') return 'services';
        if (path.startsWith('/capabilities/') || path.startsWith('/services/')) return 'service-detail';
        if (path.startsWith('/industries')) return 'industries';
        if (path === '/contact') return 'contact';
        if (path === '/quality-compliance') return 'quality';
        if (path === '/specimen-library-preservation') return 'specimen';
        return 'other';
    })();

    fetch('/theme/cms-data', { headers: { Accept: 'application/json' } })
        .then((res) => res.json())
        .then((data) => {
            if (!data) return;

            const site = data.site || {};
            const sections = data.sections || {};
            const contact = data.contact || {};

            if (pageKey === 'home') {
                document.title = `${site.name || 'LyoVial'} | Home`;
            } else if (site.name && document.title) {
                document.title = document.title.replace(/Laboix|LABOIX|laboix/gi, site.name);
            }

            document.querySelectorAll('.main-header__logo img, .footer-widget__logo img, .logo-box img').forEach((img) => {
                img.src = resolveImg(site.logo_url, FALLBACK_IMAGES.logo);
                img.alt = site.name || 'LyoVial';
            });
            document.querySelectorAll('a[href="index.html"], a[href="index-2.html"], a[href="/theme/index-2.html"]').forEach((a) => {
                a.href = '/';
            });

            text('.main-header__right__content__number', site.phone);
            attr('.main-header__right__call', 'href', site.phone ? `tel:${site.phone.replace(/\D+/g, '')}` : '#');
            text('.main-header__right__content__text', 'Call us anytime');

            const menuRoot = document.querySelector('.main-menu__list');
            if (menuRoot && Array.isArray(data.menus) && data.menus.length) {
                menuRoot.innerHTML = data.menus
                    .map((item) => {
                        const hasChildren = item.children && item.children.length;
                        const isDropdown = item.is_dropdown || hasChildren;

                        if (isDropdown) {
                            return `
                                <li class="dropdown">
                                    <a href="#" class="js-dropdown-only">${item.title || ''}</a>
                                    <ul>
                                        ${(item.children || [])
                                            .map((child) => `<li><a href="${child.url || '#'}">${child.title || ''}</a></li>`)
                                            .join('')}
                                    </ul>
                                </li>
                            `;
                        }

                        return `<li><a href="${item.url || '#'}">${item.title || ''}</a></li>`;
                    })
                    .join('');

                menuRoot.querySelectorAll('a.js-dropdown-only').forEach((a) => {
                    a.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        const li = a.closest('.dropdown');
                        if (!li) return;
                        document.querySelectorAll('.main-menu__list > .dropdown.current').forEach((el) => {
                            if (el !== li) el.classList.remove('current');
                        });
                        li.classList.toggle('current');
                    });
                });
            }

            const mobileContainer = document.querySelector('.mobile-nav__container');
            if (mobileContainer && menuRoot) {
                mobileContainer.innerHTML = `<ul class="main-menu__list">${menuRoot.innerHTML}</ul>`;
                mobileContainer.querySelectorAll('a.js-dropdown-only').forEach((a) => {
                    a.addEventListener('click', (e) => {
                        e.preventDefault();
                        const li = a.closest('li');
                        if (li) li.classList.toggle('current');
                    });
                });
            }

            text('.mobile-nav__contact a[href^="mailto"]', site.email);
            attr('.mobile-nav__contact a[href^="mailto"]', 'href', site.email ? `mailto:${site.email}` : '#');
            const mobilePhone = document.querySelector('.mobile-nav__contact a[href^="tel"]');
            if (mobilePhone && site.phone) {
                mobilePhone.textContent = site.phone;
                mobilePhone.href = `tel:${site.phone.replace(/\D+/g, '')}`;
            }

            if (pageKey === 'home') {
                const setTag = (rootSel, title) => {
                    const tag = document.querySelector(`${rootSel} .sec-title__tagline`);
                    if (!tag || !title) return;
                    const img = tag.querySelector('img');
                    tag.innerHTML = '';
                    if (img) tag.appendChild(img);
                    tag.append(document.createTextNode(title));
                };

                const hero = sections.hero || {};
                if (hero.heading) {
                    document.querySelectorAll('.main-slider-two__title').forEach((el) => {
                        el.textContent = hero.heading;
                    });
                }
                if (hero.description) {
                    const desc = stripHtml(hero.description);
                    const eyebrow = hero.small_title
                        ? `<li class="main-slider-two__list__item">${hero.small_title}</li>`
                        : '';
                    document.querySelectorAll('.main-slider-two__list').forEach((list) => {
                        list.innerHTML = eyebrow + `<li class="main-slider-two__list__item">${desc}</li>`;
                    });
                }
                const heroPrimary = document.querySelector('.main-slider-two__btn .laboix-btn:not(.cms-hero-secondary)');
                if (heroPrimary && hero.button_primary_text) {
                    heroPrimary.textContent = hero.button_primary_text;
                    heroPrimary.href = hero.button_primary_link || '/contact';
                }
                const heroSecondary = document.querySelector('.main-slider-two__btn .cms-hero-secondary');
                if (heroSecondary && hero.button_secondary_text) {
                    heroSecondary.textContent = hero.button_secondary_text;
                    heroSecondary.href = hero.button_secondary_link || '/capabilities';
                }
                {
                    const url = resolveImg(hero.image, FALLBACK_IMAGES.hero);
                    document.querySelectorAll('.main-slider-two__bg').forEach((bg) => {
                        bg.style.backgroundImage = `url(${url})`;
                    });
                    document.querySelectorAll('.main-slider-two__image__item img').forEach((img) => {
                        img.src = url;
                        img.alt = hero.image_alt || site.name || 'LyoVial';
                    });
                }

                const about = sections.about || {};
                setTag('.about-three', about.small_title);
                text('.about-three .sec-title__title', about.heading);
                const aboutText = document.querySelector('.about-three__top__text');
                if (aboutText && about.description) aboutText.innerHTML = about.description;
                if (about.button_primary_text) {
                    const aboutBtn = document.querySelector('.about-three__link__btn');
                    if (aboutBtn) {
                        aboutBtn.textContent = about.button_primary_text;
                        aboutBtn.href = about.button_primary_link || '/quality-compliance';
                    }
                }
                {
                    const aboutImg = document.querySelector('.about-three__image__item img');
                    if (aboutImg) {
                        aboutImg.src = resolveImg(about.image, FALLBACK_IMAGES.about);
                        aboutImg.alt = about.image_alt || 'Who Is LyoVial';
                    }
                }

                const servicesSec = sections.services || {};
                setTag('.service-two', servicesSec.small_title);
                text('.service-two .sec-title__title', servicesSec.heading);
                text('.cms-services-intro', stripHtml(servicesSec.description));
                const serviceIcons = ['icon-artificial-intelligence-2', 'icon-dna-1', 'icon-pathology-2-1'];
                const serviceRow = document.querySelector('.service-two .row.gutter-y-30');
                if (serviceRow && Array.isArray(data.services)) {
                    serviceRow.innerHTML = data.services.slice(0, 3).map((item, i) => {
                        const img = resolveImg(item.image_url, FALLBACK_IMAGES.services[i % FALLBACK_IMAGES.services.length]);
                        return `
                        <div class="col-lg-4 col-md-6">
                            <a href="${item.url || '/capabilities'}" class="service-two__item service-two__item--link wow fadeInUp" data-wow-duration="500ms" data-wow-delay="${300 + i * 100}ms">
                                <div class="service-two__thumb">
                                    <img src="${img}" alt="${item.title || 'LyoVial service'}">
                                </div>
                                <div class="service-two__icon"><i class="${serviceIcons[i % serviceIcons.length]}"></i></div>
                                <div class="service-two__content">
                                    <h4 class="service-two__title">${item.title || ''}</h4>
                                    <p class="service-two__text">${item.description || ''}</p>
                                </div>
                            </a>
                        </div>`;
                    }).join('');
                }

                const industriesSec = sections.industries || {};
                setTag('.case-studies-two', industriesSec.small_title);
                text('.case-studies-two .sec-title__title', industriesSec.heading);
                text('.cms-industries-intro', stripHtml(industriesSec.description));
                const industriesGrid = document.querySelector('.cms-industries-grid');
                if (industriesGrid && Array.isArray(data.industries)) {
                    industriesGrid.innerHTML = data.industries.map((item, i) => {
                        const img = resolveImg(item.image_url, FALLBACK_IMAGES.industries[i % FALLBACK_IMAGES.industries.length]);
                        return `
                        <div class="col-lg-4 col-md-6">
                            <div class="case-studies-two__item wow fadeInUp" data-wow-duration="700ms" data-wow-delay="${500 + i * 100}ms">
                                <div class="case-studies-two__thumb">
                                    <img src="${img}" alt="${item.title || ''}">
                                </div>
                                <div class="case-studies-two__hover">
                                    <div class="case-studies-two__icon"><i class="icon-diagonostic"></i></div>
                                    <h4 class="case-studies-two__title"><a href="${item.url || '#'}">${item.title || ''}</a></h4>
                                    <p class="case-studies-two__text">${item.description || ''}</p>
                                </div>
                            </div>
                        </div>`;
                    }).join('');
                }

                const why = sections.why_choose || {};
                setTag('.why-choose-us', why.small_title);
                text('.why-choose-us .sec-title__title', why.heading);
                text('.why-choose-us__top__text', stripHtml(why.description));
                const whyIcons = ['icon-trophy-2', 'icon-microscope-1', 'icon-case', 'icon-clients'];
                const whyItems = Array.isArray(data.why_choose_items) ? data.why_choose_items : [];
                const fillWhyRow = (sel, slice, offset) => {
                    const row = document.querySelector(sel);
                    if (!row) return;
                    row.innerHTML = slice.map((item, i) => `
                        <div class="why-choose-us__feature__item">
                            <div class="why-choose-us__feature__icon"><i class="${whyIcons[(offset + i) % whyIcons.length]}"></i></div>
                            <h4 class="why-choose-us__feature__title">${item.title || ''}</h4>
                            <p class="why-choose-us__feature__text">${item.description || ''}</p>
                        </div>`).join('');
                };
                fillWhyRow('.cms-why-row-1', whyItems.slice(0, 2), 0);
                fillWhyRow('.cms-why-row-2', whyItems.slice(2, 4), 2);

                const canada = sections.canada_coverage || {};
                setTag('.our-work-two', canada.small_title);
                text('.our-work-two .sec-title__title', canada.heading);
                text('.cms-canada-intro', stripHtml(canada.description));
                const points = Array.isArray(data.canada_points) ? data.canada_points : [];
                document.querySelectorAll('.cms-canada-points .our-work-two__item__title').forEach((el, i) => {
                    if (!points[i]) return;
                    el.innerHTML = `${points[i].title || ''}<br><span style="font-size:14px;font-weight:500;display:block;margin-top:6px;">${points[i].text || ''}</span>`;
                });
                {
                    const img = document.querySelector('.our-work-two__image img');
                    if (img) {
                        img.src = resolveImg(canada.image, FALLBACK_IMAGES.canada);
                        img.alt = canada.image_alt || 'LyoVial Canada coverage';
                    }
                }

                const mapHtml = canada.map_embed || contact.map_embed;
                if (mapHtml) {
                    const mapInner = document.querySelector('.cms-contact-map-inner');
                    if (mapInner) mapInner.innerHTML = mapHtml;
                }

                const faqSec = sections.faq || {};
                setTag('.faq-page', faqSec.small_title);
                text('.faq-page .sec-title__title', faqSec.heading);
                text('.cms-faq-intro', stripHtml(faqSec.description));
                const faqAcc = document.querySelector('.cms-faq-accordion');
                if (faqAcc && Array.isArray(data.faqs)) {
                    faqAcc.innerHTML = data.faqs.map((faq, i) => `
                        <div class="accrodion${i === 0 ? ' active' : ''}">
                            <div class="accrodion-title">
                                <h4 class="accrodion-title__text">${faq.question || ''}<span class="accrodion-title__icon"></span></h4>
                            </div>
                            <div class="accrodion-content">
                                <div class="inner"><p class="inner__text">${faq.answer || ''}</p></div>
                            </div>
                        </div>`).join('');

                    // Re-bind theme accordion after CMS inject (laboix.js ran earlier)
                    if (window.jQuery) {
                        const $acc = window.jQuery(faqAcc);
                        $acc.find('.accrodion-content').hide();
                        $acc.find('.accrodion.active .accrodion-content').show();
                        $acc.off('click.cmsFaq');
                        $acc.on('click.cmsFaq', '.accrodion-title', function () {
                            const $item = window.jQuery(this).parent();
                            if ($item.hasClass('active')) {
                                $item.removeClass('active');
                                $item.find('.accrodion-content').slideUp();
                                return;
                            }
                            $acc.find('.accrodion').removeClass('active');
                            $acc.find('.accrodion-content').slideUp();
                            $item.addClass('active');
                            $item.find('.accrodion-content').slideDown();
                        });
                    }
                }

                const ready = sections.ready_to_talk || {};
                setTag('.join-us-tow', ready.small_title);
                text('.join-us-tow .sec-title__title', ready.heading);
                text('.cms-ready-text', stripHtml(ready.description));
                const readyBtn = document.querySelector('.join-us-tow__link__btn');
                if (readyBtn && ready.button_primary_text) {
                    readyBtn.textContent = ready.button_primary_text;
                    readyBtn.href = ready.button_primary_link || '/contact';
                }
                {
                    const readyBg = resolveImg(ready.image, FALLBACK_IMAGES.ready);
                    document.querySelectorAll('.join-us-tow__bg').forEach((bg) => {
                        bg.style.backgroundImage = `url(${readyBg})`;
                    });
                }

                text('.contact-two .sec-title__title', contact.form_heading || 'Send a Project Inquiry');
                setTag('.contact-two', contact.small_title || 'Contact With Us');
            }
            if (pageKey === 'services' && Array.isArray(data.services)) {
                document.querySelectorAll('.service-card__title a, .service-one__title a, .services-one__title a, h3 a, h4 a').forEach((link, i) => {
                    const item = data.services[i];
                    if (!item) return;
                    const card = link.closest('[class*="service"]');
                    if (!card) return;
                    link.textContent = item.title;
                    link.href = item.url;
                    const desc = card.querySelector('p');
                    if (desc && item.description) desc.textContent = item.description.slice(0, 140);
                });
            }

            document.querySelectorAll('a[href^="tel:"]').forEach((a) => {
                if (site.phone && (a.closest('.main-header') || a.closest('.contact-two') || a.closest('.contact-one') || a.closest('footer') || a.closest('.mobile-nav__wrapper'))) {
                    if (!a.classList.contains('main-header__right__call') && a.children.length === 0) {
                        a.textContent = site.phone;
                    }
                    a.href = `tel:${site.phone.replace(/\D+/g, '')}`;
                }
            });
            document.querySelectorAll('a[href^="mailto:"]').forEach((a) => {
                if (site.email && (a.closest('.contact-two') || a.closest('.contact-one') || a.closest('footer') || a.closest('.mobile-nav__wrapper'))) {
                    a.textContent = site.email;
                    a.href = `mailto:${site.email}`;
                }
            });

            const contactItems = document.querySelectorAll('.contact-two__content__list__item');
            if (contactItems.length) {
                if (contactItems[0]) {
                    const a = contactItems[0].querySelector('a');
                    if (a && (contact.phone || site.phone)) {
                        const phone = contact.phone || site.phone;
                        a.textContent = phone;
                        a.href = `tel:${phone.replace(/\D+/g, '')}`;
                    }
                }
                if (contactItems[1]) {
                    const a = contactItems[1].querySelector('a');
                    if (a && (contact.email || site.email)) {
                        const email = contact.email || site.email;
                        a.textContent = email;
                        a.href = `mailto:${email}`;
                    }
                }
                if (contactItems[2] && (contact.address || site.address)) {
                    const h = contactItems[2].querySelector('.contact-two__content__text, h4, p, span');
                    if (h) h.innerHTML = (contact.address || site.address).replace(/\n/g, '<br>');
                }
            }

            document.querySelectorAll('form.contact-two__form, form.contact-one__form, form.contact-form-validated, form[action*="sendemail"]').forEach((form) => {
                wireContactForm(form, data);
            });

            document.querySelectorAll('form.footer-widget__newsletter, form.mc-form').forEach((form) => {
                // Skip 404 search forms that reuse mc-form class without EMAIL intent for newsletter footer
                if (!form.querySelector('input[name="EMAIL"], input[name="email"]')) return;
                if (form.classList.contains('error-404__search') || form.classList.contains('search-popup__form')) return;
                wireNewsletterForm(form, data);
            });

            // Avoid dumping full address HTML into the intro blurb (contact column already shows it)
            const footerBlurb = document.querySelector('.footer-widget__text');
            if (footerBlurb) {
                footerBlurb.textContent = stripHtml(
                    sections.footer?.description ||
                        'Pilot-scale contract lyophilization & formulation services. Member of the Evik Diagnostics group.'
                ).slice(0, 160);
            }
            text(
                '.main-footer__copyright',
                site.footer_copyright ||
                    `© ${new Date().getFullYear()} LyoVial. All Rights Reserved. | Contract lyophilization services based in Ottawa, serving Canada-wide.`
            );

            const footerContactItems = document.querySelectorAll('.footer-widget__info__item');
            if (footerContactItems[0] && site.address) {
                footerContactItems[0].innerHTML = `<span class="footer-widget__info__item__text">${site.address.replace(/\n/g, '<br>')}</span>`;
            }
            if (footerContactItems[1] && site.phone) {
                footerContactItems[1].innerHTML = `<i class="icon-telephone-call-1" aria-hidden="true"></i> <a href="tel:${site.phone.replace(/\D+/g, '')}">${site.phone}</a>`;
            }
            if (footerContactItems[2] && site.email) {
                footerContactItems[2].innerHTML = `<i class="icon-email" aria-hidden="true"></i> <a href="mailto:${site.email}">${site.email}</a>`;
            }

            const footerLinks = document.querySelector('.footer-widget--link .footer-widget__links');
            if (footerLinks) {
                footerLinks.innerHTML = [
                    { title: 'Home', url: '/' },
                    { title: 'Capabilities', url: '/capabilities' },
                    { title: 'Industries We Serve', url: '/industries' },
                    { title: 'Quality & Compliance', url: '/quality-compliance' },
                    { title: 'Specimen Library Preservation', url: '/specimen-library-preservation' },
                    { title: 'Contact', url: '/contact' },
                ]
                    .map((item) => `<li class="footer-widget__links__item"><a href="${item.url}">${item.title}</a></li>`)
                    .join('');
            }

            if (Array.isArray(data.services) && data.services.length) {
                const caps = document.querySelector('.footer-widget__capabilities');
                if (caps) {
                    caps.innerHTML =
                        data.services
                            .slice(0, 3)
                            .map((s) => `<li class="footer-widget__links__item"><a href="${s.url || '#'}">${s.title || ''}</a></li>`)
                            .join('') +
                        `<li class="footer-widget__links__item"><a href="/specimen-library-preservation">Specimen Library Preservation</a></li>`;
                }
            }
        })
        .catch((err) => {
            console.error('CMS bind failed:', err);
        });

    function ensureCsrf(form, token) {
        if (!token) return;
        let input = form.querySelector('input[name="_token"]');
        if (!input) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_token';
            form.prepend(input);
        }
        input.value = token;
    }

    function ensureCaptcha(form, siteKey) {
        if (!siteKey || form.querySelector('.g-recaptcha') || form.parentElement?.querySelector('.cms-newsletter-captcha .g-recaptcha')) {
            return;
        }

        const wrap = document.createElement('div');
        wrap.className = 'cms-recaptcha';
        wrap.style.marginTop = '12px';
        wrap.style.marginBottom = '8px';
        wrap.innerHTML = `<div class="g-recaptcha" data-sitekey="${siteKey}"></div>`;

        // Keep theme newsletter input+button row intact — captcha goes below the form
        if (form.classList.contains('footer-widget__newsletter')) {
            const slot = form.parentElement?.querySelector('.cms-newsletter-captcha');
            if (slot) {
                slot.appendChild(wrap);
            } else {
                form.insertAdjacentElement('afterend', wrap);
            }
            renderCaptchaWidgets();
            return;
        }

        wrap.classList.add('form-one__control', 'form-one__control--full');
        const submitControl = form.querySelector('button[type="submit"]')?.closest('.form-one__control');
        if (submitControl && submitControl.parentElement) {
            submitControl.parentElement.insertBefore(wrap, submitControl);
        } else {
            form.appendChild(wrap);
        }
        renderCaptchaWidgets();
    }

    function loadRecaptcha(siteKey) {
        if (!siteKey || window.__lyovialRecaptchaLoading) return;
        if (document.querySelector('script[src*="google.com/recaptcha/api.js"]')) {
            renderCaptchaWidgets();
            return;
        }
        window.__lyovialRecaptchaLoading = true;
        const s = document.createElement('script');
        s.src = 'https://www.google.com/recaptcha/api.js?onload=__lyovialRecaptchaOnload&render=explicit';
        s.async = true;
        s.defer = true;
        window.__lyovialRecaptchaOnload = () => renderCaptchaWidgets();
        document.head.appendChild(s);
    }

    function renderCaptchaWidgets() {
        if (!window.grecaptcha || typeof window.grecaptcha.render !== 'function') return;
        document.querySelectorAll('.g-recaptcha').forEach((el) => {
            if (el.getAttribute('data-widget-id')) return;
            try {
                const id = window.grecaptcha.render(el, {
                    sitekey: el.getAttribute('data-sitekey'),
                });
                el.setAttribute('data-widget-id', String(id));
            } catch (e) {
                // already rendered
            }
        });
    }

    function formStatus(form, message, isError) {
        const host = form.classList.contains('footer-widget__newsletter')
            ? form.parentElement
            : form;
        let box = host?.querySelector('.cms-form-status');
        if (!box) {
            box = document.createElement('div');
            box.className = 'cms-form-status';
            box.style.marginTop = '12px';
            box.style.fontSize = '14px';
            (host || form).appendChild(box);
        }
        box.style.color = isError ? '#b42318' : '#027a48';
        box.textContent = message || '';
    }

    function wireContactForm(form, data) {
        form.action = '/contact';
        form.method = 'POST';
        form.removeAttribute('novalidate');
        form.classList.remove('contact-form-validated');
        // Stop theme jquery.validate / ajax handlers
        if (window.jQuery) {
            window.jQuery(form).removeData('validator');
            window.jQuery(form).off('submit');
        }

        const phone = form.querySelector('input[name="form_phone"]');
        if (phone) {
            phone.name = 'phone';
            phone.removeAttribute('pattern');
            phone.removeAttribute('required');
            phone.placeholder = phone.placeholder || 'Phone';
        }
        const subject = form.querySelector('input[name="subject"]');
        if (subject && !form.querySelector('input[name="company"]')) {
            subject.name = 'company';
            subject.placeholder = 'Company / Subject';
        }
        const message = form.querySelector('textarea');
        if (message && !message.name) message.name = 'message';

        ensureCsrf(form, data.csrf_token);
        if (data.recaptcha_site_key) {
            loadRecaptcha(data.recaptcha_site_key);
            ensureCaptcha(form, data.recaptcha_site_key);
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            e.stopImmediatePropagation();
            formStatus(form, 'Sending…', false);
            const fd = new FormData(form);
            try {
                const res = await fetch('/contact', {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: fd,
                });
                const json = await res.json().catch(() => ({}));
                if (!res.ok) {
                    const first =
                        json.message ||
                        (json.errors && Object.values(json.errors).flat()[0]) ||
                        'Unable to send message.';
                    formStatus(form, first, true);
                    resetCaptcha(form);
                    return;
                }
                form.reset();
                resetCaptcha(form);
                formStatus(form, json.message || 'Message sent. Thank you!', false);
            } catch (err) {
                formStatus(form, 'Network error. Please try again.', true);
            }
        }, true);
    }

    function wireNewsletterForm(form, data) {
        form.action = '/newsletter';
        form.method = 'POST';
        form.classList.remove('mc-form');
        form.removeAttribute('data-url');
        if (window.jQuery) {
            window.jQuery(form).off('submit');
        }

        const emailInput = form.querySelector('input[name="EMAIL"]');
        if (emailInput) emailInput.name = 'email';

        ensureCsrf(form, data.csrf_token);
        if (data.recaptcha_site_key) {
            loadRecaptcha(data.recaptcha_site_key);
            ensureCaptcha(form, data.recaptcha_site_key);
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            e.stopImmediatePropagation();
            formStatus(form, 'Subscribing…', false);
            const fd = new FormData(form);

            // Captcha may sit outside the form (to preserve theme newsletter layout)
            const outerCaptcha = form.parentElement?.querySelector('.cms-newsletter-captcha textarea[name="g-recaptcha-response"], .cms-newsletter-captcha .g-recaptcha');
            if (outerCaptcha && window.grecaptcha) {
                const widget = form.parentElement.querySelector('.cms-newsletter-captcha .g-recaptcha[data-widget-id]');
                if (widget) {
                    const token = window.grecaptcha.getResponse(Number(widget.getAttribute('data-widget-id')));
                    if (token) fd.set('g-recaptcha-response', token);
                }
            }

            try {
                const res = await fetch('/newsletter', {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: fd,
                });
                const json = await res.json().catch(() => ({}));
                if (!res.ok) {
                    const first =
                        json.message ||
                        (json.errors && Object.values(json.errors).flat()[0]) ||
                        'Unable to subscribe.';
                    formStatus(form, first, true);
                    resetCaptcha(form);
                    return;
                }
                form.reset();
                resetCaptcha(form);
                formStatus(form, json.message || 'Subscribed. Thank you!', false);
            } catch (err) {
                formStatus(form, 'Network error. Please try again.', true);
            }
        }, true);
    }

    function resetCaptcha(form) {
        if (!window.grecaptcha) return;
        const nodes = [
            ...form.querySelectorAll('.g-recaptcha[data-widget-id]'),
            ...(form.parentElement?.querySelectorAll('.cms-newsletter-captcha .g-recaptcha[data-widget-id]') || []),
        ];
        nodes.forEach((el) => {
            try {
                window.grecaptcha.reset(Number(el.getAttribute('data-widget-id')));
            } catch (e) {}
        });
    }
})();
