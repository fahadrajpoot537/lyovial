@extends('admin.layouts.guest')

@section('title', 'Sign in')

@section('content')
    <h1 class="h4 fw-bold mb-1">Welcome back</h1>
    <p class="text-muted mb-4">Sign in to manage LyoVial content.</p>

    <form method="POST" action="{{ route('admin.login.submit') }}" novalidate>
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                   class="form-control @error('email') is-invalid @enderror" autocomplete="username">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <label for="password" class="form-label">Password</label>
                @if (Route::has('admin.password.request'))
                    <a href="{{ route('admin.password.request') }}" class="small">Forgot password?</a>
                @endif
            </div>
            <input type="password" name="password" id="password" required
                   class="form-control @error('password') is-invalid @enderror" autocomplete="current-password">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" @checked(old('remember'))>
            <label class="form-check-label" for="remember">Remember me</label>
        </div>

        @if (!empty($recaptchaSiteKey))
            <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                @error('g-recaptcha-response')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        @endif

        <button type="submit" class="btn btn-teal w-100 py-2">
            <i class="bi bi-box-arrow-in-right me-1"></i> Sign in
        </button>
    </form>

    @if (app()->environment('local'))
        <p class="text-muted small mt-3 mb-0">
            Default login: <code>admin@lyovial.com</code> / <code>Admin@12345</code>
        </p>
    @endif
@endsection

@push('scripts')
    @if (!empty($recaptchaSiteKey))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
@endpush
