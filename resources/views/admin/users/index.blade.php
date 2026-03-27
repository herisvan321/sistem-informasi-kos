@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Kelola Pengguna</h1>
        <p class="page-subtitle">Total {{ $users->total() }} pengguna terdaftar di platform</p>
    </div>
    <div class="page-actions">
        <button class="btn btn-blue" onclick="openModal('modal-add-user')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah User Baru
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
            Daftar Seluruh Pengguna
        </div>
        <form action="{{ route('admin.users.index') }}" method="GET" class="filter-bar">
            <div class="search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" class="search-input" placeholder="Cari nama atau email..." value="{{ request('search') }}">
            </div>
        </form>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table class="table-hover">
                <thead>
                    <tr>
                        <th>PROFIL</th>
                        <th>LEVEL AKSES</th>
                        <th>STATUS AKUN</th>
                        <th>GABUNG PADA</th>
                        <th>VERIFIKASI PRO</th>
                        <th style="text-align:right;">KONTROL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-av" style="background:var(--primary); opacity: 0.8;">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="user-info">
                                    <strong style="color:var(--text);">{{ $user->name }}</strong>
                                    <span style="font-size:12px; opacity: 0.6;">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                                @foreach($user->roles as $role)
                                    <span class="badge" style="background:var(--primary-glow); color:var(--primary); border:1px solid rgba(59,130,246,0.2); text-transform:uppercase; font-size:10px;">
                                        {{ str_replace('-', ' ', $role->name) }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            @php
                                $statusMap = [
                                    'active' => ['class' => 'green', 'label' => 'Aktif'],
                                    'pending' => ['class' => 'amber', 'label' => 'Menunggu'],
                                    'blocked' => ['class' => 'red', 'label' => 'Diblokir'],
                                ];
                                $st = $statusMap[$user->status] ?? ['class' => 'red', 'label' => ucfirst($user->status)];
                            @endphp
                            <span class="badge badge-{{ $st['class'] }}">
                                <span class="badge-dot"></span>
                                {{ $st['label'] }}
                            </span>
                        </td>
                        <td>
                            <span style="font-size:13px; opacity:0.8;">{{ $user->created_at->format('d/m/Y') }}</span>
                        </td>
                        <td>
                            @if($user->hasRole('pemilik-kos'))
                                @if($user->status == 'active')
                                    <span class="badge badge-green" style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3);">
                                        <svg style="width:12px;height:12px;margin-right:4px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                        Verified
                                    </span>
                                @else
                                    <form action="{{ route('admin.users.verify', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-blue" style="padding: 4px 10px; font-size: 11px;">Aktifkan Pemilik</button>
                                    </form>
                                @endif
                            @else
                                <span class="badge" style="opacity: 0.3;">N/A</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <button class="act-btn" title="Edit Profil" 
                                        onclick="initEditUserModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->status }}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                
                                <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="act-btn warning" title="{{ $user->status === 'active' ? 'Blokir' : 'Aktifkan' }}">
                                        @if($user->status === 'active')
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                        @else
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        @endif
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus permanent?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="act-btn danger" title="Hapus Permanent">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding: 40px; opacity: 0.5;">
                            Tidak ada data pengguna ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer" style="padding: 15px 22px;">
        {{ $users->links() }}
    </div>
</div>

<!-- Modal: Tambah User -->
<div class="modal-overlay" id="modal-add-user" onclick="closeModalOuter(event, 'modal-add-user')">
    <div class="modal-box">
        <div class="modal-header">
            <h2 class="modal-title">Tambah User Baru</h2>
            <button class="modal-close" onclick="closeModal('modal-add-user')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-input" placeholder="Masukkan nama..." required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" placeholder="email@example.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tipe User</label>
                    <select name="role" class="filter-select" style="width: 100%;">
                        <option value="pencari-kos">Pencari Kos</option>
                        <option value="pemilik-kos">Pemilik Kos</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Min. 8 karakter" required>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-add-user')">Batal</button>
                <button type="submit" class="btn btn-blue">Simpan User</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit User -->
<div class="modal-overlay" id="modal-edit-user" onclick="closeModalOuter(event, 'modal-edit-user')">
    <div class="modal-box">
        <div class="modal-header">
            <h2 class="modal-title">Edit Data User</h2>
            <button class="modal-close" onclick="closeModal('modal-edit-user')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="form-edit-user" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" id="edit-name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" id="edit-email" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Status Akun</label>
                    <select name="status" id="edit-status" class="filter-select" style="width: 100%;">
                        <option value="active">Aktif</option>
                        <option value="blocked">Diblokir</option>
                    </select>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-edit-user')">Batal</button>
                <button type="submit" class="btn btn-blue">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    function initEditUserModal(id, name, email, status) {
        const form = document.getElementById('form-edit-user');
        form.action = `/admin/users/${id}`;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-status').value = status;
        openModal('modal-edit-user');
    }
</script>
@endsection
@endsection

