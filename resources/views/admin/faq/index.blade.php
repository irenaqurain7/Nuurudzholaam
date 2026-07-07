@extends('layouts.admin')

@section('title', 'Kelola FAQ')@section('page-title', 'Kelola FAQ')
@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Kelola FAQ (Frequently Asked Questions)</h1>
            <p class="subtitle">Kelola pertanyaan yang sering diajukan oleh calon pendaftar</p>
        </div>
        <a href="{{ route('admin.faq.create') }}" class="btn-add-new">
            <i class="fas fa-plus"></i> Tambah FAQ Baru
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="management-toolbar">
        <form method="GET" action="{{ route('admin.faq.index') }}" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center; width: 100%;">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari FAQ..." class="search-input">
            </div>
            <div class="filter-group">
                <select name="kategori" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <option value="umum" {{ request('kategori') == 'umum' ? 'selected' : '' }}>Umum</option>
                    <option value="ppdb" {{ request('kategori') == 'ppdb' ? 'selected' : '' }}>PPDB</option>
                    <option value="akademik" {{ request('kategori') == 'akademik' ? 'selected' : '' }}>Akademik</option>
                    <option value="fasilitas" {{ request('kategori') == 'fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                </select>
            </div>
            @if(request()->anyFilled(['search', 'kategori']))
                <a href="{{ route('admin.faq.index') }}" style="color: var(--text-light); text-decoration: none; font-size: 14px;"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>

    <!-- FAQ List -->
    <div class="faq-list-container">
        @forelse($faqs as $faq)
        <div class="faq-item">
            <div class="faq-header">
                <div class="faq-number">{{ $loop->iteration }}</div>
                <div class="faq-title-section">
                    <h3>{{ $faq->pertanyaan }}</h3>
                    <span class="badge-category">{{ ucfirst($faq->kategori) }}</span>
                </div>
                <div class="faq-order">
                    <small>Urutan: {{ $faq->urutan }}</small>
                </div>
            </div>

            <div class="faq-preview">
                {{ Str::limit($faq->jawaban, 100) }}
            </div>

            <div class="faq-actions">
                <a href="{{ route('admin.faq.edit', $faq->id) }}" class="btn-action-faq btn-edit-faq">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button class="btn-action-faq btn-delete-faq" onclick="deleteFaq({{ $faq->id }})">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-question-circle"></i>
            <h3>Belum ada FAQ</h3>
            <p>Mulai dengan membuat pertanyaan yang sering diajakan</p>
            <a href="{{ route('admin.faq.create') }}" class="btn-add-new">
                <i class="fas fa-plus"></i> Buat FAQ Pertama
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $faqs->links('partials.pagination') }}
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

    /* FAQ List */
    .faq-list-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 30px;
    }

    .faq-item {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: all 0.3s;
        border-left: 4px solid var(--hijau-islam);
    }

    .faq-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .faq-header {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 18px;
        border-bottom: 1px solid #e2e8f0;
    }

    .faq-number {
        min-width: 40px;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }

    .faq-title-section {
        flex: 1;
    }

    .faq-title-section h3 {
        color: var(--text-dark);
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .badge-category {
        display: inline-block;
        padding: 4px 12px;
        background: rgba(31, 127, 95, 0.1);
        color: var(--hijau-islam);
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .faq-order {
        color: var(--text-light);
        font-size: 12px;
        white-space: nowrap;
    }

    .faq-preview {
        padding: 0 18px 18px 73px;
        color: var(--text-light);
        font-size: 14px;
        line-height: 1.6;
    }

    .faq-actions {
        display: flex;
        gap: 10px;
        padding: 12px 18px;
        background: #f7fafc;
        border-top: 1px solid #e2e8f0;
    }

    .btn-action-faq {
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

    .btn-edit-faq {
        background: rgba(243, 156, 18, 0.1);
        color: #f39c12;
    }

    .btn-edit-faq:hover {
        background: #f39c12;
        color: white;
    }

    .btn-delete-faq {
        background: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
    }

    .btn-delete-faq:hover {
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
        padding: 22px 0 8px;
        margin-top: 10px;
        width: 100%;
    }

    .pagination-wrapper nav {
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper .custom-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 6px;
        margin: 0;
        width: 100%;
    }

    .pagination-wrapper .page-numbers {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 6px;
    }

    .pagination-wrapper .page-item {
        margin: 0;
    }

    .pagination-wrapper .page-link {
        min-width: 34px;
        height: 36px;
        padding: 0 12px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: var(--text-dark);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        line-height: 1;
        text-decoration: none;
        box-shadow: none;
        transition: all 0.2s ease;
    }

    .pagination-wrapper .page-link.active,
    .pagination-wrapper .page-item.active .page-link {
        background: #3b5d50;
        border-color: #3b5d50;
        color: #ffffff;
        font-weight: 600;
    }

    .pagination-wrapper .page-link:hover:not(.disabled):not(.active) {
        background: #e6f2ed;
        border-color: #3b5d50;
        color: #3b5d50;
    }

    .pagination-wrapper .page-link.disabled {
        background: #ffffff;
        border-color: #d1d5db;
        color: #9ca3af;
        cursor: not-allowed;
        opacity: 1;
    }

    .pagination-wrapper .page-link i,
    .pagination-wrapper .page-link svg {
        width: 14px !important;
        height: 14px !important;
        max-width: 14px;
        max-height: 14px;
        flex-shrink: 0;
        font-size: 14px !important;
        line-height: 1;
    }

    .pagination-wrapper .page-link span {
        display: inline-flex;
        align-items: center;
    }

    .pagination-wrapper .custom-pagination .page-link {
        box-shadow: none;
    }

    @media (max-width: 768px) {
        .faq-header {
            flex-direction: column;
        }

        .faq-preview {
            padding-left: 18px;
        }

        .faq-actions {
            flex-direction: column;
        }

        .btn-action-faq {
            width: 100%;
            justify-content: center;
        }

        .pagination-wrapper {
            padding-top: 20px;
        }

        .pagination-wrapper .page-link {
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            font-size: 13px;
        }

        .pagination-wrapper .page-numbers {
            gap: 4px;
        }
    }
</style>
@endsection
