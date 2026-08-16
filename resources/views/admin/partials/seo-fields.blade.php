@php
    $seo = $seo ?? null;
    $hideSeoSlug = $hideSeoSlug ?? false;
    $seoSourceTitle = $seoSourceTitle ?? '';
    $val = function (string $key, mixed $default = null) use ($seo) {
        $raw = old($key, $seo?->{$key} ?? $default);
        if ($raw instanceof \Carbon\CarbonInterface) {
            return $raw->format('Y-m-d');
        }

        return $raw;
    };
    $ogImage = $val('og_image');
    $twitterImage = $val('twitter_image');
    $errClass = function (string $key) use ($errors) {
        return $errors->has($key) ? ' is-invalid' : '';
    };
    $errMsg = function (string $key) use ($errors) {
        return $errors->has($key)
            ? '<div class="invalid-feedback d-block">'.e($errors->first($key)).'</div>'
            : '';
    };
    $analysisSeed = [
        'seo_title' => $val('seo_title'),
        'browser_title' => $val('browser_title'),
        'meta_title' => $val('meta_title'),
        'meta_description' => $val('meta_description'),
        'focus_keyword' => $val('focus_keyword'),
        'slug' => $val('slug'),
        'canonical_url' => $val('canonical_url'),
        'schema_json' => $val('schema_json'),
        'og_title' => $val('og_title'),
        'og_description' => $val('og_description'),
        'og_image' => is_string($ogImage) ? $ogImage : '',
        'twitter_title' => $val('twitter_title'),
        'h1_title' => $val('h1_title'),
    ];
    $analysis = \App\Support\SeoHelper::analyze($analysisSeed);
@endphp

