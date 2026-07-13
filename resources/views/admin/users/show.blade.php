@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')

<div class="admin-form-shell">
    <section class="form-hero">
        <div>
            <p class="form-kicker">Manajemen Akun</p>
            <h1>Detail Profil</h1>
            <p class="form-subtitle">
                Melihat profil, status, dan data khusus akun. Data pada halaman ini hanya dapat dilihat (read-only).
            </p>
        </div>
        <a href="{{ url()->previous() == route('admin.users.archive') ? route('admin.users.archive') : route('admin.users.index') }}" class="form-back-link">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </section>

    <div class="admin-form-card">
        <div class="profile-preview-wrap">
            <div class="profile-preview">
                @if ($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto Profil">
                @else
                    <div class="profile-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                @endif
            </div>
            <div>
                <p class="preview-label">Profil Akun</p>
                <h2>{{ $user->name }}</h2>
                <p class="preview-meta">{{ ucfirst($user->role) }} • {{ $user->email }}</p>
                @if($user->is_archived)
                <p style="margin-top: 5px;"><span class="badge" style="background: #eab308; color: #fff; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: bold;"><i class="fas fa-archive"></i> Diarsipkan (Lulusan {{ $user->graduation_year ?? '-' }})</span></p>
                @endif
            </div>
        </div>

        <div class="form-grid two-col">
            <div class="field-group">
                <label>Nama Lengkap</label>
                <div class="readonly-value">{{ $user->name }}</div>
            </div>

            <div class="field-group">
                <label>Email</label>
                <div class="readonly-value">{{ $user->email }}</div>
            </div>
        </div>

        <div class="form-grid two-col">
            <div class="field-group">
                <label>Jenis Akun</label>
                <div class="readonly-value">{{ ucfirst($user->role) }}</div>
            </div>

            <div class="field-group">
                <label>No. Telepon</label>
                <div class="readonly-value">{{ $user->phone ?: '-' }}</div>
            </div>
        </div>

        <div class="form-grid two-col">
            <div class="field-group">
                <label>Alamat</label>
                <div class="readonly-value">{{ $user->address ?: '-' }}</div>
            </div>
        </div>

        <div class="field-group">
            <label>Bio Singkat</label>
            <div class="readonly-value" style="min-height: 80px;">{{ $user->bio ?: '-' }}</div>
        </div>

        @if($user->role === 'siswa' && $user->student)
        <div class="role-panel">
            <div class="role-panel-header">
                <i class="fas fa-user-graduate"></i>
                <div>
                    <h3>Data Siswa</h3>
                    <p>Informasi detail untuk akun siswa.</p>
                </div>
            </div>

            <div class="form-grid two-col">
                <div class="field-group">
                    <label>Jenjang</label>
                    <div class="readonly-value">{{ $user->student->jenjang }}</div>
                </div>

                <div class="field-group">
                    <label>{{ $user->student->jenjang === 'TK' ? 'Kode Siswa' : 'NISN' }}</label>
                    <div class="readonly-value">{{ $user->student->nisn ?: '-' }}</div>
                </div>
            </div>

            <div class="form-grid two-col">
                <div class="field-group">
                    <label>Kelas</label>
                    <div class="readonly-value">{{ $user->student->class ?: '-' }}</div>
                </div>
            </div>
        </div>
        @endif

        @if($user->role === 'guru' && $user->teacher)
        <div class="role-panel">
            <div class="role-panel-header">
                <i class="fas fa-chalkboard-user"></i>
                <div>
                    <h3>Data Guru</h3>
                    <p>Informasi detail untuk akun guru.</p>
                </div>
            </div>

            <div class="form-grid two-col">
                <div class="field-group">
                    <label>Kode Guru / NIP</label>
                    <div class="readonly-value">{{ $user->teacher->nip ?: '-' }}</div>
                </div>

                <div class="field-group">
                    <label>Bidang Keahlian</label>
                    <div class="readonly-value">{{ $user->teacher->specialization ?: '-' }}</div>
                </div>
            </div>
        </div>
        @endif

        <div class="field-group inline-toggle">
            <label class="toggle-label">
                <span>Status Akun</span>
            </label>
            <div class="toggle-control">
                @if($user->is_active)
                    <span style="color: #059669; font-weight: bold;"><i class="fas fa-check-circle"></i> Akun Aktif</span>
                @else
                    <span style="color: #dc2626; font-weight: bold;"><i class="fas fa-times-circle"></i> Akun Nonaktif</span>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .admin-form-shell {
        max-width: 1100px;
        margin: 0 auto;
        padding: 28px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .form-hero {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        align-items: flex-start;
        padding: 28px;
        border-radius: 24px;
        background: linear-gradient(135deg, #23352c 0%, #2d4438 48%, #486e5a 100%);
        color: #ffffff;
        box-shadow: 0 18px 40px rgba(28, 45, 37, 0.16);
    }

    .form-kicker {
        margin: 0 0 10px;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        font-size: 12px;
        font-weight: 700;
        opacity: 0.82;
    }

    .form-hero h1 {
        margin: 0;
        font-size: clamp(28px, 3vw, 42px);
        line-height: 1.08;
    }

    .form-subtitle {
        margin: 14px 0 0;
        max-width: 62ch;
        color: rgba(255, 255, 255, 0.84);
    }

    .form-back-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 14px;
        text-decoration: none;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.12);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.18);
        white-space: nowrap;
    }
    
    .form-back-link:hover {
        transform: translateY(-1px);
    }

    .admin-form-card {
        background: #ffffff;
        border: 1px solid #e2ece8;
        border-radius: 24px;
        padding: 28px;
        box-shadow: 0 18px 40px rgba(28, 45, 37, 0.08);
    }

    .profile-preview-wrap {
        display: flex;
        gap: 16px;
        align-items: center;
        padding: 18px;
        border-radius: 20px;
        background: #f7faf8;
        border: 1px solid #dbe7e1;
        margin-bottom: 24px;
    }

    .profile-preview {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        overflow: hidden;
        background: linear-gradient(135deg, #2d4438 0%, #486e5a 100%);
        flex-shrink: 0;
    }

    .profile-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .profile-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 28px;
        font-weight: 800;
    }

    .preview-label {
        margin: 0 0 6px;
        color: #6c8b7c;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .profile-preview-wrap h2 {
        margin: 0 0 6px;
        color: #1c2d25;
        font-size: 22px;
    }

    .preview-meta {
        margin: 0;
        color: #6c8b7c;
        font-size: 14px;
    }

    .form-grid {
        display: grid;
        gap: 16px;
        margin-bottom: 16px;
    }

    .form-grid.two-col {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .field-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 16px;
    }

    .field-group label {
        font-weight: 700;
        color: #6c8b7c;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .readonly-value {
        width: 100%;
        border: 1px solid #e2ece8;
        border-radius: 16px;
        padding: 13px 16px;
        background: #fbfcfb;
        color: #1c2d25;
        font-size: 15px;
        font-weight: 500;
    }

    .field-group.inline-toggle {
        padding: 16px;
        border-radius: 16px;
        background: #f7faf8;
        border: 1px solid #dbe7e1;
        margin-top: 24px;
    }

    .toggle-label {
        display: flex;
        flex-direction: column;
        gap: 4px;
        margin-bottom: 10px;
    }

    .role-panel {
        margin-top: 24px;
        padding: 20px;
        border-radius: 20px;
        background: #f7faf8;
        border: 1px solid #dbe7e1;
    }

    .role-panel-header {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        margin-bottom: 18px;
    }

    .role-panel-header i {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: linear-gradient(135deg, #2d4438 0%, #486e5a 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .role-panel-header h3 {
        margin: 0 0 4px;
        color: #1c2d25;
        font-size: 18px;
    }

    .role-panel-header p {
        margin: 0;
        color: #6c8b7c;
        font-size: 14px;
    }

    @media (max-width: 900px) {
        .form-hero {
            flex-direction: column;
        }

        .form-grid.two-col,
        .profile-preview-wrap {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .admin-form-shell {
            padding: 16px;
        }

        .form-hero,
        .admin-form-card {
            border-radius: 18px;
            padding: 20px;
        }

        .profile-preview-wrap {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

@endsection
