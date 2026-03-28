<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ get_setting('app_name', 'Kos') }}{{ get_setting('app_name_suffix', 'Admin') }} — Verifikasi Email</title>
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

        <div class="login-title">Verifikasi Email Anda 📧</div>
        <div class="login-sub">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="login-error" style="display:block; margin-bottom: 24px; background: #d1fae5; color: #065f46; border-color: #a7f3d0;">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div style="display: flex; flex-direction: column; gap: 16px; margin-top: 32px;">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary" style="width:100%; height:48px; font-size:16px;">Kirim Ulang Link Verifikasi</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="width:100%; text-align:center; font-size:14px; color:var(--text-muted); text-decoration: underline; background:none; border:none; cursor:pointer; padding: 8px 0;">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
  </div>

  <!-- Right Side: Visual -->
  <div class="auth-right">
    <div class="auth-right-content">
        <h2>Satu Langkah Lagi!</h2>
        <p>Verifikasi email membantu kami memastikan bahwa akun Anda aman dan hanya dapat diakses oleh Anda sendiri. Silakan periksa kotak masuk atau folder spam Anda.</p>
        
        <div style="margin-top: 48px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 24px;">
            <div style="font-size: 14px; opacity: 0.8; line-height: 1.6;">
                "Kami menjaga privasi Anda dengan serius. Verifikasi ini adalah bagian dari standar keamanan global platform kami."
            </div>
        </div>
    </div>
  </div>
</div>
</body>

</html>
