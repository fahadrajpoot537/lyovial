<div class="card card-admin mb-3">
    <div class="card-header">Privacy policy dates</div>
    <div class="card-body row g-3">
        <div class="col-md-4">
            <label class="form-label" for="extra_effective_date">Effective date</label>
            <input type="text" name="extra[effective_date]" id="extra_effective_date" class="form-control"
                   value="{{ $extra['effective_date'] ?? '' }}" placeholder="2026-08-27">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="extra_last_updated">Last updated</label>
            <input type="text" name="extra[last_updated]" id="extra_last_updated" class="form-control"
                   value="{{ $extra['last_updated'] ?? '' }}" placeholder="2026-08-27">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="extra_change_log">Change log</label>
            <input type="text" name="extra[change_log]" id="extra_change_log" class="form-control"
                   value="{{ $extra['change_log'] ?? '' }}" placeholder="v.2">
        </div>
        <div class="col-12">
            <p class="text-muted small mb-0">The policy body is edited in the Content field above. These fields appear at the top and bottom of the public page.</p>
        </div>
    </div>
</div>
