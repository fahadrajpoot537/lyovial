<div class="card card-admin mb-3">
    <div class="card-header">Hero</div>
    <div class="card-body row g-3">
        <div class="col-md-4">
            <label class="form-label">Eyebrow</label>
            <input type="text" name="extra[hero_eyebrow]" class="form-control" value="{{ $extra['hero_eyebrow'] ?? '' }}">
        </div>
        <div class="col-md-8">
            <label class="form-label">Heading (line break allowed)</label>
            <textarea name="extra[hero_heading]" rows="2" class="form-control">{{ $extra['hero_heading'] ?? '' }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Subtext</label>
            <textarea name="extra[hero_sub]" rows="2" class="form-control">{{ $extra['hero_sub'] ?? '' }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Hero image</label>
            <input type="file" name="hero_image_upload" class="form-control" accept="image/*">
            <input type="hidden" name="extra[hero_image]" value="{{ $extra['hero_image'] ?? '' }}">
            @if(!empty($extra['hero_image']))
                <img src="{{ str_starts_with($extra['hero_image'], '/images/') ? $extra['hero_image'] : storage_url($extra['hero_image']) }}" alt="" class="preview-thumb mt-2" style="max-height:120px;object-fit:cover">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="remove_hero_image" id="remove_hero_image" value="1">
                    <label class="form-check-label" for="remove_hero_image">Remove hero image (use default photo)</label>
                </div>
            @endif
            <label class="form-label mt-3">Hero image alt</label>
            <input type="text" name="extra[hero_image_alt]" class="form-control" value="{{ $extra['hero_image_alt'] ?? '' }}">
            <div class="form-text">Or set the Banner image in the sidebar. Leave both empty to use the Kanata facility photo.</div>
        </div>
        @foreach(($extra['cards'] ?? [['title'=>'','text'=>''],['title'=>'','text'=>'']]) as $i => $card)
            <div class="col-md-6">
                <label class="form-label">Card {{ $i + 1 }} title</label>
                <input type="text" name="extra[cards][{{ $i }}][title]" class="form-control" value="{{ $card['title'] ?? '' }}">
                <input type="text" name="extra[cards][{{ $i }}][text]" class="form-control mt-2" value="{{ $card['text'] ?? '' }}" placeholder="Card line">
            </div>
        @endforeach
    </div>
</div>

<div class="card card-admin mb-3">
    <div class="card-header">Our Origin</div>
    <div class="card-body row g-3">
        <div class="col-md-4">
            <label class="form-label">Eyebrow</label>
            <input type="text" name="extra[origin_eyebrow]" class="form-control" value="{{ $extra['origin_eyebrow'] ?? '' }}">
        </div>
        <div class="col-md-8">
            <label class="form-label">Heading (line break allowed)</label>
            <textarea name="extra[origin_heading]" rows="2" class="form-control">{{ $extra['origin_heading'] ?? '' }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Body</label>
            <textarea name="extra[origin_body]" rows="3" class="form-control">{{ $extra['origin_body'] ?? '' }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Quote</label>
            <textarea name="extra[origin_quote]" rows="2" class="form-control">{{ $extra['origin_quote'] ?? '' }}</textarea>
        </div>
        <div class="col-md-8">
            <label class="form-label">Origin image</label>
            <input type="file" name="origin_image_upload" class="form-control" accept="image/*">
            <input type="hidden" name="extra[origin_image]" value="{{ $extra['origin_image'] ?? '' }}">
            @if(!empty($extra['origin_image']))
                <img src="{{ str_starts_with($extra['origin_image'], '/images/') ? $extra['origin_image'] : storage_url($extra['origin_image']) }}" alt="" class="preview-thumb mt-2" style="max-height:120px;object-fit:cover">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="remove_origin_image" id="remove_origin_image" value="1">
                    <label class="form-check-label" for="remove_origin_image">Remove origin image</label>
                </div>
            @endif
        </div>
        <div class="col-md-4">
            <label class="form-label">Image alt</label>
            <input type="text" name="extra[origin_image_alt]" class="form-control" value="{{ $extra['origin_image_alt'] ?? '' }}">
        </div>
    </div>
</div>

<div class="card card-admin mb-3">
    <div class="card-header">Our Expertise</div>
    <div class="card-body row g-3">
        <div class="col-md-4">
            <label class="form-label">Eyebrow</label>
            <input type="text" name="extra[expertise_eyebrow]" class="form-control" value="{{ $extra['expertise_eyebrow'] ?? '' }}">
        </div>
        <div class="col-md-8">
            <label class="form-label">Heading</label>
            <input type="text" name="extra[expertise_heading]" class="form-control" value="{{ $extra['expertise_heading'] ?? '' }}">
        </div>
        <div class="col-12">
            <label class="form-label">Body</label>
            <textarea name="extra[expertise_body]" rows="3" class="form-control">{{ $extra['expertise_body'] ?? '' }}</textarea>
        </div>
        <div class="col-md-8">
            <label class="form-label">Expertise image</label>
            <input type="file" name="expertise_image_upload" class="form-control" accept="image/*">
            <input type="hidden" name="extra[expertise_image]" value="{{ $extra['expertise_image'] ?? '' }}">
            @if(!empty($extra['expertise_image']))
                <img src="{{ str_starts_with($extra['expertise_image'], '/images/') ? $extra['expertise_image'] : storage_url($extra['expertise_image']) }}" alt="" class="preview-thumb mt-2" style="max-height:120px;object-fit:cover">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="remove_expertise_image" id="remove_expertise_image" value="1">
                    <label class="form-check-label" for="remove_expertise_image">Remove expertise image</label>
                </div>
            @endif
        </div>
        <div class="col-md-4">
            <label class="form-label">Image alt</label>
            <input type="text" name="extra[expertise_image_alt]" class="form-control" value="{{ $extra['expertise_image_alt'] ?? '' }}">
        </div>
        @foreach(($extra['steps'] ?? [['num'=>'01','title'=>'','body'=>''],['num'=>'02','title'=>'','body'=>''],['num'=>'03','title'=>'','body'=>''],['num'=>'04','title'=>'','body'=>'']]) as $i => $step)
            <div class="col-md-6">
                <label class="form-label">Step {{ $i + 1 }}</label>
                <div class="input-group mb-2">
                    <input type="text" name="extra[steps][{{ $i }}][num]" class="form-control" style="max-width:80px" value="{{ $step['num'] ?? str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}">
                    <input type="text" name="extra[steps][{{ $i }}][title]" class="form-control" value="{{ $step['title'] ?? '' }}" placeholder="Title">
                </div>
                <textarea name="extra[steps][{{ $i }}][body]" rows="2" class="form-control" placeholder="Body">{{ $step['body'] ?? '' }}</textarea>
            </div>
        @endforeach
    </div>
</div>

<div class="card card-admin mb-3">
    <div class="card-header">Pilot-scale band + CTA</div>
    <div class="card-body row g-3">
        <div class="col-md-6">
            <label class="form-label">Band heading</label>
            <input type="text" name="extra[band_heading]" class="form-control" value="{{ $extra['band_heading'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Tags (one per line)</label>
            <textarea name="extra[band_tags_text]" rows="3" class="form-control">{{ implode("\n", $extra['band_tags'] ?? []) }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Band body</label>
            <textarea name="extra[band_body]" rows="3" class="form-control">{{ $extra['band_body'] ?? '' }}</textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label">CTA eyebrow</label>
            <input type="text" name="extra[cta_eyebrow]" class="form-control" value="{{ $extra['cta_eyebrow'] ?? '' }}">
        </div>
        <div class="col-md-8">
            <label class="form-label">CTA heading</label>
            <input type="text" name="extra[cta_heading]" class="form-control" value="{{ $extra['cta_heading'] ?? '' }}">
        </div>
        <div class="col-12">
            <label class="form-label">CTA body</label>
            <textarea name="extra[cta_body]" rows="2" class="form-control">{{ $extra['cta_body'] ?? '' }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">CTA button</label>
            <input type="text" name="extra[cta_button]" class="form-control" value="{{ $extra['cta_button'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">CTA link</label>
            <input type="text" name="extra[cta_link]" class="form-control" value="{{ $extra['cta_link'] ?? '/contact' }}">
        </div>
    </div>
</div>
