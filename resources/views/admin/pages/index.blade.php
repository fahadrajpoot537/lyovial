@extends('admin.layouts.app')

@section('title', 'Pages')

@section('content')
    <div class="page-header">
        <div>
            <h1>Pages</h1>
            <p class="subtitle">Create, edit, unpublish, or delete every page. Changing the slug changes the public URL.</p>
        </div>
        @can('pages.create')
            <a href="{{ route('admin.pages.create') }}" class="btn btn-teal"><i class="bi bi-plus-lg me-1"></i> Add page</a>
        @endcan
    </div>

    <div class="card card-admin">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pages ?? $items ?? [] as $page)
                            <tr>
                                <td class="fw-semibold">{{ $page->title }}</td>
                                <td><span class="badge badge-soft-secondary">{{ \App\Models\Page::types()[$page->type] ?? $page->type }}</span></td>
                                <td class="text-muted small">{{ $page->slug }}</td>
                                <td>
                                    @if ($page->status)
                                        <span class="badge badge-soft">Active</span>
                                    @else
                                        <span class="badge badge-soft-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $page->sort_order }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ $page->publicUrl() }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">View</a>
                                    @can('pages.update')
                                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    @endcan
                                    @can('pages.delete')
                                        <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="d-inline" onsubmit="return confirm('Delete this page?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="bi bi-file-earmark-text d-block mb-2"></i>
                                    No pages yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.partials.pagination', ['items' => $pages ?? $items ?? null])
@endsection
