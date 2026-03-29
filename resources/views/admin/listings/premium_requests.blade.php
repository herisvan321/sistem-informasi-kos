@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@700;800&display=swap');
    
    .requests-container {
        animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .syne { font-family: 'Syne', sans-serif; }

    /* Dashboard-style Card & Table */
    .dashboard-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table th {
        background: var(--bg);
        padding: 20px 24px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border);
    }

    .custom-table td {
        padding: 20px 24px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border);
    }

    .custom-table tr:last-child td { border-bottom: none; }

    /* User Cell - Dashboard Pattern */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-av {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        color: white;
        background: var(--primary);
        font-family: 'Syne';
    }

    .user-info strong {
        display: block;
        font-size: 14px;
        font-weight: 800;
        color: var(--text);
    }

    .user-info span {
        font-size: 11px;
        color: var(--text-muted);
        font-weight: 600;
    }

    /* Listing Identity */
    .listing-id {
        display: flex;
        flex-direction: column;
    }

    .listing-id .name {
        font-weight: 800;
        font-size: 14px;
        color: var(--text);
    }

    .listing-id .loc {
        font-size: 11px;
        color: var(--text-muted);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Strategic Buttons */
    .btn-strategic {
        border-radius: 100px;
        font-weight: 800;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 8px 20px;
    }

    /* Cinematic Proof Viewer */
    .proof-viewer-btn {
        background: var(--bg);
        border: 1.5px solid var(--border);
        padding: 8px 16px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--text);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .proof-viewer-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
        transform: scale(1.05);
    }

    /* Status Badge - Dashboard Plate */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        background: var(--bg);
        border: 1px solid var(--border);
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #f59e0b; /* Amber for pending */
    }
</style>

<div class="requests-container">
    <div class="page-header" style="margin-bottom: 30px;">
        <div>
            <h1 class="page-title syne">Log Verifikasi Akselerasi</h1>
            <p class="page-subtitle">Sesi Otorisasi Transaksi Premium Aktif</p>
        </div>
        <div class="page-actions">
            <button class="btn btn-outline btn-strategic" onclick="showToast('info','Mengunduh log transaksi...')">EKSPOR AUDIT</button>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="table-wrap">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>ENTITAS PEMILIK</th>
                        <th>ASSET PROPERTI</th>
                        <th>WAKTU PENGAJUAN</th>
                        <th>INSTRUMEN AUDIT</th>
                        <th style="text-align: right;">AKSI STRATEGIS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listings as $listing)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-av" style="background: var(--primary); opacity: 0.9;">
                                    {{ strtoupper(substr($listing->user->name, 0, 1)) }}
                                </div>
                                <div class="user-info">
                                    <strong>{{ $listing->user->name }}</strong>
                                    <span>MITRA AFILIASI</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="listing-id">
                                <span class="name">{{ $listing->name }}</span>
                                <span class="loc">
                                    <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $listing->city }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 13px; font-weight: 800;">{{ $listing->updated_at->translatedFormat('d M Y') }}</div>
                            <div style="font-size: 11px; color: var(--text-muted); font-weight: 700;">{{ $listing->updated_at->format('H:i') }} WIB</div>
                        </td>
                        <td>
                            <button class="proof-viewer-btn" onclick="showCinematicAudit('{{ asset('storage/' . $listing->premium_payment_proof) }}', '{{ $listing->name }}')">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                PERIKSA DOKUMEN
                            </button>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <form action="{{ route('admin.listings.approve-premium', $listing->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-blue btn-strategic" style="background: #41b67e;">OTORISASI</button>
                                </form>
                                <button class="btn btn-outline btn-strategic" style="color: #ef4444; border-color: #ef4444;" onclick="openAuditReject('{{ $listing->id }}', '{{ $listing->name }}')">PROTES</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 100px 0; text-align: center;">
                            <div class="status-badge" style="margin-bottom: 16px; padding: 12px 24px;">
                                <span class="status-dot" style="background: #41b67e;"></span>
                                STABILITAS SISTEM TERJAMIN
                            </div>
                            <p style="color: var(--text-muted); font-size: 13px; font-weight: 600;">Tidak ada anomali transaksi premium yang memerlukan intervensi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Audit View -->
<div class="modal-overlay" id="modal-proof" style="backdrop-filter: blur(15px); background: rgba(0,0,0,0.85);" onclick="closeModalOuter(event, 'modal-proof')">
    <div class="modal-box" style="max-width: 800px; background: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 24px;">
        <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.05); padding: 24px;">
            <h2 class="syne" id="proof-title" style="color: white; font-size: 18px; font-weight: 800;">DOKUMEN AUDIT STRATEGIS</h2>
            <button class="modal-close" style="color: rgba(255,255,255,0.5); font-weight: 400;" onclick="closeModal('modal-proof')">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-body" style="padding: 24px;">
            <div style="background: #1e293b; border-radius: 16px; padding: 12px; max-height: 65vh; overflow-y: auto;">
                <img id="proof-img" src="" style="width: 100%; border-radius: 8px; box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
            </div>
            <div style="margin-top: 24px; text-align: center;">
                <button class="btn btn-outline btn-strategic" style="color: white; border-color: rgba(255,255,255,0.2);" onclick="window.open(document.getElementById('proof-img').src, '_blank')">BUKA SUMBER ASLI</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Intervention (Reject) -->
<div class="modal-overlay" id="modal-reject" onclick="closeModalOuter(event, 'modal-reject')">
    <div class="modal-box" style="max-width: 450px; border-radius: 28px;">
        <div class="modal-header">
            <h2 class="syne" style="font-size: 18px; font-weight: 800;">INTERVENSI SISTEM</h2>
            <button class="modal-close" onclick="closeModal('modal-reject')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="reject-form" method="POST">
            @csrf
            <div class="modal-body">
                <div style="background: #fff1f2; border: 1.5px solid #fecdd3; border-radius: 16px; padding: 16px; margin-bottom: 24px; color: #be123c; font-size: 12px; font-weight: 700; line-height: 1.6;">
                    OPERASI PENOLAKAN: <strong id="reject-listing-name"></strong><br>
                    Harap lampirkan log justifikasi audit untuk mitra pemilik.
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-weight: 800; font-size: 11px; letter-spacing: 0.5px;">JUSTIFIKASI PENOLAKAN</label>
                    <textarea name="notes" class="form-input" rows="4" style="border-radius: 16px; resize: none; font-size: 13px;" 
                              placeholder="Deskripsikan anomali atau ketidaksesuaian data finansial..." required></textarea>
                </div>
            </div>
            <div class="modal-foot" style="border-top: none;">
                <button type="submit" class="btn btn-blue btn-strategic" style="background: #ef4444; width: 100%; height: 50px;">PROSES INTERVENSI</button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    function showCinematicAudit(url, name) {
        document.getElementById('proof-img').src = url;
        document.getElementById('proof-title').innerText = 'AUDIT STRATEGIS: ' + name.toUpperCase();
        openModal('modal-proof');
    }

    function openAuditReject(id, name) {
        const form = document.getElementById('reject-form');
        form.action = `/admin/listings/${id}/reject-premium`;
        document.getElementById('reject-listing-name').innerText = name.toUpperCase();
        openModal('modal-reject');
    }
</script>
@endsection
@endsection


