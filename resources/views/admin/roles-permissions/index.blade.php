@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Roles & Permissions</h1>
        <p class="page-subtitle">Kelola tingkat akses dan hak istimewa pengguna secara hierarkis</p>
    </div>
    <div class="page-actions">
        <button type="button" class="btn btn-blue" onclick="openModal('modal-add-role')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Role Baru
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Matriks Hak Akses Sistem
        </div>
        <button type="submit" form="matrix-form" class="btn btn-blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Simpan Konfigurasi
        </button>
    </div>
    <div class="card-body" style="padding:0;">
        <form id="matrix-form" action="{{ route('admin.roles-permissions.sync') }}" method="POST">
            @csrf
            <div class="table-wrap" style="max-height: 70vh; overflow: auto; border-radius: 0 0 var(--radius) var(--radius);">
                <table class="table-hover" style="border-collapse: separate; border-spacing: 0;">
                    <thead style="position: sticky; top: 0; z-index: 20;">
                        <tr>
                            <th style="background: var(--surface2); position: sticky; left: 0; z-index: 30; border-right: 1.5px solid var(--border); width: 280px;">
                                <div style="display:flex; align-items:center; gap:8px; color:var(--text); font-weight:800; letter-spacing:1px;">
                                    <svg style="width:14px;height:14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                                    IDENTIFIER PERMISSION
                                </div>
                            </th>
                            @foreach($roles as $role)
                            <th style="text-align:center; min-width: 140px; background: var(--surface2); border-bottom: 1.5px solid var(--border);">
                                <div style="font-size: 11px; font-weight: 800; letter-spacing: 1.5px; color: {{ $role->name === 'super-admin' ? 'var(--primary)' : 'var(--text)' }};">
                                    {{ strtoupper($role->name) }}
                                </div>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td style="background: var(--surface); position: sticky; left: 0; z-index: 10; border-right: 1.5px solid var(--border); font-weight: 500;">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <code style="font-family: 'JetBrains Mono', monospace; font-size: 12.5px; color: var(--text);">{{ $permission->name }}</code>
                                </div>
                            </td>
                            @foreach($roles as $role)
                            <td style="text-align:center; padding: 0;">
                                @if($role->name === 'super-admin')
                                    <div style="color: var(--success); display: flex; align-items: center; justify-content: center; height: 54px; background: rgba(34,197,94,0.03);">
                                        <div style="background: rgba(34,197,94,0.15); width: 26px; height: 26px; border-radius: 6px; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 10px rgba(34,197,94,0.2);">
                                            <svg style="width:14px; height:14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
                                        </div>
                                    </div>
                                @else
                                    <div class="matrix-cell-hover" style="display: flex; align-items: center; justify-content: center; height: 54px;">
                                        <label class="matrix-check" style="cursor: pointer; display: flex; align-items:center; justify-content:center; width: 100%; height: 100%;">
                                            <input type="checkbox" name="matrix[{{ $role->id }}][{{ $permission->name }}]" value="1" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        </label>
                                    </div>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Add New Role -->
<div class="modal-overlay" id="modal-add-role" onclick="closeModalOuter(event, 'modal-add-role')">
    <div class="modal-box" style="max-width: 420px;">
        <div class="modal-header">
            <h2 class="modal-title">Registrasi Role Baru</h2>
            <button class="modal-close" onclick="closeModal('modal-add-role')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.roles-permissions.store-role') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Identifier Role</label>
                    <div class="input-wrap">
                        <input type="text" name="name" class="form-input" placeholder="Misal: manager, moderator..." required autofocus>
                        <div class="input-icon">
                            <svg style="width:18px;height:18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                        </div>
                    </div>
                    <small style="display:block; margin-top:8px; color:var(--text-muted); font-size:12px;">Gunakan huruf kecil dan tanda hubung untuk identifier sistem.</small>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-add-role')">Batalkan</button>
                <button type="submit" class="btn btn-blue">Daftarkan Role</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Matrix Specific Styles */
.matrix-cell-hover:hover {
    background: var(--primary-glow);
}
.matrix-check input {
    appearance: none;
    width: 22px;
    height: 22px;
    border: 2px solid var(--border);
    border-radius: 6px;
    background: var(--surface);
    cursor: pointer;
    position: relative;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
.matrix-check input:checked {
    background: var(--primary);
    border-color: var(--primary);
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(78, 115, 223, 0.35);
}
.matrix-check input:checked::after {
    content: '';
    position: absolute;
    left: 7px;
    top: 3px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2.5px 2.5px 0;
    transform: rotate(45deg);
}
.matrix-check input:hover {
    border-color: var(--primary);
    background: var(--primary-glow);
}
/* Ensure table rows don't collapse */
.table-hover tr {
    height: 54px;
}
</style>
@endsection
