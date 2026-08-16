@extends('admin.layouts.app')

@section('title', 'Newsletter')

@section('content')
    <div class="page-header">
        <div>
            <h1>Newsletter</h1>
            <p class="subtitle">Email subscribers from the website footer</p>
        </div>
    </div>

    <div class="card card-admin mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-8">
                    <label class="form-label" for="q">Search</label>
                    <input type="search" name="q" id="q" class="form-control" value="{{ request('q') }}" placeholder="Email…">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-teal flex-grow-1">Filter</button>
                    <a href="{{ route('admin.newsletter.index') }}" class="btn btn-outline-secondary">Reset</a>
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
                            <th>Email</th>
                            <th>Subscribed</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscribers as $subscriber)
                            <tr>
                                <td class="fw-semibold">{{ $subscriber->email }}</td>
                                <td>{{ $subscriber->subscribed_at?->format('M j, Y g:i A') }}</td>
                                <td>{{ $subscriber->is_active ? 'Active' : 'Inactive' }}</td>
                                <td class="text-end">
                                    @can('inquiries.manage')
                                        <form method="POST" action="{{ route('admin.newsletter.destroy', $subscriber) }}" class="d-inline" onsubmit="return confirm('Remove this subscriber?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No subscribers yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($subscribers->hasPages())
            <div class="card-footer">{{ $subscribers->links() }}</div>
        @endif
    </div>
@endsection
