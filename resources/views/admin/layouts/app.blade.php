<!DOCTYPE html>
<html lang="en" data-bs-theme="{{ auth()->user()?->isDarkMode() ? 'dark' : 'light' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('admin.name', 'LyoVial Admin') }}</title>
    @include('front.partials.favicon')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ admin_asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="admin-body {{ auth()->user()?->isDarkMode() ? 'theme-dark' : 'theme-light' }}" data-theme-locked="1">
    <div class="admin-shell">
        @include('admin.partials.sidebar')
        <div class="sidebar-backdrop" data-sidebar-toggle></div>

        <div class="admin-main">
            @include('admin.partials.topbar')
            <main class="admin-content">
                @include('admin.partials.alerts')
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ admin_asset('js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>
