@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Properti</h1>
        <p class="page-subtitle">Perbarui informasi unit: <strong>{{ $listing->name }}</strong></p>
    </div>
    <div class="page-actions">
        <a href="{{ route('pemilik-kos.listings.index') }}" class="btn btn-outline">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali
        </a>
    </div>
</div>

@if($listing->status === 'Rejected')
    <div style="background: rgba(239, 68, 68, 0.08); border: 1.5px solid var(--danger); color: var(--danger); padding: 20px; border-radius: var(--radius); margin-bottom: 24px; display: flex; gap: 16px; align-items: flex-start;">
        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <div style="font-weight: 800; font-size: 15px; margin-bottom: 4px;">Ditolak oleh Admin</div>
            <div style="font-size: 13px; opacity: 0.9; line-height: 1.5;">Alasan: <strong>{{ $listing->rejection_reason }}</strong></div>
            @if($listing->rejection_notes)
                <div style="font-size: 13px; opacity: 0.9; margin-top: 4px; padding: 10px; background: rgba(0,0,0,0.03); border-radius: 6px;">Catatan: <em>{{ $listing->rejection_notes }}</em></div>
            @endif
            <div style="margin-top: 10px; font-size: 12px; font-weight: 700; color: var(--danger);">Silakan perbarui data di bawah ini dan simpan kembali untuk peninjauan ulang.</div>
        </div>
    </div>
@endif

