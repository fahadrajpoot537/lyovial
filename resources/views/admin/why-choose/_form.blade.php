@php
    $item = $item ?? null;
@endphp

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card card-admin">
            <div class="card-header">Item details</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $item?->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $item?->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-0">
                    <label class="form-label" for="icon">Icon class</label>
                    <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon', $item?->icon) }}" placeholder="bi bi-shield-check">
                    <div class="form-text">Bootstrap Icons class name</div>
                </div>
            </div>
        </div>

        @include('admin.partials.seo-fields', ['seo' => $item?->seo, 'hideSeoSlug' => true, 'seoSourceTitle' => old('title', $item?->title)])
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
                <div class="mb-3">
                    <label class="form-label" for="sort_order">Sort order</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $item?->sort_order ?? 0) }}">
                </div>
                <button type="submit" class="btn btn-teal w-100">{{ $item ? 'Update item' : 'Create item' }}</button>
            </div>
        </div>
        <div class="card card-admin">
            <div class="card-header">Image</div>
            <div class="card-body">
                <input type="file" name="image" class="form-control" accept="image/*">
                @if ($item?->image)
                    <img src="{{ storage_url($item->image) }}" alt="" class="preview-thumb mt-2 w-100" style="max-height:120px;object-fit:cover">
                @endif
            </div>
        </div>
    </div>
</div>
