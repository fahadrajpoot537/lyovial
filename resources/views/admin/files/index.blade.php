@extends('admin.layouts.app')

@section('title', 'Files')

@section('content')
    <div class="page-header">
        <div>
            <h1>File Manager</h1>
            <p class="subtitle">Upload and manage documents</p>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card card-admin">
                <div class="card-header">Upload file</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.files.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="file">File</label>
                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" required>
                            @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea name="description" id="description" rows="2" class="form-control">{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="folder">Folder</label>
                            <input type="text" name="folder" id="folder" class="form-control" value="{{ old('folder', 'documents') }}">
                        </div>
                        <button type="submit" class="btn btn-teal w-100">Upload</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-admin">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-admin mb-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>File</th>
                                    <th>Size</th>
                                    <th>Uploaded</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($files ?? $items ?? [] as $file)
                                    <tr>
                                        <td class="fw-semibold">{{ $file->title ?: $file->original_name }}</td>
                                        <td>
                                            <a href="{{ $file->url }}" target="_blank" rel="noopener">{{ $file->original_name }}</a>
                                        </td>
                                        <td>{{ $file->human_size }}</td>
                                        <td class="text-muted small">{{ $file->created_at?->format('M j, Y') }}</td>
                                        <td class="text-end">
                                            <form method="POST" action="{{ route('admin.files.destroy', $file) }}" class="d-inline" onsubmit="return confirm('Delete this file?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="empty-state">
                                            <i class="bi bi-folder2-open d-block mb-2"></i>
                                            No files uploaded yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('admin.partials.pagination', ['items' => $files ?? $items ?? null])
        </div>
    </div>
@endsection
