@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@700;800&display=swap');
    
    .premium-wrapper {
        max-width: 1000px;
        margin: 0 auto;
        padding-bottom: 40px;
        animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Steps Indicator - Dashboard Style */
    .payment-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        position: relative;
        padding: 0 40px;
    }

    .payment-steps::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 60px;
        right: 60px;
        height: 2px;
        background: var(--border);
        z-index: 1;
    }

    .step-item {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .step-dot {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--bg);
        border: 2px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-weight: 800;
        font-family: 'Syne';
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .step-item.active .step-dot {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
        box-shadow: 0 10px 20px rgba(var(--primary-rgb), 0.3);
        transform: scale(1.1);
    }

    .step-item.completed .step-dot {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--primary-glow);
    }

    .step-label {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--text-muted);
    }

    .step-item.active .step-label { color: var(--text); }

    /* Dashboard-style Stat Card for Price */
    .stat-card-premium {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 30px;
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border-left: 4px solid var(--primary);
    }

    .stat-icon-premium {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: var(--primary-glow);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .syne { font-family: 'Syne', sans-serif; }

    /* Buttons - Strategic Style */
    .btn-strategic {
        border-radius: 100px;
        font-weight: 800;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 16px 32px;
        transition: all 0.3s ease;
    }

    /* Dropzone - Dashboard Interaction */
    .proof-upload-area {
        width: 100%;
        height: 260px;
        border-radius: 24px;
        background: var(--bg);
        border: 2px dashed var(--border);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }

    .proof-upload-area:hover {
        border-color: var(--primary);
        background: var(--primary-glow);
        transform: translateY(-4px);
    }

    .benefits-list li {
        position: relative;
        padding-left: 32px;
        margin-bottom: 16px;
        list-style: none;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .benefits-list li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 4px;
        width: 18px;
        height: 18px;
        background: var(--primary-glow);
        mask: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'%3E%3C/polyline%3E%3C/svg%3E") no-repeat center;
        mask-size: contain;
        -webkit-mask: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'%3E%3C/polyline%3E%3C/svg%3E") no-repeat center;
        -webkit-mask-size: contain;
        background-color: var(--primary);
    }
</style>

<div class="premium-wrapper">
    <div class="page-header" style="margin-bottom: 50px;">
        <div>
            <h1 class="page-title syne">Pusat Akselerasi Properti</h1>
            <p class="page-subtitle">Mitigasi Transaksi Strategis: <strong>{{ $listing->name }}</strong></p>
        </div>
        <div class="page-actions">
            <a href="{{ route('pemilik-kos.listings.index') }}" class="btn btn-outline btn-strategic">BATALKAN AKSI</a>
        </div>
    </div>

    <!-- Steps -->
    <div class="payment-steps">
        <div class="step-item completed">
            <div class="step-dot">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <span class="step-label">KONFIGURASI</span>
        </div>
        <div class="step-item active">
            <div class="step-dot">02</div>
            <span class="step-label">ALOKASI DANA</span>
        </div>
        <div class="step-item">
            <div class="step-dot">03</div>
            <span class="step-label">AUDIT SISTEM</span>
        </div>
    </div>

    <div class="two-col" style="gap: 32px; align-items: start;">
        <div class="main-form" style="flex: 1.2;">
            <div class="stat-card-premium">
                <div class="stat-icon-premium">
                    <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <div class="stat-info">
                    <div class="stat-label" style="font-weight: 800; font-size: 11px; color: var(--text-muted); letter-spacing: 1px;">INVESTASI PREMIUM AKTIF</div>
                    <div class="stat-value syne" style="font-size: 36px; font-weight: 800; color: var(--text);">Rp {{ number_format(get_setting('premium_price', 150000), 0, ',', '.') }}</div>
                    <div style="font-size: 11px; font-weight: 700; color: var(--primary); margin-top: 4px;">DURASI UTILITAS: 30 HARI SIKLUS</div>
                </div>
            </div>

            <div class="card" style="border-radius: 24px;">
                <div class="card-header">
                    <div class="card-title syne" style="font-weight: 800; font-size: 16px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>
                        DATA REKENING TUJUAN
                    </div>
                </div>
                <div class="card-body">
                    <div style="background: var(--bg); padding: 24px; border-radius: 18px; border: 1.5px solid var(--border); margin-bottom: 32px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                            <span style="font-size: 12px; color: var(--text-muted); font-weight: 800; letter-spacing: 0.5px;">IDENTITAS BANK</span>
                            <span style="font-size: 14px; font-weight: 800;">{{ get_setting('premium_bank_name', 'Bank Transfer') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                            <span style="font-size: 12px; color: var(--text-muted); font-weight: 800; letter-spacing: 0.5px;">NOMOR VIRTUAL</span>
                            <span class="syne" style="font-size: 20px; color: var(--primary); letter-spacing: 1px; font-weight: 800;">{{ get_setting('premium_bank_account', '-') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 12px; color: var(--text-muted); font-weight: 800; letter-spacing: 0.5px;">PROPRIETOR</span>
                            <span style="font-size: 14px; font-weight: 800; text-transform: uppercase; color: var(--text);">{{ get_setting('premium_bank_holder', 'PT KOS PREMIUM') }}</span>
                        </div>
                    </div>

                    <div class="benefits-section">
                        <div style="font-weight: 800; font-size: 11px; color: var(--text-muted); letter-spacing: 1px; margin-bottom: 20px;">VALUE-ADDED PROPOSITION</div>
                        <ul class="benefits-list" style="margin: 0; padding: 0;">
                            @foreach(explode("\n", get_setting('premium_benefits', "- Prioritas algoritma pencarian global\n- Atribusi badge verifikasi premium\n- Metrik analitik performa asset\n- Jalur dukungan teknis prioritas")) as $benefit)
                                @if(trim($benefit))
                                    <li>{{ ltrim(trim($benefit), '- ') }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar" style="flex: 0.8;">
            <form action="{{ route('pemilik-kos.listings.submit-premium', $listing->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card" style="border-radius: 24px;">
                    <div class="card-header">
                        <div class="card-title syne" style="font-weight: 800; font-size: 15px;">KONFIRMASI ASET</div>
                    </div>
                    <div class="card-body">
                        <label for="payment_proof" class="proof-upload-area" id="drop-area">
                            <div id="upload-idle">
                                <svg style="width: 48px; height: 48px; margin-bottom: 18px; color: var(--text-muted); opacity: 0.5;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                                <div style="font-size: 13px; font-weight: 800; margin-bottom: 6px;">SUBMIT BUKTI AUDIT</div>
                                <div style="font-size: 10px; color: var(--text-muted); font-weight: 700;">UPLOAD IMAGE/CAPTURE</div>
                            </div>
                            <div id="upload-preview" style="display: none; width: 100%; height: 100%;">
                                <img id="preview-img" src="" style="width: 100%; height: 100%; object-fit: cover;">
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 14px; background: rgba(0,0,0,0.8); backdrop-filter: blur(8px); color: white; font-size: 10px; text-align: center; font-weight: 800; letter-spacing: 1px;">PERBARUI DOKUMEN</div>
                            </div>
                            <input type="file" name="payment_proof" id="payment_proof" style="display: none;" accept="image/*" required onchange="previewDashboardProof(this)">
                        </label>

                        <div style="background: var(--bg); border: 1px solid var(--border); border-radius: 12px; padding: 12px; margin-top: 16px;">
                            <p style="font-size: 11px; color: var(--text-muted); line-height: 1.6; font-weight: 600;">
                                <span style="color: var(--warning); font-weight: 800;">CATATAN:</span> Pastikan validitas data finansial terlihat presisi untuk mempercepat otorisasi sistem.
                            </p>
                        </div>

                        <button type="submit" class="btn btn-blue btn-strategic" style="width: 100%; margin-top: 24px; height: 52px; box-shadow: 0 10px 20px rgba(var(--primary-rgb), 0.2);">
                            EKSEKUSI PEMBAYARAN
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewDashboardProof(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const idle = document.getElementById('upload-idle');
                const preview = document.getElementById('upload-preview');
                const img = document.getElementById('preview-img');
                const dropArea = document.getElementById('drop-area');
                
                img.src = e.target.result;
                idle.style.display = 'none';
                preview.style.display = 'block';
                dropArea.style.borderStyle = 'solid';
                dropArea.style.borderColor = 'var(--primary)';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

