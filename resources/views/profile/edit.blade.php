@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Pengaturan Profil</h1>
        <p class="page-subtitle">Kelola identitas digital dan parameter keamanan akun administrator Anda.</p>
    </div>
</div>

<!-- Profile Hero Section -->
<div class="card" style="margin-bottom: 24px; background: linear-gradient(135deg, var(--bg-card) 0%, var(--bg) 100%);">
    <div class="card-body" style="display: flex; align-items: center; gap: 24px; padding: 30px;">
        <div class="user-av" style="width: 100px; height: 100px; font-size: 42px; font-weight: 800; background: var(--primary-glow); color: var(--primary); border: 4px solid var(--bg-card); box-shadow: 0 10px 25px rgba(var(--primary-rgb), 0.2);">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: var(--text); margin-bottom: 5px;">{{ auth()->user()->name }}</h2>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="font-family: 'JetBrains Mono'; color: var(--text-muted); font-size: 14px;">{{ auth()->user()->email }}</span>
                <span class="badge badge-blue" style="font-size: 10px; font-weight: 700;">SYSTEM ADMINISTRATOR</span>
                @if(auth()->user()->email_verified_at)
                    <span style="color: #10b981; display: flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 600;">
                        <svg style="width:14px; height:14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        Verified
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="two-col" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: start;">
    <!-- Column 1: Personal Information -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Informasi Personal
                </div>
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <!-- Column 2: Security & Account -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    Kredensial Keamanan
                </div>
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="card" style="border: 1.5px solid rgba(239, 68, 68, 0.2); background: rgba(239, 68, 68, 0.02);">
            <div class="card-header" style="border-bottom-color: rgba(239, 68, 68, 0.1);">
                <div class="card-title" style="color: #ef4444;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Zona Berbahaya
                </div>
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
