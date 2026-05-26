@extends('teacher.layout')

@section('teacher-content')
<h1 class="h2 mb-4">Data Siswa Saya</h1>

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

    @foreach($studentsByClass as $className => $classStudents)
        <div class="card mb-4 border-0 shadow-sm class-group-card">
            <div class="card-header bg-light border-0 class-group-header">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-1"></i>Daftar Siswa Kelas {{ $className }}
                    </h5>
                    <span class="badge bg-success-subtle text-success-emphasis">{{ $classStudents->count() }} siswa</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive class-student-scroll">
                    <table class="table table-hover align-middle mb-0 class-student-table">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Siswa</th>
                                <th>NISN</th>
                                <th>Kelas</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classStudents as $student)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $student->user->name }}</div>
                                    </td>
                                    <td>{{ $student->nisn }}</td>
                                    <td>{{ $student->class }}</td>
                                    <td class="text-end">
                                        <div class="d-inline-flex flex-wrap gap-2 justify-content-end">
                                            <a href="{{ route('teacher.students.show', $student->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye me-1"></i>Lihat Detail
                                            </a>
                                            <a href="{{ route('teacher.grades', ['student_id' => $student->id]) }}" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-star me-1"></i>Kelola Nilai
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

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
            max-height: clamp(280px, 45vh, 420px);
            overflow: auto;
            border-top: 1px solid #e9ecef;
        }

        .class-student-table {
            width: 100%;
            min-width: 860px;
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

        .class-student-table td:nth-child(1),
        .class-student-table th:nth-child(1) {
            min-width: 220px;
        }

        .class-student-table td:nth-child(2),
        .class-student-table th:nth-child(2) {
            min-width: 120px;
        }

        .class-student-table td:nth-child(3),
        .class-student-table th:nth-child(3) {
            min-width: 110px;
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
        <i class="fas fa-info-circle"></i> Belum ada data siswa yang tersedia.
    </div>
@endif
@endsection
