@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Laporan Finansial & Arus Kas</h1>
        <p class="page-subtitle">Analisis komprehensif revenue dan rekonsiliasi pembayaran bisnis Anda</p>
    </div>
    <div class="page-actions">
        <button class="btn btn-outline" style="border-radius: 100px; padding: 10px 20px; font-weight: 800; font-size: 11px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px; height:18px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            REKONSILIASI DATA (CSV)
        </button>
    </div>
</div>

<div class="stats-grid" style="margin-bottom: 32px; grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card" style="background: linear-gradient(135deg, var(--primary), #4f46e5); border: none;">
        <div class="stat-body">
            <div class="stat-label" style="color: rgba(255,255,255,0.7);">AKUMULASI REVENUE</div>
            <div class="stat-value" style="color: #fff; font-size: 28px; font-family: 'Syne'; font-weight: 800;">Rp {{ number_format($transactions->where('status', 'Success')->sum('amount'), 0, ',', '.') }}</div>
            <div style="margin-top: 12px; font-size: 11px; color: rgba(255,255,255,0.6); font-weight: 700;">KONSOLIDASI SELURUH UNIT AKTIF</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-body">
            <div class="stat-label">REVENUE PERIODE BERJALAN</div>
            <div class="stat-value" style="font-size: 24px;">Rp {{ number_format($transactions->where('status', 'Success')->where('created_at', '>=', now()->startOfMonth())->sum('amount'), 0, ',', '.') }}</div>
            <div class="stat-trend trend-up" style="font-weight: 700; font-size: 11px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="width:12px;"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                +{{ $transactions->where('status', 'Success')->where('created_at', '>=', now()->startOfMonth())->count() }} OPERASI SUKSES
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-body">
            <div class="stat-label">AVERAGE TICKET SIZE</div>
            @php 
                $successCount = $transactions->where('status', 'Success')->count();
                $avg = $successCount > 0 ? $transactions->where('status', 'Success')->sum('amount') / $successCount : 0;
            @endphp
            <div class="stat-value" style="font-size: 24px;">Rp {{ number_format($avg, 0, ',', '.') }}</div>
            <div style="font-size: 11px; color: var(--text-muted); font-weight: 600; margin-top: 8px;">OPTIMASI DATA HISTORIS</div>
        </div>
    </div>
</div>

<div class="card" style="border:none; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
    <div class="card-header" style="background: #fff; border-bottom: 1.5px solid var(--border); padding: 20px 24px;">
        <div class="card-title" style="font-size: 16px; font-weight: 800;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--success);"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            Rincian Transaksi Strategis
        </div>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table style="border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th style="padding: 16px 24px; background: var(--bg); font-size: 11px; font-weight: 800; letter-spacing: 0.05em; color: var(--text-muted);">IDENTIFIKASI REF</th>
                        <th style="padding: 16px 24px; background: var(--bg); font-size: 11px; font-weight: 800; letter-spacing: 0.05em; color: var(--text-muted);">PENGGUNA / PENYEWA</th>
                        <th style="padding: 16px 24px; background: var(--bg); font-size: 11px; font-weight: 800; letter-spacing: 0.05em; color: var(--text-muted);">OBJEK ASET</th>
                        <th style="padding: 16px 24px; background: var(--bg); font-size: 11px; font-weight: 800; letter-spacing: 0.05em; color: var(--text-muted);">VALUASI</th>
                        <th style="padding: 16px 24px; background: var(--bg); font-size: 11px; font-weight: 800; letter-spacing: 0.05em; color: var(--text-muted);">STATUS OPERASI</th>
                        <th style="padding: 16px 24px; background: var(--bg); text-align: right; padding-right: 32px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr class="trx-row" style="transition: 0.2s;">
                            <td style="padding: 16px 24px;">
                                <div style="font-family: 'JetBrains Mono', monospace; font-size: 12px; font-weight: 700; color: var(--primary);">#{{ strtoupper(substr($transaction->id, 0, 8)) }}</div>
                                <div style="font-size: 10px; color: var(--text-muted); margin-top: 4px;">{{ $transaction->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-av" style="background: var(--bg); color: var(--text-muted); width: 36px; height: 36px; font-weight: 700; border-radius: 10px;">
                                        {{ strtoupper(substr($transaction->user->name, 0, 1)) }}
                                    </div>
                                    <div class="user-info">
                                        <strong style="font-size: 14px; color: var(--text);">{{ $transaction->user->name }}</strong>
                                        <span style="font-size: 11px;">{{ $transaction->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 13px; font-weight: 700; color: var(--text);">{{ $transaction->listing->name }}</div>
                                @if($transaction->room)
                                    <div style="font-size: 11px; color: var(--primary); font-weight: 800; margin-top: 2px;">Unit: {{ $transaction->room->room_number }}</div>
                                @endif
                            </td>
                            <td>
                                <div style="font-size: 15px; font-weight: 800; color: var(--text);">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</div>
                                <div style="font-size: 10px; color: var(--text-muted); margin-top: 4px;">Via {{ $transaction->payment_method ?? 'Manual Transfer' }}</div>
                            </td>
                            <td>
                                @if($transaction->status === 'Success')
                                    <span class="badge" style="background: rgba(34, 197, 94, 0.08); color: #16a34a; border: 1.5px solid rgba(34, 197, 94, 0.2); font-weight: 800; font-size: 10px; letter-spacing: 0.5px;">
                                        <span style="display:inline-block; width:6px; height:6px; background:#16a34a; border-radius:50%; margin-right:6px;"></span>SUCCESS
                                    </span>
                                @elseif($transaction->status === 'Pending')
                                    <span class="badge" style="background: rgba(245, 158, 11, 0.08); color: #d97706; border: 1.5px solid rgba(245, 158, 11, 0.2); font-weight: 800; font-size: 10px; letter-spacing: 0.5px;">
                                        <span style="display:inline-block; width:6px; height:6px; background:#d97706; border-radius:50%; margin-right:6px;"></span>PENDING
                                    </span>
                                @else
                                    <span class="badge" style="background: rgba(239, 68, 68, 0.08); color: #dc2626; border: 1.5px solid rgba(239, 68, 68, 0.2); font-weight: 800; font-size: 10px; letter-spacing: 0.5px;">
                                        <span style="display:inline-block; width:6px; height:6px; background:#dc2626; border-radius:50%; margin-right:6px;"></span>FAILED
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: right; padding-right: 32px;">
                                <a href="{{ route('pemilik-kos.transactions.show', $transaction->id) }}" class="btn btn-outline btn-sm" style="border-radius: 100px; font-weight: 700; font-size: 11px;">Struk / Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 100px 24px;">
                                <div style="width: 80px; height: 80px; background: var(--bg); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                                    <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity: 0.2;"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                </div>
                                <h3 style="font-size: 20px; font-weight: 800; color: var(--text); font-family: 'Syne'; margin-bottom: 8px;">Tidak Ada Data</h3>
                                <p style="color: var(--text-muted); font-size: 14px; max-width: 300px; margin: 0 auto;">Riwayat transaksi keuangan Anda akan muncul di sini secara otomatis.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .trx-row:hover {
        background: rgba(var(--bg-rgb), 0.5);
    }
    .table-wrap table tr:last-child td {
        border-bottom: none;
    }
    .table-wrap table td {
        border-bottom: 1px solid var(--border);
    }
</style>
@endsection
