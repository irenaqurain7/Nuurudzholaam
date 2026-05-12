@extends('teacher.layout')

@section('teacher-content')
<h1 class="h2 mb-4">Profil Saya</h1>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h5 class="mb-0">Data Pribadi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('teacher.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ auth()->user()->name }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="{{ auth()->user()->email }}" disabled>
                        <small class="text-muted">Email tidak dapat diubah</small>
                    </div>

                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" value="{{ auth()->user()->nip ?? '-' }}" disabled>
                        <small class="text-muted">NIP tidak dapat diubah</small>
                    </div>

                    <div class="mb-3">
                        <label for="specialization" class="form-label">Bidang Keahlian</label>
                        <input type="text" class="form-control" id="specialization" value="{{ auth()->user()->teacher->specialization ?? '-' }}" disabled>
                        <small class="text-muted">Bidang keahlian tidak dapat diubah</small>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ auth()->user()->phone }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ auth()->user()->address }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Biodata Singkat</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3">{{ auth()->user()->bio }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Profile Photo -->
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h5 class="mb-0">Foto Profil</h5>
            </div>
            <div class="card-body text-center">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="img-fluid rounded" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                @else
                    <div class="bg-light p-5 rounded">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                @endif
                <div class="mt-3">
                    <a href="{{ route('teacher.upload-photo') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-upload"></i> Ubah Foto
                    </a>
                </div>
            </div>
        </div>

        <!-- Security -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Keamanan</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Kelola keamanan akun Anda</p>
                <a href="{{ route('teacher.change-password') }}" class="btn btn-outline-secondary btn-sm w-100">
                    <i class="fas fa-key"></i> Ubah Password
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
