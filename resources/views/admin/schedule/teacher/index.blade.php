@extends('layouts.admin')

@section('title', 'Kelola Jadwal Guru')
@section('page-title', 'Kelola Jadwal Guru')
@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Kelola Jadwal Guru</h1>
            <p class="subtitle">Jadwal guru tersinkron otomatis dari Jadwal Siswa.</p>
        </div>
        <div class="header-action">
            <span class="badge bg-success py-2 px-3"><i class="fas fa-sync-alt mr-1"></i> Sinkron Otomatis</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon bg-primary-light text-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $totalGuru }}</h3>
                <p>Total Guru</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-success-light text-success">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $guruMemilikiJadwal }}</h3>
                <p>Guru Memiliki Jadwal</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-info-light text-info">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $totalJadwal }}</h3>
                <p>Total Jadwal Mengajar</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-danger-light text-danger">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $totalKonflik }}</h3>
                <p>Konflik Jadwal</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('admin.schedule.teacher.index') }}" class="management-toolbar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" name="search_guru" value="{{ request('search_guru') }}" placeholder="Cari nama guru..." class="search-input">
        </div>
        <div class="filter-group">
            <select name="day" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Hari</option>
                <option value="Monday" {{ request('day') == 'Monday' ? 'selected' : '' }}>Senin</option>
                <option value="Tuesday" {{ request('day') == 'Tuesday' ? 'selected' : '' }}>Selasa</option>
                <option value="Wednesday" {{ request('day') == 'Wednesday' ? 'selected' : '' }}>Rabu</option>
                <option value="Thursday" {{ request('day') == 'Thursday' ? 'selected' : '' }}>Kamis</option>
                <option value="Friday" {{ request('day') == 'Friday' ? 'selected' : '' }}>Jumat</option>
                <option value="Saturday" {{ request('day') == 'Saturday' ? 'selected' : '' }}>Sabtu</option>
            </select>
            <select name="level" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Jenjang</option>
                <option value="TK" {{ request('level') == 'TK' ? 'selected' : '' }}>TK</option>
                <option value="SD" {{ request('level') == 'SD' ? 'selected' : '' }}>SD</option>
                <option value="SMP" {{ request('level') == 'SMP' ? 'selected' : '' }}>SMP</option>
                <option value="SMK" {{ request('level') == 'SMK' ? 'selected' : '' }}>SMK</option>
            </select>
            @if(request()->hasAny(['search_guru', 'day', 'level']))
                <a href="{{ route('admin.schedule.teacher.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
            <button type="submit" class="btn btn-primary d-none">Cari</button>
        </div>
    </form>

    <!-- Schedules Table -->
    <div class="table-responsive-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Guru</th>
                    <th style="width: 20%;">Mata Pelajaran</th>
                    <th style="width: 10%;">Total Kelas</th>
                    <th style="width: 15%;">Total Jam</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groupedSchedulesPaginated as $index => $data)
                    <tr>
                        <td>{{ ($groupedSchedulesPaginated->currentPage() - 1) * $groupedSchedulesPaginated->perPage() + $index + 1 }}</td>
                        <td>
                            <div class="teacher-info">
                                <span class="teacher-name">{{ $data['name'] }}</span>
                            </div>
                        </td>
                        <td><span class="text-muted">{{ $data['subjects_str'] ?: '-' }}</span></td>
                        <td>{{ $data['total_classes'] }} Kelas</td>
                        <td>{{ $data['formatted_duration'] }}</td>
                        <td>
                            @if($data['has_conflict'])
                                <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Konflik Jadwal</span>
                            @else
                                <span class="badge bg-success"><i class="fas fa-check-circle"></i> Normal</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $data['teacher_id'] }}">
                                <i class="fas fa-eye mr-1"></i> Lihat Jadwal
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Modal Detail -->
                    <div class="modal fade" id="modalDetail{{ $data['teacher_id'] }}" tabindex="-1" aria-labelledby="modalLabel{{ $data['teacher_id'] }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="modalLabel{{ $data['teacher_id'] }}">Detail Jadwal Mengajar</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-4">
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <td width="150" class="text-muted">Nama Guru</td>
                                                <th>{{ $data['name'] }}</th>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Mata Pelajaran</td>
                                                <th>{{ $data['subjects_str'] ?: '-' }}</th>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Total Jam Mengajar</td>
                                                <th>{{ $data['formatted_duration'] }}</th>
                                            </tr>
                                        </table>
                                    </div>

                                    @if($data['has_conflict'])
                                        <div class="alert alert-danger">
                                            <i class="fas fa-exclamation-triangle"></i> Ditemukan jadwal yang saling bertabrakan (overlap waktu pada hari yang sama).
                                        </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Hari</th>
                                                    <th>Jam</th>
                                                    <th>Kelas</th>
                                                    <th>Jenjang</th>
                                                    <th>Ruangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $daysIndonesia = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
                                                    $sortedSchedules = collect($data['schedules'])->sortBy('day')->sortBy('start_time');
                                                @endphp
                                                @forelse($sortedSchedules as $sched)
                                                    <tr>
                                                        <td>{{ $daysIndonesia[$sched->day] ?? $sched->day }}</td>
                                                        <td>{{ substr($sched->start_time, 0, 5) }} - {{ substr($sched->end_time, 0, 5) }}</td>
                                                        <td>{{ $sched->class ?? '-' }}</td>
                                                        <td>{{ $sched->education_level ?? '-' }}</td>
                                                        <td>{{ $sched->room ?? '-' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr><td colspan="5" class="text-center">Tidak ada jadwal</td></tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="7" class="text-center no-data">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada data guru yang memiliki jadwal</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($groupedSchedulesPaginated->hasPages())
        <div class="pagination-container">
            {{ $groupedSchedulesPaginated->links() }}
        </div>
    @endif
</div>

<style>
.admin-page {
    padding: 2rem;
    background: #f8f9fa;
    min-height: 100vh;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(45,68,56,0.06);
}

.page-header h1 {
    margin: 0 0 0.25rem 0;
    color: #2D4438;
    font-size: 1.6rem;
    font-weight:700;
}

.subtitle {
    color: #7f8c8d;
    margin: 0;
    font-size: 0.95rem;
}

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
}
.stat-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 1px 3px rgba(45,68,56,0.06);
}
.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
}
.bg-primary-light { background: rgba(13, 110, 253, 0.1); }
.bg-success-light { background: rgba(25, 135, 84, 0.1); }
.bg-info-light { background: rgba(13, 202, 240, 0.1); }
.bg-danger-light { background: rgba(220, 53, 69, 0.1); }

