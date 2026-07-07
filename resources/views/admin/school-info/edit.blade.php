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

            <!-- PPDB Settings Section -->
            <div style="background-color: #f0f4f8; padding: 20px; border-radius: 8px; border-left: 4px solid var(--hijau-islam); margin-top: 30px;">
                <h3 style="color: var(--hijau-islam); margin-top: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-calendar-alt"></i> Pengaturan Periode PPDB
                </h3>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" id="ppdb_active" name="ppdb_active" value="1" @if(old('ppdb_active', $school->ppdb_active ?? false)) checked @endif style="width: auto; padding: 0; margin: 0;">
                        <span style="margin: 0; color: var(--text-dark); font-weight: 600;">Aktifkan PPDB</span>
                    </label>
                    <p style="font-size: 12px; color: var(--text-light); margin-top: 8px; margin-bottom: 0;">Centang untuk mengaktifkan pendaftaran PPDB</p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                    <div class="form-group">
                        <label for="ppdb_start_date">Tanggal Mulai PPDB</label>
                        <input type="date" id="ppdb_start_date" name="ppdb_start_date" value="{{ old('ppdb_start_date', $school->ppdb_start_date?->format('Y-m-d') ?? '') }}">
                        <p style="font-size: 12px; color: var(--text-light); margin-top: 5px;">Tanggal dimulainya pendaftaran PPDB</p>
                    </div>

                    <div class="form-group">
                        <label for="ppdb_end_date">Tanggal Akhir PPDB</label>
                        <input type="date" id="ppdb_end_date" name="ppdb_end_date" value="{{ old('ppdb_end_date', $school->ppdb_end_date?->format('Y-m-d') ?? '') }}">
                        <p style="font-size: 12px; color: var(--text-light); margin-top: 5px;">Tanggal berakhirnya pendaftaran PPDB</p>
                    </div>
                </div>

                <div style="background-color: #e8f5e9; border: 1px solid #c8e6c9; padding: 12px; border-radius: 6px; margin-top: 15px; display: flex; gap: 10px;">
                    <i class="fas fa-info-circle" style="color: #2e7d32; flex-shrink: 0; margin-top: 2px;"></i>
                    <p style="color: #2e7d32; margin: 0; font-size: 13px;">
                        <strong>Informasi:</strong> Formulir PPDB hanya dapat diisi ketika tanggal saat ini berada dalam periode yang telah ditentukan dan PPDB diaktifkan.
                    </p>
                </div>
            </div>
            </div>

            <!-- Pilar Pendidikan Section -->
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid var(--emas); margin-top: 30px;">
                <h3 style="color: var(--hijau-islam); margin-top: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-landmark"></i> Pilar Pendidikan Utama
                </h3>
                <p style="font-size: 13px; color: var(--text-light); margin-bottom: 20px;">Atur 4 Pilar Pendidikan Utama yang tampil di Halaman Depan.</p>

                @php
                    $pilars = old('pilar_pendidikan', $school->pilar_pendidikan ?? [
                        ['icon' => 'fas fa-brain', 'judul' => 'Olah Pikir (Literasi)', 'deskripsi' => 'Mengasah daya pikir dan intelektual agar peserta didik memiliki pemikiran kritis, luas dan tajam.'],
                        ['icon' => 'fas fa-heart', 'judul' => 'Olah Hati (Etika/Spiritual)', 'deskripsi' => 'Membina akhlak, moral dan budi pekerti luhur sehingga peserta didik menjadi individu yang berkarakter dan berintegritas.'],
                        ['icon' => 'fas fa-palette', 'judul' => 'Olah Rasa (Estetika)', 'deskripsi' => 'Menumbuhkan kepekaan perasaan, welas asih dan apresiasi terhadap keindahan serta seni.'],
                        ['icon' => 'fas fa-bolt', 'judul' => 'Olah Karsa (Kinestetik/Kemauan)', 'deskripsi' => 'Mengembangkan kemauan keras, semangat juang, kreativitas dan inovasi.']
                    ]);
                @endphp

                @for($i = 0; $i < 4; $i++)
                <div style="background-color: white; border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px; margin-bottom: 15px;">
                    <h4 style="margin-top: 0; margin-bottom: 15px; color: var(--hijau-islam); font-size: 14px;">Pilar {{ $i + 1 }}</h4>
                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px;">
                        <div class="form-group" style="margin-bottom: 10px;">
                            <label>Icon (FontAwesome)</label>
                            <input type="text" name="pilar_pendidikan[{{ $i }}][icon]" value="{{ $pilars[$i]['icon'] ?? '' }}" placeholder="Contoh: fas fa-brain">
                        </div>
                        <div class="form-group" style="margin-bottom: 10px;">
                            <label>Judul Pilar</label>
                            <input type="text" name="pilar_pendidikan[{{ $i }}][judul]" value="{{ $pilars[$i]['judul'] ?? '' }}" placeholder="Judul Pilar">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Deskripsi Pilar</label>
                        <textarea name="pilar_pendidikan[{{ $i }}][deskripsi]" rows="2" style="min-height: unset; height: 60px;" placeholder="Deskripsi Pilar">{{ $pilars[$i]['deskripsi'] ?? '' }}</textarea>
                    </div>
                </div>
                @endfor
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

    .form-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--hijau-islam);
    }

    .form-group input:not([type="checkbox"]),
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

    .form-group input:not([type="checkbox"]):focus,
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
