@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Konfirmasi Rencana Sewa</h1>
        <p class="page-subtitle">Pusat Transaksi: Finalisasi Manifes Booking Strategis Anda</p>
    </div>
    <div class="page-actions">
        <div class="badge badge-primary" style="border-radius: 100px; padding: 10px 20px; font-weight: 800; font-size: 11px; letter-spacing: 0.05em;">AUDIT KEAMANAN AKTIF</div>
    </div>
</div>

<div class="two-col" style="gap: 32px;">
    <div class="dashboard-main">
        <div class="card">
            <div class="card-header">
                <div class="card-title" style="font-family: 'Syne'; font-weight: 800;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Formulir Booking Strategis
                </div>
            </div>
            <div class="card-body" style="padding: 40px;">
                <form action="{{ route('pencari-kos.bookings.store', $listing->id) }}" method="POST">
                    @csrf
                    
                    <!-- Room Selection -->
                    <div class="form-group" style="margin-bottom: 32px;">
                        <label class="form-label" style="font-weight: 800; font-size: 11px; letter-spacing: 0.1em; margin-bottom: 12px; color: var(--text-muted);">KLASIFIKASI KAMAR 🏢</label>
                        <div style="position: relative;">
                            <select name="room_id" id="room_id" class="form-input @error('room_id') is-invalid @enderror" style="height: 56px; border-radius: 16px; padding-left: 20px; font-weight: 700; background: #f9fafb; border: 1px solid var(--border); appearance: none;" required>
                                @foreach($availableRooms as $room)
                                    <option value="{{ $room->id }}">KAMAR {{ strtoupper($room->room_number) }} / LT.{{ $room->floor ?? '1' }} - RP {{ number_format($listing->price, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                            <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none; opacity: 0.5;">▼</div>
                        </div>
                        @error('room_id') <span class="badge badge-rose" style="margin-top: 8px;">{{ $message }}</span> @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
                        <!-- Check-in Date -->
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 800; font-size: 11px; letter-spacing: 0.1em; margin-bottom: 12px; color: var(--text-muted);">TANGGAL AKTIVASI 📅</label>
                            <input type="date" name="check_in_date" id="check_in_date" class="form-input @error('check_in_date') is-invalid @enderror" style="height: 56px; border-radius: 16px; padding: 0 20px; font-weight: 700; background: #f9fafb;" value="{{ old('check_in_date', date('Y-m-d')) }}" required>
                            @error('check_in_date') <span class="badge badge-rose" style="margin-top: 8px;">{{ $message }}</span> @enderror
                        </div>

                        <!-- Duration -->
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 800; font-size: 11px; letter-spacing: 0.1em; margin-bottom: 12px; color: var(--text-muted);">TENOR SEWA (BULAN) ⏳</label>
                            <div style="position: relative;">
                                <select name="duration_months" id="duration_months" class="form-input @error('duration_months') is-invalid @enderror" style="height: 56px; border-radius: 16px; padding-left: 20px; font-weight: 700; background: #f9fafb; appearance: none;" required>
                                    <option value="1">1 BULAN (STRATEGIS)</option>
                                    <option value="3">3 BULAN (OPTIMAL)</option>
                                    <option value="6">6 BULAN (PROFITABEL)</option>
                                    <option value="12">12 BULAN (MAXIMAL)</option>
                                </select>
                                <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); pointer-events: none; opacity: 0.5;">▼</div>
                            </div>
                            @error('duration_months') <span class="badge badge-rose" style="margin-top: 8px;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="form-group" style="margin-bottom: 40px;">
                        <label class="form-label" style="font-weight: 800; font-size: 11px; letter-spacing: 0.1em; margin-bottom: 12px; color: var(--text-muted);">MANIFES TAMBAHAN (OPSIONAL) 📝</label>
                        <textarea name="notes" id="notes" class="form-input @error('notes') is-invalid @enderror" rows="4" style="border-radius: 20px; padding: 20px; background: #f9fafb;" placeholder="Informasi tambahan untuk pemilik mengenai preferensi hunian..."></textarea>
                        @error('notes') <span class="badge badge-rose" style="margin-top: 8px;">{{ $message }}</span> @enderror
                    </div>

                    <div style="padding-top: 32px; border-top: 1px solid var(--border);">
                        <button type="submit" class="btn btn-primary" style="width: 100%; height: 60px; font-weight: 900; font-size: 16px; letter-spacing: 0.05em; border-radius: 100px; box-shadow: 0 20px 30px -10px rgba(var(--primary-rgb), 0.4);">
                            LANJUT KE PEMBAYARAN STRATEGIS
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left: 12px;"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="dashboard-sidebar">
        <div class="card" style="border: none; background: #f9fafb;">
            <div class="card-header" style="background: transparent; border-bottom: 1px dashed var(--border);">
                <div class="card-title" style="font-family: 'Syne'; font-weight: 800;">Manifest Properti</div>
            </div>
            <div class="card-body" style="padding: 24px;">
                <div style="display: flex; gap: 16px; align-items: center; margin-bottom: 32px;">
                    <div style="width: 90px; height: 90px; border-radius: 20px; overflow: hidden; background: #eee; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
                        @if($listing->main_photo)
                            <img src="{{ asset('storage/' . $listing->main_photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--primary); color: #fff; font-size: 32px;">🏢</div>
                        @endif
                    </div>
                    <div>
                        <div style="font-weight: 800; font-family: 'Syne'; font-size: 20px; line-height: 1.2; color: var(--text);">{{ $listing->name }}</div>
                        <div style="font-size: 12px; font-weight: 600; color: var(--text-muted); margin-top: 6px;">{{ strtoupper($listing->district) }}, {{ strtoupper($listing->city) }}</div>
                    </div>
                </div>

                <div style="padding: 24px; background: #fff; border-radius: 20px; border: 1px solid var(--border); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                    <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); opacity: 0.6; letter-spacing: 0.1em; margin-bottom: 20px;">RINGKASAN VALUASI</div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 14px; font-weight: 600;">
                        <span style="color: var(--text-muted);">Biaya Sewa / Tenor</span>
                        <span style="color: var(--text);">Rp {{ number_format($listing->price, 0, ',', '.') }}</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 24px; font-size: 14px; font-weight: 600;">
                        <span style="color: var(--text-muted);">Administrasi Audit</span>
                        <span style="color: var(--text);">Rp 50.000</span>
                    </div>
                    
                    <div style="padding-top: 20px; border-top: 2px dashed var(--border); display: flex; justify-content: space-between; align-items: baseline;">
                        <span style="font-size: 14px; font-weight: 800; color: var(--text-muted);">AKUMULASI TOTAL</span>
                        <span style="font-size: 24px; font-weight: 800; font-family: 'Syne'; color: var(--primary);">Rp {{ number_format($listing->price + 50000, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div style="margin-top: 32px; padding: 20px; background: rgba(var(--primary-rgb), 0.05); border-radius: 16px; border: 1px solid rgba(var(--primary-rgb), 0.1); display: flex; gap: 16px; align-items: flex-start;">
                    <div style="font-size: 20px;">🛡️</div>
                    <div style="font-size: 12px; line-height: 1.6; color: var(--primary); font-weight: 600;">
                        Seluruh transaksi diproteksi oleh protokol keamanan digital kami. Dana Anda aman hingga proses check-in tervalidasi.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
