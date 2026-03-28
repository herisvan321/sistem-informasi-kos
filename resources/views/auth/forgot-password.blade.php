<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ get_setting('app_name', 'Kos') }}{{ get_setting('app_name_suffix', 'Admin') }} — Lupa Password</title>
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

        <div class="login-title">Lupa Password? 🔑</div>
        <div class="login-sub">Masukkan email Anda untuk menerima tautan pemulihan kata sandi.</div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if ($errors->any())
            <div class="login-error" style="display:block; margin-bottom: 24px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-wrap">
                    <input class="form-input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required autofocus autocomplete="email"/>
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width:100%; height:48px; font-size:16px;">Kirim Tautan Reset</button>
        </form>

        <div style="text-align:center; margin-top: 32px;">
            <p style="font-size:14px; color:var(--text-muted);">Kembali ke <a href="{{ route('login') }}" style="color:var(--primary); font-weight:600;">Halaman Login</a></p>
        </div>
    </div>
  </div>

  <!-- Right Side: Visual -->
  <div class="auth-right">
    <div class="auth-right-content">
        <h2>Keamanan Akun Anda Prioritas Kami.</h2>
        <p>Proses pemulihan sandi dirancang untuk memastikan hanya pemilik sah yang dapat mengakses data sensitif. Pastikan Anda menggunakan email yang terdaftar.</p>
        
        <div style="margin-top: 48px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 24px;">
            <div style="font-size: 14px; opacity: 0.8; line-height: 1.6;">
                "Kami berkomitmen memberikan perlindungan data maksimal melalui sistem verifikasi yang aman dan andal."
            </div>
        </div>
    </div>
  </div>
</div>
</body>

</html>
