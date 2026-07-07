@extends('layouts.admin')

@section('title', 'Data PPDB')
@section('page-title', 'Kelola Data PPDB')

@section('content')
<div class="ppdb-page">
    <!-- Header -->
    <section class="ppdb-hero">
        <div>
            <p class="ppdb-kicker">Penerimaan Peserta Didik Baru</p>
            <h1>Data Pendaftar PPDB</h1>
            <p class="ppdb-subtitle">
                Kelola dan monitor semua pendaftar PPDB. Filter berdasarkan status dan jenjang pendidikan.
            </p>
        </div>
    </section>

    <!-- Filter Form -->
    <div class="ppdb-panel">
        <div class="panel-header">
            <div>
                <p class="panel-kicker">Daftar Pendaftar</p>
                <h2>Semua Registrasi PPDB</h2>
            </div>
            <div class="panel-meta">
                <span>{{ $registrations->count() }} ditampilkan</span>
                <span>{{ $registrations->total() }} total</span>
            </div>
        </div>

        <div class="filter-toolbar">
            <form action="{{ route('admin.ppdb.index') }}" method="GET" class="filter-form">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau no telepon..." class="search-input">
                </div>
                <div class="filter-group">
                    <select name="status" class="filter-select" id="filter-status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending Review</option>
                        <option value="diterima" @selected(request('status') === 'diterima')>Diterima</option>
                        <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                    </select>
                    
                    <select name="jenjang" class="filter-select" id="filter-jenjang" onchange="this.form.submit()">
                        <option value="">Semua Jenjang</option>
                        <option value="tk" @selected(request('jenjang') === 'tk')>TK</option>
                        <option value="sd" @selected(request('jenjang') === 'sd')>SD</option>
                        <option value="smp" @selected(request('jenjang') === 'smp')>SMP</option>
                        <option value="smk" @selected(request('jenjang') === 'smk')>SMK</option>
                    </select>

                    <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Cari</button>
                    
                    @if(request()->hasAny(['search', 'status', 'jenjang']))
                        <a href="{{ route('admin.ppdb.index') }}" class="btn-reset">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </div>
            </form>

            @php
                $exportParams = array_filter(request()->except('page'), function ($value) {
                    return $value !== null && $value !== '';
                });
            @endphp
            <div class="toolbar-actions">
                <a href="{{ route('admin.ppdb.index') }}" class="btn-action-primary btn-refresh">
                    <i class="fas fa-sync-alt"></i>
                    Refresh
                </a>
                <div class="export-dropdown">
                    <button type="button" class="btn-action-primary btn-export-toggle">
                        <i class="fas fa-file-export"></i>
                        Export
                        <i class="fas fa-chevron-down export-caret"></i>
                    </button>
                    <div class="export-menu">
                        <a href="{{ route('admin.ppdb.export.excel', $exportParams) }}" class="export-item">
                            <i class="fas fa-file-excel" style="color: #1f9d55;"></i>
                            Export Excel
                        </a>
                        <a href="{{ route('admin.ppdb.export.pdf', $exportParams) }}" class="export-item">
                            <i class="fas fa-file-pdf" style="color: #dc3545;"></i>
                            Export PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if(request()->hasAny(['search', 'status', 'jenjang']) && (request('search') != '' || request('status') != '' || request('jenjang') != ''))
            <div class="active-filters">
                <span class="active-filters-label">Filter aktif:</span>
                @if(request('status')) 
                    <span class="filter-tag">
                        Status: 
                        @if(request('status') === 'pending') Pending @elseif(request('status') === 'diterima') Diterima @elseif(request('status') === 'ditolak') Ditolak @endif
                    </span> 
                @endif
                @if(request('jenjang')) 
                    <span class="filter-tag">Jenjang: {{ strtoupper(request('jenjang')) }}</span> 
                @endif
                @if(request('search')) 
                    <span class="filter-tag">Pencarian: "{{ request('search') }}"</span> 
                @endif
            </div>
        @endif
    </div>

<form id="archivePpdbForm" method="POST" style="display:none;">
    @csrf
</form>

<script>
    function archivePPDB(id) {
        var year = prompt('Masukkan tahun arsip (contoh: 2026) untuk pendaftar ini:');
        if (year === null) return;
        year = year.trim();
        if (!/^[0-9]{4}$/.test(year)) {
            alert('Tahun tidak valid. Gunakan format YYYY.');
            return;
        }
        var form = document.getElementById('archivePpdbForm');
        form.action = '/admin/ppdb/' + id + '/archive';
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'archive_year';
        input.value = year;
        form.appendChild(input);
        form.submit();
    }
