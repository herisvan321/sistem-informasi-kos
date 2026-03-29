@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Pengaturan Sistem</h1>
        <p class="page-subtitle">Konfigurasi parameter platform dan manajemen data master</p>
    </div>
</div>

<div class="two-col">
    <!-- General Settings -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                Konfigurasi Utama
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label class="form-label">Nama Utama</label>
                        <div class="input-wrap">
                            <input type="text" name="app_name" class="form-input" value="{{ $settings['app_name'] ?? 'Kos' }}">
                            <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/></svg></div>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Suffix (Span)</label>
                        <div class="input-wrap">
                            <input type="text" name="app_name_suffix" class="form-input" value="{{ $settings['app_name_suffix'] ?? 'Admin' }}">
                            <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Dukungan Pelanggan</label>
                    <div class="input-wrap">
                        <input type="email" name="contact_email" class="form-input" value="{{ $settings['contact_email'] ?? 'support@kosapp.id' }}">
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Status Operasional (Maintenance)</label>
                    <div style="display: flex; gap: 10px; align-items: center; background: var(--bg); padding: 12px; border-radius: var(--radius-sm); border: 1.5px solid var(--border);">
                        <select name="maintenance_mode" id="maintenance_mode" class="filter-select" style="flex: 1; border: none; background: transparent; padding: 0;">
                            <option value="0" {{ ($settings['maintenance_mode'] ?? '0') == '0' ? 'selected' : '' }}>Platform Aktif (Live)</option>
                            <option value="1" {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'selected' : '' }}>Mode Pemeliharaan (Under Maintenance)</option>
                        </select>
                        <span id="maintenance-badge" class="badge {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'badge-amber' : 'badge-green' }}">
                            <span class="badge-dot"></span>
                            {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'OFFLINE' : 'ONLINE' }}
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-blue" style="width: 100%; margin-top: 15px; height: 50px; font-weight: 700; letter-spacing: 0.5px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan Konfigurasi
                </button>
            </form>
        </div>
    </div>

    <!-- Premium Settings -->
    <div class="card" style="margin-top: 20px;">
        <div class="card-header">
            <div class="card-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary);"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
                Konfigurasi Pembayaran Premium
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Biaya Listing Premium</label>
                    <div class="input-wrap">
                        <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); font-weight: 700; font-size: 13px; color: var(--primary);">Rp</span>
                        <input type="number" name="premium_price" class="form-input" style="padding-left: 42px;" value="{{ $settings['premium_price'] ?? 150000 }}">
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg></div>
                    </div>
                </div>

                <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label class="form-label">Nama Bank</label>
                        <div class="input-wrap">
                            <input type="text" name="premium_bank_name" class="form-input" value="{{ $settings['premium_bank_name'] ?? 'Bank BCA' }}">
                            <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg></div>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Atas Nama (A/N)</label>
                        <div class="input-wrap">
                            <input type="text" name="premium_bank_holder" class="form-input" value="{{ $settings['premium_bank_holder'] ?? 'PT KOS PREMIUM' }}">
                            <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Rekening</label>
                    <div class="input-wrap">
                        <input type="text" name="premium_bank_account" class="form-input" value="{{ $settings['premium_bank_account'] ?? '829 012 3456' }}">
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Ketentuan Premium (Baris baru untuk list)</label>
                    <textarea name="premium_benefits" class="form-input" rows="4" style="height: auto;">{{ $settings['premium_benefits'] ?? "- Properti diprioritaskan di pencarian teratas\n- Badge Premium untuk kepercayaan\n- Analitik pengunjung lebih mendalam\n- Durasi aktif 30 hari" }}</textarea>
                </div>

                <button type="submit" class="btn btn-blue" style="width: 100%; margin-top: 15px; height: 50px; font-weight: 700;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Konfigurasi Premium
                </button>
            </form>
        </div>
    </div>

    <!-- Master Data Side -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <!-- Categories Management -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                    Kategori Hunian
                </div>
                <button class="btn btn-sm btn-blue" onclick="openModal('modal-category')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                    Tambah
                </button>
            </div>
            <div class="card-body" style="padding:0;">
                <div class="table-wrap">
                    <table class="table-hover">
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td style="padding: 14px 22px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--primary);"></div>
                                        <strong style="color:var(--text); font-size:13.5px;">{{ $category->name }}</strong>
                                    </div>
                                </td>
                                <td style="text-align:right; padding: 14px 22px;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <button class="act-btn" title="Edit Kategori" 
                                                onclick="initEditCategoryModal('{{ $category->id }}', '{{ $category->name }}')">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </button>

                                        <form action="{{ route('admin.settings.categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="act-btn danger" title="Hapus">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="empty-state">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                                    <p>Belum ada kategori hunian terdaftar.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Banner & Promotion -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    Media Promosi
                </div>
                <button class="btn btn-sm btn-blue" onclick="openModal('modal-banner')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                    Baru
                </button>
            </div>
            <div class="card-body" style="padding:0;">
                <div class="table-wrap">
                    <table class="table-hover">
                        <tbody>
                            @forelse($banners as $banner)
                            <tr>
                                <td style="padding: 14px 22px; width: 120px;">
                                    <div style="width: 100px; height: 50px; border-radius: 8px; overflow: hidden; background: var(--bg); border: 1px solid var(--border);">
                                        @if($banner->image_path)
                                            <img src="{{ asset('storage/' . $banner->image_path) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; opacity: 0.3;">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td style="padding: 14px 22px;">
                                    <div style="display: flex; flex-direction: column; gap: 4px;">
                                        <strong style="color:var(--text); font-size:13.5px;">{{ $banner->title }}</strong>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span class="badge badge-blue" style="font-size: 10px; padding: 2px 8px;">
                                                <svg style="width:10px;height:10px;margin-right:4px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                                Tayang: {{ \Carbon\Carbon::parse($banner->start_date)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($banner->end_date)->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:right; padding: 14px 22px;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <button class="act-btn" title="Edit Banner" 
                                                onclick="initEditBannerModal('{{ $banner->id }}', '{{ $banner->title }}', '{{ addslashes($banner->description) }}', '{{ $banner->start_date }}', '{{ $banner->end_date }}', '{{ $banner->image_path ? asset('storage/' . $banner->image_path) : '' }}')">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </button>

                                        <form action="{{ route('admin.settings.banners.destroy', $banner->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus banner ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="act-btn danger" title="Hapus">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="empty-state">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                    <p>Belum ada banner promosi aktif.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Edit Banner -->
