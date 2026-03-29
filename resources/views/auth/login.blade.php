@extends('layouts.admin')

@section('styles')
<style>
    .auth-split { display: flex; min-height: calc(100vh - 64px); background: #fff; }
    .auth-left { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px; }
    .auth-right { flex: 1.2; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; padding: 80px; position: relative; overflow: hidden; }
    .auth-right::before { content: ""; position: absolute; inset: 0; background: url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&q=80&w=1600') center/cover; opacity: 0.15; mix-blend-mode: overlay; }
    .auth-form-container { width: 100%; max-width: 440px; }
    .login-logo { display:flex; align-items:center; gap:16px; margin-bottom:48px; }
    .login-logo-icon { width:48px; height:48px; background:var(--primary); border-radius:14px; display:flex; align-items:center; justify-content:center; color:#fff; box-shadow: 0 10px 20px -5px rgba(var(--primary-rgb), 0.3); }
    .login-logo-text { font-family:'Syne'; font-weight:800; font-size:24px; color:var(--text); letter-spacing:-0.02em; }
    .login-logo-text span { color:var(--primary); }
    .login-title { font-family:'Syne'; font-weight:800; font-size:32px; color:var(--text); margin-bottom:12px; letter-spacing:-0.02em; }
    .login-sub { color:var(--text-muted); font-size:15px; margin-bottom:40px; line-height:1.6; }
    .auth-right-content { position: relative; z-index: 10; max-width: 540px; }
    .auth-right-content h2 { font-family: 'Syne'; font-weight: 800; font-size: 48px; line-height: 1.1; margin-bottom: 24px; letter-spacing: -0.03em; }
    .auth-right-content p { font-size: 18px; opacity: 0.8; line-height: 1.6; }
    .feat-item { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 24px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); }
    .main-content { padding: 0 !important; }
    .topnav { border-bottom: none; }
</style>
@endsection

@section('content')
<div class="auth-split">
  <div class="auth-left">
    <div class="auth-form-container">
        <div class="login-logo">
            <div class="login-logo-icon">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8" fill="rgba(255,255,255,0.5)"/></svg>
            </div>
            <div class="login-logo-text">{{ get_setting('app_name', 'Kos') }}<span>{{ get_setting('app_name_suffix', 'Admin') }}</span></div>
        </div>

        <div class="login-title">Autentikasi Akses 👋</div>
        <div class="login-sub">Masuk ke Control Panel Pengelolaan Properti {{ get_setting('app_name', 'Kos') }}</div>

        @if ($errors->any())
            <div class="alert alert-rose" style="margin-bottom: 24px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" for="email" style="font-weight: 800; font-size: 11px; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 12px;">MANIFES EMAIL</label>
                <div class="input-wrap">
                    <input class="form-input" id="email" type="email" name="email" value="{{ old('email', 'admin@kosapp.id') }}" placeholder="admin@kosapp.id" style="height: 56px; border-radius: 16px; padding-left: 56px; background: #f9fafb;" autocomplete="email" required autofocus/>
                    <span class="input-icon" style="left: 20px; color: var(--primary);">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 32px;">
                <div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <label class="form-label" for="password" style="font-weight: 800; font-size: 11px; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 0;">KUNCI AKSES</label>
                    <a href="{{ route('password.request') }}" style="font-size:12px; color:var(--primary); font-weight:800; text-decoration: underline;">LUPA KUNCI?</a>
                </div>
                <div class="input-wrap">
                    <input class="form-input" id="password" type="password" name="password" placeholder="••••••••" style="height: 56px; border-radius: 16px; padding-left: 56px; background: #f9fafb;" autocomplete="current-password" required/>
                    <span class="input-icon" style="left: 20px; color: var(--primary);">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; height:60px; font-size:16px; font-weight: 900; letter-spacing: 0.05em; border-radius: 100px; box-shadow: 0 20px 30px -10px rgba(var(--primary-rgb), 0.4);">VALIDASI AKSES SEKARANG</button>
        </form>

        <div style="text-align:center; margin-top: 40px;">
            <p style="font-size:14px; color:var(--text-muted); font-weight: 600;">Belum terdaftar dalam jaringan? <a href="{{ route('register') }}" style="color:var(--primary); font-weight:800; text-decoration: underline;">Registrasi Kemitraan</a></p>
        </div>
    </div>
  </div>

  <div class="auth-right">
    <div class="auth-right-content">
        <h2>Ekosistem Manajemen Properti Terpadu.</h2>
        <p>Optimasi operasional aset melalui infrastruktur digital yang presisi dan efisien dalam satu platform terpadu.</p>
        
        <div style="margin-top: 64px; display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
            <div class="feat-item">
                <div style="font-weight:800; font-size:32px; font-family:'Syne'; margin-bottom: 8px;">1.2k+</div>
                <div style="font-size:12px; font-weight: 800; opacity:0.6; letter-spacing: 0.1em;">ASET TERVERIFIKASI</div>
            </div>
            <div class="feat-item">
                <div style="font-weight:800; font-size:32px; font-family:'Syne'; margin-bottom: 8px;">99.9%</div>
                <div style="font-size:12px; font-weight: 800; opacity:0.6; letter-spacing: 0.1em;">RELIABILITAS SISTEM</div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection