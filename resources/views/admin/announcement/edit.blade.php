@extends('layouts.admin')

@section('title', 'Edit Pengumuman')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #eaedf1; padding-bottom: 15px;">
    <div>
        <h1 style="margin: 0; color: var(--hijau-islam); font-size: 28px; font-weight: 700;">Edit Pengumuman</h1>
        <p style="margin: 5px 0 0 0; color: #718096; font-size: 14px;">Perbarui data atau informasi pengumuman yang sudah diterbitkan.</p>
    </div>
    <a href="{{ route('admin.announcement.index') }}" class="admin-btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@if ($errors->any())
<div style="background-color: #ffff; border-left: 4px solid #e53e3e; padding: 15px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); margin-bottom: 25px; display: flex; gap: 15px;">
    <i class="fas fa-exclamation-circle" style="font-size: 18px; color: #e53e3e; margin-top: 3px;"></i>
    <div>
        <strong style="color: #e53e3e; font-size: 15px;">Periksa kembali isian Anda:</strong>
        <ul style="margin: 5px 0 0 0; padding-left: 20px; color: #4a5568; font-size: 14px; line-height: 1.5;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div style="max-width: 800px; margin: 0 auto;">
    <form method="POST" action="{{ route('admin.announcement.update', $announcement->id) }}" style="background: white; padding: 35px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="judul">Judul Pengumuman <span class="required">*</span></label>
            <input type="text" id="judul" name="judul" value="{{ old('judul', $announcement->judul) }}" placeholder="Contoh: Jadwal Pelaksanaan Libur Semester Akhir" required>
        </div>

        <div class="form-group">
            <label for="konten">Konten / Isi Pengumuman <span class="required">*</span></label>
            <textarea id="konten" name="konten" placeholder="Tuliskan detail pengumuman secara lengkap di sini..." required>{{ old('konten', $announcement->konten) }}</textarea>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label for="tipe">Tipe Pengumuman <span class="required">*</span></label>
                <div class="select-wrapper">
                    <select id="tipe" name="tipe" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="umum" @if(old('tipe', $announcement->tipe) === 'umum') selected @endif>Umum</option>
                        <option value="ppdb" @if(old('tipe', $announcement->tipe) === 'ppdb') selected @endif>PPDB</option>
                        <option value="libur" @if(old('tipe', $announcement->tipe) === 'libur') selected @endif>Libur</option>
                        <option value="penting" @if(old('tipe', $announcement->tipe) === 'penting') selected @endif>Penting</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status Publikasi <span class="required">*</span></label>
                <div class="select-wrapper">
                    <select id="status" name="status" required>
                        <option value="aktif" @if(old('status', $announcement->status) === 'aktif') selected @endif>Aktif (Tampilkan)</option>
                        <option value="arsip" @if(old('status', $announcement->status) === 'arsip') selected @endif>Arsip (Sembunyikan)</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-grid-2" style="margin-bottom: 10px;">
            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai Tampil <span class="required">*</span></label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $announcement->tanggal_mulai ? $announcement->tanggal_mulai->format('Y-m-d') : '') }}" required>
            </div>

            <div class="form-group">
                <label for="tanggal_selesai">Tanggal Selesai Tampil <span class="optional">(Opsional)</span></label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $announcement->tanggal_selesai ? $announcement->tanggal_selesai->format('Y-m-d') : '') }}">
            </div>
        </div>

        <hr style="border: 0; border-top: 1px solid #edf2f7; margin: 30px 0 25px 0;">

        <div style="display: flex; justify-content: flex-end; gap: 12px;">
            <a href="{{ route('admin.announcement.index') }}" class="btn-cancel">
                <i class="fas fa-times"></i> Batalkan
            </a>
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<style>
    /* Form Utilities */
    .form-group {
        margin-bottom: 22px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 600px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }

    /* Labels */
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #344054;
    }

    .form-group label .required {
        color: #e53e3e;
        margin-left: 2px;
    }

    .form-group label .optional {
        color: #a0aec0;
        font-size: 12px;
        font-weight: 400;
        margin-left: 4px;
    }

    /* Input Controls */
    .form-group input[type="text"],
    .form-group input[type="date"],
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d0d5dd;
        border-radius: 8px;
        font-size: 15px;
        color: #1d2939;
        background-color: #ffffff;
        box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05);
        transition: all 0.2s ease-in-out;
        font-family: inherit;
        box-sizing: border-box;
    }

    /* Focus States */
    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--hijau-islam);
        box-shadow: 0 0 0 4px rgba(31, 127, 95, 0.12);
    }

    /* Textarea Customization */
    .form-group textarea {
        resize: vertical;
        min-height: 160px;
        line-height: 1.5;
    }

    /* Custom Buttons styling */
    .admin-btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        background-color: #ffffff;
        color: #344054;
        border: 1px solid #d0d5dd;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05);
        transition: background-color 0.2s;
    }

    .admin-btn-secondary:hover {
        background-color: #f9fafb;
        color: #1d2939;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background-color: var(--hijau-islam);
        color: white;
        border: 1px solid var(--hijau-islam);
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05);
        transition: background-color 0.2s, transform 0.1s;
    }

    .btn-submit:hover {
        opacity: 0.95;
    }

    .btn-submit:active {
        transform: scale(0.98);
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background-color: #ffffff;
        color: #4a5568;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background-color: #f7fafc;
        color: #2d3748;
        border-color: #cbd5e1;
    }
</style>
@endsection
