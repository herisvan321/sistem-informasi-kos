@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen Role</h1>
        <p class="page-subtitle">Definisikan hirarki dan cakupan otoritas pengguna dalam sistem</p>
    </div>
    <div class="page-actions">
        <button class="btn btn-blue" onclick="openModal('modal-add-role')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Otoritas Role
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
            Struktur Role & Hak Akses
        </div>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table class="table-hover">
                <thead>
                    <tr>
                        <th style="padding-left: 24px;">IDENTITAS ROLE</th>
                        <th>CAKUPAN PERMISSION</th>
                        <th>TEREGISTRASI</th>
                        <th style="text-align:right; padding-right: 24px;">KONTROL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td style="padding-left: 24px;">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <div style="width: 40px; height: 40px; border-radius: 12px; background: {{ $role->name === 'super-admin' ? 'var(--primary-glow)' : 'var(--bg)' }}; display: flex; align-items: center; justify-content: center; color: {{ $role->name === 'super-admin' ? 'var(--primary)' : 'var(--text-muted)' }}; border: 1.5px solid {{ $role->name === 'super-admin' ? 'var(--primary)' : 'var(--border)' }}; shadow: var(--shadow);">
                                    <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                </div>
                                <div>
                                    <strong style="color:var(--text); font-size:14px; letter-spacing: 0.3px; display:block;">{{ strtoupper($role->name) }}</strong>
                                    <small style="opacity:0.5; font-size:11px; text-transform: uppercase; font-weight:600;">{{ $role->guard_name }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($role->name === 'super-admin')
                                <span class="badge badge-green">
                                    <span class="badge-dot"></span>
                                    FULL SYSTEM ACCESS
                                </span>
                            @else
                                <span class="badge badge-blue">
                                    <span class="badge-dot"></span>
                                    {{ $role->permissions->count() }} Hak Akses Aktif
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-size:13.5px; font-weight:500;">{{ $role->created_at->format('d M Y') }}</span>
                                <small style="opacity:0.4; font-size:11px;">{{ $role->created_at->diffForHumans() }}</small>
                            </div>
                        </td>
                        <td style="padding-right: 24px;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                @if($role->name !== 'super-admin')
                                <button class="act-btn" title="Edit Role" onclick="initEditRoleModal('{{ $role->id }}', '{{ $role->name }}', '{{ json_encode($role->permissions->pluck('name')) }}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Hapus role ini secara permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="act-btn danger" title="Hapus Role">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                    </button>
                                </form>
                                @else
                                <div class="badge" style="opacity: 0.3; font-size: 10px; border: 1.5px solid var(--border); letter-spacing: 1px;">PROTECTED</div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Tambah Role -->
<div class="modal-overlay" id="modal-add-role" onclick="closeModalOuter(event, 'modal-add-role')">
    <div class="modal-box" style="max-width: 600px;">
        <div class="modal-header">
            <h2 class="modal-title">Tambah Otoritas Role</h2>
            <button class="modal-close" onclick="closeModal('modal-add-role')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Identifier Role</label>
                    <div class="input-wrap">
                        <input type="text" name="name" class="form-input" placeholder="Misal: moderator, editor" required autofocus>
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 25px;">
                    <label class="form-label">Alokasi Hak Akses (Permissions)</label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; margin-top: 10px; background: var(--bg); padding: 15px; border-radius: var(--radius-sm); border: 1.5px solid var(--border); max-height: 250px; overflow-y: auto;">
                        @foreach($permissions as $perm)
                        <label class="custom-check-label">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}">
                            <span class="check-box"></span>
                            <span class="check-text text-mono">{{ $perm->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-add-role')">Batal</button>
                <button type="submit" class="btn btn-blue">Simpan Konfigurasi</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Role -->
<div class="modal-overlay" id="modal-edit-role" onclick="closeModalOuter(event, 'modal-edit-role')">
    <div class="modal-box" style="max-width: 600px;">
        <div class="modal-header">
            <h2 class="modal-title">Moderasi Otoritas Role</h2>
            <button class="modal-close" onclick="closeModal('modal-edit-role')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="form-edit-role" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Identifier Role</label>
                    <div class="input-wrap">
                        <input type="text" name="name" id="edit-role-name" class="form-input" required>
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 25px;">
                    <label class="form-label">Review Hak Akses Aktif</label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; margin-top: 10px; background: var(--bg); padding: 15px; border-radius: var(--radius-sm); border: 1.5px solid var(--border); max-height: 250px; overflow-y: auto;">
                        @foreach($permissions as $perm)
                        <label class="custom-check-label">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" class="edit-perm-check">
                            <span class="check-box"></span>
                            <span class="check-text text-mono">{{ $perm->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-edit-role')">Batal</button>
                <button type="submit" class="btn btn-blue">Update Otoritas</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Custom Checkboxes for Modals */
.custom-check-label {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    user-select: none;
    padding: 4px 0;
}
.custom-check-label input {
    display: none;
}
.check-box {
    width: 20px;
    height: 20px;
    border: 2px solid var(--border);
    border-radius: 6px;
    background: var(--surface);
    position: relative;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    flex-shrink: 0;
}
.custom-check-label input:checked + .check-box {
    background: var(--primary);
    border-color: var(--primary);
    box-shadow: 0 4px 10px rgba(78, 115, 223, 0.35);
}
.check-box::after {
    content: '';
    position: absolute;
    left: 6px;
    top: 2px;
    width: 4px;
    height: 8px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
    opacity: 0;
    transition: opacity 0.2s;
}
.custom-check-label input:checked + .check-box::after {
    opacity: 1;
}
.check-text {
    font-size: 13px;
    color: var(--text);
    font-weight: 500;
}
.text-mono {
    font-family: 'JetBrains Mono', monospace;
    font-size: 11.5px;
}
</style>

@section('scripts')
<script>
    function initEditRoleModal(id, name, currentPerms) {
        const form = document.getElementById('form-edit-role');
        form.action = `/admin/roles/${id}`;
        document.getElementById('edit-role-name').value = name;
        
        // Reset and check existing perms
        const perms = JSON.parse(currentPerms);
        document.querySelectorAll('.edit-perm-check').forEach(el => {
            el.checked = perms.includes(el.value);
        });

        openModal('modal-edit-role');
    }
</script>
@endsection
@endsection
