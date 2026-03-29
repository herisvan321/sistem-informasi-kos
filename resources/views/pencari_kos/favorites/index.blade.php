@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Properti Favorit Anda</h1>
            <p class="page-subtitle">Pusat Observasi: Properti Strategis yang Sedang Dalam Pantauan Anda</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('pencari-kos.discovery.index') }}" class="btn btn-outline"
                style="border-radius: 100px; font-weight: 800; font-size: 11px;">TAMBAH OBSERVASI BARU</a>
        </div>
    </div>

    <div class="listing-grid @if($favorites->isEmpty()) empty-state @endif"
        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 32px;">
        @forelse($favorites as $favorite)
            @php $listing = $favorite->listing; @endphp
            <div class="listing-card {{ $listing->is_premium ? 'premium-highlight' : '' }}"
                style="background: #fff; border-radius: 24px; overflow: hidden; border: 1px solid var(--border); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; position: relative;"
                onclick="window.location='{{ route('pencari-kos.discovery.show', $listing->id) }}'">

                @if($listing->is_premium)
                    <div
                        style="position: absolute; top: 20px; right: 20px; z-index: 10; background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); color: #fff; padding: 6px 14px; border-radius: 100px; font-size: 10px; font-weight: 900; letter-spacing: 0.1em; box-shadow: 0 10px 15px -3px rgba(217, 119, 6, 0.4); display: flex; align-items: center; gap: 6px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        PREMIUM ASSET
                    </div>
                @endif

                <div class="card-image" style="height: 200px; position: relative; overflow: hidden;">
                    @if($listing->main_photo)
                        <img src="{{ asset('storage/' . $listing->main_photo) }}"
                            style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);"
                            class="list-img">
                    @else
                        <div
                            style="width: 100%; height: 100%; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); display: flex; align-items: center; justify-content: center; font-size: 40px;">
                            🏢</div>
                    @endif

                    <div
                        style="position: absolute; bottom: 16px; left: 16px; background: rgba(0,0,0,0.6); backdrop-filter: blur(10px); color: #fff; padding: 6px 14px; border-radius: 100px; font-size: 13px; font-weight: 800; border: 1px solid rgba(255,255,255,0.2); font-family: 'Syne';">
                        Rp {{ number_format($listing->price, 0, ',', '.') }}/bln
                    </div>

                    <form action="{{ route('pencari-kos.favorites.toggle', $listing->id) }}" method="POST"
                        style="position: absolute; top: 16px; left: 16px; z-index: 10;" onclick="event.stopPropagation()">
                        @csrf
                        <button type="submit"
                            style="background: rgba(255,255,255,0.95); border: none; cursor: pointer; color: #ef4444; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border: 1px solid var(--border);">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="card-body" style="padding: 20px;">
                    <div
                        style="font-size: 10px; color: var(--primary); font-weight: 800; letter-spacing: 0.1em; margin-bottom: 6px;">
                        {{ strtoupper($listing->city) }}</div>
                    <h3
                        style="font-size: 17px; font-weight: 800; color: var(--text); margin-bottom: 12px; font-family: 'Syne'; line-height: 1.3;">
                        {{ $listing->name }}</h3>
                    <div
                        style="display: flex; align-items: center; gap: 6px; color: var(--text-muted); font-size: 11px; font-weight: 600;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        {{ strtoupper($listing->district) }}
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 120px 0;">
                <div style="font-size: 80px; margin-bottom: 32px; filter: grayscale(1); opacity: 0.5;">❤️</div>
                <h2 style="font-family: 'Syne'; font-weight: 800; font-size: 28px;">Gudang Favorit Kosong</h2>
                <p style="color: var(--text-muted); margin-top: 12px; max-width: 400px; margin-left: auto; margin-right: auto;">
                    Anda belum menandai properti manapun sebagai aset strategis pilihan.</p>
                <a href="{{ route('pencari-kos.discovery.index') }}" class="btn btn-primary"
                    style="margin-top: 32px; padding: 14px 40px; border-radius: 100px;">MULA PERAMALAN PROPERTI</a>
            </div>
        @endforelse
    </div>

    <style>
        .listing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 40px 60px -15px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        .listing-card:hover .list-img {
            transform: scale(1.1);
        }

        .premium-highlight {
            border: 2px solid #fbbf24 !important;
            box-shadow: 0 10px 40px -10px rgba(251, 191, 36, 0.2);
        }
    </style>
@endsection