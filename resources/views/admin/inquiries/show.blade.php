@extends('admin.layouts.app')

@section('title', 'Inquiry')

@section('content')
    <div class="page-header">
        <div>
            <h1>{{ $inquiry->name }}</h1>
            <p class="subtitle">Received {{ $inquiry->created_at?->format('M j, Y g:i A') }}</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary">Back</a>
            @can('inquiries.manage')
                @if ($inquiry->isUnread())
                    <form method="POST" action="{{ route('admin.inquiries.mark-read', $inquiry) }}">
                        @csrf
                        <button type="submit" class="btn btn-teal">Mark as read</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.inquiries.mark-unread', $inquiry) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">Mark as unread</button>
                    </form>
                @endif
            @endcan
            @can('inquiries.delete')
                <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" onsubmit="return confirm('Delete this inquiry?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                </form>
            @endcan
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card card-admin mb-3">
                <div class="card-header">Message</div>
                <div class="card-body">
                    <div class="mb-0" style="white-space: pre-wrap;">{{ $inquiry->message }}</div>
                </div>
            </div>

            @can('inquiries.manage')
                <div class="card card-admin">
                    <div class="card-header">Internal notes</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="status">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="new" @selected(old('status', $inquiry->status) === 'new')>New</option>
                                    <option value="read" @selected(old('status', $inquiry->status) === 'read')>Read</option>
                                    <option value="archived" @selected(old('status', $inquiry->status) === 'archived')>Archived</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="notes">Notes</label>
                                <textarea name="notes" id="notes" rows="4" class="form-control">{{ old('notes', $inquiry->notes) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-teal">Save</button>
                        </form>
                    </div>
                </div>
            @endcan
        </div>

        <div class="col-lg-4">
            <div class="card card-admin">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <dl class="row mb-0 small">
                        <dt class="col-4 text-muted">Email</dt>
                        <dd class="col-8"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></dd>
                        <dt class="col-4 text-muted">Company</dt>
                        <dd class="col-8">{{ $inquiry->company ?: '—' }}</dd>
                        <dt class="col-4 text-muted">Phone</dt>
                        <dd class="col-8">{{ $inquiry->phone ?: '—' }}</dd>
                        <dt class="col-4 text-muted">Status</dt>
                        <dd class="col-8">{{ ucfirst($inquiry->status) }}</dd>
                        <dt class="col-4 text-muted">IP</dt>
                        <dd class="col-8">{{ $inquiry->ip_address ?: '—' }}</dd>
                        <dt class="col-4 text-muted">Read at</dt>
                        <dd class="col-8">{{ $inquiry->read_at?->format('M j, Y g:i A') ?: '—' }}</dd>
                        <dt class="col-4 text-muted">Agent</dt>
                        <dd class="col-8 text-break">{{ \Illuminate\Support\Str::limit($inquiry->user_agent, 80) ?: '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
