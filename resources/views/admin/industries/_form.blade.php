@php
    $industry = $industry ?? null;
@endphp

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card card-admin mb-3">
            <div class="card-header">Industry details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $industry?->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug', $industry?->slug) }}">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="heading">Heading</label>
                        <input type="text" name="heading" id="heading" class="form-control" value="{{ old('heading', $industry?->heading) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="short_description">Short description</label>
                        <textarea name="short_description" id="short_description" rows="2" class="form-control">{{ old('short_description', $industry?->short_description) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="description">Description</label>
                        @include('admin.partials.editor', ['name' => 'description', 'id' => 'description', 'value' => $industry?->description])
                    </div>
                </div>
            </div>
        </div>

        @include('admin.industries._extra')

        @include('admin.partials.seo-fields', ['seo' => $industry?->seo, 'hideSeoSlug' => true, 'seoSourceTitle' => old('title', $industry?->title)])
    </div>

    <div class="col-lg-4">
        <div class="card card-admin mb-3">
            <div class="card-header">Publish</div>
            <div class="card-body">
                <div class="form-check form-switch mb-2">
                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" @checked(old('status', $industry?->status ?? true))>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input type="hidden" name="show_on_home" value="0">
                    <input class="form-check-input" type="checkbox" name="show_on_home" id="show_on_home" value="1" @checked(old('show_on_home', $industry?->show_on_home))>
                    <label class="form-check-label" for="show_on_home">Show on home</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sort_order">Sort order</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $industry?->sort_order ?? 0) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="home_sort_order">Home sort order</label>
                    <input type="number" name="home_sort_order" id="home_sort_order" class="form-control" value="{{ old('home_sort_order', $industry?->home_sort_order ?? 0) }}">
                </div>
                <button type="submit" class="btn btn-teal w-100">{{ $industry ? 'Update industry' : 'Create industry' }}</button>
            </div>
        </div>

        <div class="card card-admin mb-3">
            <div class="card-header">Banner image</div>
            <div class="card-body">
                <input type="file" name="banner_image" class="form-control" accept="image/*">
                @if ($industry?->banner_image)
                    <img src="{{ storage_url($industry->banner_image) }}" alt="" class="preview-thumb mt-2 w-100" style="max-height:120px;object-fit:cover">
                @endif
            </div>
        </div>

        <div class="card card-admin">
            <div class="card-header">Image</div>
            <div class="card-body">
                <input type="file" name="image" class="form-control" accept="image/*">
                @if ($industry?->image)
                    <img src="{{ storage_url($industry->image) }}" alt="" class="preview-thumb mt-2 w-100" style="max-height:120px;object-fit:cover">
                @endif
            </div>
        </div>
    </div>
</div>
