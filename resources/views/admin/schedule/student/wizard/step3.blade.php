@extends('layouts.admin')

@section('title', 'Wizard Jadwal Siswa - Langkah 3')
@section('page-title', 'Wizard Upload Jadwal - Langkah 3 dari 3')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Ringkasan Import</h5>
                    @php
                        $total = count($validation);
                        $valid = collect($validation)->where('status','valid')->count();
                        $conflicts = $total - $valid;
                    @endphp
                    <div class="d-flex gap-3">
                        <div class="p-3 bg-white border rounded" style="flex:1">
                            <div>Total Rekaman</div>
                            <div class="h4">{{ $total }}</div>
                        </div>
                        <div class="p-3 bg-white border rounded" style="flex:1">
                            <div>Data Valid</div>
                            <div class="h4 text-success">{{ $valid }}</div>
                        </div>
                        <div class="p-3 bg-white border rounded" style="flex:1">
                            <div>Konflik Terdeteksi</div>
                            <div class="h4 text-danger">{{ $conflicts }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5>Detail Rekaman</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Waktu</th>
                                <th>Pengajar</th>
                                <th>Ruangan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($validation as $i => $row)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $row['class'] ?? '' }}</td>
                                    <td>{{ $row['subject'] ?? '' }}</td>
                                    <td>{{ ($row['start_time'] ?? '') . ' - ' . ($row['end_time'] ?? '') }}</td>
                                    <td>{{ $row['teacher'] ?? '' }}</td>
                                    <td>{{ $row['room'] ?? '' }}</td>
                                    <td>
                                        @if($row['status'] === 'valid')
                                            <span class="badge bg-success">Valid</span>
                                        @else
                                            <span class="badge bg-danger">Konflik</span>
                                            <div style="font-size:0.8rem">{{ implode('; ', $row['reasons'] ?? []) }}</div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <form method="POST" action="{{ route('admin.schedule.student.wizard.publish') }}">
                        @csrf
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.schedule.student.wizard.step2') }}" class="btn btn-secondary">Kembali</a>
                            <div>
                                <a href="{{ route('admin.schedule.student.wizard.step2') }}" class="btn btn-outline-secondary">Unggah Ulang Berkas</a>
                                <button class="btn btn-success">Publikasikan Jadwal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-2">
                <div class="card-body">
                    <h6>Tips Resolusi</h6>
                    <ul>
                        <li><strong>Jadwal Pengajar Ganda:</strong> Guru digunakan di dua kelas pada jam yang sama.</li>
                        <li><strong>Bentrok Waktu Kelas:</strong> Satu kelas memiliki dua mata pelajaran pada jam yang sama.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
