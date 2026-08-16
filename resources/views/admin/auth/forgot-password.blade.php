@extends('admin.layouts.guest')

@section('title', 'Forgot password')

@section('content')
    <h1 class="h4 fw-bold mb-1">Forgot password</h1>
    <p class="text-muted mb-4">Enter your email and we’ll send a reset link.</p>

    <form method="POST" action="{{ route('admin.password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                   class="form-control @error('email') is-invalid @enderror">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-teal w-100 py-2 mb-3">
            <i class="bi bi-envelope me-1"></i> Send reset link
        </button>

        <div class="text-center">
            <a href="{{ route('admin.login') }}" class="small">&larr; Back to sign in</a>
        </div>
    </form>
@endsection
