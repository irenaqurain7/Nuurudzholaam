@extends('layouts.admin')

@section('title', 'Arsip User')

@section('content')
<div class="users-page">
    <section class="users-hero">
        <div>
            <p class="users-kicker">Manajemen Akun</p>
            <h1>Arsip User</h1>
            <p class="users-subtitle">Kelola akun yang sudah diarsipkan dengan tampilan yang ringkas dan mudah dilihat.</p>
        </div>
    </section>

    <section class="stats-grid">
        <article class="stat-card primary">
            <div class="stat-card-header">
                <span class="stat-label">Total Arsip</span>
                <i class="fas fa-archive"></i>
            </div>
            <strong>{{ \App\Models\User::where('is_archived', true)->where('role','!=','admin')->count() }}</strong>
            <small>Akun yang diarsipkan</small>
        </article>
        <article class="stat-card green">
            <div class="stat-card-header">
                <span class="stat-label">Siswa</span>
                <i class="fas fa-user-graduate"></i>
            </div>
            <strong>{{ \App\Models\User::where('is_archived', true)->where('role','siswa')->count() }}</strong>
            <small>Arsip siswa</small>
        </article>
        <article class="stat-card blue">
            <div class="stat-card-header">
                <span class="stat-label">Guru</span>
                <i class="fas fa-chalkboard-user"></i>
            </div>
            <strong>{{ \App\Models\User::where('is_archived', true)->where('role','guru')->count() }}</strong>
            <small>Arsip guru</small>
        </article>
    </section>

    <section class="users-panel">
        <div class="panel-header">
            <div>
                <p class="panel-kicker">Arsip</p>
                <h2>Daftar Arsip</h2>
            </div>
            <div class="panel-meta">
                <span>{{ $users->count() }} ditampilkan</span>
                <span>{{ $users->total() }} total arsip</span>
            </div>
        </div>

        <div class="filter-toolbar">
            <form action="{{ route('admin.users.archive') }}" method="GET" class="filter-form">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="search-input">
                </div>
                <div class="filter-group">
                    <select name="jenjang" class="filter-select">
                        <option value="">Semua Jenjang</option>
                        <option value="tk" @selected(request('jenjang') === 'tk')>TK</option>
                        <option value="sd" @selected(request('jenjang') === 'sd')>SD</option>
                        <option value="smp" @selected(request('jenjang') === 'smp')>SMP</option>
                        <option value="smk" @selected(request('jenjang') === 'smk')>SMK</option>
                    </select>
                    <select name="graduation_year" class="filter-select">
                        <option value="">Semua Tahun</option>
                        @foreach(range(now()->year, now()->year - 5) as $year)
                            <option value="{{ $year }}" @selected(request('graduation_year') == $year)>{{ $year }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Cari</button>
                    @if(request()->hasAny(['search', 'jenjang', 'graduation_year']))
                        <a href="{{ route('admin.users.archive') }}" class="btn-reset">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if($users->count() > 0)
            <div class="table-wrap">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Peran</th>
                            <th>Tahun Kelulusan</th>
                            <th class="action-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar role-{{ $user->role }}">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                            <span class="email-cell">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display:flex;flex-direction:column;gap:6px;">
                                        <span class="role-badge role-{{ $user->role }}">
                                            {{ $user->role === 'siswa' ? 'Siswa' : ($user->role === 'guru' ? 'Guru' : 'Orang Tua') }}
                                        </span>
                                        @if($user->role === 'siswa' && $user->student)
                                            <span class="jenjang-badge"><i class="fas fa-graduation-cap"></i> {{ $user->student->jenjang }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $user->graduation_year ?? '—' }}</td>
                                <td>
                                    <div class="action-group" style="justify-content:flex-end; gap:8px;">
                                        <form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="action-pill restore" onclick="return confirm('Kembalikan akun ini ke daftar aktif?')">
                                                <i class="fas fa-undo"></i>
                                                Pulihkan
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="action-pill view">
                                            <i class="fas fa-eye"></i>
                                            Detail
                                        </a>
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
                <div class="empty-icon"><i class="fas fa-archive"></i></div>
                <h3>Belum ada arsip</h3>
                <p>Tidak ada data yang diarsipkan.</p>
            </div>
        @endif
    </section>
