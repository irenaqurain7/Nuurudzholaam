@extends('layouts.admin')

@section('title', 'Edit FAQ')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0; color: var(--hijau-islam);">Edit FAQ</h1>
    <a href="{{ route('admin.faq.index') }}" class="admin-btn" style="text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div style="max-width: 700px;">
    <form method="POST" action="{{ route('admin.faq.update', $faq->id) }}" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="pertanyaan">Pertanyaan *</label>
            <input type="text" id="pertanyaan" name="pertanyaan" value="{{ old('pertanyaan', $faq->pertanyaan) }}" required>
        </div>

        <div class="form-group">
            <label for="jawaban">Jawaban *</label>
            <textarea id="jawaban" name="jawaban" required>{{ old('jawaban', $faq->jawaban) }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="kategori">Kategori *</label>
                <select id="kategori" name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="umum" @if(old('kategori', $faq->kategori) === 'umum') selected @endif>Umum</option>
                    <option value="ppdb" @if(old('kategori', $faq->kategori) === 'ppdb') selected @endif>PPDB</option>
                    <option value="akademik" @if(old('kategori', $faq->kategori) === 'akademik') selected @endif>Akademik</option>
                    <option value="fasilitas" @if(old('kategori', $faq->kategori) === 'fasilitas') selected @endif>Fasilitas</option>
                </select>
            </div>

            <div class="form-group">
                <label for="urutan">Urutan *</label>
                <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $faq->urutan) }}" min="0" required>
            </div>
        </div>

        <div style="display: flex; gap: 15px;">
            <button type="submit" class="admin-btn" style="background-color: #28a745; border: none; cursor: pointer;">
                <i class="fas fa-save"></i> Perbarui
            </button>
            <a href="{{ route('admin.faq.index') }}" class="admin-btn" style="text-decoration: none; background-color: #6c757d;">
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
