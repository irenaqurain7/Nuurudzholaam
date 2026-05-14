@extends('layouts.admin')

@section('title', 'Username & Password')

@section('content')
<div class="users-page">
    <section class="users-hero">
        <div>
            <p class="users-kicker">Manajemen Akun</p>
            <h1>Username & Password</h1>
            <p class="users-subtitle">
                Kelola username dan reset password pengguna dengan mudah. Pastikan semua pengguna memiliki akses login yang aman.
            </p>
        </div>
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
                <p class="panel-kicker">Kredensial Login</p>
                <h2>Daftar Username & Password</h2>
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
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
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
                                            <span>{{ $user->nisn ?? $user->nip ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code style="background-color: #f3f4f6; padding: 4px 8px; border-radius: 4px; color: #1f2937; font-size: 13px;">
                                        {{ $user->username ?? 'N/A' }}
                                    </code>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="role-badge role-{{ $user->role }}">
                                        {{ $user->role === 'siswa' ? 'Siswa' : ($user->role === 'guru' ? 'Guru' : 'Orang Tua') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="action-btn soft" onclick="return confirm('Reset password user ini?')">
                                                <i class="fas fa-key"></i>
                                                Reset
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="action-btn edit">
                                            <i class="fas fa-pen"></i>
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $users->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 40px 20px; color: #6B7280;">
                <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                <p>Tidak ada data pengguna saat ini.</p>
            </div>
        @endif
    </section>

    <section style="margin-top: 30px; background: #f0fdf4; padding: 20px; border-radius: 8px; border-left: 4px solid #10b981;">
        <h3 style="color: #047857; margin-bottom: 10px; font-size: 16px;">
            <i class="fas fa-lightbulb"></i> Tips Manajemen Password
        </h3>
        <ul style="margin: 0; padding-left: 20px; color: #065f46; font-size: 14px;">
            <li>Username dapat digunakan untuk login sebagai alternatif dari email</li>
            <li>Password yang di-reset akan menggunakan format: Sekolah@[4 digit angka acak]</li>
            <li>Pengguna harus mengubah password tersebut saat login pertama kali</li>
            <li>Pastikan password yang baru disimpan dengan aman dan diberikan kepada pengguna secara pribadi</li>
        </ul>
    </section>
</div>

<style>
    .users-page {
        padding: 30px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .users-hero {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .users-hero > div:first-child {
        flex: 1;
    }

    .users-kicker {
        color: #6B7280;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .users-hero h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1C2D25;
        margin-bottom: 10px;
    }

    .users-subtitle {
        color: #6B7280;
        font-size: 15px;
        margin: 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid;
    }

    .stat-card.primary {
        border-left-color: #3B82F6;
    }

    .stat-card.green {
        border-left-color: #10B981;
    }

    .stat-card.blue {
        border-left-color: #0EA5E9;
    }

    .stat-card.amber {
        border-left-color: #F59E0B;
    }

    .stat-label {
        color: #6B7280;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 8px;
    }

    .stat-card strong {
        font-size: 28px;
        color: #1C2D25;
        display: block;
        margin-bottom: 5px;
    }

    .stat-card small {
        color: #9CA3AF;
        font-size: 13px;
    }

    .users-panel {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #E5E7EB;
    }

    .panel-kicker {
        color: #6B7280;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 5px 0;
    }

    .panel-header h2 {
        font-size: 20px;
        font-weight: 700;
        color: #1C2D25;
        margin: 0;
    }

    .panel-meta {
        display: flex;
        gap: 20px;
        align-items: center;
        color: #6B7280;
        font-size: 13px;
    }

    .table-wrap {
        overflow-x: auto;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table thead tr {
        background-color: #F9FAFB;
        border-bottom: 1px solid #E5E7EB;
    }

    .users-table th {
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .users-table td {
        padding: 15px;
        border-bottom: 1px solid #E5E7EB;
    }

    .users-table tbody tr:hover {
        background-color: #F9FAFB;
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D4438 0%, #486E5A 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }

    .user-cell strong {
        color: #1C2D25;
        display: block;
    }

    .user-cell span {
        color: #6B7280;
        font-size: 12px;
        display: block;
    }

    .role-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .role-siswa {
        background-color: #DBEAFE;
        color: #1E40AF;
    }

    .role-guru {
        background-color: #FEF3C7;
        color: #92400E;
    }

    .role-orangtua {
        background-color: #F3E8FF;
        color: #6D28D9;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge.active {
        background-color: #D1FAE5;
        color: #065F46;
    }

    .status-badge.inactive {
        background-color: #FEE2E2;
        color: #7F1D1D;
    }

    .action-col {
        width: 220px;
        text-align: center;
    }

    .action-group {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .action-btn.edit {
        background-color: #3B82F6;
        color: white;
    }

    .action-btn.edit:hover {
        background-color: #2563EB;
    }

    .action-btn.soft {
        background-color: #FCD34D;
        color: #78350F;
    }

    .action-btn.soft:hover {
        background-color: #FBBF24;
    }

    .action-btn i {
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .users-hero {
            flex-direction: column;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .users-hero h1 {
            font-size: 24px;
        }

        .table-wrap {
            font-size: 13px;
        }

        .users-table th,
        .users-table td {
            padding: 10px;
        }

        .action-group {
            flex-direction: column;
        }
    }
</style>
@endsection
