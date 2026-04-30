@extends('layouts.admin')

@section('title', 'Kelola Galeri')@section('page-title', 'Kelola Galeri')
@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Kelola Galeri Foto</h1>
            <p class="subtitle">Kelola koleksi foto dan dokumentasi sekolah</p>
        </div>
        <a href="{{ route('admin.gallery.create') }}" class="btn-add-new">
            <i class="fas fa-plus"></i> Tambah Foto
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="management-toolbar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari foto..." class="search-input">
        </div>
    </div>

    <!-- Photo Grid -->
    <div class="photo-grid">
        @forelse($galleries as $gallery)
        <div class="photo-card">
            @if($gallery->gambar)
                <div class="photo-thumbnail">
                    <img src="{{ asset('storage/' . $gallery->gambar) }}" alt="{{ $gallery->judul }}">
                    <div class="photo-overlay">
                        <button class="btn-action-photo btn-delete-photo" onclick="deletePhoto({{ $gallery->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @else
                <div class="photo-thumbnail placeholder">
                    <i class="fas fa-image"></i>
                </div>
            @endif

            <div class="photo-info">
                <h4>{{ Str::limit($gallery->judul, 30) }}</h4>
                <p class="photo-date">
                    <i class="fas fa-calendar"></i>
                    {{ $gallery->created_at->format('d M Y') }}
                </p>
            </div>
        </div>
        @empty
        <div class="empty-state" style="grid-column: 1 / -1;">
            <i class="fas fa-images"></i>
            <h3>Belum ada foto</h3>
            <p>Mulai dengan menambahkan foto ke galeri</p>
            <a href="{{ route('admin.gallery.create') }}" class="btn-add-new">
                <i class="fas fa-plus"></i> Upload Foto Pertama
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $galleries->links() }}
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

    /* Photo Grid */
    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 30px;
    }

    .photo-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
    }

    .photo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .photo-thumbnail {
        position: relative;
        width: 100%;
        aspect-ratio: 1;
        background: #f0f0f0;
        overflow: hidden;
    }

    .photo-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-thumbnail.placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
        color: white;
        font-size: 40px;
    }

    .photo-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s;
    }

    .photo-card:hover .photo-overlay {
        opacity: 1;
    }

    .btn-action-photo {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s;
        background: white;
    }

    .btn-delete-photo {
        color: #e74c3c;
    }

    .btn-delete-photo:hover {
        background: #e74c3c;
        color: white;
    }

    .photo-info {
        padding: 12px;
    }

    .photo-info h4 {
        color: var(--text-dark);
        font-size: 14px;
        font-weight: 600;
        margin: 0 0 6px 0;
    }

    .photo-date {
        color: var(--text-light);
        font-size: 12px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
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
        .photo-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
    }
</style>
@endsection