<form action="{{ route('pemilik-kos.listings.update', $listing->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="two-col">
        <div class="main-form">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9.5L12 3l9 6.5V21H3V9.5z"/></svg>
                        Informasi Dasar
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Nama Properti</label>
                        <input type="text" name="name" class="form-input" placeholder="Contoh: Kos Premium Cempaka" value="{{ old('name', $listing->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Google Maps Link</label>
                        <input type="url" name="map_link" class="form-input" placeholder="https://maps.google.com/..." value="{{ old('map_link', $listing->map_link) }}">
                        <p style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Paste link dari Google Maps untuk akurasi lokasi yang lebih baik.</p>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Tipe Kos</label>
                            <select name="type" class="form-input" required style="appearance: auto;">
                                <option value="Putra" {{ old('type', $listing->type) == 'Putra' ? 'selected' : '' }}>Putra</option>
                                <option value="Putri" {{ old('type', $listing->type) == 'Putri' ? 'selected' : '' }}>Putri</option>
                                <option value="Campur" {{ old('type', $listing->type) == 'Campur' ? 'selected' : '' }}>Campur</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kota</label>
                            <input type="text" name="city" class="form-input" placeholder="Padang" value="{{ old('city', $listing->city) }}" required>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="district" class="form-input" placeholder="Padang Timur" value="{{ old('district', $listing->district) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat Lengkap</label>
                            <input type="text" name="address" class="form-input" placeholder="Jl. Raya Utama No. 123..." value="{{ old('address', $listing->address) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi & Peraturan</label>
                        <textarea name="description" class="form-input" rows="4" placeholder="Jelaskan fasilitas dan aturan kos Anda..." required>{{ old('description', $listing->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Fasilitas Umum
                    </div>
                </div>
                <div class="card-body">
                    <style>
                        .fac-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 10px; }
                        .fac-item { 
                            display: flex; align-items: center; gap: 10px; padding: 10px 14px; 
                            background: var(--bg); border: 1.5px solid var(--border); border-radius: var(--radius-sm);
                            cursor: pointer; transition: all .2s; font-size: 13px; font-weight: 500;
                        }
                        .fac-item input { display: none; }
                        .fac-item:hover { border-color: var(--primary); background: var(--surface2); }
                        .fac-item.active { background: var(--primary); color: #fff; border-color: var(--primary); }
                    </style>
                    <div class="fac-grid">
                        @php 
                            $facs = ['WiFi', 'AC', 'Kamar Mandi Dalam', 'Lemari', 'Kasur', 'Meja Belajar', 'Laundry', 'Parkir Motor', 'Parkir Mobil', 'Dapur Umum', 'CCTV']; 
                            $currentFacs = is_array($listing->facilities) ? $listing->facilities : (json_decode($listing->facilities, true) ?? []);
                        @endphp
                        @foreach($facs as $fac)
                            <label class="fac-item {{ in_array($fac, old('facilities', $currentFacs)) ? 'active' : '' }}" id="label-{{ Str::slug($fac) }}">
                                <input type="checkbox" name="facilities[]" value="{{ $fac }}" {{ in_array($fac, old('facilities', $currentFacs)) ? 'checked' : '' }} onchange="this.parentElement.classList.toggle('active', this.checked)">
                                <span>{{ $fac }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar">
            <div class="card" style="border-top: 4px solid var(--primary);">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Harga Sewa Bulanan (Mulai dari)</label>
                        <div style="position:relative;">
                            <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); font-weight:700; color:var(--primary); font-size: 14px;">Rp</span>
                            <input type="number" name="price" class="form-input" style="padding-left:40px; font-weight:800; color:var(--primary); font-size: 18px;" placeholder="1000000" value="{{ old('price', $listing->price) }}" required>
                        </div>
                    </div>
                    <p style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Perubahan harga akan langsung berlaku pada listing publik.</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Media Utama</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="main_photo">Foto Properti</label>
                        <div id="photo-preview" style="width:100%; height:180px; border-radius:12px; background:var(--bg); border:2px dashed var(--border); display:flex; align-items:center; justify-content:center; overflow:hidden; margin-bottom:12px;">
                            @if($listing->main_photo)
                                <img src="{{ asset('storage/'.$listing->main_photo) }}" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:0.3;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            @endif
                        </div>
                        <input type="file" name="main_photo" id="main_photo" class="form-input" accept="image/*" onchange="previewImage(this, 'photo-preview')">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Galeri Interior & Eksterior</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Galeri Saat Ini</label>
                        <style>
                            .gallery-item-card {
                                position: relative; aspect-ratio: 1; border-radius: 16px; 
                                overflow: hidden; border: 1.5px solid var(--border); 
                                transition: all 0.3s ease;
                                cursor: grab;
                            }
                            .gallery-item-card:active { cursor: grabbing; }
                            .gallery-item-card:hover { border-color: var(--primary); transform: translateY(-3px); box-shadow: var(--shadow-md); }
                            .gallery-item-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
                            .gallery-item-card:hover img { transform: scale(1.1); }
                            .delete-btn-overlay {
                                position: absolute; top: 8px; right: 8px; z-index: 10;
                            }
                            .btn-delete-gallery {
                                width: 30px; height: 30px; border-radius: 8px; 
                                background: #ef4444; /* Solid Red */
                                color: #fff; border: 2px solid #fff; 
                                cursor: pointer; display: flex; align-items: center; justify-content: center;
                                transition: all 0.2s ease; 
                                box-shadow: 0 4px 6px rgba(0,0,0,0.2);
                                z-index: 50; /* High z-index */
                            }
                            .btn-delete-gallery:hover { background: #dc2626; transform: scale(1.1); }
                        </style>

                        <div id="sortable-gallery" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 12px; margin-bottom: 24px;">
                            @foreach($listing->images as $image)
                                <div class="gallery-item-card" data-id="{{ $image->id }}">
                                    <img src="{{ asset('storage/'.$image->photo_path) }}">
                                    <div class="delete-btn-overlay">
                                        <button type="button" class="btn-delete-gallery" onclick="deleteGalleryImage('{{ route('pemilik-kos.listings.delete-image', $image->id) }}')">
                                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="3"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2M10 11v6M14 11v6"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <label class="form-label">Tambah Foto Galeri Baru</label>
                        <div id="gallery-preview" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 12px;">
                            <!-- Previews will appear here -->
                        </div>
                        <input type="file" name="listing_images[]" class="form-input" accept="image/*" multiple onchange="previewMultipleImages(this, 'gallery-preview')">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Status Premium</div>
                </div>
                <div class="card-body">
                    @if($listing->is_premium)
                        <div style="padding: 12px; background: rgba(245, 158, 11, 0.1); border: 1.5px solid rgba(245, 158, 11, 0.3); border-radius: 10px; display: flex; align-items: center; gap: 12px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #F59E0B; display: flex; align-items: center; justify-content: center; color: #fff;">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            </div>
                            <div>
                                <div style="font-size: 13px; font-weight: 800; color: #B45309;">Listing Premium Aktif</div>
                                <div style="font-size: 11px; color: #D97706; opacity: 0.8;">Visibilitas maksimal di pencarian.</div>
                            </div>
                        </div>
                    @elseif($listing->premium_status === 'pending')
                        <div style="padding: 12px; background: var(--surface2); border: 1.5px dashed var(--border); border-radius: 10px; display: flex; align-items: center; gap: 12px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--warning); display: flex; align-items: center; justify-content: center; color: #fff;">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <div>
                                <div style="font-size: 13px; font-weight: 800; color: var(--text);">Menunggu Peninjauan</div>
                                <div style="font-size: 11px; color: var(--text-muted);">Request premium sedang diproses.</div>
                            </div>
                        </div>
                    @else
                        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 12px;">Tingkatkan visibilitas properti Anda dengan fitur Premium.</p>
                        <form action="{{ route('pemilik-kos.listings.request-premium', $listing->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline" style="width: 100%; border-style: dashed; color: var(--primary);">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:8px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                Ajukan Premium
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div style="margin-top: 16px;">
                <button type="submit" class="btn btn-blue" style="width:100%; justify-content:center; padding: 14px; font-size: 15px;">Update Properti</button>
            </div>
        </div>
    </div>
</form>

<form id="delete-gallery-form" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Initialize Sortable
    const gallery = document.getElementById('sortable-gallery');
    if (gallery) {
        new Sortable(gallery, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                const order = Array.from(gallery.querySelectorAll('.gallery-item-card')).map(el => el.dataset.id);
                
                fetch("{{ route('pemilik-kos.listings.reorder-images') }}", {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        throw new Error(data.message || 'Server error');
                    }
                    return data;
                })
                .then(data => {
                    if (data.success) {
                        showToast('success', 'Urutan galeri berhasil diperbarui!');
                    }
                })
                .catch(error => {
                    console.error('Reorder Error:', error);
                    showToast('error', 'Gagal memperbarui urutan: ' + error.message);
                });
            }
        });
    }

    function deleteGalleryImage(url) {
        if (confirm('Apakah Anda yakin ingin menghapus foto galeri ini?')) {
            const form = document.getElementById('delete-gallery-form');
            form.action = url;
            form.submit();
        }
    }

    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                preview.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewMultipleImages(input, previewId) {
        const preview = document.getElementById(previewId);
        preview.innerHTML = '';
        if (input.files) {
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.style.width = '100%';
                    div.style.aspectRatio = '1';
                    div.style.borderRadius = '16px';
                    div.style.overflow = 'hidden';
                    div.style.border = '1.5px solid var(--primary)';
                    div.style.boxShadow = 'var(--shadow-sm)';
                    div.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
                    preview.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>
@endsection
