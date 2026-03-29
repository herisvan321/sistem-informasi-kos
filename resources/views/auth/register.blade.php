<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ get_setting('app_name', 'Kos') }}{{ get_setting('app_name_suffix', 'Admin') }} — Daftar</title>
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

        <div class="login-title">Inisialisasi Keanggotaan Strategis 📝</div>
        <div class="login-sub">Akses eksklusif ke infrastruktur pengelolaan properti {{ get_setting('app_name', 'Kos') }}</div>

        @if ($errors->any())
            <div class="login-error" style="display:block; margin-bottom: 24px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Nama Lengkap</label>
                <div class="input-wrap">
                    <input class="form-input" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus autocomplete="name"/>
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-wrap">
                    <input class="form-input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required autocomplete="email"/>
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">IDENTIFIKASI PERAN</label>
                <div style="display: flex; gap: 16px; margin-top: 8px;">
                    <label style="flex: 1; cursor: pointer;">
                        <input type="radio" name="type_user" value="pencari-kos" checked style="display:none;" id="type_pencari">
                        <div class="type-card" onclick="document.getElementById('type_pencari').click()">
                            <span style="font-size:24px; display:block; margin-bottom:4px;">🔍</span>
                            <span style="font-weight:600; font-size:14px;">MITRA PENGGUNA</span>
                        </div>
                    </label>
                    <label style="flex: 1; cursor: pointer;">
                        <input type="radio" name="type_user" value="pemilik-kos" style="display:none;" id="type_pemilik">
                        <div class="type-card" onclick="document.getElementById('type_pemilik').click()">
                            <span style="font-size:24px; display:block; margin-bottom:4px;">🏠</span>
                            <span style="font-weight:600; font-size:14px;">MITRA PENGELOLA</span>
                        </div>
                    </label>
                </div>
            </div>

            <style>
                .type-card {
                    border: 2px solid var(--border);
                    border-radius: 12px;
                    padding: 16px;
                    text-align: center;
                    transition: all 0.2s;
                }
                input[type="radio"]:checked + .type-card {
                    border-color: var(--primary);
                    background: rgba(var(--primary-rgb), 0.05);
                    box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.1);
                }
            </style>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <input class="form-input" id="password" type="password" name="password" placeholder="••••••••" required autocomplete="new-password"/>
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <div class="input-wrap">
                    <input class="form-input" id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password"/>
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width:100%; height:48px; font-size:16px;">FINALISASI REGISTRASI</button>
        </form>

        <div style="text-align:center; margin-top: 32px;">
            <p style="font-size:14px; color:var(--text-muted);">Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--primary); font-weight:600;">Login Disini</a></p>
        </div>
    </div>
  </div>

  <!-- Right Side: Visual -->
  <div class="auth-right">
    <div class="auth-right-content">
        <h2>Transformasi Aset Properti Secara Digital.</h2>
        <p>Bergabunglah dengan ratusan pengelola properti profesional yang telah mentransformasi portofolio mereka melalui sistem terorganisir.</p>
        
        <div style="margin-top: 48px; display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div class="feat-item">
                <div style="font-weight:800; font-size:24px; font-family:'Syne';">500+</div>
                <div style="font-size:13px; opacity:0.8;">Partner Terpercaya</div>
            </div>
            <div class="feat-item">
                <div style="font-weight:800; font-size:24px; font-family:'Syne';">ISO 27001</div>
                <div style="font-size:13px; opacity:0.8;">Keamanan Terjamin</div>
            </div>
        </div>
    </div>
  </div>
</div>
</body>

</html>
   </div>
    </div>
</body>

</html>