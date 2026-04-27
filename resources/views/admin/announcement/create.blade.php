@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0; color: var(--hijau-islam);">Tambah Pengumuman</h1>
    <a href="{{ route('admin.announcement.index') }}" class="admin-btn" style="text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div style="max-width: 700px;">
    <form method="POST" action="{{ route('admin.announcement.store') }}" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        @csrf

        <div class="form-group">
            <label for="judul">Judul *</label>
            <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required>
        </div>

        <div class="form-group">
            <label for="konten">Konten *</label>
            <textarea id="konten" name="konten" required>{{ old('konten') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="tipe">Tipe *</label>
                <select id="tipe" name="tipe" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="umum" @if(old('tipe') === 'umum') selected @endif>Umum</option>
                    <option value="ppdb" @if(old('tipe') === 'ppdb') selected @endif>PPDB</option>
                    <option value="libur" @if(old('tipe') === 'libur') selected @endif>Libur</option>
                    <option value="penting" @if(old('tipe') === 'penting') selected @endif>Penting</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" required>
                    <option value="aktif" @if(old('status', 'aktif') === 'aktif') selected @endif>Aktif</option>
                    <option value="arsip" @if(old('status') === 'arsip') selected @endif>Arsip</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai *</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', now()->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label for="tanggal_selesai">Tanggal Selesai</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
            </div>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" class="admin-btn" style="background-color: #28a745; border: none; cursor: pointer;">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.announcement.index') }}" class="admin-btn" style="text-decoration: none; background-color: #6c757d;">
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
