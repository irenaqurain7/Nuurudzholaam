@extends('layouts.admin')

@section('title', 'Kelola Kegiatan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0; color: var(--hijau-islam);">Kelola Kegiatan</h1>
    <a href="{{ route('admin.activity.create') }}" class="admin-btn" style="text-decoration: none; background-color: #28a745;">
        <i class="fas fa-plus"></i> Tambah Kegiatan
    </a>
</div>

<div style="background: white; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); overflow: hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Visibility</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $activity)
            <tr>
                <td>{{ ($activities->currentPage() - 1) * $activities->perPage() + $loop->iteration }}</td>
                <td><strong>{{ Str::limit($activity->judul, 40) }}</strong></td>
                <td>
                    <span class="badge">{{ ucfirst($activity->kategori) }}</span>
                </td>
                <td>
                    <span style="display: inline-block; padding: 4px 8px; background-color: 
                    @if($activity->visibility === 'publik') #d4edda
                    @elseif($activity->visibility === 'ortu') #d1ecf1
                    @else #fff3cd
                    @endif
                    ; color: 
                    @if($activity->visibility === 'publik') #155724
                    @elseif($activity->visibility === 'ortu') #0c5460
                    @else #856404
                    @endif
                    ; border-radius: 4px; font-size: 11px; font-weight: 600;">
                        {{ ucfirst($activity->visibility) }}
                    </span>
                </td>
                <td>{{ $activity->tanggal->format('d M Y') }}</td>
                <td>
                    <div class="admin-btn-group">
                        <a href="{{ route('admin.activity.edit', $activity->id) }}" class="admin-btn" style="text-decoration: none;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.activity.destroy', $activity->id) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
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
                    <p>Belum ada kegiatan</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $activities->links() }}
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
