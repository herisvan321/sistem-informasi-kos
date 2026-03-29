@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Detail Transaksi</h1>
        <p class="page-subtitle">Invoice <strong>#{{ strtoupper(substr($transaction->id, 0, 8)) }}</strong></p>
    </div>
    <div class="page-actions">
        <a href="{{ route('pemilik-kos.transactions.index') }}" class="btn btn-outline">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali
        </a>
        <button class="btn btn-blue" onclick="window.print()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:8px;"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Cetak Invoice
        </button>
    </div>
</div>

<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-body" style="padding: 64px;">
        <!-- Header Invoice -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 64px;">
            <div>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                     <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--primary); display: flex; align-items: center; justify-content: center;">
                        <svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #fff;"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/></svg>
                    </div>
                    <div style="font-size: 24px; font-weight: 800; font-family: 'Syne'; color: var(--text);">{{ get_setting('app_name', 'Kos') }}<span style="color:var(--primary);">{{ get_setting('app_name_suffix', 'Admin') }}</span></div>
                </div>
                <p style="color: var(--text-muted); font-size: 13px; line-height: 1.6;">Sistem Manajemen Properti Terpadu<br>Surabaya, Jawa Timur - Indonesia</p>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 28px; font-weight: 800; font-family: 'Syne'; color: var(--text); letter-spacing: -0.5px; line-height: 1;">INVOICE</div>
                <div style="font-size: 14px; font-weight: 700; color: var(--primary); margin-top: 8px;">#{{ strtoupper(substr($transaction->id, 0, 12)) }}</div>
                <div style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">{{ $transaction->created_at->format('d M Y, H:i') }}</div>
            </div>
        </div>

        <!-- Info Grid -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; margin-bottom: 48px; padding: 32px; background: var(--bg); border-radius: 16px; border: 1px solid var(--border);">
            <div>
                <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 12px; letter-spacing: 1px;">Dibayar Oleh (Penyewa)</div>
                <div style="font-size: 16px; font-weight: 800; color: var(--text);">{{ $transaction->user->name }}</div>
                <div style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">{{ $transaction->user->email }}</div>
                <div style="display: inline-flex; align-items: center; gap: 6px; margin-top: 12px; font-size: 12px; font-weight: 700; color: var(--success); background: rgba(var(--success-rgb), 0.1); padding: 4px 10px; border-radius: 20px;">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: var(--success);"></span> Verified Tenant
                </div>
            </div>
            <div>
                <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 12px; letter-spacing: 1px;">Properti Terkait</div>
                <div style="font-size: 16px; font-weight: 800; color: var(--text);">{{ $transaction->listing->name }}</div>
                <div style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">{{ $transaction->listing->city }}, {{ $transaction->listing->district }}</div>
                <div style="font-size: 13px; color: var(--primary); font-weight: 700; margin-top: 8px;">Tipe: {{ $transaction->listing->type }}</div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-wrap" style="margin-bottom: 48px; border: 1px solid var(--border); border-radius: 12px; overflow: hidden;">
            <table style="margin: 0;">
                <thead>
                    <tr style="background: var(--surface2);">
                        <th style="padding: 16px 24px;">Deskripsi Tagihan</th>
                        <th style="padding: 16px 24px; text-align: center;">Metode</th>
                        <th style="padding: 16px 24px; text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 24px 24px;">
                            <div style="font-size: 15px; font-weight: 800; color: var(--text);">Sewa Unit Properti</div>
                            <div style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">Pembayaran untuk bulan berjalan ketersediaan unit sewa.</div>
                        </td>
                        <td style="padding: 24px 24px; text-align: center;">
                            <span class="badge badge-outline">{{ $transaction->payment_method ?? 'Transfer Bank' }}</span>
                        </td>
                        <td style="padding: 24px 24px; text-align: right;">
                            <strong style="font-size: 16px; color: var(--text);">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div style="display: flex; justify-content: flex-end;">
            <div style="width: 320px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;">
                    <span style="color: var(--text-muted); font-weight: 500;">Subtotal</span>
                    <span style="font-weight: 700; color: var(--text);">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 24px; font-size: 14px;">
                    <span style="color: var(--text-muted); font-weight: 500;">Biaya Admin & Pajak</span>
                    <span style="font-weight: 700; color: var(--text);">Rp 0</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 24px 0; border-top: 2px solid var(--border);">
                    <span style="font-size: 18px; font-weight: 800; font-family: 'Syne'; color: var(--text);">Total Bayar</span>
                    <span style="font-size: 18px; font-weight: 800; font-family: 'Syne'; color: var(--primary);">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                </div>
                @if($transaction->status === 'Pending' && $transaction->payment_proof)
                <div style="margin-top: 32px; padding: 24px; background: rgba(var(--amber-rgb), 0.05); border: 1px solid rgba(var(--amber-rgb), 0.2); border-radius: 16px;">
                    <div style="font-size: 11px; font-weight: 800; color: var(--amber); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; text-align: center;">Verifikasi Pembayaran</div>
                    <div style="margin-bottom: 24px; border-radius: 12px; overflow: hidden; border: 1px solid var(--border);">
                        <img src="{{ asset('storage/' . $transaction->payment_proof) }}" alt="Bukti Bayar" style="width: 100%; height: auto; display: block;">
                        <div style="padding: 10px; background: #fff; text-align: center;">
                            <a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank" style="font-size: 11px; font-weight: 700; color: var(--primary); text-decoration: none;">PERBESAR GAMBAR</a>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <form action="{{ route('pemilik-kos.transactions.approve', $transaction->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="width: 100%; border-radius: 100px; font-size: 11px; padding: 12px; font-weight: 800;">TERIMA</button>
                        </form>
                        <form action="{{ route('pemilik-kos.transactions.reject', $transaction->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline" style="width: 100%; border-radius: 100px; font-size: 11px; padding: 12px; font-weight: 800; color: #ef4444; border-color: #fecaca;">TOLAK</button>
                        </form>
                    </div>
                </div>
                @elseif(in_array($transaction->status, ['Paid', 'Active', 'Success']))
                <div style="margin-top: 24px; padding: 16px; background: rgba(var(--success-rgb), 0.05); border: 1px solid rgba(var(--success-rgb), 0.2); border-radius: 12px; text-align: center;">
                    <div style="font-size: 12px; font-weight: 800; color: var(--success); text-transform: uppercase; letter-spacing: 1px;">Status Konfirmasi</div>
                    <div style="font-size: 16px; font-weight: 800; color: var(--success); margin-top: 4px;">Diverifikasi / Lunas</div>
                </div>
                @else
                <div style="margin-top: 24px; padding: 16px; background: var(--bg); border: 1px solid var(--border); border-radius: 12px; text-align: center;">
                    <div style="font-size: 12px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">Status: {{ strtoupper($transaction->status) }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div style="margin-top: 80px; padding-top: 32px; border-top: 1px dashed var(--border); text-align: center;">
            <p style="font-size: 13px; font-weight: 600; color: var(--text);">Invoice ini sah secara sistem dan tidak memerlukan tanda tangan basah.</p>
            <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Jika ada pertanyaan, silakan hubungi dukungan pelanggan kami atau pemilik properti terkait.</p>
        </div>
    </div>
</div>

<style>
    @media print {
        .page-header, .topnav, #app > nav, .btn { display: none !important; }
        body { background: white !important; }
        .card { border: none !important; box-shadow: none !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; }
        .card-body { padding: 0 !important; }
    }
</style>
@endsection
