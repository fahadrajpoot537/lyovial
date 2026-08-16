@extends('admin.layouts.guest')

@section('title', 'Reset password')

@section('content')
    <h1 class="h4 fw-bold mb-1">Reset password</h1>
    <p class="text-muted mb-4">Choose a new password for your account.</p>

    <form method="POST" action="{{ route('admin.password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $email ?? '') }}" required autofocus
                   class="form-control @error('email') is-invalid @enderror">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New password</label>
            <input type="password" name="password" id="password" required
                   class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   class="form-control" autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-teal w-100 py-2">
            <i class="bi bi-shield-lock me-1"></i> Reset password
        </button>
    </form>
@endsection
