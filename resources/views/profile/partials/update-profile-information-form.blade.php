<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf
        @method('patch')

        <div class="form-group">
            <label class="form-label" for="name">NAMA LENGKAP</label>
            <div class="input-wrap">
                <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                <div class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
            </div>
            @if($errors->get('name'))
                <p class="mt-2 text-sm" style="color: #ef4444;">{{ $errors->get('name')[0] }}</p>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label" for="email">ALAMAT EMAIL</label>
            <div class="input-wrap">
                <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                <div class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
            </div>
            @if($errors->get('email'))
                <p class="mt-2 text-sm" style="color: #ef4444;">{{ $errors->get('email')[0] }}</p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 15px; padding: 12px; background: rgba(245, 158, 11, 0.05); border: 1.5px solid rgba(245, 158, 11, 0.2); border-radius: 10px;">
                    <p class="text-sm" style="color: #d97706; display: flex; align-items: center; gap: 8px;">
                        <svg style="width:16px; height:16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Email Anda belum terverifikasi.
                        <button form="send-verification" style="font-weight: 700; text-decoration: underline; background: none; border: none; cursor: pointer; color: #b45309;">
                            Kirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm" style="color: #10b981;">
                            Link verifikasi baru telah dikirimkan ke email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 15px; margin-top: 10px;">
            <button type="submit" class="btn btn-blue">Simpan Perubahan</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="font-size: 13px; color: #10b981; font-weight: 600; display: flex; align-items: center; gap: 5px;"
                >
                    <svg style="width:16px; height:16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    Tersimpan
                </p>
            @endif
        </div>
    </form>
</section>
