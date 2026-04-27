@extends('layouts.admin')

@section('title', 'Tambah Program')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0; color: var(--hijau-islam);">Tambah Program Baru</h1>
    <a href="{{ route('admin.program.index') }}" class="admin-btn" style="text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div style="max-width: 700px;">
    <form method="POST" action="{{ route('admin.program.store') }}" enctype="multipart/form-data" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        @csrf

        <div class="form-group">
            <label for="nama_program">Nama Program *</label>
            <input type="text" id="nama_program" name="nama_program" value="{{ old('nama_program') }}" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi *</label>
            <textarea id="deskripsi" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-group">
            <label for="kurikulum">Kurikulum</label>
            <textarea id="kurikulum" name="kurikulum">{{ old('kurikulum') }}</textarea>
        </div>

        <div class="form-group">
            <label for="kuota">Kuota Siswa *</label>
            <input type="number" id="kuota" name="kuota" value="{{ old('kuota', 30) }}" min="1" required>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar (Opsional)</label>
            <input type="file" id="gambar" name="gambar" accept="image/*">
            <p style="font-size: 12px; color: var(--text-light); margin-top: 5px;">Format: JPG, PNG. Ukuran maksimal: 2MB</p>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" class="admin-btn" style="background-color: #28a745; border: none; cursor: pointer;">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.program.index') }}" class="admin-btn" style="text-decoration: none; background-color: #6c757d;">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

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
        min-height: 120px;
    }
</style>
@endsection
