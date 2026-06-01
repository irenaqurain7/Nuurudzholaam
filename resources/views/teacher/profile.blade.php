@extends('teacher.layout')

@section('teacher-content')
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
    .form-control[disabled] {
        background-color: var(--bg-light);
        color: var(--text-muted);
        cursor: not-allowed;
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
                    <i class="fas fa-user fa-3x"></i>
                </div>
            @endif
        </div>
        <div class="profile-info">
            <h1>{{ auth()->user()->name }}</h1>
            <p>{{ auth()->user()->teacher->specialization ?? 'Guru' }} | NIP: {{ auth()->user()->nip ?? '-' }}</p>
        </div>
    </div>

    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8">
            <form action="{{ route('teacher.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Data Pribadi -->
                <div class="section">
                    <h5><i class="fas fa-user-circle"></i>Data Pribadi</h5>

                    <div class="form-row full">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ auth()->user()->name }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Email</label>
                            <div class="read-only-value">{{ auth()->user()->email }}</div>
                            <span class="form-helper">Email tidak dapat diubah</span>
                        </div>
                        <div class="form-group">
                            <label>NIP</label>
                            <div class="read-only-value">{{ auth()->user()->nip ?? '-' }}</div>
                            <span class="form-helper">Nomor Induk Pegawai tidak dapat diubah</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Bidang Keahlian</label>
                            <div class="read-only-value">{{ auth()->user()->teacher->specialization ?? '-' }}</div>
                            <span class="form-helper">Bidang keahlian tidak dapat diubah</span>
                        </div>
                        <div class="form-group">
                            <label>No. Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="Contoh: 08123456789" value="{{ auth()->user()->phone }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 4: Alamat -->
                    <div class="form-row full">
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3" placeholder="Masukkan alamat lengkap Anda">{{ auth()->user()->address }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 5: Biodata Singkat -->
                    <div class="form-row full">
                        <div class="form-group">
                            <label>Biodata Singkat</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" name="bio" rows="3" placeholder="Ceritakan tentang diri Anda secara singkat...">{{ auth()->user()->bio }}</textarea>
                            <span class="form-helper">Opsional - untuk profil publik Anda</span>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="fas fa-save"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar (Right) -->
        <div class="col-lg-4">
            <div class="side-section">
                <!-- Foto Profile Actions -->
                <div class="info-box">
                    <h5><i class="fas fa-camera"></i>Foto Profil</h5>
                    <p class="mb-3 text-muted" style="font-size: 0.85rem;">Ganti foto Anda untuk memudahkan identifikasi di sistem.</p>
                    <a href="{{ route('teacher.upload-photo') }}" class="btn btn-secondary">
                        <i class="fas fa-upload"></i>Upload Foto Baru
                    </a>
                </div>

                <!-- Keamanan Actions -->
                <div class="info-box">
                    <h5><i class="fas fa-shield-alt"></i>Keamanan Akun</h5>
                    <p class="mb-3 text-muted" style="font-size: 0.85rem;">Ganti password secara berkala untuk menjaga keamanan akun Anda.</p>
                    <a href="{{ route('teacher.change-password') }}" class="btn btn-secondary">
                        <i class="fas fa-key"></i>Ubah Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
