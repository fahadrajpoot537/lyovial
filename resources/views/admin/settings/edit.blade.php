@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
    @php
        $settings = $settings ?? [];
        $g = fn (string $group, string $key, mixed $default = '') => old($key, $settings[$group][$key] ?? $default);
    @endphp

    <div class="page-header">
        <div>
            <h1>Settings</h1>
            <p class="subtitle">Site-wide configuration for LyoVial</p>
        </div>
    </div>

    <div class="card card-admin">
        <div class="card-header border-0 pb-0">
            <ul class="nav nav-tabs nav-tabs-admin" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-general" type="button">General</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-contact" type="button">Contact</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-social" type="button">Social</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-seo" type="button">SEO</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-analytics" type="button">Analytics</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-scripts" type="button">Scripts</button></li>
            </ul>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="group" id="settings_group" value="{{ old('group', 'general') }}">

                <div class="tab-content">
                    {{-- General --}}
                    <div class="tab-pane fade show active" id="tab-general">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="site_name">Site name</label>
                                <input type="text" name="site_name" id="site_name" class="form-control @error('site_name') is-invalid @enderror" value="{{ $g('general', 'site_name') }}">
                                @error('site_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="copyright">Copyright</label>
                                <input type="text" name="copyright" id="copyright" class="form-control @error('copyright') is-invalid @enderror" value="{{ $g('general', 'copyright') }}">
                                @error('copyright')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="logo">Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                                @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if ($g('general', 'logo'))
                                    <img src="{{ storage_url($g('general', 'logo')) }}" alt="Logo" class="preview-thumb mt-2">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="favicon">Favicon</label>
                                <input type="file" name="favicon" id="favicon" class="form-control @error('favicon') is-invalid @enderror" accept="image/*">
                                @error('favicon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if ($g('general', 'favicon'))
                                    <img src="{{ storage_url($g('general', 'favicon')) }}" alt="Favicon" class="preview-thumb mt-2">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $g('general', 'phone') }}">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $g('general', 'email') }}">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="address">Address</label>
                                <textarea name="address" id="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ $g('general', 'address') }}</textarea>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="map_embed">Map embed</label>
                                <textarea name="map_embed" id="map_embed" rows="3" class="form-control font-monospace @error('map_embed') is-invalid @enderror">{{ $g('general', 'map_embed') }}</textarea>
                                @error('map_embed')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Contact --}}
                    <div class="tab-pane fade" id="tab-contact">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="contact_phone">Phone</label>
                                <input type="text" name="phone" id="contact_phone" class="form-control" value="{{ $g('contact', 'phone') }}" data-group-field="contact">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="contact_email">Email</label>
                                <input type="email" name="email" id="contact_email" class="form-control" value="{{ $g('contact', 'email') }}" data-group-field="contact">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="contact_address">Address</label>
                                <textarea name="address" id="contact_address" rows="2" class="form-control" data-group-field="contact">{{ $g('contact', 'address') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="contact_map_embed">Map embed</label>
                                <textarea name="map_embed" id="contact_map_embed" rows="3" class="form-control font-monospace" data-group-field="contact">{{ $g('contact', 'map_embed') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Social --}}
                    <div class="tab-pane fade" id="tab-social">
                        <div class="row g-3">
                            @foreach (['facebook', 'twitter', 'linkedin', 'instagram', 'youtube'] as $network)
                                <div class="col-md-6">
                                    <label class="form-label" for="{{ $network }}">{{ ucfirst($network) }}</label>
                                    <input type="url" name="{{ $network }}" id="{{ $network }}" class="form-control @error($network) is-invalid @enderror" value="{{ $g('social', $network) }}" placeholder="https://">
                                    @error($network)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- SEO --}}
                    <div class="tab-pane fade" id="tab-seo">
                        <div class="row g-3">
                            <div class="col-12"><h6 class="fw-semibold mb-0">Site &amp; Organization</h6></div>
                            <div class="col-md-6">
                                <label class="form-label" for="site_title">Site Title</label>
                                <input type="text" name="site_title" id="site_title" class="form-control" value="{{ $g('seo', 'site_title') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="default_canonical_url">Default Canonical URL</label>
                                <input type="url" name="default_canonical_url" id="default_canonical_url" class="form-control" value="{{ $g('seo', 'default_canonical_url', url('/')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="organization_name">Organization Name</label>
                                <input type="text" name="organization_name" id="organization_name" class="form-control" value="{{ $g('seo', 'organization_name') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="organization_logo">Organization Logo</label>
                                <input type="file" name="organization_logo" id="organization_logo" class="form-control" accept="image/*">
                                @if ($g('seo', 'organization_logo'))
                                    <img src="{{ storage_url($g('seo', 'organization_logo')) }}" alt="" class="preview-thumb mt-2">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="organization_phone">Organization Phone</label>
                                <input type="text" name="organization_phone" id="organization_phone" class="form-control" value="{{ $g('seo', 'organization_phone') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="organization_email">Organization Email</label>
                                <input type="email" name="organization_email" id="organization_email" class="form-control" value="{{ $g('seo', 'organization_email') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="organization_address">Organization Address</label>
                                <textarea name="organization_address" id="organization_address" rows="2" class="form-control">{{ $g('seo', 'organization_address') }}</textarea>
                            </div>

                            <div class="col-12"><hr class="my-2"><h6 class="fw-semibold mb-0">Default Meta</h6></div>
                            <div class="col-md-6">
                                <label class="form-label" for="default_meta_title">Default meta title</label>
                                <input type="text" name="default_meta_title" id="default_meta_title" class="form-control" value="{{ $g('seo', 'default_meta_title') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="default_meta_keywords">Default meta keywords</label>
                                <input type="text" name="default_meta_keywords" id="default_meta_keywords" class="form-control" value="{{ $g('seo', 'default_meta_keywords') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="default_meta_description">Default meta description</label>
                                <textarea name="default_meta_description" id="default_meta_description" rows="2" class="form-control">{{ $g('seo', 'default_meta_description') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="default_og_title">Default OG title</label>
                                <input type="text" name="default_og_title" id="default_og_title" class="form-control" value="{{ $g('seo', 'default_og_title') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="default_og_description">Default OG description</label>
                                <input type="text" name="default_og_description" id="default_og_description" class="form-control" value="{{ $g('seo', 'default_og_description') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="default_og_image">Default OG image</label>
                                <input type="file" name="default_og_image" id="default_og_image" class="form-control" accept="image/*">
                                @if ($g('seo', 'default_og_image'))
                                    <img src="{{ storage_url($g('seo', 'default_og_image')) }}" alt="" class="preview-thumb mt-2">
                                    <input type="hidden" name="default_og_image_current" value="{{ $g('seo', 'default_og_image') }}">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="default_twitter_title">Default Twitter title</label>
                                <input type="text" name="default_twitter_title" id="default_twitter_title" class="form-control" value="{{ $g('seo', 'default_twitter_title') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="default_twitter_description">Default Twitter description</label>
                                <input type="text" name="default_twitter_description" id="default_twitter_description" class="form-control" value="{{ $g('seo', 'default_twitter_description') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="default_twitter_card">Default Twitter card</label>
                                <select name="default_twitter_card" id="default_twitter_card" class="form-select">
                                    @php $twCard = $g('seo', 'default_twitter_card', 'summary_large_image'); @endphp
                                    <option value="summary_large_image" @selected($twCard === 'summary_large_image')>summary_large_image</option>
                                    <option value="summary" @selected($twCard === 'summary')>summary</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="default_twitter_image">Default Twitter image</label>
                                <input type="file" name="default_twitter_image" id="default_twitter_image" class="form-control" accept="image/*">
                                @if ($g('seo', 'default_twitter_image'))
                                    <img src="{{ storage_url($g('seo', 'default_twitter_image')) }}" alt="" class="preview-thumb mt-2">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="sitemap_enabled">Sitemap enabled</label>
                                <select name="sitemap_enabled" id="sitemap_enabled" class="form-select">
                                    @php $sm = (string) $g('seo', 'sitemap_enabled', '1'); @endphp
                                    <option value="1" @selected($sm === '1')>Yes</option>
                                    <option value="0" @selected($sm === '0')>No</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="sitemap_changefreq">Default changefreq</label>
                                <input type="text" name="sitemap_changefreq" id="sitemap_changefreq" class="form-control" value="{{ $g('seo', 'sitemap_changefreq', 'weekly') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Analytics --}}
                    <div class="tab-pane fade" id="tab-analytics">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="google_analytics">Google Analytics</label>
                                <textarea name="google_analytics" id="google_analytics" rows="3" class="form-control font-monospace">{{ $g('analytics', 'google_analytics') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="google_tag_manager">Google Tag Manager</label>
                                <textarea name="google_tag_manager" id="google_tag_manager" rows="3" class="form-control font-monospace">{{ $g('analytics', 'google_tag_manager') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="google_search_console">Google Search Console</label>
                                <input type="text" name="google_search_console" id="google_search_console" class="form-control" value="{{ $g('analytics', 'google_search_console') }}" placeholder="Verification meta content">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="bing_verification">Bing Verification</label>
                                <input type="text" name="bing_verification" id="bing_verification" class="form-control" value="{{ $g('analytics', 'bing_verification') }}" placeholder="msvalidate.01 content">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="meta_pixel">Meta Pixel</label>
                                <textarea name="meta_pixel" id="meta_pixel" rows="3" class="form-control font-monospace">{{ $g('analytics', 'meta_pixel') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="linkedin_insight_tag">LinkedIn Insight Tag</label>
                                <textarea name="linkedin_insight_tag" id="linkedin_insight_tag" rows="3" class="form-control font-monospace">{{ $g('analytics', 'linkedin_insight_tag') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="robots_txt">robots.txt</label>
                                <textarea name="robots_txt" id="robots_txt" rows="6" class="form-control font-monospace">{{ $g('analytics', 'robots_txt') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Scripts --}}
                    <div class="tab-pane fade" id="tab-scripts">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label" for="custom_head_scripts">Custom head scripts</label>
                                <textarea name="custom_head_scripts" id="custom_head_scripts" rows="6" class="form-control font-monospace">{{ $g('scripts', 'custom_head_scripts') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="custom_footer_scripts">Custom footer scripts</label>
                                <textarea name="custom_footer_scripts" id="custom_footer_scripts" rows="6" class="form-control font-monospace">{{ $g('scripts', 'custom_footer_scripts') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-teal">Save settings</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(() => {
    const groupInput = document.getElementById('settings_group');
    const map = {
        'tab-general': 'general',
        'tab-contact': 'contact',
        'tab-social': 'social',
        'tab-seo': 'seo',
        'tab-analytics': 'analytics',
        'tab-scripts': 'scripts',
    };

    document.querySelectorAll('[data-bs-toggle="tab"]').forEach((btn) => {
        btn.addEventListener('shown.bs.tab', (e) => {
            const target = e.target.getAttribute('data-bs-target')?.replace('#', '');
            if (map[target]) groupInput.value = map[target];
        });
    });

    // Disable fields not in the active tab so only active group posts
    const form = groupInput.closest('form');
    form?.addEventListener('submit', () => {
        const active = form.querySelector('.tab-pane.active');
        form.querySelectorAll('.tab-pane').forEach((pane) => {
            if (pane === active) return;
            pane.querySelectorAll('input, select, textarea').forEach((el) => {
                el.disabled = true;
            });
        });
    });
})();
</script>
@endpush
