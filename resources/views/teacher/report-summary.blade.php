@extends('teacher.layout')

@section('teacher-content')
<style>
    :root {
        --primary: #2d5016;
        --primary-light: rgba(45, 80, 22, 0.08);
        --text-primary: #1a1a1a;
        --text-secondary: #666;
        --text-muted: #999;
        --border: #e5e5e5;
        --bg-light: #f9f9f9;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
    }

    .page-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: #1f3a0d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 80, 22, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .filter-section {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .filter-group {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .form-group {
        flex: 1;
        min-width: 200px;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-primary);
        font-size: 0.9rem;
    }

    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .summary-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
    }

    .stat-card .label {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
    }

    .stat-card .value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
    }

    .students-table {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    thead th {
        background: var(--primary);
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid var(--primary);
    }

    tbody td {
        padding: 1rem;
        border-bottom: 1px solid var(--border);
    }

    tbody tr:hover {
        background-color: var(--bg-light);
    }

    .badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .average-grade {
        font-weight: 700;
        color: var(--primary);
    }

    .student-details {
        display: flex;
        gap: 0.5rem;
        flex-direction: column;
    }

    .student-name {
        font-weight: 600;
        color: var(--text-primary);
    }

    .student-meta {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .action-links {
        display: flex;
        gap: 0.5rem;
    }

    .action-links a {
        padding: 0.35rem 0.75rem;
        background: #e9ecef;
        color: var(--text-primary);
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .action-links a:hover {
        background: var(--primary);
        color: white;
    }

    .no-data-message {
        background: #f8f9fa;
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 2rem;
        text-align: center;
        color: var(--text-muted);
    }
</style>

<div style="padding: 1.5rem 2rem; max-width: 1400px; margin: 0 auto;">
    <div class="page-header">
        <div>
            <h1>📊 Laporan Ringkasan Kelas</h1>
            <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">Rekap nilai siswa per kelas dan semester</p>
        </div>
        <div class="action-buttons">
            <a href="{{ route('teacher.grades') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('teacher.report-summary') }}" id="filterForm">
            <div class="filter-group">
                <div class="form-group" style="flex: 1;">
                    <label for="class"><i class="fas fa-school"></i> Pilih Kelas</label>
                    <select name="class" id="class" required onchange="document.getElementById('filterForm').submit();">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $c)
                            <option value="{{ $c }}" @if($selectedClass === $c) selected @endif>
                                Kelas {{ $c }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    @if($selectedClass)
        <!-- Summary Statistics -->
        @if(isset($averageClass) && $averageClass !== null)
        <div class="summary-stats">
            <div class="stat-card">
                <div class="label">Total Siswa</div>
                <div class="value">{{ $students->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Rata-rata Kelas</div>
                <div class="value">{{ number_format($averageClass, 2) }}</div>
            </div>
            <div class="stat-card">
                <div class="label">Siswa Lulus</div>
                <div class="value" style="color: var(--success);">
                    {{ collect($studentSummary)->where('average', '>=', 70)->count() }}
                </div>
            </div>
            <div class="stat-card">
                <div class="label">Butuh Remediasi</div>
                <div class="value" style="color: var(--danger);">
                    {{ collect($studentSummary)->where('average', '<', 70)->count() }}
                </div>
            </div>
        </div>
        @endif

        <!-- Export Options -->
        <div style="margin-bottom: 1.5rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <a href="{{ route('teacher.export-report-excel', ['class' => $selectedClass]) }}" class="btn btn-primary">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('teacher.export-report-pdf', ['class' => $selectedClass]) }}" class="btn btn-primary">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="{{ route('teacher.export-grades-excel', ['class' => $selectedClass]) }}" class="btn btn-primary">
                <i class="fas fa-download"></i> Export Rinci
            </a>
        </div>

        <!-- Students Table -->
        @if($students->count() > 0)
        <div class="students-table">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th width="150">NISN</th>
                            <th>Nama Siswa</th>
                            <th width="100">Avg. Nilai</th>
                            <th width="80">Mapel</th>
                            <th width="120">Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($studentSummary as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['student']->nisn ?? '-' }}</td>
                            <td>
                                <div class="student-details">
                                    <span class="student-name">{{ $item['student']->user->name ?? '-' }}</span>
                                    <span class="student-meta">Kelas {{ $item['student']->class }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="average-grade">
                                    {{ number_format($item['average'], 2) }}
                                </span>
                            </td>
                            <td>{{ $item['total_subjects'] }}</td>
                            <td>
                                @if($item['average'] >= 70)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> {{ $item['status'] }}
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-exclamation-circle"></i> {{ $item['status'] }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-links">
                                    <a href="{{ route('teacher.students.show', $item['student']->id) }}">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('teacher.grades', ['student_id' => $item['student']->id]) }}">
                                        <i class="fas fa-star"></i> Nilai
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="no-data-message">
            <i class="fas fa-inbox"></i>
            <p>Tidak ada data siswa untuk kelas {{ $selectedClass }}</p>
        </div>
        @endif

    @else
        <div class="no-data-message">
            <i class="fas fa-folder-open"></i>
            <p>Pilih kelas untuk melihat laporan ringkasan</p>
        </div>
    @endif
</div>

@endsection