<div class="modal-overlay" id="modal-edit-banner" onclick="closeModalOuter(event, 'modal-edit-banner')">
    <div class="modal-box" style="max-width: 500px;">
        <div class="modal-header">
            <h2 class="modal-title">Edit Banner Promosi</h2>
            <button class="modal-close" onclick="closeModal('modal-edit-banner')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="form-edit-banner" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Judul Banner</label>
                    <div class="input-wrap">
                        <input type="text" name="title" id="edit-banner-title" class="form-input" required>
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Uraian Promo</label>
                    <textarea name="description" id="edit-banner-description" class="form-input" rows="3" required></textarea>
                </div>
                <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label class="form-label">Tgl Tayang</label>
                        <input type="date" name="start_date" id="edit-banner-start" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Tgl Berakhir</label>
                        <input type="date" name="end_date" id="edit-banner-end" class="form-input" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Visual Banner (Kosongkan jika tidak diubah)</label>
                    <div id="edit-banner-preview-container" style="display: none; margin-bottom: 15px; width: 100%; height: 160px; border-radius: 12px; overflow: hidden; border: 1.5px solid var(--primary-glow); background: var(--bg);">
                        <img id="edit-banner-preview-img" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="input-wrap">
                        <input type="file" name="image" id="edit-banner-input" class="form-input" accept="image/*" onchange="previewEditBanner(this)">
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-edit-banner')">Batal</button>
                <button type="submit" class="btn btn-blue">Update Banner</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Kelola Kategori -->
<div class="modal-overlay" id="modal-category" onclick="closeModalOuter(event, 'modal-category')">
    <div class="modal-box" style="max-width: 420px;">
        <div class="modal-header">
            <h2 class="modal-title">Registrasi Kategori Pesan</h2>
            <button class="modal-close" onclick="closeModal('modal-category')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.settings.categories.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Kategori Hunian</label>
                    <div class="input-wrap">
                        <input type="text" name="name" class="form-input" placeholder="Misal: Kos Putri, Exclusive..." required autofocus>
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg></div>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-category')">Batal</button>
                <button type="submit" class="btn btn-blue">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Kategori -->
