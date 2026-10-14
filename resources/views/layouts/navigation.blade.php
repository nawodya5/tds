
<aside class="app-sidebar" id="appSidebar">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <x-application-logo class="sidebar-logo-image" />
            <span>TDS Attendance</span>
        </a>

        <button
            type="button"
            class="sidebar-close"
            id="sidebarClose"
            aria-label="Close sidebar"
        >
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="sidebar-menu">
        <div class="sidebar-section-label">MENU</div>

        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" >
            <i class="bi bi-grid-1x2"></i>
            <span>Dashboard</span>
        </a>

        
        <a href="{{ url('/calendar') }}" class="sidebar-link {{ request()->is('calendar*') ? 'active' : '' }}" >
            <i class="bi bi-calendar3"></i>
            <span>Calendar</span>
        </a>

        <a href="{{ url('/attendance') }}" class="sidebar-link {{ request()->is('attendance*') ? 'active' : '' }}" >
            <i class="bi bi-clipboard-check"></i>
            <span>Attendance</span>
        </a>

        <a href="{{ url('/classes') }}" class="sidebar-link {{ request()->is('classes*') ? 'active' : '' }}" >
            <i class="bi bi-collection"></i>
            <span>Classes</span>
        </a>

        <a href="{{ url('/students') }}" class="sidebar-link {{ request()->is('students*') ? 'active' : '' }}" >
            <i class="bi bi-people"></i>
            <span>Students</span>
        </a>

        <div class="sidebar-section-label mt-4">PREFERENCES</div>

        <a href="{{ url('/settings') }}" class="sidebar-link {{ request()->is('settings*') ? 'active' : '' }}" >
            <i class="bi bi-gear"></i>
            <span>Settings</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>

            <div class="sidebar-user-info">
                <div class="sidebar-user-name">
                    {{ Auth::user()->name }}
                </div>
                <div class="sidebar-user-email">
                    {{ Auth::user()->email }}
                </div>
            </div>
        </div>

        <a href="{{ route('profile.edit') }}" class="sidebar-footer-link">
            <i class="bi bi-person-circle"></i>
            Profile
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-footer-link w-100 text-start">
                <i class="bi bi-box-arrow-right"></i>
                Log out
            </button>
        </form>
    </div>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<button
    type="button"
    class="mobile-sidebar-toggle"
    id="sidebarToggle"
    aria-label="Open navigation"
>
    <i class="bi bi-list"></i>
</button>