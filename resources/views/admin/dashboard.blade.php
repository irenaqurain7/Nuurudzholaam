@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="admin-dashboard">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div>
            <h1>CMS Admin</h1>
            <p class="subtitle">Kelola konten dan informasi institusional Sekolah Islam Nuurudzholaam</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-card-blue">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">PPDB Terdaftar</p>
                <h3 class="stat-value">{{ $totalPPDB ?? 42 }}</h3>
            </div>
        </div>

        <div class="stat-card stat-card-orange">
            <div class="stat-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">Pending Review</p>
                <h3 class="stat-value">{{ $ppdbBaru ?? 2 }}</h3>
            </div>
        </div>

        <div class="stat-card stat-card-cyan">
            <div class="stat-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">Dokumen Aktif</p>
                <h3 class="stat-value">{{ $totalProgram ?? 8 }}</h3>
            </div>
        </div>

        <div class="stat-card stat-card-green">
            <div class="stat-icon">
                <i class="fas fa-image"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">File di Galeri</p>
                <h3 class="stat-value">{{ $totalKegiatan ?? 156 }}</h3>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-content-grid">
        <!-- Quick Access Folders Section -->
        <div class="section quick-access-section">
            <h2 class="section-title">
                <i class="fas fa-folder"></i> Akses Cepat Folder
            </h2>
            <div class="quick-access-grid">
                <a href="{{ route('admin.ppdb.index') }}" class="quick-folder">
                    <div class="folder-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-list-check"></i>
                    </div>
                    <div class="folder-info">
                        <p class="folder-name">Data PPDB</p>
                        <p class="folder-meta">{{ $totalPPDB ?? 42 }} File • 324 KB</p>
                    </div>
                </a>

                <a href="{{ route('admin.activity.index') }}" class="quick-folder">
                    <div class="folder-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-calendar-days"></i>
                    </div>
                    <div class="folder-info">
                        <p class="folder-name">Kegiatan</p>
                        <p class="folder-meta">12 Item • 854 KB</p>
                    </div>
                </a>

                <a href="{{ route('admin.gallery.index') }}" class="quick-folder">
                    <div class="folder-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="folder-info">
                        <p class="folder-name">Galeri Foto</p>
                        <p class="folder-meta">156 File • 2.5 MB</p>
                    </div>
                </a>

                <a href="{{ route('admin.program.index') }}" class="quick-folder">
                    <div class="folder-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="folder-info">
                        <p class="folder-name">Program</p>
                        <p class="folder-meta">8 File • 128 KB</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="two-column-grid">
            <!-- Live Announcements -->
            <div class="section announcements-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-bullhorn"></i> Pengumuman Live
                    </h2>
                    <a href="{{ route('admin.announcement.index') }}" class="view-all-link">Lihat Semua</a>
                </div>

                <div class="announcements-list">
                    <div class="announcement-item" style="border-left: 4px solid #28a745;">
                        <div class="announcement-badge announcement-badge-success">PENTING</div>
                        <p class="announcement-text">Pendaftaran untuk Angkatan 2024/2025 telah dibuka!</p>
                        <p class="announcement-date">Oct 30, 2024 • 10:30 AM</p>
                    </div>

                    <div class="announcement-item" style="border-left: 4px solid #f39c12;">
                        <div class="announcement-badge announcement-badge-warning">INFO</div>
                        <p class="announcement-text">Libur sekolah dimulai pada tanggal 15 Desember</p>
                        <p class="announcement-date">Oct 25, 2024 • 2:00 PM</p>
                    </div>

                    <div class="announcement-item" style="border-left: 4px solid #3498db;">
                        <div class="announcement-badge announcement-badge-info">UMUM</div>
                        <p class="announcement-text">Perbaikan fasilitasGiliran: Updated di Lapangan Olahraga</p>
                        <p class="announcement-date">Oct 15, 2024 • 9:15 AM</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="section recent-activity-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-history"></i> Aktivitas Terbaru
                    </h2>
                    <a href="#" class="view-all-link">Lihat Semua</a>
                </div>

                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon" style="background: #e8f4f8; color: #3498db;">
                            <i class="fas fa-file-upload"></i>
                        </div>
                        <div class="activity-info">
                            <p class="activity-title">Dokumen di-upload</p>
                            <p class="activity-description">Brosur_2024_Nuurudzholaam.pdf</p>
                            <p class="activity-time">3 jam lalu</p>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon" style="background: #f0e8f4; color: #9b59b6;">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="activity-info">
                            <p class="activity-title">Pengumuman di-update</p>
                            <p class="activity-description">Registrasi Angkatan 2024/2025 dibuka</p>
                            <p class="activity-time">5 jam lalu</p>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon" style="background: #f0f8e8; color: #27ae60;">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="activity-info">
                            <p class="activity-title">PPDB baru terdaftar</p>
                            <p class="activity-description">Registrasi dari Ahmad Rifandi</p>
                            <p class="activity-time">1 hari lalu</p>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon" style="background: #fef5e7; color: #f39c12;">
                            <i class="fas fa-images"></i>
                        </div>
                        <div class="activity-info">
                            <p class="activity-title">Foto ditambahkan</p>
                            <p class="activity-description">Dokumentasi Acara Pembukaan Tahun Ajaran</p>
                            <p class="activity-time">2 hari lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Bottom -->
    <div class="section quick-actions-bottom">
        <h2 class="section-title">
            <i class="fas fa-zap"></i> Tindakan Cepat
        </h2>
        <div class="actions-grid">
            <a href="{{ route('admin.announcement.index') }}" class="action-btn">
                <i class="fas fa-bell"></i>
                <span>Kelola Pengumuman</span>
            </a>
            <a href="{{ route('admin.school-info.edit') }}" class="action-btn">
                <i class="fas fa-cog"></i>
                <span>Pengaturan Sekolah</span>
            </a>
            <a href="{{ route('admin.faq.index') }}" class="action-btn">
                <i class="fas fa-question-circle"></i>
                <span>Kelola FAQ</span>
            </a>
            <a href="{{ route('admin.activity.index') }}" class="action-btn">
                <i class="fas fa-plus-circle"></i>
                <span>Buat Kegiatan Baru</span>
            </a>
        </div>
    </div>
