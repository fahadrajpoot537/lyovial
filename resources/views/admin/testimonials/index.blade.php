@extends('admin.layouts.app')

@section('title', 'Testimonials')

@section('content')
    <div class="page-header">
        <div>
            <h1>Testimonials</h1>
            <p class="subtitle">Homepage client quotes</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-teal"><i class="bi bi-plus-lg me-1"></i> Add testimonial</a>
    </div>

    <div class="card card-admin">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Home</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items ?? [] as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->name }}</td>
                                <td class="text-muted small">{{ $item->role ?: '—' }}</td>
                                <td>{{ $item->show_on_home ? 'Yes' : 'No' }}</td>
                                <td>
                                    @if ($item->status)
                                        <span class="badge badge-soft">Active</span>
                                    @else
                                        <span class="badge badge-soft-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $item->sort_order }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('admin.testimonials.edit', $item) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form method="POST" action="{{ route('admin.testimonials.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Delete this testimonial?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="bi bi-chat-quote d-block mb-2"></i>
                                    No testimonials yet.
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
