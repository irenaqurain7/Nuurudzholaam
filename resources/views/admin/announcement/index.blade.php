@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')@section('page-title', 'Kelola Pengumuman')
@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Kelola Pengumuman</h1>
            <p class="subtitle">Kelola dan publikasikan pengumuman penting untuk sekolah</p>
        </div>
        <a href="{{ route('admin.announcement.create') }}" class="btn-add-new">
            <i class="fas fa-plus"></i> Pengumuman Baru
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="management-toolbar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari pengumuman..." class="search-input">
        </div>
        <div class="filter-group">
            <select class="filter-select">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Non-Aktif</option>
            </select>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="announcements-list-container">
        @forelse($announcements as $announcement)
        <div class="announcement-list-item">
            <div class="announcement-item-header">
                <div class="announcement-title-section">
                    <h3>{{ $announcement->judul }}</h3>
                    <div class="announcement-meta">
                        <span class="badge-type">{{ ucfirst($announcement->tipe) }}</span>
                        <span class="announcement-date">
                            <i class="fas fa-calendar"></i>
                            {{ $announcement->tanggal_mulai->format('d M Y') }}
                        </span>
                    </div>
                </div>
                <div class="announcement-status">
                    <span class="badge {{ $announcement->status === 'aktif' ? 'badge-success' : 'badge-secondary' }}">
                        {{ ucfirst($announcement->status) }}
                    </span>
                </div>
            </div>

            <p class="announcement-description">{{ Str::limit($announcement->isi, 150) }}</p>

            <div class="announcement-item-actions">
                <a href="{{ route('admin.announcement.edit', $announcement->id) }}" class="btn-action-list btn-edit-list">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button class="btn-action-list btn-delete-list" onclick="deleteAnnouncement({{ $announcement->id }})">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-bell"></i>
            <h3>Belum ada pengumuman</h3>
            <p>Mulai dengan membuat pengumuman pertama</p>
            <a href="{{ route('admin.announcement.create') }}" class="btn-add-new">
                <i class="fas fa-plus"></i> Buat Pengumuman
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $announcements->links() }}
    </div>
</div>

<style>
    .admin-page {
        max-width: 1000px;
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

    /* Announcements List */
    .announcements-list-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 30px;
    }

    .announcement-list-item {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border-left: 4px solid var(--hijau-islam);
        transition: all 0.3s;
    }

    .announcement-list-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .announcement-item-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 12px;
    }

    .announcement-title-section h3 {
        color: var(--text-dark);
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 10px 0;
    }

    .announcement-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .badge-type {
        display: inline-block;
        padding: 4px 12px;
        background: rgba(31, 127, 95, 0.1);
        color: var(--hijau-islam);
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .announcement-date {
        color: var(--text-light);
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .announcement-status {
        display: flex;
        gap: 8px;
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

    .badge-secondary {
        background: #e2e3e5;
        color: #383d41;
    }

    .announcement-description {
        color: var(--text-light);
        font-size: 14px;
        margin: 0 0 16px 0;
        line-height: 1.6;
    }

    .announcement-item-actions {
        display: flex;
        gap: 10px;
    }

    .btn-action-list {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s;
        text-decoration: none;
    }

    .btn-edit-list {
        background: rgba(243, 156, 18, 0.1);
        color: #f39c12;
    }

    .btn-edit-list:hover {
        background: #f39c12;
        color: white;
    }

    .btn-delete-list {
        background: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
    }

    .btn-delete-list:hover {
        background: #e74c3c;
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-light);
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
        display: block;
    }

    .empty-state h3 {
        color: var(--text-dark);
        font-size: 20px;
        margin: 0 0 10px 0;
    }

    .empty-state p {
        margin: 0 0 20px 0;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    @media (max-width: 768px) {
        .announcement-item-header {
            flex-direction: column;
        }

        .announcement-meta {
            flex-direction: column;
            align-items: flex-start;
        }

        .announcement-item-actions {
            flex-direction: column;
        }

        .btn-action-list {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection
