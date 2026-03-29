@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Validasi Transaksi Strategis</h1>
        <p class="page-subtitle">Protokol Keamanan: Selesaikan Pembayaran untuk Aktivasi Hunian</p>
    </div>
    <div class="page-actions">
        <div class="badge badge-amber" style="border-radius: 100px; padding: 10px 20px; font-weight: 800; font-size: 11px; letter-spacing: 0.05em;">
            <span class="badge-dot"></span> MENUNGGU VERIFIKASI
        </div>
    </div>
</div>

<div class="two-col" style="gap: 32px;">
    <div class="dashboard-main">
        <div class="card">
            <div class="card-header">
                <div class="card-title" style="font-family: 'Syne'; font-weight: 800;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    Instruksi Pembayaran Strategis
                </div>
            </div>
            <div class="card-body" style="padding: 40px;">
                <div style="padding: 32px; background: rgba(var(--primary-rgb), 0.03); border: 2px dashed rgba(var(--primary-rgb), 0.2); border-radius: 24px; margin-bottom: 40px; text-align: center;">
                    <div style="font-size: 11px; color: var(--text-muted); font-weight: 800; letter-spacing: 0.1em; margin-bottom: 12px; opacity: 0.7;">TOTAL AKUMULASI TRANSFER</div>
                    <div style="font-family: 'Syne'; font-weight: 800; font-size: 42px; color: var(--primary); letter-spacing: -0.02em;">Rp {{ number_format($transaction->amount + 50000, 0, ',', '.') }}</div>
                    <div style="font-size: 10px; font-weight: 800; color: var(--text-muted); margin-top: 12px; font-family: 'Syne'; letter-spacing: 0.05em; background: #f3f4f6; display: inline-block; padding: 4px 12px; border-radius: 100px;">{{ strtoupper($transaction->id) }}</div>
                </div>

                <h4 style="font-weight: 800; font-family: 'Syne'; font-size: 18px; margin-bottom: 24px;">Metode Transfer Terverifikasi:</h4>
                <div class="payment-methods" style="display: grid; gap: 16px; margin-bottom: 40px;">
                    <div style="padding: 20px; border: 1px solid var(--border); border-radius: 20px; display: flex; align-items: center; gap: 20px; background: #fff; transition: all 0.3s;" class="method-card">
                        <div style="width: 56px; height: 56px; background: #f3f4f6; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 18px; color: #1e3a8a; font-family: 'Syne';">BCA</div>
                        <div>
                            <div style="font-weight: 800; font-size: 11px; color: var(--text-muted); letter-spacing: 0.05em;">PT KOS ADMIN PROPERTY</div>
                            <div style="font-size: 18px; font-weight: 800; font-family: 'Syne'; color: var(--text); letter-spacing: 0.05em;">123-456-7890</div>
                        </div>
                        <div style="margin-left: auto; opacity: 0.3;">📋</div>
                    </div>
                    <div style="padding: 20px; border: 1px solid var(--border); border-radius: 20px; display: flex; align-items: center; gap: 20px; background: #fff; transition: all 0.3s;" class="method-card">
                        <div style="width: 56px; height: 56px; background: #f3f4f6; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 18px; color: #ea580c; font-family: 'Syne';">BNI</div>
                        <div>
                            <div style="font-weight: 800; font-size: 11px; color: var(--text-muted); letter-spacing: 0.05em;">PT KOS ADMIN PROPERTY</div>
                            <div style="font-size: 18px; font-weight: 800; font-family: 'Syne'; color: var(--text); letter-spacing: 0.05em;">098-765-4321</div>
                        </div>
                        <div style="margin-left: auto; opacity: 0.3;">📋</div>
                    </div>
                    <div style="padding: 20px; border: 1px solid var(--border); border-radius: 20px; display: flex; align-items: center; gap: 20px; background: #fff; transition: all 0.3s;" class="method-card">
                        <div style="width: 56px; height: 56px; background: #f3f4f6; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 12px; color: #8b5cf6; font-family: 'Syne'; text-align: center; line-height: 1;">E-WALLET<br><span style="font-size: 8px;">QRIS</span></div>
                        <div>
                            <div style="font-weight: 800; font-size: 11px; color: var(--text-muted); letter-spacing: 0.05em;">GOPAY / OVO / DANA</div>
                            <div style="font-size: 18px; font-weight: 800; font-family: 'Syne'; color: var(--text); letter-spacing: 0.05em;">0812-3456-7890</div>
                        </div>
                        <div style="margin-left: auto; opacity: 0.3;">📋</div>
                    </div>
                </div>

                <div class="alert alert-amber" style="margin-bottom: 0; border-radius: 100px; padding: 12px 24px; font-size: 12px; font-weight: 700;">
                    <span style="font-weight: 900; letter-spacing: 0.05em;">SECURITY NOTICE:</span> Mohon lampirkan bukti fisik digital untuk memproses validasi sewa secara otomatis.
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-sidebar">
        <div class="card" style="border: 2px solid var(--primary); box-shadow: 0 30px 60px -15px rgba(var(--primary-rgb), 0.2);">
            <div class="card-header" style="border-bottom: 1px dashed var(--border);">
                <div class="card-title" style="font-family: 'Syne'; font-weight: 800;">Upload Manifes Bukti</div>
            </div>
            <div class="card-body" style="padding: 32px;">
                <form action="{{ route('pencari-kos.payments.upload', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="border: 3px dashed var(--border); border-radius: 24px; padding: 48px 24px; text-align: center; position: relative; transition: all 0.4s; cursor: pointer; background: #f9fafb;" onclick="document.getElementById('payment_proof').click()" onmouseover="this.style.borderColor='var(--primary)'; this.style.background='rgba(var(--primary-rgb), 0.02)';" onmouseout="this.style.borderColor='var(--border)'; this.style.background='#f9fafb';">
                        <input type="file" name="payment_proof" id="payment_proof" style="display: none;" onchange="this.form.submit()">
                        <div style="font-size: 60px; margin-bottom: 24px; filter: drop-shadow(0 10px 10px rgba(0,0,0,0.1));">📄</div>
                        <h4 style="font-weight: 800; font-family: 'Syne'; font-size: 18px; margin-bottom: 8px;">Unggah Bukti Fisik</h4>
                        <p style="font-size: 12px; color: var(--text-muted); font-weight: 600; opacity: 0.7;">FORMAT: JPG, PNG, WEBP (MAX. 2MB)</p>
                        
                        <div style="margin-top: 32px; padding: 12px 24px; background: var(--primary); color: #fff; border-radius: 100px; font-size: 11px; font-weight: 800; letter-spacing: 0.05em; display: inline-block;">PILIH BERKAS SEKARANG</div>
                    </div>
                    
                    <div style="margin-top: 32px; padding: 16px; background: rgba(16, 185, 129, 0.05); border-radius: 16px; border: 1px solid rgba(16, 185, 129, 0.1); display: flex; gap: 12px; align-items: flex-start;">
                        <div style="font-size: 18px;">✨</div>
                        <p style="font-size: 11px; line-height: 1.6; color: #065f46; font-weight: 700;">
                            Sistem secara otomatis mengonversi bukti Anda ke format <strong style="text-decoration: underline;">WebP</strong> untuk optimasi arsip digital yang efisien.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .method-card:hover {
        border-color: var(--primary);
        transform: scale(1.02);
        box-shadow: 0 10px 20px -5px rgba(0,0,0,0.05);
    }
</style>
@endsection
