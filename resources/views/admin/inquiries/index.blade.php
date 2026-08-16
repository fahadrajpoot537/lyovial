@extends('admin.layouts.app')

@section('title', 'Inquiries')

@section('content')
    <div class="page-header">
        <div>
            <h1>Inquiries</h1>
            <p class="subtitle">Contact form submissions</p>
        </div>
        @can('inquiries.export')
            <a href="{{ route('admin.inquiries.export', request()->query()) }}" class="btn btn-outline-secondary">
                <i class="bi bi-download me-1"></i> Export CSV
            </a>
        @endcan
    </div>

    <div class="card card-admin mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label" for="q">Search</label>
                    <input type="search" name="q" id="q" class="form-control" value="{{ request('q') }}" placeholder="Name, email, phone…">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="status">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All</option>
                        <option value="new" @selected(request('status') === 'new')>New</option>
                        <option value="read" @selected(request('status') === 'read')>Read</option>
                        <option value="archived" @selected(request('status') === 'archived')>Archived</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-teal flex-grow-1">Filter</button>
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-admin">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Received</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inquiries ?? $items ?? [] as $inquiry)
                            <tr class="{{ $inquiry->isUnread() ? 'table-active' : '' }}">
                                <td class="fw-semibold">{{ $inquiry->name }}</td>
                                <td>{{ $inquiry->company ?: '—' }}</td>
                                <td>{{ $inquiry->email }}</td>
                                <td>{{ $inquiry->phone ?: '—' }}</td>
                                <td>
                                    @if ($inquiry->status === 'new')
                                        <span class="badge badge-soft-warning">New</span>
                                    @elseif ($inquiry->status === 'read')
                                        <span class="badge badge-soft">Read</span>
                                    @else
                                        <span class="badge badge-soft-secondary">{{ ucfirst($inquiry->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $inquiry->created_at?->format('M j, Y g:i A') }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                    @can('inquiries.delete')
                                        <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" class="d-inline" onsubmit="return confirm('Delete this inquiry?');">
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
                                    <i class="bi bi-inbox d-block mb-2"></i>
                                    No inquiries found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.partials.pagination', ['items' => $inquiries ?? $items ?? null])
@endsection
