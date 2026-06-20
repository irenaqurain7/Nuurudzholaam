@extends('layouts.admin')

@section('title', 'Detail Jadwal Guru')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <div>
            <h1>Detail Jadwal Mengajar</h1>
            <p class="subtitle">Melihat rincian jadwal untuk guru yang dipilih.</p>
        </div>
        <div>
            <a href="{{ route('admin.schedule.teacher.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="detail-panel">
        <div class="detail-header">
            <h3><i class="fas fa-user-circle"></i> Profil Guru</h3>
        </div>
        <div class="detail-body">
            <!-- Grid Info -->
            <div class="info-grid">
                <div class="info-card">
                    <span class="info-label">Nama Guru</span>
                    <strong class="info-value">{{ $teacher->user->name ?? 'Guru Tidak Diketahui' }}</strong>
                </div>
                <div class="info-card">
                    <span class="info-label">Mata Pelajaran</span>
                    <strong class="info-value">{{ $subjectsStr ?: '-' }}</strong>
                </div>
                <div class="info-card">
                    <span class="info-label">Total Kelas</span>
                    <strong class="info-value">{{ $totalClasses }} Kelas</strong>
                </div>
                <div class="info-card">
                    <span class="info-label">Total Jam Mengajar</span>
                    <strong class="info-value">{{ $formattedDuration }}</strong>
                </div>
            </div>

            <!-- Conflict Alert Placeholder -->
            @if($hasConflict)
            <div class="alert-conflict">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Ditemukan jadwal yang saling bertabrakan (overlap waktu pada hari yang sama).</span>
            </div>
            @endif

            <!-- Schedules Table / Empty State -->
            <div class="schedule-section">
                <h4 class="section-title">Daftar Jadwal:</h4>
                
                @if($schedules->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>Belum ada jadwal mengajar</p>
                </div>
                @else
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Kelas</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Jenjang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $daysIndonesia = [
                                        'Monday' => 'Senin',
                                        'Tuesday' => 'Selasa',
                                        'Wednesday' => 'Rabu',
                                        'Thursday' => 'Kamis',
                                        'Friday' => 'Jumat',
                                        'Saturday' => 'Sabtu',
                                        'Sunday' => 'Minggu'
                                    ];
                                @endphp
                                @foreach($schedules as $sched)
                                <tr>
                                    <td><strong>{{ $daysIndonesia[$sched->day] ?? $sched->day }}</strong></td>
                                    <td>{{ substr($sched->start_time, 0, 5) }} - {{ substr($sched->end_time, 0, 5) }}</td>
                                    <td>{{ $sched->class ?? '-' }}</td>
                                    <td>{{ $sched->subject ?? '-' }}</td>
                                    <td>{{ $sched->education_level ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* CSS VARIABLES MATCHING ADMIN LAYOUT */
:root {
    --primary: #2D4438;
    --primary-light: #486E5A;
    --secondary: #709D88;
    --bg-light: #F4F7F5;
    --border: #E2ECE8;
    --text-dark: #1C2D25;
    --text-muted: #6C8B7C;
    --white: #ffffff;
    --danger: #ef4444;
    --danger-bg: #fef2f2;
    --success: #10b981;
    --success-bg: #ecfdf5;
}

/* LAYOUT & SPACING */
.admin-page {
    padding: 2rem;
    background: var(--bg-light);
    min-height: 100vh;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
}

.page-header h1 {
    margin: 0 0 0.5rem 0;
    color: var(--primary);
    font-size: 1.8rem;
    font-weight: 700;
}

.subtitle {
    color: var(--text-muted);
    margin: 0;
}

.btn {
    padding: 0.6rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-outline {
    background: var(--white);
    border: 1px solid var(--border);
    color: var(--text-dark);
}

.btn-outline:hover {
    background: var(--bg-light);
    border-color: var(--secondary);
}

/* DYNAMIC DETAIL PANEL */
.detail-panel {
    background: var(--white);
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    border: 1px solid var(--border);
}

.detail-header {
    background: var(--primary);
    color: var(--white);
    padding: 1.25rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.detail-header h3 {
    margin: 0;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-body {
    padding: 1.5rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.info-card {
    background: var(--bg-light);
    padding: 1.25rem;
    border-radius: 8px;
    border: 1px solid var(--border);
}

.info-label {
    display: block;
    font-size: 0.85rem;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.info-value {
    display: block;
    font-size: 1.1rem;
    color: var(--text-dark);
    font-weight: 700;
}

.alert-conflict {
    background: var(--danger-bg);
    color: var(--danger);
    padding: 1rem 1.25rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
    border: 1px solid #fca5a5;
}

.schedule-section {
    margin-top: 1.5rem;
}

.section-title {
    color: var(--text-dark);
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

/* TABLES */
.table-container {
    background: var(--white);
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid var(--border);
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th {
    background: var(--bg-light);
    color: var(--text-muted);
    padding: 1rem 1.5rem;
    text-align: left;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--border);
}

.admin-table td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border);
    color: var(--text-dark);
    vertical-align: middle;
}

.admin-table tbody tr:hover {
    background-color: var(--bg-light);
}

.admin-table tbody tr:last-child td {
    border-bottom: none;
}

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-muted);
    background: var(--bg-light);
    border-radius: 8px;
    border: 1px dashed var(--border);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state p {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 500;
}
</style>
@endsection
