@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title" style="font-family: 'Syne'; font-weight: 800;">Detail Reservasi</h1>
        <p class="page-subtitle">ID Manifest: <strong>#{{ strtoupper(substr($transaction->id, 0, 8)) }}</strong></p>
    </div>
    <div class="page-actions">
        <a href="{{ route('pencari-kos.history.index') }}" class="btn btn-outline" style="border-radius: 100px; padding: 12px 24px; font-weight: 800; font-size: 11px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 8px;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            KEMBALI KE RIWAYAT
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="card" style="border-radius: 24px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
            <div style="height: 200px; background: linear-gradient(135deg, var(--primary), #4f46e5); position: relative;">
                <div style="position: absolute; bottom: -30px; left: 40px; width: 80px; height: 80px; background: #fff; border-radius: 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                    <svg viewBox="0 0 24 24" width="40" height="40" fill="var(--primary)"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/></svg>
                </div>
            </div>
            <div class="card-body" style="padding: 60px 40px 40px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
                    <div>
                        <h2 style="font-family: 'Syne'; font-weight: 800; font-size: 28px; color: var(--text); line-height: 1.2;">{{ $transaction->listing->name }}</h2>
                        <p style="color: var(--text-muted); font-size: 15px; margin-top: 8px;">{{ $transaction->listing->address }}, {{ $transaction->listing->city }}</p>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Total Investasi Sewa</div>
                        <div style="font-family: 'Syne'; font-weight: 800; font-size: 24px; color: var(--primary);">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; padding: 32px; background: #f9fafb; border-radius: 20px; margin-bottom: 40px;">
                    <div>
                        <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Tipe Kamar</div>
                        <div style="font-weight: 700; color: var(--text);">Kamar {{ $transaction->room->room_number }} - {{ $transaction->room->type }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Tenor Sewa</div>
                        <div style="font-weight: 700; color: var(--text);">{{ $transaction->duration_months }} Bulan</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Check-in</div>
                        <div style="font-weight: 700; color: var(--text);">{{ \Carbon\Carbon::parse($transaction->check_in_date)->format('d F Y') }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Metode Pembayaran</div>
                        <div style="font-weight: 700; color: var(--text);">{{ $transaction->payment_method ?? 'Transfer Bank' }}</div>
                    </div>
                </div>

                @if($transaction->notes)
                <div style="margin-bottom: 40px;">
                    <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Catatan Tambahan</div>
                    <div style="padding: 20px; border-left: 4px solid var(--primary); background: rgba(var(--primary-rgb), 0.03); font-size: 14px; color: var(--text); border-radius: 0 12px 12px 0;">
                        {{ $transaction->notes }}
                    </div>
                </div>
                @endif

                @if($transaction->payment_proof)
                <div>
                    <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;">Dokumen Bukti Pembayaran</div>
                    <div style="position: relative; border-radius: 16px; overflow: hidden; border: 1px solid var(--border); max-width: 300px;">
                        <img src="{{ asset('storage/' . $transaction->payment_proof) }}" alt="Bukti Pembayaran" style="width: 100%; height: auto; display: block;">
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.6); padding: 10px; text-align: center;">
                            <a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank" style="color: #fff; font-size: 11px; font-weight: 700; text-decoration: none;">LIHAT FULL RESOLUSI</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar Status -->
    <div>
        <div class="card" style="border-radius: 24px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.04); position: sticky; top: 24px;">
            <div class="card-body" style="padding: 32px;">
                <h3 style="font-family: 'Syne'; font-weight: 800; font-size: 18px; color: var(--text); margin-bottom: 24px;">Status Manifest</h3>
                
                <div style="display: flex; flex-direction: column; gap: 24px;">
                    <!-- Step 1 -->
                    <div style="display: flex; gap: 16px;">
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--success); display: flex; align-items: center; justify-content: center; color: #fff;">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div style="width: 2px; height: 32px; background: var(--success);"></div>
                        </div>
                        <div>
                            <div style="font-size: 13px; font-weight: 800; color: var(--text);">Booking Dibuat</div>
                            <div style="font-size: 11px; color: var(--text-muted);">{{ $transaction->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div style="display: flex; gap: 16px;">
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 24px; height: 24px; border-radius: 50%; background: {{ $transaction->payment_proof ? 'var(--success)' : 'var(--amber)' }}; display: flex; align-items: center; justify-content: center; color: #fff;">
                                @if($transaction->payment_proof)
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg>
                                @else
                                    <div style="width: 8px; height: 8px; background: #fff; border-radius: 50%;"></div>
                                @endif
                            </div>
                            <div style="width: 2px; height: 32px; background: {{ $transaction->payment_proof ? 'var(--success)' : 'var(--border)' }};"></div>
                        </div>
                        <div>
                            <div style="font-size: 13px; font-weight: 800; color: {{ $transaction->payment_proof ? 'var(--text)' : 'var(--amber)' }};">Upload Bukti Bayar</div>
                            <div style="font-size: 11px; color: var(--text-muted);">
                                @if($transaction->payment_proof)
                                    Selesai diupload
                                @else
                                    Menunggu proses upload
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div style="display: flex; gap: 16px;">
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <div style="width: 24px; height: 24px; border-radius: 50%; background: {{ in_array($transaction->status, ['Paid', 'Active', 'Success']) ? 'var(--success)' : ($transaction->payment_proof ? 'var(--amber)' : 'var(--border)') }}; display: flex; align-items: center; justify-content: center; color: #fff;">
                                @if(in_array($transaction->status, ['Paid', 'Active', 'Success']))
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg>
                                @else
                                    <div style="width: 8px; height: 8px; background: #fff; border-radius: 50%;"></div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div style="font-size: 13px; font-weight: 800; color: {{ in_array($transaction->status, ['Paid', 'Active', 'Success']) ? 'var(--text)' : 'var(--text-muted)' }};">Verifikasi Owner</div>
                            <div style="font-size: 11px; color: var(--text-muted);">
                                @if(in_array($transaction->status, ['Paid', 'Active', 'Success']))
                                    Berhasil Diverifikasi
                                @elseif($transaction->payment_proof)
                                    Sedang Ditinjau
                                @else
                                    Belum Dimulai
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 40px; padding-top: 32px; border-top: 1px solid var(--border);">
                    @if($transaction->status === 'Pending' && !$transaction->payment_proof)
                        <a href="{{ route('pencari-kos.payments.show', $transaction->id) }}" class="btn btn-primary" style="width: 100%; border-radius: 100px; padding: 14px; font-weight: 800; font-family: 'Syne'; letter-spacing: 0.5px;">
                            UPLOAD BUKTI SEKARANG
                        </a>
                        <p style="text-align: center; font-size: 11px; color: var(--text-muted); margin-top: 12px;">Mohon selesaikan pembayaran agar pesanan tidak dibatalkan otomatis.</p>
                    @elseif($transaction->status === 'Pending' && $transaction->payment_proof)
                        <div style="padding: 16px; background: rgba(var(--amber-rgb), 0.1); border: 1px solid rgba(var(--amber-rgb), 0.3); border-radius: 12px; text-align: center;">
                            <div style="font-size: 12px; font-weight: 800; color: var(--amber); text-transform: uppercase;">Menunggu Verifikasi</div>
                            <div style="font-size: 11px; color: var(--amber); margin-top: 4px; opacity: 0.8;">Owner akan meninjau bukti bayar Anda maksimal 1x24 jam.</div>
                        </div>
                    @elseif(in_array($transaction->status, ['Paid', 'Active', 'Success']))
                        <div style="padding: 16px; background: rgba(var(--success-rgb), 0.1); border: 1px solid rgba(var(--success-rgb), 0.3); border-radius: 12px; text-align: center;">
                            <div style="font-size: 12px; font-weight: 800; color: var(--success); text-transform: uppercase;">Reservasi Aktif</div>
                            <div style="font-size: 11px; color: var(--success); margin-top: 4px; opacity: 0.8;">Selamat! Pembayaran Anda telah dikonfirmasi. Selamat datang di hunian baru Anda.</div>
                        </div>
                    @else
                        <div style="padding: 16px; background: #fef2f2; border: 1px solid #fee2e2; border-radius: 12px; text-align: center;">
                            <div style="font-size: 12px; font-weight: 800; color: #ef4444; text-transform: uppercase;">{{ strtoupper($transaction->status) }}</div>
                            <div style="font-size: 11px; color: #ef4444; margin-top: 4px; opacity: 0.8;">Mohon hubungi dukungan pelanggan jika Anda merasa ini adalah kesalahan.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection