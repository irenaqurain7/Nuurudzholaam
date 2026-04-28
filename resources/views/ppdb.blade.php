@extends('layouts.app')

@section('title', 'PPDB - Penerimaan Peserta Didik Baru')

@section('content')
<!-- Hero Section -->
<div class="hero">
    <div class="container">
        <h1>Program PPDB Tahun Ini</h1>
        <p>Daftar sekarang dan raih kesempatan emas untuk bergabung dengan kami</p>
    </div>
</div>

<!-- Main Content -->
<div class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: start;">
            <!-- Left Column - Info -->
            <div>
                <h2 class="section-title" style="text-align: left;">Informasi PPDB</h2>
                
                @if($announcements)
                <div class="card mb-30">
                    <h3 style="color: var(--hijau-islam); margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-bell" style="color: var(--emas);"></i>
                        Pengumuman
                    </h3>
                    <p>{{ $announcements->konten }}</p>
                </div>
                @endif

                <div class="card mb-30">
                    <h3 style="color: var(--hijau-islam); margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-list" style="color: var(--emas);"></i>
                        Persyaratan Pendaftaran
                    </h3>
                    <ul style="list-style: none;">
                        <li style="padding: 10px 0; border-bottom: 1px solid #e2e8f0; display: flex; align-items: flex-start; gap: 10px;">
                            <i class="fas fa-check" style="color: var(--hijau-islam); margin-top: 2px;"></i>
                            <span>Fotokopi rapor terakhir yang dilegalisir</span>
                        </li>
                        <li style="padding: 10px 0; border-bottom: 1px solid #e2e8f0; display: flex; align-items: flex-start; gap: 10px;">
                            <i class="fas fa-check" style="color: var(--hijau-islam); margin-top: 2px;"></i>
                            <span>Fotokopi Kartu Keluarga yang dilegalisir</span>
                        </li>
                        <li style="padding: 10px 0; border-bottom: 1px solid #e2e8f0; display: flex; align-items: flex-start; gap: 10px;">
                            <i class="fas fa-check" style="color: var(--hijau-islam); margin-top: 2px;"></i>
                            <span>Surat rekomendasi dari sekolah asal</span>
                        </li>
                        <li style="padding: 10px 0; border-bottom: 1px solid #e2e8f0; display: flex; align-items: flex-start; gap: 10px;">
                            <i class="fas fa-check" style="color: var(--hijau-islam); margin-top: 2px;"></i>
                            <span>Sertifikat penghargaan (jika ada)</span>
                        </li>
                        <li style="padding: 10px 0; display: flex; align-items: flex-start; gap: 10px;">
                            <i class="fas fa-check" style="color: var(--hijau-islam); margin-top: 2px;"></i>
                            <span>Fotokopi KTP orang tua</span>
                        </li>
                    </ul>
                </div>

                <div class="card">
                    <h3 style="color: var(--hijau-islam); margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-graduation-cap" style="color: var(--emas);"></i>
                        Program yang Tersedia
                    </h3>
                    <div style="display: grid; gap: 15px;">
                        @foreach($programs as $program)
                        <div style="padding: 15px; background-color: #f7fafc; border-left: 4px solid var(--emas); border-radius: 4px;">
                            <h4 style="color: var(--hijau-islam); margin-bottom: 5px;">{{ $program->nama_program }}</h4>
                            <p style="font-size: 14px; color: var(--text-light); margin: 0;">
                                Kuota: <strong>{{ $program->kuota }} siswa</strong>
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column - Form -->
            <div>
                <h2 class="section-title" style="text-align: left;">Formulir Pendaftaran</h2>
                
                @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle" style="font-size: 20px;"></i>
                    <div>
                        <strong>Terjadi kesalahan:</strong>
                        <ul style="margin-top: 10px; margin-left: 20px;">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle" style="font-size: 20px;"></i>
                    <div>
                        <strong>Sukses!</strong>
                        <p style="margin-top: 5px;">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('ppdb.store') }}" class="card">
                    @csrf

                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap *</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="no_telepon">Nomor Telepon *</label>
                        <input type="tel" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir *</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="asal_sekolah">Asal Sekolah *</label>
                        <input type="text" id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="program">Pilih Program *</label>
                        <select id="program" name="program" required>
                            <option value="">-- Pilih Program --</option>
                            <option value="ipa" @if(old('program') === 'ipa') selected @endif>IPA (Science)</option>
                            <option value="ips" @if(old('program') === 'ips') selected @endif>IPS (Social)</option>
                            <option value="keagamaan" @if(old('program') === 'keagamaan') selected @endif>Program Keagamaan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat Lengkap *</label>
                        <textarea id="alamat" name="alamat" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="nama_ortu">Nama Orang Tua/Wali *</label>
                        <input type="text" id="nama_ortu" name="nama_ortu" value="{{ old('nama_ortu') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="no_ortu">Nomor Telepon Orang Tua/Wali *</label>
                        <input type="tel" id="no_ortu" name="no_ortu" value="{{ old('no_ortu') }}" required>
                    </div>

                    <div style="background-color: #f7fafc; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid var(--emas);">
                        <p style="font-size: 13px; color: var(--text-light); margin: 0;">
                            <i class="fas fa-info-circle" style="color: var(--hijau-islam); margin-right: 8px;"></i>
                            <strong>Catatan:</strong> Dokumen pendukung dapat diunggah di kantor sekolah setelah Anda menyelesaikan pendaftaran ini.
                        </p>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%; padding: 15px; font-size: 16px;">
                        <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
                    </button>
                </form>

                <div style="margin-top: 30px; padding: 20px; background-color: #d4edda; border-radius: 8px; border-left: 4px solid #28a745;">
                    <h4 style="color: #155724; margin-bottom: 10px;">
                        <i class="fas fa-check-circle"></i> Langkah Berikutnya
                    </h4>
                    <ol style="color: #155724; margin: 0; padding-left: 20px;">
                        <li>Isi formulir pendaftaran dengan lengkap</li>
                        <li>Kami akan menghubungi Anda dalam 24 jam</li>
                        <li>Bawa dokumen pendukung ke kantor sekolah</li>
                        <li>Selesai dan tunggu pengumuman hasil</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
