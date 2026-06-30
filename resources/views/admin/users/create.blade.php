@extends('layouts.admin')

@section('title', 'Tambah Siswa & Guru')

@section('content')
@php
    $selectedRole = old('role');
@endphp

<div class="admin-form-shell">
    <section class="form-hero">
        <div>
            <p class="form-kicker">Manajemen Akun</p>
            <h1>Tambah Siswa & Guru</h1>
            <p class="form-subtitle">
                Buat akun baru untuk siswa atau guru beserta data profil dasar yang dibutuhkan untuk login dan pendataan.
            </p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="form-back-link">
            <i class="fas fa-arrow-left"></i>
            Kembali ke daftar
        </a>
    </section>

    @if ($errors->any())
        <div class="alert-box">
            <i class="fas fa-circle-exclamation"></i>
            <div>
                <strong>Periksa kembali data yang diisi.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="admin-form-card">
        @csrf

        <div class="form-grid two-col">
            <div class="field-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                @error('name')<small>{{ $message }}</small>@enderror
            </div>

            <div class="field-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                @error('email')<small>{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="form-grid two-col">
            <div class="field-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                @error('password')<small>{{ $message }}</small>@enderror
            </div>

            <div class="field-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                @error('password_confirmation')<small>{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="form-grid two-col">
            <div class="field-group">
                <label for="role">Pilih Jenis Akun</label>
                <select id="role" name="role" required onchange="toggleRoleFields()">
                    <option value="">-- Pilih role --</option>
                    <option value="siswa" {{ $selectedRole === 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ $selectedRole === 'guru' ? 'selected' : '' }}>Guru</option>
                </select>
                @error('role')<small>{{ $message }}</small>@enderror
            </div>

            <div class="field-group">
                <label for="phone">No. Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Opsional">
                @error('phone')<small>{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="form-grid two-col">
            <div class="field-group">
                <label for="profile_photo">Foto Profil</label>
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
                @error('profile_photo')<small>{{ $message }}</small>@enderror
            </div>

            <div class="field-group">
                <label for="address">Alamat</label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Alamat singkat">
                @error('address')<small>{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="field-group">
            <label for="bio">Bio Singkat</label>
            <textarea id="bio" name="bio" rows="3" placeholder="Ringkasan singkat profil akun">{{ old('bio') }}</textarea>
            @error('bio')<small>{{ $message }}</small>@enderror
        </div>

        <div class="role-panel" id="student-fields" style="display: none;">
            <div class="role-panel-header">
                <i class="fas fa-user-graduate"></i>
                <div>
                    <h3>Data Siswa</h3>
                    <p>Field ini diisi jika jenis akun yang dipilih adalah siswa.</p>
                </div>
            </div>

            <div class="form-grid two-col">
                <div class="field-group" id="jenjang-field-group">
                    <label for="jenjang">Jenjang</label>
                    <select id="jenjang" name="jenjang" onchange="toggleJenjangFields()">
                        <option value="TK" {{ old('jenjang') == 'TK' ? 'selected' : '' }}>TK</option>
                        <option value="SD" {{ old('jenjang') == 'SD' || !old('jenjang') ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMK" {{ old('jenjang') == 'SMK' ? 'selected' : '' }}>SMK</option>
                    </select>
                    @error('jenjang')<small>{{ $message }}</small>@enderror
                </div>

                <div class="field-group" id="nisn-field-group">
                    <label for="nisn">NISN</label>
                    <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}" placeholder="Nomor induk siswa">
                    @error('nisn')<small>{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="form-grid two-col">
                <div class="field-group">
                    <label for="class">Kelas</label>
                    <input type="text" id="class" name="class" value="{{ old('class') }}" placeholder="Contoh: 7A">
                    @error('class')<small>{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="role-panel" id="teacher-fields" style="display: none;">
            <div class="role-panel-header">
                <i class="fas fa-chalkboard-user"></i>
                <div>
                    <h3>Data Guru</h3>
                    <p>Field ini diisi jika jenis akun yang dipilih adalah guru.</p>
                </div>
            </div>

            <div class="form-grid two-col">
                <div class="field-group">
                    <label for="nip">NIP</label>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}" placeholder="Nomor induk pegawai">
                    @error('nip')<small>{{ $message }}</small>@enderror
                </div>

                <div class="field-group">
                    <label for="specialization">Bidang Keahlian</label>
                    <input type="text" id="specialization" name="specialization" value="{{ old('specialization') }}" placeholder="Contoh: Matematika">
                    @error('specialization')<small>{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="field-group inline-toggle">
            <label class="toggle-label" for="is_active">
                <span>Status Akun</span>
                <small>Akun aktif bisa langsung login ke sistem.</small>
            </label>
            <div class="toggle-control">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <span>Akun aktif</span>
            </div>
            @error('is_active')<small>{{ $message }}</small>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                Simpan Akun
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                Batal
            </a>
        </div>
    </form>

    <div class="admin-form-card">
        <div class="role-panel-header" style="margin-bottom: 14px;">
            <i class="fas fa-file-excel"></i>
            <div>
                <h3>Tambah Sekaligus via Excel / CSV</h3>
                <p class="import-kicker">IMPORT MASSAL</p>
            </div>
        </div>

        <p class="import-subtitle">
            Fitur ini digunakan untuk memasukkan data siswa atau guru dalam jumlah banyak secara bersamaan. Silakan unduh template format berkas terlebih dahulu agar struktur data sesuai.
        </p>

        <div class="form-grid two-col alignment-stretch" style="margin-bottom: 0; margin-top: 20px;">
            <div class="field-group">
                <label>1. Unduh Format Contoh</label>
                <a href="{{ route('admin.users.download-template') }}" class="btn-secondary btn-full-height">
                    <i class="fas fa-download" style="color: #3d5a4c;"></i>
                    Download Template Format CSV
                </a>
            </div>

            <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data" class="field-group">
                @csrf
                <label for="file_excel">2. Pilih & Upload Berkas</label>
                <div class="import-upload-group">
                    <input type="file" id="file_excel" name="file_excel" required accept=".csv, text/csv">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-upload"></i> Proses Import
                    </button>
                </div>
            </form>
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

    .import-kicker {
        margin: 2px 0 0;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-size: 11px;
        font-weight: 700;
        color: #6c8b7c;
    }

    .form-hero h1 {
        margin: 0;
        font-size: clamp(28px, 3vw, 42px);
        line-height: 1.08;
    }

    .form-subtitle, .import-subtitle {
        margin: 14px 0 0;
        max-width: 62ch;
        color: rgba(255, 255, 255, 0.84);
    }

    .import-subtitle {
        color: #556b60;
        font-size: 14px;
        line-height: 1.6;
        margin-top: 6px;
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

    .admin-form-card {
        background: #ffffff;
        border: 1px solid #e2ece8;
        border-radius: 24px;
        padding: 28px;
        box-shadow: 0 18px 40px rgba(28, 45, 37, 0.08);
    }

    .alert-box {
        display: flex;
        gap: 14px;
        padding: 18px 20px;
        border-radius: 18px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .alert-box i {
        font-size: 20px;
        margin-top: 2px;
    }

    .alert-box strong {
        display: block;
        margin-bottom: 8px;
    }

    .alert-box ul {
        margin: 0;
        padding-left: 18px;
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
    }

    .field-group label {
        font-weight: 700;
        color: #1c2d25;
        font-size: 14px;
    }

    .field-group input,
    .field-group select,
    .field-group textarea {
        width: 100%;
        border: 1px solid #dbe7e1;
        border-radius: 16px;
        padding: 13px 16px;
        background: #fbfcfb;
        color: #1c2d25;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .field-group input:focus,
    .field-group select:focus,
    .field-group textarea:focus {
        border-color: #2d4438;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(45, 68, 56, 0.08);
    }

    .field-group small {
        color: #dc2626;
        font-weight: 600;
    }

    .field-group.inline-toggle {
        padding: 16px;
        border-radius: 16px;
        background: #f7faf8;
        border: 1px solid #dbe7e1;
    }

    .toggle-label {
        display: flex;
        flex-direction: column;
        gap: 4px;
        margin-bottom: 10px;
    }

    .toggle-label small {
        color: #6c8b7c;
        font-weight: 500;
    }

    .toggle-control {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #1c2d25;
        font-weight: 700;
    }

    .toggle-control input {
        width: 18px;
        height: 18px;
        accent-color: #2d4438;
    }

    .role-panel {
        margin-top: 18px;
        padding: 20px;
        border-radius: 20px;
        background: #f7faf8;
        border: 1px solid #dbe7e1;
    }

    .role-panel-header {
        display: flex;
        gap: 14px;
        align-items: center;
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
        margin: 0;
        color: #1c2d25;
        font-size: 18px;
        font-weight: 700;
    }

    .role-panel-header p {
        margin: 4px 0 0;
        color: #6c8b7c;
        font-size: 14px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-top: 22px;
        flex-wrap: wrap;
    }

    .btn-primary,
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px 18px;
        border-radius: 14px;
        text-decoration: none;
        font-weight: 700;
        border: none;
        cursor: pointer;
        font-size: 14px;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #2d4438 0%, #486e5a 100%);
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(45, 68, 56, 0.18);
    }

    .btn-primary:hover,
    .btn-secondary:hover,
    .form-back-link:hover {
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: #edf4ef;
        color: #1c2d25;
        border: 1px solid #dbe7e1;
    }

    /* Penyelaras Komponen Download & Upload */
    .btn-full-height {
        padding: 13px 16px;
        height: 48px;
        box-sizing: border-box;
    }

    .import-upload-group {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .import-upload-group input[type="file"] {
        padding: 11px 16px;
        height: 48px;
        box-sizing: border-box;
    }

    .import-upload-group .btn-primary {
        height: 48px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    @media (max-width: 900px) {
        .form-hero {
            flex-direction: column;
        }

        .form-grid.two-col {
            grid-template-columns: 1fr;
        }

        .import-upload-group {
            flex-direction: column;
            align-items: stretch;
        }

        .import-upload-group .btn-primary, .btn-full-height {
            width: 100%;
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
    }
</style>

<script>
    function toggleRoleFields() {
        const role = document.getElementById('role').value;
        const studentFields = document.getElementById('student-fields');
        const teacherFields = document.getElementById('teacher-fields');

        studentFields.style.display = role === 'siswa' ? 'block' : 'none';
        teacherFields.style.display = role === 'guru' ? 'block' : 'none';

        if (role === 'siswa') {
            toggleJenjangFields();
        }
    }

    function toggleJenjangFields() {
        const jenjang = document.getElementById('jenjang').value;
        const nisnGroup = document.getElementById('nisn-field-group');
        
        if (jenjang === 'TK') {
            nisnGroup.style.display = 'none';
        } else {
            nisnGroup.style.display = 'flex';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        toggleRoleFields();
    });
</script>
@endsection
