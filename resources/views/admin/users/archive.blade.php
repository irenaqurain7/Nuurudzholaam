@extends('layouts.admin')

@section('title', 'Arsip User')

@section('content')
<div class="users-page">
    <section class="users-hero">
        <div>
            <p class="users-kicker">Arsip</p>
            <h1>Arsip User</h1>
            <p class="users-subtitle">Daftar akun yang telah diarsipkan (alumni).</p>
        </div>
    </section>

    <section class="users-panel">
        <div class="panel-header">
            <div>
                <p class="panel-kicker">Daftar Arsip</p>
                <h2>Arsip User</h2>
            </div>
            <div class="panel-meta">
                <span>{{ $users->count() }} ditampilkan</span>
                <span>{{ $users->total() }} total arsip</span>
            </div>
        </div>

        @if($users->count() > 0)
            <div class="table-wrap">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role / Jenjang</th>
                            <th>Tahun Kelulusan</th>
                            <th class="action-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role === 'siswa' && $user->student)
                                        {{ $user->student->jenjang }}
                                    @else
                                        {{ ucfirst($user->role) }}
                                    @endif
                                </td>
                                <td>{{ $user->graduation_year ?? '—' }}</td>
                                <td>
                                    <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn-action-list" onclick="return confirm('Kembalikan akun ini ke daftar aktif?')">
                                            <i class="fas fa-undo"></i> Pulihkan
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-action-list">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
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
@endsection
