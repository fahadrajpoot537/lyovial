@php
    $extra = old('extra', $section?->extra ?? []);
    if (! is_array($extra)) {
        $extra = [];
    }
    $statItems = old('stat_items', $extra['items'] ?? [['num' => '', 'label' => '', 'icon' => 'flask']]);
    $partnerCards = old('partner_cards', $extra['cards'] ?? [['title' => '', 'description' => '', 'icon' => 'target']]);
    $processSteps = old('process_steps', $extra['steps'] ?? [['num' => '', 'title' => '']]);
    $coveragePoints = old('coverage_points', $extra['points'] ?? [['title' => '', 'text' => '']]);
@endphp

@if ($key === 'stats')
    <div class="card card-admin mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Stat items</span>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-repeat-add="statItems">Add stat</button>
        </div>
        <div class="card-body">
            <div id="statItems" data-repeat-list>
                @foreach ($statItems as $i => $row)
                    <div class="row g-2 align-items-end mb-2" data-repeat-row>
                        <div class="col-md-3">
                            <label class="form-label">Number</label>
                            <input type="text" name="stat_items[{{ $i }}][num]" class="form-control" value="{{ $row['num'] ?? '' }}" placeholder="250+">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Label</label>
                            <input type="text" name="stat_items[{{ $i }}][label]" class="form-control" value="{{ $row['label'] ?? '' }}" placeholder="Lyo Cycles Completed">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Icon</label>
                            <select name="stat_items[{{ $i }}][icon]" class="form-select">
                                @foreach (['flask','doc','vial','check'] as $icon)
                                    <option value="{{ $icon }}" @selected(($row['icon'] ?? '') === $icon)>{{ $icon }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-outline-danger w-100" data-repeat-remove>&times;</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@elseif ($key === 'partner')
    <div class="card card-admin mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Partner cards</span>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-repeat-add="partnerCards">Add card</button>
        </div>
        <div class="card-body">
            <div id="partnerCards" data-repeat-list>
                @foreach ($partnerCards as $i => $row)
                    <div class="border rounded p-3 mb-3" data-repeat-row>
                        <div class="row g-2">
                            <div class="col-md-5">
                                <label class="form-label">Title</label>
                                <input type="text" name="partner_cards[{{ $i }}][title]" class="form-control" value="{{ $row['title'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Icon</label>
                                <input type="text" name="partner_cards[{{ $i }}][icon]" class="form-control" value="{{ $row['icon'] ?? '' }}" placeholder="target">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger w-100" data-repeat-remove>Remove</button>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="partner_cards[{{ $i }}][description]" rows="2" class="form-control">{{ $row['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@elseif ($key === 'process')
    <div class="card card-admin mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Process steps</span>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-repeat-add="processSteps">Add step</button>
        </div>
        <div class="card-body">
            <div id="processSteps" data-repeat-list>
                @foreach ($processSteps as $i => $row)
                    <div class="row g-2 align-items-end mb-2" data-repeat-row>
                        <div class="col-md-2">
                            <label class="form-label">Num</label>
                            <input type="text" name="process_steps[{{ $i }}][num]" class="form-control" value="{{ $row['num'] ?? '' }}" placeholder="01">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label">Title</label>
                            <input type="text" name="process_steps[{{ $i }}][title]" class="form-control" value="{{ $row['title'] ?? '' }}">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-outline-danger w-100" data-repeat-remove>&times;</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@elseif ($key === 'canada_coverage')
    <div class="card card-admin mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Coverage points</span>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-repeat-add="coveragePoints">Add point</button>
        </div>
        <div class="card-body">
            <div id="coveragePoints" data-repeat-list>
                @foreach ($coveragePoints as $i => $row)
                    <div class="row g-2 align-items-end mb-2" data-repeat-row>
                        <div class="col-md-4">
                            <label class="form-label">Title</label>
                            <input type="text" name="coverage_points[{{ $i }}][title]" class="form-control" value="{{ $row['title'] ?? '' }}">
                        </div>
                        <div class="col-md-7">
                            <label class="form-label">Text</label>
                            <input type="text" name="coverage_points[{{ $i }}][text]" class="form-control" value="{{ $row['text'] ?? '' }}">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-outline-danger w-100" data-repeat-remove>&times;</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@else
    <div class="col-12 mt-3">
        <label class="form-label" for="extra">Extra (JSON)</label>
        <textarea name="extra" id="extra" rows="4" class="form-control font-monospace @error('extra') is-invalid @enderror">{{ old('extra', is_array($section?->extra) ? json_encode($section->extra, JSON_PRETTY_PRINT) : $section?->extra) }}</textarea>
        @error('extra')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="form-text">Optional advanced data for this section.</div>
    </div>
@endif

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
