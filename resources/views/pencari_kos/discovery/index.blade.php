@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Discovery Properti Terpercaya</h1>
            <p class="page-subtitle">Pencarian Strategis: Menampilkan Hunian dengan Validasi Audit Keamanan</p>
        </div>
        <div class="page-actions">
            <div class="search-wrap" style="width: 320px; position: relative;">
                <form action="{{ route('pencari-kos.discovery.index') }}" method="GET">
                    <input type="text" name="search" class="form-input"
                        style="border-radius: 100px; padding-left: 40px; height: 44px; font-size: 13px;"
                        placeholder="Cari nama, kota, atau daerah..." value="{{ request('search') }}">
                    <span
                        style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); opacity: 0.5;">🔍</span>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card" style="margin-bottom: 32px; border-radius: 100px; padding: 8px 32px;">
        <div style="display: flex; gap: 24px; align-items: center; flex-wrap: wrap;">
            <span
                style="font-weight: 800; font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">KLASIFIKASI:</span>
            <div style="display: flex; gap: 12px;">
                <a href="{{ route('pencari-kos.discovery.index') }}"
                    class="badge {{ !request('category_id') ? 'badge-primary' : 'badge-slate' }}"
                    style="padding: 8px 20px; cursor: pointer; border-radius: 100px;">SEMUA</a>
                @foreach($categories as $category)
                    <a href="{{ route('pencari-kos.discovery.index', ['category_id' => $category->id]) }}"
                        class="badge {{ request('category_id') == $category->id ? 'badge-primary' : 'badge-slate' }}"
                        style="padding: 8px 20px; cursor: pointer; border-radius: 100px;">{{ strtoupper($category->name) }}</a>
                @endforeach
            </div>

            <div style="margin-left: auto; display: flex; gap: 12px; align-items: center;">
                <span style="font-size: 11px; font-weight: 700; color: var(--text-muted);">SORTIR:</span>
                <select class="form-input"
                    style="width: 160px; height: 36px; font-size: 12px; border-radius: 100px; background: #f9fafb; border: none;">
                    <option>Terbaru</option>
                    <option>Harga Terendah</option>
                    <option>Harga Tertinggi</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Listing Grid -->
    <div class="listing-grid @if($listings->isEmpty()) empty-state @endif"
        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 32px;">
        @forelse($listings as $listing)
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

                <div class="card-image" style="height: 220px; position: relative; overflow: hidden;">
                    @if($listing->main_photo)
                        <img src="{{ asset('storage/' . $listing->main_photo) }}"
                            style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);"
                            class="list-img">
                    @else
                        <div
                            style="width: 100%; height: 100%; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); display: flex; align-items: center; justify-content: center; font-size: 50px;">
                            🏢</div>
                    @endif

                    <div
                        style="position: absolute; bottom: 20px; left: 20px; background: rgba(0,0,0,0.6); backdrop-filter: blur(10px); color: #fff; padding: 8px 18px; border-radius: 100px; font-size: 14px; font-weight: 800; border: 1px solid rgba(255,255,255,0.2); font-family: 'Syne';">
                        Rp {{ number_format($listing->price, 0, ',', '.') }}<span
                            style="font-size: 10px; font-weight: 500; opacity: 0.8; margin-left: 4px;">/BULAN</span>
                    </div>
                </div>

                <div class="card-body" style="padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                        <div style="font-size: 11px; color: var(--primary); font-weight: 800; letter-spacing: 0.1em;">
                            {{ strtoupper($listing->city) }}</div>
                        <div
                            style="display: flex; align-items: center; gap: 4px; color: #fbbf24; font-size: 12px; font-weight: 800;">
                            ★ 4.8 <span
                                style="font-weight: 500; font-size: 10px; color: var(--text-muted); opacity: 0.7;">(12)</span>
                        </div>
                    </div>

                    <h3
                        style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 12px; font-family: 'Syne'; line-height: 1.3;">
                        {{ $listing->name }}</h3>

                    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px;">
                        @foreach(array_slice($listing->facilities ?? [], 0, 3) as $facility)
                            <span
                                style="font-size: 10px; font-weight: 700; background: #f3f4f6; color: var(--text-muted); padding: 4px 10px; border-radius: 6px;">{{ strtoupper($facility) }}</span>
                        @endforeach
                    </div>

                    <div
                        style="padding-top: 20px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                        <div
                            style="display: flex; align-items: center; gap: 6px; color: var(--text-muted); font-size: 11px; font-weight: 600;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            {{ strtoupper($listing->district) }}
                        </div>

                        <form action="{{ route('pencari-kos.favorites.toggle', $listing->id) }}" method="POST"
                            onclick="event.stopPropagation()">
                            @csrf
                            <button type="submit"
                                style="background: none; border: none; cursor: pointer; color: #ef4444; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s;"
                                class="fav-btn">
                                @php
                                    $isFav = \App\Models\Favorite::where('user_id', auth()->id())->where('listing_id', $listing->id)->exists();
                                @endphp
                                <svg viewBox="0 0 24 24" width="22" height="22" fill="{{ $isFav ? 'currentColor' : 'none' }}"
                                    stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 120px 0;">
                <div style="font-size: 80px; margin-bottom: 32px; filter: grayscale(1); opacity: 0.5;">🔎</div>
                <h2 style="font-family: 'Syne'; font-weight: 800; font-size: 28px;">Audit Lokasi Tidak Ditemukan</h2>
                <p style="color: var(--text-muted); margin-top: 12px; max-width: 400px; margin-left: auto; margin-right: auto;">
                    Properti yang Anda cari saat ini belum terdaftar atau tidak lolos validasi audit kami.</p>
                <a href="{{ route('pencari-kos.discovery.index') }}" class="btn btn-primary"
                    style="margin-top: 32px; padding: 14px 40px; border-radius: 100px;">RESET EKSPLORASI STRATEGIS</a>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 60px; display: flex; justify-content: center;">
        {{ $listings->links() }}
    </div>

    <style>
        .listing-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 40px 60px -15px rgba(0, 0, 0, 0.1), 0 20px 30px -10px rgba(0, 0, 0, 0.05);
            border-color: var(--primary);
        }

        .listing-card:hover .list-img {
            transform: scale(1.1);
        }

        .premium-highlight {
            border: 2px solid #fbbf24 !important;
            box-shadow: 0 10px 40px -10px rgba(251, 191, 36, 0.2);
            position: relative;
        }

        .premium-highlight::after {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
            pointer-events: none;
        }

        .premium-highlight:hover::after {
            left: 100%;
            transition: 0.8s;
        }

        .premium-highlight:hover {
            box-shadow: 0 30px 60px -15px rgba(251, 191, 36, 0.4);
        }

        .fav-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            transform: scale(1.1);
        }
    </style>
@endsection