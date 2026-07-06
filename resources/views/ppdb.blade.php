@extends('layouts.app')

@section('title', 'PPDB - Penerimaan Peserta Didik Baru')

@section('content')
<!-- Hero Section -->
<div class="hero-new" style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); padding: 70px 20px 60px; text-align: center; color: white;">
    <div class="container">
        <h1 style="font-size: 40px; margin-bottom: 15px; font-weight: bold;">Formulir Pendaftaran Siswa Baru</h1>
        <p style="font-size: 16px; opacity: 0.95;">Silakan lengkapi formulir di bawah ini dengan data yang benar dan valid.<br>Proses pendaftaran terdiri dari 3 tahapan utama.</p>
    </div>
</div>

<!-- PPDB Status Banner -->
<div class="section" style="background-color: #f5f5f5; padding: 20px 20px 30px;">
    <div class="container">
        @php
            $today = now();
            $ppdbOpen = false;
            $statusMessage = '';
            $statusColor = '#d4af37';
            $statusBgColor = '#fff9e6';
            $statusIcon = 'fas fa-clock';

            if ($school && $school->ppdb_active) {
                if ($school->ppdb_start_date && $school->ppdb_end_date) {
                    $startDate = $school->ppdb_start_date;
                    $endDate = $school->ppdb_end_date;

                    if ($today >= $startDate && $today <= $endDate) {
                        $ppdbOpen = true;
                        $statusMessage = 'Pendaftaran PPDB Dibuka';
                        $statusColor = '#2e7d32';
                        $statusBgColor = '#e8f5e9';
                        $statusIcon = 'fas fa-check-circle';
                    } elseif ($today < $startDate) {
                        $statusMessage = 'Pendaftaran Akan Dibuka';
                        $statusColor = '#1976d2';
                        $statusBgColor = '#e3f2fd';
                        $statusIcon = 'fas fa-hourglass-start';
                    } else {
                        $statusMessage = 'Pendaftaran Telah Ditutup';
                        $statusColor = '#d32f2f';
                        $statusBgColor = '#ffebee';
                        $statusIcon = 'fas fa-times-circle';
                    }
                }
            } else {
                $statusMessage = 'Pendaftaran PPDB Tidak Aktif';
                $statusColor = '#d32f2f';
                $statusBgColor = '#ffebee';
                $statusIcon = 'fas fa-ban';
            }
        @endphp

        <div style="background-color: {{ $statusBgColor }}; border-left: 4px solid {{ $statusColor }}; padding: 20px; border-radius: 8px; display: flex; align-items: center; gap: 20px;">
            <i class="{{ $statusIcon }}" style="font-size: 32px; color: {{ $statusColor }};"></i>
            <div style="flex: 1;">
                <h3 style="color: {{ $statusColor }}; margin: 0 0 8px 0; font-weight: bold;">{{ $statusMessage }}</h3>
                @if ($school && $school->ppdb_start_date && $school->ppdb_end_date)
                <p style="color: {{ $statusColor }}; margin: 0; font-size: 14px;">
                    <strong>Periode Pendaftaran:</strong>
                    {{ $school->ppdb_start_date->format('d F Y') }} - {{ $school->ppdb_end_date->format('d F Y') }}
                </p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="section" style="padding-top: 10px;">
    <div class="container">
        @if ($errors->any())
        <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 8px; margin-bottom: 30px; display: flex; gap: 15px;">
            <i class="fas fa-exclamation-circle" style="font-size: 20px; color: #721c24; flex-shrink: 0; margin-top: 2px;"></i>
            <div>
                <strong style="color: #721c24;">Terjadi kesalahan:</strong>
                <ul style="margin-top: 10px; margin-left: 20px; color: #721c24;">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        @if (session('success'))
        <div style="background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 8px; margin-bottom: 30px; display: flex; gap: 15px;">
            <i class="fas fa-check-circle" style="font-size: 20px; color: #155724; flex-shrink: 0; margin-top: 2px;"></i>
            <div style="color: #155724;">
                <strong>Sukses!</strong>
                <p style="margin-top: 5px;">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('ppdb.store') }}" id="ppdbForm" @if(!$ppdbOpen) style="pointer-events: none; opacity: 0.6;" @endif>
            @csrf

            @if(!$ppdbOpen)
            <div style="background-color: #ffebee; border: 1px solid #ef5350; padding: 20px; border-radius: 8px; margin-bottom: 30px; display: flex; gap: 15px; align-items: center;">
                <i class="fas fa-lock" style="font-size: 24px; color: #d32f2f; flex-shrink: 0;"></i>
                <div style="flex: 1;">
                    <h3 style="color: #d32f2f; margin: 0 0 5px 0; font-weight: bold;">Formulir Pendaftaran Ditutup</h3>
                    <p style="color: #d32f2f; margin: 0; font-size: 14px;">
                        Maaf, pendaftaran PPDB sedang tidak dibuka. Silakan menunggu periode pendaftaran berikutnya atau hubungi sekolah untuk informasi lebih lanjut.
                    </p>
                </div>
            </div>
            @endif

            <!-- Form Steps -->
            <div style="display: flex; justify-content: center; gap: 60px; margin-bottom: 50px; flex-wrap: wrap;">
                <div class="form-step-indicator" data-step="1" style="text-align: center; width: 120px;">
                    <div style="width: 40px; height: 40px; background-color: var(--hijau-islam); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px; margin: 0 auto 10px;">
                        <span class="step-number">1</span>
                    </div>
                    <h3 style="color: var(--hijau-islam); font-size: 14px; margin: 0;">Pilih Jenjang</h3>
                </div>

                <div class="form-step-indicator" data-step="2" style="text-align: center; opacity: 0.5; width: 120px;">
                    <div style="width: 40px; height: 40px; background-color: #ccc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px; margin: 0 auto 10px;">
                        <span class="step-number">2</span>
                    </div>
                    <h3 style="color: #999; font-size: 14px; margin: 0;">Data Siswa</h3>
                </div>

                <div class="form-step-indicator" data-step="3" style="text-align: center; opacity: 0.5; width: 120px;">
                    <div style="width: 40px; height: 40px; background-color: #ccc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px; margin: 0 auto 10px;">
                        <span class="step-number">3</span>
                    </div>
                    <h3 style="color: #999; font-size: 14px; margin: 0;">Data Orang Tua</h3>
                </div>

                <div class="form-step-indicator" data-step="4" style="text-align: center; opacity: 0.5; width: 120px;" id="indicator-step-4">
                    <div style="width: 40px; height: 40px; background-color: #ccc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px; margin: 0 auto 10px;">
                        <span class="step-number">4</span>
                    </div>
                    <h3 style="color: #999; font-size: 14px; margin: 0;">Pilih Jurusan</h3>
                </div>
            </div>

            <!-- Step 1: Pilih Jenjang -->
            <div class="form-step" id="step-1">
                <div class="card">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px; border-bottom: 2px solid var(--hijau-islam); padding-bottom: 12px;">
                        <i class="fas fa-graduation-cap" style="color: var(--hijau-islam); font-size: 24px;"></i>
                        <h2 style="color: var(--hijau-islam); font-size: 24px; margin: 0; font-weight: bold;">Pilih Jenjang Pendidikan</h2>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr; gap: 14px;">
                        <div>
                            <label style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 10px; font-size: 16px;">Pilih Jenjang yang Akan Didaftar <span style="color: red;">*</span></label>
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
                                <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #ddd; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="program-option">
                                    <input type="radio" name="jenjang" value="tk" required style="width: 20px; height: 20px; cursor: pointer;" onchange="handleJenjangChange()">
                                    <div style="margin-left: 15px;">
                                        <h4 style="color: var(--hijau-islam); margin: 0 0 5px 0; font-weight: bold;">TK</h4>
                                    </div>
                                </label>
                                <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #ddd; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="program-option">
                                    <input type="radio" name="jenjang" value="sd" required style="width: 20px; height: 20px; cursor: pointer;" onchange="handleJenjangChange()">
                                    <div style="margin-left: 15px;">
                                        <h4 style="color: var(--hijau-islam); margin: 0 0 5px 0; font-weight: bold;">SD</h4>
                                    </div>
                                </label>
                                <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #ddd; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="program-option">
                                    <input type="radio" name="jenjang" value="smp" required style="width: 20px; height: 20px; cursor: pointer;" onchange="handleJenjangChange()">
                                    <div style="margin-left: 15px;">
                                        <h4 style="color: var(--hijau-islam); margin: 0 0 5px 0; font-weight: bold;">SMP</h4>
                                    </div>
                                </label>
                                <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #ddd; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="program-option">
                                    <input type="radio" name="jenjang" value="smk" required style="width: 20px; height: 20px; cursor: pointer;" onchange="handleJenjangChange()">
                                    <div style="margin-left: 15px;">
                                        <h4 style="color: var(--hijau-islam); margin: 0 0 5px 0; font-weight: bold;">SMK</h4>
                                    </div>
                                </label>
                            </div>
                            <div class="field-error" id="error_jenjang"></div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; margin-top: 20px; gap: 15px;">
                        <button type="button" class="next-btn" id="btn-step-1-next" onclick="nextStep()" disabled style="background-color: var(--hijau-islam); color: white; padding: 12px 30px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            Lanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 2: Data Siswa -->
            <div class="form-step" id="step-2" style="display: none;">
                <div class="card">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px; border-bottom: 2px solid var(--hijau-islam); padding-bottom: 12px;">
                        <i class="fas fa-user" style="color: var(--hijau-islam); font-size: 24px;"></i>
                        <h2 style="color: var(--hijau-islam); font-size: 24px; margin: 0; font-weight: bold;">Data Calon Siswa</h2>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr; gap: 14px;">
                        <div>
                            <label for="nama_lengkap" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 6px;">Nama Lengkap Sesuai Akta Kelahiran <span style="color: red;">*</span></label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap" value="{{ old('nama_lengkap') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                            <div class="field-error" id="error_nama_lengkap"></div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                            <div id="nisn_container">
                                <label for="nisn" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 6px;">NISN (Nomor Induk Siswa Nasional) <span style="color: red;" id="nisn_required_star">*</span></label>
                                <input type="text" id="nisn" name="nisn" placeholder="Contoh: 0123456789" value="{{ old('nisn') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                                <div class="field-error" id="error_nisn"></div>
                            </div>
                            <div>
                                <label for="nik" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 6px;">NIK (Nomor Induk Kependudukan) <span style="color: red;">*</span></label>
                                <input type="text" id="nik" name="nik" placeholder="16 digit NIK" value="{{ old('nik') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                                <div class="field-error" id="error_nik"></div>
                            </div>
                        </div>

                        <div>
                            <label for="email" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 6px;">Email <span style="color: red;">*</span></label>
                            <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                            <div class="field-error" id="error_email"></div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                            <div>
                                <label for="tempat_lahir" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 6px;">Tempat Lahir <span style="color: red;">*</span></label>
                                <input type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Kota/Kabupaten" value="{{ old('tempat_lahir') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                                <div class="field-error" id="error_tempat_lahir"></div>
                            </div>
                            <div>
                                <label for="tanggal_lahir" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 6px;">Tanggal Lahir <span style="color: red;">*</span></label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                                <div class="field-error" id="error_tanggal_lahir"></div>
                            </div>
                        </div>

                        <div>
                            <label for="jenis_kelamin" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 6px;">Jenis Kelamin <span style="color: red;">*</span></label>
                            <div style="display: flex; gap: 14px;">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="radio" name="jenis_kelamin" value="laki-laki" @if(old('jenis_kelamin') === 'laki-laki') checked @endif required> Laki-laki
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="radio" name="jenis_kelamin" value="perempuan" @if(old('jenis_kelamin') === 'perempuan') checked @endif required> Perempuan
                                </label>
                            </div>
                            <div class="field-error" id="error_jenis_kelamin"></div>
                        </div>

                        <div>
                            <label for="alamat" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 6px;">Alamat Lengkap (Sesuai KK) <span style="color: red;">*</span></label>
                            <textarea id="alamat" name="alamat" placeholder="Nama jalan, RT/RW, Kelurahan, Kecamatan" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; height: 80px;">{{ old('alamat') }}</textarea>
                            <div class="field-error" id="error_alamat"></div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                            <div>
                                <label for="asal_sekolah" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 6px;">Asal Sekolah <span style="color: red;">*</span></label>
                                <input type="text" id="asal_sekolah" name="asal_sekolah" placeholder="Nama sekolah asal" value="{{ old('asal_sekolah') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                                <div class="field-error" id="error_asal_sekolah"></div>
                            </div>
                            <div>
                                <label for="no_telepon" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 6px;">Nomor Telepon Siswa <span style="color: red;">*</span></label>
                                <input type="tel" id="no_telepon" name="no_telepon" placeholder="+62 atau nomor lokal" value="{{ old('no_telepon') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                                <div class="field-error" id="error_no_telepon"></div>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-top: 20px; gap: 15px;">
                        <button type="button" class="prev-btn" onclick="prevStep()" style="background-color: #e0e0e0; color: var(--text-dark); padding: 12px 30px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </button>
                        <button type="button" class="next-btn" id="btn-step-2-next" onclick="nextStep()" disabled style="background-color: var(--hijau-islam); color: white; padding: 12px 30px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            Lanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 3: Data Orang Tua -->
            <div class="form-step" id="step-3" style="display: none;">
                <div class="card">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px; border-bottom: 2px solid var(--hijau-islam); padding-bottom: 12px;">
                        <i class="fas fa-users" style="color: var(--hijau-islam); font-size: 24px;"></i>
                        <h2 style="color: var(--hijau-islam); font-size: 24px; margin: 0; font-weight: bold;">Data Orang Tua/Wali</h2>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr; gap: 14px;">
                        <h3 style="color: var(--hijau-islam); margin-bottom: 4px; font-size: 16px; border-bottom: 2px solid #e0e0e0; padding-bottom: 8px;">Ayah</h3>

                        <div>
                            <label for="nama_ayah" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 6px;">Nama Ayah <span style="color: red;">*</span></label>
                            <input type="text" id="nama_ayah" name="nama_ayah" placeholder="Nama lengkap ayah" value="{{ old('nama_ayah') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                            <div class="field-error" id="error_nama_ayah"></div>
                        </div>

                        <div>
                            <label for="no_ortu" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 6px;">Nomor Telepon Orang Tua/Wali <span style="color: red;">*</span></label>
                            <input type="tel" id="no_ortu" name="no_ortu" placeholder="+62 atau nomor lokal" value="{{ old('no_ortu') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                            <div class="field-error" id="error_no_ortu"></div>
                        </div>

                        <h3 style="color: var(--hijau-islam); margin-top: 8px; margin-bottom: 4px; font-size: 16px; border-bottom: 2px solid #e0e0e0; padding-bottom: 8px;">Ibu</h3>

                        <div>
                            <label for="nama_ibu" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 6px;">Nama Ibu <span style="color: red;">*</span></label>
                            <input type="text" id="nama_ibu" name="nama_ibu" placeholder="Nama lengkap ibu" value="{{ old('nama_ibu') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                            <div class="field-error" id="error_nama_ibu"></div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-top: 20px; gap: 15px;">
                        <button type="button" class="prev-btn" onclick="prevStep()" style="background-color: #e0e0e0; color: var(--text-dark); padding: 12px 30px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </button>
                        <button type="button" class="next-btn" id="btn-next-step-3" onclick="handleStep3Next()" disabled style="background-color: var(--hijau-islam); color: white; padding: 12px 30px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            Lanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 4: Pilih Jurusan (Khusus SMK) -->
            <div class="form-step" id="step-4" style="display: none;">
                <div class="card">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px; border-bottom: 2px solid var(--hijau-islam); padding-bottom: 12px;">
                        <i class="fas fa-book" style="color: var(--hijau-islam); font-size: 24px;"></i>
                        <h2 style="color: var(--hijau-islam); font-size: 24px; margin: 0; font-weight: bold;">Pilih Jurusan (Khusus SMK)</h2>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr; gap: 14px;">
                        <div>
                            <label style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 10px; font-size: 16px;">Pilih Jurusan <span style="color: red;">*</span></label>
                            <div style="display: grid; gap: 12px;">
                                <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #ddd; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="program-option">
                                    <input type="radio" name="jurusan" value="Akuntansi" required style="width: 20px; height: 20px; cursor: pointer;" id="jurusan_akuntansi">
                                    <div style="margin-left: 15px; flex: 1;">
                                        <h4 style="color: var(--hijau-islam); margin: 0 0 5px 0; font-weight: bold;">Akuntansi</h4>
                                    </div>
                                </label>
                                <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #ddd; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="program-option">
                                    <input type="radio" name="jurusan" value="OTKP" required style="width: 20px; height: 20px; cursor: pointer;" id="jurusan_otkp">
                                    <div style="margin-left: 15px; flex: 1;">
                                        <h4 style="color: var(--hijau-islam); margin: 0 0 5px 0; font-weight: bold;">OTKP (Otomatisasi Tata Kelola Perkantoran)</h4>
                                    </div>
                                </label>
                            </div>
                            <div class="field-error" id="error_jurusan"></div>
                        </div>
                    </div>

                    <div style="background-color: #e8f5e9; border: 1px solid #c8e6c9; padding: 15px; border-radius: 8px; margin-top: 18px; display: flex; gap: 12px;">
                        <i class="fas fa-info-circle" style="color: #2e7d32; flex-shrink: 0; margin-top: 2px;"></i>
                        <p style="color: #2e7d32; margin: 0; font-size: 14px;">
                            <strong>Catatan:</strong> Dokumen pendukung dapat diunggah di kantor sekolah setelah Anda menyelesaikan pendaftaran ini.
                        </p>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-top: 20px; gap: 15px;">
                        <button type="button" class="prev-btn" onclick="prevStep()" style="background-color: #e0e0e0; color: var(--text-dark); padding: 12px 30px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </button>
                        <button type="submit" style="background-color: var(--hijau-islam); color: white; padding: 12px 35px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px; font-size: 16px;">
                            <i class="fas fa-check"></i> Selesaikan Pendaftaran
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .field-error {
        margin-top: 4px;
        color: #d32f2f;
        font-size: 12px;
        min-height: 0;
        line-height: 1.2;
    }

    .field-invalid {
        border-color: #d32f2f !important;
        box-shadow: 0 0 0 2px rgba(211, 47, 47, 0.08);
    }

    .program-option:has(input[type="radio"]:checked) {
        background-color: #e8f5e9 !important;
        border-color: var(--hijau-islam) !important;
    }

    .next-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed !important;
        box-shadow: none;
    }
</style>

<script>
    let currentStep = 1;
    let totalSteps = 4;
    let isSmk = false;
    const touchedFields = {};

    const validators = {
        jenjang: () => !!document.querySelector('input[name="jenjang"]:checked'),
        nama_lengkap: () => document.getElementById('nama_lengkap').value.trim().length > 0,
        nisn: () => {
            const jenjang = document.querySelector('input[name="jenjang"]:checked')?.value;
            const value = document.getElementById('nisn').value.trim();
            if (jenjang === 'tk' || jenjang === 'sd') {
                return value === '' || /^\d{10}$/.test(value);
            }
            return /^\d{10}$/.test(value);
        },
        nik: () => /^\d{16}$/.test(document.getElementById('nik').value.trim()),
        tempat_lahir: () => document.getElementById('tempat_lahir').value.trim().length > 0,
        tanggal_lahir: () => document.getElementById('tanggal_lahir').value.trim().length > 0,
        jenis_kelamin: () => !!document.querySelector('input[name="jenis_kelamin"]:checked'),
        alamat: () => document.getElementById('alamat').value.trim().length > 0,
        asal_sekolah: () => document.getElementById('asal_sekolah').value.trim().length > 0,
        email: () => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(document.getElementById('email').value.trim()),
        no_telepon: () => /^\+?\d{9,15}$/.test(document.getElementById('no_telepon').value.replace(/\s+/g, '')),
        nama_ayah: () => document.getElementById('nama_ayah').value.trim().length > 0,
        no_ortu: () => /^\+?\d{9,15}$/.test(document.getElementById('no_ortu').value.replace(/\s+/g, '')),
        nama_ibu: () => document.getElementById('nama_ibu').value.trim().length > 0,
        jurusan: () => {
            if (!isSmk) {
                return true;
            }
            return !!document.querySelector('input[name="jurusan"]:checked');
        },
    };

    const errorMessages = {
        jenjang: 'Pilih salah satu jenjang terlebih dahulu.',
        nama_lengkap: 'Nama lengkap wajib diisi.',
        nisn: 'NISN harus 10 digit angka.',
        nik: 'NIK harus 16 digit angka.',
        tempat_lahir: 'Tempat lahir wajib diisi.',
        tanggal_lahir: 'Tanggal lahir wajib dipilih.',
        jenis_kelamin: 'Pilih jenis kelamin terlebih dahulu.',
        alamat: 'Alamat wajib diisi.',
        asal_sekolah: 'Asal sekolah wajib diisi.',
        email: 'Format email tidak valid.',
        no_telepon: 'Nomor HP harus berupa angka dan panjang 9-15 digit.',
        nama_ayah: 'Nama ayah wajib diisi.',
        no_ortu: 'Nomor orang tua harus berupa angka dan panjang 9-15 digit.',
        nama_ibu: 'Nama ibu wajib diisi.',
        jurusan: 'Pilih jurusan terlebih dahulu.',
    };

    function setButtonDisabled(buttonId, disabled) {
        const button = document.getElementById(buttonId);
        if (!button) {
            return;
        }
        button.disabled = disabled;
    }

    function shouldShowFieldError(fieldId, forceShow = false) {
        return forceShow || touchedFields[fieldId] === true;
    }

    function markFieldTouched(fieldId) {
        touchedFields[fieldId] = true;
    }

    function setFieldState(fieldId, isValid, message, forceShow = false) {
        const element = document.getElementById(fieldId);
        const errorElement = document.getElementById(`error_${fieldId}`);

        if (!element || !errorElement) {
            return isValid;
        }

        if (isValid) {
            element.classList.remove('field-invalid');
            errorElement.textContent = '';
        } else if (shouldShowFieldError(fieldId, forceShow)) {
            element.classList.add('field-invalid');
            errorElement.textContent = message;
        } else {
            element.classList.remove('field-invalid');
            errorElement.textContent = '';
        }

        return isValid;
    }

    function setGroupState(errorId, isValid, message, fieldKey = null, forceShow = false) {
        const errorElement = document.getElementById(errorId);
        if (!errorElement) {
            return isValid;
        }

        const shouldShow = forceShow || (fieldKey && touchedFields[fieldKey] === true);
        errorElement.textContent = isValid || !shouldShow ? '' : message;
        return isValid;
    }

    function validateStep1(showErrors = false) {
        const isValid = validators.jenjang();
        setGroupState('error_jenjang', isValid, errorMessages.jenjang, 'jenjang', showErrors);
        setButtonDisabled('btn-step-1-next', !isValid);
        return isValid;
    }

    function validateStep2(showErrors = false) {
        const fields = ['nama_lengkap', 'nisn', 'nik', 'email', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'asal_sekolah', 'no_telepon'];
        let isValid = true;

        fields.forEach((fieldId) => {
            const fieldValid = validators[fieldId]();
            isValid = isValid && fieldValid;
            if (fieldId === 'jenis_kelamin') {
                setGroupState('error_jenis_kelamin', fieldValid, errorMessages[fieldId], 'jenis_kelamin', showErrors);
                return;
            }
            if (showErrors || touchedFields[fieldId]) {
                setFieldState(fieldId, fieldValid, errorMessages[fieldId], showErrors);
            } else {
                setFieldState(fieldId, fieldValid, errorMessages[fieldId], false);
            }
        });

        setButtonDisabled('btn-step-2-next', !isValid);
        return isValid;
    }

    function validateStep3(showErrors = false) {
        const fields = ['nama_ayah', 'no_ortu', 'nama_ibu'];
        let isValid = true;

        fields.forEach((fieldId) => {
            const fieldValid = validators[fieldId]();
            isValid = isValid && fieldValid;
            if (showErrors || touchedFields[fieldId]) {
                setFieldState(fieldId, fieldValid, errorMessages[fieldId], showErrors);
            } else {
                setFieldState(fieldId, fieldValid, errorMessages[fieldId], false);
            }
        });

        setButtonDisabled('btn-next-step-3', !isValid);
        return isValid;
    }

    function validateStep4(showErrors = false) {
        const isValid = validators.jurusan();
        setGroupState('error_jurusan', isValid, errorMessages.jurusan, 'jurusan', showErrors);
        return isValid;
    }

    function validateCurrentStep(showErrors = false) {
        if (currentStep === 1) {
            return validateStep1(showErrors);
        }
        if (currentStep === 2) {
            return validateStep2(showErrors);
        }
        if (currentStep === 3) {
            return validateStep3(showErrors);
        }
        if (currentStep === 4) {
            return validateStep4(showErrors);
        }
        return true;
    }

    function bindLiveValidation() {
        const fields = ['nama_lengkap', 'nisn', 'nik', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'asal_sekolah', 'no_telepon', 'nama_ayah', 'no_ortu', 'nama_ibu'];

        fields.forEach((fieldId) => {
            const element = document.getElementById(fieldId);
            if (!element) {
                return;
            }

            const eventName = element.tagName === 'TEXTAREA' || element.type === 'text' || element.type === 'tel' || element.type === 'date' ? 'input' : 'change';
            element.addEventListener(eventName, () => {
                markFieldTouched(fieldId);
                if (currentStep === 2 && ['nama_lengkap', 'nisn', 'nik', 'email', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'asal_sekolah', 'no_telepon'].includes(fieldId)) {
                    validateStep2(false);
                }
                if (currentStep === 3 && ['nama_ayah', 'no_ortu', 'nama_ibu'].includes(fieldId)) {
                    validateStep3(false);
                }
            });

            element.addEventListener('blur', () => {
                markFieldTouched(fieldId);
                if (currentStep === 2 && ['nama_lengkap', 'nisn', 'nik', 'email', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'asal_sekolah', 'no_telepon'].includes(fieldId)) {
                    validateStep2(false);
                }
                if (currentStep === 3 && ['nama_ayah', 'no_ortu', 'nama_ibu'].includes(fieldId)) {
                    validateStep3(false);
                }
            });
        });

        ['jenjang', 'jenis_kelamin', 'jurusan'].forEach((fieldName) => {
            document.querySelectorAll(`input[name="${fieldName}"]`).forEach((element) => {
                element.addEventListener('change', () => {
                    markFieldTouched(fieldName);
                    if (fieldName === 'jenjang') {
                        validateStep1(false);
                        handleJenjangChange();
                        validateStep2(false);
                    }
                    if (fieldName === 'jenis_kelamin') {
                        validateStep2(false);
                    }
                    if (fieldName === 'jurusan') {
                        validateStep4(false);
                    }
                });

                element.addEventListener('blur', () => {
                    markFieldTouched(fieldName);
                    if (fieldName === 'jenjang') {
                        validateStep1(false);
                    }
                    if (fieldName === 'jenis_kelamin') {
                        validateStep2(false);
                    }
                    if (fieldName === 'jurusan') {
                        validateStep4(false);
                    }
                });
            });
        });
    }

    function handleJenjangChange() {
        const jenjang = document.querySelector('input[name="jenjang"]:checked')?.value;
        const nisnContainer = document.getElementById('nisn_container');
        const nisnInput = document.getElementById('nisn');
        const nisnStar = document.getElementById('nisn_required_star');
        const indicatorStep4 = document.getElementById('indicator-step-4');
        const btnNextStep3 = document.getElementById('btn-next-step-3');

        if (jenjang === 'tk' || jenjang === 'sd') {
            nisnInput.removeAttribute('required');
            nisnStar.style.display = 'none';
        } else {
            nisnInput.setAttribute('required', 'required');
            nisnStar.style.display = 'inline';
        }

        if (jenjang === 'smk') {
            isSmk = true;
            indicatorStep4.style.display = 'block';
            btnNextStep3.innerHTML = 'Lanjutnya <i class="fas fa-arrow-right"></i>';
            totalSteps = 4;
        } else {
            isSmk = false;
            indicatorStep4.style.display = 'none';
            btnNextStep3.innerHTML = '<i class="fas fa-check"></i> Selesaikan Pendaftaran';
            totalSteps = 3;
        }

        validateStep1(false);
    }

    function handleStep3Next() {
        if (!validateStep3(true)) {
            return;
        }

        if (isSmk) {
            nextStep();
        } else {
            document.getElementById('ppdbForm').submit();
        }
    }

    function showStep(step) {
        for (let i = 1; i <= 4; i++) {
            const stepElement = document.getElementById(`step-${i}`);
            const indicator = document.querySelector(`.form-step-indicator[data-step="${i}"]`);

            if (stepElement) {
                if (i === step) {
                    stepElement.style.display = 'block';
                    if(indicator) {
                        indicator.style.opacity = '1';
                        indicator.querySelector('div').style.backgroundColor = 'var(--hijau-islam)';
                        indicator.querySelector('h3').style.color = 'var(--hijau-islam)';
                    }
                } else {
                    stepElement.style.display = 'none';
                    if(indicator) {
                        if (i < step) {
                            indicator.style.opacity = '1';
                            indicator.querySelector('div').style.backgroundColor = 'var(--hijau-islam)';
                            indicator.querySelector('h3').style.color = 'var(--hijau-islam)';
                        } else {
                            indicator.style.opacity = '0.5';
                            indicator.querySelector('div').style.backgroundColor = '#ccc';
                            indicator.querySelector('h3').style.color = '#999';
                        }
                    }
                }
            }
        }
        currentStep = step;
        validateCurrentStep(false);
        window.scrollTo({ top: 0, behavior: 'auto' });
    }

    function nextStep() {
        if (!validateCurrentStep(true)) {
            return;
        }

        if (currentStep < totalSteps) {
            showStep(currentStep + 1);
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', function() {
        handleJenjangChange();
        bindLiveValidation();
        validateStep1(false);
        validateStep2(false);
        validateStep3(false);
        validateStep4(false);
    });
</script>

@endsection
