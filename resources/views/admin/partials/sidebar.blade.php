<aside class="admin-sidebar" id="adminSidebar">
    <div class="brand">
        <span class="brand-mark"><i class="bi bi-droplet-half"></i></span>
        <span class="brand-text">LyoVial</span>
    </div>

    <nav class="nav-scroll">
        <div class="nav-label">Main</div>

        @can('dashboard.view')
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i><span>Dashboard</span>
            </a>
        @endcan

        @can('home.manage')
            <a href="{{ route('admin.home.index') }}" class="nav-link {{ request()->routeIs('admin.home.*') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i><span>Home CMS</span>
            </a>
        @endcan

        @can('pages.view')
            <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i><span>Pages</span>
            </a>
        @endcan

        @can('services.view')
            <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="bi bi-briefcase"></i><span>Services</span>
            </a>
        @endcan

        @can('industries.view')
            <a href="{{ route('admin.industries.index') }}" class="nav-link {{ request()->routeIs('admin.industries.*') ? 'active' : '' }}">
                <i class="bi bi-buildings"></i><span>Industries</span>
            </a>
        @endcan

        @can('faqs.manage')
            <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                <i class="bi bi-question-circle"></i><span>FAQs</span>
            </a>
        @endcan

        @can('testimonials.manage')
            <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <i class="bi bi-chat-quote"></i><span>Testimonials</span>
            </a>
        @endcan

        @can('articles.manage')
            <a href="{{ route('admin.articles.index') }}" class="nav-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i><span>Articles</span>
            </a>
        @endcan

        @can('why_choose.manage')
            <a href="{{ route('admin.why-choose.index') }}" class="nav-link {{ request()->routeIs('admin.why-choose.*') ? 'active' : '' }}">
                <i class="bi bi-stars"></i><span>Why Choose Us</span>
            </a>
        @endcan

        <div class="nav-label">Engage</div>

        @can('contact.manage')
            <a href="{{ route('admin.contact.edit') }}" class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                <i class="bi bi-telephone"></i><span>Contact Page</span>
            </a>
        @endcan

        @can('inquiries.view')
            <a href="{{ route('admin.inquiries.index') }}" class="nav-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
                <i class="bi bi-inbox"></i><span>Inquiries</span>
            </a>
            <a href="{{ route('admin.newsletter.index') }}" class="nav-link {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}">
                <i class="bi bi-envelope-plus"></i><span>Newsletter</span>
            </a>
        @endcan

        @can('menus.manage')
            <a href="{{ route('admin.menus.index') }}" class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
                <i class="bi bi-list-nested"></i><span>Menus</span>
            </a>
        @endcan

        <div class="nav-label">Library</div>

        @can('media.manage')
            <a href="{{ route('admin.media.index') }}" class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i><span>Media</span>
            </a>
        @endcan

        @can('files.manage')
            <a href="{{ route('admin.files.index') }}" class="nav-link {{ request()->routeIs('admin.files.*') ? 'active' : '' }}">
                <i class="bi bi-folder2-open"></i><span>Files</span>
            </a>
        @endcan

        <div class="nav-label">Account</div>

        @can('settings.manage')
            <a href="{{ route('admin.settings.edit') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i><span>Settings</span>
            </a>
            <a href="{{ route('admin.seo-redirects.index') }}" class="nav-link {{ request()->routeIs('admin.seo-redirects.*') ? 'active' : '' }}">
                <i class="bi bi-sign-turn-right"></i><span>SEO Redirects</span>
            </a>
        @endcan

        @can('profile.manage')
            <a href="{{ route('admin.profile.edit') }}" class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i><span>Profile</span>
            </a>
        @endcan
    </nav>
</aside>
