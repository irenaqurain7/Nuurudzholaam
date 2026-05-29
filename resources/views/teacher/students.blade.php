@extends('teacher.layout')

@section('teacher-content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <h1 class="h2 mb-0">Data Siswa Saya</h1>
</div>

<!-- Search Box -->
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('teacher.students') }}" class="d-flex gap-2 flex-wrap align-items-center">
            <div class="flex-grow-1" style="min-width: 250px;">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input 
                        type="text" 
                        class="form-control border-start-0 ps-0" 
                        name="search" 
                        placeholder="Cari berdasarkan nama atau NISN..." 
                        value="{{ $search }}"
                    >
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search me-1"></i>Cari
            </button>
            @if($search)
                <a href="{{ route('teacher.students') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>Reset
                </a>
            @endif
        </form>
        @if($search)
            <div class="mt-3">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Hasil pencarian untuk: <strong>"{{ $search }}"</strong> - Ditemukan <strong>{{ $students->count() }}</strong> siswa
                </small>
            </div>
        @endif
    </div>
</div>

@if($students->count() > 0)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-users"></i> Total Siswa: <strong>{{ $students->count() }}</strong>
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 border-0 shadow-sm class-group-card">
        <div class="card-header bg-light border-0 class-group-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="mb-0">
                    <i class="fas fa-users me-1"></i>Daftar Siswa per Kelas
                </h5>
                <span class="badge bg-success-subtle text-success-emphasis">{{ $students->count() }} siswa</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive class-student-scroll">
                <table class="table table-hover align-middle mb-0 class-student-table">
                    <thead class="table-light">
                        <tr>
                            <th class="col-class-name">Kelas</th>
                            <th>Nama Siswa</th>
                            <th class="col-nisn">NISN</th>
                            <th class="text-end col-actions">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($studentsByClass as $className => $classStudents)
                            <tr class="class-divider-row">
                                <td colspan="4">
                                    <div class="class-divider">
                                        <span>Kelas {{ $className }}</span>
                                        <strong>{{ $classStudents->count() }} siswa</strong>
                                    </div>
                                </td>
                            </tr>
                            @foreach($classStudents as $student)
                                <tr>
                                    <td class="text-muted fw-semibold">{{ $student->class }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $student->user->name }}</div>
                                    </td>
                                    <td>{{ $student->nisn }}</td>
                                    <td class="text-end">
                                        <div class="d-inline-flex flex-wrap gap-2 justify-content-end">
                                            <a href="{{ route('teacher.students.show', $student->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye me-1"></i>Lihat Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
            transform: translateY(-2px);
        }

        .class-group-card {
            overflow: hidden;
        }

        .class-group-header {
            padding: 1rem 1.25rem;
        }

        .class-student-scroll {
            max-height: clamp(320px, 60vh, 620px);
            overflow: auto;
            border-top: 1px solid #e9ecef;
        }

        .class-student-table {
            width: 100%;
            min-width: 900px;
            table-layout: fixed;
        }

        .class-student-table th,
        .class-student-table td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
        }

        .class-student-table thead th {
            position: sticky;
            top: 0;
            z-index: 1;
            background: #f8f9fa;
            box-shadow: inset 0 -1px 0 #e9ecef;
        }

        .class-divider-row td {
            padding: 0;
            border: 0;
        }

        .class-divider {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: .8rem 1.25rem;
            background: linear-gradient(90deg, rgba(45, 68, 56, 0.08), rgba(45, 68, 56, 0.03));
            color: #21312a;
            font-weight: 700;
            border-top: 1px solid #e9ecef;
            border-bottom: 1px solid #e9ecef;
        }

        .class-divider strong {
            color: var(--hijau-islam);
        }

        .col-class-name {
            width: 120px;
        }

        .class-student-table td:nth-child(1),
        .class-student-table th:nth-child(1) {
            min-width: 120px;
        }

        .class-student-table td:nth-child(2),
        .class-student-table th:nth-child(2) {
            min-width: 260px;
        }

        .class-student-table td:nth-child(3),
        .class-student-table th:nth-child(3) {
            min-width: 130px;
        }

        .class-student-table td:nth-child(4),
        .class-student-table th:nth-child(4) {
            min-width: 240px;
        }

        .class-student-table td:nth-child(1) {
            word-break: break-word;
        }

        .class-student-table td:nth-child(4) .btn {
            white-space: nowrap;
        }
    </style>
@else
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        @if($search)
            Tidak ada siswa yang cocok dengan pencarian "<strong>{{ $search }}</strong>". 
            <a href="{{ route('teacher.students') }}">Tampilkan semua siswa</a>
        @else
            Belum ada data siswa yang tersedia.
        @endif
    </div>
@endif
@endsection
