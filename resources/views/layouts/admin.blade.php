<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'KosAdmin') }} — Panel Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet"/>
    
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    @yield('styles')
</head>
<body>
    <div id="app">
        <!-- TOP NAVIGATION -->
        <nav class="topnav">
            <!-- Hamburger (mobile) -->
            <button class="hamburger" onclick="openDrawer()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>

            <!-- Brand -->
            <div class="topnav-brand">
                <div class="brand-icon">
                    <svg viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8" fill="rgba(255,255,255,0.5)"/></svg>
                </div>
                <div class="brand-name">Kos<span>Admin</span></div>
            </div>

            <!-- Menu items (desktop) -->
            <div class="topnav-menu" id="topnav-menu">
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/></svg>
                    Kelola User <span class="nav-badge">12</span>
                </a>
                <a href="{{ route('admin.listings.index') }}" class="nav-item {{ request()->routeIs('admin.listings.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8"/></svg>
                    Kelola Listing <span class="nav-badge">5</span>
                </a>
                <a href="{{ route('admin.analytics') }}" class="nav-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Analitik
                </a>
                <a href="{{ route('admin.roles-permissions') }}" class="nav-item {{ request()->routeIs('admin.roles-permissions') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Sync Akses
                </a>
                <a href="{{ route('admin.roles.index') }}" class="nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    Kelola Role
                </a>
                <a href="{{ route('admin.permissions.index') }}" class="nav-item {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    Permission
                </a>
                <a href="{{ route('admin.settings') }}" class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                    Pengaturan
                </a>
            </div>

            <!-- Right side -->
            <div class="topnav-right">
                <button class="notif-btn" onclick="showToast('info','Tidak ada notifikasi baru')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span class="notif-dot"></span>
                </button>
                <!-- Admin avatar + dropdown -->
                <div style="position:relative;">
                    <div class="admin-avatar" onclick="toggleDropdown()" id="admin-av">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="admin-dropdown" id="admin-dropdown">
                        <div class="dropdown-header">
                            <strong>{{ auth()->user()->name }}</strong>
                            <span>{{ auth()->user()->email }}</span>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20v-1a8 8 0 0116 0v1"/></svg>
                            Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item danger" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- MOBILE DRAWER -->
        <div class="mobile-drawer" id="mobile-drawer">
            <div class="drawer-overlay" onclick="closeDrawer()"></div>
            <div class="drawer-panel">
                <div class="drawer-brand">
                    <div class="brand-icon" style="width:34px;height:34px;border-radius:9px;">
                        <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:#fff;"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/></svg>
                    </div>
                    <span class="brand-name" style="font-size:16px;">Kos<span>Admin</span></span>
                    <button class="drawer-close" onclick="closeDrawer()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="drawer-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="drawer-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/></svg>
                    Kelola User
                </a>
                <a href="{{ route('admin.listings.index') }}" class="drawer-nav-item {{ request()->routeIs('admin.listings.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8"/></svg>
                    Kelola Listing
                </a>
                <a href="{{ route('admin.analytics') }}" class="drawer-nav-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Laporan
                </a>
                <a href="{{ route('admin.roles-permissions') }}" class="drawer-nav-item {{ request()->routeIs('admin.roles-permissions') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Sync Akses
                </a>
                <a href="{{ route('admin.roles.index') }}" class="drawer-nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    Kelola Role
                </a>
                <a href="{{ route('admin.permissions.index') }}" class="drawer-nav-item {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    Permission
                </a>
                <a href="{{ route('admin.settings') }}" class="drawer-nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                    Pengaturan
                </a>

                <form method="POST" action="{{ route('logout') }}" style="margin-top:auto;">
                    @csrf
                    <button type="submit" class="drawer-nav-item" style="width:100%; border:none; background:none; cursor:pointer; color:var(--danger);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>


        <!-- MAIN CONTENT AREA -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Toast container -->
    <div class="toast-container" id="toast-container"></div>
    @if(session('success'))
        <script>window.onload = () => showToast('success', "{{ session('success') }}");</script>
    @endif
    @if(session('error'))
        <script>window.onload = () => showToast('error', "{{ session('error') }}");</script>
    @endif

    <script src="{{ asset('js/admin.js') }}"></script>
    @yield('scripts')
</body>
</html>