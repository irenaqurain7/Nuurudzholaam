@extends('teacher.layout')

@section('teacher-content')
<style>
    :root {
        --hijau-islam: #2D4438;
        --hijau-light: #486E5A;
        --hijau-subtle: rgba(45, 68, 56, 0.04);
        --emas: #709D88;
        --emas-light: #E2ECE8;
        --text-dark: #1C2D25;
        --text-muted: #667A70;
        --border: #E2ECE8;
        --bg-light: #F4F7F5;
        --putih: #ffffff;
    }

    /* Hero Section - Dibuat lebih modern dan anggun */
    .hero-card {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-light) 100%);
        color: var(--putih);
        padding: 2.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(45, 68, 56, 0.12);
        position: relative;
        overflow: hidden;
    }

    .hero-card h1 {
        font-size: 1.85rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .hero-card p {
        font-size: 0.95rem;
        opacity: 0.85;
        margin: 0;
    }

    /* Dashboard Cards Grid */
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background-color: var(--putih);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(45, 68, 56, 0.06);
    }

    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .stat-card h6 {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.75px;
        margin: 0;
        font-weight: 600;
    }

    .stat-card .number {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1;
        margin: 0.25rem 0 1rem 0;
    }

    /* Icon wrappers dengan warna pastel yang clean */
    .icon-wrapper {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
    }

    .stat-card.siswa .icon-wrapper { background-color: rgba(52, 152, 219, 0.1); color: #2980b9; }
    .stat-card.nilai .icon-wrapper { background-color: rgba(46, 204, 113, 0.1); color: #27ae60; }
    .stat-card.jadwal .icon-wrapper { background-color: rgba(243, 156, 18, 0.1); color: #d35400; }
    .stat-card.profil .icon-wrapper { background-color: rgba(155, 89, 182, 0.1); color: #8e44ad; }

    .stat-card a {
        display: inline-flex;
        align-items: center;
        color: var(--hijau-islam);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: color 0.2s;
    }

    .stat-card a:hover {
        color: var(--hijau-light);
    }

    /* Info Card Profile - Dibuat clean tanpa tumpukan gradient kasar */
    .info-card {
        background-color: var(--putih);
        border-radius: 12px;
        border: 1px solid var(--border);
        overflow: hidden;
        width: 100%;
    }

    .info-card-header {
        background-color: var(--hijau-subtle);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .info-card-header h5 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .info-card-header i {
        color: var(--hijau-islam);
        font-size: 1.1rem;
    }

    .info-card-body {
        padding: 1.75rem 1.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem 2rem;
    }

    .info-item {
        border-bottom: 1px solid rgba(45, 68, 56, 0.06);
        padding-bottom: 0.75rem;
    }

    .info-item strong {
        display: block;
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }

    .info-item span {
        color: var(--text-dark);
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* Action & Navigation Buttons */
    .edit-btn {
        background-color: var(--hijau-islam);
        color: var(--putih);
        border: none;
        padding: 0.6rem 1.25rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }

    .edit-btn:hover {
        background-color: var(--hijau-light);
        color: var(--putih);
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
        .hero-card {
            padding: 1.75rem;
        }
        .hero-card h1 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="hero-card">
    <h1>Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
    <p>Kelola data siswa, nilai akademik, dan pantau jadwal mengajar Anda dari satu halaman terpusat.</p>
</div>

<div class="dashboard-cards">
    <div class="stat-card siswa">
        <div>
            <div class="stat-card-header">
                <h6>Total Siswa</h6>
                <div class="icon-wrapper">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="number">{{ $totalStudents }}</div>
        </div>
        <a href="{{ route('teacher.students') }}">Lihat Kelas Bimbingan <i class="fas fa-arrow-right ms-1" style="font-size: 0.75rem;"></i></a>
    </div>

    <div class="stat-card nilai">
        <div>
            <div class="stat-card-header">
                <h6>Mata Pelajaran</h6>
                <div class="icon-wrapper">
                    <i class="fas fa-book"></i>
                </div>
            </div>
            <div class="number">{{ $totalClasses }}</div>
        </div>
        <a href="{{ route('teacher.grades') }}">Input & Kelola Nilai <i class="fas fa-arrow-right ms-1" style="font-size: 0.75rem;"></i></a>
    </div>

    <div class="stat-card jadwal">
        <div>
            <div class="stat-card-header">
                <h6>Jadwal Hari Ini</h6>
                <div class="icon-wrapper">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <div class="number" style="font-size: 1.25rem; font-weight: 600; margin: 1rem 0; color: var(--text-dark);">
                Buka Agenda
            </div>
        </div>
        <a href="{{ route('teacher.schedule') }}">Lihat Jadwal Mengajar <i class="fas fa-arrow-right ms-1" style="font-size: 0.75rem;"></i></a>
    </div>

    <div class="stat-card profil">
        <div>
            <div class="stat-card-header">
                <h6>Akun Pengguna</h6>
                <div class="icon-wrapper">
                    <i class="fas fa-user-badge"></i>
                </div>
            </div>
            <div class="number" style="font-size: 1.25rem; font-weight: 600; margin: 1rem 0; color: var(--text-dark);">
                Terverifikasi
            </div>
        </div>
        <a href="{{ route('teacher.profile') }}">Pengaturan Akun <i class="fas fa-arrow-right ms-1" style="font-size: 0.75rem;"></i></a>
    </div>
</div>

<div class="info-card">
    <div class="info-card-header">
        <i class="fas fa-user-circle"></i>
        <h5>Informasi Profil Guru</h5>
    </div>
    <div class="info-card-body">
        <div class="info-grid">
            <div class="info-item">
                <strong>Nama Lengkap</strong>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <div class="info-item">
                <strong>Alamat Email</strong>
                <span>{{ auth()->user()->email }}</span>
            </div>
            <div class="info-item">
                <strong>Nomor Induk Pegawai (NIP)</strong>
                <span>{{ auth()->user()->nip ?? 'Belum diisi' }}</span>
            </div>
            <div class="info-item">
                <strong>Bidang Keahlian / Spesialisasi</strong>
                <span>{{ auth()->user()->teacher->specialization ?? 'Belum diisi' }}</span>
            </div>
            <div class="info-item">
                <strong>No. Telepon Aktif</strong>
                <span>{{ auth()->user()->phone ?? 'Belum diisi' }}</span>
            </div>
            <div class="info-item">
                <strong>Alamat Rumah</strong>
                <span>{{ auth()->user()->address ?? 'Belum diisi' }}</span>
            </div>
        </div>

        <a href="{{ route('teacher.profile') }}" class="edit-btn">
            <i class="fas fa-edit"></i> Perbarui Profil Saya
        </a>
    </div>
</div>
@endsection
