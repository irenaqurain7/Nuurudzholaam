@extends('layouts.admin')

@section('title', 'Jadwal Guru')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <div>
            <h1>Kelola Jadwal Guru</h1>
            <p class="subtitle">Jadwal guru tersinkron otomatis dari Jadwal Siswa.</p>
        </div>
        <div>
            <span class="sync-badge">
                <i class="fas fa-sync-alt"></i> Sinkron Otomatis
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalGuru }}</h3>
                <p>Total Guru</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-green">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $guruMemilikiJadwal }}</h3>
                <p>Guru Memiliki Jadwal</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-purple">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalJadwal }}</h3>
                <p>Total Jadwal Mengajar</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-red">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalKonflik }}</h3>
                <p>Konflik Jadwal</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="filter-section">
        <form method="GET" action="{{ route('admin.schedule.teacher.index') }}" class="filter-form">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search_guru" value="{{ request('search_guru') }}" placeholder="Cari nama guru..." class="form-control">
            </div>
            
            <div class="filter-controls">
                <select name="day" class="form-control">
                    <option value="">Semua Hari</option>
                    <option value="Monday" {{ request('day') == 'Monday' ? 'selected' : '' }}>Senin</option>
                    <option value="Tuesday" {{ request('day') == 'Tuesday' ? 'selected' : '' }}>Selasa</option>
                    <option value="Wednesday" {{ request('day') == 'Wednesday' ? 'selected' : '' }}>Rabu</option>
                    <option value="Thursday" {{ request('day') == 'Thursday' ? 'selected' : '' }}>Kamis</option>
                    <option value="Friday" {{ request('day') == 'Friday' ? 'selected' : '' }}>Jumat</option>
                    <option value="Saturday" {{ request('day') == 'Saturday' ? 'selected' : '' }}>Sabtu</option>
                </select>

                <select name="level" class="form-control">
                    <option value="">Semua Jenjang</option>
                    <option value="TK" {{ request('level') == 'TK' ? 'selected' : '' }}>TK</option>
                    <option value="SD" {{ request('level') == 'SD' ? 'selected' : '' }}>SD</option>
                    <option value="SMP" {{ request('level') == 'SMP' ? 'selected' : '' }}>SMP</option>
                    <option value="SMK" {{ request('level') == 'SMK' ? 'selected' : '' }}>SMK</option>
                </select>

                <button type="submit" class="btn btn-primary">Cari</button>
                @if(request()->hasAny(['search_guru', 'day', 'level']))
                    <a href="{{ route('admin.schedule.teacher.index') }}" class="btn btn-outline">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Main Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th width="5%">NO</th>
                        <th width="20%">NAMA GURU</th>
                        <th width="25%">MATA PELAJARAN</th>
                        <th width="15%">TOTAL KELAS</th>
                        <th width="15%">TOTAL JAM</th>
                        <th width="10%">STATUS</th>
                        <th width="10%">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groupedSchedulesPaginated as $index => $data)
                        <tr>
                            <td>{{ ($groupedSchedulesPaginated->currentPage() - 1) * $groupedSchedulesPaginated->perPage() + $index + 1 }}</td>
                            <td class="fw-bold text-dark">{{ $data['name'] }}</td>
                            <td>{{ $data['subjects_str'] ?: '-' }}</td>
                            <td>{{ $data['total_classes'] }} Kelas</td>
                            <td>{{ $data['formatted_duration'] }}</td>
                            <td>
                                @if($data['has_conflict'])
                                    <span class="status-badge error"><i class="fas fa-times-circle"></i> Konflik Jadwal</span>
                                @else
                                    <span class="status-badge success"><i class="fas fa-check-circle"></i> Normal</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.schedule.teacher.show', $data['teacher_id']) }}" class="btn-lihat-jadwal">
                                    <i class="fas fa-eye"></i> Lihat Jadwal
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada data guru</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($groupedSchedulesPaginated->hasPages())
            <div class="pagination-wrapper">
                {{ $groupedSchedulesPaginated->links('partials.pagination') }}
            </div>
        @endif
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

.sync-badge {
    background: var(--border);
    color: var(--primary);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: 1px solid var(--secondary);
}

/* STATS CARDS */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--white);
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-icon.bg-blue { background: #eff6ff; color: #3b82f6; }
.stat-icon.bg-green { background: #ecfdf5; color: #10b981; }
.stat-icon.bg-purple { background: #f5f3ff; color: #8b5cf6; }
.stat-icon.bg-red { background: var(--danger-bg); color: var(--danger); }

.stat-content h3 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-dark);
}

.stat-content p {
    margin: 0;
    color: var(--text-muted);
    font-size: 0.9rem;
}

/* FILTER SECTION */
.filter-section {
    background: var(--white);
    padding: 1.25rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    margin-bottom: 2rem;
}

.filter-form {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: center;
}

.search-box {
    flex: 1;
    min-width: 250px;
    position: relative;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
}

.search-box .form-control {
    padding-left: 2.5rem;
    width: 100%;
}

.filter-controls {
    display: flex;
    gap: 1rem;
}

.form-control {
    padding: 0.6rem 1rem;
    border: 1px solid var(--border);
    border-radius: 8px;
    background: var(--bg-light);
    color: var(--text-dark);
    outline: none;
}

.form-control:focus {
    border-color: var(--secondary);
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
}

.btn-primary {
    background: var(--primary);
    color: var(--white);
}

.btn-primary:hover {
    background: var(--primary-light);
}

.btn-outline {
    background: transparent;
    border: 1px solid var(--border);
    color: var(--text-dark);
}

.btn-outline:hover {
    background: var(--bg-light);
}

/* TABLES */
.table-container {
    background: var(--white);
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    margin-bottom: 2rem;
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
    background: var(--primary);
    color: var(--white);
    padding: 1rem 1.5rem;
    text-align: left;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
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

.fw-bold { font-weight: 700; }
.text-dark { color: var(--text-dark); }

/* STATUS BADGES */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.8rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
}

.status-badge.success {
    background: var(--success-bg);
    color: var(--success);
}

.status-badge.error {
    background: var(--danger-bg);
    color: var(--danger);
}

/* ACTION BUTTON */
.btn-lihat-jadwal {
    background: transparent;
    border: 1px solid var(--success);
    color: var(--success);
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    text-decoration: none;
}

.btn-lihat-jadwal:hover {
    background: var(--success);
    color: var(--white);
}

/* PAGINATION */
.pagination-wrapper {
    padding: 1.5rem;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: center;
}

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-muted);
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
