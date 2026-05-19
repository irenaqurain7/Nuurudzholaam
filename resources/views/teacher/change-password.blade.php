@extends('teacher.layout')

@section('teacher-content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-key"></i> Ubah Password</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('teacher.change-password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div class="mb-4">
                        <label for="current_password" class="form-label fw-bold">Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-lg @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" required>
                        <small class="text-muted">Minimal 8 karakter</small>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Requirements -->
                    <div class="alert alert-info" role="alert">
                        <h6 class="alert-heading"><i class="fas fa-lightbulb"></i> Persyaratan Password</h6>
                        <ul class="mb-0 ms-2 small">
                            <li>Minimal 8 karakter</li>
                            <li>Harus berbeda dengan password lama</li>
                            <li>Kedua password harus sama</li>
                        </ul>
                    </div>

                    <!-- Buttons -->
                    <div class="d-grid gap-2 gap-md-2">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="fas fa-save"></i> Ubah Password
                        </button>
                        <a href="{{ route('teacher.profile') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
