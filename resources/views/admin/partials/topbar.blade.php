<header class="admin-topbar">
    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-sm btn-outline-secondary" data-sidebar-toggle aria-label="Toggle sidebar">
            <i class="bi bi-list"></i>
        </button>
        <div class="d-none d-md-block">
            <div class="fw-semibold">@yield('title', 'Dashboard')</div>
            <div class="text-muted small">{{ config('admin.name', 'LyoVial Admin') }}</div>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        @can('theme.manage')
            @php
                $isDark = auth()->user()?->isDarkMode();
                $nextTheme = $isDark ? 'light' : 'dark';
            @endphp
            <form action="{{ route('admin.theme.update') }}" method="POST" class="m-0" data-theme-form>
                @csrf
                <input type="hidden" name="theme" value="{{ $nextTheme }}">
                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Switch to {{ $nextTheme }} mode">
                    <i class="bi {{ $isDark ? 'bi-sun' : 'bi-moon-stars' }}"></i>
                </button>
            </form>
        @endcan

        <div class="dropdown">
            <button class="btn btn-sm btn-light border d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ auth()->user()->avatarUrl() }}" alt="" class="user-avatar">
                <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                <i class="bi bi-chevron-down small"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                @can('profile.manage')
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                            <i class="bi bi-person me-2"></i> Profile
                        </a>
                    </li>
                @endcan
                @can('settings.manage')
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.settings.edit') }}">
                            <i class="bi bi-gear me-2"></i> Settings
                        </a>
                    </li>
                @endcan
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST" class="px-3 py-1">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
