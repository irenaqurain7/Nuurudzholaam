@extends('teacher.layout')

@section('teacher-content')
<h1 class="h2 mb-4">Profil Saya</h1>

<div class="row">
    <!-- Profile Photo -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-image"></i> Foto Profil</h5>
            </div>
            <div class="card-body text-center">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="img-fluid rounded mb-3" style="max-width: 100%; max-height: 250px; object-fit: cover;">
                @else
                    <div class="bg-light p-5 rounded mb-3">
                        <i class="fas fa-user-circle fa-5x text-muted"></i>
                    </div>
                @endif
                <div>
                    <a href="{{ route('teacher.upload-photo') }}" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-upload"></i> Ubah Foto
                    </a>
                </div>
            </div>
        </div>

        <!-- Security Card -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-lock"></i> Keamanan</h5>
            </div>
            <div class="card-body">
                <p class="mb-3 text-muted">Kelola keamanan akun Anda</p>
                <a href="{{ route('teacher.change-password') }}" class="btn btn-warning btn-sm w-100">
                    <i class="fas fa-key"></i> Ubah Password
                </a>
            </div>
        </div>
    </div>

    <!-- Profile Data -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-user"></i> Data Pribadi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('teacher.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Lengkap -->
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" name="name" value="{{ auth()->user()->name }}" required>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control form-control-lg" id="email" value="{{ auth()->user()->email }}" disabled>
                        <small class="text-muted">Email tidak dapat diubah</small>
                    </div>

                    <!-- NIP -->
                    <div class="mb-4">
                        <label for="nip" class="form-label fw-bold">NIP</label>
                        <input type="text" class="form-control form-control-lg" id="nip" value="{{ auth()->user()->nip ?? '-' }}" disabled>
                        <small class="text-muted">Nomor Induk Pegawai tidak dapat diubah</small>
                    </div>

                    <!-- Bidang Keahlian -->
                    <div class="mb-4">
                        <label for="specialization" class="form-label fw-bold">Bidang Keahlian</label>
                        <input type="text" class="form-control form-control-lg" id="specialization" value="{{ auth()->user()->teacher->specialization ?? '-' }}" disabled>
                        <small class="text-muted">Bidang keahlian tidak dapat diubah</small>
                    </div>

                    <!-- No. Telepon -->
                    <div class="mb-4">
                        <label for="phone" class="form-label fw-bold">No. Telepon</label>
                        <input type="text" class="form-control form-control-lg @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Contoh: 08123456789" value="{{ auth()->user()->phone }}">
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="mb-4">
                        <label for="address" class="form-label fw-bold">Alamat</label>
                        <textarea class="form-control form-control-lg @error('address') is-invalid @enderror" id="address" name="address" rows="3" placeholder="Masukkan alamat lengkap Anda">{{ auth()->user()->address }}</textarea>
                        @error('address')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Biodata Singkat -->
                    <div class="mb-4">
                        <label for="bio" class="form-label fw-bold">Biodata Singkat</label>
                        <textarea class="form-control form-control-lg @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3" placeholder="Ceritakan tentang diri Anda secara singkat...">{{ auth()->user()->bio }}</textarea>
                        <small class="text-muted">Opsional - untuk profil publik Anda</small>
                        @error('bio')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