.stat-info h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #2D4438;
}
.stat-info p {
    margin: 0;
    font-size: 0.9rem;
    color: #6C8B7C;
}

.management-toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
    background: white;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.search-box {
    flex: 1;
    min-width: 250px;
    position: relative;
    display: flex;
    align-items: center;
}

.search-box i { position: absolute; left: 1rem; color: #c8d1cc; }
.search-input { width: 100%; padding: 0.6rem 1rem 0.6rem 2.5rem; border: 1px solid #e6ebe6; border-radius: 8px; font-size: 0.95rem; background: #fbfdfb; }
.search-input:focus { outline: none; border-color: #2D4438; }

.filter-group {
    display: flex;
    gap: 0.5rem;
}

.filter-select {
    padding: 0.6rem 1rem;
    border: 1px solid #ddd;
    border-radius: 6px;
    background: white;
    cursor: pointer;
}

.table-responsive-container { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 1px 3px rgba(45,68,56,0.05); margin-bottom: 2rem; }

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table thead { background: #2D4438; color: white; }

.admin-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
}

.admin-table tbody tr {
    border-bottom: 1px solid #ecf0f1;
    transition: background 0.3s;
}

.admin-table tbody tr:hover {
    background: #f8f9fa;
}

.admin-table td {
    padding: 1rem;
    vertical-align: middle;
}

.teacher-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.teacher-name {
    font-weight: 600;
    color: #2c3e50;
}

.no-data {
    padding: 3rem 1rem;
    color: #7f8c8d;
}

.no-data i {
    font-size: 3rem;
    display: block;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

.modal-header.bg-success {
    background-color: #2D4438 !important;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr 1fr;
    }

    .management-toolbar {
        flex-direction: column;
    }
    
    .filter-group {
        width: 100%;
        flex-wrap: wrap;
    }
    .filter-group select {
        flex: 1;
    }
}
</style>
@endsection
