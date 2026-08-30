@extends('admin.layouts.app')

@section('title', 'Articles')

@section('content')
    <div class="page-header">
        <div>
            <h1>Articles</h1>
            <p class="subtitle">Homepage blog / insights</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-teal"><i class="bi bi-plus-lg me-1"></i> Add article</a>
    </div>

    <div class="card card-admin">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Published</th>
                            <th>Home</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items ?? [] as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->title }}</td>
                                <td class="text-muted small">{{ $item->author_name ?: '—' }}</td>
                                <td class="small">{{ $item->published_at?->format('Y-m-d') ?: '—' }}</td>
                                <td>{{ $item->show_on_home ? 'Yes' : 'No' }}</td>
                                <td>
                                    @if ($item->status)
                                        <span class="badge badge-soft">Active</span>
                                    @else
                                        <span class="badge badge-soft-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('blog.show', $item) }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">View</a>
                                    <a href="{{ route('admin.articles.edit', $item) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form method="POST" action="{{ route('admin.articles.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Delete this article?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="bi bi-journal-text d-block mb-2"></i>
                                    No articles yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.partials.pagination', ['items' => $items ?? null])
@endsection
