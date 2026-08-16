@extends('admin.layouts.app')

@section('title', 'FAQs')

@section('content')
    <div class="page-header">
        <div>
            <h1>FAQs</h1>
            <p class="subtitle">Manage frequently asked questions</p>
        </div>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-teal"><i class="bi bi-plus-lg me-1"></i> Add FAQ</a>
    </div>

    <div class="card card-admin">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Section</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($faqs ?? $items ?? [] as $faq)
                            <tr>
                                <td class="fw-semibold">{{ \Illuminate\Support\Str::limit($faq->question, 70) }}</td>
                                <td><span class="badge badge-soft-secondary">{{ $faq->section ?: 'general' }}</span></td>
                                <td>
                                    @if ($faq->status)
                                        <span class="badge badge-soft">Active</span>
                                    @else
                                        <span class="badge badge-soft-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $faq->sort_order }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" class="d-inline" onsubmit="return confirm('Delete this FAQ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <i class="bi bi-question-circle d-block mb-2"></i>
                                    No FAQs yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.partials.pagination', ['items' => $faqs ?? $items ?? null])
@endsection
