@extends('layouts.admin')

@section('title', 'Data PPDB')
@section('page-title', 'Kelola Data PPDB')

@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Data PPDB Registrations</h1>
            <p class="subtitle">Kelola dan monitor semua pendaftar PPDB</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="management-toolbar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari nama, email, atau no telepon..." class="search-input">
        </div>
        <div class="filter-group">
            <select class="filter-select">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        <a href="{{ route('admin.ppdb.index') }}" class="btn-export">
            <i class="fas fa-sync"></i>
            Refresh
        </a>
    </div>

    <!-- Statistics -->
    <div class="mini-stats">
        <div class="mini-stat">
            <div class="mini-stat-icon" style="background: rgba(102, 126, 234, 0.1); color: #667eea;">
                <i class="fas fa-users"></i>
            </div>
            <div class="mini-stat-content">
                <p class="mini-stat-label">Total Pendaftar</p>
                <p class="mini-stat-value">{{ count($registrations) > 0 ? $registrations->total() : 0 }}</p>
            </div>
        </div>
        <div class="mini-stat">
            <div class="mini-stat-icon" style="background: rgba(243, 156, 18, 0.1); color: #f39c12;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="mini-stat-content">
                <p class="mini-stat-label">Pending Review</p>
                <p class="mini-stat-value">{{ $registrations->where('status', 'pending')->count() }}</p>
            </div>
        </div>
        <div class="mini-stat">
            <div class="mini-stat-icon" style="background: rgba(39, 174, 96, 0.1); color: #27ae60;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="mini-stat-content">
                <p class="mini-stat-label">Approved</p>
                <p class="mini-stat-value">{{ $registrations->where('status', 'approved')->count() }}</p>
            </div>
        </div>
        <div class="mini-stat">
            <div class="mini-stat-icon" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="mini-stat-content">
                <p class="mini-stat-label">Rejected</p>
                <p class="mini-stat-value">{{ $registrations->where('status', 'rejected')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Asal Sekolah</th>
                    <th>Program</th>
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $reg)
                <tr>
                    <td class="font-bold">{{ $reg->nama_lengkap }}</td>
                    <td>{{ $reg->email }}</td>
                    <td>{{ $reg->no_telepon }}</td>
                    <td>{{ $reg->asal_sekolah }}</td>
                    <td><span class="badge-program">{{ ucfirst($reg->program) }}</span></td>
                    <td>{{ $reg->created_at->format('d M Y') }}</td>
                    <td>
                        @if($reg->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($reg->status == 'approved')
                            <span class="badge badge-success">Approved</span>
                        @else
                            <span class="badge badge-danger">Rejected</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.ppdb.show', $reg->id) }}" class="btn-action btn-view" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn-action btn-edit" title="Ubah Status">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-action btn-delete" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                        <p>Belum ada data pendaftar</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $registrations->links() }}
    </div>
</div>

<style>
    .admin-page {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .page-header {
        margin-bottom: 30px;
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

    /* Management Toolbar */
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
        display: flex;
        align-items: center;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        color: var(--text-light);
    }

    .search-input {
        width: 100%;
        padding: 12px 15px 12px 40px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
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
        transition: all 0.3s;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--hijau-islam);
    }

    .btn-export {
        padding: 10px 20px;
        background: white;
        color: var(--hijau-islam);
        border: 1px solid var(--hijau-islam);
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        text-decoration: none;
    }

    .btn-export:hover {
        background: var(--hijau-islam);
        color: white;
    }

    /* Mini Statistics */
    .mini-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 25px;
    }

    .mini-stat {
        background: white;
        padding: 18px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .mini-stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .mini-stat-content {
        flex: 1;
    }

    .mini-stat-label {
        color: var(--text-light);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 5px 0;
    }

    .mini-stat-value {
        color: var(--text-dark);
        font-size: 22px;
        font-weight: 700;
        margin: 0;
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

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-program {
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

    .btn-view {
        background: rgba(0, 188, 212, 0.1);
        color: #00bcd4;
    }

    .btn-view:hover {
        background: #00bcd4;
        color: white;
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

        .data-table {
            font-size: 12px;
        }

        .data-table th, .data-table td {
            padding: 10px;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection
