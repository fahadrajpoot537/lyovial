@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <div>
            <h1>Dashboard</h1>
            <p class="subtitle">Overview of LyoVial content and inquiries</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-file-earmark-text"></i></div>
                <div class="stat-label">Pages</div>
                <div class="stat-value">{{ $stats['pages'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-briefcase"></i></div>
                <div class="stat-label">Services</div>
                <div class="stat-value">{{ $stats['services'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-buildings"></i></div>
                <div class="stat-label">Industries</div>
                <div class="stat-value">{{ $stats['industries'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-inbox"></i></div>
                <div class="stat-label">Inquiries</div>
                <div class="stat-value">{{ $stats['inquiries'] ?? 0 }}</div>
                @if (($stats['unread_inquiries'] ?? 0) > 0)
                    <div class="small mt-1"><span class="badge badge-soft-warning">{{ $stats['unread_inquiries'] }} unread</span></div>
                @endif
            </div>
        </div>
    </div>

    <div class="card card-admin">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Recent inquiries</span>
            @can('inquiries.view')
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-secondary">View all</a>
            @endcan
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Received</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentInquiries ?? [] as $inquiry)
                            <tr>
                                <td class="fw-semibold">{{ $inquiry->name }}</td>
                                <td>{{ $inquiry->email }}</td>
                                <td>
                                    @if ($inquiry->status === 'new')
                                        <span class="badge badge-soft-warning">New</span>
                                    @elseif ($inquiry->status === 'read')
                                        <span class="badge badge-soft">Read</span>
                                    @else
                                        <span class="badge badge-soft-secondary">{{ ucfirst($inquiry->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $inquiry->created_at?->diffForHumans() }}</td>
                                <td class="text-end">
                                    @can('inquiries.view')
                                        <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-sm btn-outline-secondary">Open</a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <i class="bi bi-inbox d-block mb-2"></i>
                                    No inquiries yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
