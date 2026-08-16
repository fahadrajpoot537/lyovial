@extends('admin.layouts.app')

@section('title', 'Industries')

@section('content')
    <div class="page-header">
        <div>
            <h1>Industries</h1>
            <p class="subtitle">Manage industry pages</p>
        </div>
        @can('industries.create')
            <a href="{{ route('admin.industries.create') }}" class="btn btn-teal"><i class="bi bi-plus-lg me-1"></i> Add industry</a>
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
                            <th>Status</th>
                            <th>Order</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($industries ?? $items ?? [] as $industry)
                            <tr>
                                <td class="fw-semibold">{{ $industry->title }}</td>
                                <td class="text-muted small">{{ $industry->slug }}</td>
                                <td>{{ $industry->show_on_home ? 'Yes' : 'No' }}</td>
                                <td>
                                    @if ($industry->status)
                                        <span class="badge badge-soft">Active</span>
                                    @else
                                        <span class="badge badge-soft-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $industry->sort_order }}</td>
                                <td class="text-end text-nowrap">
                                    @can('industries.update')
                                        <a href="{{ route('admin.industries.edit', $industry) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    @endcan
                                    @can('industries.delete')
                                        <form method="POST" action="{{ route('admin.industries.destroy', $industry) }}" class="d-inline" onsubmit="return confirm('Delete this industry?');">
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
                                    <i class="bi bi-buildings d-block mb-2"></i>
                                    No industries yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.partials.pagination', ['items' => $industries ?? $items ?? null])
@endsection
