@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Listing</h1>
        <p class="page-subtitle">Perbarui informasi untuk {{ $listing->name }}</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('admin.listings.index') }}" class="btn btn-outline">Batal</a>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form action="{{ route('admin.listings.update', $listing->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Kos</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $listing->name) }}" required>
                @error('name') <small style="color:var(--danger);">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Alamat Lengkap</label>
                <textarea name="address" class="form-input" rows="3" required>{{ old('address', $listing->address) }}</textarea>
                @error('address') <small style="color:var(--danger);">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Harga Per Bulan</label>
                <input type="number" name="price" class="form-input" value="{{ old('price', $listing->price) }}" required>
                @error('price') <small style="color:var(--danger);">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Status Moderasi</label>
                <select name="status" class="form-input">
                    <option value="Pending" {{ $listing->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Approved" {{ $listing->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Rejected" {{ $listing->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <button type="submit" class="btn btn-blue">Perbarui Listing</button>
        </form>
    </div>
</div>
@endsection
