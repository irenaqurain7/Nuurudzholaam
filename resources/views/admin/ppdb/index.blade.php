@extends('layouts.admin')

@section('title', 'Kelola PPDB')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0; color: var(--hijau-islam);">Pendaftar PPDB</h1>
    <a href="{{ route('admin.ppdb.index') }}" class="admin-btn" style="text-decoration: none;">
        <i class="fas fa-sync"></i> Refresh
    </a>
</div>

<div style="background: white; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); overflow: hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No Telepon</th>
                <th>Program</th>
                <th>Status</th>
                <th>Tgl Daftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $reg)
            <tr>
                <td>{{ ($registrations->currentPage() - 1) * $registrations->perPage() + $loop->iteration }}</td>
                <td><strong>{{ $reg->nama_lengkap }}</strong></td>
                <td>{{ $reg->email }}</td>
                <td>{{ $reg->no_telepon }}</td>
                <td>
                    <span class="badge">{{ ucfirst($reg->program) }}</span>
                </td>
                <td>
                    <span style="display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
                    @if($reg->status === 'pending') background-color: #fff3cd; color: #856404;
                    @elseif($reg->status === 'diterima') background-color: #d4edda; color: #155724;
                    @else background-color: #f8d7da; color: #721c24;
                    @endif
                    ">
                        {{ ucfirst($reg->status) }}
                    </span>
                </td>
                <td>{{ $reg->tgl_daftar->format('d M Y') }}</td>
                <td>
                    <div class="admin-btn-group">
                        <a href="{{ route('admin.ppdb.show', $reg->id) }}" class="admin-btn" style="text-decoration: none;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.ppdb.updateStatus', [$reg->id, 'diterima']) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="admin-btn" style="background-color: #28a745;" title="Terima">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.ppdb.updateStatus', [$reg->id, 'ditolak']) }}" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="admin-btn danger" title="Tolak">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-light);">
                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                    <p>Belum ada pendaftar PPDB</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $registrations->links() }}
</div>

<div style="margin-top: 30px; padding: 20px; background-color: #d1ecf1; border-radius: 8px; border-left: 4px solid #17a2b8;">
    <p style="color: #0c5460; margin: 0;">
        <i class="fas fa-info-circle"></i> <strong>Total:</strong> {{ $registrations->total() }} pendaftar
    </p>
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
