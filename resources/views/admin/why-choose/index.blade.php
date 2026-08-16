@extends('admin.layouts.app')

@section('title', 'Why Choose Us')

@section('content')
    <div class="page-header">
        <div>
            <h1>Why Choose Us</h1>
            <p class="subtitle">Manage highlight items</p>
        </div>
        <a href="{{ route('admin.why-choose.create') }}" class="btn btn-teal"><i class="bi bi-plus-lg me-1"></i> Add item</a>
    </div>

    <div class="card card-admin">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items ?? [] as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->title }}</td>
                                <td class="text-muted small">{{ $item->icon ?: '—' }}</td>
                                <td>
                                    @if ($item->status)
                                        <span class="badge badge-soft">Active</span>
                                    @else
                                        <span class="badge badge-soft-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $item->sort_order }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('admin.why-choose.edit', $item) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form method="POST" action="{{ route('admin.why-choose.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <i class="bi bi-stars d-block mb-2"></i>
                                    No items yet.
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
