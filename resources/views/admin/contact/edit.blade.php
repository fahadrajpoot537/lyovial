@extends('admin.layouts.app')

@section('title', 'Contact page')

@section('content')
    @php $contact = $contact ?? $page ?? null; @endphp

    <div class="page-header">
        <div>
            <h1>Contact page</h1>
            <p class="subtitle">Edit contact page content</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.contact.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card card-admin mb-3">
                    <div class="card-header">Page content</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label" for="heading">Heading</label>
                                <input type="text" name="heading" id="heading" class="form-control @error('heading') is-invalid @enderror"
                                       value="{{ old('heading', $contact?->heading) }}">
                                @error('heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="description">Description</label>
                                @include('admin.partials.editor', ['name' => 'description', 'id' => 'description', 'value' => $contact?->description])
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="form_heading">Form heading</label>
                                <input type="text" name="form_heading" id="form_heading" class="form-control"
                                       value="{{ old('form_heading', $contact?->form_heading) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="what_to_include_heading">What to include — heading</label>
                                <input type="text" name="what_to_include_heading" id="what_to_include_heading" class="form-control"
                                       value="{{ old('what_to_include_heading', $contact?->what_to_include_heading) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="how_can_we_help_heading">How can we help — heading</label>
                                <input type="text" name="how_can_we_help_heading" id="how_can_we_help_heading" class="form-control"
                                       value="{{ old('how_can_we_help_heading', $contact?->how_can_we_help_heading) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="what_to_include_content">What to include — content</label>
                                @include('admin.partials.editor', ['name' => 'what_to_include_content', 'id' => 'what_to_include_content', 'value' => $contact?->what_to_include_content, 'rows' => 5])
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="how_can_we_help_content">How can we help — content</label>
                                @include('admin.partials.editor', ['name' => 'how_can_we_help_content', 'id' => 'how_can_we_help_content', 'value' => $contact?->how_can_we_help_content, 'rows' => 5])
                            </div>
                        </div>
                    </div>
                </div>

                @include('admin.partials.seo-fields', ['seo' => $contact?->seo])
            </div>

            <div class="col-lg-4">
                <div class="card card-admin mb-3">
                    <div class="card-header">Contact details</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $contact?->phone) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $contact?->email) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="address">Address</label>
                            <textarea name="address" id="address" rows="2" class="form-control">{{ old('address', $contact?->address) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="map_embed">Map embed</label>
                            <textarea name="map_embed" id="map_embed" rows="3" class="form-control font-monospace">{{ old('map_embed', $contact?->map_embed) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-teal w-100">Save contact page</button>
                    </div>
                </div>

                <div class="card card-admin">
                    <div class="card-header">Banner image</div>
                    <div class="card-body">
                        <input type="file" name="banner_image" class="form-control" accept="image/*">
                        @if ($contact?->banner_image)
                            <img src="{{ storage_url($contact->banner_image) }}" alt="" class="preview-thumb mt-2 w-100" style="max-height:140px;object-fit:cover">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
