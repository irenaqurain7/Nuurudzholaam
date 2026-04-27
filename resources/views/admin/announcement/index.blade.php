@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0; color: var(--hijau-islam);">Kelola Pengumuman</h1>
    <a href="{{ route('admin.announcement.create') }}" class="admin-btn" style="text-decoration: none; background-color: #28a745;">
        <i class="fas fa-plus"></i> Tambah Pengumuman
    </a>
</div>

<div style="background: white; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); overflow: hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Tipe</th>
                <th>Tgl Mulai</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($announcements as $announcement)
            <tr>
                <td>{{ ($announcements->currentPage() - 1) * $announcements->perPage() + $loop->iteration }}</td>
                <td><strong>{{ Str::limit($announcement->judul, 40) }}</strong></td>
                <td><span class="badge">{{ ucfirst($announcement->tipe) }}</span></td>
                <td>{{ $announcement->tanggal_mulai->format('d M Y') }}</td>
                <td>
                    <span style="display: inline-block; padding: 4px 8px; background-color: {{ $announcement->status === 'aktif' ? '#d4edda' : '#e2e8f0' }}; color: {{ $announcement->status === 'aktif' ? '#155724' : '#4a5568' }}; border-radius: 4px; font-size: 11px; font-weight: 600;">
                        {{ ucfirst($announcement->status) }}
                    </span>
                </td>
                <td>
                    <div class="admin-btn-group">
                        <a href="{{ route('admin.announcement.edit', $announcement->id) }}" class="admin-btn" style="text-decoration: none;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.announcement.destroy', $announcement->id) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
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
                <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-light);">
                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                    <p>Belum ada pengumuman</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $announcements->links() }}
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
