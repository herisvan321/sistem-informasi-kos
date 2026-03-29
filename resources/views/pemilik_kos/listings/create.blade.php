@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Properti</h1>
        <p class="page-subtitle">Daftarkan properti kos baru ke sistem</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('pemilik-kos.listings.index') }}" class="btn btn-outline">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali
        </a>
    </div>
</div>

<form action="{{ route('pemilik-kos.listings.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
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
                        <input type="text" name="name" class="form-input" placeholder="Contoh: Kos Premium Cempaka" value="{{ old('name') }}" required>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Tipe Kos</label>
                            <select name="type" class="form-input" required style="appearance: auto;">
                                <option value="Putra" {{ old('type') == 'Putra' ? 'selected' : '' }}>Putra</option>
                                <option value="Putri" {{ old('type') == 'Putri' ? 'selected' : '' }}>Putri</option>
                                <option value="Campur" {{ old('type') == 'Campur' ? 'selected' : '' }}>Campur</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kota</label>
                            <input type="text" name="city" class="form-input" placeholder="Padang" value="{{ old('city') }}" required>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="district" class="form-input" placeholder="Padang Timur" value="{{ old('district') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat Lengkap</label>
                            <input type="text" name="address" class="form-input" placeholder="Jl. Raya Utama No. 123..." value="{{ old('address') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi & Peraturan</label>
                        <textarea name="description" class="form-input" rows="4" placeholder="Jelaskan fasilitas dan aturan kos Anda..." required>{{ old('description') }}</textarea>
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
                        @php $facs = ['WiFi', 'AC', 'Kamar Mandi Dalam', 'Lemari', 'Kasur', 'Meja Belajar', 'Laundry', 'Parkir Motor', 'Parkir Mobil', 'Dapur Umum', 'CCTV']; @endphp
                        @foreach($facs as $fac)
                            <label class="fac-item" id="label-{{ Str::slug($fac) }}">
                                <input type="checkbox" name="facilities[]" value="{{ $fac }}" onchange="this.parentElement.classList.toggle('active', this.checked)">
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
                            <input type="number" name="price" class="form-input" style="padding-left:40px; font-weight:800; color:var(--primary); font-size: 18px;" placeholder="1000000" value="{{ old('price') }}" required>
                        </div>
                    </div>
                    <p style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Harga ini akan ditampilkan sebagai harga dasar ("Mulai dari") pada halaman pencarian.</p>
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
                            <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:0.3;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </div>
                        <input type="file" name="main_photo" id="main_photo" class="form-input" accept="image/*" onchange="previewImage(this)">
                    </div>
                </div>
            </div>

            <div style="margin-top: 16px;">
                <button type="submit" class="btn btn-blue" style="width:100%; justify-content:center; padding: 14px; font-size: 15px;">Simpan Properti</button>
            </div>
        </div>
    </div>
</form>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('photo-preview');
                preview.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
