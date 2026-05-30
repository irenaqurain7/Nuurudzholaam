@extends('layouts.app')

@section('content')
<style>
    /* Hide navbar and footer from app layout for teacher dashboard */
    .navbar {
        display: none;
    }
    .footer {
        display: none;
    }

    :root {
        --hijau-islam: #2D4438;
        --hijau-light: #1C2D25;
        --emas: #709D88;
        --emas-light: #E2ECE8;
        --putih: #ffffff;
        --bg-light: #F4F7F5;
        --text-dark: #333333;
        --sidebar-width: 280px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: var(--bg-light);
    }

    /* Main layout structure */
    .teacher-dashboard-wrapper {
        display: flex;
        height: 100vh;
        background-color: var(--bg-light);
    }

    /* Sidebar */
    .teacher-sidebar {
        width: var(--sidebar-width);
        background-color: var(--hijau-islam);
        color: var(--putih);
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        z-index: 1000;
    }

    .teacher-sidebar-header {
        padding: 2.5rem 1.5rem;
        text-align: center;
        border-bottom: 2px solid rgba(226, 236, 232, 0.15);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .teacher-sidebar-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        border: 4px solid var(--emas);
        object-fit: cover;
        background-color: var(--hijau-light);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .teacher-sidebar-header h5 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        color: var(--putih);
        letter-spacing: 0.3px;
        line-height: 1.4;
    }

    .teacher-sidebar-header small {
        color: var(--emas);
        font-size: 0.9rem;
        margin-top: 0.5rem;
        font-weight: 500;
        letter-spacing: 0.2px;
    }

    .teacher-sidebar-menu {
        flex: 1;
        list-style: none;
        padding: 1rem 0;
        overflow-y: auto;
    }

    .teacher-sidebar-menu li {
        margin: 0;
    }

    .teacher-sidebar-menu a {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        color: rgba(226, 236, 232, 0.8);
        text-decoration: none;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .teacher-sidebar-menu a:hover {
        background-color: rgba(226, 236, 232, 0.1);
        color: var(--putih);
        border-left-color: var(--emas);
    }

    .teacher-sidebar-menu a.active {
        background-color: rgba(226, 236, 232, 0.15);
        color: var(--putih);
        border-left-color: var(--emas);
        font-weight: 500;
    }

    .teacher-sidebar-menu i {
        width: 20px;
        text-align: center;
        margin-right: 0.75rem;
    }

    .sidebar-divider {
        height: 1px;
        background-color: rgba(226, 236, 232, 0.3);
        margin: 15px 0 15px 0;
    }

    /* Main content area */
    .teacher-main-content {
        flex: 1;
        margin-left: var(--sidebar-width);
        display: flex;
        flex-direction: column;
        background-color: var(--bg-light);
    }

    .teacher-topbar {
        background-color: var(--putih);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--emas-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 80px;
    }

    .teacher-topbar h2 {
        color: var(--hijau-islam);
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }

    .teacher-topbar-title {
        color: var(--hijau-islam);
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .teacher-topbar-date {
        color: var(--text-dark);
        font-size: 0.95rem;
    }

    .teacher-content-area {
        flex: 1;
        overflow-y: auto;
        padding: 40px;
    }

    .teacher-content-area::-webkit-scrollbar {
        width: 8px;
    }

    .teacher-content-area::-webkit-scrollbar-track {
        background: transparent;
    }

    .teacher-content-area::-webkit-scrollbar-thumb {
        background: var(--emas-light);
        border-radius: 4px;
    }

    .teacher-content-area::-webkit-scrollbar-thumb:hover {
        background: var(--emas);
    }

    /* Alerts */
    .alert {
        border-radius: 8px;
        border: none;
        margin-bottom: 20px;
    }

    .alert-danger {
        background-color: #fee;
        color: #c33;
        border-left: 4px solid #c33;
    }

    .alert-success {
        background-color: #efe;
        color: #0a0;
        border-left: 4px solid #0a0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .teacher-sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }

        .teacher-main-content {
            margin-left: 0;
        }

        .teacher-sidebar-menu {
            display: flex;
            overflow-x: auto;
            padding: 0.5rem;
        }

        .teacher-sidebar-menu li {
            flex-shrink: 0;
        }

        .teacher-sidebar-menu a {
            padding: 0.5rem 1rem;
            white-space: nowrap;
        }

        .teacher-topbar {
            flex-direction: column;
            align-items: flex-start;
            height: auto;
            gap: 1rem;
        }

        .teacher-topbar h2 {
            font-size: 1.25rem;
        }

        .teacher-content-area {
            padding: 20px;
        }
    }
</style>

<div class="teacher-dashboard-wrapper">
    <!-- Sidebar -->
    <aside class="teacher-sidebar">
        <div class="teacher-sidebar-header">
                @if(optional(auth()->user())->profile_photo)
                    <img src="{{ asset('storage/' . optional(auth()->user())->profile_photo) }}" alt="{{ optional(auth()->user())->name }}" class="teacher-sidebar-avatar">
                @else
                    <div class="teacher-sidebar-avatar">
                        <i class="fas fa-user" style="color: var(--putih); font-size: 2.5rem;"></i>
                    </div>
                @endif
                <h5>{{ optional(auth()->user())->name ?? 'Guru' }}</h5>
                <small>{{ optional(optional(auth()->user())->teacher)->specialization ?? 'Guru' }}</small>
        </div>

        <ul class="teacher-sidebar-menu">
            <li>
                <a class="@if(Route::currentRouteName() === 'teacher.dashboard') active @endif" href="{{ route('teacher.dashboard') }}">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a class="@if(Route::currentRouteName() === 'teacher.schedule') active @endif" href="{{ route('teacher.schedule') }}">
                    <i class="fas fa-calendar"></i> <span>Jadwal Mengajar</span>
                </a>
            </li>
            <li>
                <a class="@if(Route::currentRouteName() === 'teacher.students') active @endif" href="{{ route('teacher.students') }}">
                    <i class="fas fa-users"></i> <span>Data Siswa</span>
                </a>
            </li>
            <li>
                <a class="@if(Route::currentRouteName() === 'teacher.grades') active @endif" href="{{ route('teacher.grades') }}">
                    <i class="fas fa-star"></i> <span>Kelola Nilai</span>
                </a>
            </li>
            <li>
                <a class="@if(Route::currentRouteName() === 'teacher.profile') active @endif" href="{{ route('teacher.profile') }}">
                    <i class="fas fa-user-circle"></i> <span>Profil</span>
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li>
                <a href="{{ route('teacher.informasi') }}">
                    <i class="fas fa-bell"></i> <span>Informasi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('teacher.kegiatan') }}">
                    <i class="fas fa-calendar-check"></i> <span>Kegiatan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('teacher.kontak') }}">
                    <i class="fas fa-envelope"></i> <span>Kontak</span>
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <span>Keluar</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="teacher-main-content">
        <!-- Topbar -->
        <div class="teacher-topbar">
            <div class="teacher-topbar-title">
                <img src="{{ asset('images/logo-nuzo.png') }}" alt="Logo" style="height: 40px; margin-right: 12px;">
                <span>Sekolah Nuurudzholaam</span>
            </div>
            <span class="teacher-topbar-date" id="current-date"></span>
        </div>

        <!-- Content Area -->
        <div class="teacher-content-area">
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Error!</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('teacher-content')
        </div>
    </div>
</div>

<script>
    // Display current date in topbar
    document.getElementById('current-date').textContent = new Date().toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
</script>

@endsection
