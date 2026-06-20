@extends('layouts.admin')

@section('title', 'Kelola Jadwal Siswa')
@section('page-title', 'Kelola Jadwal Siswa')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <div>
            <h1>Kelola Jadwal Siswa</h1>
            <p class="subtitle">Atur jadwal pelajaran untuk setiap kelas (SD, SMP, SMA)</p>
        </div>
        <a href="{{ route('admin.schedule.student.wizard.step1') }}" class="btn-add-new">
            <i class="fas fa-plus"></i> Jadwal Baru
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle"></i>
            Terjadi kesalahan. Silakan periksa kembali data Anda.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="management-toolbar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari berdasarkan kelas atau mata pelajaran..." class="search-input">
        </div>
        <div class="filter-group">
            <select id="classFilter" class="filter-select">
                <option value="">Semua Kelas</option>
                @php
                    $uniqueClasses = $schedules->pluck('class')->unique()->sort();
                @endphp
                @foreach($uniqueClasses as $class)
                    <option value="{{ $class }}">{{ $class }}</option>
                @endforeach
            </select>
            <select id="dayFilter" class="filter-select">
                <option value="">Semua Hari</option>
                <option value="Monday">Senin</option>
                <option value="Tuesday">Selasa</option>
                <option value="Wednesday">Rabu</option>
                <option value="Thursday">Kamis</option>
                <option value="Friday">Jumat</option>
                <option value="Saturday">Sabtu</option>
            </select>
        </div>
    </div>

    <div class="table-responsive-container">
        @php
            $grouped = $schedules->groupBy('class');
            $daysIndonesia = [
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu'
            ];
        @endphp

        @if($grouped->isEmpty())
            <div class="no-data" style="padding:2rem;text-align:center;">
                <i class="fas fa-inbox" style="font-size:2rem;color:#7f8c8d"></i>
                <p>Belum ada jadwal siswa</p>
            </div>
        @else
            @foreach($grouped as $className => $items)
                <div class="class-block" style="margin-bottom:1.5rem;background:white;padding:1rem;border-radius:8px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <h3 style="margin:0">Kelas {{ $className }}</h3>
                        <div>
                            <a href="{{ route('admin.schedule.student.wizard.step1') }}?class={{ urlencode($className) }}" class="btn-add-new">Tambah Jadwal</a>
                        </div>
                    </div>

                    @php $byDay = $items->groupBy('day'); @endphp
                    @foreach($byDay as $day => $entries)
                        <div style="padding:0.75rem 0;border-top:1px solid #f1f1f1;">
                            <strong>{{ $daysIndonesia[$day] ?? $day }}</strong>
                            <ul style="margin:0.5rem 0 0 1rem;padding:0;">
                                @foreach($entries as $entry)
                                    <li style="margin-bottom:0.5rem;">
                                        <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;">
                                            <div>
                                                @foreach($entry->activities as $act)
                                                    <div>{{ $act }}</div>
                                                @endforeach
                                            </div>
                                            <div style="display:flex;gap:0.5rem;">
                                                <a href="{{ route('admin.schedule.student.edit', $entry->id) }}" class="btn-action btn-edit"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('admin.schedule.student.destroy', $entry->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn-action btn-delete" type="submit"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <i class="fas fa-calendar-check"></i>
            <div class="stat-content">
                <span class="stat-label">Total Jadwal</span>
                <span class="stat-value">{{ $schedules->count() }}</span>
            </div>
        </div>
    </div>
</div>

<style>
.admin-page { padding: 2rem; background: #f8f9fa; min-height: 100vh; }
    .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 1px 3px rgba(45,68,56,0.06); }
    .page-header h1 { margin: 0 0 0.25rem 0; color: #2D4438; font-size: 1.6rem; font-weight:700; }
.subtitle { color: #7f8c8d; margin: 0; font-size: 0.95rem; }
    .btn-add-new { background: #2D4438; color: white; padding: 0.6rem 1.1rem; border: none; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; transition: background 0.18s, transform 0.12s; box-shadow: 0 1px 2px rgba(45,68,56,0.12); }
    .btn-add-new:hover { background: #23362b; transform: translateY(-2px); }
.management-toolbar { display: flex; gap: 1rem; margin-bottom: 1.5rem; background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); flex-wrap: wrap; }
    .search-box { flex: 1; min-width: 250px; position: relative; display: flex; align-items: center; }
    .search-box i { position: absolute; left: 1rem; color: #c8d1cc; }
    .search-input { width: 100%; padding: 0.6rem 1rem 0.6rem 2.5rem; border: 1px solid #e6ebe6; border-radius: 8px; font-size: 0.95rem; background: #fbfdfb; }
.filter-group { display: flex; gap: 0.5rem; }
    .filter-select { padding: 0.6rem 0.9rem; border: 1px solid #e6ebe6; border-radius: 8px; background: white; cursor: pointer; min-width: 150px; }
    .alert { padding: 1rem; margin-bottom: 1.25rem; border-radius: 8px; display: flex; align-items: center; gap: 0.75rem; }
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
.close { background: none; border: none; font-size: 1.5rem; cursor: pointer; opacity: 0.7; margin-left: auto; }
    .table-responsive-container { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 1px 3px rgba(45,68,56,0.05); margin-bottom: 2rem; overflow-x: auto; }
.admin-table { width: 100%; border-collapse: collapse; min-width: 900px; }
    .admin-table thead { background: #2D4438; color: white; }
.admin-table th { padding: 1rem; text-align: left; font-weight: 600; }
.admin-table tbody tr { border-bottom: 1px solid #ecf0f1; transition: background 0.3s; }
.admin-table tbody tr:hover { background: #f8f9fa; }
.admin-table td { padding: 1rem; }
    .class-badge { display: inline-block; padding: 0.4rem 0.6rem; border-radius: 8px; font-weight: 700; font-size: 0.85rem; color: white; background: #2D4438; }
.badge-subject { display: inline-block; background: #e8f4f8; color: #16a085; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.9rem; font-weight: 500; }
.time-badge { display: inline-block; background: #fff3cd; color: #856404; padding: 0.5rem 0.75rem; border-radius: 4px; font-size: 0.9rem; font-weight: 500; }
.action-buttons { display: flex; gap: 0.5rem; }
    .btn-action { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: none; border-radius: 6px; cursor: pointer; transition: all 0.18s; text-decoration: none; }
    .btn-edit { background: #2D4438; color: white; }
    .btn-edit:hover { background: #23362b; transform: translateY(-2px); }
.btn-delete { background: #e74c3c; color: white; }
.btn-delete:hover { background: #c0392b; transform: translateY(-2px); }
.no-data { padding: 3rem 1rem; color: #7f8c8d; }
.no-data i { font-size: 3rem; display: block; margin-bottom: 1rem; opacity: 0.5; }
.pagination-container { display: flex; justify-content: center; margin: 2rem 0; }
    .stats-container { display: grid; grid-template-columns: 1fr; gap: 1rem; margin-top: 2rem; }
    .stat-card { background: white; padding: 1.25rem; border-radius: 10px; box-shadow: 0 1px 3px rgba(45,68,56,0.04); display: flex; align-items: center; gap: 1rem; }
    .stat-card i { font-size: 1.9rem; color: #2D4438; }
.stat-content { display: flex; flex-direction: column; gap: 0.25rem; }
.stat-label { color: #7f8c8d; font-size: 0.9rem; }
.stat-value { color: #2c3e50; font-size: 1.5rem; font-weight: 700; }

@media (max-width: 1024px) {
    .management-toolbar { flex-direction: column; }
    .filter-group { width: 100%; display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; }
}

@media (max-width: 768px) {
    .admin-page { padding: 1rem; }
    .page-header { flex-direction: column; gap: 1rem; }
    .btn-add-new { width: 100%; justify-content: center; }
    .search-box { width: 100%; }
    .admin-table th, .admin-table td { padding: 0.5rem; font-size: 0.85rem; }
    .admin-table th { width: auto !important; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const classFilter = document.getElementById('classFilter');
    const dayFilter = document.getElementById('dayFilter');
    const rows = document.querySelectorAll('.schedule-row');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedClass = classFilter.value;
        const selectedDay = dayFilter.value;

        rows.forEach(row => {
            const rowClass = row.dataset.class || '';
            const day = row.dataset.day || '';
            const subject = row.dataset.subject || '';

            const matchesSearch = rowClass.toLowerCase().includes(searchTerm) || subject.includes(searchTerm);
            const matchesClass = !selectedClass || rowClass === selectedClass;
            const matchesDay = !selectedDay || day === selectedDay;

            row.style.display = matchesSearch && matchesClass && matchesDay ? '' : 'none';
        });
    }

    searchInput?.addEventListener('keyup', filterTable);
    classFilter?.addEventListener('change', filterTable);
    dayFilter?.addEventListener('change', filterTable);
});
</script>
@endsection
