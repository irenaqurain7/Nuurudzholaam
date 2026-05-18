@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    $adminName = auth()->user()->name ?? 'Admin';
    $adminEmail = auth()->user()->email ?? '-';
    $adminInitial = strtoupper(substr($adminName, 0, 1));
@endphp

<div class="admin-dashboard-shell">
    <section class="admin-hero-card">
        <div class="admin-hero-copy">
            <p class="section-kicker">Dashboard Admin</p>
            <h1>Selamat datang, {{ $adminName }}!</h1>
            <p class="hero-subtitle">
                Kelola PPDB, program, kegiatan, dan pengumuman dari satu tempat dengan tampilan yang lebih rapi dan konsisten.
            </p>

            <!-- actions removed per request -->
        </div>

        <!-- profile card removed per request -->
    </section>

    <section class="admin-stat-grid">
        <article class="admin-stat-card">
            <div class="stat-icon blue"><i class="fas fa-users"></i></div>
            <div>
                <p>Total PPDB</p>
                <h3>{{ $totalPPDB ?? 0 }}</h3>
                <span>Seluruh pendaftar</span>
            </div>
        </article>

        <article class="admin-stat-card">
            <div class="stat-icon amber"><i class="fas fa-clock"></i></div>
            <div>
                <p>Menunggu Review</p>
                <h3>{{ $ppdbBaru ?? 0 }}</h3>
                <span>Perlu ditindaklanjuti</span>
            </div>
        </article>

        <article class="admin-stat-card">
            <div class="stat-icon green"><i class="fas fa-book-open"></i></div>
            <div>
                <p>Program</p>
                <h3>{{ $totalProgram ?? 0 }}</h3>
                <span>Program aktif</span>
            </div>
        </article>

        <article class="admin-stat-card">
            <div class="stat-icon cyan"><i class="fas fa-calendar-days"></i></div>
            <div>
                <p>Kegiatan</p>
                <h3>{{ $totalKegiatan ?? 0 }}</h3>
                <span>Data kegiatan</span>
            </div>
        </article>
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

    .admin-hero-card,
    .admin-panel {
        background: #ffffff;
        border: 1px solid #e2ece8;
        border-radius: 24px;
        box-shadow: 0 18px 40px rgba(28, 45, 37, 0.08);
    }

    .admin-hero-card {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0;
        padding: 28px;
        align-items: center;
        background: linear-gradient(135deg, #23352c 0%, #2d4438 48%, #486e5a 100%);
        border-color: #2f4b3d;
    }

    .admin-hero-copy h1 {
        margin: 8px 0 0;
        font-size: clamp(28px, 3vw, 44px);
        line-height: 1.08;
        color: #ffffff;
    }

    .section-kicker {
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
    }

    .hero-subtitle {
        margin: 16px 0 0;
        max-width: 60ch;
        color: rgba(255, 255, 255, 0.88);
    }

    .admin-hero-card .section-kicker {
        color: rgba(255, 255, 255, 0.82);
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
        padding: 22px;
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid #e2ece8;
        box-shadow: 0 14px 30px rgba(28, 45, 37, 0.06);
    }

    .admin-stat-card p,
    .admin-stat-card span,
    .admin-stat-card h3 {
        margin: 0;
    }

    .admin-stat-card p {
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .admin-stat-card h3 {
        margin-top: 6px;
        font-size: 28px;
        color: var(--text-dark);
    }

    .admin-stat-card span {
        display: block;
        margin-top: 4px;
        color: var(--text-light);
        font-size: 13px;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        color: #ffffff;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-icon.blue { background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%); }
    .stat-icon.amber { background: linear-gradient(135deg, #d97706 0%, #fbbf24 100%); }
    .stat-icon.green { background: linear-gradient(135deg, #059669 0%, #34d399 100%); }
    .stat-icon.cyan { background: linear-gradient(135deg, #0891b2 0%, #22d3ee 100%); }

    @media (max-width: 1200px) {
        .admin-stat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .admin-dashboard-shell {
            padding: 18px;
        }

        .admin-hero-card {
            grid-template-columns: 1fr;
        }

        .admin-stat-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
