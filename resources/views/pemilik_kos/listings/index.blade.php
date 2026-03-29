@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Portofolio Aset Properti</h1>
        <p class="page-subtitle">Manajemen komprehensif aset unit dan visibilitas pasar properti Anda</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('pemilik-kos.listings.create') }}" class="btn btn-blue" style="border-radius: 100px; padding: 12px 24px; font-family: 'Syne'; font-weight: 800; box-shadow: 0 10px 20px rgba(var(--primary-rgb), 0.2);">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="width:16px; height:16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            REGISTRASI ASET BARU
        </a>
    </div>
</div>

<div class="property-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 28px;">
    @forelse($listings as $listing)
        <div class="property-card" style="background: #fff; border-radius: 20px; border: 1.5px solid var(--border); overflow: hidden; transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); display: flex; flex-direction: column;">
            <!-- Hero Section -->
            <div class="property-image" style="height: 220px; position: relative; overflow: hidden;">
                @if($listing->main_photo)
                    <img src="{{ asset('storage/' . $listing->main_photo) }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s;">
                @else
                    <div style="width:100%; height:100%; background: var(--bg); display: flex; align-items: center; justify-content: center; font-size: 40px;">🏢</div>
                @endif

                <!-- Status Overlay -->
                <div style="position: absolute; top: 16px; left: 16px; display: flex; flex-direction: column; gap: 8px;">
                    @if($listing->status === 'Approved')
                        <div class="status-badge" style="background: rgba(34, 197, 94, 0.9); backdrop-filter: blur(8px); color: #fff; padding: 6px 14px; border-radius: 100px; font-size: 10px; font-weight: 800; letter-spacing: 0.5px; border: 1px solid rgba(255,255,255,0.2);">✓ PUBLIKASI AKTIF</div>
                    @elseif($listing->status === 'Pending')
                        <div class="status-badge" style="background: rgba(245, 158, 11, 0.9); backdrop-filter: blur(8px); color: #fff; padding: 6px 14px; border-radius: 100px; font-size: 10px; font-weight: 800; letter-spacing: 0.5px;">⌛ VERIFIKASI ADMIN</div>
                    @else
                        <div class="status-badge" style="background: rgba(239, 68, 68, 0.9); backdrop-filter: blur(8px); color: #fff; padding: 6px 14px; border-radius: 100px; font-size: 10px; font-weight: 800; letter-spacing: 0.5px;">✕ REVISI DIBUTUHKAN</div>
                    @endif

                    @if($listing->premium_status === 'approved')
                        <div class="premium-badge" style="background: linear-gradient(135deg, #f59e0b, #ef4444); color: #fff; padding: 6px 14px; border-radius: 100px; font-size: 10px; font-weight: 800; letter-spacing: 0.5px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);">★ PREMIUM</div>
                    @elseif($listing->premium_status === 'pending')
                         <div class="premium-badge" style="background: rgba(255,255,255,0.9); color: #B45309; padding: 6px 14px; border-radius: 100px; font-size: 10px; font-weight: 800; letter-spacing: 0.5px; border: 1.5px dashed #B45309;">⌛ ANTRIAN PREMIUM</div>
                    @endif
                </div>

                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.6), transparent); padding: 24px 20px;">
                    <span style="display: inline-block; padding: 4px 10px; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); color: #fff; border-radius: 6px; font-size: 10px; font-weight: 800; margin-bottom: 8px; text-transform: uppercase;">{{ $listing->category->name ?? 'Boarding House' }}</span>
                    <h3 style="color: #fff; font-size: 18px; font-weight: 800; font-family: 'Syne';">{{ $listing->name }}</h3>
                </div>
            </div>

            <!-- Content Section -->
            <div class="property-content" style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                <div style="display: flex; gap: 16px; margin-bottom: 24px;">
                    <div style="flex: 1;">
                        <div style="font-size: 11px; color: var(--text-muted); font-weight: 800; letter-spacing: 0.05em; margin-bottom: 4px;">HARGA MULAI</div>
                        <div style="font-size: 18px; font-weight: 800; color: var(--primary); font-family: 'Syne';">Rp {{ number_format($listing->price, 0, ',', '.') }}<small style="font-size: 11px; font-weight: 500;">/bln</small></div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 11px; color: var(--text-muted); font-weight: 800; letter-spacing: 0.05em; margin-bottom: 4px;">TOTAL UNIT</div>
                        <div style="font-size: 18px; font-weight: 800; color: var(--text); font-family: 'Syne';">{{ $listing->rooms_count ?? $listing->rooms()->count() }} Unit</div>
                    </div>
                </div>

                @if($listing->status === 'Rejected')
                <div style="padding: 12px; background: rgba(239, 68, 68, 0.05); border: 1px dashed var(--danger); border-radius: 10px; margin-bottom: 20px;">
                    <div style="font-size: 11px; font-weight: 800; color: var(--danger);">CATATAN PENOLAKAN:</div>
                    <div style="font-size: 12px; color: var(--text); margin-top: 4px;">{{ $listing->rejection_reason }}</div>
                </div>
                @endif

                <div class="property-footer" style="margin-top: auto; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <a href="{{ route('pemilik-kos.listings.edit', $listing->id) }}" class="btn btn-outline" style="justify-content: center; font-weight: 800; font-size: 12px; border-radius: 10px;">
                        PERBARUI ASET
                    </a>
                    <a href="{{ route('pemilik-kos.listings.rooms.index', $listing->id) }}" class="btn btn-primary" style="justify-content: center; font-weight: 800; font-size: 12px; border-radius: 10px; background: var(--text); border-color: var(--text);">
                        MANAJEMEN OKUPANSI
                    </a>
                </div>

                @if($listing->premium_status === 'none' && $listing->status === 'Approved')
                <form action="{{ route('pemilik-kos.listings.request-premium', $listing->id) }}" method="POST" style="margin-top: 12px;">
                    @csrf
                    <button type="submit" class="btn" style="width: 100%; justify-content: center; background: linear-gradient(135deg, #f59e0b, #ef4444); color: #fff; font-weight: 800; font-size: 11px; border: none; border-radius: 10px; padding: 10px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);">
                         UPGRADE KE PREMIUM ★
                    </button>
                </form>
                @endif
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 120px 24px; border: 2px dashed var(--border); border-radius: 24px;">
            <div style="width: 100px; height: 100px; background: var(--bg); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity: 0.2;"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/><rect x="9" y="13" width="6" height="8"/></svg>
            </div>
            <h3 style="font-size: 24px; font-weight: 800; color: var(--text); font-family: 'Syne'; margin-bottom: 12px;">Ekspansi Portofolio Anda</h3>
            <p style="color: var(--text-muted); font-size: 16px; max-width: 400px; margin: 0 auto 32px;">Daftarkan aset perdana Anda dan jangkau target pasar penyewa eksklusif di seluruh Indonesia.</p>
            <a href="{{ route('pemilik-kos.listings.create') }}" class="btn btn-blue" style="padding: 16px 32px; border-radius: 100px; font-weight: 800; font-family: 'Syne'; box-shadow: 0 10px 30px rgba(var(--primary-rgb), 0.3);">
                DAFTARKAN ASET PERDANA
            </a>
        </div>
    @endforelse
</div>

<style>
    .property-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.08);
        border-color: var(--primary);
    }
    .property-card:hover img {
        transform: scale(1.05);
    }
    .status-badge { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
</style>
@endsection
