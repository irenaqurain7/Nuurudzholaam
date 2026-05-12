@extends('teacher.layout')

@section('teacher-content')
<h1 class="h2 mb-4">Jadwal Mengajar</h1>

<div class="card">
    <div class="card-body">
        @if($schedules->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Mata Pelajaran</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Ruangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                            <tr>
                                <td>
                                    <span class="badge bg-primary">{{ $schedule->day }}</span>
                                </td>
                                <td>{{ $schedule->subject }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('H:i') }}</td>
                                <td>{{ $schedule->room ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Belum ada jadwal mengajar yang tersedia.
            </div>
        @endif
    </div>
</div>
@endsection
