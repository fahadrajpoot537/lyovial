@extends('admin.layouts.app')

@section('title', 'Services')

@section('content')
    <div class="page-header">
        <div>
            <h1>Services</h1>
            <p class="subtitle">Manage service offerings</p>
        </div>
        @can('services.create')
            <a href="{{ route('admin.services.create') }}" class="btn btn-teal"><i class="bi bi-plus-lg me-1"></i> Add service</a>
        @endcan
    </div>

    <div class="card card-admin">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Home</th>
                            <th>Featured</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services ?? $items ?? [] as $service)
                            <tr>
                                <td class="fw-semibold">{{ $service->title }}</td>
                                <td class="text-muted small">{{ $service->slug }}</td>
                                <td>{{ $service->show_on_home ? 'Yes' : 'No' }}</td>
                                <td>{{ $service->is_featured ? 'Yes' : 'No' }}</td>
                                <td>
                                    @if ($service->status)
                                        <span class="badge badge-soft">Active</span>
                                    @else
                                        <span class="badge badge-soft-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $service->sort_order }}</td>
                                <td class="text-end text-nowrap">
                                    @can('services.update')
                                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    @endcan
                                    @can('services.delete')
                                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="d-inline" onsubmit="return confirm('Delete this service?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <i class="bi bi-briefcase d-block mb-2"></i>
                                    No services yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.partials.pagination', ['items' => $services ?? $items ?? null])
@endsection
