@extends('layouts.admin')

@section('title', 'Kelola Program')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0; color: var(--hijau-islam);">Kelola Program</h1>
    <a href="{{ route('admin.program.create') }}" class="admin-btn" style="text-decoration: none; background-color: #28a745;">
        <i class="fas fa-plus"></i> Tambah Program
    </a>
</div>

<div style="background: white; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); overflow: hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Program</th>
                <th>Kuota</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($programs as $program)
            <tr>
                <td>{{ ($programs->currentPage() - 1) * $programs->perPage() + $loop->iteration }}</td>
                <td><strong>{{ $program->nama_program }}</strong></td>
                <td><span class="badge">{{ $program->kuota }} siswa</span></td>
                <td>{{ Str::limit($program->deskripsi, 50) }}</td>
                <td>
                    <div class="admin-btn-group">
                        <a href="{{ route('admin.program.edit', $program->id) }}" class="admin-btn" style="text-decoration: none;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.program.destroy', $program->id) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-light);">
                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                    <p>Belum ada program</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $programs->links() }}
</div>

<style>
    .badge {
        display: inline-block;
        padding: 4px 8px;
        background-color: var(--hijau-islam-lighter);
        color: white;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }
</style>
@endsection
