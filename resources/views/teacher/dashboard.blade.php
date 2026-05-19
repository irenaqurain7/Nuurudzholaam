@extends('teacher.layout')

@section('teacher-content')
<!-- Welcome Section -->
<div class="row mb-5">
    <div class="col-md-12">
        <div class="card bg-gradient border-0 shadow-sm" style="background: linear-gradient(135deg, #2D4438 0%, #709D88 100%);">
            <div class="card-body text-white p-5">
                <h1 class="h2 mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                <p class="mb-0 opacity-75">Kelola siswa, nilai, dan jadwal mengajar Anda dengan mudah</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted small mb-1">Total Siswa</h6>
                        <h2 class="mb-0 text-primary">{{ $totalStudents }}</h2>
                    </div>
                    <div class="text-primary" style="font-size: 2rem;">
                        <i class="fas fa-users opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-top-0">
                <a href="{{ route('teacher.students') }}" class="text-decoration-none small">
                    Lihat semua siswa <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted small mb-1">Mata Pelajaran</h6>
                        <h2 class="mb-0 text-success">{{ $totalClasses }}</h2>
                    </div>
                    <div class="text-success" style="font-size: 2rem;">
                        <i class="fas fa-book opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-top-0">
                <a href="{{ route('teacher.grades') }}" class="text-decoration-none small">
                    Kelola nilai <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted small mb-1">Jadwal Mengajar</h6>
                        <h2 class="mb-0 text-info">📅</h2>
                    </div>
                    <div class="text-info" style="font-size: 2rem;">
                        <i class="fas fa-calendar opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-top-0">
                <a href="{{ route('teacher.schedule') }}" class="text-decoration-none small">
                    Lihat jadwal <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted small mb-1">Profil Saya</h6>
                        <h2 class="mb-0 text-warning">👤</h2>
                    </div>
                    <div class="text-warning" style="font-size: 2rem;">
                        <i class="fas fa-user-circle opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-top-0">
                <a href="{{ route('teacher.profile') }}" class="text-decoration-none small">
                    Kelola profil <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row">
    <!-- Quick Actions -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-bolt text-warning"></i> Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('teacher.grades.edit') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle"></i> Tambah Nilai Baru
                    </a>
                    <a href="{{ route('teacher.students') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list"></i> Lihat Daftar Siswa
                    </a>
                    <a href="{{ route('teacher.grades') }}" class="btn btn-outline-success">
                        <i class="fas fa-star"></i> Kelola Nilai
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Info -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-user text-primary"></i> Informasi Profil</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 py-2">
                        <small class="text-muted">Nama Lengkap</small>
                        <p class="mb-0 fw-bold">{{ auth()->user()->name }}</p>
                    </div>
                    <div class="list-group-item px-0 py-2">
                        <small class="text-muted">Email</small>
                        <p class="mb-0">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="list-group-item px-0 py-2">
                        <small class="text-muted">NIP</small>
                        <p class="mb-0 fw-bold">{{ auth()->user()->nip ?? '-' }}</p>
                    </div>
                    <div class="list-group-item px-0 py-2">
                        <small class="text-muted">Bidang Keahlian</small>
                        <p class="mb-0">{{ auth()->user()->teacher->specialization ?? '-' }}</p>
                    </div>
                </div>
                <a href="{{ route('teacher.profile') }}" class="btn btn-outline-primary btn-sm mt-3 w-100">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-lift {
        transition: all 0.3s ease;
    }
    .hover-lift:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-4px);
    }
    .bg-gradient {
        background: linear-gradient(135deg, #2D4438 0%, #709D88 100%);
    }
</style>
@endsection
