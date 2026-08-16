@extends('admin.layouts.app')

@section('title', 'Edit home section')

@section('content')
    @php
        $section = $section ?? null;
        $key = $key ?? $section?->section_key;
        $label = \App\Models\HomeSection::sectionKeys()[$key] ?? $key;
    @endphp

    <div class="page-header">
        <div>
            <h1>{{ $label }}</h1>
            <p class="subtitle">Home section · <code>{{ $key }}</code></p>
        </div>
        <a href="{{ route('admin.home.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.home.update', $key) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="section_key" value="{{ $key }}">

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card card-admin">
                    <div class="card-header">Section content</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="small_title">Small title</label>
                                <input type="text" name="small_title" id="small_title" class="form-control"
                                       value="{{ old('small_title', $section?->small_title) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="heading">Heading</label>
                                <input type="text" name="heading" id="heading" class="form-control @error('heading') is-invalid @enderror"
                                       value="{{ old('heading', $section?->heading) }}">
                                @error('heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="description">Description</label>
                                @include('admin.partials.editor', ['name' => 'description', 'id' => 'description', 'value' => $section?->description])
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="button_primary_text">Primary button text</label>
                                <input type="text" name="button_primary_text" id="button_primary_text" class="form-control"
                                       value="{{ old('button_primary_text', $section?->button_primary_text) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="button_primary_link">Primary button link</label>
                                <input type="text" name="button_primary_link" id="button_primary_link" class="form-control"
                                       value="{{ old('button_primary_link', $section?->button_primary_link) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="button_secondary_text">Secondary button text</label>
                                <input type="text" name="button_secondary_text" id="button_secondary_text" class="form-control"
                                       value="{{ old('button_secondary_text', $section?->button_secondary_text) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="button_secondary_link">Secondary button link</label>
                                <input type="text" name="button_secondary_link" id="button_secondary_link" class="form-control"
                                       value="{{ old('button_secondary_link', $section?->button_secondary_link) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="map_embed">Map embed</label>
                                <textarea name="map_embed" id="map_embed" rows="3" class="form-control font-monospace">{{ old('map_embed', $section?->map_embed) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                @include('admin.home._extra-fields', ['section' => $section, 'key' => $key])

                @include('admin.partials.seo-fields', ['seo' => $section?->seo, 'hideSeoSlug' => true, 'seoSourceTitle' => old('heading', $section?->heading)])
            </div>

            <div class="col-lg-4">
                <div class="card card-admin mb-3">
                    <div class="card-header">Settings</div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                   @checked(old('is_active', $section?->is_active ?? true))>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sort_order">Sort order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control"
                                   value="{{ old('sort_order', $section?->sort_order ?? 0) }}">
                        </div>
                        <button type="submit" class="btn btn-teal w-100">Save section</button>
                    </div>
                </div>

                <div class="card card-admin">
                    <div class="card-header">Image</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if ($section?->image)
                                <img src="{{ storage_url($section->image) }}" alt="" class="preview-thumb mt-2 w-100" style="max-height:140px;object-fit:cover">
                            @endif
                        </div>
                        <div>
                            <label class="form-label" for="image_alt">Image alt</label>
                            <input type="text" name="image_alt" id="image_alt" class="form-control"
                                   value="{{ old('image_alt', $section?->image_alt) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
