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
        --danger: #dc3545;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .page-header p {
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

    .form-group {
        margin-bottom: 1.5rem;
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

    /* Otomatisasi border merah saat error divalidasi Laravel */
    .form-control.is-invalid {
        border-color: var(--danger);
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.1);
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
        margin-bottom: 0.75rem;
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
        color: var(--danger);
        font-size: 0.85rem;
        margin-top: 0.3rem;
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
        .page-header h1 {
            font-size: 1.5rem;
        }

        .section {
            padding: 1.5rem;
        }
    }
</style>

<div class="page-header">
    <h1>Ubah Password</h1>
    <p>Perbarui password Anda untuk keamanan akun yang lebih baik</p>
</div>

<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('teacher.change-password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="section">
                <h5><i class="fas fa-lock"></i> Password Baru</h5>

                <div class="form-group">
                    <label for="current_password">Password Saat Ini</label>
                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    <span class="form-helper">Minimal 8 karakter, kombinasi huruf dan angka direkomendasikan</span>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check"></i> Ubah Password
                </button>
                <a href="{{ route('teacher.profile') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>

    <div class="col-lg-6">
        <div class="info-box" style="height: fit-content;">
            <h5><i class="fas fa-shield-alt"></i> Tips Keamanan</h5>
            <div style="margin-bottom: 1rem;">
                <p><strong>Password yang kuat:</strong></p>
                <ul style="font-size: 0.85rem; color: var(--text-secondary); margin: 0.5rem 0; padding-left: 1.5rem;">
                    <li>Minimal 8 karakter</li>
                    <li>Kombinasi huruf besar dan kecil</li>
                    <li>Tambahkan angka atau simbol</li>
                    <li>Jangan gunakan tanggal lahir atau informasi pribadi</li>
                </ul>
            </div>
            <p style="margin: 0; padding-top: 1rem; border-top: 1px solid var(--border); font-size: 0.85rem;">Ganti password Anda secara berkala untuk menjaga keamanan akun.</p>
        </div>
    </div>
</div>
@endsection
