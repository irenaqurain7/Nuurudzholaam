@extends('teacher.layout')

@section('teacher-content')
<style>
    :root {
        --hijau-islam: #2D4438;
        --hijau-light: #486E5A;
        --emas: #709D88;
        --emas-light: #E2ECE8;
        --text-dark: #1C2D25;
        --text-light: #5A7E6B;
        --bg-light: #F4F7F5;
        --putih: #ffffff;
        --red: #dc3545;
    }

    .profile-header {
        margin-bottom: 40px;
    }

    .profile-header h1 {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .profile-container {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 30px;
        margin-top: 30px;
    }

    /* Photo Card */
    .photo-card {
        background: var(--putih);
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(45, 68, 56, 0.08);
        overflow: hidden;
    }

    .photo-card-header {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-light) 100%);
        color: var(--putih);
        padding: 20px;
        font-weight: 600;
    }

    .photo-card-header i {
        margin-right: 10px;
    }

    .photo-card-body {
        padding: 30px 25px;
        text-align: center;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .photo-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto;
        background-color: var(--emas-light);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 3px solid var(--emas);
    }

    .photo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-preview i {
        font-size: 3rem;
        color: var(--text-light);
    }

    .photo-btn {
        background: var(--hijau-islam);
        color: var(--putih);
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .photo-btn:hover {
        background: var(--hijau-light);
        color: var(--putih);
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 68, 56, 0.15);
    }

    /* Security Card */
    .security-card {
        background: var(--putih);
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(45, 68, 56, 0.08);
        overflow: hidden;
        margin-top: 30px;
    }

    .security-card-header {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: var(--putih);
        padding: 20px;
        font-weight: 600;
    }

    .security-card-header i {
        margin-right: 10px;
    }

    .security-card-body {
        padding: 25px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .security-description {
        font-size: 14px;
        color: var(--text-light);
        margin: 0;
    }

    .security-btn {
        background: #f39c12;
        color: var(--putih);
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .security-btn:hover {
        background: #e67e22;
        color: var(--putih);
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(243, 156, 18, 0.2);
    }

    /* Form Card */
    .form-card {
        background: var(--putih);
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(45, 68, 56, 0.08);
        overflow: hidden;
    }

    .form-card-header {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-light) 100%);
        color: var(--putih);
        padding: 20px;
        font-weight: 600;
    }

    .form-card-header i {
        margin-right: 10px;
    }

    .form-card-body {
        padding: 30px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 25px;
    }

    .form-row.full {
        grid-template-columns: 1fr;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-group label .required {
        color: var(--red);
        margin-left: 3px;
    }

    .form-group input,
    .form-group textarea {
        padding: 12px 15px;
        border: 1.5px solid var(--emas-light);
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--hijau-light);
        box-shadow: 0 0 0 3px rgba(72, 110, 90, 0.1);
        background-color: rgba(226, 236, 232, 0.3);
    }

    .form-group input:disabled,
    .form-group textarea:disabled {
        background-color: var(--emas-light);
        color: var(--text-light);
        cursor: not-allowed;
    }

    .form-group small {
        font-size: 13px;
        color: var(--text-light);
        margin-top: 6px;
    }

    .form-group.error input,
    .form-group.error textarea {
        border-color: var(--red);
    }

    .error-message {
        color: var(--red);
        font-size: 13px;
        margin-top: 6px;
        display: block;
    }

    .submit-btn {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-light) 100%);
        color: var(--putih);
        border: none;
        padding: 14px 30px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 20px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(45, 68, 56, 0.2);
    }

    .submit-btn i {
        margin-right: 10px;
    }

    @media (max-width: 768px) {
        .profile-container {
            grid-template-columns: 1fr;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .profile-header h1 {
            font-size: 24px;
        }

        .form-card-body {
            padding: 20px;
        }
    }
</style>

<div class="profile-header">
    <h1>Profil Saya</h1>
</div>

<div class="profile-container">
    <!-- Sidebar -->
    <div>
        <!-- Photo Card -->
        <div class="photo-card">
            <div class="photo-card-header">
                <i class="fas fa-image"></i>Foto Profil
            </div>
            <div class="photo-card-body">
                <div class="photo-preview">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile">
                    @else
                        <i class="fas fa-user-circle"></i>
                    @endif
                </div>
                <a href="{{ route('teacher.upload-photo') }}" class="photo-btn">
                    <i class="fas fa-upload"></i>Ubah Foto
                </a>
            </div>
        </div>

        <!-- Security Card -->
        <div class="security-card">
            <div class="security-card-header">
                <i class="fas fa-lock"></i>Keamanan
            </div>
            <div class="security-card-body">
                <p class="security-description">Kelola keamanan akun Anda</p>
                <a href="{{ route('teacher.change-password') }}" class="security-btn">
                    <i class="fas fa-key"></i>Ubah Password
                </a>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <div class="form-card">
        <div class="form-card-header">
            <i class="fas fa-user"></i>Data Pribadi
        </div>
        <div class="form-card-body">
            <form action="{{ route('teacher.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Row 1: Nama Lengkap -->
                <div class="form-row full">
                    <div class="form-group @error('name') error @enderror">
                        <label for="name">
                            Nama Lengkap
                            <span class="required">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" required>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Row 2: Email & NIP -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" value="{{ auth()->user()->email }}" disabled>
                        <small>Email tidak dapat diubah</small>
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" id="nip" value="{{ auth()->user()->nip ?? '-' }}" disabled>
                        <small>Nomor Induk Pegawai tidak dapat diubah</small>
                    </div>
                </div>

                <!-- Row 3: Bidang Keahlian & No. Telepon -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="specialization">Bidang Keahlian</label>
                        <input type="text" id="specialization" value="{{ auth()->user()->teacher->specialization ?? '-' }}" disabled>
                        <small>Bidang keahlian tidak dapat diubah</small>
                    </div>
                    <div class="form-group @error('phone') error @enderror">
                        <label for="phone">No. Telepon</label>
                        <input type="text" id="phone" name="phone" placeholder="Contoh: 08123456789" value="{{ auth()->user()->phone }}">
                        @error('phone')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Row 4: Alamat -->
                <div class="form-row full">
                    <div class="form-group @error('address') error @enderror">
                        <label for="address">Alamat</label>
                        <textarea id="address" name="address" rows="3" placeholder="Masukkan alamat lengkap Anda">{{ auth()->user()->address }}</textarea>
                        @error('address')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Row 5: Biodata Singkat -->
                <div class="form-row full">
                    <div class="form-group @error('bio') error @enderror">
                        <label for="bio">Biodata Singkat</label>
                        <textarea id="bio" name="bio" rows="3" placeholder="Ceritakan tentang diri Anda secara singkat...">{{ auth()->user()->bio }}</textarea>
                        <small>Opsional - untuk profil publik Anda</small>
                        @error('bio')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">
                    <i class="fas fa-save"></i>Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
