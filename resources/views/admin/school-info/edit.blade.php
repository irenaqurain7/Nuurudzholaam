@extends('layouts.admin')

@section('title', 'Edit Informasi Sekolah')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0; color: var(--hijau-islam);">Edit Informasi Sekolah</h1>
    <a href="{{ route('admin.dashboard') }}" class="admin-btn" style="text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<form method="POST" action="{{ route('admin.school-info.update') }}" enctype="multipart/form-data" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
    @csrf
    @method('PUT')

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        <div>
            <div class="form-group">
                <label for="nama_sekolah">Nama Sekolah *</label>
                <input type="text" id="nama_sekolah" name="nama_sekolah" value="{{ old('nama_sekolah', $school->nama_sekolah ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi *</label>
                <textarea id="deskripsi" name="deskripsi" required>{{ old('deskripsi', $school->deskripsi ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label for="visi">Visi</label>
                <textarea id="visi" name="visi">{{ old('visi', $school->visi ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label for="misi">Misi</label>
                <textarea id="misi" name="misi">{{ old('misi', $school->misi ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat *</label>
                <textarea id="alamat" name="alamat" required>{{ old('alamat', $school->alamat ?? '') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="no_telepon">Nomor Telepon *</label>
                    <input type="tel" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $school->no_telepon ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $school->email ?? '') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="website">Website</label>
                <input type="url" id="website" name="website" value="{{ old('website', $school->website ?? '') }}">
            </div>
        </div>

        <div>
            <div class="form-group">
                <label for="logo">Logo Sekolah</label>
                @if($school && $school->logo)
                <p style="font-size: 12px; color: var(--text-light); margin-bottom: 10px;">
                    <i class="fas fa-image"></i> Logo saat ini:
                    <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" style="max-width: 120px; margin-top: 10px; border-radius: 4px;">
                </p>
                @endif
                <input type="file" id="logo" name="logo" accept="image/*">
                <p style="font-size: 12px; color: var(--text-light); margin-top: 5px;">Format: JPG, PNG. Ukuran maksimal: 2MB</p>
            </div>

            <div class="form-group">
                <label for="gambar_utama">Gambar Utama</label>
                @if($school && $school->gambar_utama)
                <p style="font-size: 12px; color: var(--text-light); margin-bottom: 10px;">
                    <i class="fas fa-image"></i> Gambar saat ini:
                    <img src="{{ asset('storage/' . $school->gambar_utama) }}" alt="Gambar Utama" style="max-width: 100%; margin-top: 10px; border-radius: 4px;">
                </p>
                @endif
                <input type="file" id="gambar_utama" name="gambar_utama" accept="image/*">
                <p style="font-size: 12px; color: var(--text-light); margin-top: 5px;">Format: JPG, PNG. Ukuran maksimal: 2MB</p>
            </div>
        </div>
    </div>

    <div style="display: flex; gap: 15px; margin-top: 30px;">
        <button type="submit" class="admin-btn" style="background-color: #28a745; border: none; cursor: pointer;">
            <i class="fas fa-save"></i> Simpan Perubahan
        </button>
        <a href="{{ route('admin.dashboard') }}" class="admin-btn" style="text-decoration: none; background-color: #6c757d;">
            <i class="fas fa-times"></i> Batal
        </a>
    </div>
</form>

<style>
    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--hijau-islam);
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--hijau-islam);
        box-shadow: 0 0 0 3px rgba(31, 127, 95, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }
</style>
@endsection
