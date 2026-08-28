@php
    $item = $item ?? null;
@endphp

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card card-admin">
            <div class="card-header">Article content</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $item?->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="slug">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                           value="{{ old('slug', $item?->slug) }}">
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="excerpt">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="2" class="form-control">{{ old('excerpt', $item?->excerpt) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="content">Content</label>
                    <p class="form-text mb-2">
                        Use <strong>Heading 1 / 2 / 3</strong> in the editor. Click under the heading
                        where the photo should appear, then use the <strong>image</strong> button to upload it.
                        Click the image to add a caption or choose full-width / side layout.
                    </p>
                    @include('admin.partials.editor', ['name' => 'content', 'id' => 'content', 'value' => $item?->content, 'minHeight' => 440])
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="author_name">Author name</label>
                        <input type="text" name="author_name" id="author_name" class="form-control" value="{{ old('author_name', $item?->author_name ?: 'Vladimir Evtodienko') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="author_role">Author role</label>
                        <input type="text" name="author_role" id="author_role" class="form-control" value="{{ old('author_role', $item?->author_role ?: 'CEO, Founder- IVD Technology') }}">
                    </div>
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
                <div class="form-check form-switch mb-3">
                    <input type="hidden" name="show_on_home" value="0">
                    <input class="form-check-input" type="checkbox" name="show_on_home" id="show_on_home" value="1" @checked(old('show_on_home', $item?->show_on_home ?? true))>
                    <label class="form-check-label" for="show_on_home">Show on homepage</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="published_at">Published at</label>
                    <input type="datetime-local" name="published_at" id="published_at" class="form-control"
                           value="{{ old('published_at', $item?->published_at?->format('Y-m-d\TH:i')) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sort_order">Sort order</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $item?->sort_order ?? 0) }}">
                </div>
                <button type="submit" class="btn btn-teal w-100">{{ $item ? 'Update article' : 'Create article' }}</button>
            </div>
        </div>
        <div class="card card-admin mb-3">
            <div class="card-header">Featured image</div>
            <div class="card-body">
                <input type="file" name="featured_image" class="form-control" accept="image/*">
                @if ($item?->featured_image)
                    <img src="{{ storage_url($item->featured_image) }}" alt="" class="preview-thumb mt-2 w-100" style="max-height:140px;object-fit:cover">
                @endif
            </div>
        </div>
        <div class="card card-admin">
            <div class="card-header">Author avatar</div>
            <div class="card-body">
                <input type="file" name="author_avatar" class="form-control" accept="image/*">
                @if ($item?->author_avatar)
                    <img src="{{ storage_url($item->author_avatar) }}" alt="" class="preview-thumb mt-2 rounded-circle" style="width:64px;height:64px;object-fit:cover">
                @endif
            </div>
        </div>
    </div>
</div>
