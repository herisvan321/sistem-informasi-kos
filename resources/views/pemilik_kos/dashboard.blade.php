@extends('layouts.admin')

@section('content')
<!-- WELCOME HEADER -->
<div class="page-header" style="margin-bottom: 40px;">
    <div style="display: flex; align-items: center; gap: 20px;">
        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary), #4f46e5); color: #fff; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 800; font-family: 'Syne'; box-shadow: 0 10px 20px rgba(var(--primary-rgb), 0.2);">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <h1 class="page-title" style="font-size: 24px; font-family: 'Syne'; margin-bottom: 4px;">Selamat Datang, {{ explode(' ', auth()->user()->name)[0] }}!</h1>
            <p class="page-subtitle" style="font-size: 14px;">Command Center Pengelolaan Portofolio Properti Anda.</p>
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('pemilik-kos.listings.create') }}" class="btn btn-blue" style="border-radius: 100px; padding: 12px 24px; font-weight: 800; font-family: 'Syne'; box-shadow: 0 10px 20px rgba(var(--primary-rgb), 0.2);">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="width:16px; height:16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            EKSPANSI ASET
        </a>
    </div>
</div>

<!-- STATS GRID -->
<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 40px;">
    <!-- Total Properti -->
    <div class="stat-card" style="border:none; box-shadow: 0 10px 30px rgba(0,0,0,0.03); padding: 24px; background: #fff; display: flex; align-items: center; gap: 20px;">
        <div style="width: 56px; height: 56px; background: rgba(var(--primary-rgb), 0.1); color: var(--primary); border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8"/></svg>
        </div>
        <div>
            <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Aset Properti</div>
            <div style="font-size: 28px; font-weight: 800; color: var(--text); margin-top: 2px;">{{ number_format($totalListings) }}</div>
            <div style="font-size: 11px; color: var(--success); font-weight: 700; margin-top: 4px;">{{ $listing_change >= 0 ? '↑' : '↓' }} {{ abs($listing_change) }}% <span style="color: var(--text-muted); font-weight: 500;">performa aset</span></div>
        </div>
    </div>

    <!-- Penyewa Aktif -->
    <div class="stat-card" style="border:none; box-shadow: 0 10px 30px rgba(0,0,0,0.03); padding: 24px; background: #fff; display: flex; align-items: center; gap: 20px;">
        <div style="width: 56px; height: 56px; background: rgba(34, 197, 94, 0.1); color: #16a34a; border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div>
            <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Total Penghuni</div>
            <div style="font-size: 28px; font-weight: 800; color: var(--text); margin-top: 2px;">{{ number_format($activeTenants) }}</div>
            <div style="font-size: 11px; color: var(--text-muted); font-weight: 600; margin-top: 4px; display: flex; align-items: center; gap: 6px;">
                <span style="width: 6px; height: 6px; background: #22c55e; border-radius: 50%;"></span> Terverifikasi Aktif
            </div>
        </div>
    </div>

    <!-- Total Pendapatan -->
    <div class="stat-card" style="border:none; box-shadow: 0 10px 30px rgba(0,0,0,0.03); padding: 24px; background: #fff; display: flex; align-items: center; gap: 20px;">
        <div style="width: 56px; height: 56px; background: rgba(245, 158, 11, 0.1); color: #d97706; border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div>
            <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Akumulasi Finansial</div>
            <div style="font-size: 28px; font-weight: 800; color: var(--text); margin-top: 2px;">Rp {{ number_format($totalRevenue / 1000000, 1) }}jt</div>
            <div style="font-size: 11px; color: var(--text-muted); font-weight: 600; margin-top: 4px;">Pendapatan Bersih</div>
        </div>
    </div>

    <!-- Rata-rata Okupansi -->
    <div class="stat-card" style="border:none; box-shadow: 0 10px 30px rgba(0,0,0,0.03); padding: 24px; background: #fff; display: flex; align-items: center; gap: 20px;">
        <div style="width: 56px; height: 56px; background: rgba(var(--primary-rgb), 0.1); color: var(--primary); border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2v10h10"/></svg>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Rasio Okupansi</div>
            <div style="font-size: 28px; font-weight: 800; color: var(--text); margin-top: 2px;">{{ $occupancyRate }}%</div>
            <div style="width: 100%; height: 6px; background: var(--bg); border-radius: 100px; margin-top: 8px; overflow: hidden;">
                <div style="width: {{ $occupancyRate }}%; height: 100%; background: var(--primary); border-radius: 100px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="two-col" style="gap: 28px;">
    <!-- LEFT PANEL: CHARTS -->
    <div style="flex: 1.6; display: flex; flex-direction: column; gap: 28px;">
        <div class="card" style="border:none; box-shadow: 0 10px 40px rgba(0,0,0,0.03);">
            <div class="card-header" style="background: #fff; padding: 20px 24px; border-bottom: 1.5px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                <div class="card-title" style="font-size: 15px; font-weight: 800; font-family: 'Syne';">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--primary);"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Wawasan Pertumbuhan Aset
                </div>
            </div>
            <div class="card-body" style="padding: 24px;">
                <div id="growthChart" style="min-height: 320px;"></div>
            </div>
        </div>

        <div class="card" style="border:none; box-shadow: 0 10px 40px rgba(0,0,0,0.03);">
            <div class="card-header" style="background: #fff; padding: 20px 24px; border-bottom: 1.5px solid var(--border);">
                <div class="card-title" style="font-size: 15px; font-weight: 800; font-family: 'Syne';">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--success);"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/></svg>
                    Inventori Properti Terbaru
                </div>
            </div>
            <div class="card-body" style="padding:0;">
                <div class="table-wrap">
                    <table style="border-collapse: separate; border-spacing: 0;">
                        <tbody>
                            @foreach($recentListings as $listing)
                            <tr>
                                <td style="padding: 16px 24px;">
                                    <div class="user-cell">
                                        <div class="user-av" style="border-radius: 10px; background: var(--bg); width: 40px; height: 40px; overflow: hidden;">
                                            @if($listing->main_photo)
                                                <img src="{{ asset('storage/'.$listing->main_photo) }}" style="width:100%; height:100%; object-fit:cover;">
                                            @else
                                                <div style="display:flex; align-items:center; justify-content:center; height:100%; font-size:18px;">🏢</div>
                                            @endif
                                        </div>
                                        <div class="user-info">
                                            <strong style="font-size: 14px; color: var(--text);">{{ $listing->name }}</strong>
                                            <span style="font-size: 11px;">{{ $listing->city }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: var(--primary); font-size: 14px;">Rp {{ number_format($listing->price, 0, ',', '.') }}</div>
                                </td>
                                <td style="text-align: right; padding-right: 24px;">
                                    @if($listing->premium_status === 'active')
                                        <span class="badge" style="background: rgba(245, 158, 11, 0.1); color: #d97706; border: none; font-weight: 800; font-size: 10px;">TIER PREMIUM</span>
                                    @else
                                        <span class="badge" style="background: var(--bg); color: var(--text-muted); border: none; font-weight: 800; font-size: 10px;">TIER STANDAR</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL: FEED -->
    <div style="flex: 1; display: flex; flex-direction: column; gap: 28px;">
        <div class="card" style="border:none; box-shadow: 0 10px 40px rgba(0,0,0,0.03); background: #fff;">
            <div class="card-header" style="padding: 20px 24px; border-bottom: 1.5px solid var(--border);">
                <div class="card-title" style="font-size: 15px; font-weight: 800; font-family: 'Syne';">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--amber);"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Inquiry & Komunikasi
                </div>
            </div>
            <div class="card-body" style="padding: 0;">
                @forelse($recentInquiries as $inquiry)
                    <a href="{{ route('pemilik-kos.inquiries.show', $inquiry->id) }}" style="display: block; padding: 16px 24px; text-decoration: none; border-bottom: 1px solid var(--border); transition: 0.2s;" onmouseover="this.style.background='rgba(var(--primary-rgb), 0.02)'" onmouseout="this.style.background='none'">
                        <div class="user-cell">
                            <div class="user-av" style="background: var(--primary-glow); color: var(--primary); font-family: 'Syne'; font-weight: 800;">
                                {{ strtoupper(substr($inquiry->sender->name, 0, 1)) }}
                            </div>
                            <div class="user-info" style="flex:1; overflow:hidden;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <strong style="font-size: 13px; color: var(--text);">{{ $inquiry->sender->name }}</strong>
                                    <span style="font-size: 10px; color: var(--text-muted);">{{ $inquiry->created_at->diffForHumans() }}</span>
                                </div>
                                <div style="font-size: 11px; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 4px;">{{ $inquiry->message }}</div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div style="padding: 40px 24px; text-align: center; color: var(--text-muted); font-size: 13px;">Belum ada interaksi masuk.</div>
                @endforelse
            </div>
        </div>

        <div class="card" style="border:none; box-shadow: 0 10px 40px rgba(0,0,0,0.03);">
            <div class="card-header" style="padding: 20px 24px; border-bottom: 1.5px solid var(--border);">
                <div class="card-title" style="font-size: 15px; font-weight: 800; font-family: 'Syne';">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--primary);"><circle cx="12" cy="12" r="10"/><path d="M12 2v10h10"/></svg>
                    Sebaran Okupansi
                </div>
            </div>
            <div class="card-body" style="padding: 24px; display: flex; flex-direction: column; align-items: center;">
                <div id="occupancyDonut" style="width: 100%; min-height: 220px;"></div>
                <div style="width: 100%; margin-top: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div style="padding: 12px; background: var(--bg); border-radius: 12px; text-align: center;">
                        <div style="font-size: 10px; font-weight: 800; color: var(--text-muted); margin-bottom: 4px;">TERISI</div>
                        <div style="font-size: 16px; font-weight: 800; color: #16a34a;">{{ $distribution['occupied'] }}</div>
                    </div>
                    <div style="padding: 12px; background: var(--bg); border-radius: 12px; text-align: center;">
                        <div style="font-size: 10px; font-weight: 800; color: var(--text-muted); margin-bottom: 4px;">KOSONG</div>
                        <div style="font-size: 16px; font-weight: 800; color: var(--primary);">{{ $distribution['available'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // GROWTH TRENDS CHART
        const trends = @json($registration_trends);
        const optionsGrowth = {
            series: [{
                name: 'Properti Baru',
                data: trends.map(t => t.count)
            }],
            chart: {
                height: 320,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'DM Sans, sans-serif'
            },
            dataLabels: { enabled: false },
            colors: ['#6366f1'],
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100, 100, 100]
                }
            },
            xaxis: {
                categories: trends.map(t => t.month),
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: { labels: { style: { colors: '#94a3b8' } } },
            grid: { borderColor: '#f1f5f9' }
        };
        new ApexCharts(document.querySelector("#growthChart"), optionsGrowth).render();

        // OCCUPANCY DONUT
        const optionsDonut = {
            series: [{{ $distribution['occupied'] }}, {{ $distribution['available'] }}],
            labels: ['Terisi', 'Tersedia'],
            chart: { type: 'donut', height: 220 },
            colors: ['#22c55e', '#6366f1'],
            legend: { show: false },
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'TOTAL UNIT',
                                fontSize: '10px',
                                fontWeight: 800,
                                fontFamily: 'DM Sans',
                                color: '#94a3b8'
                            }
                        }
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#occupancyDonut"), optionsDonut).render();
    });
</script>
@endsection
