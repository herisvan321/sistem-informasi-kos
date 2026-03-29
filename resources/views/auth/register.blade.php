@extends('layouts.admin')

@section('styles')
<style>
    .auth-split { display: flex; min-height: calc(100vh - 64px); background: #fff; }
    .auth-left { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px; }
    .auth-right { flex: 1.2; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; padding: 80px; position: relative; overflow: hidden; }
    .auth-right::before { content: ""; position: absolute; inset: 0; background: url('https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&q=80&w=1600') center/cover; opacity: 0.15; mix-blend-mode: overlay; }
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
    
    .type-card {
        border: 2px solid #f3f4f6;
        border-radius: 20px;
        padding: 24px;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #f9fafb;
    }
    input[type="radio"]:checked + .type-card {
        border-color: var(--primary);
        background: rgba(var(--primary-rgb), 0.05);
        box-shadow: 0 20px 30px -10px rgba(var(--primary-rgb), 0.2);
        transform: translateY(-4px);
    }
    .type-card .icon { font-size: 32px; margin-bottom: 12px; display: block; filter: drop-shadow(0 10px 10px rgba(0,0,0,0.1)); }
    .type-card .label { font-weight: 900; font-size: 11px; letter-spacing: 0.1em; color: var(--text-muted); display: block; }
    input[type="radio"]:checked + .type-card .label { color: var(--primary); }
</style>
@endsection

@section('content')
<div class="auth-split">
  <div class="auth-left" style="padding: 60px 40px;">
    <div class="auth-form-container">
        <div class="login-logo">
            <div class="login-logo-icon">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8" fill="rgba(255,255,255,0.5)"/></svg>
            </div>
            <div class="login-logo-text">{{ get_setting('app_name', 'Kos') }}<span>{{ get_setting('app_name_suffix', 'Admin') }}</span></div>
        </div>

        <div class="login-title">Inisialisasi Keanggotaan 📝</div>
        <div class="login-sub">Akses eksklusif ke infrastruktur pengelolaan properti {{ get_setting('app_name', 'Kos') }}</div>

        @if ($errors->any())
            <div class="alert alert-rose" style="margin-bottom: 24px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group" style="margin-bottom: 32px;">
                <label class="form-label" style="font-weight: 800; font-size: 11px; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 16px;">IDENTIFIKASI PERAN STRATEGIS</label>
                <div style="display: flex; gap: 20px;">
                    <label style="flex: 1; cursor: pointer; margin-bottom: 0;">
                        <input type="radio" name="type_user" value="pencari-kos" checked style="display:none;" id="type_pencari">
                        <div class="type-card" onclick="document.getElementById('type_pencari').click()">
                            <span class="icon">🔍</span>
                            <span class="label">PENCARI KOS</span>
                        </div>
                    </label>
                    <label style="flex: 1; cursor: pointer; margin-bottom: 0;">
                        <input type="radio" name="type_user" value="pemilik-kos" style="display:none;" id="type_pemilik">
                        <div class="type-card" onclick="document.getElementById('type_pemilik').click()">
                            <span class="icon">🏠</span>
                            <span class="label">PEMILIK KOS</span>
                        </div>
                    </label>
                    <label style="flex: 1; cursor: pointer; margin-bottom: 0;">
                        <input type="radio" name="type_user" value="super-admin" style="display:none;" id="type_admin">
                        <div class="type-card" onclick="document.getElementById('type_admin').click()">
                            <span class="icon">👑</span>
                            <span class="label">SUPER ADMIN</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" for="name" style="font-weight: 800; font-size: 11px; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 12px;">NAMA LENGKAP</label>
                <div class="input-wrap">
                    <input class="form-input" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" style="height: 56px; border-radius: 16px; padding-left: 56px; background: #f9fafb;" required autofocus autocomplete="name"/>
                    <span class="input-icon" style="left: 20px; color: var(--primary);">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </span>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" for="email" style="font-weight: 800; font-size: 11px; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 12px;">MANIFES EMAIL</label>
                <div class="input-wrap">
                    <input class="form-input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" style="height: 56px; border-radius: 16px; padding-left: 56px; background: #f9fafb;" required autocomplete="email"/>
                    <span class="input-icon" style="left: 20px; color: var(--primary);">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px;">
                <div class="form-group">
                    <label class="form-label" for="password" style="font-weight: 800; font-size: 11px; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 12px;">KUNCI AKSES</label>
                    <div class="input-wrap">
                        <input class="form-input" id="password" type="password" name="password" placeholder="••••••••" style="height: 56px; border-radius: 16px; padding-left: 56px; background: #f9fafb;" required autocomplete="new-password"/>
                        <span class="input-icon" style="left: 20px; color: var(--primary);">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation" style="font-weight: 800; font-size: 11px; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 12px;">KONFIRMASI KUNCI</label>
                    <div class="input-wrap">
                        <input class="form-input" id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" style="height: 56px; border-radius: 16px; padding-left: 56px; background: #f9fafb;" required autocomplete="new-password"/>
                        <span class="input-icon" style="left: 20px; color: var(--primary);">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; height:60px; font-size:16px; font-weight: 900; letter-spacing: 0.05em; border-radius: 100px; box-shadow: 0 20px 30px -10px rgba(var(--primary-rgb), 0.4);">FINALISASI REGISTRASI</button>
        </form>

        <div style="text-align:center; margin-top: 40px;">
            <p style="font-size:14px; color:var(--text-muted); font-weight: 600;">Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--primary); font-weight:800; text-decoration: underline;">Login Disini</a></p>
        </div>
    </div>
  </div>

  <div class="auth-right">
    <div class="auth-right-content">
        <h2>Modernisasi Aset Properti Secara Digital.</h2>
        <p>Bergabunglah dengan ratusan pengelola properti profesional yang telah mentransformasi portofolio mereka melalui sistem terorganisir.</p>
        
        <div style="margin-top: 64px; display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
            <div class="feat-item">
                <div style="font-weight:800; font-size:32px; font-family:'Syne'; margin-bottom: 8px;">650+</div>
                <div style="font-size:12px; font-weight: 800; opacity:0.6; letter-spacing: 0.1em;">PARTNER TERVERIFIKASI</div>
            </div>
            <div class="feat-item">
                <div style="font-weight:800; font-size:32px; font-family:'Syne'; margin-bottom: 8px;">ISO 27001</div>
                <div style="font-size:12px; font-weight: 800; opacity:0.6; letter-spacing: 0.1em;">KEAMANAN DATA TERJAMIN</div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection