@extends('layouts.admin')

@section('title', 'Edit Siswa & Guru')

@section('content')
@php
    $currentRole = old('role', $user->role);
@endphp

<div class="admin-form-shell">
    <section class="form-hero">
        <div>
            <p class="form-kicker">Manajemen Akun</p>
            <h1>Edit Siswa & Guru</h1>
            <p class="form-subtitle">
                Perbarui profil, status, dan data khusus akun siswa atau guru.
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

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="admin-form-card">
        @csrf
        @method('PUT')

        <div class="profile-preview-wrap">
            <div class="profile-preview">
                @if ($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto Profil">
                @else
                    <div class="profile-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                @endif
            </div>
            <div>
                <p class="preview-label">Akun yang sedang diedit</p>
                <h2>{{ $user->name }}</h2>
                <p class="preview-meta">{{ ucfirst($user->role) }} • {{ $user->email }}</p>
            </div>
        </div>

        <div class="form-grid two-col">
            <div class="field-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')<small>{{ $message }}</small>@enderror
            </div>

            <div class="field-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<small>{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="form-grid two-col">
            <div class="field-group">
                <label for="role">Pilih Jenis Akun</label>
                <select id="role" name="role" required onchange="toggleRoleFields()">
                    <option value="siswa" {{ $currentRole === 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ $currentRole === 'guru' ? 'selected' : '' }}>Guru</option>
                </select>
                @error('role')<small>{{ $message }}</small>@enderror
            </div>

            <div class="field-group">
                <label for="phone">No. Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Opsional">
                @error('phone')<small>{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="form-grid two-col">
            <div class="field-group">
                <label for="profile_photo">Foto Profil Baru</label>
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
                @error('profile_photo')<small>{{ $message }}</small>@enderror
            </div>

            <div class="field-group">
                <label for="address">Alamat</label>
                <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}" placeholder="Alamat singkat">
                @error('address')<small>{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="field-group">
            <label for="bio">Bio Singkat</label>
            <textarea id="bio" name="bio" rows="3" placeholder="Ringkasan singkat profil akun">{{ old('bio', $user->bio) }}</textarea>
            @error('bio')<small>{{ $message }}</small>@enderror
        </div>

        <div class="role-panel" id="student-fields" style="display: none;">
            <div class="role-panel-header">
                <i class="fas fa-user-graduate"></i>
                <div>
                    <h3>Data Siswa</h3>
                    <p>Field ini ditampilkan saat role akun adalah siswa.</p>
                </div>
            </div>

            <div class="form-grid two-col">
                <div class="field-group" id="jenjang-field-group">
                    <label for="jenjang">Jenjang</label>
                    <select id="jenjang" name="jenjang" onchange="toggleJenjangFields()">
                        <option value="TK" {{ old('jenjang', $user->student->jenjang ?? '') == 'TK' ? 'selected' : '' }}>TK</option>
                        <option value="SD" {{ old('jenjang', $user->student->jenjang ?? '') == 'SD' || !old('jenjang', $user->student->jenjang ?? '') ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('jenjang', $user->student->jenjang ?? '') == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMK" {{ old('jenjang', $user->student->jenjang ?? '') == 'SMK' ? 'selected' : '' }}>SMK</option>
                    </select>
                    @error('jenjang')<small>{{ $message }}</small>@enderror
                </div>

                <div class="field-group" id="nisn-field-group">
                    <label for="nisn">NISN</label>
                    <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $user->nisn) }}">
                    @error('nisn')<small>{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="form-grid two-col">
                <div class="field-group">
                    <label for="class">Kelas</label>
                    <select id="class" name="class" data-old-value="{{ old('class', $user->class) }}">
                        <!-- Diisi secara dinamis oleh JavaScript -->
                    </select>
                    @error('class')<small>{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="role-panel" id="teacher-fields" style="display: none;">
            <div class="role-panel-header">
                <i class="fas fa-chalkboard-user"></i>
                <div>
                    <h3>Data Guru</h3>
                    <p>Field ini ditampilkan saat role akun adalah guru.</p>
                </div>
            </div>

            <div class="form-grid two-col">
                <div class="field-group">
                    <label for="nip">NIP</label>
                    <input type="text" id="nip" name="nip" value="{{ old('nip', $user->nip) }}">
                    @error('nip')<small>{{ $message }}</small>@enderror
                </div>

                <div class="field-group">
                    <label for="specialization">Bidang Keahlian</label>
                    <input type="text" id="specialization" name="specialization" value="{{ old('specialization', $user->specialization) }}">
                    @error('specialization')<small>{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="field-group inline-toggle">
            <label class="toggle-label" for="is_active">
                <span>Status Akun</span>
                <small>Nonaktifkan jika akun sedang tidak boleh masuk.</small>
            </label>
            <div class="toggle-control">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                <span>Akun aktif</span>
            </div>
            @error('is_active')<small>{{ $message }}</small>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                Batal
            </a>
        </div>
    </form>
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
        margin-bottom: 18px;
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

<script>
    const classOptions = {
        'TK': ['TK-A', 'TK-B'],
        'SD': ['1', '2', '3', '4', '5', '6'],
        'SMP': ['7', '8', '9'],
        'SMK': ['10-RPL', '10-TKJ', '11-RPL', '11-TKJ', '12-RPL', '12-TKJ']
    };

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

        populateClassOptions(jenjang);
    }

    function populateClassOptions(jenjang) {
        const classSelect = document.getElementById('class');
        const selectedValue = classSelect.getAttribute('data-old-value') || classSelect.value;
        
        classSelect.innerHTML = '';
        
        if (classOptions[jenjang]) {
            classOptions[jenjang].forEach(option => {
                const optElement = document.createElement('option');
                optElement.value = option;
                optElement.textContent = option;
                if (option === selectedValue) {
                    optElement.selected = true;
                }
                classSelect.appendChild(optElement);
            });
        }

        // Remove the data-old-value after first load so subsequent changes don't force select it
        classSelect.removeAttribute('data-old-value');
    }

    document.addEventListener('DOMContentLoaded', () => {
        toggleRoleFields();
    });
</script>
@endsection
