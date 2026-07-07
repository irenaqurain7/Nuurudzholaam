@extends('student.layout')

@section('student-content')
<style>
    :root {
        --primary: #2d5016;
        --text-primary: #1a1a1a;
        --text-secondary: #666;
        --text-muted: #999;
        --border: #e5e5e5;
        --bg-light: #f9f9f9;
        --blue: #3498db;
        --green: #2ecc71;
        --purple: #9b59b6;
        --red: #e74c3c;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, var(--primary) 0%, #3d6b1f 100%);
        color: white;
        padding: 2rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .hero-section h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .hero-section p {
        font-size: 0.95rem;
        opacity: 0.95;
        margin: 0;
        line-height: 1.6;
    }

    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .schedule-preview {
        background: white;
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04);
    }

    .schedule-preview-header {
        padding: 1.1rem 1.25rem;
        background: linear-gradient(135deg, rgba(45, 80, 22, 0.08), rgba(61, 107, 31, 0.16));
        border-bottom: 1px solid rgba(45, 80, 22, 0.08);
        display: flex;
        justify-content: space-between;
        gap: 0.75rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .schedule-preview-header h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .schedule-preview-header span {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    .schedule-preview-body {
        padding: 1.25rem;
    }

    .schedule-table {
        width: 100%;
        border-collapse: collapse;
    }

    .schedule-table th,
    .schedule-table td {
        text-align: left;
        padding: 0.85rem 0.9rem;
        border-bottom: 1px solid var(--border);
        vertical-align: top;
        font-size: 0.93rem;
    }

    .schedule-table th {
        color: var(--text-secondary);
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        font-weight: 700;
    }

    .schedule-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .schedule-table td:first-child {
        width: 72px;
        font-weight: 700;
        color: var(--primary);
    }

    .schedule-empty {
        padding: 1.25rem;
        text-align: center;
        color: var(--text-secondary);
        font-size: 0.95rem;
        background: #fafbfa;
        border: 1px dashed var(--border);
        border-radius: 12px;
    }

    .dashboard-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.25rem;
        transition: all 0.3s ease;
        border-left: 3px solid var(--primary);
        cursor: pointer;
    }

    .dashboard-card:hover {
        border-color: var(--primary);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transform: translateY(-1px);
    }

    .dashboard-card.blue { border-left-color: var(--blue); }
    .dashboard-card.green { border-left-color: var(--green); }
    .dashboard-card.purple { border-left-color: var(--purple); }
    .dashboard-card.red { border-left-color: var(--red); }

    .dashboard-card h6 {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 0.75rem;
    }

    .dashboard-card-icon {
        font-size: 1.75rem;
        margin-bottom: 0.75rem;
        display: block;
    }

    .dashboard-card.blue .dashboard-card-icon { color: var(--blue); }
    .dashboard-card.green .dashboard-card-icon { color: var(--green); }
    .dashboard-card.purple .dashboard-card-icon { color: var(--purple); }
    .dashboard-card.red .dashboard-card-icon { color: var(--red); }

    .dashboard-card.is-schedule {
        cursor: default;
    }

    .dashboard-card.is-schedule:hover {
        border-color: var(--border);
        box-shadow: none;
        transform: none;
    }

    .dashboard-card a {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        color: var(--primary);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        margin-top: 0.5rem;
        transition: all 0.2s;
    }

    .dashboard-card a:hover {
        gap: 0.6rem;
        color: #1f3a0f;
    }

    /* Info Card */
    .info-section {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
    }

    .info-header {
        background: linear-gradient(135deg, var(--primary) 0%, #3d6b1f 100%);
        color: white;
        padding: 1.25rem;
    }

    .info-header h5 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
    }

    .info-body {
        padding: 1.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .info-grid:last-of-type {
        margin-bottom: 0;
    }

    .info-item {
        padding-bottom: 0;
    }

    .info-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 0.4rem;
    }

    .info-value {
        display: block;
        font-size: 0.95rem;
        color: var(--text-primary);
        font-weight: 500;
    }

    .btn-edit {
        background-color: var(--primary);
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }

    .btn-edit:hover {
        background-color: #1f3a0f;
        color: white;
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
            gap: 0.8rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .hero-section {
            padding: 1.5rem;
        }

        .hero-section h1 {
            font-size: 1.5rem;
        }

        .info-body {
            padding: 1.25rem;
        }
    }
</style>

<!-- Hero Section -->
<div class="hero-section">
    <h1>Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
    <p>Kelola data akademik dan profil Anda dengan mudah melalui dashboard ini.</p>
</div>

<!-- Dashboard Cards -->
<div class="dashboard-grid">
    <div class="dashboard-card blue is-schedule">
        <h6>Jadwal Sekolah Hari Ini</h6>
        <i class="fas fa-calendar-alt dashboard-card-icon"></i>
        <div style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5;">
            {{ $todayLabel ?? 'Hari ini' }}
        </div>
    </div>

    <div class="dashboard-card purple">
        <h6>Data Saya</h6>
        <i class="fas fa-user dashboard-card-icon"></i>
        <a href="{{ route('student.profile') }}">
            <span>Lihat Data</span>
            <i class="fas fa-arrow-right" style="font-size: 0.7rem;"></i>
        </a>
    </div>

    <div class="dashboard-card red">
        <h6>Keamanan</h6>
        <i class="fas fa-lock dashboard-card-icon"></i>
        <a href="{{ route('student.change-password') }}">
            <span>Ubah Password</span>
            <i class="fas fa-arrow-right" style="font-size: 0.7rem;"></i>
        </a>
    </div>
</div>

<!-- Schedule Preview -->
<div class="schedule-preview">
    <div class="schedule-preview-header">
        <h5>Preview Jadwal Pelajaran Hari Ini</h5>
        <span>{{ $todayLabel ?? 'Hari ini' }}</span>
    </div>
    <div class="schedule-preview-body">
        @if(($todayScheduleItems ?? collect())->isNotEmpty())
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelajaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($todayScheduleItems as $index => $scheduleItem)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $scheduleItem }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="schedule-empty">Tidak ada jadwal pelajaran hari ini.</div>
        @endif
    </div>
</div>

<!-- Profile Info Card -->
<div class="info-section">
    <div class="info-header">
        <h5>Informasi Profil Anda</h5>
    </div>
    <div class="info-body">
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nama Lengkap</span>
                <span class="info-value">{{ auth()->user()->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value">{{ auth()->user()->email }}</span>
            </div>
        </div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">NISN</span>
                <span class="info-value">{{ auth()->user()->nisn ?? 'Belum diisi' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Kelas</span>
                <span class="info-value">{{ auth()->user()->class ?? 'Belum diisi' }}</span>
            </div>
        </div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">No. Telepon</span>
                <span class="info-value">{{ auth()->user()->phone ?? 'Belum diisi' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Alamat</span>
                <span class="info-value">{{ auth()->user()->address ?? 'Belum diisi' }}</span>
            </div>
        </div>

        <a href="{{ route('student.profile') }}" class="btn-edit">
            <i class="fas fa-edit"></i>Edit Profil
        </a>
    </div>
</div>
@endsection
