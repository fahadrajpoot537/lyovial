@php
    $service = $service ?? null;
    $extra = old('extra', $service?->extra);
    $extra = is_array($extra) ? $extra : [];
    $defaults = \App\Support\ThemePageDefaults::serviceExtra($service?->slug ?: 'custom');
    $extra = $service
        ? array_replace(\App\Support\ThemePageDefaults::emptyServiceExtra(), $extra)
        : array_replace($defaults, $extra);
    $includes = $extra['includes'] ?: [['title' => '', 'body' => '']];
    $whyBullets = $extra['why_bullets'] ?: ['', '', ''];
    $steps = $extra['steps'] ?: [['num' => '', 'title' => '', 'body' => '']];
    $galleries = old('galleries', $service?->galleries?->toArray() ?? []);
@endphp

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card card-admin mb-3">
            <div class="card-header">Service details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $service?->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug', $service?->slug) }}">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="page_heading">Banner heading</label>
                        <input type="text" name="page_heading" id="page_heading" class="form-control"
                               value="{{ old('page_heading', $service?->page_heading) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="extra_eyebrow">Eyebrow</label>
                        <input type="text" name="extra[eyebrow]" id="extra_eyebrow" class="form-control" value="{{ $extra['eyebrow'] ?? '' }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="extra_intro_heading">Intro heading (H2)</label>
                        <input type="text" name="extra[intro_heading]" id="extra_intro_heading" class="form-control" value="{{ $extra['intro_heading'] ?? '' }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="short_description">Lead paragraph</label>
                        <textarea name="short_description" id="short_description" rows="3" class="form-control @error('short_description') is-invalid @enderror">{{ old('short_description', $service?->short_description) }}</textarea>
                        @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="button_text">Button text</label>
                        <input type="text" name="button_text" id="button_text" class="form-control" value="{{ old('button_text', $service?->button_text) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="button_link">Button link</label>
                        <input type="text" name="button_link" id="button_link" class="form-control" value="{{ old('button_link', $service?->button_link ?: '/contact') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-admin mb-3">
            <div class="card-header">Includes cards</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Section heading</label>
                    <input type="text" name="extra[includes_heading]" class="form-control" value="{{ $extra['includes_heading'] ?? '' }}">
                </div>
                @foreach($includes as $i => $row)
                    <div class="border rounded p-3 mb-2">
                        <div class="row g-2">
                            <div class="col-md-5">
                                <input type="text" name="extra[includes][{{ $i }}][title]" class="form-control" placeholder="Title" value="{{ $row['title'] ?? '' }}">
                            </div>
                            <div class="col-md-7">
                                <textarea name="extra[includes][{{ $i }}][body]" rows="2" class="form-control" placeholder="Body">{{ $row['body'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
                @for($i = count($includes); $i < 4; $i++)
                    <div class="border rounded p-3 mb-2">
                        <div class="row g-2">
                            <div class="col-md-5">
                                <input type="text" name="extra[includes][{{ $i }}][title]" class="form-control" placeholder="Title">
                            </div>
                            <div class="col-md-7">
                                <textarea name="extra[includes][{{ $i }}][body]" rows="2" class="form-control" placeholder="Body"></textarea>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="card card-admin mb-3">
            <div class="card-header">Why it matters</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Heading</label>
                    <input type="text" name="extra[why_heading]" class="form-control" value="{{ $extra['why_heading'] ?? '' }}">
                </div>
                @foreach($whyBullets as $i => $bullet)
                    <input type="text" name="extra[why_bullets][{{ $i }}]" class="form-control mb-2" value="{{ is_string($bullet) ? $bullet : '' }}" placeholder="Bullet {{ $i + 1 }}">
                @endforeach
                @for($i = count($whyBullets); $i < 3; $i++)
                    <input type="text" name="extra[why_bullets][{{ $i }}]" class="form-control mb-2" placeholder="Bullet {{ $i + 1 }}">
                @endfor
            </div>
        </div>

        <div class="card card-admin mb-3">
            <div class="card-header">How it works (steps)</div>
            <div class="card-body">
                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <input type="text" name="extra[steps_heading]" class="form-control" placeholder="Steps heading" value="{{ $extra['steps_heading'] ?? '' }}">
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="extra[steps_intro]" class="form-control" placeholder="Steps intro" value="{{ $extra['steps_intro'] ?? '' }}">
                    </div>
                </div>
                @foreach($steps as $i => $step)
                    <div class="row g-2 mb-2">
                        <div class="col-md-2"><input type="text" name="extra[steps][{{ $i }}][num]" class="form-control" placeholder="01" value="{{ $step['num'] ?? '' }}"></div>
                        <div class="col-md-4"><input type="text" name="extra[steps][{{ $i }}][title]" class="form-control" placeholder="Title" value="{{ $step['title'] ?? '' }}"></div>
                        <div class="col-md-6"><input type="text" name="extra[steps][{{ $i }}][body]" class="form-control" placeholder="Body" value="{{ $step['body'] ?? '' }}"></div>
                    </div>
                @endforeach
                @for($i = count($steps); $i < 4; $i++)
                    <div class="row g-2 mb-2">
                        <div class="col-md-2"><input type="text" name="extra[steps][{{ $i }}][num]" class="form-control" placeholder="0{{ $i + 1 }}"></div>
                        <div class="col-md-4"><input type="text" name="extra[steps][{{ $i }}][title]" class="form-control" placeholder="Title"></div>
                        <div class="col-md-6"><input type="text" name="extra[steps][{{ $i }}][body]" class="form-control" placeholder="Body"></div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="card card-admin mb-3">
            <div class="card-header">Sidebar & bottom CTA</div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label class="form-label">Sidebar CTA title</label>
                    <input type="text" name="extra[sidebar_cta_title]" class="form-control" value="{{ $extra['sidebar_cta_title'] ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sidebar CTA button</label>
                    <input type="text" name="extra[sidebar_cta_button]" class="form-control" value="{{ $extra['sidebar_cta_button'] ?? '' }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Sidebar CTA body</label>
                    <textarea name="extra[sidebar_cta_body]" rows="2" class="form-control">{{ $extra['sidebar_cta_body'] ?? '' }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bottom CTA heading</label>
                    <input type="text" name="extra[bottom_cta_heading]" class="form-control" value="{{ $extra['bottom_cta_heading'] ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Bottom CTA button</label>
                    <input type="text" name="extra[bottom_cta_button]" class="form-control" value="{{ $extra['bottom_cta_button'] ?? '' }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Bottom CTA body</label>
                    <textarea name="extra[bottom_cta_body]" rows="2" class="form-control">{{ $extra['bottom_cta_body'] ?? '' }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Related section heading</label>
                    <input type="text" name="extra[related_heading]" class="form-control" value="{{ $extra['related_heading'] ?? 'Related Services' }}">
                </div>
            </div>
        </div>

        <div class="card card-admin mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Gallery</span>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-gallery-add="#galleryRepeater">
                    <i class="bi bi-plus-lg"></i> Add image
                </button>
            </div>
            <div class="card-body" id="galleryRepeater">
                @forelse ($galleries as $i => $gallery)
                    <div class="gallery-row" data-gallery-row>
                        @if (!empty($gallery['id']))
                            <input type="hidden" name="galleries[{{ $i }}][id]" value="{{ $gallery['id'] }}">
                        @endif
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Image</label>
                                <input type="file" name="galleries[{{ $i }}][image]" class="form-control" accept="image/*">
                                @if (!empty($gallery['image']))
                                    <img src="{{ storage_url($gallery['image']) }}" alt="" class="preview-thumb mt-2">
                                    <input type="hidden" name="galleries[{{ $i }}][existing_image]" value="{{ $gallery['image'] }}">
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="galleries[{{ $i }}][title]" class="form-control" value="{{ $gallery['title'] ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Alt text</label>
                                <input type="text" name="galleries[{{ $i }}][alt_text]" class="form-control" value="{{ $gallery['alt_text'] ?? '' }}">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">Order</label>
                                <input type="number" name="galleries[{{ $i }}][sort_order]" class="form-control" value="{{ $gallery['sort_order'] ?? $i }}">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-outline-danger w-100" data-gallery-remove title="Remove">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No gallery images. Click “Add image” to start.</p>
                @endforelse
            </div>
        </div>

        @include('admin.partials.seo-fields', ['seo' => $service?->seo, 'hideSeoSlug' => true, 'seoSourceTitle' => old('title', $service?->title)])
    </div>

    <div class="col-lg-4">
        <div class="card card-admin mb-3">
            <div class="card-header">Publish</div>
            <div class="card-body">
                <div class="form-check form-switch mb-2">
                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" @checked(old('status', $service?->status ?? true))>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <div class="form-check form-switch mb-2">
                    <input type="hidden" name="show_on_home" value="0">
                    <input class="form-check-input" type="checkbox" name="show_on_home" id="show_on_home" value="1" @checked(old('show_on_home', $service?->show_on_home))>
                    <label class="form-check-label" for="show_on_home">Show on home</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input type="hidden" name="is_featured" value="0">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" @checked(old('is_featured', $service?->is_featured))>
                    <label class="form-check-label" for="is_featured">Featured</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sort_order">Sort order</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $service?->sort_order ?? 0) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="home_sort_order">Home sort order</label>
                    <input type="number" name="home_sort_order" id="home_sort_order" class="form-control" value="{{ old('home_sort_order', $service?->home_sort_order ?? 0) }}">
                </div>
                <button type="submit" class="btn btn-teal w-100">{{ $service ? 'Update service' : 'Create service' }}</button>
            </div>
        </div>

        <div class="card card-admin mb-3">
            <div class="card-header">Featured image</div>
            <div class="card-body">
                <input type="file" name="featured_image" class="form-control" accept="image/*">
                @if ($service?->featured_image)
                    <img src="{{ storage_url($service->featured_image) }}" alt="" class="preview-thumb mt-2 w-100" style="max-height:140px;object-fit:cover">
                @endif
            </div>
        </div>

        <div class="card card-admin">
            <div class="card-header">Banner image (optional)</div>
            <div class="card-body">
                <input type="file" name="banner_image" class="form-control" accept="image/*">
                @if ($service?->banner_image)
                    <img src="{{ storage_url($service->banner_image) }}" alt="" class="preview-thumb mt-2 w-100" style="max-height:140px;object-fit:cover">
                @endif
            </div>
        </div>
    </div>
</div>
