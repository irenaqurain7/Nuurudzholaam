@extends('layouts.admin')

@section('title', 'Kelola FAQ')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0; color: var(--hijau-islam);">Kelola FAQ</h1>
    <a href="{{ route('admin.faq.create') }}" class="admin-btn" style="text-decoration: none; background-color: #28a745;">
        <i class="fas fa-plus"></i> Tambah FAQ
    </a>
</div>

<div style="background: white; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); overflow: hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pertanyaan</th>
                <th>Kategori</th>
                <th>Urutan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($faqs as $faq)
            <tr>
                <td>{{ ($faqs->currentPage() - 1) * $faqs->perPage() + $loop->iteration }}</td>
                <td><strong>{{ Str::limit($faq->pertanyaan, 50) }}</strong></td>
                <td><span class="badge">{{ ucfirst($faq->kategori) }}</span></td>
                <td>{{ $faq->urutan }}</td>
                <td>
                    <div class="admin-btn-group">
                        <a href="{{ route('admin.faq.edit', $faq->id) }}" class="admin-btn" style="text-decoration: none;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.faq.destroy', $faq->id) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
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
                    <p>Belum ada FAQ</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $faqs->links() }}
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
