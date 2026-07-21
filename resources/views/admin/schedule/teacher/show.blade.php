@extends('layouts.admin')

@section('title', 'Rekap Jadwal Guru')

@section('content')
<div class="admin-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1>Rekap Jadwal Mengajar</h1>
            <p class="subtitle">Rincian alokasi waktu dan kelas untuk guru.</p>
        </div>
        <div class="header-action">
            <a href="{{ route('admin.schedule.teacher.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Top Summary Card (Profil & Statistik Ringkas) -->
    <div class="recap-summary-card">
        <div class="teacher-profile-info">
            <div class="avatar-box">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="profile-details">
                <h2>{{ $teacher->user->name ?? 'Guru Tidak Diketahui' }}</h2>
                <span class="subject-tag"><i class="fas fa-book"></i> {{ $subjectsStr ?: 'Belum Ada Mapel' }}</span>
            </div>
        </div>
        <div class="stats-divider"></div>
        <div class="recap-stats">
            <div class="stat-item">
                <span class="stat-label">Total Kelas</span>
                <span class="stat-value">{{ $totalClasses }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Total Durasi</span>
                <span class="stat-value">{{ $formattedDuration }}</span>
            </div>
        </div>
    </div>

    <!-- Conflict Alert -->
    @if($hasConflict)
    <div class="alert-conflict">
        <div class="alert-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="alert-text">
            <strong>Peringatan Jadwal Bentrok!</strong>
            <p>Ditemukan jam mengajar yang saling beririsan pada hari yang sama.</p>
        </div>
    </div>
    @endif

    <!-- Schedules Section Grouped by Day -->
    @if($schedules->isEmpty())
    <div class="detail-panel">
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-calendar-times"></i>
            </div>
            <p>Belum ada rekap jadwal mengajar</p>
            <span class="text-muted text-sm">Guru ini belum diplot ke kelas manapun.</span>
        </div>
    </div>
    @else
        @php
            $daysOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $daysIndonesia = [
                'Monday'    => 'Senin',
                'Tuesday'   => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday'  => 'Kamis',
                'Friday'    => 'Jumat',
                'Saturday'  => 'Sabtu',
                'Sunday'    => 'Minggu'
            ];
            $groupedSchedules = $schedules->groupBy('day');
        @endphp

        <div class="recap-grid">
            @foreach($daysOrder as $dayName)
                @if(isset($groupedSchedules[$dayName]))
                    <div class="day-recap-card">
                        <div class="day-card-header">
                            <div class="day-title">
                                <i class="far fa-calendar-alt"></i>
                                <h3>{{ $daysIndonesia[$dayName] ?? $dayName }}</h3>
                            </div>
                            <span class="day-count-badge">{{ count($groupedSchedules[$dayName]) }} Sesi</span>
                        </div>
                        <div class="day-card-body">
                            <div class="schedule-timeline">
                                @foreach($groupedSchedules[$dayName] as $sched)
                                <div class="timeline-item">
                                    <div class="time-badge">
                                        <i class="far fa-clock"></i>
                                        {{ substr($sched->start_time, 0, 5) }} - {{ substr($sched->end_time, 0, 5) }}
                                    </div>
                                    <div class="schedule-detail">
                                        <div class="main-info">
                                            <strong class="class-name">Kelas {{ $sched->class ?? '-' }}</strong>
                                            <span class="subject-name">{{ $sched->subject ?? '-' }}</span>
                                        </div>
                                        @if($sched->education_level)
                                            <span class="level-pill">{{ $sched->education_level }}</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>

<style>
/* CSS VARIABLES */
:root {
    --primary: #2D4438;
    --primary-light: #486E5A;
    --primary-soft: #EAF0EC;
    --bg-main: #F8FAFC;
    --bg-white: #ffffff;
    --border-light: #E2E8F0;
    --text-main: #1E293B;
    --text-muted: #64748B;
    --danger: #EF4444;
    --danger-bg: #FEF2F2;
    --danger-border: #FCA5A5;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
    --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07);
}