</div>

<style>
    .admin-dashboard {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* Header */
    .dashboard-header {
        margin-bottom: 40px;
    }

    .dashboard-header h1 {
        color: var(--hijau-islam);
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 10px 0;
    }

    .dashboard-header .subtitle {
        color: var(--text-light);
        font-size: 16px;
        margin: 0;
    }

    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        border-top: 4px solid;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .stat-card-blue {
        border-top-color: #667eea;
    }

    .stat-card-orange {
        border-top-color: #f39c12;
    }

    .stat-card-cyan {
        border-top-color: #00bcd4;
    }

    .stat-card-green {
        border-top-color: #27ae60;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        flex-shrink: 0;
    }

    .stat-card-blue .stat-icon {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .stat-card-orange .stat-icon {
        background: rgba(243, 156, 18, 0.1);
        color: #f39c12;
    }

    .stat-card-cyan .stat-icon {
        background: rgba(0, 188, 212, 0.1);
        color: #00bcd4;
    }

    .stat-card-green .stat-icon {
        background: rgba(39, 174, 96, 0.1);
        color: #27ae60;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        color: var(--text-light);
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 8px 0;
    }

    .stat-value {
        color: var(--text-dark);
        font-size: 28px;
        font-weight: 700;
        margin: 0;
    }

    /* Dashboard Content Grid */
    .dashboard-content-grid {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    /* Sections */
    .section {
        background: white;
        padding: 28px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .section-title {
        color: var(--hijau-islam);
        font-size: 18px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        font-size: 20px;
    }

    .view-all-link {
        color: var(--hijau-islam);
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
    }

    .view-all-link:hover {
        color: var(--hijau-islam-light);
    }

    /* Quick Access Folders */
    .quick-access-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }

    .quick-folder {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        border-radius: 10px;
        background: #f7fafc;
        text-decoration: none;
        transition: all 0.3s;
        border: 1px solid #e2e8f0;
    }

    .quick-folder:hover {
        background: #f0f4f8;
        transform: translateX(5px);
        border-color: #d0d8e8;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .folder-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
        flex-shrink: 0;
    }

    .folder-info {
        flex: 1;
    }

    .folder-name {
        color: var(--text-dark);
        font-weight: 600;
        font-size: 14px;
        margin: 0 0 5px 0;
    }

    .folder-meta {
        color: var(--text-light);
        font-size: 12px;
        margin: 0;
    }

    /* Two Column Layout */
    .two-column-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    @media (max-width: 1024px) {
        .two-column-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Announcements Section */
    .announcements-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .announcement-item {
        padding: 16px;
        background: #f7fafc;
        border-radius: 8px;
        border-left: 4px solid;
        transition: all 0.3s;
    }

    .announcement-item:hover {
        background: #eef2f7;
        transform: translateX(4px);
    }

    .announcement-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .announcement-badge-success {
        background: #d4edda;
        color: #155724;
    }

    .announcement-badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .announcement-badge-info {
        background: #d1ecf1;
        color: #0c5460;
    }

    .announcement-text {
        color: var(--text-dark);
        font-weight: 600;
        font-size: 14px;
        margin: 0 0 8px 0;
    }

    .announcement-date {
        color: var(--text-light);
        font-size: 12px;
        margin: 0;
    }

    /* Recent Activity Section */
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 12px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .activity-info {
        flex: 1;
    }

    .activity-title {
        color: var(--text-dark);
        font-weight: 600;
        font-size: 14px;
        margin: 0 0 4px 0;
    }

    .activity-description {
        color: var(--text-light);
        font-size: 13px;
        margin: 0 0 4px 0;
    }

    .activity-time {
        color: #95a5a6;
        font-size: 12px;
        margin: 0;
    }

    /* Quick Actions Bottom */
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
    }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 20px;
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
        font-size: 14px;
    }

    .action-btn i {
        font-size: 24px;
    }

    .action-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(31, 127, 95, 0.3);
    }

    @media (max-width: 768px) {
        .admin-dashboard {
            padding: 20px 15px;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }

        .quick-access-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-header h1 {
            font-size: 24px;
        }
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
