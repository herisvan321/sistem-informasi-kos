@extends('layouts.admin')
@section('content')
<!-- =============================================
         PAGE: LAPORAN & ANALITIK
    ============================================= -->
    <div id="page-analytics">
      <div class="page-header">
        <div>
          <div class="page-title">Laporan & Analitik</div>
          <div class="page-subtitle">Pantau statistik, transaksi, dan performa platform</div>
        </div>
        <button class="btn btn-blue" onclick="showToast('success','Data berhasil diekspor ke CSV!')">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Export Data
        </button>
      </div>

      <!-- Top metrics -->
      <div class="stats-grid" style="margin-bottom:20px;">
        <div class="stat-card">
          <div class="stat-icon blue"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
          <div class="stat-info"><div class="stat-value">{{ number_format($total_users) }}</div><div class="stat-label">Pengguna Aktif</div><div class="stat-change up">↑ 14% dari kemarin</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon green"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div>
          <div class="stat-info"><div class="stat-value">{{ $total_transactions }}</div><div class="stat-label">Transaksi Bulan Ini</div><div class="stat-change up">↑ 9.6%</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon amber"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div>
          <div class="stat-info"><div class="stat-value">Rp {{ number_format($monthly_revenue / 1000000, 1) }}jt</div><div class="stat-label">Total Revenue</div><div class="stat-change up">↑ 12.4%</div></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon red"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>
          <div class="stat-info"><div class="stat-value">{{ $uptime }}</div><div class="stat-label">Uptime Platform</div><div class="stat-change up">Stabil</div></div>
        </div>
      </div>

      <!-- Revenue & Platform metrics -->
      <div class="two-col">
        <div class="card">
          <div class="card-header">
            <div class="card-title">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="12" width="4" height="9"/><rect x="10" y="7" width="4" height="14"/><rect x="17" y="3" width="4" height="18"/></svg>
              Revenue Bulanan ({{ date('Y') }})
            </div>
          </div>
          <div class="card-body">
            <div class="chart-area" id="revenue-chart"></div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <div class="card-title">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
              Performa Platform
            </div>
          </div>
          <div class="card-body">
            <div class="metric-row">
              <span class="metric-label">Response Time Rata-rata</span>
              <span class="metric-val" style="color:var(--success);">142ms</span>
            </div>
            <div class="metric-row">
              <span class="metric-label">Error Rate</span>
              <span class="metric-val" style="color:var(--success);">0.13%</span>
            </div>
            <div class="metric-row">
              <span class="metric-label">Server Uptime</span>
              <div>
                <span class="metric-val">98.7%</span>
                <div class="progress-bar"><div class="progress-fill" style="width:98.7%;"></div></div>
              </div>
            </div>
            <div class="metric-row">
              <span class="metric-label">Disk Usage</span>
              <div>
                <span class="metric-val">64%</span>
                <div class="progress-bar"><div class="progress-fill" style="width:64%;background:linear-gradient(90deg,var(--warning),#D97706);"></div></div>
              </div>
            </div>
            <div class="metric-row">
              <span class="metric-label">API Calls Hari Ini</span>
              <span class="metric-val">28.4k</span>
            </div>
          </div>
        </div>
      </div>
    </div>

@section('scripts')
<script>
    window.onload = () => {
        const trends = @json($revenue_trends);
        if(typeof renderRevenueChart === 'function') {
            renderRevenueChart(trends);
        }
    };
</script>
@endsection
@endsection