.admin-page {
    padding: 2.5rem;
    background: var(--bg-main);
    min-height: 100vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

.text-muted { color: var(--text-muted); }
.text-sm { font-size: 0.875rem; }

/* PAGE HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.75rem;
}

.header-content h1 {
    margin: 0 0 0.25rem 0;
    color: var(--text-main);
    font-size: 1.75rem;
    font-weight: 700;
}

.subtitle {
    color: var(--text-muted);
    margin: 0;
    font-size: 0.95rem;
}

/* BUTTONS */
.btn {
    padding: 0.55rem 1.1rem;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-outline {
    background: var(--bg-white);
    border: 1px solid var(--border-light);
    color: var(--text-main);
    box-shadow: var(--shadow-sm);
}

.btn-outline:hover {
    background: #F1F5F9;
    border-color: #CBD5E1;
}

/* RECAP SUMMARY CARD */
.recap-summary-card {
    background: var(--bg-white);
    border: 1px solid var(--border-light);
    border-radius: 12px;
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: var(--shadow-sm);
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.teacher-profile-info {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.avatar-box {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    background: var(--primary-soft);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.profile-details h2 {
    margin: 0 0 0.25rem 0;
    font-size: 1.3rem;
    color: var(--text-main);
    font-weight: 700;
}

.subject-tag {
    font-size: 0.875rem;
    color: var(--text-muted);
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.stats-divider {
    width: 1px;
    height: 48px;
    background: var(--border-light);
}

.recap-stats {
    display: flex;
    gap: 2.5rem;
}

.stat-item {
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    font-weight: 600;
    margin-bottom: 0.2rem;
}

.stat-value {
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--primary);
}

/* CONFLICT ALERT */
.alert-conflict {
    background: var(--danger-bg);
    border: 1px solid var(--danger-border);
    border-left: 4px solid var(--danger);
    padding: 1rem 1.25rem;
    border-radius: 8px;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 2rem;
    color: #991B1B;
}

.alert-icon {
    font-size: 1.2rem;
    margin-top: 0.1rem;
}

.alert-text p {
    margin: 0.2rem 0 0 0;
    font-size: 0.875rem;
}

/* RECAP GRID BY DAY */
.recap-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 1.5rem;
}

.day-recap-card {
    background: var(--bg-white);
    border: 1px solid #D5E2DB;
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.day-recap-card:hover {
    box-shadow: var(--shadow-md);
}

/* HEADER CARD HIJAU */
.day-card-header {
    background: var(--primary-soft);
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #D5E2DB;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.day-title {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    color: var(--primary);
}

.day-title h3 {
    margin: 0;
    font-size: 1rem;
    font-weight: 700;
    color: var(--primary);
}

.day-count-badge {
    background: var(--primary);
    color: #ffffff;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.65rem;
    border-radius: 9999px;
}

.day-card-body {
    padding: 1.25rem;
}

/* TIMELINE LIST */
.schedule-timeline {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.timeline-item {
    padding-bottom: 1rem;
    border-bottom: 1px dashed var(--border-light);
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.timeline-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.time-badge {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--primary);
    background: var(--primary-soft);
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    width: fit-content;
}

.schedule-detail {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.main-info {
    display: flex;
    flex-direction: column;
}

.class-name {
    font-size: 0.95rem;
    color: var(--text-main);
}

.subject-name {
    font-size: 0.85rem;
    color: var(--text-muted);
}

.level-pill {
    font-size: 0.75rem;
    background: var(--bg-main);
    border: 1px solid var(--border-light);
    padding: 0.15rem 0.5rem;
    border-radius: 4px;
    color: var(--text-muted);
}

/* EMPTY STATE */
.detail-panel {
    background: var(--bg-white);
    border-radius: 12px;
    border: 1px solid var(--border-light);
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    width: 60px;
    height: 60px;
    background: #F1F5F9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: #94A3B8;
    font-size: 1.5rem;
}

.empty-state p {
    margin: 0 0 0.25rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-main);
}

@media (max-width: 768px) {
    .stats-divider { display: none; }
    .recap-summary-card { flex-direction: column; align-items: flex-start; }
}
</style>
@endsection