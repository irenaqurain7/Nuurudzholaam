@extends('teacher.layout')

@section('teacher-content')
<div class="row mb-4">
    <div class="col-md-12">
        <a href="{{ route('teacher.students') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- Student Info -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informasi Siswa</h5>
            </div>
            <div class="card-body text-center">
                @if($student->user->profile_photo)
                    <img src="{{ asset('storage/' . $student->user->profile_photo) }}" alt="{{ $student->user->name }}" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                @else
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px;">
                        <i class="fas fa-user fa-3x text-muted"></i>
                    </div>
                @endif
                <h5 class="card-title">{{ $student->user->name }}</h5>
                <p class="text-muted">{{ $student->class }}</p>
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item">
                    <small class="text-muted">NISN</small>
                    <p class="mb-0 fw-bold">{{ $student->nisn }}</p>
                </div>
                <div class="list-group-item">
                    <small class="text-muted">Email</small>
                    <p class="mb-0">{{ $student->user->email }}</p>
                </div>
                <div class="list-group-item">
                    <small class="text-muted">No. Telepon</small>
                    <p class="mb-0">{{ $student->user->phone ?? '-' }}</p>
                </div>
                <div class="list-group-item">
                    <small class="text-muted">Alamat</small>
                    <p class="mb-0">{{ $student->user->address ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Grades -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Nilai Siswa</h5>
                <a href="{{ route('teacher.grades.edit', '?student_id=' . $student->id) }}" class="btn btn-sm btn-light">
                    <i class="fas fa-plus"></i> Tambah Nilai
                </a>
            </div>
            <div class="card-body">
                @if($grades->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
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
                                            <strong>{{ $grade->subject }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $grade->grade >= 75 ? 'success' : ($grade->grade >= 70 ? 'warning' : 'danger') }}">
                                                {{ number_format($grade->grade, 2) }}
                                            </span>
                                        </td>
                                        <td>{{ $grade->notes ?? '-' }}</td>
                                        <td><small class="text-muted">{{ $grade->created_at->format('d M Y') }}</small></td>
                                        <td>
                                            <a href="{{ route('teacher.grades.edit', $grade->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('teacher.grades.delete', $grade->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Grade Statistics -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="alert alert-info mb-0">
                                <strong>Rata-rata Nilai:</strong> {{ number_format($grades->avg('grade'), 2) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-info mb-0">
                                <strong>Total Mata Pelajaran:</strong> {{ $grades->count() }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle"></i> Belum ada nilai yang tersedia untuk siswa ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