</script>

    <!-- Statistics Cards -->
    <section class="stats-grid">
        <article class="stat-card primary">
            <span class="stat-label">Total Pendaftar</span>
            <strong>{{ $registrations->total() }}</strong>
            <small>Semua jenjang</small>
        </article>
        <article class="stat-card yellow">
            <span class="stat-label">Pending Review</span>
            <strong>{{ $registrations->where('status', 'pending')->count() }}</strong>
            <small>Menunggu review</small>
        </article>
        <article class="stat-card green">
            <span class="stat-label">Diterima</span>
            <strong>{{ $registrations->where('status', 'diterima')->count() }}</strong>
            <small>Sudah disetujui</small>
        </article>
        <article class="stat-card red">
            <span class="stat-label">Ditolak</span>
            <strong>{{ $registrations->where('status', 'ditolak')->count() }}</strong>
            <small>Tidak diterima</small>
        </article>
    </section>

    <!-- Data Table -->
    @if($registrations->count() > 0)
        <div class="table-wrap">
            <table class="ppdb-table">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Jenjang</th>
                        <th>Email</th>
                        <th>No Telepon</th>
                        <th>Asal Sekolah</th>
                        <th>Program/Jurusan</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th class="action-col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $reg)
                    <tr>
                        <td class="font-bold">{{ $reg->nama_lengkap }}</td>
                        <td>
                            <span class="jenjang-badge jenjang-{{ strtolower($reg->jenjang) }}">
                                {{ strtoupper($reg->jenjang) }}
                            </span>
                        </td>
                        <td><span class="email-cell">{{ $reg->email }}</span></td>
                        <td>{{ $reg->no_telepon }}</td>
                        <td>{{ $reg->asal_sekolah }}</td>
                        <td>
                            @if($reg->jenjang == 'smk' && $reg->jurusan)
                                <span class="program-badge">{{ $reg->jurusan }}</span>
                            @elseif($reg->jenjang == 'sma' && $reg->program)
                                <span class="program-badge">{{ ucfirst($reg->program) }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $reg->created_at->format('d M Y') }}</td>
                        <td>
                            <span class="status-badge status-{{ $reg->status }}">
                                <i class="fas fa-circle"></i>
                                @if($reg->status == 'pending')
                                    Pending
                                @elseif($reg->status == 'diterima')
                                    Diterima
                                @else
                                    Ditolak
                                @endif
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('admin.ppdb.show', $reg->id) }}" class="btn-icon-sm btn-view" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.ppdb.show', $reg->id) }}" class="btn-icon-sm btn-edit" title="Ubah Status">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.ppdb.show', $reg->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data pendaftar ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon-sm btn-delete" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <button class="btn-icon-sm btn-archive" title="Arsipkan" onclick="archivePPDB({{ $reg->id }})">
                                    <i class="fas fa-archive"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <p class="empty-state-text">Belum ada data pendaftar</p>
            @if(request()->hasAny(['search', 'status', 'jenjang']))
                <p class="empty-state-hint">Coba ubah filter atau pencarian Anda</p>
            @endif
        </div>
    @endif

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $registrations->links('partials.pagination') }}
    </div>
</div>

