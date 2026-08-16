@extends('admin.layouts.app')

@section('title', 'Home CMS')

@section('content')
    <div class="page-header">
        <div>
            <h1>Home CMS</h1>
            <p class="subtitle">Edit homepage section content</p>
        </div>
    </div>

    <div class="card card-admin">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Section</th>
                            <th>Key</th>
                            <th>Heading</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $keys = \App\Models\HomeSection::sectionKeys();
                            $byKey = collect($sections ?? [])->keyBy('section_key');
                        @endphp
                        @foreach ($keys as $key => $label)
                            @php $section = $byKey->get($key); @endphp
                            <tr>
                                <td class="fw-semibold">{{ $label }}</td>
                                <td><code class="small">{{ $key }}</code></td>
                                <td class="text-muted">{{ $section?->heading ?: '—' }}</td>
                                <td>
                                    @if ($section?->is_active ?? true)
                                        <span class="badge badge-soft">Active</span>
                                    @else
                                        <span class="badge badge-soft-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.home.edit', $key) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
