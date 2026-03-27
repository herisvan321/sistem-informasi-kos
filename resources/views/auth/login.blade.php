<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>KosAdmin — Login</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div id="login-page">
  <div class="login-card">
    <div class="login-logo">
      <div class="login-logo-icon">
        <svg viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8" fill="rgba(255,255,255,0.5)"/></svg>
      </div>
      <div class="login-logo-text">Kos<span>Admin</span></div>
    </div>

    <div class="login-title">Selamat Datang 👋</div>
    <div class="login-sub">Masuk ke panel administrasi aplikasi kos Anda</div>

    @if ($errors->any())
        <div class="login-error" style="display:block;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <div class="input-wrap">
                <input class="form-input" id="email" type="email" name="email" value="{{ old('email', 'admin@kosapp.id') }}" placeholder="admin@kosapp.id" autocomplete="email" required autofocus/>
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </span>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrap">
                <input class="form-input" id="password" type="password" name="password" placeholder="••••••••" autocomplete="current-password" required/>
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                </span>
            </div>
        </div>

        <button type="submit" class="btn-primary" id="login-btn">Masuk sebagai Admin</button>
    </form>

    <div style="text-align:center; margin-top: 24px;">
        <p style="font-size:13px; color:var(--text-muted);">Belum punya akun? <a href="{{ route('register') }}" style="color:var(--primary); font-weight:600;">Daftar Sekarang</a></p>
    </div>

    <p style="text-align:center;font-size:12px;color:var(--text-muted);margin-top:24px; padding-top:16px; border-top: 1px solid var(--border);">
      Demo: <strong>admin@kosapp.id</strong> / <strong>admin123</strong>
    </p>
  </div>
</div>
</body>
</html>