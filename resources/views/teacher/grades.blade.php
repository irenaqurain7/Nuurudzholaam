@extends('teacher.layout')

@section('teacher-content')
<h1 class="h2 mb-4">Kelola Nilai Siswa</h1>

<div class="row mb-4">
    <div class="col-md-12">
        <a href="{{ route('teacher.grades.edit') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Nilai Baru
        </a>
    </div>
</div>

<!-- Filter Card -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Nilai</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('teacher.grades') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-8">
                    <label for="student_id" class="form-label">Pilih Siswa</label>
                    <select class="form-select" id="student_id" name="student_id" onchange="this.form.submit()">
                        <option value="">-- Semua Siswa --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" @if($selectedStudent == $student->id) selected @endif>
                                {{ $student->user->name }} ({{ $student->class }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Grades Table -->
<div class="card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-star"></i> 
            @if($selectedStudent)
                Nilai Siswa - Total: <strong>{{ $grades->count() }}</strong>
            @else
                Semua Nilai - Total: <strong>{{ $grades->count() }}</strong>
            @endif
        </h5>
        @if($grades->count() > 0)
            <small class="text-muted">Rata-rata: <strong>{{ number_format($grades->avg('grade'), 2) }}</strong></small>
        @endif
    </div>
    <div class="card-body">
        @if($grades->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Nilai</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                            <tr>
                                <td>
                                    <strong>{{ $grade->student->user->name }}</strong>
                                </td>
                                <td>{{ $grade->student->class }}</td>
                                <td>{{ $grade->subject }}</td>
                                <td>
                                    <span class="badge bg-{{ $grade->grade >= 75 ? 'success' : ($grade->grade >= 70 ? 'warning' : ($grade->grade >= 60 ? 'info' : 'danger')) }} fs-6">
                                        {{ number_format($grade->grade, 2) }}
                                    </span>
                                </td>
                                <td>
                                    @if($grade->notes)
                                        <small>{{ substr($grade->notes, 0, 30) }}{{ strlen($grade->notes) > 30 ? '...' : '' }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><small class="text-muted">{{ $grade->created_at->format('d M Y') }}</small></td>
                                <td>
                                    <a href="{{ route('teacher.grades.edit', $grade->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('teacher.grades.delete', $grade->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus nilai ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info mb-0">
                <i class="fas fa-info-circle"></i> Belum ada data nilai yang tersedia.
            </div>
        @endif
    </div>
</div>
@endsection
