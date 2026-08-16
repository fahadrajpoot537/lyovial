@php
    $item = $item ?? null;
@endphp

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card card-admin">
            <div class="card-header">Testimonial details</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $item?->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="role">Role / title</label>
                    <input type="text" name="role" id="role" class="form-control" value="{{ old('role', $item?->role) }}">
                </div>
                <div class="mb-0">
                    <label class="form-label" for="quote">Quote</label>
                    <textarea name="quote" id="quote" rows="5" class="form-control @error('quote') is-invalid @enderror" required>{{ old('quote', $item?->quote) }}</textarea>
                    @error('quote')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-admin mb-3">
            <div class="card-header">Publish</div>
            <div class="card-body">
                <div class="form-check form-switch mb-3">
                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" @checked(old('status', $item?->status ?? true))>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input type="hidden" name="show_on_home" value="0">
                    <input class="form-check-input" type="checkbox" name="show_on_home" id="show_on_home" value="1" @checked(old('show_on_home', $item?->show_on_home ?? true))>
                    <label class="form-check-label" for="show_on_home">Show on homepage</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="rating">Rating (1–5)</label>
                    <input type="number" name="rating" id="rating" min="1" max="5" class="form-control" value="{{ old('rating', $item?->rating ?? 5) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sort_order">Sort order</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $item?->sort_order ?? 0) }}">
                </div>
                <button type="submit" class="btn btn-teal w-100">{{ $item ? 'Update' : 'Create' }}</button>
            </div>
        </div>
        <div class="card card-admin">
            <div class="card-header">Avatar</div>
            <div class="card-body">
                <input type="file" name="avatar" class="form-control" accept="image/*">
                @if ($item?->avatar)
                    <img src="{{ storage_url($item->avatar) }}" alt="" class="preview-thumb mt-2 rounded-circle" style="width:80px;height:80px;object-fit:cover">
                @endif
            </div>
        </div>
    </div>
</div>
