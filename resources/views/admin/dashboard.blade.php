@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="admin-container">
    <h1>Dashboard Admin</h1>
    <p style="color: var(--text-light); margin-bottom: 40px;">Selamat datang di panel administrasi Sekolah Islam Nuurudzholaam</p>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-bottom: 50px;">
        <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: rgba(255,255,255,0.9); margin: 0 0 10px 0; font-size: 14px; font-weight: 600;">PPDB Terdaftar</p>
                    <h3 style="color: white; margin: 0; font-size: 36px; font-weight: bold;">{{ $totalPPDB }}</h3>
                </div>
                <i class="fas fa-users" style="color: rgba(255,255,255,0.3); font-size: 48px;"></i>
            </div>
        </div>

        <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: rgba(255,255,255,0.9); margin: 0 0 10px 0; font-size: 14px; font-weight: 600;">Pending Review</p>
                    <h3 style="color: white; margin: 0; font-size: 36px; font-weight: bold;">{{ $ppdbBaru }}</h3>
                </div>
                <i class="fas fa-hourglass-half" style="color: rgba(255,255,255,0.3); font-size: 48px;"></i>
            </div>
        </div>

        <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: rgba(255,255,255,0.9); margin: 0 0 10px 0; font-size: 14px; font-weight: 600;">Kegiatan</p>
                    <h3 style="color: white; margin: 0; font-size: 36px; font-weight: bold;">{{ $totalKegiatan }}</h3>
                </div>
                <i class="fas fa-calendar" style="color: rgba(255,255,255,0.3); font-size: 48px;"></i>
            </div>
        </div>

        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: rgba(255,255,255,0.9); margin: 0 0 10px 0; font-size: 14px; font-weight: 600;">Program</p>
                    <h3 style="color: white; margin: 0; font-size: 36px; font-weight: bold;">{{ $totalProgram }}</h3>
                </div>
                <i class="fas fa-book" style="color: rgba(255,255,255,0.3); font-size: 48px;"></i>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 50px;">
        <h2 style="color: var(--hijau-islam); margin-bottom: 25px; font-size: 20px;">Akses Cepat</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <a href="{{ route('admin.ppdb.index') }}" class="quick-action-btn">
                <i class="fas fa-list"></i>
                <span>Lihat PPDB</span>
            </a>
            <a href="{{ route('admin.activity.index') }}" class="quick-action-btn">
                <i class="fas fa-plus"></i>
                <span>Tambah Kegiatan</span>
            </a>
            <a href="{{ route('admin.program.index') }}" class="quick-action-btn">
                <i class="fas fa-book-open"></i>
                <span>Kelola Program</span>
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="quick-action-btn">
                <i class="fas fa-images"></i>
                <span>Galeri Foto</span>
            </a>
            <a href="{{ route('admin.announcement.index') }}" class="quick-action-btn">
                <i class="fas fa-bell"></i>
                <span>Pengumuman</span>
            </a>
            <a href="{{ route('admin.school-info.edit') }}" class="quick-action-btn">
                <i class="fas fa-cog"></i>
                <span>Pengaturan Sekolah</span>
            </a>
        </div>
    </div>

    <!-- Recent PPDB -->
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h2 style="color: var(--hijau-islam); margin: 0; font-size: 20px;">PPDB Terbaru</h2>
            <a href="{{ route('admin.ppdb.index') }}" style="color: var(--hijau-islam); text-decoration: none; font-weight: 600;">Lihat Semua →</a>
        </div>
        <p style="color: var(--text-light); margin: 0 0 20px 0; font-size: 14px;">Fitur untuk menampilkan data PPDB terbaru akan diupdate di halaman PPDB.</p>
    </div>
</div>

<style>
    .admin-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .stat-card {
        padding: 25px;
        border-radius: 12px;
        color: white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.2);
    }

    .quick-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        padding: 20px;
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(31, 127, 95, 0.3);
    }

    .quick-action-btn i {
        font-size: 28px;
    }
</style>
@endsection
