@extends('student.layout')

@section('student-content')
<h1 class="h2 mb-4">Nilai Saya</h1>

<div class="card">
    <div class="card-body">
        @if($grades->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                            <th>Nilai</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                            <tr>
                                <td>{{ $grade->subject }}</td>
                                <td>{{ $grade->teacher->user->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $grade->grade >= 70 ? 'success' : 'warning' }}">
                                        {{ number_format($grade->grade, 2) }}
                                    </span>
                                </td>
                                <td>{{ $grade->notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Belum ada nilai yang tersedia.
            </div>
        @endif
    </div>
</div>
@endsection
