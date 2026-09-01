@php
    $stored = old('extra', $industry?->extra);
    $stored = is_array($stored) ? $stored : null;
    $extra = $industry
        ? array_replace(\App\Support\IndustryPageDefaults::blank(), $stored ?? [])
        : \App\Support\IndustryPageDefaults::merge($stored, (string) old('slug', $industry?->slug ?: 'custom'));
    $specItems = $extra['spec_items'] ?: [['title' => '', 'body' => '']];
    $leadParas = $extra['lead_paras'] ?: [''];
    $needs = $extra['needs'] ?: [['n' => '', 'title' => '', 'body' => '']];
    $steps = $extra['steps'] ?: [['title' => '', 'body' => '']];
    $whyItems = $extra['why_items'] ?: [''];
    $faqs = $extra['faqs'] ?: [['q' => '', 'a' => '']];
@endphp

<div class="card card-admin mb-3">
    <div class="card-header">Industry page content</div>
    <div class="card-body">
        <p class="text-muted small mb-3">These fields drive the public industry page. Leave a row blank to hide it.</p>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Nav / card title</label>
                <input type="text" name="extra[nav_title]" class="form-control" value="{{ $extra['nav_title'] ?? '' }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Hero eyebrow</label>
                <input type="text" name="extra[hero_eyebrow]" class="form-control" value="{{ $extra['hero_eyebrow'] ?? '' }}">
            </div>
            <div class="col-12">
                <label class="form-label">Hero heading (HTML allowed, e.g. &lt;em&gt;)</label>
                <input type="text" name="extra[hero_h1]" class="form-control" value="{{ $extra['hero_h1'] ?? '' }}">
            </div>
            <div class="col-12">
                <label class="form-label">Hero lead</label>
                <textarea name="extra[hero_lede]" rows="3" class="form-control">{{ $extra['hero_lede'] ?? '' }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="card card-admin mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Formats / spec list</span>
        <button type="button" class="btn btn-sm btn-outline-secondary" data-repeat-add="specItems">Add item</button>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Section heading</label>
            <input type="text" name="extra[spec_heading]" class="form-control" value="{{ $extra['spec_heading'] ?? '' }}">
        </div>
        <div id="specItems" data-repeat-list>
            @foreach($specItems as $i => $row)
                <div class="row g-2 mb-2" data-repeat-row>
                    <div class="col-md-4">
                        <input type="text" name="extra[spec_items][{{ $i }}][title]" class="form-control" placeholder="Title" value="{{ $row['title'] ?? '' }}">
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="extra[spec_items][{{ $i }}][body]" class="form-control" placeholder="Body" value="{{ $row['body'] ?? '' }}">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger w-100" data-repeat-remove>&times;</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card card-admin mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Lead copy</span>
        <button type="button" class="btn btn-sm btn-outline-secondary" data-repeat-add="leadParas">Add paragraph</button>
    </div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">Eyebrow</label>
                <input type="text" name="extra[lead_eyebrow]" class="form-control" value="{{ $extra['lead_eyebrow'] ?? '' }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Heading</label>
                <input type="text" name="extra[lead_heading]" class="form-control" value="{{ $extra['lead_heading'] ?? '' }}">
            </div>
        </div>
        <div id="leadParas" data-repeat-list>
            @foreach($leadParas as $i => $para)
                <div class="mb-2" data-repeat-row>
                    <div class="d-flex gap-2">
                        <textarea name="extra[lead_paras][{{ $i }}]" rows="3" class="form-control" placeholder="Paragraph">{{ is_string($para) ? $para : '' }}</textarea>
                        <button type="button" class="btn btn-outline-danger" data-repeat-remove>&times;</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card card-admin mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>What we support</span>
        <button type="button" class="btn btn-sm btn-outline-secondary" data-repeat-add="needItems">Add need</button>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Eyebrow</label>
            <input type="text" name="extra[needs_eyebrow]" class="form-control" value="{{ $extra['needs_eyebrow'] ?? '' }}">
        </div>
        <div id="needItems" data-repeat-list>
            @foreach($needs as $i => $row)
                <div class="border rounded p-3 mb-2" data-repeat-row>
                    <div class="row g-2">
                        <div class="col-md-2">
                            <input type="text" name="extra[needs][{{ $i }}][n]" class="form-control" placeholder="01" value="{{ $row['n'] ?? '' }}">
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="extra[needs][{{ $i }}][title]" class="form-control" placeholder="Title" value="{{ $row['title'] ?? '' }}">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-outline-danger w-100" data-repeat-remove>&times;</button>
                        </div>
                        <div class="col-12">
                            <textarea name="extra[needs][{{ $i }}][body]" rows="2" class="form-control" placeholder="Body">{{ $row['body'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-2">
            <label class="form-label">Swipe hint</label>
            <input type="text" name="extra[swipe_needs]" class="form-control" value="{{ $extra['swipe_needs'] ?? '' }}">
        </div>
    </div>
</div>

<div class="card card-admin mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Process / steps</span>
        <button type="button" class="btn btn-sm btn-outline-secondary" data-repeat-add="processSteps">Add step</button>
    </div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <input type="text" name="extra[process_eyebrow]" class="form-control" placeholder="Eyebrow" value="{{ $extra['process_eyebrow'] ?? '' }}">
            </div>
            <div class="col-md-8">
                <input type="text" name="extra[process_heading]" class="form-control" placeholder="Heading" value="{{ $extra['process_heading'] ?? '' }}">
            </div>
            <div class="col-12">
                <textarea name="extra[process_intro]" rows="2" class="form-control" placeholder="Intro">{{ $extra['process_intro'] ?? '' }}</textarea>
            </div>
        </div>
        <div id="processSteps" data-repeat-list>
            @foreach($steps as $i => $row)
                <div class="row g-2 mb-2" data-repeat-row>
                    <div class="col-md-4">
                        <input type="text" name="extra[steps][{{ $i }}][title]" class="form-control" placeholder="Title" value="{{ $row['title'] ?? '' }}">
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="extra[steps][{{ $i }}][body]" class="form-control" placeholder="Body" value="{{ $row['body'] ?? '' }}">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger w-100" data-repeat-remove>&times;</button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-2">
            <label class="form-label">Swipe hint</label>
            <input type="text" name="extra[swipe_steps]" class="form-control" value="{{ $extra['swipe_steps'] ?? '' }}">
        </div>
    </div>
</div>

<div class="card card-admin mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Why LyoVial</span>
        <button type="button" class="btn btn-sm btn-outline-secondary" data-repeat-add="whyItems">Add bullet</button>
    </div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">Eyebrow</label>
                <input type="text" name="extra[why_eyebrow]" class="form-control" value="{{ $extra['why_eyebrow'] ?? '' }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Heading</label>
                <input type="text" name="extra[why_heading]" class="form-control" value="{{ $extra['why_heading'] ?? '' }}">
            </div>
            <div class="col-12">
                <label class="form-label">Body</label>
                <textarea name="extra[why_body]" rows="3" class="form-control">{{ $extra['why_body'] ?? '' }}</textarea>
            </div>
        </div>
        <div id="whyItems" data-repeat-list>
            @foreach($whyItems as $i => $item)
                <div class="mb-2" data-repeat-row>
                    <div class="d-flex gap-2">
                        <textarea name="extra[why_items][{{ $i }}]" rows="2" class="form-control" placeholder="Bullet (HTML allowed)">{{ is_string($item) ? $item : '' }}</textarea>
                        <button type="button" class="btn btn-outline-danger" data-repeat-remove>&times;</button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row g-3 mt-1">
            <div class="col-md-6">
                <label class="form-label">Workflow heading</label>
                <input type="text" name="extra[workflow_heading]" class="form-control" value="{{ $extra['workflow_heading'] ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Other industries heading</label>
                <input type="text" name="extra[other_industries_heading]" class="form-control" value="{{ $extra['other_industries_heading'] ?? '' }}">
            </div>
            <div class="col-12">
                <label class="form-label">Related capabilities intro</label>
                <input type="text" name="extra[related_intro]" class="form-control" value="{{ $extra['related_intro'] ?? '' }}">
            </div>
        </div>
    </div>
</div>

<div class="card card-admin mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>FAQs</span>
        <button type="button" class="btn btn-sm btn-outline-secondary" data-repeat-add="faqItems">Add FAQ</button>
    </div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <input type="text" name="extra[faq_eyebrow]" class="form-control" placeholder="Eyebrow" value="{{ $extra['faq_eyebrow'] ?? '' }}">
            </div>
            <div class="col-md-8">
                <input type="text" name="extra[faq_heading]" class="form-control" placeholder="Heading" value="{{ $extra['faq_heading'] ?? '' }}">
            </div>
            <div class="col-12">
                <textarea name="extra[faq_intro]" rows="2" class="form-control" placeholder="Intro">{{ $extra['faq_intro'] ?? '' }}</textarea>
            </div>
        </div>
        <div id="faqItems" data-repeat-list>
            @foreach($faqs as $i => $row)
                <div class="border rounded p-3 mb-2" data-repeat-row>
                    <div class="d-flex justify-content-end mb-2">
                        <button type="button" class="btn btn-sm btn-outline-danger" data-repeat-remove>Remove</button>
                    </div>
                    <input type="text" name="extra[faqs][{{ $i }}][q]" class="form-control mb-2" placeholder="Question" value="{{ $row['q'] ?? '' }}">
                    <textarea name="extra[faqs][{{ $i }}][a]" rows="3" class="form-control" placeholder="Answer">{{ $row['a'] ?? '' }}</textarea>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card card-admin mb-3">
    <div class="card-header">Bottom CTA</div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Eyebrow</label>
                <input type="text" name="extra[cta_eyebrow]" class="form-control" value="{{ $extra['cta_eyebrow'] ?? '' }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Heading</label>
                <input type="text" name="extra[cta_heading]" class="form-control" value="{{ $extra['cta_heading'] ?? '' }}">
            </div>
            <div class="col-12">
                <label class="form-label">Body</label>
                <textarea name="extra[cta_body]" rows="2" class="form-control">{{ $extra['cta_body'] ?? '' }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Button text</label>
                <input type="text" name="extra[cta_button]" class="form-control" value="{{ $extra['cta_button'] ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Button link</label>
                <input type="text" name="extra[cta_link]" class="form-control" value="{{ $extra['cta_link'] ?? '' }}" placeholder="/contact">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    document.querySelectorAll('[data-repeat-add]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var list = document.getElementById(btn.getAttribute('data-repeat-add'));
            if (!list) return;
            var rows = list.querySelectorAll('[data-repeat-row]');
            var last = rows[rows.length - 1];
            if (!last) return;
            var clone = last.cloneNode(true);
            var idx = rows.length;
            clone.querySelectorAll('input, textarea, select').forEach(function (el) {
                if (el.name) {
                    el.name = el.name.replace(/\[\d+]/, '[' + idx + ']');
                }
                if (el.tagName === 'TEXTAREA') el.value = '';
                else if (el.tagName === 'SELECT') el.selectedIndex = 0;
                else el.value = '';
            });
            list.appendChild(clone);
        });
    });
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-repeat-remove]');
        if (!btn) return;
        var list = btn.closest('[data-repeat-list]');
        var row = btn.closest('[data-repeat-row]');
        if (!list || !row) return;
        if (list.querySelectorAll('[data-repeat-row]').length <= 1) {
            row.querySelectorAll('input, textarea').forEach(function (el) { el.value = ''; });
            return;
        }
        row.remove();
    });
})();
</script>
@endpush