<style>
    /* Page Container */
    .ppdb-page {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* Hero Section */
    .ppdb-hero {
        margin-bottom: 30px;
    }

    .ppdb-kicker {
        color: var(--text-light);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 8px 0;
    }

    .ppdb-hero h1 {
        color: var(--hijau-islam);
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .ppdb-subtitle {
        color: var(--text-light);
        font-size: 14px;
        margin: 0;
    }

    /* Panel Section */
    .ppdb-panel {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        margin-bottom: 25px;
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
    }

    .panel-kicker {
        color: var(--text-light);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 6px 0;
    }

    .panel-header h2 {
        color: var(--text-dark);
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .panel-meta {
        display: flex;
        gap: 20px;
        font-size: 13px;
        color: var(--text-light);
    }

    /* Filter Toolbar */
    .filter-toolbar {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-form {
        display: flex;
        gap: 12px;
        flex: 1;
        min-width: 280px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-box {
        flex: 1;
        min-width: 200px;
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-box i {
        position: absolute;
        left: 12px;
        color: var(--text-light);
    }

    .search-input {
        width: 100%;
        padding: 10px 12px 10px 36px;
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
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-select {
        padding: 10px 12px;
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
        box-shadow: 0 0 0 3px rgba(31, 127, 95, 0.1);
    }

    .btn-filter {
        padding: 10px 16px;
        background: var(--hijau-islam);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s;
        font-size: 14px;
    }

    .btn-filter:hover {
        background: var(--hijau-islam-light);
    }

    .btn-reset {
        padding: 10px 16px;
        background: #f5f5f5;
        color: var(--text-dark);
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s;
        font-size: 14px;
        text-decoration: none;
    }

    .btn-reset:hover {
        background: #e2e8f0;
    }

    .toolbar-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-action-primary {
        padding: 10px 16px;
        background: white;
        color: var(--hijau-islam);
        border: 1px solid var(--hijau-islam);
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-action-primary:hover {
        background: var(--hijau-islam);
        color: white;
    }

    .btn-refresh {
        white-space: nowrap;
    }

    .export-dropdown {
        position: relative;
    }

    .btn-export-toggle {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .export-caret {
        font-size: 11px;
        transition: transform 0.2s ease;
    }

    .export-menu {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        min-width: 180px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
        padding: 8px;
        display: none;
        z-index: 15;
    }

    .export-dropdown:hover .export-menu,
    .export-dropdown:focus-within .export-menu {
        display: block;
    }

    .export-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 8px;
        color: var(--text-dark);
        text-decoration: none;
        font-size: 14px;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .export-item:hover {
        background: #f8fafc;
        color: var(--hijau-islam);
    }

    /* Active Filters Display */
    .active-filters {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        background: #f0f7f4;
        border-radius: 8px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .active-filters-label {
        color: var(--text-light);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .filter-tag {
        background: white;
        border: 1px solid #d4e8e1;
        color: var(--hijau-islam);
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
    }

    /* Statistics Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        display: flex;
        flex-direction: column;
        gap: 8px;
        border-left: 4px solid;
        transition: all 0.3s;
    }

    .stat-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .stat-card.primary {
        border-left-color: #667eea;
    }

    .stat-card.yellow {
        border-left-color: #f39c12;
    }

    .stat-card.green {
        border-left-color: #27ae60;
    }

    .stat-card.red {
        border-left-color: #e74c3c;
    }

    .stat-label {
        color: var(--text-light);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }

    .stat-card strong {
        color: var(--text-dark);
        font-size: 28px;
        font-weight: 700;
        margin: 0;
    }

    .stat-card small {
        color: var(--text-light);
        font-size: 12px;
        margin: 0;
    }

    /* Data Table */
    .table-wrap {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .ppdb-table {
        width: 100%;
        border-collapse: collapse;
    }

    .ppdb-table thead {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
        color: white;
    }

    .ppdb-table th {
        padding: 14px 16px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .ppdb-table th:first-child {
        border-top-left-radius: 12px;
    }

    .ppdb-table th:last-child {
        border-top-right-radius: 12px;
    }

    .ppdb-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 14px;
        vertical-align: middle;
    }

    .ppdb-table tbody tr {
        transition: background 0.2s ease;
    }

    .ppdb-table tbody tr:hover {
        background: #f7fafc;
    }

    .ppdb-table tbody tr:last-child td {
        border-bottom: none;
    }

    .font-bold {
        font-weight: 600;
        color: var(--text-dark);
    }

    .email-cell {
        color: var(--text-light);
        font-size: 13px;
    }

    .text-muted {
        color: var(--text-light);
    }

    /* Badges */
    .jenjang-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        background: #e3f2fd;
        color: #1976d2;
    }

    .jenjang-badge.jenjang-tk {
        background: rgba(255, 107, 107, 0.1);
        color: #ff6b6b;
    }

    .jenjang-badge.jenjang-sd {
        background: rgba(76, 175, 80, 0.1);
        color: #4caf50;
    }

    .jenjang-badge.jenjang-smp {
        background: rgba(33, 150, 243, 0.1);
        color: #2196f3;
    }

    .jenjang-badge.jenjang-smk {
        background: rgba(255, 152, 0, 0.1);
        color: #ff9800;
    }

    .program-badge {
        display: inline-block;
        background: rgba(31, 127, 95, 0.1);
        color: var(--hijau-islam);
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge i {
        font-size: 8px;
    }

    .status-badge.status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.status-diterima {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.status-ditolak {
        background: #f8d7da;
        color: #721c24;
    }

    /* Action Buttons */
    .action-col {
        width: 100px;
        text-align: center;
    }

    .action-group {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .btn-icon-sm {
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
        padding: 0;
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

    /* Empty State */
    .empty-state {
        background: white;
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .empty-state-icon {
        margin-bottom: 16px;
    }

    .empty-state-icon i {
        font-size: 56px;
        color: #ccc;
        opacity: 0.6;
    }

    .empty-state-text {
        color: var(--text-dark);
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 8px 0;
    }

    .empty-state-hint {
        color: var(--text-light);
        font-size: 14px;
        margin: 0;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px;
        margin-top: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .ppdb-page {
            padding: 20px 15px;
        }

        .ppdb-hero h1 {
            font-size: 24px;
        }

        .ppdb-subtitle {
            font-size: 13px;
        }

        .panel-header {
            flex-direction: column;
            gap: 12px;
        }

        .filter-toolbar {
            flex-direction: column;
        }

        .filter-form {
            width: 100%;
            min-width: 100%;
        }

        .search-box {
            width: 100%;
            min-width: 100%;
        }

        .toolbar-actions {
            width: 100%;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .ppdb-table {
            font-size: 12px;
        }

        .ppdb-table th,
        .ppdb-table td {
            padding: 10px 12px;
        }

        .action-group {
            flex-wrap: wrap;
        }

        .active-filters {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection
