@php
    $partners = $extra['partners'] ?? [[], []];
    while (count($partners) < 2) {
        $partners[] = [];
    }
@endphp
<div class="card card-admin mb-3">
    <div class="card-header">Partnerships page content</div>
    <div class="card-body row g-3">
        <div class="col-md-4">
            <label class="form-label">Hero eyebrow</label>
            <input type="text" name="extra[hero_eyebrow]" class="form-control" value="{{ $extra['hero_eyebrow'] ?? '' }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Hero heading</label>
            <input type="text" name="extra[hero_heading]" class="form-control" value="{{ $extra['hero_heading'] ?? '' }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Accent word(s)</label>
            <input type="text" name="extra[hero_accent]" class="form-control" value="{{ $extra['hero_accent'] ?? '' }}">
        </div>
        <div class="col-12">
            <label class="form-label">Hero intro</label>
            <textarea name="extra[hero_lede]" rows="3" class="form-control">{{ $extra['hero_lede'] ?? '' }}</textarea>
        </div>

        @foreach($partners as $pi => $partner)
            <div class="col-12"><hr><strong>Partner {{ $pi + 1 }}</strong></div>
            <div class="col-md-2">
                <label class="form-label">Num</label>
                <input type="text" name="extra[partners][{{ $pi }}][num]" class="form-control" value="{{ $partner['num'] ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Name</label>
                <input type="text" name="extra[partners][{{ $pi }}][name]" class="form-control" value="{{ $partner['name'] ?? '' }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Location</label>
                <input type="text" name="extra[partners][{{ $pi }}][location]" class="form-control" value="{{ $partner['location'] ?? '' }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Anchor ID</label>
                <input type="text" name="extra[partners][{{ $pi }}][anchor]" class="form-control" value="{{ $partner['anchor'] ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Card title</label>
                <input type="text" name="extra[partners][{{ $pi }}][title]" class="form-control" value="{{ $partner['title'] ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Website URL</label>
                <input type="text" name="extra[partners][{{ $pi }}][website]" class="form-control" value="{{ $partner['website'] ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Logo path</label>
                <input type="text" name="extra[partners][{{ $pi }}][logo]" class="form-control" value="{{ $partner['logo'] ?? '' }}" placeholder="/images/site/...">
            </div>
            <div class="col-md-6">
                <label class="form-label">Summary</label>
                <textarea name="extra[partners][{{ $pi }}][summary]" rows="2" class="form-control">{{ $partner['summary'] ?? '' }}</textarea>
            </div>
            @foreach(($partner['sections'] ?? [['heading'=>'','body'=>''],['heading'=>'','body'=>'']]) as $si => $section)
                <div class="col-md-6">
                    <label class="form-label">Section {{ $si + 1 }} heading</label>
                    <input type="text" name="extra[partners][{{ $pi }}][sections][{{ $si }}][heading]" class="form-control" value="{{ $section['heading'] ?? '' }}">
                    <textarea name="extra[partners][{{ $pi }}][sections][{{ $si }}][body]" rows="2" class="form-control mt-2" placeholder="Body">{{ $section['body'] ?? '' }}</textarea>
                </div>
            @endforeach
            <div class="col-md-4">
                <label class="form-label">Callout label</label>
                <input type="text" name="extra[partners][{{ $pi }}][callout_label]" class="form-control" value="{{ $partner['callout_label'] ?? '' }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Callout body</label>
                <textarea name="extra[partners][{{ $pi }}][callout_body]" rows="2" class="form-control">{{ $partner['callout_body'] ?? '' }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Bullets (one per line)</label>
                <textarea name="extra[partners][{{ $pi }}][bullets_text]" rows="4" class="form-control">{{ implode("\n", $partner['bullets'] ?? []) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Methods (Name|Description per line)</label>
                <textarea name="extra[partners][{{ $pi }}][methods_text]" rows="4" class="form-control">@foreach(($partner['methods'] ?? []) as $m){{ ($m['name'] ?? '').'|'.($m['desc'] ?? '') }}{{ "\n" }}@endforeach</textarea>
            </div>
        @endforeach

        <div class="col-12"><hr><strong>Bottom CTA</strong></div>
        <div class="col-md-6">
            <label class="form-label">CTA heading</label>
            <input type="text" name="extra[cta_heading]" class="form-control" value="{{ $extra['cta_heading'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">CTA button</label>
            <input type="text" name="extra[cta_button]" class="form-control" value="{{ $extra['cta_button'] ?? '' }}">
        </div>
        <div class="col-12">
            <label class="form-label">CTA body</label>
            <textarea name="extra[cta_body]" rows="2" class="form-control">{{ $extra['cta_body'] ?? '' }}</textarea>
        </div>
        @foreach(($extra['cta_paths'] ?? [['tag'=>'','text'=>''],['tag'=>'','text'=>''],['tag'=>'','text'=>'']]) as $ci => $path)
            <div class="col-md-4">
                <label class="form-label">CTA path {{ $ci + 1 }} tag</label>
                <input type="text" name="extra[cta_paths][{{ $ci }}][tag]" class="form-control" value="{{ $path['tag'] ?? '' }}">
                <input type="text" name="extra[cta_paths][{{ $ci }}][text]" class="form-control mt-2" value="{{ $path['text'] ?? '' }}" placeholder="Text">
            </div>
        @endforeach
    </div>
</div>
