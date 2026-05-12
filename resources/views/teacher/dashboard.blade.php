@extends('teacher.layout')

@section('teacher-content')
<div class="row">
    <div class="col-md-12">
        <h1 class="h2 mb-4">Selamat Datang, {{ auth()->user()->name }}!</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h6 class="card-title">Total Siswa</h6>
                <p class="card-text fs-3">{{ $totalStudents }}</p>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('teacher.students') }}" class="text-white text-decoration-none">Lihat Siswa →</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h6 class="card-title">Total Kelas</h6>
                <p class="card-text fs-3">{{ $totalClasses }}</p>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('teacher.grades') }}" class="text-white text-decoration-none">Lihat Nilai →</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h6 class="card-title">Jadwal Mengajar</h6>
                <p class="card-text fs-5">
                    <i class="fas fa-calendar"></i>
                </p>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('teacher.schedule') }}" class="text-white text-decoration-none">Lihat Jadwal →</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h6 class="card-title">Profil</h6>
                <p class="card-text fs-5">
                    <i class="fas fa-user"></i>
                </p>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('teacher.profile') }}" class="text-dark text-decoration-none">Lihat Profil →</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('teacher.grades.edit') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Nilai Baru
                    </a>
                    <a href="{{ route('teacher.grades') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list"></i> Kelola Semua Nilai
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Informasi Profil</h5>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>NIP:</strong> {{ auth()->user()->nip ?? '-' }}</p>
                <p><strong>Bidang Keahlian:</strong> {{ auth()->user()->teacher->specialization ?? '-' }}</p>
                <a href="{{ route('teacher.profile') }}" class="btn btn-primary btn-sm">Edit Profil</a>
            </div>
        </div>
    </div>
</div>
@endsection
