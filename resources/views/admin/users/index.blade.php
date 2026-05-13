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
        <article class="stat-card amber">
            <span class="stat-label">Orang Tua</span>
            <strong>{{ $totalOrangtua ?? 0 }}</strong>
            <small>Akun pendamping siswa</small>
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

        @if($users->count() > 0)
            <div class="table-wrap">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
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
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                            <span>{{ $user->phone ?? 'Tidak ada nomor' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="role-badge role-{{ $user->role }}">
                                        {{ $user->role === 'siswa' ? 'Siswa' : ($user->role === 'guru' ? 'Guru' : 'Orang Tua') }}
                                    </span>
                                </td>
                                <td>{{ $user->nisn ?? $user->nip ?? '-' }}</td>
                                <td>
                                    <span class="status-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="action-btn edit">
                                            <i class="fas fa-pen"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="action-btn soft" onclick="return confirm('Reset password user ini?')">
                                                <i class="fas fa-key"></i>
                                                Reset
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $users->links() }}
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
    }

    .users-create-btn.compact {
        box-shadow: none;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
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
        margin-bottom: 18px;
    }

    .panel-header h2 {
        margin: 0;
        font-size: 24px;
        color: #1c2d25;
    }

    .panel-meta {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .panel-meta span {
        padding: 8px 12px;
        border-radius: 999px;
        background: #f4f7f5;
        color: #5a7e6b;
        font-size: 12px;
        font-weight: 700;
    }

    .table-wrap {
        overflow-x: auto;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .users-table thead {
        background: #f4f7f5;
    }

    .users-table th {
        padding: 14px 16px;
        text-align: left;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #1c2d25;
        border-bottom: 1px solid #e2ece8;
    }

    .users-table td {
        padding: 16px;
        border-bottom: 1px solid #e2ece8;
        color: #1c2d25;
        vertical-align: middle;
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
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: linear-gradient(135deg, #2d4438 0%, #486e5a 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .user-cell strong {
        display: block;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .user-cell span {
        display: block;
        color: #6c8b7c;
        font-size: 12px;
    }

    .role-badge,
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
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
        background: #dcfce7;
        color: #166534;
    }

    .status-badge.inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-col {
        width: 280px;
    }

    .action-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 12px;
        border: 1px solid transparent;
        text-decoration: none;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        background: #edf4ef;
        color: #1c2d25;
    }

    .action-btn:hover {
        transform: translateY(-1px);
    }

    .action-btn.edit {
        background: #eef2ff;
        color: #3730a3;
    }

    .action-btn.soft {
        background: #eff6ff;
        color: #075985;
    }

    .action-btn.danger {
        background: #fef2f2;
        color: #b91c1c;
    }

    .pagination-wrap {
        display: flex;
        justify-content: center;
        margin-top: 18px;
    }

    .empty-state {
        text-align: center;
        padding: 40px 16px;
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
    }

    .empty-state p {
        margin: 0 0 18px;
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

        .action-group {
            flex-direction: column;
            align-items: stretch;
        }

        .action-btn {
            justify-content: center;
        }
    }
</style>
@endsection
