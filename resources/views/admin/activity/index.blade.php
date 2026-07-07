@extends('layouts.admin')

@section('title', 'Kelola Kegiatan')@section('page-title', 'Kelola Kegiatan')
@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Kelola Kegiatan Sekolah</h1>
            <p class="subtitle">Kelola dan publikasikan kegiatan sekolah</p>
        </div>
        <a href="{{ route('admin.activity.create') }}" class="btn-add-new">
            <i class="fas fa-plus"></i> Tambah Kegiatan Baru
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="management-toolbar">
        <form method="GET" action="{{ route('admin.activity.index') }}" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center; width: 100%;">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kegiatan..." class="search-input">
            </div>
            <div class="filter-group">
                <select name="kategori" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <option value="kegiatan" {{ request('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="dokumentasi" {{ request('kategori') == 'dokumentasi' ? 'selected' : '' }}>Dokumentasi</option>
                    <option value="berita" {{ request('kategori') == 'berita' ? 'selected' : '' }}>Berita</option>
                    <option value="pengumuman" {{ request('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                </select>
                <select name="visibility" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Visibility</option>
                    <option value="publik" {{ request('visibility') == 'publik' ? 'selected' : '' }}>Publik</option>
                    <option value="siswa" {{ request('visibility') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ request('visibility') == 'guru' ? 'selected' : '' }}>Guru</option>
                </select>
            </div>
            @if(request()->anyFilled(['search', 'kategori', 'visibility']))
                <a href="{{ route('admin.activity.index') }}" style="color: var(--text-light); text-decoration: none; font-size: 14px;"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>

    <!-- Table View -->
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Visibility</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                <tr>
                    <td class="font-bold">{{ Str::limit($activity->judul, 50) }}</td>
                    <td>
                        <span class="badge-category">{{ ucfirst($activity->kategori) }}</span>
                    </td>
                    <td>{{ $activity->tanggal->format('d M Y') }}</td>
                    <td>
                        @if($activity->visibility === 'publik')
                            <span class="badge badge-success">Publik</span>
                        @elseif($activity->visibility === 'siswa')
                            <span class="badge badge-info">Siswa</span>
                        @else
                            <span class="badge badge-secondary">Guru</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.activity.edit', $activity->id) }}" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn-action btn-delete" onclick="deleteActivity({{ $activity->id }})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                        <p>Belum ada kegiatan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $activities->links() }}
    </div>
</div>

<style>
    .admin-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        gap: 20px;
        flex-wrap: wrap;
    }

    .page-header h1 {
        color: var(--hijau-islam);
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .page-header .subtitle {
        color: var(--text-light);
        font-size: 14px;
        margin: 0;
    }

    .btn-add-new {
        padding: 12px 24px;
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .btn-add-new:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(31, 127, 95, 0.3);
    }

    /* Toolbar */
    .management-toolbar {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-box {
        flex: 1;
        min-width: 250px;
        position: relative;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
    }

    .search-input {
        width: 100%;
        padding: 12px 15px 12px 40px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--hijau-islam);
        box-shadow: 0 0 0 3px rgba(31, 127, 95, 0.1);
    }

    .filter-group {
        display: flex;
        gap: 10px;
    }

    .filter-select {
        padding: 10px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        color: var(--text-dark);
        font-size: 14px;
        cursor: pointer;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--hijau-islam);
    }

    /* Data Table */
    .data-table-container {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
        color: white;
    }

    .data-table th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .data-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 14px;
    }

    .data-table tbody tr:hover {
        background: #f7fafc;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .font-bold {
        font-weight: 600;
        color: var(--text-dark);
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-info {
        background: #d1ecf1;
        color: #0c5460;
    }

    .badge-secondary {
        background: #e2e3e5;
        color: #383d41;
    }

    .badge-category {
        background: rgba(31, 127, 95, 0.1);
        color: var(--hijau-islam);
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: all 0.3s;
        text-decoration: none;
    }

    .btn-edit {
        background: rgba(243, 156, 18, 0.1);
        color: #f39c12;
    }

    .btn-edit:hover {
        background: #f39c12;
        color: white;
    }

    .btn-delete {
        background: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
    }

    .btn-delete:hover {
        background: #e74c3c;
        color: white;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    .text-center {
        text-align: center;
    }

    .text-muted {
        color: var(--text-light);
    }

    .py-4 {
        padding: 16px 0;
    }

    @media (max-width: 768px) {
        .management-toolbar {
            flex-direction: column;
        }

        .search-box {
            min-width: 100%;
        }

        .filter-group {
            flex-direction: column;
            width: 100%;
        }

        .filter-select {
            width: 100%;
        }
    }
</style>

<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteActivity(id) {
    if (confirm('Yakin ingin menghapus kegiatan ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = '{{ route("admin.activity.index") }}/' + id;
        form.submit();
    }
}
</script>

@endsection
