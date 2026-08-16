@extends('admin.layouts.app')

@section('title', 'SEO Redirects')

@section('content')
    <div class="page-header">
        <div>
            <h1>SEO Redirects</h1>
            <p class="subtitle">301 / 302 redirects for technical SEO</p>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card card-admin">
                <div class="card-header">Add redirect</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.seo-redirects.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="from_path">From path</label>
                            <input type="text" name="from_path" id="from_path" class="form-control @error('from_path') is-invalid @enderror" value="{{ old('from_path') }}" placeholder="/old-page" required>
                            @error('from_path')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="to_url">To URL</label>
                            <input type="text" name="to_url" id="to_url" class="form-control @error('to_url') is-invalid @enderror" value="{{ old('to_url') }}" placeholder="/new-page or https://..." required>
                            @error('to_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status_code">Status</label>
                            <select name="status_code" id="status_code" class="form-select">
                                @foreach ([301, 302, 307, 308] as $code)
                                    <option value="{{ $code }}" @selected((int) old('status_code', 301) === $code)>{{ $code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="notes">Notes</label>
                            <textarea name="notes" id="notes" rows="2" class="form-control">{{ old('notes') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-teal w-100">Save redirect</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card card-admin">
                <div class="card-header">Redirects</div>
                <div class="table-responsive">
                    <table class="table table-admin mb-0">
                        <thead>
                            <tr>
                                <th>From</th>
                                <th>To</th>
                                <th>Code</th>
                                <th>Active</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($redirects as $redirect)
                                <tr>
                                    <td><code>{{ $redirect->from_path }}</code></td>
                                    <td class="small">{{ $redirect->to_url }}</td>
                                    <td>{{ $redirect->status_code }}</td>
                                    <td>{{ $redirect->is_active ? 'Yes' : 'No' }}</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('admin.seo-redirects.destroy', $redirect) }}" onsubmit="return confirm('Delete this redirect?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-muted text-center py-4">No redirects yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($redirects->hasPages())
                    <div class="card-body">{{ $redirects->links() }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection
