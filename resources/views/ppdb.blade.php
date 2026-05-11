@extends('layouts.app')

@section('title', 'PPDB - Penerimaan Peserta Didik Baru')

@section('content')
<!-- Hero Section -->
<div class="hero-new" style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); padding: 100px 20px; text-align: center; color: white;">
    <div class="container">
        <h1 style="font-size: 40px; margin-bottom: 15px; font-weight: bold;">Formulir Pendaftaran Siswa Baru</h1>
        <p style="font-size: 16px; opacity: 0.95;">Silakan lengkapi formulir di bawah ini dengan data yang benar dan valid.<br>Proses pendaftaran terdiri dari 3 tahapan utama.</p>
    </div>
</div>

<!-- Main Content -->
<div class="section">
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

        <form method="POST" action="{{ route('ppdb.store') }}" id="ppdbForm">
            @csrf
            
            <!-- Form Steps -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 50px;">
                <div class="form-step-indicator" data-step="1" style="text-align: center;">
                    <div style="width: 50px; height: 50px; background-color: var(--hijau-islam); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px; margin: 0 auto 10px;">
                        <span class="step-number">1</span>
                    </div>
                    <h3 style="color: var(--hijau-islam); font-size: 16px; margin: 0;">Data Siswa</h3>
                </div>

                <div class="form-step-indicator" data-step="2" style="text-align: center; opacity: 0.5;">
                    <div style="width: 50px; height: 50px; background-color: #ccc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px; margin: 0 auto 10px;">
                        <span class="step-number">2</span>
                    </div>
                    <h3 style="color: #999; font-size: 16px; margin: 0;">Data Orang Tua</h3>
                </div>

                <div class="form-step-indicator" data-step="3" style="text-align: center; opacity: 0.5;">
                    <div style="width: 50px; height: 50px; background-color: #ccc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px; margin: 0 auto 10px;">
                        <span class="step-number">3</span>
                    </div>
                    <h3 style="color: #999; font-size: 16px; margin: 0;">Pilih Program</h3>
                </div>
            </div>

            <!-- Step 1: Data Siswa -->
            <div class="form-step" id="step-1">
                <div class="card">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 25px; border-bottom: 2px solid var(--hijau-islam); padding-bottom: 15px;">
                        <i class="fas fa-user" style="color: var(--hijau-islam); font-size: 24px;"></i>
                        <h2 style="color: var(--hijau-islam); font-size: 24px; margin: 0; font-weight: bold;">Data Calon Siswa</h2>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                        <div>
                            <label for="nama_lengkap" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px;">Nama Lengkap Sesuai Akta Kelahiran <span style="color: red;">*</span></label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap" value="{{ old('nama_lengkap') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <label for="nisn" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px;">NISN (Nomor Induk Siswa Nasional) <span style="color: red;">*</span></label>
                                <input type="text" id="nisn" name="nisn" placeholder="Contoh: 0123456789" value="{{ old('nisn') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                            </div>
                            <div>
                                <label for="nik" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px;">NIK (Nomor Induk Kependudukan) <span style="color: red;">*</span></label>
                                <input type="text" id="nik" name="nik" placeholder="16 digit NIK" value="{{ old('nik') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <label for="tempat_lahir" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px;">Tempat Lahir <span style="color: red;">*</span></label>
                                <input type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Kota/Kabupaten" value="{{ old('tempat_lahir') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                            </div>
                            <div>
                                <label for="tanggal_lahir" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px;">Tanggal Lahir <span style="color: red;">*</span></label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                            </div>
                        </div>

                        <div>
                            <label for="jenis_kelamin" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px;">Jenis Kelamin <span style="color: red;">*</span></label>
                            <div style="display: flex; gap: 20px;">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="radio" name="jenis_kelamin" value="laki-laki" @if(old('jenis_kelamin') === 'laki-laki') checked @endif required> Laki-laki
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="radio" name="jenis_kelamin" value="perempuan" @if(old('jenis_kelamin') === 'perempuan') checked @endif required> Perempuan
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="alamat" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px;">Alamat Lengkap (Sesuai KK) <span style="color: red;">*</span></label>
                            <textarea id="alamat" name="alamat" placeholder="Nama jalan, RT/RW, Kelurahan, Kecamatan" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; height: 80px;">{{ old('alamat') }}</textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <label for="asal_sekolah" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px;">Asal Sekolah <span style="color: red;">*</span></label>
                                <input type="text" id="asal_sekolah" name="asal_sekolah" placeholder="Nama sekolah asal" value="{{ old('asal_sekolah') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                            </div>
                            <div>
                                <label for="no_telepon" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px;">Nomor Telepon Siswa <span style="color: red;">*</span></label>
                                <input type="tel" id="no_telepon" name="no_telepon" placeholder="+62 atau nomor lokal" value="{{ old('no_telepon') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; margin-top: 30px; gap: 15px;">
                        <button type="button" class="next-btn" onclick="nextStep()" style="background-color: var(--hijau-islam); color: white; padding: 12px 30px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            Lanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 2: Data Orang Tua -->
            <div class="form-step" id="step-2" style="display: none;">
                <div class="card">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 25px; border-bottom: 2px solid var(--hijau-islam); padding-bottom: 15px;">
                        <i class="fas fa-users" style="color: var(--hijau-islam); font-size: 24px;"></i>
                        <h2 style="color: var(--hijau-islam); font-size: 24px; margin: 0; font-weight: bold;">Data Orang Tua/Wali</h2>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                        <h3 style="color: var(--hijau-islam); margin-bottom: 10px; font-size: 16px; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">Ayah</h3>

                        <div>
                            <label for="nama_ayah" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px;">Nama Ayah <span style="color: red;">*</span></label>
                            <input type="text" id="nama_ayah" name="nama_ayah" placeholder="Nama lengkap ayah" value="{{ old('nama_ayah') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                        </div>

                        <div>
                            <label for="no_ortu" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px;">Nomor Telepon Orang Tua/Wali <span style="color: red;">*</span></label>
                            <input type="tel" id="no_ortu" name="no_ortu" placeholder="+62 atau nomor lokal" value="{{ old('no_ortu') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                        </div>

                        <h3 style="color: var(--hijau-islam); margin-top: 20px; margin-bottom: 10px; font-size: 16px; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">Ibu</h3>

                        <div>
                            <label for="nama_ibu" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px;">Nama Ibu <span style="color: red;">*</span></label>
                            <input type="text" id="nama_ibu" name="nama_ibu" placeholder="Nama lengkap ibu" value="{{ old('nama_ibu') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-top: 30px; gap: 15px;">
                        <button type="button" class="prev-btn" onclick="prevStep()" style="background-color: #e0e0e0; color: var(--text-dark); padding: 12px 30px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-arrow-left"></i> Sebelumnya
                        </button>
                        <button type="button" class="next-btn" onclick="nextStep()" style="background-color: var(--hijau-islam); color: white; padding: 12px 30px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            Lanjutnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 3: Pilih Program -->
            <div class="form-step" id="step-3" style="display: none;">
                <div class="card">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 25px; border-bottom: 2px solid var(--hijau-islam); padding-bottom: 15px;">
                        <i class="fas fa-book" style="color: var(--hijau-islam); font-size: 24px;"></i>
                        <h2 style="color: var(--hijau-islam); font-size: 24px; margin: 0; font-weight: bold;">Pilih Program</h2>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                        @if($programs->count() > 0)
                            <div>
                                <label for="program_id" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 15px; font-size: 16px;">Program Pendidikan yang Diminati <span style="color: red;">*</span></label>
                                <div style="display: grid; gap: 15px;">
                                    @foreach($programs as $program)
                                    <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #ddd; border-radius: 8px; cursor: pointer; transition: all 0.3s;" class="program-option">
                                        <input type="radio" name="program_id" value="{{ $program->id }}" required style="width: 20px; height: 20px; cursor: pointer;">
                                        <div style="margin-left: 15px; flex: 1;">
                                            <h4 style="color: var(--hijau-islam); margin: 0 0 5px 0; font-weight: bold;">{{ $program->nama_program }}</h4>
                                            <p style="color: var(--text-light); margin: 0; font-size: 14px;">{{ Str::limit($program->deskripsi, 100) }}</p>
                                            <p style="color: var(--hijau-islam); font-size: 12px; margin-top: 5px; font-weight: 600;">Target Lulusan: {{ $program->kuota }} siswa</p>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div style="background-color: #e8f5e9; border: 1px solid #c8e6c9; padding: 15px; border-radius: 8px; margin-top: 25px; display: flex; gap: 12px;">
                        <i class="fas fa-info-circle" style="color: #2e7d32; flex-shrink: 0; margin-top: 2px;"></i>
                        <p style="color: #2e7d32; margin: 0; font-size: 14px;">
                            <strong>Catatan:</strong> Dokumen pendukung dapat diunggah di kantor sekolah setelah Anda menyelesaikan pendaftaran ini.
                        </p>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-top: 30px; gap: 15px;">
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
    .program-option:has(input[type="radio"]:checked) {
        background-color: #e8f5e9 !important;
        border-color: var(--hijau-islam) !important;
    }
</style>

<script>
    let currentStep = 1;
    const totalSteps = 3;

    function showStep(step) {
        for (let i = 1; i <= totalSteps; i++) {
            const stepElement = document.getElementById(`step-${i}`);
            const indicator = document.querySelector(`.form-step-indicator[data-step="${i}"]`);
            
            if (i === step) {
                stepElement.style.display = 'block';
                indicator.style.opacity = '1';
            } else {
                stepElement.style.display = 'none';
                if (i < step) {
                    indicator.style.opacity = '1';
                } else {
                    indicator.style.opacity = '0.5';
                }
            }
        }
        currentStep = step;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function nextStep() {
        if (currentStep < totalSteps) {
            showStep(currentStep + 1);
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    }
</script>

@endsection
