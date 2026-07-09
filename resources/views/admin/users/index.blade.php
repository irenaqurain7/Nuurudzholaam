@extends('layouts.admin')

@section('title', 'Manajer User')

@section('content')
<div class="users-page">
    <section class="users-hero">
        <div>
            <p class="users-kicker">Manajemen Akun</p>
            <h1>Manajer User</h1>
            <p class="users-subtitle">
                Kelola akun siswa, guru, dan orang tua dengan tampilan yang lebih jelas dan ringkas.
            </p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="users-create-btn">
            <i class="fas fa-plus"></i>
            Tambah Siswa & Guru
        </a>
    </section>

    <section class="stats-grid">
        <article class="stat-card primary">
            <span class="stat-label">Total Data</span>
            <strong>{{ $users->total() }}</strong>
            <small>Akun non-admin</small>
        </article>
        <article class="stat-card green">
            <span class="stat-label">Siswa</span>
            <strong>{{ $totalSiswa ?? 0 }}</strong>
            <small>Akun aktif dan nonaktif</small>
        </article>
        <article class="stat-card blue">
            <span class="stat-label">Guru</span>
            <strong>{{ $totalGuru ?? 0 }}</strong>
            <small>Akun aktif dan nonaktif</small>
        </article>
    </section>

    <section class="users-panel">
        <div class="panel-header">
            <div>
                <p class="panel-kicker">Daftar user</p>
                <h2>Semua Akun Terdaftar</h2>
            </div>
            <div class="panel-meta">
                <span>{{ $users->count() }} ditampilkan</span>
                <span>{{ $users->total() }} total</span>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="filter-toolbar">
            <form action="{{ route('admin.users.index') }}" method="GET" class="filter-form">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, NISN, NIP..." class="search-input">
                </div>
                <div class="filter-group">
                    <select name="role" class="filter-select" id="filter-role" onchange="this.form.submit()">
                        <option value="">Semua Role</option>
                        <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                    </select>
                    
                    <select name="jenjang" class="filter-select" id="filter-jenjang" onchange="this.form.submit()">
                        <option value="">Semua Jenjang</option>
                        <option value="TK" {{ request('jenjang') == 'TK' ? 'selected' : '' }}>TK</option>
                        <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMK" {{ request('jenjang') == 'SMK' ? 'selected' : '' }}>SMK</option>
                    </select>

                    <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Cari</button>
                    
                    @if(request()->hasAny(['search', 'role', 'jenjang']))
                        <a href="{{ route('admin.users.index') }}" class="btn-reset">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if(request()->hasAny(['search', 'role', 'jenjang']) && (request('search') != '' || request('role') != '' || request('jenjang') != ''))
            <div class="active-filters">
                <span class="active-filters-label">Filter aktif:</span>
                @if(request('role')) <span class="filter-tag">Role: {{ ucfirst(request('role')) }}</span> @endif
                @if(request('jenjang')) <span class="filter-tag">Jenjang: {{ request('jenjang') }}</span> @endif
                @if(request('search')) <span class="filter-tag">Pencarian: "{{ request('search') }}"</span> @endif
            </div>
        @endif

        @if($users->count() > 0)
            <div class="table-wrap">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role / Jenjang</th>
                            <th>NISN / NIP</th>
                            <th>Status</th>
                            <th class="action-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar role-{{ $user->role }}">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                            <span>{{ $user->phone ?? '—' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="email-cell">{{ $user->email }}</span></td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 4px; align-items: flex-start;">
                                        <span class="role-badge role-{{ $user->role }}">
                                            {{ $user->role === 'siswa' ? 'Siswa' : ($user->role === 'guru' ? 'Guru' : 'Orang Tua') }}
                                        </span>
                                        @if($user->role === 'siswa' && $user->student)
                                            <span class="jenjang-badge"><i class="fas fa-graduation-cap"></i> {{ $user->student->jenjang }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="nisn-cell">
                                        @if($user->role === 'siswa')
                                            {{ $user->student->nisn ?? '—' }}
                                        @elseif($user->role === 'guru')
                                            {{ $user->teacher->nip ?? '—' }}
                                        @else
                                            —
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                                        <i class="fas fa-circle"></i>
                                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <div class="dropdown-menu">
                                            <button class="action-menu-btn" aria-label="Menu tindakan">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-content">
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="dropdown-item edit">
                                                    <i class="fas fa-pen-to-square"></i>
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" style="display: contents;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item reset" onclick="return confirm('Reset password user ini?')">
                                                        <i class="fas fa-key"></i>
                                                        Reset Password
                                                    </button>
                                                </form>
                                                <hr class="dropdown-divider">
                                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display: contents;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                                <button class="dropdown-item" onclick="archiveUser({{ $user->id }})">
                                                    <i class="fas fa-archive"></i>
                                                    Arsipkan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $users->links('partials.pagination') }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-users"></i></div>
                <h3>Belum ada user yang dibuat</h3>
                <p>Mulai dengan menambahkan akun siswa atau guru pertama.</p>
                <a href="{{ route('admin.users.create') }}" class="users-create-btn compact">
                    <i class="fas fa-plus"></i>
                    Tambah Sekarang
                </a>
            </div>
        @endif
    </section>
</div>

<form id="archiveUserForm" method="POST" style="display:none;">
    @csrf
</form>

<script>
    function archiveUser(id) {
        var year = prompt('Masukkan tahun kelulusan (contoh: 2026) untuk arsip:');
        if (year === null) return;
        year = year.trim();
        if (!/^[0-9]{4}$/.test(year)) {
            alert('Tahun tidak valid. Gunakan format YYYY.');
            return;
        }
        var form = document.getElementById('archiveUserForm');
        form.action = '/admin/users/' + id + '/archive';
        // append hidden input for graduation_year
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'graduation_year';
        input.value = year;
        form.appendChild(input);
        form.submit();
    }
</script>

<style>
    .users-page {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-width: 1400px;
        margin: 0 auto;
        padding: 28px;
    }

    .users-hero,
    .users-panel,
    .stat-card {
        background: #ffffff;
        border: 1px solid #e2ece8;
        border-radius: 24px;
        box-shadow: 0 16px 36px rgba(28, 45, 37, 0.08);
    }

    .users-hero {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        align-items: flex-start;
        padding: 28px;
        background: linear-gradient(135deg, #23352c 0%, #2d4438 48%, #486e5a 100%);
        color: #ffffff;
    }

    .users-kicker,
    .panel-kicker,
    .stat-label {
        margin: 0 0 10px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-size: 12px;
        font-weight: 700;
        opacity: 0.82;
    }

    .users-hero h1 {
        margin: 0;
        font-size: clamp(30px, 3vw, 46px);
        line-height: 1.08;
    }

    .users-subtitle {
        margin: 14px 0 0;
        max-width: 62ch;
        color: rgba(255, 255, 255, 0.84);
    }

    .users-create-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        border-radius: 14px;
        background: #ffffff;
        color: #1c2d25;
        text-decoration: none;
        font-weight: 800;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .users-create-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.16);
    }

    .users-create-btn.compact {
        box-shadow: none;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .stat-card {
        padding: 20px;
    }

    .stat-card strong {
        display: block;
        margin: 4px 0 4px;
        font-size: 30px;
        color: #1c2d25;
        line-height: 1;
    }

    .stat-card small {
        color: #6c8b7c;
    }

    .stat-card.primary {
        background: linear-gradient(180deg, #ffffff 0%, #fbfcfb 100%);
    }

    .stat-card.green strong { color: #059669; }
    .stat-card.blue strong { color: #2563eb; }
    .stat-card.amber strong { color: #d97706; }
    .stat-card.green .stat-label { color: #059669; }
    .stat-card.blue .stat-label { color: #2563eb; }
    .stat-card.amber .stat-label { color: #d97706; }
    .stat-card.primary .stat-label { color: #2d4438; opacity: 1; }

    .users-panel {
        padding: 24px;
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: flex-start;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2ece8;
    }

    .panel-header h2 {
        margin: 0;
        font-size: 24px;
        color: #1c2d25;
    }

    .panel-meta {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .panel-meta span {
        padding: 8px 14px;
        border-radius: 999px;
        background: #f4f7f5;
        color: #5a7e6b;
        font-size: 12px;
        font-weight: 700;
    }

    .table-wrap {
        overflow-x: auto;
    }

    /* Filter Styles */
    .filter-toolbar {
        margin-bottom: 20px;
    }

    .filter-form {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
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
        left: 14px;
        color: #9ca3a0;
    }

    .search-input {
        width: 100%;
        padding: 10px 14px 10px 36px;
        border: 1px solid #e2ece8;
        border-radius: 12px;
        font-size: 14px;
        background: #fcfdfc;
        transition: border-color 0.2s;
    }

    .search-input:focus {
        outline: none;
        border-color: #2d4438;
    }

    .filter-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-select {
        padding: 10px 32px 10px 14px;
        border: 1px solid #e2ece8;
        border-radius: 12px;
        background: #fcfdfc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%235a7e6b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 12px center;
        appearance: none;
        font-size: 14px;
        color: #1c2d25;
        min-width: 140px;
    }

    .btn-filter, .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
    }

    .btn-filter {
        background: #2d4438;
        color: white;
    }

    .btn-filter:hover {
        background: #1c2d25;
    }

    .btn-reset {
        background: #f8f9fa;
        color: #e11d48;
        border: 1px solid #ffe4e6;
    }

    .btn-reset:hover {
        background: #ffe4e6;
    }

    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        margin-bottom: 20px;
        padding: 12px 16px;
        background: #f4f7f5;
        border-radius: 10px;
        border-left: 4px solid #2d4438;
    }

    .active-filters-label {
        font-size: 12px;
        font-weight: 700;
        color: #5a7e6b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-right: 4px;
    }

    .filter-tag {
        display: inline-flex;
        align-items: center;
        background: white;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        color: #1c2d25;
        border: 1px solid #e2ece8;
    }

    .jenjang-badge {
        font-size: 11px;
        background: #f1f5f9;
        color: #475569;
        padding: 2px 8px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .users-table thead {
        background: #f8faf9;
    }

    .users-table th {
        padding: 14px 16px;
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #5a7e6b;
        font-weight: 700;
        border-bottom: 2px solid #e2ece8;
    }

    .users-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f0f3f2;
        color: #1c2d25;
        vertical-align: middle;
        height: 56px;
    }

    .users-table tbody tr {
        transition: background-color 0.15s ease;
    }

    .users-table tbody tr:hover {
        background: #fbfcfb;
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 800;
        flex-shrink: 0;
        transition: transform 0.2s ease;
    }

    .user-avatar.role-siswa {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .user-avatar.role-guru {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .user-avatar.role-orangtua {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .user-cell strong {
        display: block;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 3px;
    }

    .user-cell span {
        display: block;
        color: #9ca3a0;
        font-size: 12px;
    }

    .email-cell, .nisn-cell {
        font-size: 13px;
        color: #6c8b7c;
    }

    .role-badge,
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .role-badge {
        text-transform: capitalize;
    }

    .role-siswa {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .role-guru {
        background: #dcfce7;
        color: #166534;
    }

    .role-orangtua {
        background: #fef3c7;
        color: #92400e;
    }

    .status-badge.active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.active i {
        color: #10b981;
        font-size: 8px;
    }

    .status-badge.inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-badge.inactive i {
        color: #ef4444;
        font-size: 8px;
    }

    .action-col {
        width: 60px;
        text-align: center;
    }

    .action-group {
        display: flex;
        justify-content: center;
    }

    .dropdown-menu {
        position: relative;
        display: inline-block;
    }

    .action-menu-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 1px solid #e2ece8;
        background: #f8faf9;
        color: #5a7e6b;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-size: 14px;
        padding: 0;
    }

    .action-menu-btn:hover {
        background: #edf4ef;
        color: #1c2d25;
        border-color: #d1e8df;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background: white;
        min-width: 160px;
        box-shadow: 0 8px 24px rgba(28, 45, 37, 0.12);
        border-radius: 12px;
        border: 1px solid #e2ece8;
        z-index: 1;
        overflow: hidden;
    }

    .dropdown-menu:hover .dropdown-content {
        display: block;
    }

    .dropdown-item {
        color: #1c2d25;
        padding: 10px 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 500;
        border: none;
        background: none;
        cursor: pointer;
        width: 100%;
        text-align: left;
        transition: all 0.15s ease;
    }

    .dropdown-item:hover {
        background: #f8faf9;
        color: #2d4438;
    }

    .dropdown-item.edit {
        color: #3730a3;
    }

    .dropdown-item.edit:hover {
        background: #eef2ff;
    }

    .dropdown-item.reset {
        color: #075985;
    }

    .dropdown-item.reset:hover {
        background: #eff6ff;
    }

    .dropdown-item.danger {
        color: #b91c1c;
    }

    .dropdown-item.danger:hover {
        background: #fef2f2;
    }

    .dropdown-divider {
        border: none;
        border-top: 1px solid #e2ece8;
        margin: 4px 0;
    }

    .pagination-wrap {
        display: flex;
        justify-content: center;
        margin-top: 24px;
    }

    /* Hide the mobile pagination container since we want a unified layout */
    .pagination-wrap nav > div:first-child {
        display: none !important;
    }

    /* Style the desktop pagination container */
    .pagination-wrap nav > div:last-child {
        display: flex !important;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* Style the "Showing X to Y of Z results" text */
    .pagination-wrap nav p {
        margin: 0;
        font-size: 14px;
        color: #5a7e6b;
        font-weight: 600;
    }

    /* Style the pagination list container */
    .pagination-wrap nav span.relative {
        display: inline-flex;
        border-radius: 12px;
        background: #ffffff;
        border: 1px solid #e2ece8;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(28, 45, 37, 0.04);
    }

    /* Style page numbers and arrows */
    .pagination-wrap nav span.relative a,
    .pagination-wrap nav span.relative span[aria-current="page"] > span,
    .pagination-wrap nav span.relative span[disabled] > span,
    .pagination-wrap nav span.relative a > span,
    .pagination-wrap nav span.relative span.relative {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 14px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        color: #2d4438;
        border-right: 1px solid #e2ece8;
        background: #ffffff;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .pagination-wrap nav span.relative a:last-child,
    .pagination-wrap nav span.relative span:last-child,
    .pagination-wrap nav span.relative a > span:last-child {
        border-right: none;
    }

    /* Hover effect */
    .pagination-wrap nav span.relative a:hover {
        background: #f4f7f5;
        color: #1c2d25;
    }

    /* Active page style */
    .pagination-wrap nav span.relative span[aria-current="page"] > span {
        background: #2d4438;
        color: #ffffff;
        border-color: #2d4438;
    }

    /* Disabled arrow style */
    .pagination-wrap nav span.relative span[disabled] > span,
    .pagination-wrap nav span.relative span.relative.text-gray-300 {
        color: #cbd5e1;
        cursor: not-allowed;
        background: #f8faf9;
    }

    /* Constrain the SVGs */
    .pagination-wrap nav svg {
        width: 18px !important;
        height: 18px !important;
        display: inline-block;
        vertical-align: middle;
    }

    .empty-state {
        text-align: center;
        padding: 50px 16px;
        color: #5a7e6b;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        border-radius: 22px;
        background: #e2ece8;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        color: #2d4438;
        font-size: 28px;
    }

    .empty-state h3 {
        margin: 0 0 8px;
        color: #1c2d25;
        font-size: 18px;
    }

    .empty-state p {
        margin: 0 0 24px;
        color: #6c8b7c;
    }

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .users-hero,
        .panel-header {
            flex-direction: column;
        }
    }

    @media (max-width: 768px) {
        .users-page {
            padding: 16px;
        }

        .users-hero,
        .users-panel {
            border-radius: 18px;
            padding: 20px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .panel-header {
            margin-bottom: 16px;
            padding-bottom: 16px;
        }

        .users-table td {
            padding: 12px;
        }

        .action-col {
            width: 50px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('filter-role');
        const jenjangSelect = document.getElementById('filter-jenjang');

        function updateJenjangState() {
            if (roleSelect && roleSelect.value === 'guru') {
                jenjangSelect.disabled = true;
                // If the user already selected a jenjang before switching to Guru, clear it in UI
                jenjangSelect.value = '';
                jenjangSelect.style.opacity = '0.5';
                jenjangSelect.style.cursor = 'not-allowed';
            } else if (jenjangSelect) {
                jenjangSelect.disabled = false;
                jenjangSelect.style.opacity = '1';
                jenjangSelect.style.cursor = 'pointer';
            }
        }

        if (roleSelect && jenjangSelect) {
            // Initialize on load
            updateJenjangState();
        }
    });
</script>
@endsection
