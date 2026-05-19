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

    <div class="row">
        @foreach($students as $student)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow" style="transition: all 0.3s ease;">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @if($student->user->profile_photo)
                                <img src="{{ asset('storage/' . $student->user->profile_photo) }}" alt="{{ $student->user->name }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-user text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <h5 class="mb-0">{{ $student->user->name }}</h5>
                                <small class="text-muted">{{ $student->class }}</small>
                            </div>
                        </div>
                        <hr>
                        <div class="student-info mb-3">
                            <p class="mb-2">
                                <strong>NISN:</strong> {{ $student->nisn }}
                            </p>
                            <p class="mb-2">
                                <strong>Email:</strong> <small>{{ $student->user->email }}</small>
                            </p>
                            <p class="mb-2">
                                <strong>No. Telepon:</strong> {{ $student->user->phone ?? '-' }}
                            </p>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('teacher.students.show', $student->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                            <a href="{{ route('teacher.grades', ['student_id' => $student->id]) }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-star"></i> Kelola Nilai
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
            transform: translateY(-2px);
        }
    </style>
@else
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> Belum ada data siswa yang tersedia.
    </div>
@endif
@endsection
