@extends('layouts.admin')

@section('content')
    <div class="page-header" style="margin-bottom: 40px;">
        <div>
            <h1 class="page-title" style="font-family: 'Syne'; font-weight: 800; font-size: 32px; letter-spacing: -0.5px;">Dashboard Strategis</h1>
            <p class="page-subtitle" style="font-size: 15px; opacity: 0.8;">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>. Pantau portfolio hunian Anda.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('pencari-kos.discovery.index') }}" class="btn btn-primary"
                style="border-radius: 100px; font-weight: 800; font-size: 11px; padding: 14px 28px; box-shadow: 0 10px 20px rgba(var(--primary-rgb), 0.2);">EKSPLORASI HUNIAN SEKARANG</a>
        </div>
    </div>

    <!-- Stats Grid with Premium Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Active Booking -->
        <div class="card stat-card-premium" style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); color: #fff; border: none; position: relative; overflow: hidden;">
            <div style="position: absolute; top: -20px; right: -20px; font-size: 120px; opacity: 0.1; font-weight: 800;">01</div>
            <div class="card-body" style="padding: 32px; position: relative; z-index: 1;">
                <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/></svg>
                </div>
                <div style="font-size: 36px; font-weight: 800; font-family: 'Syne'; line-height: 1;">{{ $stats['active_bookings'] }}</div>
                <div style="font-size: 11px; font-weight: 800; opacity: 0.8; letter-spacing: 1px; margin-top: 8px;">HUNIAN AKTIF</div>
            </div>
        </div>

        <!-- Favorites -->
        <div class="card stat-card-premium" style="background: #fff; border: 1px solid var(--border); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
            <div class="card-body" style="padding: 32px;">
                <div style="width: 48px; height: 48px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                </div>
                <div style="font-size: 36px; font-weight: 800; font-family: 'Syne'; color: var(--text); line-height: 1;">{{ $stats['favorites_count'] }}</div>
                <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); letter-spacing: 1px; margin-top: 8px;">LISTING FAVORIT</div>
            </div>
        </div>

        <!-- Pending/Action -->
        <div class="card stat-card-premium" style="background: #fff; border: 1px solid var(--border); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
            <div class="card-body" style="padding: 32px;">
                <div style="width: 48px; height: 48px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                </div>
                <div style="font-size: 36px; font-weight: 800; font-family: 'Syne'; color: var(--text); line-height: 1;">{{ $stats['pending_payments'] }}</div>
                <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); letter-spacing: 1px; margin-top: 8px;">TAGIHAN PENDING</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Activity List -->
        <div class="lg:col-span-2">
            <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(var(--primary-rgb), 0.04);">
                <div class="card-header" style="padding: 24px 32px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-family: 'Syne'; font-weight: 800; font-size: 18px; color: var(--text);">Manifes Booking Terkini</h3>
                    <a href="{{ route('pencari-kos.history.index') }}" style="font-size: 11px; font-weight: 800; color: var(--primary); text-decoration: none;">LIHAT SEMUA →</a>
                </div>
                <div class="card-body" style="padding:0;">
                    <div class="table-wrap">
                        <table style="width: 100%;">
                            <thead>
                                <tr style="background: #fafafa;">
                                    <th style="padding: 16px 32px; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Aset Properti</th>
                                    <th style="padding: 16px 32px; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Check-in / Tenor</th>
                                    <th style="padding: 16px 32px; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Status</th>
                                    <th style="padding: 16px 32px; font-size: 11px; color: var(--text-muted); text-transform: uppercase; text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_bookings as $booking)
                                    <tr style="border-bottom: 1px solid #f3f4f6;">
                                        <td style="padding: 24px 32px;">
                                            <div style="display: flex; align-items: center; gap: 16px;">
                                                <div style="width: 44px; height: 44px; background: var(--bg); border: 1px solid var(--border); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--primary); font-family: 'Syne';">
                                                    {{ substr($booking->listing->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div style="font-weight: 800; font-size: 14px; color: var(--text);">{{ $booking->listing->name }}</div>
                                                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">{{ $booking->listing->city }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 24px 32px;">
                                            <div style="font-weight: 700; font-size: 13px;">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</div>
                                            <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">{{ $booking->duration_months }} Bulan</div>
                                        </td>
                                        <td style="padding: 24px 32px;">
                                            @if($booking->status === 'Pending')
                                                <span class="badge badge-amber" style="padding: 6px 12px; border-radius: 6px; font-size: 10px;"><span class="badge-dot"></span> PENDING REVIEW</span>
                                            @elseif(in_array($booking->status, ['Paid', 'Active', 'Success']))
                                                <span class="badge badge-emerald" style="padding: 6px 12px; border-radius: 6px; font-size: 10px;"><span class="badge-dot"></span> TERVERIFIKASI</span>
                                            @else
                                                <span class="badge badge-slate" style="padding: 6px 12px; border-radius: 6px; font-size: 10px;">{{ strtoupper($booking->status) }}</span>
                                            @endif
                                        </td>
                                        <td style="padding: 24px 32px; text-align: right;">
                                            <a href="{{ route('pencari-kos.history.show', $booking->id) }}" class="btn-icon">
                                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center; padding: 60px; color: var(--text-muted);">
                                            <div style="font-size: 32px; margin-bottom: 16px;">🔍</div>
                                            <div style="font-weight: 700;">Belum ada manifest booking.</div>
                                            <div style="font-size: 12px; margin-top: 4px;">Mulailah dengan mengeksplorasi pilihan properti terbaik kami.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side CTA/Help -->
        <div>
            <div class="card" style="background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%); border: none; border-radius: 20px; padding: 40px; color: #fff; text-align: center; overflow: hidden; position: relative; margin-bottom: 24px;">
                <div style="position: absolute; width: 200px; height: 200px; border-radius: 50%; background: rgba(255,255,255,0.05); top: -100px; right: -100px;"></div>
                <div style="position: relative; z-index: 1;">
                    <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                    </div>
                    <h3 style="font-family: 'Syne'; font-weight: 800; font-size: 20px; line-height: 1.2; margin-bottom: 16px;">Siap Menemukan Hunian Baru?</h3>
                    <p style="font-size: 13px; opacity: 0.7; margin-bottom: 32px; line-height: 1.6;">Akses daftar eksklusif hunian kos premium yang telah melalui proses validasi audit ketat.</p>
                    <a href="{{ route('pencari-kos.discovery.index') }}" class="btn" style="background: #fff; color: #1e1b4b; border: none; border-radius: 100px; font-weight: 800; padding: 14px 32px; width: 100%;">MULAI CARI KOS</a>
                </div>
            </div>

            <div class="card" style="border-radius: 20px; border: 1px solid var(--border); box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                <div class="card-body" style="padding: 24px;">
                    <h4 style="font-family: 'Syne'; font-weight: 800; font-size: 15px; margin-bottom: 16px;">Bantuan & Panduan</h4>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <a href="#" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--text); font-size: 13px; font-weight: 600; padding: 12px; border-radius: 12px; background: #fafafa;">
                            <div style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; color: var(--primary);">📖</div>
                            Panduan Penyewa Baru
                        </a>
                        <a href="#" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--text); font-size: 13px; font-weight: 600; padding: 12px; border-radius: 12px; background: #fafafa;">
                            <div style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; color: var(--primary);">🛡️</div>
                            Kebijakan Keamanan Audit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection