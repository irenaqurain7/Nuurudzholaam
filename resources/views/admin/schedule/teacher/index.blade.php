@extends('layouts.admin')

@section('title', 'Kelola Jadwal Guru')
@section('page-title', 'Kelola Jadwal Guru')
@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Kelola Jadwal Guru</h1>
            <p class="subtitle">Atur jadwal mengajar untuk semua guru</p>
        </div>
        <a href="{{ route('admin.schedule.teacher.create') }}" class="btn-add-new">
            <i class="fas fa-plus"></i> Jadwal Baru
        </a>
    </div>

    <!-- Status Message -->
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

    <!-- Search & Filter -->
    <div class="management-toolbar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari berdasarkan nama guru atau mata pelajaran..." class="search-input">
        </div>
        <div class="filter-group">
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

    <!-- Schedules Table -->
    <div class="table-responsive-container">
        <table class="admin-table" id="scheduleTable">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Nama Guru</th>
                    <th style="width: 15%;">Mata Pelajaran</th>
                    <th style="width: 12%;">Hari</th>
                    <th style="width: 15%;">Waktu</th>
                    <th style="width: 10%;">Ruang</th>
                    <th style="width: 23%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $index => $schedule)
                    @php
                        $daysIndonesia = [
                            'Monday' => 'Senin',
                            'Tuesday' => 'Selasa',
                            'Wednesday' => 'Rabu',
                            'Thursday' => 'Kamis',
                            'Friday' => 'Jumat',
                            'Saturday' => 'Sabtu'
                        ];
                        $dayName = $daysIndonesia[$schedule->day] ?? $schedule->day;
                    @endphp
                    <tr class="schedule-row" data-teacher="{{ $teacherNames[$schedule->teacher_id] ?? '' }}" data-day="{{ $schedule->day }}" data-subject="{{ strtolower($schedule->subject) }}">
                        <td>{{ ($schedules->currentPage() - 1) * $schedules->perPage() + $index + 1 }}</td>
                        <td>
                            <div class="teacher-info">
                                <span class="teacher-name">{{ $teacherNames[$schedule->teacher_id] ?? 'Guru Tidak Diketahui' }}</span>
                            </div>
                        </td>
                        <td><span class="badge-subject">{{ $schedule->subject }}</span></td>
                        <td>{{ $dayName }}</td>
                        <td>
                            <span class="time-badge">
                                {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}
                            </span>
                        </td>
                        <td>{{ $schedule->room ?? '-' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.schedule.teacher.edit', $schedule->id) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.schedule.teacher.destroy', $schedule->id) }}" method="POST" class="delete-form" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center no-data">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada jadwal guru</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($schedules->hasPages())
        <div class="pagination-container">
            {{ $schedules->links() }}
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
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.page-header h1 {
    margin: 0 0 0.5rem 0;
    color: #2c3e50;
    font-size: 1.8rem;
}

.subtitle {
    color: #7f8c8d;
    margin: 0;
    font-size: 0.95rem;
}

.btn-add-new {
    background: #3498db;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: background 0.3s;
}

.btn-add-new:hover {
    background: #2980b9;
}

.management-toolbar {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    background: white;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.search-box {
    flex: 1;
    position: relative;
    display: flex;
    align-items: center;
}

.search-box i {
    position: absolute;
    left: 1rem;
    color: #bdc3c7;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 0.95rem;
}

.filter-select {
    padding: 0.75rem 1rem;
    border: 1px solid #ddd;
    border-radius: 6px;
    background: white;
    cursor: pointer;
}

.alert {
    padding: 1rem;
    margin-bottom: 1.5rem;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    opacity: 0.7;
    margin-left: auto;
}

.table-responsive-container {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table thead {
    background: #34495e;
    color: white;
}

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

.teacher-spec {
    font-size: 0.85rem;
    color: #7f8c8d;
}

.badge-subject {
    display: inline-block;
    background: #e8f4f8;
    color: #16a085;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

.time-badge {
    display: inline-block;
    background: #fff3cd;
    color: #856404;
    padding: 0.5rem 0.75rem;
    border-radius: 4px;
    font-size: 0.9rem;
    font-weight: 500;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
}

.btn-edit {
    background: #3498db;
    color: white;
}

.btn-edit:hover {
    background: #2980b9;
    transform: translateY(-2px);
}

.btn-delete {
    background: #e74c3c;
    color: white;
}

.btn-delete:hover {
    background: #c0392b;
    transform: translateY(-2px);
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

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 1rem;
    }

    .btn-add-new {
        width: 100%;
        justify-content: center;
    }

    .management-toolbar {
        flex-direction: column;
    }

    .admin-table {
        font-size: 0.9rem;
    }

    .admin-table th,
    .admin-table td {
        padding: 0.75rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const dayFilter = document.getElementById('dayFilter');
    const rows = document.querySelectorAll('.schedule-row');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedDay = dayFilter.value;

        rows.forEach(row => {
            const teacher = row.dataset.teacher.toLowerCase();
            const day = row.dataset.day;
            const subject = row.dataset.subject;

            const matchesSearch = teacher.includes(searchTerm) || subject.includes(searchTerm);
            const matchesDay = !selectedDay || day === selectedDay;

            row.style.display = matchesSearch && matchesDay ? '' : 'none';
        });
    }

    searchInput?.addEventListener('keyup', filterTable);
    dayFilter?.addEventListener('change', filterTable);
});
</script>
@endsection