<div class="modal-overlay" id="modal-edit-category" onclick="closeModalOuter(event, 'modal-edit-category')">
    <div class="modal-box" style="max-width: 420px;">
        <div class="modal-header">
            <h2 class="modal-title">Edit Kategori Pesan</h2>
            <button class="modal-close" onclick="closeModal('modal-edit-category')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="form-edit-category" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Kategori Hunian</label>
                    <div class="input-wrap">
                        <input type="text" name="name" id="edit-category-name" class="form-input" required>
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg></div>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-edit-category')">Batal</button>
                <button type="submit" class="btn btn-blue">Update Kategori</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Kelola Banner -->
<div class="modal-overlay" id="modal-banner" onclick="closeModalOuter(event, 'modal-banner')">
    <div class="modal-box" style="max-width: 500px;">
        <div class="modal-header">
            <h2 class="modal-title">Publikasi Banner Promosi</h2>
            <button class="modal-close" onclick="closeModal('modal-banner')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.settings.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Judul Banner</label>
                    <div class="input-wrap">
                        <input type="text" name="title" class="form-input" placeholder="Contoh: Promo Ramadhan Berkah" required>
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Uraian Promo</label>
                    <textarea name="description" class="form-input" rows="3" placeholder="Masukkan deskripsi promo yang menarik..." required></textarea>
                </div>
                <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label class="form-label">Tgl Tayang</label>
                        <input type="date" name="start_date" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Tgl Berakhir</label>
                        <input type="date" name="end_date" class="form-input" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Visual Banner (JPEG/PNG)</label>
                    <div id="banner-preview-container" style="display: none; margin-bottom: 15px; width: 100%; height: 160px; border-radius: 12px; overflow: hidden; border: 1.5px solid var(--primary-glow); background: var(--bg);">
                        <img id="banner-preview-img" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="input-wrap">
                        <input type="file" name="image" id="banner-input" class="form-input" accept="image/*" required onchange="previewBanner(this)">
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                    </div>
                    <p style="font-size: 11px; color: var(--text-muted); margin-top: 5px;">* Gambar akan dikonversi ke format WebP secara otomatis.</p>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-banner')">Batal</button>
                <button type="submit" class="btn btn-blue">Terbitkan Promo</button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    function previewBanner(input) {
        const container = document.getElementById('banner-preview-container');
        const img = document.getElementById('banner-preview-img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                container.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewEditBanner(input) {
        const container = document.getElementById('edit-banner-preview-container');
        const img = document.getElementById('edit-banner-preview-img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                container.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function initEditBannerModal(id, title, description, start, end, image) {
        const form = document.getElementById('form-edit-banner');
        form.action = `/admin/settings/banners/${id}`;
        
        document.getElementById('edit-banner-title').value = title;
        document.getElementById('edit-banner-description').value = description;
        document.getElementById('edit-banner-start').value = start;
        document.getElementById('edit-banner-end').value = end;
        
        const previewContainer = document.getElementById('edit-banner-preview-container');
        const previewImg = document.getElementById('edit-banner-preview-img');
        
        if (image) {
            previewImg.src = image;
            previewContainer.style.display = 'block';
        } else {
            previewContainer.style.display = 'none';
        }
        
        openModal('modal-edit-banner');
    }

    function initEditCategoryModal(id, name) {
        const form = document.getElementById('form-edit-category');
        form.action = `/admin/settings/categories/${id}`;
        document.getElementById('edit-category-name').value = name;
        openModal('modal-edit-category');
    }

    document.getElementById('maintenance_mode').addEventListener('change', function() {
        const badge = document.getElementById('maintenance-badge');
        if (this.value === '1') {
            badge.className = 'badge badge-amber';
            badge.innerHTML = '<span class="badge-dot"></span> OFFLINE';
        } else {
            badge.className = 'badge badge-green';
            badge.innerHTML = '<span class="badge-dot"></span> ONLINE';
        }
    });

    // Reset preview when modal is closed
    window.addEventListener('modal-closed', function(e) {
        if (e.detail === 'modal-banner') {
            document.getElementById('banner-preview-container').style.display = 'none';
            document.getElementById('banner-input').value = '';
        }
    });
</script>
@endsection
@endsection

