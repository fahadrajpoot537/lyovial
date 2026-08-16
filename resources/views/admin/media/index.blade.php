@extends('admin.layouts.app')

@section('title', 'Media')

@section('content')
    <div class="page-header">
        <div>
            <h1>Media Library</h1>
            <p class="subtitle">Upload and manage images</p>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card card-admin">
                <div class="card-header">Upload media</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="file">File</label>
                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" accept="image/*" required>
                            @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="alt_text">Alt text</label>
                            <input type="text" name="alt_text" id="alt_text" class="form-control" value="{{ old('alt_text') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="folder">Folder</label>
                            <input type="text" name="folder" id="folder" class="form-control" value="{{ old('folder', 'uploads') }}">
                        </div>
                        <button type="submit" class="btn btn-teal w-100">Upload</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-admin mb-3">
                <div class="card-body">
                    <form method="GET" class="row g-2">
                        <div class="col-md-8">
                            <input type="search" name="q" class="form-control" placeholder="Search media..." value="{{ request('q') }}">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-secondary w-100" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="media-grid">
                @forelse ($media ?? $items ?? [] as $item)
                    <div class="media-tile">
                        <img src="{{ $item->url }}" alt="{{ $item->alt_text }}">
                        <div class="meta">
                            <div class="fw-semibold text-truncate" title="{{ $item->original_name }}">{{ $item->title ?: $item->original_name }}</div>
                            <div class="text-muted">{{ $item->human_size }}</div>
                            <div class="d-flex gap-1 mt-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary flex-grow-1"
                                        data-bs-toggle="modal" data-bs-target="#editMediaModal"
                                        data-id="{{ $item->id }}"
                                        data-title="{{ $item->title }}"
                                        data-alt="{{ $item->alt_text }}"
                                        data-caption="{{ $item->caption }}"
                                        data-description="{{ $item->description }}"
                                        data-seo="{{ $item->seo_name }}"
                                        data-lazy="{{ $item->lazy_load ? '1' : '0' }}"
                                        data-url="{{ route('admin.media.update', $item) }}">
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('admin.media.destroy', $item) }}" onsubmit="return confirm('Delete this media item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state w-100">
                        <i class="bi bi-images d-block mb-2"></i>
                        No media uploaded yet.
                    </div>
                @endforelse
            </div>

            @include('admin.partials.pagination', ['items' => $media ?? $items ?? null])
        </div>
    </div>

    <div class="modal fade" id="editMediaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="editMediaForm" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="edit_title">Title</label>
                        <input type="text" name="title" id="edit_title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_alt_text">Alt text</label>
                        <input type="text" name="alt_text" id="edit_alt_text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_caption">Caption</label>
                        <input type="text" name="caption" id="edit_caption" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_description">Description</label>
                        <textarea name="description" id="edit_description" rows="2" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_seo_name">SEO name</label>
                        <input type="text" name="seo_name" id="edit_seo_name" class="form-control">
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input type="hidden" name="lazy_load" value="0">
                        <input class="form-check-input" type="checkbox" name="lazy_load" id="edit_lazy_load" value="1">
                        <label class="form-check-label" for="edit_lazy_load">Lazy loading</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-teal">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.getElementById('editMediaModal')?.addEventListener('show.bs.modal', (event) => {
    const btn = event.relatedTarget;
    const form = document.getElementById('editMediaForm');
    form.action = btn.getAttribute('data-url');
    form.querySelector('#edit_title').value = btn.getAttribute('data-title') || '';
    form.querySelector('#edit_alt_text').value = btn.getAttribute('data-alt') || '';
    form.querySelector('#edit_caption').value = btn.getAttribute('data-caption') || '';
    form.querySelector('#edit_description').value = btn.getAttribute('data-description') || '';
    form.querySelector('#edit_seo_name').value = btn.getAttribute('data-seo') || '';
    form.querySelector('#edit_lazy_load').checked = btn.getAttribute('data-lazy') === '1';
});
</script>
@endpush
