@extends('student.layout')

@section('student-content')
<div class="row">
    <div class="col-md-12">
        <h1 class="h2 mb-4">Selamat Datang, {{ auth()->user()->name }}!</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h6 class="card-title">Jadwal Sekolah</h6>
                <p class="card-text fs-5">
                    <i class="fas fa-calendar"></i>
                </p>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('student.schedule') }}" class="text-white text-decoration-none">Lihat Jadwal →</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h6 class="card-title">Nilai Saya</h6>
                <p class="card-text fs-5">
                    <i class="fas fa-star"></i>
                </p>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('student.grades') }}" class="text-white text-decoration-none">Lihat Nilai →</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h6 class="card-title">Data Saya</h6>
                <p class="card-text fs-5">
                    <i class="fas fa-user"></i>
                </p>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('student.profile') }}" class="text-white text-decoration-none">Lihat Data →</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h6 class="card-title">Keamanan</h6>
                <p class="card-text fs-5">
                    <i class="fas fa-lock"></i>
                </p>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('student.change-password') }}" class="text-dark text-decoration-none">Ubah Password →</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Informasi Profil</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p><strong>NISN:</strong> {{ auth()->user()->nisn ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Kelas:</strong> {{ auth()->user()->class ?? '-' }}</p>
                        <p><strong>No. Telepon:</strong> {{ auth()->user()->phone ?? '-' }}</p>
                        <p><strong>Alamat:</strong> {{ auth()->user()->address ?? '-' }}</p>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('student.profile') }}" class="btn btn-primary btn-sm">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
