@extends('student.layout')

@section('student-content')
<style>
    :root {
        --primary: #2d5016;
        --text-primary: #1a1a1a;
        --text-secondary: #666;
        --text-muted: #999;
        --border: #e5e5e5;
        --bg-light: #f9f9f9;
    }

    .profile-container {
        max-width: 1200px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 2rem;
        padding: 2rem 0;
        border-bottom: 1px solid var(--border);
        margin-bottom: 2rem;
    }

    .profile-photo {
        width: 120px;
        height: 120px;
        border-radius: 8px;
        object-fit: cover;
        background-color: var(--bg-light);
    }

    .profile-photo-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 8px;
        background-color: var(--bg-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ddd;
    }

    .profile-info h1 {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .profile-info p {
        color: var(--text-secondary);
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }

    .section {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 2rem;
        margin-bottom: 1.5rem;
    }

    .section h5 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-row.full {
        grid-template-columns: 1fr;
    }

    .form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.6rem 0.875rem;
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 0.95rem;
        color: var(--text-primary);
        background-color: white;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(45, 80, 22, 0.1);
    }

    .form-control:disabled,
    .form-control[disabled],
    .form-control[readonly] {
        background-color: var(--bg-light);
        color: var(--text-muted);
        cursor: not-allowed;
    }

    textarea.form-control[readonly] {
        resize: none;
    }

    .read-only-value {
        display: block;
        padding: 0.6rem 0.875rem;
        background-color: var(--bg-light);
        border-radius: 6px;
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    .form-helper {
        display: block;
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.3rem;
    }

    .readonly-banner {
        background: #f7fbf8;
        border: 1px solid rgba(45, 80, 22, 0.12);
        color: var(--primary);
        border-radius: 8px;
        padding: 0.9rem 1rem;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .btn {
        padding: 0.6rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
        width: 100%;
        justify-content: center;
    }

    .btn-primary:hover {
        background-color: #1f3a0f;
    }

    .btn-secondary {
        background-color: white;
        border: 1.5px solid var(--primary);
        color: var(--primary);
        width: 100%;
        justify-content: center;
    }

    .btn-secondary:hover {
        background-color: var(--primary);
        color: white;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.3rem;
    }

    .photo-section {
        text-align: center;
    }

    .photo-section .form-control {
        margin-bottom: 1rem;
    }

    .side-section {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .info-box {
        background-color: #fafafa;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.5rem;
    }

    .info-box h5 {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 0.75rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-box p {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.5;
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .profile-info h1 {
            font-size: 1.5rem;
        }

        .profile-container {
            max-width: 100%;
        }
    }
</style>

<div class="profile-container">
    <!-- Header -->
    <div class="profile-header">
        <div>
            @if(auth()->user()->profile_photo)
                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="profile-photo">
            @else
                <div class="profile-photo-placeholder">
                    <i class="fas fa-user fa-2x"></i>
                </div>
            @endif
        </div>
        <div class="profile-info">
            <h1>{{ auth()->user()->name }}</h1>
            <p>{{ auth()->user()->class ?? 'Kelas Tidak Ditentukan' }}</p>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="readonly-banner">
                <i class="fas fa-lock"></i> Seluruh data profil siswa bersifat read-only dan tidak dapat diedit.
            </div>

            <!-- Data Pribadi -->
            <div class="section">
                <h5><i class="fas fa-user-circle"></i>Data Pribadi</h5>

                <div class="form-row full">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->email }}" readonly>
                        <span class="form-helper">Email tidak dapat diubah</span>
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->phone ?? '-' }}" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>NISN</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->nisn ?? '-' }}" readonly>
                        <span class="form-helper">NISN tidak dapat diubah</span>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->class ?? '-' }}" readonly>
                        <span class="form-helper">Kelas tidak dapat diubah</span>
                    </div>
                </div>
            </div>

            <!-- Alamat & Biodata -->
            <div class="section">
                <h5><i class="fas fa-map-marker-alt"></i>Alamat & Informasi</h5>

                <div class="form-row full">
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" rows="3" readonly>{{ auth()->user()->address ?? '-' }}</textarea>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group">
                        <label>Biodata Singkat</label>
                        <textarea class="form-control" rows="3" readonly>{{ auth()->user()->bio ?? '-' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="side-section">
                <!-- Foto Profil -->
                <div class="section photo-section">
                    <h5><i class="fas fa-image"></i>Foto Profil</h5>
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="profile-photo" style="width: 100%; height: auto; max-width: 150px;">
                    @else
                        <div class="profile-photo-placeholder" style="width: 100%; height: 150px; margin-bottom: 1rem;">
                            <i class="fas fa-camera fa-2x"></i>
                        </div>
                    @endif
                </div>

                <!-- Keamanan -->
                <div class="section">
                    <h5><i class="fas fa-lock"></i>Keamanan</h5>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 1rem;">Kelola keamanan akun Anda dengan mengubah password secara berkala.</p>
                </div>

                <!-- Info -->
                <div class="info-box">
                    <h5><i class="fas fa-info-circle"></i>Tips</h5>
                    <p>Data pribadi Anda tersimpan dengan aman. Untuk perubahan data administratif, hubungi pihak sekolah.</p>
                </div>

                <div class="info-box">
                    <h5><i class="fas fa-address-card"></i>Informasi Perubahan Data</h5>
                    <p>Apabila terdapat data yang ingin diubah, silakan menghubungi Admin Sekolah.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