</div>

<style>
    .users-page {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .users-hero {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        padding: 28px;
        background: linear-gradient(135deg, #23352c 0%, #2d4438 48%, #486e5a 100%);
        border-radius: 24px;
        color: #ffffff;
        margin-bottom: 24px;
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

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #e2ece8;
        border-radius: 24px;
        padding: 20px;
        box-shadow: 0 16px 36px rgba(28, 45, 37, 0.08);
    }

    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .stat-card-header i {
        font-size: 18px;
        color: #2d4438;
    }

    .stat-card strong {
        display: block;
        margin: 4px 0 6px;
        font-size: 30px;
        color: #1c2d25;
        line-height: 1;
    }

    .stat-card small {
        color: #6c8b7c;
    }

    .stat-card.primary .stat-label { color: #2d4438; opacity: 1; }
    .stat-card.green strong { color: #059669; }
    .stat-card.blue strong { color: #2563eb; }
    .stat-card.green .stat-label { color: #059669; }
    .stat-card.blue .stat-label { color: #2563eb; }

    .users-panel {
        background: #ffffff;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 16px 36px rgba(28, 45, 37, 0.08);
    }

    .filter-toolbar {
        display: flex;
        justify-content: space-between;
        margin-bottom: 18px;
        align-items: center;
        width: 100%;
    }

    .filter-form {
        display: grid;
        grid-template-columns: minmax(240px, 1.75fr) repeat(3, minmax(150px, 1fr));
        gap: 12px;
        width: 100%;
        align-items: center;
    }

    .search-box {
        min-width: 0;
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .search-box i {
        position: absolute;
        left: 12px;
        color: #6c8b7c;
    }

    .search-input,
    .filter-select {
        width: 100%;
        min-width: 160px;
        padding: 10px 12px 10px 36px;
        border: 1px solid #e2ece8;
        border-radius: 12px;
        font-size: 14px;
        color: #1c2d25;
        background: #ffffff;
        transition: border-color 0.2s ease;
    }

    .filter-select {
        padding-left: 14px;
    }

    .search-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: #2d4438;
        box-shadow: 0 0 0 3px rgba(45, 68, 56, 0.08);
    }

    .btn-filter,
    .btn-reset,
    .action-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-filter {
        background: #2d4438;
        color: #ffffff;
    }

    .btn-reset {
        background: #f8faf9;
        color: #6c8b7c;
        border: 1px solid #e2ece8;
    }

    .action-pill {
        background: #f8faf9;
        color: #1c2d25;
        border: 1px solid transparent;
        padding: 10px 14px;
    }

    .action-pill:hover {
        transform: translateY(-1px);
        background: #edf7f0;
    }

    .action-pill.view {
        background: #eff6ff;
        color: #1d4ed8;
        border-color: #bfdbfe;
    }

    .action-pill.restore {
        background: #ecfdf5;
        color: #166534;
        border-color: #bbf7d0;
    }

    .action-pill i {
        font-size: 14px;
    }

    .btn-reset:hover,
    .btn-filter:hover {
        transform: translateY(-1px);
    }

    .table-wrap {
        overflow-x: auto;
        margin-top: 20px;
    }

    .users-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 14px;
        min-width: 760px;
    }

    .users-table thead {
        background: transparent;
    }

    .users-table th {
        padding: 16px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #5a7e6b;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border-bottom: 1px solid #e2ece8;
        background: #f9fbfa;
    }

    .users-table td {
        padding: 20px 20px;
        background: #ffffff;
        border: none;
        color: #1c2d25;
        vertical-align: middle;
        font-size: 14px;
    }

    .users-table tbody tr {
        border-radius: 22px;
        box-shadow: 0 8px 24px rgba(28, 45, 37, 0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden;
        background: #ffffff;
    }

    .users-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(28, 45, 37, 0.08);
    }

    .users-table td:first-child {
        border-top-left-radius: 22px;
        border-bottom-left-radius: 22px;
    }

    .users-table td:last-child {
        border-top-right-radius: 22px;
        border-bottom-right-radius: 22px;
    }

    .action-col {
        width: 140px;
        text-align: right;
    }

    .action-group {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 8px;
    }
</style>
@endsection
