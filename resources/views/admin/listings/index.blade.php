@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen Listing Properti</h1>
        <p class="page-subtitle">Moderasi kualitas konten dan verifikasi ketersediaan hunian</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Daftar Properti Aktif
        </div>
        <div style="flex: 1; display: flex; justify-content: flex-end; gap: 15px;">
            <form action="{{ route('admin.listings.index') }}" method="GET" class="filter-bar" style="max-width:320px;">
                <div class="search-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" class="search-input" placeholder="Cari nama kos atau alamat..." value="{{ request('search') }}">
                </div>
            </form>
        </div>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table class="table-hover">
                <thead>
                    <tr>
                        <th style="padding-left: 24px;">IDENTITAS PROPERTI</th>
                        <th>PEMILIK / PROVIDER</th>
                        <th>TARIF SEWA</th>
                        <th>STATUS PUBLIKASI</th>
                        <th>TIER AKUN</th>
                        <th style="text-align:right; padding-right: 24px;">NAVIGASI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listings as $listing)
                    <tr>
                        <td style="padding-left: 24px;">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--bg); border: 1.5px solid var(--border); overflow: hidden; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    @if($listing->image)
                                        <img src="{{ asset('storage/'.$listing->image) }}" style="width:100%; height:100%; object-fit:cover;">
                                    @else
                                        <svg style="width:20px; color:var(--text-muted);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                                    @endif
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <strong style="color:var(--text); font-size:14px;">{{ $listing->name }}</strong>
                                    <small style="opacity:0.5; font-size:11px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">{{ $listing->address }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell">
                                <div class="user-av" style="width:32px; height:32px; font-size:12px; background:var(--primary-glow); color:var(--primary); font-weight:700; border: 1px solid var(--primary-light);">
                                    {{ strtoupper(substr($listing->user->name ?? 'N', 0, 1)) }}
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size:13px; font-weight:600;">{{ $listing->user->name ?? 'N/A' }}</span>
                                    <small style="opacity:0.4; font-size:10px;">ID: #{{ $listing->user_id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column;">
                                <strong style="color:var(--primary); font-size:14px;">Rp {{ number_format($listing->price) }}</strong>
                                <small style="opacity:0.4; font-size:10px; font-weight:600;">PER BULAN</small>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusMap = [
                                    'Approved' => ['class' => 'green', 'label' => 'PUBLISHED'],
                                    'Pending' => ['class' => 'amber', 'label' => 'IN REVIEW'],
                                    'Rejected' => ['class' => 'red', 'label' => 'REJECTED'],
                                ];
                                $st = $statusMap[$listing->status] ?? ['class' => 'red', 'label' => 'UNKNOWN'];
                            @endphp
                            <span class="badge badge-{{ $st['class'] }}" style="padding: 4px 10px; font-size: 10px; font-weight: 700;">
                                <span class="badge-dot"></span>
                                {{ $st['label'] }}
                            </span>
                        </td>
                        <td>
                            @if($listing->is_premium)
                                <span class="badge badge-amber" style="background:rgba(245,158,11,0.1); border:1.5px solid rgba(245,158,11,0.3); color:#D97706; padding: 4px 10px; font-size: 10px; font-weight: 700;">
                                    <svg style="width:12px;height:12px;margin-right:5px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    PREMIUM
                                </span>
                            @else
                                <span class="badge" style="opacity: 0.3; font-size: 9px; border: 1.5px solid var(--border); letter-spacing: 0.5px;">REGULAR</span>
                            @endif
                        </td>
                        <td style="padding-right: 24px;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="{{ route('admin.listings.show', $listing->id) }}" class="act-btn" title="Lihat Detail">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>

                                @if($listing->status == 'Pending')
                                <form action="{{ route('admin.listings.approve', $listing->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="act-btn success" title="Setujui">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    </button>
                                </form>
                                <button class="act-btn danger" title="Tolak" onclick="initRejectModal('{{ $listing->id }}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                </button>
                                @endif
                                
                                <button class="act-btn" title="Edit Cepat" 
                                        onclick="initEditListingModal('{{ $listing->id }}', '{{ $listing->name }}', '{{ addslashes($listing->address) }}', '{{ $listing->price }}', '{{ $listing->status }}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                
                                <form action="{{ route('admin.listings.destroy', $listing->id) }}" method="POST" onsubmit="return confirm('Hapus listing ini secara permanent?')">
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
                        <td colspan="6" class="empty-state" style="padding: 60px 20px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            <p>Belum ada properti terdaftar dalam database.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($listings->hasPages())
    <div class="card-footer" style="padding: 15px 22px;">
        {{ $listings->links() }}
    </div>
    @endif
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

