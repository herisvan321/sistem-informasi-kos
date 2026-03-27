@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
            <a href="{{ route('admin.listings.index') }}" style="color: var(--primary); display: flex; align-items: center; gap: 5px; font-size: 13px; font-weight: 600; text-decoration: none;">
                <svg style="width:16px; height:16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                KEMBALI KE LISTING
            </a>
        </div>
        <h1 class="page-title">Detail Properti: {{ $listing->name }}</h1>
        <p class="page-subtitle">ID Listing: #{{ $listing->id }} &bull; Terdaftar pada {{ $listing->created_at->format('d M Y, H:i') }} WIB</p>
    </div>
    <div class="page-actions">
        <button class="btn btn-blue" onclick="initEditListingModal('{{ $listing->id }}', '{{ $listing->name }}', '{{ addslashes($listing->address) }}', '{{ $listing->price }}', '{{ $listing->status }}')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Properti
        </button>
    </div>
</div>

<div class="two-col" style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px; align-items: start;">
    <!-- Left Column: Property Info & Media -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Informasi Utama Properti
                </div>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    <div class="info-group">
                        <label style="display: block; font-size: 11px; font-weight: 700; color: var(--text-muted); letter-spacing: 0.5px; margin-bottom: 8px;">NAMA HUNIAN</label>
                        <div style="font-size: 18px; font-weight: 700; color: var(--text);">{{ $listing->name }}</div>
                    </div>
                    <div class="info-group">
                        <label style="display: block; font-size: 11px; font-weight: 700; color: var(--text-muted); letter-spacing: 0.5px; margin-bottom: 8px;">TARIF SEWA / BULAN</label>
                        <div style="font-size: 18px; font-weight: 700; color: var(--primary);">Rp {{ number_format($listing->price) }}</div>
                    </div>
                </div>
                
                <div style="margin-top: 25px; padding-top: 25px; border-top: 1.5px solid var(--border);">
                    <label style="display: block; font-size: 11px; font-weight: 700; color: var(--text-muted); letter-spacing: 0.5px; margin-bottom: 12px;">LOKASI LENGKAP</label>
                    <div style="display: flex; gap: 12px;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--bg); border: 1.5px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--primary); flex-shrink: 0;">
                            <svg style="width:20px; height:20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div style="font-size: 15px; color: var(--text); line-height: 1.6;">{{ $listing->address }}</div>
                    </div>
                </div>

                <div style="margin-top: 25px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                    <div style="background: var(--bg); border: 1.5px solid var(--border); border-radius: 12px; padding: 15px;">
                        <label style="display: block; font-size: 10px; font-weight: 700; color: var(--text-muted); margin-bottom: 5px;">STATUS</label>
                        @php
                            $statusMap = [
                                'Approved' => ['class' => 'green', 'label' => 'LIVE / PUBLISHED'],
                                'Pending' => ['class' => 'amber', 'label' => 'UNDER REVIEW'],
                                'Rejected' => ['class' => 'red', 'label' => 'REJECTED'],
                            ];
                            $st = $statusMap[$listing->status] ?? ['class' => 'red', 'label' => 'UNKNOWN'];
                        @endphp
                        <span class="badge badge-{{ $st['class'] }}" style="padding: 4px 8px; font-size: 10px; font-weight: 700;">
                            <span class="badge-dot"></span>
                            {{ $st['label'] }}
                        </span>
                    </div>
                    <div style="background: var(--bg); border: 1.5px solid var(--border); border-radius: 12px; padding: 15px;">
                        <label style="display: block; font-size: 10px; font-weight: 700; color: var(--text-muted); margin-bottom: 5px;">TIER LISTING</label>
                        @if($listing->is_premium)
                            <span class="badge badge-amber" style="background:rgba(245,158,11,0.1); border:1.5px solid rgba(245,158,11,0.3); color:#D97706; padding: 4px 8px; font-size: 10px; font-weight: 700;">
                                <svg style="width:12px;height:12px;margin-right:4px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                PREMIUM
                            </span>
                        @else
                            <span class="badge" style="opacity: 0.5; font-size: 10px; border: 1.5px solid var(--border);">REGULAR</span>
                        @endif
                    </div>
                    <div style="background: var(--bg); border: 1.5px solid var(--border); border-radius: 12px; padding: 15px;">
                        <label style="display: block; font-size: 10px; font-weight: 700; color: var(--text-muted); margin-bottom: 5px;">VISIBILITAS</label>
                        <span style="font-size: 13px; font-weight: 600; color: var(--text);">Public Searchable</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Moderation Actions -->
        <div class="card" style="border: 2px solid var(--primary-glow);">
            <div class="card-header" style="background: var(--primary-glow);">
                <div class="card-title" style="color: var(--primary);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Pusat Tindakan Moderasi
                </div>
            </div>
            <div class="card-body">
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px;">Tentukan status publikasi properti ini setelah melakukan verifikasi data dan aset visual.</p>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    @if($listing->status != 'Approved')
                    <form action="{{ route('admin.listings.approve', $listing->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-blue" style="background: #10b981; border-color: #059669; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);">
                            <svg style="width:18px; height:18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Terbitkan Properti
                        </button>
                    </form>
                    @endif
                    
                    @if($listing->status != 'Rejected')
                    <button class="btn btn-outline" style="color: #ef4444; border-color: rgba(239, 68, 68, 0.3);" onclick="initRejectModal('{{ $listing->id }}')">
                        <svg style="width:18px; height:18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Tolak & Beri Feedback
                    </button>
                    @endif

                    <form action="{{ route('admin.listings.toggle-premium', $listing->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline">
                            <svg style="width:18px; height:18px; color: #f59e0b;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            {{ $listing->is_premium ? 'Downgrade ke Regular' : 'Upgrade ke Premium' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Owner & Stats -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Owner Card -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Profil Pemilik</div>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 10px 0 20px;">
                    <div class="user-av" style="width: 80px; height: 80px; font-size: 32px; font-weight: 800; background: var(--primary-glow); color: var(--primary); border: 3px solid var(--primary-light); box-shadow: 0 8px 16px rgba(var(--primary-rgb), 0.1);">
                        {{ strtoupper(substr($listing->user->name ?? '?', 0, 1)) }}
                    </div>
                    <div style="margin-top: 15px;">
                        <h3 style="font-size: 18px; font-weight: 700; color: var(--text); margin-bottom: 4px;">{{ $listing->user->name ?? 'N/A' }}</h3>
                        <p style="font-size: 13px; color: var(--text-muted); font-family: 'JetBrains Mono';">{{ $listing->user->email ?? 'N/A' }}</p>
                    </div>
                    
                    <div style="margin-top: 20px; width: 100%; display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; justify-content: space-between; padding: 10px; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; font-size: 13px;">
                            <span style="color: var(--text-muted);">Status Akun</span>
                            <span style="font-weight: 700; color: var(--primary);">PROVIDER</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 10px; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; font-size: 13px;">
                            <span style="color: var(--text-muted);">Verifikasi Email</span>
                            @if($listing->user->email_verified_at ?? false)
                                <span style="font-weight: 700; color: #10b981; display: flex; align-items: center; gap: 4px;">
                                    <svg style="width:14px; height:14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    Terverifikasi
                                </span>
                            @else
                                <span style="font-weight: 700; color: #ef4444;">Belum Verifikasi</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Meta -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Metadata Sistem</div>
            </div>
            <div class="card-body" style="padding: 0;">
                <div style="padding: 15px 20px; border-bottom: 1.5px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 12px; font-weight: 600; color: var(--text-muted);">ID DATABASE</span>
                    <code style="font-family: 'JetBrains Mono'; font-size: 12px; color: var(--text);">#{{ $listing->id }}</code>
                </div>
                <div style="padding: 15px 20px; border-bottom: 1.5px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 12px; font-weight: 600; color: var(--text-muted);">DITAMBAHKAN</span>
                    <span style="font-size: 12px; font-weight: 600; color: var(--text);">{{ $listing->created_at->format('d M Y') }}</span>
                </div>
                <div style="padding: 15px 20px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 12px; font-weight: 600; color: var(--text-muted);">PEMBARUAN TERAKHIR</span>
                    <span style="font-size: 12px; font-weight: 600; color: var(--text);">{{ $listing->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Tolak Listing -->
<div class="modal-overlay" id="modal-reject" onclick="closeModalOuter(event, 'modal-reject')">
    <div class="modal-box" style="max-width: 440px;">
        <div class="modal-header">
            <h2 class="modal-title">Konfirmasi Penolakan</h2>
            <button class="modal-close" onclick="closeModal('modal-reject')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="form-reject-listing" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Kategori Pelanggaran</label>
                    <select name="reason" class="filter-select" style="width: 100%; border: 1.5px solid var(--border);" required>
                        <option value="Foto tidak jelas">Foto tidak jelas / Kualitas rendah</option>
                        <option value="Data tidak valid">Deskripsi / Lokasi tidak valid</option>
                        <option value="Indikasi penipuan">Indikasi penipuan / Scam</option>
                        <option value="Properti duplikat">Properti terdaftar ganda</option>
                        <option value="Lainnya">Alasan lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan Feedback untuk Pemilik</label>
                    <textarea name="notes" class="form-input" rows="3" placeholder="Jelaskan apa yang perlu diperbaiki oleh pemilik agar listing dapat diterbitkan..."></textarea>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-reject')">Batal</button>
                <button type="submit" class="btn btn-red">Submit Penolakan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Listing (Quick Edit) -->
<div class="modal-overlay" id="modal-edit-listing" onclick="closeModalOuter(event, 'modal-edit-listing')">
    <div class="modal-box" style="max-width: 500px;">
        <div class="modal-header">
            <h2 class="modal-title">Sunting Cepat Properti</h2>
            <button class="modal-close" onclick="closeModal('modal-edit-listing')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="form-edit-listing" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Properti Kos</label>
                    <div class="input-wrap">
                        <input type="text" name="name" id="edit-listing-name" class="form-input" required>
                        <div class="input-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Lokasi Lengkap</label>
                    <textarea name="address" id="edit-listing-address" class="form-input" rows="2" required></textarea>
                </div>
                <div class="form-group" style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 15px;">
                    <div>
                        <label class="form-label">Harga per Bulan</label>
                        <div class="input-wrap">
                            <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--primary); font-weight:700; font-size:12px;">Rp</span>
                            <input type="number" name="price" id="edit-listing-price" class="form-input" style="padding-left: 36px;" required>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" id="edit-listing-status" class="filter-select" style="width: 100%; border: 1.5px solid var(--border);">
                            <option value="Pending">Review</option>
                            <option value="Approved">Live</option>
                            <option value="Rejected">Reject</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-edit-listing')">Batal</button>
                <button type="submit" class="btn btn-blue">Update Properti</button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    function initRejectModal(id) {
        const form = document.getElementById('form-reject-listing');
        form.action = `/admin/listings/${id}/reject`;
        openModal('modal-reject');
    }
    function initEditListingModal(id, name, address, price, status) {
        const form = document.getElementById('form-edit-listing');
        form.action = `/admin/listings/${id}`;
        document.getElementById('edit-listing-name').value = name;
        document.getElementById('edit-listing-address').value = address;
        document.getElementById('edit-listing-price').value = price;
        document.getElementById('edit-listing-status').value = status;
        openModal('modal-edit-listing');
    }
</script>
@endsection
@endsection
