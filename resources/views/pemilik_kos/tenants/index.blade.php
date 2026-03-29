@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Portofolio Penghuni & Kontrak</h1>
        <p class="page-subtitle">Monitoring real-time aktivitas dan validitas penghuni aktif di seluruh properti Anda</p>
    </div>
    <div class="page-actions" style="display: flex; gap: 12px; align-items: center;">
        <div style="position:relative; min-width: 250px;">
            <input type="text" placeholder="Filter identitas penghuni..." style="width:100%; padding: 10px 16px 10px 40px; background: #fff; border: 1.5px solid var(--border); border-radius: 100px; font-size: 13px; font-weight: 500;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); width:18px; height:18px; opacity:0.4;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
    </div>
</div>

<div class="card" style="border:none; box-shadow: 0 10px 40px rgba(0,0,0,0.03);">
    <div class="card-header" style="background: #fff; border-bottom: 1.5px solid var(--border); padding: 20px 24px;">
        <div class="card-title" style="font-size: 16px; font-weight: 800; font-family: 'Syne';">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--primary);"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
            Direktori Mitra Penghuni
        </div>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table style="border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th style="padding: 16px 24px; background: var(--bg); font-size: 11px; font-weight: 800; letter-spacing: 0.05em; color: var(--text-muted);">IDENTITAS PENYEWA</th>
                        <th style="padding: 16px 24px; background: var(--bg); font-size: 11px; font-weight: 800; letter-spacing: 0.05em; color: var(--text-muted);">ALOKASI ASET & UNIT</th>
                        <th style="padding: 16px 24px; background: var(--bg); font-size: 11px; font-weight: 800; letter-spacing: 0.05em; color: var(--text-muted);">KRONOLOGI AKTIVASI</th>
                        <th style="padding: 16px 24px; background: var(--bg); font-size: 11px; font-weight: 800; letter-spacing: 0.05em; color: var(--text-muted);">STATUS FINANSIAL</th>
                        <th style="padding: 16px 24px; background: var(--bg); text-align: right; padding-right: 32px;">MANAJEMEN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tenants as $trx)
                        <tr style="transition: 0.2s;">
                            <td style="padding: 20px 24px;">
                                <div class="user-cell">
                                    <div class="user-av" style="background: var(--primary-glow); color: var(--primary); width: 44px; height: 44px; font-family: 'Syne'; font-weight: 800; font-size: 18px; border-radius: 12px; border: 1.5px solid rgba(var(--primary-rgb), 0.1);">
                                        {{ strtoupper(substr($trx->user->name, 0, 1)) }}
                                    </div>
                                    <div class="user-info">
                                        <div style="font-size: 15px; font-weight: 800; color: var(--text);">{{ $trx->user->name }}</div>
                                        <div style="font-size: 12px; color: var(--text-muted);">{{ $trx->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--text); font-size: 14px;">{{ $trx->listing->name }}</div>
                                @if($trx->room)
                                    <div style="display: inline-flex; align-items: center; gap: 6px; margin-top: 6px; padding: 4px 10px; background: rgba(var(--primary-rgb), 0.05); color: var(--primary); border-radius: 6px; font-size: 11px; font-weight: 800;">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="3"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/></svg>
                                        UNIT: {{ $trx->room->room_number }}
                                    </div>
                                @else
                                    <div style="font-size: 11px; color: var(--text-muted); font-style: italic; margin-top: 4px;">Unit belum ditetapkan</div>
                                @endif
                            </td>
                            <td>
                                <div style="font-size: 13px; font-weight: 700; color: var(--text);">{{ $trx->created_at->format('d M Y') }}</div>
                                <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Terdaftar otomatis via TRX</div>
                            </td>
                            <td>
                                <div style="font-size: 15px; font-weight: 800; color: var(--success);">Rp {{ number_format($trx->amount, 0, ',', '.') }}</div>
                                <div style="font-size: 10px; color: var(--text-muted); font-weight: 700; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $trx->payment_method ?? 'TRANSFER' }} • SUCCESS</div>
                            </td>
                            <td style="text-align: right; padding-right: 32px;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <a href="{{ route('pemilik-kos.inquiries.index', ['user_id' => $trx->user_id]) }}" class="circle-btn" style="width: 38px; height: 38px; border-radius: 10px; border: 1.5px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); transition: 0.2s;" title="Kirim Pesan">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 11-7.6-11.7 8.38 8.38 0 013.8.9L21 3.5l-2.1 4.7z"/></svg>
                                    </a>
                                    <a href="{{ route('pemilik-kos.transactions.show', $trx->id) }}" class="circle-btn" style="width: 38px; height: 38px; border-radius: 10px; border: 1.5px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); transition: 0.2s;" title="Detail Transaksi">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19H6a2 2 0 01-2-2V7a2 2 0 012-2h11a2 2 0 012 2v3m-7 8l-4-4m4 4l4-4m-4 4V1"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 100px 24px;">
                                <div style="width: 80px; height: 80px; background: var(--bg); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                                    <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity: 0.2;"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                </div>
                                <h3 style="font-size: 20px; font-weight: 800; color: var(--text); font-family: 'Syne'; margin-bottom: 8px;">Basis Data Steril</h3>
                                <p style="color: var(--text-muted); font-size: 14px; max-width: 300px; margin: 0 auto;">Seluruh entitas yang telah memvalidasi okupansi akan terdaftar secara otomatis di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .circle-btn:hover {
        background: var(--primary);
        border-color: var(--primary) !important;
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.3);
        transform: translateY(-2px);
    }
    .table-wrap table tr:last-child td { border-bottom: none; }
    .table-wrap table td { border-bottom: 1px solid var(--border); }
</style>
@endsection
