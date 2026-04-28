@extends('layouts.admin')

@section('title', 'Edit Kegiatan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0; color: var(--hijau-islam);">Edit Kegiatan</h1>
    <a href="{{ route('admin.activity.index') }}" class="admin-btn" style="text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div style="max-width: 700px;">
    <form method="POST" action="{{ route('admin.activity.update', $activity->id) }}" enctype="multipart/form-data" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="judul">Judul Kegiatan *</label>
            <input type="text" id="judul" name="judul" value="{{ old('judul', $activity->judul) }}" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi *</label>
            <textarea id="deskripsi" name="deskripsi" required>{{ old('deskripsi', $activity->deskripsi) }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="tanggal">Tanggal *</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $activity->tanggal->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori *</label>
                <select id="kategori" name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="kegiatan" @if(old('kategori', $activity->kategori) === 'kegiatan') selected @endif>Kegiatan</option>
                    <option value="dokumentasi" @if(old('kategori', $activity->kategori) === 'dokumentasi') selected @endif>Dokumentasi</option>
                    <option value="berita" @if(old('kategori', $activity->kategori) === 'berita') selected @endif>Berita</option>
                    <option value="pengumuman" @if(old('kategori', $activity->kategori) === 'pengumuman') selected @endif>Pengumuman</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="visibility">Visibilitas *</label>
            <select id="visibility" name="visibility" required>
                <option value="">-- Pilih Visibilitas --</option>
                <option value="publik" @if(old('visibility', $activity->visibility) === 'publik') selected @endif>Publik (Semua orang)</option>
                <option value="ortu" @if(old('visibility', $activity->visibility) === 'ortu') selected @endif>Orang Tua</option>
                <option value="guru" @if(old('visibility', $activity->visibility) === 'guru') selected @endif>Guru</option>
            </select>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar (Opsional)</label>
            @if($activity->gambar)
            <p style="font-size: 12px; color: var(--text-light); margin-bottom: 10px;">
                <i class="fas fa-image"></i> Gambar saat ini:
                <img src="{{ asset('storage/' . $activity->gambar) }}" alt="Current" style="max-width: 150px; margin-top: 10px; border-radius: 4px;">
            </p>
            @endif
            <input type="file" id="gambar" name="gambar" accept="image/*">
            <p style="font-size: 12px; color: var(--text-light); margin-top: 5px;">Format: JPG, PNG. Ukuran maksimal: 2MB. Biarkan kosong untuk tidak mengubah gambar.</p>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" class="admin-btn" style="background-color: #28a745; border: none; cursor: pointer;">
                <i class="fas fa-save"></i> Perbarui
            </button>
            <a href="{{ route('admin.activity.index') }}" class="admin-btn" style="text-decoration: none; background-color: #6c757d;">
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
        min-height: 150px;
    }
</style>
@endsection
