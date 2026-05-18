@extends('student.layout')

@section('student-content')
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

    .stat-card.jadwal {
        border-left-color: #3498db;
    }

    .stat-card.nilai {
        border-left-color: #2ecc71;
    }

    .stat-card.profil {
        border-left-color: #9b59b6;
    }

    .stat-card.keamanan {
        border-left-color: #e74c3c;
    }

    .stat-card h6 {
        font-size: 14px;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 15px 0;
        font-weight: 600;
    }

    .stat-card .icon {
        font-size: 32px;
        margin-bottom: 10px;
        opacity: 0.8;
    }

    .stat-card .icon.jadwal { color: #3498db; }
    .stat-card .icon.nilai { color: #2ecc71; }
    .stat-card .icon.profil { color: #9b59b6; }
    .stat-card .icon.keamanan { color: #e74c3c; }

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

    @media (max-width: 768px) {
        .dashboard-cards {
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
    <p>Kelola data akademik dan profil Anda dengan mudah melalui dashboard ini.</p>
</div>

<!-- Dashboard Cards -->
<div class="dashboard-cards">
    <div class="stat-card jadwal">
        <h6>Jadwal Sekolah</h6>
        <div class="icon jadwal">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <a href="{{ route('student.schedule') }}">Lihat Jadwal →</a>
    </div>

    <div class="stat-card nilai">
        <h6>Nilai Saya</h6>
        <div class="icon nilai">
            <i class="fas fa-star"></i>
        </div>
        <a href="{{ route('student.grades') }}">Lihat Nilai →</a>
    </div>

    <div class="stat-card profil">
        <h6>Data Saya</h6>
        <div class="icon profil">
            <i class="fas fa-user"></i>
        </div>
        <a href="{{ route('student.profile') }}">Lihat Data →</a>
    </div>

    <div class="stat-card keamanan">
        <h6>Keamanan</h6>
        <div class="icon keamanan">
            <i class="fas fa-lock"></i>
        </div>
        <a href="{{ route('student.change-password') }}">Ubah Password →</a>
    </div>
</div>

<!-- Profile Info Card -->
<div class="info-card">
    <div class="info-card-header">
        <h5>Informasi Profil Anda</h5>
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
                <strong>NISN</strong>
                <span>{{ auth()->user()->nisn ?? 'Belum diisi' }}</span>
            </div>
            <div class="info-item">
                <strong>Kelas</strong>
                <span>{{ auth()->user()->class ?? 'Belum diisi' }}</span>
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
            <a href="{{ route('student.profile') }}" class="edit-btn">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection
