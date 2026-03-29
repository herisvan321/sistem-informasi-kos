@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Jejak Transaksi & Sewa</h1>
            <p class="page-subtitle">Pusat Arsip: Memantau Seluruh Aktivitas Operasional Hunian Anda</p>
        </div>
        <div class="page-actions">
            <div class="badge badge-slate"
                style="border-radius: 100px; padding: 10px 20px; font-weight: 800; font-size: 11px; letter-spacing: 0.05em;">
                TOTAL: {{ $bookings->count() }} MANIFES</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title" style="font-family: 'Syne'; font-weight: 800;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                    <polyline points="10 9 9 9 8 9" />
                </svg>
                Portofolio Booking Historis
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>PROPERTI STRATEGIS</th>
                            <th>MANIFES SEWA</th>
                            <th>VALUASI</th>
                            <th>STATUS AUDIT</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr onclick="window.location='{{ route('pencari-kos.history.show', $booking->id) }}'"
                                style="cursor: pointer;" class="hover-row">
                                <td>
                                    <div class="user-cell">
                                        <div class="user-av"
                                            style="background: var(--primary); opacity: 0.1; color: var(--primary); font-family: 'Syne'; font-weight: 800;">
                                            {{ substr($booking->listing->name, 0, 1) }}
                                        </div>
                                        <div class="user-info">
                                            <strong>{{ $booking->listing->name }}</strong>
                                            <span>{{ strtoupper($booking->listing->city) }},
                                                {{ strtoupper($booking->listing->district) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 13px; font-weight: 800; color: var(--text); font-family: 'Syne';">
                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</div>
                                    <div
                                        style="font-size: 11px; color: var(--text-muted); font-weight: 600; opacity: 0.7; margin-top: 2px;">
                                        TENOR: {{ $booking->duration_months }} BULAN</div>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: var(--primary); font-family: 'Syne'; font-size: 15px;">
                                        Rp {{ number_format($booking->amount, 0, ',', '.') }}</div>
                                    <div
                                        style="font-size: 10px; color: var(--text-muted); font-weight: 700; opacity: 0.6; margin-top: 2px;">
                                        {{ strtoupper($booking->payment_method ?? 'TRANSFER BANK') }}</div>
                                </td>
                                <td>
                                    @if($booking->status === 'Pending')
                                        <span class="badge badge-amber"><span class="badge-dot"></span> MENUNGGU VALIDASI</span>
                                    @elseif($booking->status === 'Paid' || $booking->status === 'Success')
                                        <span class="badge badge-emerald"><span class="badge-dot"></span> TERVERIFIKASI</span>
                                    @elseif($booking->status === 'Active')
                                        <span class="badge badge-primary"><span class="badge-dot"></span> SEDANG BERJALAN</span>
                                    @elseif($booking->status === 'Completed')
                                        <span class="badge badge-slate" style="background: #f3f4f6; color: #4b5563;"><span
                                                class="badge-dot"></span> SELESAI</span>
                                    @else
                                        <span class="badge badge-rose"><span class="badge-dot"></span>
                                            {{ strtoupper($booking->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pencari-kos.history.show', $booking->id) }}" class="btn-icon">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                                            stroke-width="2.5">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 100px 48px;">
                                    <div style="font-size: 80px; margin-bottom: 32px; filter: grayscale(1); opacity: 0.3;">📂
                                    </div>
                                    <h4 style="font-family: 'Syne'; font-weight: 800; font-size: 22px;">Infrastruktur Data
                                        Kosong</h4>
                                    <p
                                        style="font-size: 14px; color: var(--text-muted); margin-top: 12px; max-width: 400px; margin-left: auto; margin-right: auto; font-weight: 500;">
                                        Anda belum melakukan inisiasi booking strategis pada properti manapun di platform kami.
                                    </p>
                                    <a href="{{ route('pencari-kos.discovery.index') }}" class="btn btn-primary"
                                        style="margin-top: 32px; border-radius: 100px; padding: 14px 40px; font-weight: 800;">MULA
                                        PENYIAPAN HUNIAN</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .hover-row:hover {
            background: #f9fafb !important;
        }
    </style>
@endsection