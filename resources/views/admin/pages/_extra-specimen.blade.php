<div class="card card-admin mb-3">
    <div class="card-header">Specimen page sections</div>
    <div class="card-body row g-3">
        <div class="col-md-6">
            <label class="form-label">Hero eyebrow</label>
            <input type="text" name="extra[hero_eyebrow]" class="form-control" value="{{ $extra['hero_eyebrow'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Hero button</label>
            <input type="text" name="extra[hero_button]" class="form-control" value="{{ $extra['hero_button'] ?? '' }}">
        </div>
        <div class="col-12">
            <label class="form-label">Hero subtext</label>
            <textarea name="extra[hero_sub]" rows="3" class="form-control">{{ $extra['hero_sub'] ?? '' }}</textarea>
        </div>
        <div class="col-12"><strong>Benefits</strong></div>
        @foreach(($extra['benefits'] ?? [['title'=>''],['title'=>''],['title'=>''],['title'=>'']]) as $i => $row)
            <div class="col-md-6">
                <input type="text" name="extra[benefits][{{ $i }}][title]" class="form-control" value="{{ $row['title'] ?? '' }}" placeholder="Benefit {{ $i + 1 }}">
            </div>
        @endforeach
        <div class="col-md-6">
            <label class="form-label">Challenge eyebrow</label>
            <input type="text" name="extra[challenge_eyebrow]" class="form-control" value="{{ $extra['challenge_eyebrow'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Challenge heading</label>
            <input type="text" name="extra[challenge_heading]" class="form-control" value="{{ $extra['challenge_heading'] ?? '' }}">
        </div>
        <div class="col-12">
            <label class="form-label">Challenge body</label>
            <textarea name="extra[challenge_body]" rows="4" class="form-control">{{ $extra['challenge_body'] ?? '' }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Solution eyebrow</label>
            <input type="text" name="extra[solution_eyebrow]" class="form-control" value="{{ $extra['solution_eyebrow'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Solution heading</label>
            <input type="text" name="extra[solution_heading]" class="form-control" value="{{ $extra['solution_heading'] ?? '' }}">
        </div>
        @foreach(($extra['solution_steps'] ?? []) as $i => $step)
            <div class="col-12 border rounded p-3">
                <div class="row g-2">
                    <div class="col-md-2"><input type="text" name="extra[solution_steps][{{ $i }}][label]" class="form-control" value="{{ $step['label'] ?? '' }}" placeholder="Step 1"></div>
                    <div class="col-md-4"><input type="text" name="extra[solution_steps][{{ $i }}][title]" class="form-control" value="{{ $step['title'] ?? '' }}" placeholder="Title"></div>
                    <div class="col-md-6"><textarea name="extra[solution_steps][{{ $i }}][body]" rows="2" class="form-control" placeholder="Body">{{ $step['body'] ?? '' }}</textarea></div>
                </div>
            </div>
        @endforeach
        <div class="col-12"><strong>Stats</strong></div>
        @foreach(($extra['stats'] ?? ['','','','']) as $i => $stat)
            <div class="col-md-6">
                <input type="text" name="extra[stats][{{ $i }}]" class="form-control" value="{{ $stat }}" placeholder="Stat {{ $i + 1 }}">
            </div>
        @endforeach
        <div class="col-md-6">
            <label class="form-label">FAQ eyebrow</label>
            <input type="text" name="extra[faq_eyebrow]" class="form-control" value="{{ $extra['faq_eyebrow'] ?? '' }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">FAQ heading</label>
            <input type="text" name="extra[faq_heading]" class="form-control" value="{{ $extra['faq_heading'] ?? '' }}">
        </div>
        @foreach(($extra['faqs'] ?? []) as $i => $faq)
            <div class="col-12 border rounded p-3">
                <input type="text" name="extra[faqs][{{ $i }}][question]" class="form-control mb-2" value="{{ $faq['question'] ?? '' }}" placeholder="Question">
                <textarea name="extra[faqs][{{ $i }}][answer]" rows="2" class="form-control" placeholder="Answer">{{ $faq['answer'] ?? '' }}</textarea>
            </div>
        @endforeach
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
    </div>
</div>
