<section>
    <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 20px;">
        Setelah akun Anda dihapus, semua sumber daya dan data di dalamnya akan dihapus secara permanen. Sebelum menghapus akun, mohon cadangkan data atau informasi apa pun yang ingin Anda pertahankan.
    </p>

    <button 
        class="btn btn-red"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        Hapus Akun Saya
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding: 30px;">
            @csrf
            @method('delete')

            <h2 style="font-size: 20px; font-weight: 700; color: var(--text); margin-bottom: 15px;">
                Apakah Anda yakin ingin menghapus akun?
            </h2>

            <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 25px;">
                Tindakan ini permanen. Mohon masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.
            </p>

            <div class="form-group">
                <label class="form-label" for="password">KONFIRMASI PASSWORD</label>
                <div class="input-wrap">
                    <input id="password" name="password" type="password" class="form-input" placeholder="Password" />
                    <div class="input-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                </div>
                @if($errors->userDeletion->get('password'))
                    <p class="mt-2 text-sm" style="color: #ef4444;">{{ $errors->userDeletion->get('password')[0] }}</p>
                @endif
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px;">
                <button type="button" class="btn btn-outline" x-on:click="$dispatch('close')">
                    Batal
                </button>

                <button type="submit" class="btn btn-red">
                    Hapus Akun Sekarang
                </button>
            </div>
        </form>
    </x-modal>
</section>
