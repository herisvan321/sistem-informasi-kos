@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title" style="font-family: 'Syne'; font-weight: 800;">Pusat Notifikasi</h1>
        <p class="page-subtitle">Seluruh aktivitas dan pemberitahuan sistem</p>
    </div>
    <div class="page-actions">
        @if($notifications->where('read_at', null)->count() > 0)
        <form action="{{ route('notifications.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline" style="border-radius: 100px; font-weight: 800; font-size: 11px; padding: 10px 24px;">
                TANDAI SEMUA DIBACA
            </button>
        </form>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        @forelse($notifications as $notification)
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: flex-start; gap: 16px; {{ $notification->read_at ? '' : 'background: rgba(var(--primary-rgb), 0.03);' }}">
                <div style="width: 10px; height: 10px; border-radius: 50%; margin-top: 6px; flex-shrink: 0; background: {{ $notification->read_at ? 'var(--border)' : 'var(--primary)' }};"></div>
                <div style="flex: 1;">
                    <div style="font-weight: 700; font-size: 14px; color: var(--text);">{{ $notification->data['title'] ?? 'Notifikasi Baru' }}</div>
                    <div style="font-size: 13px; color: var(--text-muted); margin-top: 4px; line-height: 1.5;">{{ $notification->data['message'] ?? '' }}</div>
                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px; opacity: 0.7;">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
                <div style="display: flex; gap: 8px; flex-shrink: 0;">
                    @if(!$notification->read_at)
                    <form action="{{ route('notifications.mark-as-read', $notification->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline" style="border-radius: 100px; font-size: 10px; padding: 6px 14px; font-weight: 700;">DIBACA</button>
                    </form>
                    @endif
                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline" style="border-radius: 100px; font-size: 10px; padding: 6px 14px; font-weight: 700; color: #ef4444; border-color: #fecaca;">HAPUS</button>
                    </form>
                </div>
            </div>
        @empty
            <div style="padding: 60px; text-align: center;">
                <div style="font-size: 48px; margin-bottom: 16px;">🔔</div>
                <div style="font-weight: 800; font-family: 'Syne'; font-size: 18px; color: var(--text); margin-bottom: 8px;">Tidak Ada Notifikasi</div>
                <div style="font-size: 13px; color: var(--text-muted);">Belum ada pemberitahuan untuk ditampilkan.</div>
            </div>
        @endforelse
    </div>
</div>

@if($notifications->hasPages())
<div style="margin-top: 24px; display: flex; justify-content: center;">
    {{ $notifications->links() }}
</div>
@endif
@endsection
