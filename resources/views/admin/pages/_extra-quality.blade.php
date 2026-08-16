<div class="card card-admin mb-3">
    <div class="card-header">Quality page sections</div>
    <div class="card-body row g-3">
        <div class="col-md-6">
            <label class="form-label">Hero eyebrow</label>
            <input type="text" name="extra[hero_eyebrow]" class="form-control" value="{{ $extra['hero_eyebrow'] ?? '' }}">
        </div>
        <div class="col-12">
            <label class="form-label">Hero subtext</label>
            <textarea name="extra[hero_sub]" rows="2" class="form-control">{{ $extra['hero_sub'] ?? '' }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Approach eyebrow</label>
            <input type="text" name="extra[approach_eyebrow]" class="form-control" value="{{ $extra['approach_eyebrow'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Approach heading</label>
            <input type="text" name="extra[approach_heading]" class="form-control" value="{{ $extra['approach_heading'] ?? '' }}">
        </div>
        @foreach(($extra['approach_cards'] ?? [['title'=>'','body'=>''],['title'=>'','body'=>'']]) as $i => $card)
            <div class="col-md-6">
                <label class="form-label">Approach card {{ $i + 1 }} title</label>
                <input type="text" name="extra[approach_cards][{{ $i }}][title]" class="form-control" value="{{ $card['title'] ?? '' }}">
                <textarea name="extra[approach_cards][{{ $i }}][body]" rows="2" class="form-control mt-2" placeholder="Body">{{ $card['body'] ?? '' }}</textarea>
            </div>
        @endforeach
        <div class="col-12">
            <label class="form-label">Sterility heading</label>
            <input type="text" name="extra[sterility_heading]" class="form-control" value="{{ $extra['sterility_heading'] ?? '' }}">
        </div>
        <div class="col-12">
            <label class="form-label">Sterility body</label>
            <textarea name="extra[sterility_body]" rows="3" class="form-control">{{ $extra['sterility_body'] ?? '' }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Fit eyebrow</label>
            <input type="text" name="extra[fit_eyebrow]" class="form-control" value="{{ $extra['fit_eyebrow'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Fit heading</label>
            <input type="text" name="extra[fit_heading]" class="form-control" value="{{ $extra['fit_heading'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Yes column heading</label>
            <input type="text" name="extra[fit_yes_heading]" class="form-control" value="{{ $extra['fit_yes_heading'] ?? '' }}">
            @foreach(($extra['fit_yes'] ?? ['','','','']) as $i => $item)
                <input type="text" name="extra[fit_yes][{{ $i }}]" class="form-control mt-2" value="{{ $item }}" placeholder="Yes item {{ $i + 1 }}">
            @endforeach
        </div>
        <div class="col-md-6">
            <label class="form-label">No column heading</label>
            <input type="text" name="extra[fit_no_heading]" class="form-control" value="{{ $extra['fit_no_heading'] ?? '' }}">
            @foreach(($extra['fit_no'] ?? ['','','','']) as $i => $item)
                <input type="text" name="extra[fit_no][{{ $i }}]" class="form-control mt-2" value="{{ $item }}" placeholder="No item {{ $i + 1 }}">
            @endforeach
        </div>
        <div class="col-12">
            <label class="form-label">Quote</label>
            <textarea name="extra[quote]" rows="2" class="form-control">{{ $extra['quote'] ?? '' }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Quote label</label>
            <input type="text" name="extra[quote_label]" class="form-control" value="{{ $extra['quote_label'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">CTA button</label>
            <input type="text" name="extra[cta_button]" class="form-control" value="{{ $extra['cta_button'] ?? '' }}">
        </div>
        <div class="col-12">
            <label class="form-label">CTA heading</label>
            <input type="text" name="extra[cta_heading]" class="form-control" value="{{ $extra['cta_heading'] ?? '' }}">
        </div>
        <div class="col-12">
            <label class="form-label">CTA body</label>
            <textarea name="extra[cta_body]" rows="2" class="form-control">{{ $extra['cta_body'] ?? '' }}</textarea>
        </div>
    </div>
</div>
