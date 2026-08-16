@php
    $page = $page ?? null;
    $type = old('type', $page?->type ?? 'custom');
    $extra = old('extra', $page?->extra ?? []);
    if ($type === \App\Models\Page::TYPE_QUALITY_COMPLIANCE) {
        $extra = array_replace_recursive(\App\Support\ThemePageDefaults::qualityExtra(), is_array($extra) ? $extra : []);
    } elseif ($type === \App\Models\Page::TYPE_SPECIMEN_LIBRARY) {
        $extra = array_replace_recursive(\App\Support\ThemePageDefaults::specimenExtra(), is_array($extra) ? $extra : []);
    } elseif ($type === \App\Models\Page::TYPE_PARTNERSHIPS) {
        $extra = array_replace_recursive(\App\Support\ThemePageDefaults::partnershipsExtra(), is_array($extra) ? $extra : []);
    }
@endphp

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card card-admin mb-3">
            <div class="card-header">Page content</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $page?->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug', $page?->slug) }}">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="type">Type</label>
                        <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
                            @foreach (\App\Models\Page::types() as $value => $label)
                                <option value="{{ $value }}" @selected($type === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="heading">Hero / page heading</label>
                        <input type="text" name="heading" id="heading" class="form-control @error('heading') is-invalid @enderror"
                               value="{{ old('heading', $page?->heading) }}">
                        @error('heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @if($type === 'custom')
                    <div class="col-12">
                        <label class="form-label" for="content">Content</label>
                        @include('admin.partials.editor', ['name' => 'content', 'id' => 'content', 'value' => $page?->content])
                    </div>
                    @else
                        <input type="hidden" name="content" value="{{ old('content', $page?->content) }}">
                    @endif
                </div>
            </div>
        </div>

        @if($type === \App\Models\Page::TYPE_QUALITY_COMPLIANCE)
            @include('admin.pages._extra-quality', ['extra' => $extra])
        @elseif($type === \App\Models\Page::TYPE_SPECIMEN_LIBRARY)
            @include('admin.pages._extra-specimen', ['extra' => $extra])
        @elseif($type === \App\Models\Page::TYPE_PARTNERSHIPS)
            @include('admin.pages._extra-partnerships', ['extra' => $extra])
        @endif

        @include('admin.partials.seo-fields', ['seo' => $page?->seo, 'hideSeoSlug' => true, 'seoSourceTitle' => old('title', $page?->title)])
    </div>

    <div class="col-lg-4">
        <div class="card card-admin mb-3">
            <div class="card-header">Publish</div>
            <div class="card-body">
                <div class="form-check form-switch mb-3">
                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
                           @checked(old('status', $page?->status ?? true))>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sort_order">Sort order</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control"
                           value="{{ old('sort_order', $page?->sort_order ?? 0) }}">
                </div>
                <button type="submit" class="btn btn-teal w-100">{{ $page ? 'Update page' : 'Create page' }}</button>
            </div>
        </div>

        <div class="card card-admin">
            <div class="card-header">Banner image</div>
            <div class="card-body">
                <input type="file" name="banner_image" id="banner_image" class="form-control @error('banner_image') is-invalid @enderror" accept="image/*">
                @error('banner_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @if ($page?->banner_image)
                    <img src="{{ storage_url($page->banner_image) }}" alt="" class="preview-thumb mt-2 w-100" style="max-height:140px;object-fit:cover">
                @endif
            </div>
        </div>
    </div>
</div>
