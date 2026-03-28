<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ get_setting('app_name', 'Kos') }}{{ get_setting('app_name_suffix', 'Admin') }} — Atur Ulang Password</title>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Syne:wght@700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
<div class="auth-split">
  <!-- Left Side: Form -->
  <div class="auth-left">
    <div class="auth-form-container">
        <div class="login-logo" style="margin-bottom: 32px; justify-content: flex-start;">
            <div class="login-logo-icon">
                <svg viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8" fill="rgba(255,255,255,0.5)"/></svg>
            </div>
            <div class="login-logo-text">{{ get_setting('app_name', 'Kos') }}<span>{{ get_setting('app_name_suffix', 'Admin') }}</span></div>
        </div>

        <div class="login-title">Atur Ulang Password 🔐</div>
        <div class="login-sub">Silakan masukkan kata sandi baru Anda untuk mengamankan akun.</div>

        @if ($errors->any())
            <div class="login-error" style="display:block; margin-bottom: 24px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-wrap">
                    <input class="form-input" id="email" type="email" name="email" value="{{ old('email', $request->email) }}" placeholder="john@example.com" required autofocus autocomplete="email"/>
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password Baru</label>
                <div class="input-wrap">
                    <input class="form-input" id="password" type="password" name="password" placeholder="••••••••" required autocomplete="new-password"/>
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                <div class="input-wrap">
                    <input class="form-input" id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password"/>
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width:100%; height:48px; font-size:16px;">Atur Ulang Sekarang</button>
        </form>
    </div>
  </div>

  <!-- Right Side: Visual -->
  <div class="auth-right">
    <div class="auth-right-content">
        <h2>Keamanan Maksimal, Akses Terjamin.</h2>
        <p>Memperbarui kata sandi secara berkala adalah langkah cerdas untuk melindungi data dan listing properti Anda di platform kami.</p>
        
        <div style="margin-top: 48px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 24px;">
            <div style="font-size: 14px; opacity: 0.8; line-height: 1.6;">
                "Gunakan kombinasi huruf, angka, dan simbol untuk kekuatan sandi yang optimal demi keamanan bersama."
            </div>
        </div>
    </div>
  </div>
</div>
</body>

</html>
