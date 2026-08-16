<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sign in') — {{ config('admin.name', 'LyoVial Admin') }}</title>
    @include('front.partials.favicon')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ admin_asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="admin-body theme-light">
    <div class="auth-wrap">
        <div class="auth-card">
            <div class="auth-brand">
                <span class="mark"><i class="bi bi-droplet-half"></i></span>
                <div>
                    <div class="fw-bold fs-5">LyoVial</div>
                    <div class="text-muted small">Admin CMS</div>
                </div>
            </div>
            @include('admin.partials.alerts')
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
