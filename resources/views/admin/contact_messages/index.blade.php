@extends('layouts.admin')

@section('title', 'Pesan Kontak')@section('page-title', 'Pesan Kontak')
@section('content')
<div class="admin-page">
    <div class="page-header" style="margin-bottom:18px;">
        <div>
            <h1>Pesan Kontak Masuk</h1>
            <p class="subtitle">Daftar pesan yang dikirim melalui formulir Kontak</p>
        </div>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:18px;">
        <form method="GET" action="{{ route('admin.contact-messages.index') }}" style="flex:1; max-width:520px;">
            <div style="position:relative;">
                <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--text-muted);"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, subjek atau isi pesan..." style="width:100%; padding:10px 12px 10px 38px; border:1px solid var(--border-color); border-radius:8px;">
            </div>
        </form>
        <div>
            <a href="{{ route('admin.contact-messages.index') }}" class="admin-btn secondary">Reset</a>
        </div>
    </div>

    <div class="card" style="padding:0; overflow:hidden;">
        <table class="admin-table" style="width:100%;">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Subjek</th>
                    <th>Tanggal</th>
                    <th style="width:170px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $m)
                <tr>
                    <td>{{ $m->nama }}</td>
                    <td>{{ $m->email }}</td>
                    <td>{{ $m->subjek }}</td>
                    <td>{{ $m->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <div class="admin-btn-group">
                            <a href="{{ route('admin.contact-messages.show', $m->id) }}" class="admin-btn">Lihat</a>
                            <form action="{{ route('admin.contact-messages.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:30px;">Belum ada pesan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper" style="margin-top:18px;">
        {{ $messages->links() }}
    </div>
</div>

@endsection
