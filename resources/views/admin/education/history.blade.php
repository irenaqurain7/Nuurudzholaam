@extends('layouts.admin')

@section('title', 'Riwayat Pendidikan')@section('page-title', 'Riwayat Pendidikan')
@section('content')
<div class="admin-page">
    <div class="page-header" style="margin-bottom:18px;">
        <div>
            <h1>Riwayat Pendidikan: {{ $user->name }}</h1>
            <p class="subtitle">Perjalanan pendidikan siswa per tahun ajaran</p>
        </div>
        <div>
            <a href="{{ route('admin.users.index') }}" class="admin-btn secondary">Kembali</a>
        </div>
    </div>

    <div class="card" style="padding:18px;">
        @if($histories->isEmpty())
            <p>Tidak ada riwayat pendidikan tercatat untuk siswa ini.</p>
        @else
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Tahun Ajaran</th>
                        <th>Jenjang</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Diproses Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $h)
                    <tr>
                        <td>{{ $h->academic_year }}</td>
                        <td>{{ $h->jenjang }}</td>
                        <td>{{ $h->class ?? '—' }}</td>
                        <td>{{ $h->status }}</td>
                        <td style="white-space:pre-wrap;">{{ $h->note }}</td>
                        <td>{{ $h->processor ? $h->processor->name : '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection
