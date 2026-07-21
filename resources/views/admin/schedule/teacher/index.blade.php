@extends('layouts.admin')

@section('title', 'Recap Jadwal Guru')
@section('page-title', 'Recap Jadwal Guru')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <div>
            <h1>Recap Jadwal Guru</h1>
            <p class="subtitle">Data pada halaman ini diperbarui secara otomatis berdasarkan Jadwal Kelas.</p>
        </div>
        <div>
            <span class="sync-badge">
                <i class="fas fa-sync-alt"></i> Sinkron Otomatis
            </span>
        </div>
    </div>

    <!-- Stats Cards Grid -->
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

    <!-- Toolbar Filter (Ditingkatkan Visualnya) -->
    <div class="management-toolbar">
        <form method="GET" action="{{ route('admin.schedule.teacher.index') }}" class="filter-form-wrapper">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search_guru" value="{{ request('search_guru') }}" placeholder="Cari nama guru..." class="search-input">
            </div>
            
            <div class="filter-group">
                <select name="day" class="filter-select">
                    <option value="">Semua Hari</option>
                    <option value="Monday" {{ request('day') == 'Monday' ? 'selected' : '' }}>Senin</option>
                    <option value="Tuesday" {{ request('day') == 'Tuesday' ? 'selected' : '' }}>Selasa</option>
                    <option value="Wednesday" {{ request('day') == 'Wednesday' ? 'selected' : '' }}>Rabu</option>
                    <option value="Thursday" {{ request('day') == 'Thursday' ? 'selected' : '' }}>Kamis</option>
                    <option value="Friday" {{ request('day') == 'Friday' ? 'selected' : '' }}>Jumat</option>
                    <option value="Saturday" {{ request('day') == 'Saturday' ? 'selected' : '' }}>Sabtu</option>
                </select>

                <select name="level" class="filter-select">
                    <option value="">Semua Jenjang</option>
                    <option value="TK" {{ request('level') == 'TK' ? 'selected' : '' }}>TK</option>
                    <option value="SD" {{ request('level') == 'SD' ? 'selected' : '' }}>SD</option>
                    <option value="SMP" {{ request('level') == 'SMP' ? 'selected' : '' }}>SMP</option>
                    <option value="SMK" {{ request('level') == 'SMK' ? 'selected' : '' }}>SMK</option>
                </select>

                <button type="submit" class="btn-filter-submit">
                    <i class="fas fa-filter"></i> Cari
                </button>
                @if(request()->hasAny(['search_guru', 'day', 'level']))
                    <a href="{{ route('admin.schedule.teacher.index') }}" class="btn-filter-reset">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Main Table (Fitur & Struktur Tetap Sama, Tampilan Ditingkatkan) -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">No</th>
                        <th>Nama Guru</th>
                        <th>Mata Pelajaran</th>
                        <th style="text-align: center;">Total Kelas</th>
                        <th style="text-align: center;">Total Jam</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center; width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groupedSchedulesPaginated as $index => $data)
                        <tr>
                            <td style="text-align: center; font-weight: 600; color: #6C8B7C;">
                                {{ $groupedSchedulesPaginated->firstItem() + $index }}
                            </td>
                            <td>
                                <div class="guru-profile">
                                    <div class="blue-bar"></div>
                                    <div class="guru-name-text">{{ $data['name'] }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="subject-text">{{ $data['subjects_str'] ?: '-' }}</span>
                            </td>
                            <td style="text-align: center;">
                                <span class="count-badge">{{ $data['total_classes'] }} Kelas</span>
                            </td>
                            <td style="text-align: center;">
                                <span class="time-text"><i class="far fa-clock"></i> {{ $data['formatted_duration'] }}</span>
                            </td>
                            <td style="text-align: center;">
                                @if($data['has_conflict'])
                                    <span class="status-badge error"><i class="fas fa-times-circle"></i> Konflik</span>
                                @else
                                    <span class="status-badge success"><i class="fas fa-check-circle"></i> Normal</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.schedule.teacher.show', $data['teacher_id']) }}" class="btn-lihat-jadwal" title="Lihat Detail Jadwal">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="no-data">
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
            <div class="pagination-container">
                {{ $groupedSchedulesPaginated->links('partials.pagination') }}
            </div>
        @endif
    </div>
</div>

<style>
/* Layout Base */
.admin-page { padding: 2rem; background: #f8f9fa; min-height: 100vh; }
.page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(45,68,56,0.06); }
.page-header h1 { margin: 0 0 0.25rem 0; color: #2D4438; font-size: 1.6rem; font-weight: 700; }
.subtitle { color: #7f8c8d; margin: 0; font-size: 0.95rem; }

.sync-badge { background: #E2ECE8; color: #2D4438; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; border: 1px solid #709D88; }

/* Stats Cards Grid */
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
.stat-card { background: white; padding: 1.25rem; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 1.25rem; transition: all 0.2s; border: 1px solid #E2ECE8; }
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(45,68,56,0.1); }
.stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
.stat-icon.bg-blue { background: #eff6ff; color: #3b82f6; }
.stat-icon.bg-green { background: #ecfdf5; color: #10b981; }
.stat-icon.bg-purple { background: #f5f3ff; color: #8b5cf6; }
.stat-icon.bg-red { background: #fef2f2; color: #ef4444; }
.stat-content h3 { margin: 0 0 0.2rem 0; font-size: 1.5rem; font-weight: 700; color: #1C2D25; }
.stat-content p { margin: 0; color: #6C8B7C; font-size: 0.85rem; font-weight: 600; }

/* Filter & Search Bar */
.management-toolbar { background: white; padding: 1rem; border-radius: 12px; border: 1px solid #E2ECE8; box-shadow: 0 2px 4px rgba(0,0,0,0.02); margin-bottom: 1.5rem; }
.filter-form-wrapper { display: flex; gap: 1rem; flex-wrap: wrap; width: 100%; }
.search-box { flex: 1; min-width: 250px; position: relative; display: flex; align-items: center; }
.search-box i { position: absolute; left: 1rem; color: #9ca3af; }
.search-input { width: 100%; padding: 0.6rem 1rem 0.6rem 2.5rem; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 0.9rem; background: #f9fafb; outline: none; transition: border-color 0.2s; }
.search-input:focus { border-color: #2D4438; background: #ffffff; }
.filter-group { display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; }
.filter-select { padding: 0.6rem 0.9rem; border: 1px solid #e5e7eb; border-radius: 8px; background: white; cursor: pointer; min-width: 130px; font-size: 0.88rem; outline: none; color: #374151; }
.filter-select:focus { border-color: #2D4438; }
.btn-filter-submit { background: #2D4438; color: white; padding: 0.6rem 1.2rem; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 0.4rem; transition: background 0.2s; }
.btn-filter-submit:hover { background: #23362b; }
.btn-filter-reset { background: transparent; color: #6b7280; padding: 0.6rem 1rem; border: 1px solid #e5e7eb; border-radius: 8px; text-decoration: none; font-size: 0.88rem; font-weight: 600; transition: all 0.2s; }
.btn-filter-reset:hover { background: #f3f4f6; color: #111827; }

/* Table Styling */
.table-card { background: white; border-radius: 12px; border: 1px solid #E2ECE8; box-shadow: 0 2px 4px rgba(0,0,0,0.02); overflow: hidden; }
.table-responsive { width: 100%; overflow-x: auto; }
.data-table { width: 100%; border-collapse: collapse; text-align: left; }
.data-table th { background: #f8faf9; padding: 1rem 1.25rem; font-size: 0.85rem; font-weight: 700; color: #2D4438; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #E2ECE8; }
.data-table td { padding: 1.1rem 1.25rem; border-bottom: 1px solid #f0f4f2; vertical-align: middle; color: #374151; font-size: 0.92rem; }
.data-table tbody tr:last-child td { border-bottom: none; }
.data-table tbody tr:hover { background-color: #fbfdfb; }

/* Table Inner Elements */
.guru-profile { display: flex; align-items: center; gap: 0.75rem; }
.blue-bar { width: 4px; height: 20px; background: #3b82f6; border-radius: 4px; flex-shrink: 0; }
.guru-name-text { font-weight: 700; color: #1C2D25; }
.subject-text { color: #4b5563; font-weight: 500; }
.count-badge { background: #f3f4f6; color: #374151; padding: 0.3rem 0.65rem; border-radius: 6px; font-weight: 600; font-size: 0.82rem; }
.time-text { font-size: 0.88rem; color: #6b7280; display: inline-flex; align-items: center; gap: 0.35rem; }

/* Badges & Action Buttons */
.status-badge { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.3rem 0.75rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600; }
.status-badge.success { background: #ecfdf5; color: #10b981; }
.status-badge.error { background: #fef2f2; color: #ef4444; }

.btn-lihat-jadwal { background: #2D4438; color: #ffffff; padding: 0.45rem 0.85rem; border-radius: 6px; font-size: 0.82rem; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.35rem; text-decoration: none; }
.btn-lihat-jadwal:hover { background: #23362b; transform: translateY(-1px); }

.no-data { padding: 3rem 1rem !important; text-align: center; color: #9ca3af; }
.no-data i { font-size: 2.2rem; margin-bottom: 0.5rem; opacity: 0.7; }
.no-data p { margin: 0; font-size: 0.95rem; }

.pagination-container { padding: 1rem 1.25rem; border-top: 1px solid #E2ECE8; display: flex; justify-content: center; }

@media (max-width: 768px) {
    .admin-page { padding: 1rem; }
    .page-header { flex-direction: column; gap: 1rem; }
    .filter-form-wrapper { flex-direction: column; }
    .search-box { width: 100%; }
    .filter-group { width: 100%; justify-content: flex-start; }
    .filter-select { flex: 1; }
}
</style>
@endsection