<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ get_setting('site_name', config('app.name', 'KosAdmin')) }} — Panel Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="icon" href="{{ get_setting('site_favicon', asset('favicon.ico')) }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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
            <div class="topnav-brand" style="gap: 12px;">
                <div class="brand-icon">
                    @if(get_setting('site_logo'))
                        <img src="{{ get_setting('site_logo') }}" alt="Logo" style="height: 32px; width: auto; object-fit: contain;">
                    @else
                        <svg viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8" fill="rgba(255,255,255,0.5)"/></svg>
                    @endif
                </div>
                <div class="brand-name">{{ get_setting('app_name', 'Kos') }}<span>{{ get_setting('app_name_suffix', 'Admin') }}</span></div>
                
                @if(get_setting('maintenance_mode'))
                    <span class="badge badge-amber" style="font-size: 10px; padding: 2px 8px; margin-left: 8px;">
                        <span class="badge-dot"></span> MAINTENANCE
                    </span>
                @endif
            </div>            <!-- Menu items (desktop) -->
            <div class="topnav-menu" id="topnav-menu">
                @auth
                    @if(auth()->user()->hasRole('super-admin'))
                        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                            Pusat Kendali
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Direktori Afiliasi
                        </a>
                        <a href="{{ route('admin.listings.index') }}" class="nav-item {{ request()->routeIs('admin.listings.index') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8"/></svg>
                            Validasi Properti
                        </a>
                        <a href="{{ route('admin.listings.premium-requests') }}" class="nav-item {{ request()->routeIs('admin.listings.premium-requests') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
                            Request Premium
                        </a>
                        <a href="{{ route('admin.analytics') }}" class="nav-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            Kinerja Global
                        </a>
                        <a href="{{ route('admin.settings') }}" class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                            Konfigurasi Situs
                        </a>
                    @elseif(auth()->user()->hasRole('pemilik-kos'))
                        <a href="{{ route('pemilik-kos.dashboard') }}" class="nav-item {{ request()->routeIs('pemilik-kos.dashboard') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                            Dashboard Pusat
                        </a>
                        <a href="{{ route('pemilik-kos.listings.index') }}" class="nav-item {{ request()->routeIs('pemilik-kos.listings.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8"/></svg>
                            Portofolio Properti
                        </a>
                        <a href="{{ route('pemilik-kos.inquiries.index') }}" class="nav-item {{ request()->routeIs('pemilik-kos.inquiries.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                            Pusat Komunikasi
                        </a>
                        <a href="{{ route('pemilik-kos.transactions.index') }}" class="nav-item {{ request()->routeIs('pemilik-kos.transactions.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                            Analisis Finansial
                        </a>
                        <a href="{{ route('pemilik-kos.tenants.index') }}" class="nav-item {{ request()->routeIs('pemilik-kos.tenants.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                            Portofolio Penghuni
                        </a>
                    @elseif(auth()->user()->hasRole('pencari-kos'))
                        <a href="{{ route('pencari-kos.dashboard') }}" class="nav-item {{ request()->routeIs('pencari-kos.dashboard') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('pencari-kos.discovery.index') }}" class="nav-item {{ request()->routeIs('pencari-kos.discovery.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            Eksplorasi Kos
                        </a>
                        <a href="{{ route('pencari-kos.favorites.index') }}" class="nav-item {{ request()->routeIs('pencari-kos.favorites.index') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                            Wishlist Saya
                        </a>
                        <a href="{{ route('pencari-kos.history.index') }}" class="nav-item {{ request()->routeIs('pencari-kos.history.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Riwayat Booking
                        </a>
                        <a href="{{ route('pencari-kos.inquiries.index') }}" class="nav-item {{ request()->routeIs('pencari-kos.inquiries.*') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                            Pusat Komunikasi
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Right side -->
            <div class="topnav-right">
                @include('components.notification-dropdown')

                @auth
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
                                Pengaturan Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item danger" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                    Keluar Aplikasi
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div style="display: flex; gap: 12px;">
                        <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="border-radius: 100px; font-weight: 700;">LOGIN</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm" style="border-radius: 100px; font-weight: 700;">DAFTAR</a>
                    </div>
                @endauth
            </div>
        </nav>

        @auth
        <!-- MOBILE DRAWER -->
        <div class="mobile-drawer" id="mobile-drawer">
            <div class="drawer-overlay" onclick="closeDrawer()"></div>
            <div class="drawer-panel">
                <div class="drawer-brand">
                    <div class="brand-icon" style="width:34px;height:34px;border-radius:9px; display:flex; align-items:center; justify-content:center; background:var(--primary); overflow:hidden;">
                        @if(get_setting('site_logo'))
                            <img src="{{ get_setting('site_logo') }}" alt="Logo" style="width:100%; height:100%; object-fit:contain;">
                        @else
                            <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:#fff;"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/></svg>
                        @endif
                    </div>
                    <span class="brand-name" style="font-size:16px;">{{ get_setting('app_name', 'Kos') }}<span>{{ get_setting('app_name_suffix', 'Admin') }}</span></span>
                    <button class="drawer-close" onclick="closeDrawer()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
                @if(auth()->user()->hasRole('super-admin'))
                    <a href="{{ route('admin.dashboard') }}" class="drawer-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                        Pusat Kendali
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="drawer-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 00-4-4h4a4 4 0 014 4v2"/></svg>
                        Direktori Afiliasi
                    </a>
                    <a href="{{ route('admin.listings.index') }}" class="drawer-nav-item {{ request()->routeIs('admin.listings.index') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8"/></svg>
                        Validasi Properti
                    </a>
                    <a href="{{ route('admin.listings.premium-requests') }}" class="drawer-nav-item {{ request()->routeIs('admin.listings.premium-requests') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
                        Request Premium
                    </a>
                    <a href="{{ route('admin.analytics') }}" class="drawer-nav-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        Kinerja Global
                    </a>
                    <a href="{{ route('admin.settings') }}" class="drawer-nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                        Konfigurasi Situs
                    </a>
                @elseif(auth()->user()->hasRole('pemilik-kos'))
                    <a href="{{ route('pemilik-kos.dashboard') }}" class="drawer-nav-item {{ request()->routeIs('pemilik-kos.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                        Dashboard Pusat
                    </a>
                    <a href="{{ route('pemilik-kos.listings.index') }}" class="drawer-nav-item {{ request()->routeIs('pemilik-kos.listings.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8"/></svg>
                        Portofolio Properti
                    </a>
                    <a href="{{ route('pemilik-kos.inquiries.index') }}" class="drawer-nav-item {{ request()->routeIs('pemilik-kos.inquiries.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        Pusat Komunikasi
                    </a>
                    <a href="{{ route('pemilik-kos.transactions.index') }}" class="drawer-nav-item {{ request()->routeIs('pemilik-kos.transactions.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                        Analisis Finansial
                    </a>
                    <a href="{{ route('pemilik-kos.tenants.index') }}" class="drawer-nav-item {{ request()->routeIs('pemilik-kos.tenants.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                        Portofolio Penghuni
                    </a>
                @elseif(auth()->user()->hasRole('pencari-kos'))
                    <a href="{{ route('pencari-kos.dashboard') }}" class="drawer-nav-item {{ request()->routeIs('pencari-kos.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('pencari-kos.discovery.index') }}" class="drawer-nav-item {{ request()->routeIs('pencari-kos.discovery.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Eksplorasi Kos
                    </a>
                    <a href="{{ route('pencari-kos.favorites.index') }}" class="drawer-nav-item {{ request()->routeIs('pencari-kos.favorites.index') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                        Wishlist Saya
                    </a>
                    <a href="{{ route('pencari-kos.history.index') }}" class="drawer-nav-item {{ request()->routeIs('pencari-kos.history.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Riwayat Booking
                    </a>
                    <a href="{{ route('pencari-kos.inquiries.index') }}" class="drawer-nav-item {{ request()->routeIs('pencari-kos.inquiries.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        Pusat Komunikasi
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}" style="margin-top:auto;">
                    @csrf
                    <button type="submit" class="drawer-nav-item" style="width:100%; border:none; background:none; cursor:pointer; color:var(--danger);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Keluar Aplikasi
                    </button>
                </form>
            </div>
        </div>
        @endauth


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
    <script>
        function toggleNotifDropdown() {
            document.getElementById('notif-dropdown').classList.toggle('open');
            document.getElementById('admin-dropdown').classList.remove('open');
        }
        
        // Update toggleDropdown to close notif-dropdown
        const originalToggleDropdown = window.toggleDropdown;
        window.toggleDropdown = function() {
            document.getElementById('admin-dropdown').classList.toggle('open');
            document.getElementById('notif-dropdown').classList.remove('open');
        }

        window.onclick = function(event) {
            if (!event.target.closest('.admin-avatar') && !event.target.closest('#admin-dropdown')) {
                document.getElementById('admin-dropdown').classList.remove('open');
            }
            if (!event.target.closest('#notif-btn') && !event.target.closest('#notif-dropdown')) {
                document.getElementById('notif-dropdown').classList.remove('open');
            }
        }
    </script>
    @yield('scripts')
</body>
</html>