@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    $adminName = auth()->user()->name ?? 'Admin';
    $adminInitial = strtoupper(substr($adminName, 0, 1));
@endphp

<div class="admin-dashboard-shell">
    <!-- Hero Card -->
    <section class="admin-hero-card">
        <div class="admin-hero-copy">
            <p class="section-kicker">Dashboard Hub</p>
            <h1>Selamat datang kembali, {{ $adminName }}!</h1>
            <p class="hero-subtitle">
                Akses cepat ke statistik pendaftaran, jadwal, pengumuman, dan pintasan administrasi utama Anda.
            </p>
        </div>
        <div class="admin-hero-icon-wrapper">
            <span class="admin-hero-avatar">{{ $adminInitial }}</span>
        </div>
    </section>

    <!-- Statistik Utama -->
    <section class="admin-stat-grid">
        <article class="admin-stat-card">
            <div class="stat-icon-wrapper blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">Total User</p>
                <h3 class="stat-value">{{ $totalUsers }}</h3>
                <span class="stat-meta">Seluruh akun terdaftar</span>
            </div>
        </article>

        <article class="admin-stat-card">
            <div class="stat-icon-wrapper green">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">Total Siswa</p>
                <h3 class="stat-value">{{ $totalSiswa }}</h3>
                <span class="stat-meta">Siswa aktif</span>
            </div>
        </article>

        <article class="admin-stat-card">
            <div class="stat-icon-wrapper purple">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">Total Guru</p>
                <h3 class="stat-value">{{ $totalGuru }}</h3>
                <span class="stat-meta">Tenaga pengajar</span>
            </div>
        </article>

        <article class="admin-stat-card">
            <div class="stat-icon-wrapper amber">
                <i class="fas fa-file-signature"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">Pendaftar PPDB</p>
                <h3 class="stat-value">{{ $totalPPDB }}</h3>
                <span class="stat-meta">Seluruh jenjang</span>
            </div>
        </article>
    </section>

    <!-- Jenjang & Progress/Jadwal Row -->
    <div class="dashboard-double-row">
        <!-- PPDB Per Jenjang Card -->
        <div class="dashboard-card card-half">
            <div class="card-header">
                <h4><i class="fas fa-chart-pie mr-2"></i> Pendaftar per Jenjang</h4>
                <span class="header-badge">PPDB</span>
            </div>
            <div class="jenjang-grid">
                <div class="jenjang-item tk">
                    <span class="jenjang-label">TK</span>
                    <span class="jenjang-count">{{ $ppdbTK }}</span>
                    <span class="jenjang-sub">Pendaftar</span>
                </div>
                <div class="jenjang-item sd">
                    <span class="jenjang-label">SD</span>
                    <span class="jenjang-count">{{ $ppdbSD }}</span>
                    <span class="jenjang-sub">Pendaftar</span>
                </div>
                <div class="jenjang-item smp">
                    <span class="jenjang-label">SMP</span>
                    <span class="jenjang-count">{{ $ppdbSMP }}</span>
                    <span class="jenjang-sub">Pendaftar</span>
                </div>
                <div class="jenjang-item smk">
                    <span class="jenjang-label">SMK</span>
                    <span class="jenjang-count">{{ $ppdbSMK }}</span>
                    <span class="jenjang-sub">Pendaftar</span>
                </div>
            </div>
        </div>

        <!-- PPDB Progress & Jadwal Hari Ini Card -->
        <div class="dashboard-card card-half">
            <div class="card-header">
                <h4><i class="fas fa-sync-alt mr-2"></i> Monitor Harian & Progress</h4>
                <span class="header-badge bg-emerald-500">Live</span>
            </div>
            <div class="split-card-body">
                <div class="split-section">
                    <p class="split-title">Progress PPDB</p>
                    <div class="progress-stats">
                        <div class="prog-item pending">
                            <span class="prog-dot"></span>
                            <span class="prog-label">Menunggu</span>
                            <strong class="prog-val">{{ $ppdbPending }}</strong>
                        </div>
                        <div class="prog-item approved">
                            <span class="prog-dot"></span>
                            <span class="prog-label">Diterima</span>
                            <strong class="prog-val">{{ $ppdbApproved }}</strong>
                        </div>
                        <div class="prog-item rejected">
                            <span class="prog-dot"></span>
                            <span class="prog-label">Ditolak</span>
                            <strong class="prog-val">{{ $ppdbRejected }}</strong>
                        </div>
                    </div>
                </div>
                <div class="split-divider"></div>
                <div class="split-section">
                    <p class="split-title">Jadwal Hari Ini</p>
                    <div class="today-schedules">
                        <div class="sched-pill">
                            <div class="sched-icon bg-indigo-100 text-indigo-800">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="sched-info">
                                <strong>{{ $todayTeacherSchedule }}</strong>
                                <span>Jadwal Guru</span>
                            </div>
                        </div>
                        <div class="sched-pill">
                            <div class="sched-icon bg-rose-100 text-rose-800">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <div class="sched-info">
                                <strong>{{ $todayStudentSchedule }}</strong>
                                <span>Jadwal Siswa</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendaftaran Terbaru & Aktivitas/Pengumuman -->
    <div class="dashboard-split-layout">
        <!-- Pendaftaran Terbaru -->
        <div class="dashboard-card main-col">
            <div class="card-header flex-between">
                <h4><i class="fas fa-list-ul mr-2"></i> Pendaftaran Terbaru</h4>
                <a href="{{ route('admin.ppdb.index') }}" class="btn-text">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
            <div class="table-responsive">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jenjang</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestRegistrations as $reg)
                            <tr>
                                <td class="font-bold text-dark">{{ $reg->nama_lengkap }}</td>
                                <td>
                                    <span class="badge badge-level {{ strtolower($reg->jenjang) }}">
                                        {{ strtoupper($reg->jenjang) }}
                                    </span>
                                </td>
                                <td>{{ $reg->tgl_daftar ? $reg->tgl_daftar->format('d M Y') : ($reg->created_at ? $reg->created_at->format('d M Y') : '-') }}</td>
                                <td>
                                    @if($reg->status === 'pending')
                                        <span class="badge-status pending">Menunggu</span>
                                    @elseif($reg->status === 'approved')
                                        <span class="badge-status approved">Diterima</span>
                                    @else
                                        <span class="badge-status rejected">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="fas fa-user-clock" style="font-size: 24px;"></i>
                                    <p>Belum ada pendaftaran terbaru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Side: Aktivitas Terbaru & Pengumuman -->
        <div class="dashboard-card side-col">
            <!-- Aktivitas Terbaru -->
            <div class="activities-section mb-6">
                <div class="card-header mb-3">
                    <h4><i class="fas fa-history mr-2"></i> Aktivitas Terbaru</h4>
                </div>
                <ul class="activity-timeline">
                    @forelse($recentActivities as $act)
                        <li class="activity-item">
                            <span class="activity-icon-container {{ $act['color'] }}">
                                <i class="{{ $act['icon'] }}"></i>
                            </span>
                            <div class="activity-body">
                                <p class="activity-text">{!! $act['message'] !!}</p>
                                <span class="activity-time">{{ $act['time']->diffForHumans() }}</span>
                            </div>
                        </li>
                    @empty
                        <li class="empty-state py-4">
                            <i class="fas fa-tasks text-muted"></i>
                            <p class="text-sm mt-1">Belum ada aktivitas terekam.</p>
                        </li>
                    @endforelse
                </ul>
            </div>

            <hr class="section-divider my-4" />

            <!-- Pengumuman Terbaru -->
            <div class="announcements-section">
                <div class="card-header mb-3 flex-between">
                    <h4><i class="fas fa-bullhorn mr-2"></i> Pengumuman Terbaru</h4>
                    <a href="{{ route('admin.announcement.index') }}" class="btn-text">Kelola</a>
                </div>
                <div class="announcement-list">
                    @forelse($latestAnnouncements as $ann)
                        <div class="announcement-pill">
                            <div class="ann-header">
                                <span class="ann-title">{{ $ann->judul }}</span>
                                <span class="ann-date">{{ $ann->created_at->format('d M Y') }}</span>
                            </div>
                            <p class="ann-excerpt">
                                {{ Str::limit(strip_tags($ann->konten), 80) }}
                            </p>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-comment-slash" style="font-size: 24px;"></i>
                            <p>Belum ada pengumuman.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <section class="quick-actions-section">
        <h4 class="section-title"><i class="fas fa-bolt mr-2 text-amber-500"></i> Pintasan Cepat</h4>
        <div class="quick-actions-grid">
            <a href="{{ route('admin.users.create') }}" class="action-btn-card">
                <div class="action-icon bg-emerald-50 text-emerald-700">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="action-details">
                    <h5>Tambah User</h5>
                    <p>Registrasikan guru atau siswa baru</p>
                </div>
                <i class="fas fa-chevron-right action-arrow"></i>
            </a>

            <a href="{{ route('admin.schedule.student.wizard.step1') }}" class="action-btn-card">
                <div class="action-icon bg-blue-50 text-blue-700">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <div class="action-details">
                    <h5>Tambah Jadwal</h5>
                    <p>Buat jadwal kelas melalui wizard</p>
                </div>
                <i class="fas fa-chevron-right action-arrow"></i>
            </a>

            <a href="{{ route('admin.announcement.create') }}" class="action-btn-card">
                <div class="action-icon bg-purple-50 text-purple-700">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="action-details">
                    <h5>Tambah Pengumuman</h5>
                    <p>Publikasikan info penting sekolah</p>
                </div>
                <i class="fas fa-chevron-right action-arrow"></i>
            </a>

            <a href="{{ route('admin.ppdb.settings') }}" class="action-btn-card">
                <div class="action-icon bg-amber-50 text-amber-700">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <div class="action-details">
                    <h5>Buka PPDB</h5>
                    <p>Konfigurasi status pembukaan pendaftaran</p>
                </div>
                <i class="fas fa-chevron-right action-arrow"></i>
            </a>
        </div>
    </section>
