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
    }

    .hero-card {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-light) 100%);
        color: var(--putih);
        padding: 40px;
        border-radius: 12px;
        margin-bottom: 40px;
        box-shadow: 0 4px 15px rgba(45, 68, 56, 0.15);
    }

    .hero-card h1 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .hero-card p {
        font-size: 16px;
        opacity: 0.95;
        margin: 0;
    }

    /* Dashboard Cards Grid */
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background-color: var(--putih);
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(45, 68, 56, 0.08);
        transition: all 0.3s ease;
        border-left: 5px solid;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 20px rgba(45, 68, 56, 0.12);
    }

    .stat-card.siswa {
        border-left-color: #3498db;
    }

    .stat-card.nilai {
        border-left-color: #2ecc71;
    }

    .stat-card.jadwal {
        border-left-color: #f39c12;
    }

    .stat-card.profil {
        border-left-color: #9b59b6;
    }

    .stat-card h6 {
        font-size: 14px;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 15px 0;
        font-weight: 600;
    }

    .stat-card .number {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 10px 0;
    }

    .stat-card .icon {
        font-size: 32px;
        margin-bottom: 10px;
        opacity: 0.8;
    }

    .stat-card .icon.siswa { color: #3498db; }
    .stat-card .icon.nilai { color: #2ecc71; }
    .stat-card .icon.jadwal { color: #f39c12; }
    .stat-card .icon.profil { color: #9b59b6; }

    .stat-card a {
        display: inline-block;
        color: var(--hijau-islam);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        margin-top: 10px;
        transition: all 0.3s ease;
    }

    .stat-card a:hover {
        color: var(--hijau-light);
        margin-left: 5px;
    }

    /* Action Cards */
    .action-card {
        background-color: var(--putih);
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(45, 68, 56, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .action-card:hover {
        box-shadow: 0 6px 20px rgba(45, 68, 56, 0.12);
        transform: translateY(-2px);
    }

    .action-card-header {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-light) 100%);
        color: var(--putih);
        padding: 20px 25px;
    }

    .action-card-header h5 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .action-card-header i {
        margin-right: 10px;
    }

    .action-card-body {
        padding: 25px;
    }

    .action-btn {
        display: block;
        width: 100%;
        padding: 12px 20px;
        margin-bottom: 12px;
        background-color: var(--hijau-islam);
        color: var(--putih);
        text-decoration: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-align: left;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .action-btn:last-child {
        margin-bottom: 0;
    }

    .action-btn:hover {
        background-color: var(--hijau-light);
        color: var(--putih);
        text-decoration: none;
        padding-left: 25px;
    }

    .action-btn i {
        margin-right: 10px;
        width: 20px;
    }

    /* Info Card */
    .info-card {
        background-color: var(--putih);
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(45, 68, 56, 0.08);
        overflow: hidden;
    }

    .info-card-header {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-light) 100%);
        color: var(--putih);
        padding: 20px 25px;
    }

    .info-card-header h5 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .info-card-header i {
        margin-right: 10px;
    }

    .info-card-body {
        padding: 30px 25px;
    }

    .info-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-item {
        border-bottom: 1px solid var(--emas-light);
        padding-bottom: 15px;
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-item strong {
        display: block;
        color: var(--text-dark);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .info-item span {
        color: var(--text-light);
        font-size: 15px;
        display: block;
    }

    .edit-btn {
        background: var(--hijau-islam);
        color: var(--putih);
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .edit-btn:hover {
        background: var(--hijau-light);
        color: var(--putih);
        text-decoration: none;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .dashboard-cards {
            grid-template-columns: 1fr;
        }

        .cards-grid {
            grid-template-columns: 1fr;
        }

        .info-row {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .hero-card {
            padding: 25px;
        }

        .hero-card h1 {
            font-size: 24px;
        }
    }
</style>

<!-- Hero Section -->
<div class="hero-card">
    <h1>Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
    <p>Kelola siswa, nilai, dan jadwal mengajar Anda dengan mudah melalui dashboard ini.</p>
</div>

<!-- Dashboard Cards -->
<div class="dashboard-cards">
    <div class="stat-card siswa">
        <h6>Total Siswa</h6>
        <div class="icon siswa">
            <i class="fas fa-users"></i>
        </div>
        <div class="number">{{ $totalStudents }}</div>
        <a href="{{ route('teacher.students') }}">Lihat Siswa →</a>
    </div>

    <div class="stat-card nilai">
        <h6>Mata Pelajaran</h6>
        <div class="icon nilai">
            <i class="fas fa-book"></i>
        </div>
        <div class="number">{{ $totalClasses }}</div>
        <a href="{{ route('teacher.grades') }}">Kelola Nilai →</a>
    </div>

    <div class="stat-card jadwal">
        <h6>Jadwal Mengajar</h6>
        <div class="icon jadwal">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <a href="{{ route('teacher.schedule') }}">Lihat Jadwal →</a>
    </div>

    <div class="stat-card profil">
        <h6>Profil Saya</h6>
        <div class="icon profil">
            <i class="fas fa-id-card"></i>
        </div>
        <a href="{{ route('teacher.profile') }}">Edit Profil →</a>
    </div>
</div>

<!-- Main Content -->
<div class="cards-grid">
    <!-- Quick Actions -->
    <div class="action-card">
        <div class="action-card-header">
            <h5><i class="fas fa-lightning-bolt"></i>Aksi Cepat</h5>
        </div>
        <div class="action-card-body">
            <a href="{{ route('teacher.grades.edit') }}" class="action-btn">
                <i class="fas fa-plus-circle"></i>Tambah Nilai Baru
            </a>
            <a href="{{ route('teacher.students') }}" class="action-btn">
                <i class="fas fa-list"></i>Lihat Daftar Siswa
            </a>
            <a href="{{ route('teacher.grades') }}" class="action-btn">
                <i class="fas fa-star"></i>Kelola Nilai
            </a>
            <a href="{{ route('teacher.schedule') }}" class="action-btn">
                <i class="fas fa-calendar"></i>Lihat Jadwal
            </a>
        </div>
    </div>

    <!-- Profile Info -->
    <div class="info-card">
        <div class="info-card-header">
            <h5><i class="fas fa-user-tie"></i>Informasi Profil</h5>
        </div>
        <div class="info-card-body">
            <div class="info-row">
                <div class="info-item">
                    <strong>Nama Lengkap</strong>
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <div class="info-item">
                    <strong>Email</strong>
                    <span>{{ auth()->user()->email }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <strong>NIP</strong>
                    <span>{{ auth()->user()->nip ?? 'Belum diisi' }}</span>
                </div>
                <div class="info-item">
                    <strong>Bidang Keahlian</strong>
                    <span>{{ auth()->user()->teacher->specialization ?? 'Belum diisi' }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <strong>No. Telepon</strong>
                    <span>{{ auth()->user()->phone ?? 'Belum diisi' }}</span>
                </div>
                <div class="info-item">
                    <strong>Alamat</strong>
                    <span>{{ auth()->user()->address ?? 'Belum diisi' }}</span>
                </div>
            </div>
            <div style="margin-top: 30px;">
                <a href="{{ route('teacher.profile') }}" class="edit-btn">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
