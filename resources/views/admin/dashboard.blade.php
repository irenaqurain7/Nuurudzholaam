@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    $adminName = auth()->user()->name ?? 'Admin';
    $adminEmail = auth()->user()->email ?? '-';
    $adminInitial = strtoupper(substr($adminName, 0, 1));
@endphp

<div class="admin-dashboard-shell">
    <section class="admin-hero">
        <div class="admin-hero-copy">
            <p class="admin-hero-kicker">Panel Admin Sekolah Islam Nuurudzholaam</p>
            <h1>Dashboard admin yang rapi, modern, dan mudah dipakai.</h1>
            <p class="admin-hero-subtitle">
                Pantau PPDB, program, kegiatan, dan pengumuman dari satu tempat.
            </p>

            <div class="admin-hero-actions">
                <a href="{{ route('admin.ppdb.index') }}" class="admin-hero-btn primary">
                    <i class="fas fa-file-invoice"></i>
                    Kelola PPDB
                </a>
                <a href="{{ route('home') }}" class="admin-hero-btn ghost" target="_blank" rel="noopener">
                    <i class="fas fa-globe"></i>
                    Buka Website
                </a>
            </div>
        </div>

        <div class="admin-hero-card">
            <div class="admin-hero-card-header">
                <div>
                    <span class="admin-status-pill">Aktif</span>
                    <h2>{{ $adminName }}</h2>
                    <p>{{ $adminEmail }}</p>
                </div>
                <div class="admin-avatar">{{ $adminInitial }}</div>
            </div>

            <div class="admin-hero-metrics">
                <div>
                    <span>Total PPDB</span>
                    <strong>{{ $totalPPDB ?? 0 }}</strong>
                </div>
                <div>
                    <span>Pending</span>
                    <strong>{{ $ppdbBaru ?? 0 }}</strong>
                </div>
                <div>
                    <span>Program Aktif</span>
                    <strong>{{ $totalProgram ?? 0 }}</strong>
                </div>
                <div>
                    <span>Kegiatan</span>
                    <strong>{{ $totalKegiatan ?? 0 }}</strong>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-stat-grid">
        <article class="admin-stat-card blue">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <p>Total PPDB</p>
                <h3>{{ $totalPPDB ?? 0 }}</h3>
                <span>Seluruh pendaftar</span>
            </div>
        </article>

        <article class="admin-stat-card amber">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div>
                <p>Menunggu Review</p>
                <h3>{{ $ppdbBaru ?? 0 }}</h3>
                <span>Perlu ditindaklanjuti</span>
            </div>
        </article>

        <article class="admin-stat-card green">
            <div class="stat-icon"><i class="fas fa-book-open"></i></div>
            <div>
                <p>Program</p>
                <h3>{{ $totalProgram ?? 0 }}</h3>
                <span>Program aktif</span>
            </div>
        </article>

        <article class="admin-stat-card cyan">
            <div class="stat-icon"><i class="fas fa-calendar-days"></i></div>
            <div>
                <p>Kegiatan</p>
                <h3>{{ $totalKegiatan ?? 0 }}</h3>
                <span>Data kegiatan</span>
            </div>
        </article>
    </section>

    <section class="admin-content-grid">
        <div class="admin-panel">
            <div class="panel-header">
                <div>
                    <p class="panel-kicker">Akses cepat</p>
                    <h2>Menu Utama</h2>
                </div>
            </div>

            <div class="quick-grid">
                <a href="{{ route('admin.ppdb.index') }}" class="quick-card">
                    <i class="fas fa-file-invoice"></i>
                    <span>PPDB</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="quick-card">
                    <i class="fas fa-user-group"></i>
                    <span>Users</span>
                </a>
                <a href="{{ route('admin.program.index') }}" class="quick-card">
                    <i class="fas fa-book"></i>
                    <span>Program</span>
                </a>
                <a href="{{ route('admin.activity.index') }}" class="quick-card">
                    <i class="fas fa-calendar-check"></i>
                    <span>Kegiatan</span>
                </a>
                <a href="{{ route('admin.gallery.index') }}" class="quick-card">
                    <i class="fas fa-images"></i>
                    <span>Galeri</span>
                </a>
                <a href="{{ route('admin.announcement.index') }}" class="quick-card">
                    <i class="fas fa-bullhorn"></i>
                    <span>Pengumuman</span>
                </a>
            </div>
        </div>

        <div class="admin-panel">
            <div class="panel-header">
                <div>
                    <p class="panel-kicker">PPDB terbaru</p>
                    <h2>Pendaftar Terakhir</h2>
                </div>
                <a href="{{ route('admin.ppdb.index') }}" class="panel-link">Lihat semua</a>
            </div>

            <div class="table-wrap">
                <table class="admin-table modern">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Program</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestPPDB ?? [] as $ppdb)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $ppdb->nama_lengkap ?? '-' }}</strong></td>
                                <td>{{ $ppdb->email ?? '-' }}</td>
                                <td>{{ ucfirst($ppdb->program ?? '-') }}</td>
                                <td>
                                    <span class="status-badge status-{{ $ppdb->status ?? 'pending' }}">
                                        {{ ucfirst($ppdb->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.ppdb.show', $ppdb->id) }}" class="btn-mini">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">Belum ada data pendaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<style>
    .admin-dashboard-shell {
        display: flex;
        flex-direction: column;
        gap: 24px;
        padding: 28px;
        max-width: 1440px;
    }

    .admin-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(320px, 0.9fr);
        gap: 24px;
        position: relative;
        overflow: hidden;
    }

    .admin-hero::before,
    .admin-hero::after {
        content: '';
        position: absolute;
        border-radius: 999px;
        pointer-events: none;
    }

    .admin-hero::before {
        width: 260px;
        height: 260px;
        right: -80px;
        top: -90px;
        background: rgba(255, 255, 255, 0.14);
    }

    .admin-hero::after {
        width: 140px;
        height: 140px;
        right: 180px;
        bottom: -60px;
        background: rgba(255, 255, 255, 0.08);
    }

    .admin-hero-copy,
    .admin-hero-card,
    .admin-panel {
        background: #ffffff;
        border: 1px solid #e2ece8;
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(28, 45, 37, 0.08);
    }

    .admin-hero-copy {
        padding: 32px;
        background: linear-gradient(135deg, #23352c 0%, #2d4438 45%, #486e5a 100%);
        color: #ffffff;
    }

    .admin-hero-kicker,
    .panel-kicker {
        margin: 0 0 10px;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        font-size: 12px;
        font-weight: 700;
        opacity: 0.82;
    }

    .admin-hero-copy h1 {
        margin: 0;
        font-size: clamp(28px, 3vw, 46px);
        line-height: 1.08;
        max-width: 12ch;
    }

    .admin-hero-subtitle {
        margin: 16px 0 0;
        max-width: 56ch;
        color: rgba(255, 255, 255, 0.82);
        font-size: 15px;
    }

    .admin-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 26px;
    }

    .admin-hero-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        border-radius: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .admin-hero-btn:hover {
        transform: translateY(-1px);
    }

    .admin-hero-btn.primary {
        background: #ffffff;
        color: #1c2d25;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
    }

    .admin-hero-btn.ghost {
        border: 1px solid rgba(255, 255, 255, 0.24);
        color: #ffffff;
        background: rgba(255, 255, 255, 0.06);
    }

    .admin-hero-card {
        padding: 28px;
        background: linear-gradient(180deg, #ffffff 0%, #fbfcfb 100%);
    }

    .admin-hero-card-header {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: flex-start;
    }

    .admin-hero-card-header h2 {
        margin: 10px 0 4px;
        font-size: 22px;
        color: #1c2d25;
    }

    .admin-hero-card-header p {
        margin: 0;
        color: #6c8b7c;
        font-size: 14px;
    }

    .admin-status-pill {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 999px;
        background: #e2ece8;
        color: #2d4438;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .admin-avatar {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        background: linear-gradient(135deg, #2d4438 0%, #486e5a 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .admin-hero-metrics {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-top: 22px;
    }

    .admin-hero-metrics div {
        padding: 14px 16px;
        border-radius: 18px;
        background: #f4f7f5;
        border: 1px solid #e2ece8;
    }

    .admin-hero-metrics span,
    .admin-hero-metrics strong {
        display: block;
    }

    .admin-hero-metrics span {
        color: #6c8b7c;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .admin-hero-metrics strong {
        margin-top: 8px;
        color: #1c2d25;
        font-size: 24px;
        line-height: 1;
    }

    .admin-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .admin-stat-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        border-radius: 22px;
        background: #ffffff;
        border: 1px solid #e2ece8;
        box-shadow: 0 10px 24px rgba(28, 45, 37, 0.06);
    }

    .admin-stat-card p,
    .admin-stat-card span,
    .admin-stat-card h3 {
        margin: 0;
    }

    .admin-stat-card p {
        color: #6c8b7c;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
    }

    .admin-stat-card h3 {
        margin-top: 8px;
        color: #1c2d25;
        font-size: 28px;
        line-height: 1;
    }

    .admin-stat-card span {
        display: block;
        margin-top: 6px;
        color: #8aa092;
        font-size: 13px;
    }

    .stat-icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #ffffff;
        flex-shrink: 0;
    }

    .admin-stat-card.blue .stat-icon { background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%); }
    .admin-stat-card.amber .stat-icon { background: linear-gradient(135deg, #d97706 0%, #fbbf24 100%); }
    .admin-stat-card.green .stat-icon { background: linear-gradient(135deg, #059669 0%, #34d399 100%); }
    .admin-stat-card.cyan .stat-icon { background: linear-gradient(135deg, #0891b2 0%, #22d3ee 100%); }

    .admin-content-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 18px;
    }

    .admin-panel {
        padding: 24px;
    }

    .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .panel-header h2 {
        margin: 0;
        color: #1c2d25;
        font-size: 22px;
    }

    .panel-link {
        color: #2d4438;
        font-weight: 700;
        text-decoration: none;
        font-size: 14px;
    }

    .quick-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .quick-card {
        min-height: 112px;
        border-radius: 20px;
        background: linear-gradient(180deg, #f7faf8 0%, #edf4ef 100%);
        border: 1px solid #dbe7e1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        color: #1c2d25;
        font-weight: 700;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .quick-card:hover {
        transform: translateY(-3px);
        border-color: #2d4438;
        box-shadow: 0 14px 30px rgba(28, 45, 37, 0.1);
    }

    .quick-card i {
        font-size: 28px;
        color: #2d4438;
    }

    .table-wrap {
        overflow-x: auto;
    }

    .admin-table.modern {
        background: transparent;
        box-shadow: none;
        border-radius: 0;
        width: 100%;
        border-collapse: collapse;
    }

    .admin-table.modern thead {
        background: #f4f7f5;
    }

    .admin-table.modern th {
        color: #1c2d25;
        padding: 14px 16px;
        border-bottom: 1px solid #e2ece8;
        text-align: left;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .admin-table.modern td {
        padding: 14px 16px;
        border-bottom: 1px solid #e2ece8;
        color: #1c2d25;
        font-size: 14px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-diterima {
        background: #d1fae5;
        color: #065f46;
    }

    .status-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-mini {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 12px;
        border-radius: 10px;
        background: #2d4438;
        color: #ffffff;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .btn-mini:hover {
        background: #1c2d25;
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 30px 16px !important;
        color: #6c8b7c;
    }

    @media (max-width: 1100px) {
        .admin-hero,
        .admin-content-grid {
            grid-template-columns: 1fr;
        }

        .admin-stat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .quick-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .admin-dashboard-shell {
            padding: 16px;
        }

        .admin-hero-copy,
        .admin-hero-card,
        .admin-panel {
            border-radius: 18px;
            padding: 20px;
        }

        .admin-stat-grid,
        .quick-grid,
        .admin-hero-metrics {
            grid-template-columns: 1fr;
        }

        .admin-hero-card-header,
        .panel-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .admin-hero-actions {
            flex-direction: column;
        }

        .admin-hero-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection
