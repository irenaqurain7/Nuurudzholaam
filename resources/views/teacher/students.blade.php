@extends('teacher.layout')

@section('teacher-content')
<h1 class="h2 mb-4">Data Siswa Saya</h1>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Siswa yang Diajar</h5>
    </div>
    <div class="card-body">
        @if($students->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->nisn }}</td>
                                <td>{{ $student->user->name }}</td>
                                <td>{{ $student->class }}</td>
                                <td>{{ $student->user->email }}</td>
                                <td>{{ $student->user->phone ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('teacher.grades', ['student_id' => $student->id]) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-star"></i> Nilai
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Belum ada data siswa yang tersedia.
            </div>
        @endif
    </div>
</div>
@endsection
