@extends('layouts.admin')

@section('title', 'Kelola Jadwal Siswa')
@section('page-title', 'Kelola Jadwal Siswa')
@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Kelola Jadwal Siswa</h1>
            <p class="subtitle">Atur jadwal pelajaran untuk setiap kelas (SD, SMP, SMA)</p>
        </div>
        <a href="{{ route('admin.schedule.student.create') }}" class="btn-add-new">
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

    <!-- Schedules Table -->
    <div class="table-responsive-container">
        <table class="admin-table" id="scheduleTable">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Kelas</th>
                    <th style="width: 20%;">Mata Pelajaran</th>
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
                        $classLevel = substr($schedule->class, 0, 1);
                    @endphp
                    <tr class="schedule-row" 
                        data-class="{{ $schedule->class }}"
                        data-day="{{ $schedule->day }}" 
                        data-subject="{{ strtolower($schedule->subject) }}"
                        data-level="{{ $classLevel }}">
                        <td>{{ ($schedules->currentPage() - 1) * $schedules->perPage() + $index + 1 }}</td>
                        <td>
                            <span class="class-badge" data-level="{{ $classLevel }}">
                                {{ $schedule->class }}
                            </span>
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
                                <a href="{{ route('admin.schedule.student.edit', $schedule->id) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.schedule.student.destroy', $schedule->id) }}" method="POST" class="delete-form" style="display: inline;">
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
                            <p>Belum ada jadwal siswa</p>
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

    <!-- Stats Box -->
    <div class="stats-container">
        <div class="stat-card">
            <i class="fas fa-calendar-check"></i>
            <div class="stat-content">
                <span class="stat-label">Total Jadwal</span>
                <span class="stat-value">{{ $schedules->total() }}</span>
            </div>
        </div>
    </div>
</div>
                        <td>{{ ($schedules->currentPage() - 1) * $schedules->perPage() + $index + 1 }}</td>
                        <td>
                            <div class="student-info">
                                <span class="student-name">{{ $schedule->student->user->name }}</span>
                                <span class="student-nisn">NISN: {{ $schedule->student->nisn }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="class-badge" data-level="{{ $classLevel }}">
                                {{ $schedule->student->class }}
                            </span>
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
                                <a href="{{ route('admin.schedule.student.edit', $schedule->id) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.schedule.student.destroy', $schedule->id) }}" method="POST" class="delete-form" style="display: inline;">
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
                        <td colspan="8" class="text-center no-data">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada jadwal siswa</p>
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

    <!-- Stats Box -->
    <div class="stats-container">
        <div class="stat-card">
            <i class="fas fa-users"></i>
            <div class="stat-content">
                <span class="stat-label">Total Jadwal</span>
                <span class="stat-value">{{ $schedules->total() }}</span>
            </div>
        </div>
    </div>
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
    flex-wrap: wrap;
}

.search-box {
    flex: 1;
    min-width: 250px;
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

.filter-group {
    display: flex;
    gap: 0.5rem;
}

.filter-select {
    padding: 0.75rem 1rem;
    border: 1px solid #ddd;
    border-radius: 6px;
    background: white;
    cursor: pointer;
    min-width: 150px;
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
    overflow-x: auto;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
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

.student-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.student-name {
    font-weight: 600;
    color: #2c3e50;
}

.student-nisn {
    font-size: 0.85rem;
    color: #7f8c8d;
}

.class-badge {
    display: inline-block;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.9rem;
    color: white;
}

.class-badge[data-level="1"],
.class-badge[data-level="2"],
.class-badge[data-level="3"] {
    background: #3498db; /* SD color */
}

.class-badge[data-level="4"],
.class-badge[data-level="5"],
.class-badge[data-level="6"] {
    background: #e67e22; /* SMP color */
}

.class-badge[data-level="7"],
.class-badge[data-level="8"],
.class-badge[data-level="9"] {
    background: #9b59b6; /* SMA color */
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
    margin: 2rem 0;
}

.stats-container {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
    margin-top: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.stat-card i {
    font-size: 2rem;
    color: #3498db;
}

.stat-content {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.stat-label {
    color: #7f8c8d;
    font-size: 0.9rem;
}

.stat-value {
    color: #2c3e50;
    font-size: 1.5rem;
    font-weight: 700;
}

@media (max-width: 1024px) {
    .management-toolbar {
        flex-direction: column;
    }

    .search-box {
        flex: 1;
    }

    .filter-group {
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
    }
}

@media (max-width: 768px) {
    .admin-page {
        padding: 1rem;
    }

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

    .search-box {
        width: 100%;
    }

    .filter-group {
        width: 100%;
        grid-template-columns: 1fr 1fr;
    }

    .admin-table th,
    .admin-table td {
        padding: 0.5rem;
        font-size: 0.85rem;
    }

    .admin-table th {
        width: auto !important;
    }
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
            const rowClass = row.dataset.class;
            const day = row.dataset.day;
            const subject = row.dataset.subject;

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
