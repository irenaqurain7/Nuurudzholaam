@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h2 mb-4">Edit User</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required onchange="toggleRoleFields()">
                                <option value="siswa" {{ old('role', $user->role) === 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="guru" {{ old('role', $user->role) === 'guru' ? 'selected' : '' }}>Guru</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row" id="student-fields" style="display: none;">
                        <div class="col-md-6 mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ old('nisn', $user->nisn) }}">
                            @error('nisn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="class" class="form-label">Kelas</label>
                            <input type="text" class="form-control @error('class') is-invalid @enderror" id="class" name="class" value="{{ old('class', $user->class) }}">
                            @error('class')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row" id="teacher-fields" style="display: none;">
                        <div class="col-md-6 mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip', $user->nip) }}">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="specialization" class="form-label">Bidang Keahlian</label>
                            <input type="text" class="form-control @error('specialization') is-invalid @enderror" id="specialization" name="specialization" value="{{ old('specialization', $user->specialization) }}">
                            @error('specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Akun aktif</label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleRoleFields() {
        const role = document.getElementById('role').value;
        const studentFields = document.getElementById('student-fields');
        const teacherFields = document.getElementById('teacher-fields');

        if (role === 'siswa') {
            studentFields.style.display = 'flex';
            teacherFields.style.display = 'none';
        } else if (role === 'guru') {
            studentFields.style.display = 'none';
            teacherFields.style.display = 'flex';
        } else {
            studentFields.style.display = 'none';
            teacherFields.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', toggleRoleFields);
</script>
@endsection
