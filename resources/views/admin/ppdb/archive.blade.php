@extends('layouts.admin')

@section('title', 'Arsip PPDB')

@section('content')
<div class="ppdb-page">
    <section class="ppdb-hero">
        <div>
            <p class="ppdb-kicker">Arsip</p>
            <h1>Arsip PPDB</h1>
            <p class="ppdb-subtitle">Lihat data pendaftar yang telah diarsipkan berdasarkan tahun ajaran.</p>
        </div>
    </section>

    <div class="ppdb-panel">
        <div class="panel-header">
            <div>
                <p class="panel-kicker">Arsip PPDB</p>
                <h2>Data Arsip</h2>
            </div>
            <div class="panel-meta">
                <span>{{ $registrations->count() }} ditampilkan</span>
                <span>{{ $registrations->total() }} total arsip</span>
            </div>
        </div>

        @if($registrations->count() > 0)
            <div class="table-wrap">
                <table class="ppdb-table">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Jenjang</th>
                            <th>Email</th>
                            <th>No Telepon</th>
                            <th>Tahun Arsip</th>
                            <th class="action-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $reg)
                        <tr>
                            <td>{{ $reg->nama_lengkap }}</td>
                            <td>{{ strtoupper($reg->jenjang) }}</td>
                            <td>{{ $reg->email }}</td>
                            <td>{{ $reg->no_telepon }}</td>
                            <td>{{ $reg->archive_year ?? '—' }}</td>
                            <td>
                                <form action="{{ route('admin.ppdb.restore', $reg->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn-action-list" onclick="return confirm('Kembalikan data pendaftar ini?')">
                                        <i class="fas fa-undo"></i> Pulihkan
                                    </button>
                                </form>
                                <a href="{{ route('admin.ppdb.show', $reg->id) }}" class="btn-action-list">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $registrations->links('partials.pagination') }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-archive"></i>
                </div>
                <p class="empty-state-text">Belum ada arsip PPDB</p>
            </div>
        @endif
    </div>
</div>
@endsection
