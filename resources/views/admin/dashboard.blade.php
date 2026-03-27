@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard Overview</h1>
        <p class="page-subtitle">Selamat datang kembali, {{ auth()->user()->name }}</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('admin.analytics') }}" class="btn btn-outline">Lihat Laporan Lengkap</a>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ number_format($total_users) }}</div>
            <div class="stat-label">Total Pengguna</div>
            <div class="stat-change {{ $user_change >= 0 ? 'up' : 'down' }}">
                {{ $user_change >= 0 ? '+' : '' }}{{ $user_change }}% vs bln lalu
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ number_format($total_listings) }}</div>
            <div class="stat-label">Total Listing</div>
            <div class="stat-change up">+{{ $recent_listings_count }} listing baru</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-value">Rp {{ number_format($monthly_revenue / 1000000, 1) }}jt</div>
            <div class="stat-label">Estimasi Pendapatan</div>
            <div class="stat-change up">Target {{ $revenue_perc }}% tercapai</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $pending_reports }}</div>
            <div class="stat-label">Laporan Pending</div>
            <div class="stat-change {{ $pending_reports > 0 ? 'down' : 'up' }}">
                {{ $pending_reports > 0 ? 'Perlu tindakan segera' : 'Sistem aman' }}
            </div>
        </div>
    </div>
</div>

<div class="two-col">
    <!-- Bar Chart -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="12" width="4" height="9"/><rect x="10" y="7" width="4" height="14"/><rect x="17" y="3" width="4" height="18"/></svg>
                Registrasi Pengguna (6 Bulan)
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" id="bar-chart"></div>
        </div>
    </div>

    <!-- Donut Chart -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.21 15.89A10 10 0 118 2.83M22 12A10 10 0 0012 2v10z"/></svg>
                Distribusi User
            </div>
        </div>
        <div class="card-body">
            <div class="donut-wrap">
                <div class="donut-svg">
                    @php
                        $sPerc = round(($distribution['seekers'] / $distribution['total']) * 100);
                        $oPerc = round(($distribution['owners'] / $distribution['total']) * 100);
                        $aPerc = 100 - $sPerc - $oPerc;
                    @endphp
                    <svg viewBox="0 0 36 36">
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="var(--primary-glow)" stroke-width="3" />
                        <!-- Seekers (Blue) -->
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="var(--primary)" stroke-width="3" stroke-dasharray="{{ $sPerc }}, 100" />
                        <!-- Owners (Green) -->
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="var(--success)" stroke-width="3" stroke-dasharray="{{ $oPerc }}, 100" stroke-dashoffset="-{{ $sPerc }}" />
                        <!-- Admins (Amber) -->
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="var(--warning)" stroke-width="3" stroke-dasharray="{{ $aPerc }}, 100" stroke-dashoffset="-{{ $sPerc + $oPerc }}" />
                        <text x="18" y="20.35" font-size="6" text-anchor="middle" font-weight="700" fill="var(--text)">{{ number_format($distribution['total']) }}</text>
                    </svg>
                </div>
                <div class="donut-legend">
                    <div class="legend-item"><span class="legend-dot" style="background:var(--primary);"></span><span>Pencari {{ $sPerc }}%</span></div>
                    <div class="legend-item"><span class="legend-dot" style="background:var(--success);"></span><span>Pemilik {{ $oPerc }}%</span></div>
                    <div class="legend-item"><span class="legend-dot" style="background:var(--warning);"></span><span>Admin {{ $aPerc }}%</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Table -->
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            Tabel Aktivitas Terbaru
        </div>
        <button class="btn btn-sm btn-outline" onclick="showToast('info','Navigasi ke log audit...')">Lihat Semua</button>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>USER</th>
                        <th>AKSI</th>
                        <th>WAKTU</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $act)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-av" style="background:var(--{{ $act['badge'] }}); opacity: 0.8;">{{ $act['initials'] }}</div>
                                <div class="user-info"><strong>{{ $act['name'] }}</strong><span>{{ $act['type'] }}</span></div>
                            </div>
                        </td>
                        <td>{{ $act['action'] }}</td>
                        <td>{{ $act['time'] }}</td>
                        <td><span class="badge badge-{{ $act['badge'] }}"><span class="badge-dot"></span>{{ $act['status'] }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    window.onload = () => {
        const trends = @json($registration_trends);
        if(typeof renderBarChart === 'function') {
            renderBarChart(trends);
        }
    };
</script>
@endsection
