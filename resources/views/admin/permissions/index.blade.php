@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen Permission</h1>
        <p class="page-subtitle">Atur otoritas spesifik untuk setiap modul dan fungsi sistem</p>
    </div>
    <div class="page-actions">
        <button class="btn btn-blue" onclick="openModal('modal-add-permission')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Registrasi Permission
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Daftar Otoritas Sistem
        </div>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table class="table-hover">
                <thead>
                    <tr>
                        <th style="padding-left: 24px;">IDENTIFIER PERMISSION</th>
                        <th>GUARD SCOPE</th>
                        <th>TEREGISTRASI</th>
                        <th style="text-align:right; padding-right: 24px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                    <tr>
                        <td style="padding-left: 24px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 6px; height: 6px; border-radius: 50%; background: var(--primary); box-shadow: 0 0 8px var(--primary);"></div>
                                <code style="padding: 6px 12px; background: var(--bg); border: 1.5px solid var(--border); border-radius: 8px; color: var(--text); font-family: 'JetBrains Mono', monospace; font-size: 12.5px; letter-spacing: -0.2px;">
                                    {{ $permission->name }}
                                </code>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-amber" style="font-size: 10px;">
                                <span class="badge-dot"></span>
                                {{ strtoupper($permission->guard_name) }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-size:13px; font-weight:500;">{{ $permission->created_at->format('d M Y') }}</span>
                                <small style="opacity:0.4; font-size:11px;">{{ $permission->created_at->format('H:i') }} WIB</small>
                            </div>
                        </td>
                        <td style="padding-right: 24px;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <button class="act-btn" title="Ubah Nama" onclick="initEditPermissionModal('{{ $permission->id }}', '{{ $permission->name }}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Hapus permission ini permanen? Tindakan ini dapat berdampak pada akses role aktif.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="act-btn danger" title="Hapus Permanen">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Tambah Permission -->
<div class="modal-overlay" id="modal-add-permission" onclick="closeModalOuter(event, 'modal-add-permission')">
    <div class="modal-box" style="max-width: 440px;">
        <div class="modal-header">
            <h2 class="modal-title">Registrasi Permission</h2>
            <button class="modal-close" onclick="closeModal('modal-add-permission')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.permissions.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Identifier Permission</label>
                    <div class="input-wrap">
                        <input type="text" name="name" class="form-input" placeholder="contoh: managing-users, delete-logs" required autofocus>
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-add-permission')">Batal</button>
                <button type="submit" class="btn btn-blue">Daftarkan Otoritas</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Permission -->
<div class="modal-overlay" id="modal-edit-permission" onclick="closeModalOuter(event, 'modal-edit-permission')">
    <div class="modal-box" style="max-width: 440px;">
        <div class="modal-header">
            <h2 class="modal-title">Moderasi Permission</h2>
            <button class="modal-close" onclick="closeModal('modal-edit-permission')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="form-edit-permission" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Identifier Permission</label>
                    <div class="input-wrap">
                        <input type="text" name="name" id="edit-perm-name" class="form-input" required>
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-edit-permission')">Batal</button>
                <button type="submit" class="btn btn-blue">Update Otoritas</button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    function initEditPermissionModal(id, name) {
        const form = document.getElementById('form-edit-permission');
        form.action = `/admin/permissions/${id}`;
        document.getElementById('edit-perm-name').value = name;
        openModal('modal-edit-permission');
    }
</script>
@endsection
@endsection
