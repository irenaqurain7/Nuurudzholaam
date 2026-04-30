@extends('layouts.admin')

@section('title', 'Kelola Program')@section('page-title', 'Kelola Program')
@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Kelola Program Pendidikan</h1>
            <p class="subtitle">Kelola program studi dan kurikulum sekolah</p>
        </div>
        <a href="{{ route('admin.program.create') }}" class="btn-add-new">
            <i class="fas fa-plus"></i> Tambah Program Baru
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="management-toolbar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari nama program..." class="search-input">
        </div>
    </div>

    <!-- Data Grid View -->
    <div class="card-grid">
        @forelse($programs as $program)
        <div class="card-item">
            @if($program->gambar)
                <div class="card-image">
                    <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}">
                </div>
            @else
                <div class="card-image placeholder">
                    <i class="fas fa-book-open"></i>
                </div>
            @endif

            <div class="card-content">
                <h3>{{ $program->nama_program }}</h3>
                <p class="card-description">{{ Str::limit($program->deskripsi, 100) }}</p>

                <div class="card-meta">
                    <div class="meta-item">
                        <span class="meta-label">Kuota</span>
                        <span class="meta-value">{{ $program->kuota }} Siswa</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Kurikulum</span>
                        <span class="meta-value">{{ $program->kurikulum ?? 'Belum ditentukan' }}</span>
                    </div>
                </div>

                <div class="card-actions">
                    <a href="{{ route('admin.program.edit', $program->id) }}" class="btn-action-card btn-edit-card">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button class="btn-action-card btn-delete-card" onclick="deleteProgram({{ $program->id }})">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Belum ada program</h3>
            <p>Mulai dengan membuat program pendidikan baru</p>
            <a href="{{ route('admin.program.create') }}" class="btn-add-new">
                <i class="fas fa-plus"></i> Buat Program Pertama
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $programs->links() }}
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

    /* Card Grid */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .card-item {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
    }

    .card-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .card-image {
        width: 100%;
        height: 180px;
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-image.placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 48px;
        opacity: 0.8;
    }

    .card-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-content h3 {
        color: var(--text-dark);
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .card-description {
        color: var(--text-light);
        font-size: 13px;
        margin: 0 0 15px 0;
        line-height: 1.5;
    }

    .card-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
    }

    .meta-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .meta-label {
        color: var(--text-light);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .meta-value {
        color: var(--text-dark);
        font-weight: 600;
        font-size: 13px;
    }

    .card-actions {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }

    .btn-action-card {
        flex: 1;
        padding: 10px 16px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.3s;
        text-decoration: none;
    }

    .btn-edit-card {
        background: rgba(31, 127, 95, 0.1);
        color: var(--hijau-islam);
    }

    .btn-edit-card:hover {
        background: var(--hijau-islam);
        color: white;
    }

    .btn-delete-card {
        background: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
    }

    .btn-delete-card:hover {
        background: #e74c3c;
        color: white;
    }

    /* Empty State */
    .empty-state {
        grid-column: 1 / -1;
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
</style>
@endsection