<div class="card card-admin mb-3" id="seo-panel">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <span><i class="bi bi-search me-1 text-teal"></i> SEO</span>
        <span class="badge rounded-pill text-bg-light border" id="seo-score-badge">Score: {{ $analysis['score'] }} · {{ $analysis['grade'] }}</span>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-admin mb-3" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#seo-tab-basics" type="button">Basics</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#seo-tab-advanced" type="button">Advanced</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#seo-tab-social" type="button">Social</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#seo-tab-schema" type="button">Schema</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#seo-tab-analysis" type="button">Analysis &amp; Preview</button></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="seo-tab-basics">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="seo_title">SEO Title</label>
                        <input type="text" name="seo_title" id="seo_title" class="form-control seo-live-field{{ $errClass('seo_title') }}" value="{{ $val('seo_title') }}" data-seo-field="seo_title">
                        {!! $errMsg('seo_title') !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="browser_title">Browser Title</label>
                        <input type="text" name="browser_title" id="browser_title" class="form-control seo-live-field{{ $errClass('browser_title') }}" value="{{ $val('browser_title') }}" data-seo-field="browser_title">
                        {!! $errMsg('browser_title') !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="meta_title">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control seo-live-field{{ $errClass('meta_title') }}" value="{{ $val('meta_title') }}" data-seo-field="meta_title">
                        <div class="form-text"><span id="meta_title_count">0</span>/60 characters</div>
                        {!! $errMsg('meta_title') !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="h1_title">H1 Title</label>
                        <input type="text" name="h1_title" id="h1_title" class="form-control seo-live-field{{ $errClass('h1_title') }}" value="{{ $val('h1_title') }}" data-seo-field="h1_title">
                        {!! $errMsg('h1_title') !!}
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="meta_description">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="2" class="form-control seo-live-field{{ $errClass('meta_description') }}" data-seo-field="meta_description">{{ $val('meta_description') }}</textarea>
                        <div class="form-text"><span id="meta_description_count">0</span>/160 characters</div>
                        {!! $errMsg('meta_description') !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="meta_keywords">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control{{ $errClass('meta_keywords') }}" value="{{ $val('meta_keywords') }}" placeholder="comma,separated,keywords">
                        {!! $errMsg('meta_keywords') !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="focus_keyword">Focus Keyword</label>
                        <input type="text" name="focus_keyword" id="focus_keyword" class="form-control seo-live-field{{ $errClass('focus_keyword') }}" value="{{ $val('focus_keyword') }}" data-seo-field="focus_keyword">
                        {!! $errMsg('focus_keyword') !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="secondary_keywords">Secondary Keywords</label>
                        <input type="text" name="secondary_keywords" id="secondary_keywords" class="form-control{{ $errClass('secondary_keywords') }}" value="{{ $val('secondary_keywords') }}">
                        {!! $errMsg('secondary_keywords') !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="breadcrumb_title">Breadcrumb Title</label>
                        <input type="text" name="breadcrumb_title" id="breadcrumb_title" class="form-control{{ $errClass('breadcrumb_title') }}" value="{{ $val('breadcrumb_title') }}">
                        {!! $errMsg('breadcrumb_title') !!}
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="seo-autofill-btn">Auto-fill from content</button>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="seo-tab-advanced">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="canonical_url">Canonical URL</label>
                        <input type="url" name="canonical_url" id="canonical_url" class="form-control seo-live-field{{ $errClass('canonical_url') }}" value="{{ $val('canonical_url') }}" data-seo-field="canonical_url">
                        {!! $errMsg('canonical_url') !!}
                    </div>
                    @if (! $hideSeoSlug)
                        <div class="col-md-6">
                            <label class="form-label" for="seo_slug">SEO Slug</label>
                            <input type="text" name="slug" id="seo_slug" class="form-control seo-live-field{{ $errClass('slug') }}" value="{{ $val('slug') }}" placeholder="url-friendly-slug" data-seo-field="slug">
                            {!! $errMsg('slug') !!}
                        </div>
                    @endif
                    <div class="col-md-6">
                        <label class="form-label" for="robots_meta">Robots Meta</label>
                        <input type="text" name="robots_meta" id="robots_meta" class="form-control{{ $errClass('robots_meta') }}" value="{{ $val('robots_meta') }}" placeholder="index, follow">
                        {!! $errMsg('robots_meta') !!}
                    </div>
                    <div class="col-md-3">
                        <div class="form-check mt-4">
                            <input type="hidden" name="indexable" value="0">
                            <input class="form-check-input" type="checkbox" name="indexable" id="indexable" value="1" {{ $val('indexable', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="indexable">Indexable</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check mt-4">
                            <input type="hidden" name="followable" value="0">
                            <input class="form-check-input" type="checkbox" name="followable" id="followable" value="1" {{ $val('followable', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="followable">Followable</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="author">Author</label>
                        <input type="text" name="author" id="author" class="form-control{{ $errClass('author') }}" value="{{ $val('author') }}">
                        {!! $errMsg('author') !!}
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="publish_date">Publish Date</label>
                        <input type="date" name="publish_date" id="publish_date" class="form-control{{ $errClass('publish_date') }}" value="{{ $val('publish_date') }}">
                        {!! $errMsg('publish_date') !!}
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="seo_updated_date">Updated Date</label>
                        <input type="date" name="seo_updated_date" id="seo_updated_date" class="form-control{{ $errClass('seo_updated_date') }}" value="{{ $val('seo_updated_date') }}">
                        {!! $errMsg('seo_updated_date') !!}
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="reading_time">Reading Time (minutes)</label>
                        <input type="number" name="reading_time" id="reading_time" min="0" max="600" class="form-control{{ $errClass('reading_time') }}" value="{{ $val('reading_time') }}">
                        {!! $errMsg('reading_time') !!}
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="seo-tab-social">
                <h6 class="fw-semibold mb-3">Open Graph</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label" for="og_title">OG Title</label>
                        <input type="text" name="og_title" id="og_title" class="form-control seo-live-field{{ $errClass('og_title') }}" value="{{ $val('og_title') }}" data-seo-field="og_title">
                        {!! $errMsg('og_title') !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="og_description">OG Description</label>
                        <input type="text" name="og_description" id="og_description" class="form-control seo-live-field{{ $errClass('og_description') }}" value="{{ $val('og_description') }}" data-seo-field="og_description">
                        {!! $errMsg('og_description') !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="og_image_url">OG Image URL</label>
                        <input type="text" name="og_image" id="og_image_url" class="form-control seo-live-field{{ $errClass('og_image') }}" value="{{ is_string($ogImage) ? $ogImage : '' }}" placeholder="https://... or storage path" data-seo-field="og_image">
                        {!! $errMsg('og_image') !!}
                        @if (is_string($ogImage) && $ogImage !== '')
                            <img src="{{ storage_url($ogImage) }}" alt="" class="preview-thumb mt-2" id="og_image_preview">
                        @else
                            <img src="" alt="" class="preview-thumb mt-2 d-none" id="og_image_preview">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="og_image_file">OG Image Upload</label>
                        <input type="file" name="og_image_upload" id="og_image_file" class="form-control" accept="image/*">
                        <div class="form-text">Uploading a file overrides the URL above.</div>
                    </div>
                </div>

                <h6 class="fw-semibold mb-3">Twitter Card</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="twitter_card">Card Type</label>
                        <select name="twitter_card" id="twitter_card" class="form-select{{ $errClass('twitter_card') }}">
                            @php $card = $val('twitter_card', 'summary_large_image'); @endphp
                            <option value="summary_large_image" @selected($card === 'summary_large_image')>summary_large_image</option>
                            <option value="summary" @selected($card === 'summary')>summary</option>
                        </select>
                        {!! $errMsg('twitter_card') !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="twitter_title">Twitter Title</label>
                        <input type="text" name="twitter_title" id="twitter_title" class="form-control seo-live-field{{ $errClass('twitter_title') }}" value="{{ $val('twitter_title') }}" data-seo-field="twitter_title">
                        {!! $errMsg('twitter_title') !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="twitter_description">Twitter Description</label>
                        <input type="text" name="twitter_description" id="twitter_description" class="form-control{{ $errClass('twitter_description') }}" value="{{ $val('twitter_description') }}">
                        {!! $errMsg('twitter_description') !!}
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="twitter_image_url">Twitter Image URL</label>
                        <input type="text" name="twitter_image" id="twitter_image_url" class="form-control{{ $errClass('twitter_image') }}" value="{{ is_string($twitterImage) ? $twitterImage : '' }}">
                        {!! $errMsg('twitter_image') !!}
                        @if (is_string($twitterImage) && $twitterImage !== '')
                            <img src="{{ storage_url($twitterImage) }}" alt="" class="preview-thumb mt-2">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="twitter_image_file">Twitter Image Upload</label>
                        <input type="file" name="twitter_image_upload" id="twitter_image_file" class="form-control" accept="image/*">
                        <div class="form-text">Uploading a file overrides the URL above.</div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="seo-tab-schema">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="structured_data_type">Structured Data Type</label>
                        <select name="structured_data_type" id="structured_data_type" class="form-select{{ $errClass('structured_data_type') }}">
                            <option value="">— Select —</option>
                            @foreach (\App\Support\SeoHelper::schemaTypes() as $type => $label)
                                <option value="{{ $type }}" @selected($val('structured_data_type') === $type)>{{ $label }}</option>
                            @endforeach
                        </select>
                        {!! $errMsg('structured_data_type') !!}
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="schema_json">Schema JSON-LD</label>
                        <textarea name="schema_json" id="schema_json" rows="6" class="form-control font-monospace seo-live-field{{ $errClass('schema_json') }}" data-seo-field="schema_json">{{ $val('schema_json') }}</textarea>
                        {!! $errMsg('schema_json') !!}
                        <div class="form-text">Paste valid JSON-LD. Leave empty to use automatic templates on the public site.</div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="seo-tab-analysis">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="display-6 fw-bold text-teal mb-0" id="seo-score-number">{{ $analysis['score'] }}</div>
                            <div>
                                <div class="fw-semibold" id="seo-score-grade">{{ $analysis['grade'] }}</div>
                                <div class="text-muted small">Live SEO score</div>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush" id="seo-checks-list">
                            @foreach ($analysis['checks'] as $check)
                                <li class="list-group-item px-0 d-flex gap-2 align-items-start">
                                    <i class="bi {{ $check['status'] === 'pass' ? 'bi-check-circle-fill text-success' : 'bi-exclamation-circle-fill text-warning' }}"></i>
                                    <div>
                                        <div class="fw-semibold small">{{ $check['label'] }}</div>
                                        <div class="text-muted small">{{ $check['message'] }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-7">
                        <h6 class="fw-semibold">Google Preview</h6>
                        <div class="border rounded p-3 mb-3 bg-white">
                            <div class="text-primary text-decoration-underline" id="preview-google-title" style="font-size:18px;line-height:1.3;">Preview title</div>
                            <div class="text-success small" id="preview-google-url">{{ url('/') }}</div>
                            <div class="text-muted small" id="preview-google-desc">Preview description</div>
                        </div>

                        <h6 class="fw-semibold">Facebook / LinkedIn / WhatsApp Preview</h6>
                        <div class="border rounded overflow-hidden mb-3 bg-white">
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height:140px;">
                                <img id="preview-og-image" src="" alt="" class="w-100 h-100 d-none" style="object-fit:cover;">
                                <span class="text-muted small" id="preview-og-placeholder">OG image</span>
                            </div>
                            <div class="p-3">
                                <div class="text-muted text-uppercase small" id="preview-og-domain">{{ parse_url(url('/'), PHP_URL_HOST) }}</div>
                                <div class="fw-semibold" id="preview-og-title">OG title</div>
                                <div class="text-muted small" id="preview-og-desc">OG description</div>
                            </div>
                        </div>

                        <h6 class="fw-semibold">Twitter Preview</h6>
                        <div class="border rounded overflow-hidden bg-white">
                            <div class="p-3">
                                <div class="fw-semibold" id="preview-twitter-title">Twitter title</div>
                                <div class="text-muted small" id="preview-twitter-desc">Twitter description</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
(() => {
    const panel = document.getElementById('seo-panel');
    if (!panel) return;

    const sourceTitle = @json($seoSourceTitle);
    const storageBase = @json(rtrim(asset('storage'), '/'));

    const get = (id) => document.getElementById(id);
    const val = (id) => (get(id)?.value || '').trim();

    function analyze() {
        const title = val('meta_title') || val('seo_title') || val('browser_title');
        const description = val('meta_description');
        const focus = val('focus_keyword');
        const slug = val('seo_slug') || '';
        const canonical = val('canonical_url');
        const schema = val('schema_json');
        const ogTitle = val('og_title');
        const ogDesc = val('og_description');
        const ogImage = val('og_image_url');
        const twitterTitle = val('twitter_title');
        const h1 = val('h1_title');

        const checks = [];
        let score = 0, max = 0;
        const add = (label, pass, ok, fail, weight = 10) => {
            max += weight;
            if (pass) score += weight;
            checks.push({ label, status: pass ? 'pass' : 'fail', message: pass ? ok : fail });
        };

        add('Title length', title.length >= 30 && title.length <= 60, 'Title length is optimal (30–60).', 'Aim for 30–60 characters in the meta/SEO title.', 15);
        add('Meta description', description.length >= 120 && description.length <= 160, 'Meta description length is optimal.', 'Aim for 120–160 characters in the meta description.', 15);
        add('Focus keyword', !!focus, 'Focus keyword is set.', 'Add a focus keyword.', 10);
        if (focus) {
            add('Keyword in title', title.toLowerCase().includes(focus.toLowerCase()), 'Focus keyword appears in the title.', 'Include the focus keyword in the title.', 10);
            add('Keyword in description', description.toLowerCase().includes(focus.toLowerCase()), 'Focus keyword appears in the description.', 'Include the focus keyword in the meta description.', 5);
        }
        add('H1 title', !!h1, 'H1 title is set.', 'Set an H1 title for clearer heading structure.', 5);
        add('Slug', !slug || /^[a-z0-9]+(?:-[a-z0-9]+)*$/.test(slug), 'Slug is URL-friendly.', 'Use a lowercase hyphenated slug.', 5);
        add('Canonical URL', !!canonical, 'Canonical URL is set.', 'Add a canonical URL.', 10);
        add('Schema JSON-LD', !!schema, 'Schema markup is present.', 'Add JSON-LD schema for rich results.', 10);
        add('Open Graph', !!(ogTitle && ogDesc && ogImage), 'Open Graph fields look complete.', 'Complete OG title, description, and image.', 10);
        add('Twitter card', !!(twitterTitle || ogTitle), 'Twitter card fields are covered.', 'Add Twitter title or rely on OG title.', 5);

        const pct = max ? Math.round((score / max) * 100) : 0;
        const grade = pct >= 85 ? 'Excellent' : pct >= 70 ? 'Good' : pct >= 50 ? 'Needs work' : 'Poor';

        get('seo-score-number').textContent = pct;
        get('seo-score-grade').textContent = grade;
        get('seo-score-badge').textContent = `Score: ${pct} · ${grade}`;

        const list = get('seo-checks-list');
        list.innerHTML = checks.map(c => `
            <li class="list-group-item px-0 d-flex gap-2 align-items-start">
                <i class="bi ${c.status === 'pass' ? 'bi-check-circle-fill text-success' : 'bi-exclamation-circle-fill text-warning'}"></i>
                <div>
                    <div class="fw-semibold small">${c.label}</div>
                    <div class="text-muted small">${c.message}</div>
                </div>
            </li>`).join('');

        const displayTitle = title || 'Preview title';
        const displayDesc = description || 'Preview description';
        get('preview-google-title').textContent = displayTitle;
        get('preview-google-url').textContent = canonical || window.location.origin;
        get('preview-google-desc').textContent = displayDesc;
        get('preview-og-title').textContent = ogTitle || displayTitle;
        get('preview-og-desc').textContent = ogDesc || displayDesc;
        get('preview-twitter-title').textContent = twitterTitle || ogTitle || displayTitle;
        get('preview-twitter-desc').textContent = val('twitter_description') || ogDesc || displayDesc;

        const img = get('preview-og-image');
        const ph = get('preview-og-placeholder');
        if (ogImage) {
            const src = /^https?:\/\//i.test(ogImage) ? ogImage : `${storageBase}/${ogImage.replace(/^\/+/, '')}`;
            img.src = src;
            img.classList.remove('d-none');
            ph.classList.add('d-none');
        } else {
            img.classList.add('d-none');
            ph.classList.remove('d-none');
        }

        const tc = get('meta_title_count');
        const dc = get('meta_description_count');
        if (tc) tc.textContent = val('meta_title').length;
        if (dc) dc.textContent = description.length;
    }

    panel.querySelectorAll('.seo-live-field, #twitter_description, #meta_keywords').forEach((el) => {
        el.addEventListener('input', analyze);
        el.addEventListener('change', analyze);
    });

    get('seo-autofill-btn')?.addEventListener('click', () => {
        const titleEl = document.getElementById('title') || document.getElementById('heading') || document.getElementById('question') || document.getElementById('small_title');
        const title = (titleEl?.value || sourceTitle || '').trim();
        if (!title) return;
        if (!val('seo_title')) get('seo_title').value = title;
        if (!val('meta_title')) get('meta_title').value = title.slice(0, 60);
        if (!val('browser_title')) get('browser_title').value = title.slice(0, 60);
        if (!val('h1_title')) get('h1_title').value = title;
        if (!val('og_title')) get('og_title').value = title.slice(0, 60);
        if (!val('twitter_title')) get('twitter_title').value = title.slice(0, 60);
        if (!val('breadcrumb_title')) get('breadcrumb_title').value = title;
        const slugInput = get('seo_slug');
        if (slugInput && !slugInput.value) {
            slugInput.value = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
        }
        analyze();
    });

    analyze();
})();
</script>
@endpush
@endonce
