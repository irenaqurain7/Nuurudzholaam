@extends('teacher.layout')

@section('teacher-content')
<h1 class="h2 mb-4">Kelola Nilai</h1>

<div class="row mb-4">
    <div class="col-md-12">
        <a href="{{ route('teacher.grades.edit') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Nilai Baru
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Filter Nilai</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('teacher.grades') }}" method="GET" class="row g-3">
            <div class="col-md-6">
                <label for="student_id" class="form-label">Pilih Siswa</label>
                <select class="form-select" id="student_id" name="student_id">
                    <option value="">Semua Siswa</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" @if($selectedStudent == $student->id) selected @endif>
                            {{ $student->user->name }} ({{ $student->class }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Daftar Nilai</h5>
    </div>
    <div class="card-body">
        @if($grades->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Mata Pelajaran</th>
                            <th>Nilai</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                            <tr>
                                <td>{{ $grade->student->user->name }}</td>
                                <td>{{ $grade->subject }}</td>
                                <td>
                                    <span class="badge bg-{{ $grade->grade >= 70 ? 'success' : 'warning' }}">
                                        {{ number_format($grade->grade, 2) }}
                                    </span>
                                </td>
                                <td>{{ $grade->notes ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('teacher.grades.edit', $grade->id) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('teacher.grades.delete', $grade->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Belum ada data nilai yang tersedia.
            </div>
        @endif
    </div>
</div>
@endsection
