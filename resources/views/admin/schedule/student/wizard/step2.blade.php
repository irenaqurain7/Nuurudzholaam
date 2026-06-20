@extends('layouts.admin')

@section('title', 'Wizard Jadwal Siswa - Langkah 2')
@section('page-title', 'Wizard Upload Jadwal - Langkah 2 dari 3')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Metode: {{ session('wizard_upload_method', 'bulk') == 'bulk' ? 'Bulk Upload' : 'Manual Input' }}</h5>
                    @if(session('wizard_upload_method') == 'bulk')
                        <a href="#" class="btn btn-outline-success mb-2">Download Template Excel (Template_{{ $educationLevel }}.xlsx)</a>
                        <form method="POST" action="{{ route('admin.schedule.student.wizard.step2.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Pilih berkas (.xlsx, .xls, .csv)</label>
                                <input type="file" name="file" class="form-control" required>
                            </div>
                            <button class="btn btn-success">Unggah & Parse</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.schedule.student.wizard.step2.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-2"><input name="class" class="form-control" placeholder="Kelas" required></div>
                                <div class="col-md-4 mb-2"><input name="subject" class="form-control" placeholder="Mata Pelajaran" required></div>
                                <div class="col-md-4 mb-2"><input name="teacher" class="form-control" placeholder="Guru"></div>
                                <div class="col-md-4 mb-2"><input name="day" class="form-control" placeholder="Hari (Monday)" required></div>
                                <div class="col-md-4 mb-2"><input name="start_time" class="form-control" placeholder="08:00" required></div>
                                <div class="col-md-4 mb-2"><input name="end_time" class="form-control" placeholder="09:00" required></div>
                            </div>
                            <div class="mt-2">
                                <button class="btn btn-success">Tambah Jadwal</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5>Preview Jadwal (Sementara)</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Hari</th>
                                <th>Waktu</th>
                                <th>Guru</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($previewItems as $i => $it)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $it['class'] ?? '' }}</td>
                                    <td>{{ $it['subject'] ?? '' }}</td>
                                    <td>{{ $it['day'] ?? '' }}</td>
                                    <td>{{ ($it['start_time'] ?? '') . ' - ' . ($it['end_time'] ?? '') }}</td>
                                    <td>{{ $it['teacher'] ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.schedule.student.wizard.step1') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('admin.schedule.student.wizard.step3') }}" class="btn btn-success">Lanjutkan ke Review</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6>Tips</h6>
                    <ul>
                        <li>Gunakan format template sesuai jenjang.</li>
                        <li>Kolom: Kelas, Mata Pelajaran, Hari, Jam Mulai, Jam Selesai, Guru, Ruangan</li>
                        <li>Jam gunakan format 24-jam, misal 08:00</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
