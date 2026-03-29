@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <div
                style="display: flex; gap: 8px; align-items: center; font-size: 11px; font-weight: 800; color: var(--text-muted); opacity: 0.7; letter-spacing: 0.05em;">
                <a href="{{ route('pencari-kos.discovery.index') }}">EKSPLORASI</a>
                <span>/</span>
                <span>{{ strtoupper($listing->city) }}</span>
                <span>/</span>
                <span style="color: var(--primary);">{{ strtoupper($listing->id) }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <h1 class="page-title" style="font-family: 'Syne'; font-weight: 800; font-size: 32px; margin: 0;">{{ $listing->name }}</h1>
                @if($listing->type)
                    <span class="badge badge-{{ $listing->type === 'Putra' ? 'blue' : ($listing->type === 'Putri' ? 'red' : 'amber') }}" 
                        style="padding: 6px 14px; border-radius: 100px; font-weight: 800; font-size: 10px; letter-spacing: 0.05em;">
                        KOS {{ strtoupper($listing->type) }}
                    </span>
                @endif
            </div>        </div>
        <div class="page-actions">
            <form action="{{ route('pencari-kos.favorites.toggle', $listing->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline"
                    style="border-radius: 100px; padding: 12px 24px; font-weight: 800; font-size: 11px; display: flex; align-items: center; gap: 8px;">
                    @php
                        $isFav = \App\Models\Favorite::where('user_id', auth()->id())->where('listing_id', $listing->id)->exists();
                    @endphp
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="{{ $isFav ? '#ef4444' : 'none' }}"
                        stroke="{{ $isFav ? '#ef4444' : 'currentColor' }}" stroke-width="2.5">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                    </svg>
                    {{ $isFav ? 'DI FAVORIT' : 'SIMPAN KE FAVORIT' }}
                </button>
            </form>
        </div>
    </div>

    <div class="detail-gallery"
        style="display: grid; grid-template-columns: 2fr 1fr; grid-template-rows: 240px 240px; gap: 20px; margin-bottom: 40px;">
        <div class="gallery-main"
            style="grid-row: span 2; border-radius: 24px; overflow: hidden; background: #eee; position: relative; cursor: pointer;"
            onclick="openLightbox(0)">
            @if($listing->main_photo)
                <img src="{{ asset('storage/' . $listing->main_photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <div
                    style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 80px; background: linear-gradient(135deg, var(--primary) 0%, #4338ca 100%); color: #fff;">
                    🏢</div>
            @endif
            @if($listing->is_premium)
                <div
                    style="position: absolute; bottom: 30px; left: 30px; background: rgba(0,0,0,0.6); backdrop-filter: blur(10px); padding: 12px 24px; border-radius: 100px; color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.3); font-family: 'Syne'; font-weight: 800; font-size: 11px; letter-spacing: 0.1em; display: flex; align-items: center; gap: 8px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor">
                        <path
                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                    </svg>
                    PREMIUM CERTIFIED ASSET
                </div>
            @endif
        </div>
        
        @php
            $additionalImages = $listing->images()->take(2)->get();
            $totalAdditionalCount = $listing->images()->count();
        @endphp

        @foreach($additionalImages as $index => $image)
            <div class="gallery-sub" 
                style="border-radius: 24px; overflow: hidden; background: #ddd; position: relative; cursor: pointer;"
                onclick="openLightbox({{ $index + 1 }})">
                <img src="{{ asset('storage/' . $image->photo_path) }}"
                    style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9; transition: 0.3s;" 
                    onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">
                
                @if($index === 1 && $totalAdditionalCount > 2)
                    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; color: #fff; font-family: 'Syne'; font-weight: 800; font-size: 24px; pointer-events: none;">
                        +{{ $totalAdditionalCount - 2 }} INTERIOR
                    </div>
                @endif
            </div>
        @endforeach

        @if($totalAdditionalCount === 0)
            <div class="gallery-sub" style="border-radius: 24px; overflow: hidden; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 11px; font-weight: 700;">
                NO INTERIOR PHOTO
            </div>
            <div class="gallery-sub" style="border-radius: 24px; overflow: hidden; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 11px; font-weight: 700;">
                NO INTERIOR PHOTO
            </div>
        @elseif($totalAdditionalCount === 1)
            <div class="gallery-sub" style="border-radius: 24px; overflow: hidden; background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 11px; font-weight: 700;">
                NO INTERIOR PHOTO
            </div>
        @endif
    </div>

    <div class="two-col">
        <div class="dashboard-main">
            <div class="card" style="margin-bottom: 32px;">
                <div class="card-header">
                    <div class="card-title" style="font-family: 'Syne'; font-weight: 800;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
                        </svg>
                        Manifest Properti & Deskripsi
                    </div>
                </div>
                <div class="card-body">
                    <div style="line-height: 1.8; color: var(--text-muted); font-size: 15px; font-weight: 500;">
                        {{ $listing->description }}
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom: 32px;">
                <div class="card-header">
                    <div class="card-title" style="font-family: 'Syne'; font-weight: 800;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                            <line x1="9" y1="3" x2="9" y2="21" />
                            <line x1="15" y1="3" x2="15" y2="21" />
                            <line x1="3" y1="9" x2="21" y2="9" />
                            <line x1="3" y1="15" x2="21" y2="15" />
                        </svg>
                        Infrastruktur & Fasilitas
                    </div>
                </div>
                <div class="card-body">
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px;">
                        @foreach($listing->facilities as $facility)
                            <div
                                style="display: flex; align-items: center; gap: 12px; padding: 14px; background: #f9fafb; border-radius: 16px; border: 1px solid var(--border);">
                                <div
                                    style="background: var(--primary); color: #fff; width: 24px; height: 24px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800;">
                                    ✓</div>
                                <span
                                    style="font-size: 13px; font-weight: 700; color: var(--text);">{{ strtoupper($facility) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-family: 'Syne'; font-weight: 800;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        Lokasi Strategis & Pemetaan
                    </div>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div style="padding: 24px; display: flex; align-items: center; gap: 16px;">
                        <div style="font-size: 28px;">📍</div>
                        <div>
                            <div style="font-weight: 800; font-family: 'Syne'; color: var(--text);">{{ $listing->address }}
                            </div>
                            <div style="font-size: 12px; font-weight: 600; color: var(--text-muted); opacity: 0.7;">
                                {{ strtoupper($listing->district) }}, {{ strtoupper($listing->city) }}</div>
                        </div>
                    </div>
                    <div style="height: 340px;">
                        @if($listing->map_link)
                            <iframe width="100%" height="100%" frameborder="0" scrolling="no"
                                src="{{ str_contains($listing->map_link, 'embed') ? $listing->map_link : 'https://maps.google.com/maps?q=' . urlencode(str_replace(['https://goo.gl/maps/', 'https://maps.app.goo.gl/'], '', $listing->map_link)) . '&t=&z=14&ie=UTF8&iwloc=&output=embed' }}"
                                style="filter: grayscale(0.5) contrast(1.2); border-bottom-left-radius: 24px; border-bottom-right-radius: 24px;">
                            </iframe>
                        @else
                            <iframe width="100%" height="100%" frameborder="0" scrolling="no"
                                src="https://maps.google.com/maps?q={{ urlencode($listing->address . ' ' . $listing->city) }}&t=&z=14&ie=UTF8&iwloc=&output=embed"
                                style="filter: grayscale(0.5) contrast(1.2); border-bottom-left-radius: 24px; border-bottom-right-radius: 24px;">
                            </iframe>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-sidebar">
            <div class="card"
                style="position: sticky; top: 24px; border: 2px solid var(--primary); box-shadow: 0 30px 60px -15px rgba(var(--primary-rgb), 0.2);">
                <div class="card-body" style="padding: 32px;">
                    <div style="margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px dashed var(--border);">
                        <div
                            style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; font-weight: 800; letter-spacing: 0.1em; margin-bottom: 12px;">
                            STRUKTUR VALUASI BULANAN</div>
                        <div style="display: flex; align-items: baseline; gap: 8px;">
                            <span style="font-size: 34px; font-weight: 800; color: var(--primary); font-family: 'Syne';">Rp
                                {{ number_format($listing->price, 0, ',', '.') }}</span>
                            <span style="font-size: 14px; font-weight: 700; color: var(--text-muted);">/bln</span>
                        </div>
                    </div>

                    <div style="margin-bottom: 32px;">
                        <div
                            style="font-size: 11px; color: var(--text-muted); font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 16px;">
                            KETERSEDIAAN KAMAR</div>
                        @php
                            $availableCount = $listing->rooms()->where('status', 'Available')->count();
                        @endphp
                        @if($availableCount > 0)
                            <div class="badge badge-emerald"
                                style="width: 100%; justify-content: center; padding: 14px; font-size: 13px; font-weight: 800; border-radius: 100px;">
                                <span class="badge-dot"></span> {{ $availableCount }} KAMAR DISIAPKAN
                            </div>
                        @else
                            <div class="badge badge-rose"
                                style="width: 100%; justify-content: center; padding: 14px; font-size: 13px; font-weight: 800; border-radius: 100px;">
                                <span class="badge-dot"></span> KAPASITAS PENUH
                            </div>
                        @endif
                    </div>

                    @if($availableCount > 0)
                        <a href="{{ route('pencari-kos.bookings.create', $listing->id) }}" class="btn btn-primary"
                            style="width: 100%; height: 56px; font-size: 15px; font-weight: 900; letter-spacing: 0.05em; display: flex; align-items: center; justify-content: center; gap: 12px; border-radius: 100px; box-shadow: 0 20px 30px -10px rgba(var(--primary-rgb), 0.4);">
                            BOOKING SEKARANG
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <line x1="5" y1="12" x2="19" y2="12" />
                                <polyline points="12 5 19 12 12 19" />
                            </svg>
                        </a>
                    @endif

                    <div style="margin-top: 24px; text-align: center;">
                        <button type="button" onclick="document.getElementById('inquiry-modal').style.display='flex'"
                            style="color: var(--text-muted); font-size: 12px; font-weight: 800; text-decoration: underline; background: none; border: none; cursor: pointer; opacity: 0.7;">KONSULTASI
                            DENGAN PEMILIK</button>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: 24px;">
                <div class="card-body" style="padding: 24px; display: flex; align-items: center; gap: 16px;">
                    <div
                        style="width: 54px; height: 54px; border-radius: 100px; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-family: 'Syne'; font-size: 20px; box-shadow: 0 10px 20px -5px rgba(var(--primary-rgb), 0.3);">
                        {{ substr($listing->user->name, 0, 1) }}
                    </div>
                    <div>
                        <div style="font-weight: 800; font-family: 'Syne'; font-size: 15px; color: var(--text);">
                            {{ $listing->user->name }}</div>
                        <div style="font-size: 11px; font-weight: 700; color: var(--text-muted); opacity: 0.7;">Verified
                            Provider sejak {{ $listing->user->created_at->format('M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inquiry Modal (Re-styled) -->
    <div id="inquiry-modal"
        style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(10px); z-index: 9999; align-items: center; justify-content: center; padding: 24px;">
        <div class="card"
            style="width: 100%; max-width: 500px; border-radius: 32px; box-shadow: 0 40px 100px -20px rgba(0,0,0,0.4); border: none;">
            <div class="card-header"
                style="padding: 32px; padding-bottom: 0; display: flex; justify-content: space-between; align-items: center; border: none;">
                <h3 class="card-title" style="font-family: 'Syne'; font-weight: 800; font-size: 22px;">Inisiasi Pesan
                    Strategis</h3>
                <button onclick="document.getElementById('inquiry-modal').style.display='none'"
                    style="background: #f3f4f6; border: none; width: 32px; height: 32px; border-radius: 50%; color: var(--text-muted); display: flex; align-items: center; justify-content: center; font-size: 18px; cursor: pointer;">&times;</button>
            </div>
            <div class="card-body" style="padding: 32px;">
                <form action="{{ route('pencari-kos.inquiries.store', $listing->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label"
                            style="font-weight: 800; font-size: 11px; letter-spacing: 0.05em; margin-bottom: 12px;">MANIFES
                            PESAN ✉️</label>
                        <textarea name="message" class="form-input" rows="5"
                            style="border-radius: 20px; padding: 16px; background: #f9fafb; border: 1px solid var(--border);"
                            placeholder="Halo, saya memerlukan konfirmasi mengenai ketersediaan dan validitas data kos ini..."
                            required></textarea>
                    </div>
                    <div style="margin-top: 32px;">
                        <button type="submit" class="btn btn-primary"
                            style="width: 100%; height: 52px; border-radius: 100px; font-weight: 800; font-size: 14px; letter-spacing: 0.05em;">KIRIM
                            MANIFES SEKARANG</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- LIGHTBOX OVERLAY --}}
    <div id="lightbox" 
         style="position: fixed; inset: 0; background: rgba(0,0,0,0.9); backdrop-filter: blur(10px); z-index: 10000; display: none; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease;">
        <button onclick="closeLightbox()" style="position: absolute; top: 30px; right: 30px; background: none; border: none; color: #fff; cursor: pointer; padding: 10px;">
            <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <button onclick="prevImage()" style="position: absolute; left: 30px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); width: 50px; height: 50px; border-radius: 50%; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.2s;">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </button>

        <div id="lightbox-content" style="max-width: 90%; max-height: 80vh; position: relative;">
            <img id="lightbox-img" src="" style="max-width: 100%; max-height: 80vh; border-radius: 12px; object-fit: contain; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
            <div id="lightbox-counter" style="position: absolute; bottom: -40px; left: 50%; transform: translateX(-50%); color: rgba(255,255,255,0.6); font-family: 'Plus Jakarta Sans'; font-size: 13px; font-weight: 600;"></div>
        </div>

        <button onclick="nextImage()" style="position: absolute; right: 30px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); width: 50px; height: 50px; border-radius: 50%; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.2s;">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </button>
    </div>

    <script>
        const allImages = [
            "{{ asset('storage/' . $listing->main_photo) }}",
            @foreach($listing->images as $img)
                "{{ asset('storage/' . $img->photo_path) }}",
            @endforeach
        ];
        let currentIdx = 0;

        function openLightbox(idx) {
            currentIdx = idx;
            updateLightbox();
            const lb = document.getElementById('lightbox');
            lb.style.display = 'flex';
            setTimeout(() => lb.style.opacity = '1', 10);
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const lb = document.getElementById('lightbox');
            lb.style.opacity = '0';
            setTimeout(() => {
                lb.style.display = 'none';
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function updateLightbox() {
            document.getElementById('lightbox-img').src = allImages[currentIdx];
            document.getElementById('lightbox-counter').innerText = `${currentIdx + 1} / ${allImages.length}`;
        }

        function nextImage() {
            currentIdx = (currentIdx + 1) % allImages.length;
            updateLightbox();
        }

        function prevImage() {
            currentIdx = (currentIdx - 1 + allImages.length) % allImages.length;
            updateLightbox();
        }

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (document.getElementById('lightbox').style.display === 'flex') {
                if (e.key === 'ArrowRight') nextImage();
                if (e.key === 'ArrowLeft') prevImage();
                if (e.key === 'Escape') closeLightbox();
            }
        });
    </script>
@endsection