@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Pusat Notifikasi</h1>
        <p class="page-subtitle">Kelola dan lihat semua pemberitahuan sistem</p>
    </div>
    <div style="display: flex; gap: 10px;">
        @if($unreadNotificationsCount > 0)
        <form action="{{ route('admin.notifications.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Tandai Semua Dibaca
            </button>
        </form>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            Semua Notifikasi
        </div>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-wrap">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">Status</th>
                        <th>Informasi</th>
                        <th>Waktu</th>
                        <th style="width: 100px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                    <tr class="{{ $notification->read_at ? '' : 'unread-row' }}" style="{{ $notification->read_at ? '' : 'background: rgba(78,115,223,0.03);' }}">
                        <td style="text-align: center;">
                            @if(!$notification->read_at)
                                <div class="badge-dot" style="width: 10px; height: 10px; background: var(--primary); margin: 0 auto; display: block;"></div>
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px; color: var(--text-muted); opacity: 0.5;"><polyline points="20 6 9 17 4 12"/></svg>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 600; font-size: 14px; margin-bottom: 2px;">{{ $notification->data['title'] ?? 'Pembaruan Sistem' }}</div>
                            <div style="font-size: 13px; color: var(--text-muted);">{{ $notification->data['message'] ?? '' }}</div>
                        </td>
                        <td style="font-size: 13px; color: var(--text-muted);">
                            {{ $notification->created_at->translatedFormat('d M Y, H:i') }}
                            <div style="font-size: 11px; opacity: 0.7;">{{ $notification->created_at->diffForHumans() }}</div>
                        </td>
                        <td style="text-align: right; padding-right: 22px;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                @if(!$notification->read_at)
                                <form action="{{ route('admin.notifications.mark-as-read', $notification->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="act-btn success" title="Tandai Dibaca">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="act-btn danger" title="Hapus">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
                                <p>Belum ada notifikasi yang masuk.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($notifications->hasPages())
    <div class="card-footer" style="padding: 16px 22px; border-top: 1.5px solid var(--border);">
        {{ $notifications->links() }}
    </div>
    @endif
</div>
@endsection
