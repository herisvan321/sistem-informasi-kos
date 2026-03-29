@extends('layouts.admin')

@section('content')
<div class="page-header" style="margin-bottom: 32px;">
    <div>
        <h1 class="page-title" style="font-size: 24px; font-weight: 800;">Manajemen Okupansi Unit</h1>
        <p class="page-subtitle" style="font-size: 14px;">Inventori Kapasitas & Ketersediaan Real-time: <strong style="color: var(--primary);">{{ $listing->name }}</strong></p>
    </div>
    <div class="page-actions">
        <a href="{{ route('pemilik-kos.listings.index') }}" class="btn btn-outline" style="border-radius: 100px; padding: 10px 20px; font-weight: 700;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:16px; height:16px;"><polyline points="15 18 9 12 15 6"/></svg>
            KEMBALI KE PORTOFOLIO
        </a>
    </div>
</div>

<div class="two-col" style="display: grid; grid-template-columns: 340px 1fr; gap: 32px; align-items: flex-start;">
    <!-- LEFT: ADD FORM -->
    <div class="sidebar">
        <div class="card" style="border:none; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border-radius: 20px; position: sticky; top: 24px;">
            <div class="card-header" style="background: #fff; border-bottom: 1.5px solid var(--border); padding: 24px;">
                <div class="card-title" style="font-size: 16px; font-weight: 800;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--primary);"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Registrasi Unit Baru
                </div>
            </div>
            <div class="card-body" style="padding: 24px;">
                <form action="{{ route('pemilik-kos.listings.rooms.store', $listing->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" style="font-size: 11px; letter-spacing: 0.05em; font-weight: 800; color: var(--text-muted);">LABEL IDENTIFIKASI UNIT</label>
                        <input type="text" name="room_number" class="form-input" style="padding:14px; border-radius: 12px; background: var(--bg); border: 2px solid transparent; font-weight: 600;" placeholder="Cth: A-01, Lt 1 No 5" required>
                    </div>
                    
                    <div class="form-group" style="margin-top: 24px;">
                        <label class="form-label" style="font-size: 11px; letter-spacing: 0.05em; font-weight: 800; color: var(--text-muted);">ADJUSTMENT PRICING (OPTIONAL)</label>
                        <div style="position:relative;">
                            <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); font-weight:800; color: var(--primary); font-size: 14px;">Rp</span>
                            <input type="number" name="price" class="form-input" style="padding:14px 14px 14px 44px; border-radius: 12px; background: var(--bg); border: 2px solid transparent; font-weight: 600;" placeholder="{{ number_format($listing->price, 0, ',', '.') }}">
                        </div>
                        <small style="font-size: 10px; color: var(--text-muted); margin-top: 6px; display: block;">Biarkan kosong untuk mengikuti harga properti.</small>
                    </div>

                    <div class="form-group" style="margin-top: 24px;">
                        <label class="form-label" style="font-size: 11px; letter-spacing: 0.05em; font-weight: 800; color: var(--text-muted);">STATUS AWAL</label>
                        <select name="status" class="form-input" style="padding:14px; border-radius: 12px; background: var(--bg); border: 2px solid transparent; font-weight: 600; appearance: auto;">
                            <option value="Available">Tersedia</option>
                            <option value="Full">Sudah Terisi</option>
                        </select>
                    </div>

                     <button type="submit" class="btn btn-blue" style="width: 100%; justify-content: center; padding: 16px; border-radius: 14px; font-weight: 800; margin-top: 16px; box-shadow: 0 10px 20px rgba(var(--primary-rgb), 0.2);">
                        Finalisasi Data Unit
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- RIGHT: INVENTORY GRID -->
    <div style="flex: 1;">
        <div class="card" style="border:none; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border-radius: 20px;">
            <div class="card-header" style="background: #fff; border-bottom: 1.5px solid var(--border); padding: 24px; display: flex; justify-content: space-between; align-items: center;">
                <div class="card-title" style="font-size: 16px; font-weight: 800;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--success);"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
                    Logistik & Status Unit Terintegrasi ({{ $rooms->count() }})
                </div>
            </div>
            <div class="card-body" style="padding: 32px;">
                <div class="room-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 24px;">
                    @forelse($rooms as $room)
                        <div class="room-card {{ $room->status === 'Full' ? 'is-full' : 'is-available' }}" style="background: #fff; border: 1.5px solid var(--border); border-radius: 20px; padding: 24px; position: relative; transition: 0.3s; overflow: hidden;">
                            <div style="font-size: 22px; font-weight: 800; color: var(--text); margin-bottom: 4px;">{{ $room->room_number }}</div>
                            <div style="font-size: 14px; font-weight: 700; color: var(--primary); margin-bottom: 24px;">
                                Rp {{ number_format($room->price ?? $listing->price, 0, ',', '.') }}
                                <span style="font-size: 10px; color: var(--text-muted); font-weight: 500;">/ bln</span>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: auto;">
                                @if($room->status === 'Available')
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 10px; height: 10px; background: #22c55e; border-radius: 50%; box-shadow: 0 0 10px rgba(34, 197, 94, 0.4);"></div>
                                        <span style="font-size: 11px; font-weight: 800; color: #16a34a; letter-spacing: 0.5px;">READY</span>
                                    </div>
                                @else
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 10px; height: 10px; background: var(--text-muted); opacity: 0.4; border-radius: 50%;"></div>
                                        <span style="font-size: 11px; font-weight: 800; color: var(--text-muted); letter-spacing: 0.5px;">FULL</span>
                                    </div>
                                @endif

                                <form action="{{ route('pemilik-kos.rooms.toggle-status', $room->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background: var(--bg); color: var(--text); border: none; padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';" onmouseout="this.style.background='var(--bg)'; this.style.color='var(--text)';">
                                        Update Status
                                    </button>
                                </form>
                            </div>

                            <!-- DELETE ACTION OVERLAY -->
                            <div class="action-overlay" style="position: absolute; top: 12px; right: 12px; display: flex; opacity: 0; transform: translateY(-5px); transition: 0.2s;">
                                <form action="{{ route('pemilik-kos.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Hapus unit ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="width: 32px; height: 32px; border-radius: 10px; background: rgba(239, 68, 68, 0.1); color: var(--danger); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 0;">
                            <div style="font-size: 48px; margin-bottom: 20px; opacity: 0.2;">🏢</div>
                            <h3 style="font-size: 18px; font-weight: 800; color: var(--text);">Inventori Unit Kosong</h3>
                            <p style="font-size: 13px; color: var(--text-muted); margin-top: 8px;">Gunakan modul registrasi di samping untuk mengaktifkan unit baru.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-input:focus {
        border-color: var(--primary) !important;
        background: #fff !important;
        box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.08) !important;
    }
    .room-card:hover {
        border-color: var(--primary) !important;
        box-shadow: 0 15px 30px rgba(var(--primary-rgb), 0.06) !important;
        transform: translateY(-4px);
    }
    .room-card:hover .action-overlay {
        opacity: 1;
        transform: translateY(0);
    }
    .is-full {
        background: #f8fafc !important;
        border-color: transparent !important;
    }
    .is-full div { opacity: 0.7; }
</style>
@endsection
