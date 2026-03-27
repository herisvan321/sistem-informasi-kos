<section>
    <form method="post" action="{{ route('password.update') }}" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf
        @method('put')

        <div class="form-group">
            <label class="form-label" for="update_password_current_password">PASSWORD SAAT INI</label>
            <div class="input-wrap">
                <input id="update_password_current_password" name="current_password" type="password" class="form-input" autocomplete="current-password" />
                <div class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
            </div>
            @if($errors->updatePassword->get('current_password'))
                <p class="mt-2 text-sm" style="color: #ef4444;">{{ $errors->updatePassword->get('current_password')[0] }}</p>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label" for="update_password_password">PASSWORD BARU</label>
            <div class="input-wrap">
                <input id="update_password_password" name="password" type="password" class="form-input" autocomplete="new-password" />
                <div class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
            </div>
            @if($errors->updatePassword->get('password'))
                <p class="mt-2 text-sm" style="color: #ef4444;">{{ $errors->updatePassword->get('password')[0] }}</p>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label" for="update_password_password_confirmation">KONFIRMASI PASSWORD</label>
            <div class="input-wrap">
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password" />
                <div class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
            </div>
            @if($errors->updatePassword->get('password_confirmation'))
                <p class="mt-2 text-sm" style="color: #ef4444;">{{ $errors->updatePassword->get('password_confirmation')[0] }}</p>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 15px; margin-top: 10px;">
            <button type="submit" class="btn btn-blue">Update Password</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="font-size: 13px; color: #10b981; font-weight: 600; display: flex; align-items: center; gap: 5px;"
                >
                    <svg style="width:16px; height:16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    Berhasil Diperbarui
                </p>
            @endif
        </div>
    </form>
</section>