</div>

<style>
    :root {
        --primary-green: #2d4438;
        --secondary-green: #3f604e;
        --light-green: #eaf1ed;
        --accent-green: #10b981;
        --card-bg: #ffffff;
        --border-color: #e5e7eb;
        --text-dark: #1f2937;
        --text-light: #6b7280;
    }

    .admin-dashboard-shell {
        display: flex;
        flex-direction: column;
        gap: 24px;
        padding: 28px;
        max-width: 1440px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* Hero Card */
    .admin-hero-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 32px;
        background: linear-gradient(135deg, #1e2e26 0%, #2d4438 100%);
        border-radius: 24px;
        color: #ffffff;
        box-shadow: 0 20px 40px rgba(45, 68, 56, 0.15);
        border: 1px solid #375344;
        position: relative;
        overflow: hidden;
    }

    .admin-hero-card::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        top: -100px;
        right: -100px;
        pointer-events: none;
    }

    .admin-hero-copy h1 {
        margin: 6px 0 0;
        font-size: clamp(24px, 2.5vw, 36px);
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .hero-subtitle {
        margin-top: 12px;
        max-width: 65ch;
        color: rgba(255, 255, 255, 0.8);
        font-size: 15px;
        line-height: 1.6;
    }

    .admin-hero-icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .admin-hero-avatar {
        font-size: 32px;
        font-weight: 800;
        color: #ffffff;
    }

    /* Stat Grid */
    .admin-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .admin-stat-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03);
        transition: transform 0.25s, box-shadow 0.25s;
    }

    .admin-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(45, 68, 56, 0.08);
        border-color: #cbdad2;
    }

    .stat-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .stat-icon-wrapper.blue { background-color: #eff6ff; color: #3b82f6; }
    .stat-icon-wrapper.green { background-color: #ecfdf5; color: #10b981; }
    .stat-icon-wrapper.purple { background-color: #faf5ff; color: #a855f7; }
    .stat-icon-wrapper.amber { background-color: #fffbeb; color: #f59e0b; }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-light);
        letter-spacing: 0.05em;
        margin: 0;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: var(--text-dark);
        margin: 4px 0 2px;
        letter-spacing: -0.03em;
    }

    .stat-meta {
        font-size: 12px;
        color: var(--text-light);
    }

    /* Double Column Rows */
    .dashboard-double-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .dashboard-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        padding: 28px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.02);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f3f4f6;
        padding-bottom: 16px;
        margin-bottom: 20px;
    }

    .card-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
    }

    .header-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        background-color: var(--light-green);
        color: var(--primary-green);
        text-transform: uppercase;
    }

    /* Jenjang Grid */
    .jenjang-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .jenjang-item {
        border-radius: 16px;
        padding: 20px 16px;
        text-align: center;
        display: flex;
        flex-direction: column;
        gap: 6px;
        transition: transform 0.2s;
        border: 1px solid transparent;
    }

    .jenjang-item:hover {
        transform: translateY(-2px);
    }

    .jenjang-item.tk { background-color: #fef2f2; color: #dc2626; border-color: #fee2e2; }
    .jenjang-item.sd { background-color: #f0fdf4; color: #16a34a; border-color: #dcfce7; }
    .jenjang-item.smp { background-color: #eff6ff; color: #2563eb; border-color: #dbeafe; }
    .jenjang-item.smk { background-color: #faf5ff; color: #7c3aed; border-color: #f3e8ff; }

    .jenjang-label {
        font-weight: 800;
        font-size: 18px;
    }

    .jenjang-count {
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .jenjang-sub {
        font-size: 11px;
        opacity: 0.8;
        font-weight: 500;
    }

    /* Monitor Split */
    .split-card-body {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 24px;
        align-items: center;
    }

    .split-divider {
        width: 1px;
        height: 100px;
        background-color: #e5e7eb;
    }

    .split-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-light);
        letter-spacing: 0.05em;
        margin-bottom: 12px;
    }

    /* Progress PPDB */
    .progress-stats {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .prog-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    .prog-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .prog-item.pending .prog-dot { background-color: #f59e0b; }
    .prog-item.approved .prog-dot { background-color: #10b981; }
    .prog-item.rejected .prog-dot { background-color: #ef4444; }

    .prog-label {
        color: var(--text-light);
        flex-grow: 1;
    }

    .prog-val {
        color: var(--text-dark);
        font-weight: 700;
    }

    /* Today schedules */
    .today-schedules {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .sched-pill {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 12px;
        border-radius: 12px;
        background-color: #f9fafb;
        border: 1px solid #f3f4f6;
    }

    .sched-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .sched-info {
        display: flex;
        flex-direction: column;
    }

    .sched-info strong {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1.2;
    }

    .sched-info span {
        font-size: 11px;
        color: var(--text-light);
    }

    /* Split layout: Recent Registrations vs Feed */
    .dashboard-split-layout {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 24px;
    }

    .flex-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-text {
        font-size: 14px;
        font-weight: 700;
        color: var(--accent-green);
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: color 0.2s;
    }

    .btn-text:hover {
        color: var(--primary-green);
    }

    /* Table styles */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .dashboard-table th {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-light);
        padding: 12px 16px;
        border-bottom: 2px solid #f3f4f6;
        letter-spacing: 0.05em;
    }

    .dashboard-table td {
        padding: 16px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
    }

    .dashboard-table tr:last-child td {
        border-bottom: none;
    }

    .font-bold {
        font-weight: 700;
    }

    /* Badges */
    .badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 6px;
    }

    .badge-level.tk { background-color: #fee2e2; color: #ef4444; }
    .badge-level.sd { background-color: #dcfce7; color: #10b981; }
    .badge-level.smp { background-color: #dbeafe; color: #3b82f6; }
    .badge-level.smk { background-color: #f3e8ff; color: #8b5cf6; }

    .badge-status {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 6px;
        display: inline-block;
    }

    .badge-status.pending { background-color: #fef3c7; color: #d97706; }
    .badge-status.approved { background-color: #d1fae5; color: #065f46; }
    .badge-status.rejected { background-color: #fee2e2; color: #991b1b; }

    /* Timeline style */
    .activity-timeline {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .activity-item {
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }

    .activity-icon-container {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
        border: 1px solid transparent;
    }

    .activity-body {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .activity-text {
        font-size: 13.5px;
        margin: 0;
        color: var(--text-dark);
        line-height: 1.4;
    }

    .activity-text strong {
        color: #111827;
    }

    .activity-time {
        font-size: 11px;
        color: var(--text-light);
    }

    /* Announcement List */
    .announcement-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .announcement-pill {
        background-color: #f9fafb;
        border: 1px solid #f3f4f6;
        border-radius: 12px;
        padding: 12px 16px;
        transition: border-color 0.2s;
    }

    .announcement-pill:hover {
        border-color: #d1d5db;
    }

    .ann-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: 10px;
        margin-bottom: 6px;
    }

    .ann-title {
        font-weight: 700;
        font-size: 14px;
        color: var(--text-dark);
    }

    .ann-date {
        font-size: 11px;
        color: var(--text-light);
        flex-shrink: 0;
    }

    .ann-excerpt {
        font-size: 12.5px;
        color: var(--text-light);
        margin: 0;
        line-height: 1.4;
    }

    .section-divider {
        border: 0;
        border-top: 1px solid #f3f4f6;
    }

    /* Quick Actions */
    .quick-actions-section {
        margin-top: 8px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 16px;
        display: flex;
        align-items: center;
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .action-btn-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
        transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
        position: relative;
    }

    .action-btn-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(45, 68, 56, 0.05);
        border-color: var(--accent-green);
    }

    .action-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .action-details {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        overflow: hidden;
    }

    .action-details h5 {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .action-details p {
        margin: 2px 0 0;
        font-size: 11px;
        color: var(--text-light);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .action-arrow {
        color: #d1d5db;
        font-size: 12px;
        transition: transform 0.2s, color 0.2s;
    }

    .action-btn-card:hover .action-arrow {
        color: var(--accent-green);
        transform: translateX(2px);
    }

    /* Empty states */
    .empty-state {
        text-align: center;
        padding: 24px;
        color: var(--text-light);
    }

    .empty-state i {
        font-size: 24px;
        color: #cbd5e1;
    }

    .empty-state p {
        margin: 8px 0 0;
        font-size: 13px;
    }

    /* Responsive styling */
    @media (max-width: 1200px) {
        .admin-stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .quick-actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .dashboard-double-row {
            grid-template-columns: 1fr;
        }

        .dashboard-split-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .admin-dashboard-shell {
            padding: 16px;
        }

        .admin-hero-card {
            padding: 24px;
        }

        .admin-hero-icon-wrapper {
            display: none;
        }

        .split-card-body {
            grid-template-columns: 1fr;
        }

        .split-divider {
            width: 100%;
            height: 1px;
        }

        .admin-stat-grid {
            grid-template-columns: 1fr;
        }

        .quick-actions-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
