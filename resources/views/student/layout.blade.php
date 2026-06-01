@extends('layouts.app')

@section('content')
<style>
    /* Hide navbar and footer from app layout for student dashboard */
    .navbar {
        display: none;
    }
    .footer {
        display: none;
    }
</style>

<div class="student-dashboard-wrapper">
    <style>
        :root {
            --hijau-islam: #2D4438;
            --hijau-dark: #1C2D25;
            --hijau-light: #486E5A;
            --emas: #709D88;
            --emas-light: #E2ECE8;
            --text-dark: #1C2D25;
            --text-light: #5A7E6B;
            --bg-light: #F4F7F5;
            --border-color: #E2ECE8;
            --putih: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .student-dashboard-wrapper {
            display: flex;
            height: 100vh;
            background-color: var(--bg-light);
        }

        /* Sidebar */
        .student-sidebar {
            width: 280px;
            background-color: var(--hijau-islam);
            color: var(--putih);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            left: 0;
            top: 0;
            z-index: 100;
            padding: 30px 20px;
        }

        .student-sidebar-brand {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid var(--emas-light);
            padding-bottom: 20px;
        }

        .student-sidebar-brand .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--emas-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            overflow: hidden;
            border: 3px solid var(--emas);
        }

        .student-sidebar-brand .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-sidebar-brand .avatar i {
            font-size: 32px;
            color: var(--hijau-islam);
        }

        .student-sidebar-brand h6 {
            color: var(--emas-light);
            font-weight: 600;
            margin: 10px 0 5px;
            font-size: 14px;
        }

        .student-sidebar-brand small {
            color: var(--text-light);
            display: block;
            font-size: 12px;
        }

        .student-sidebar-menu {
            list-style: none;
        }

        .student-sidebar-menu li {
            margin-bottom: 5px;
        }

        .student-sidebar-menu a {
            color: var(--putih);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }

        .student-sidebar-menu a:hover {
            background-color: rgba(224, 175, 85, 0.2);
            color: var(--emas-light);
        }

        .student-sidebar-menu a.active {
            background-color: var(--emas);
            color: var(--hijau-dark);
        }

        .student-sidebar-menu i {
            width: 20px;
            text-align: center;
        }

        .sidebar-divider {
            height: 1px;
            background-color: rgba(226, 236, 232, 0.3);
            margin: 15px 0 15px 0;
        }

        /* Main Content */
        .student-main-content {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .student-topbar {
            background-color: var(--putih);
            border-bottom: 2px solid var(--border-color);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }

        .student-topbar-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
        }

        .student-topbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .student-topbar-user a {
            color: var(--hijau-islam);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            border: 2px solid var(--hijau-islam);
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .student-topbar-user a:hover {
            background-color: var(--hijau-islam);
            color: var(--putih);
        }

        /* Content Area */
        .student-content-area {
            flex: 1;
            overflow-y: auto;
            padding: 40px;
        }

        .student-content-area::-webkit-scrollbar {
            width: 8px;
        }

        .student-content-area::-webkit-scrollbar-track {
            background: transparent;
        }

        .student-content-area::-webkit-scrollbar-thumb {
            background: var(--emas-light);
            border-radius: 4px;
        }

        .student-content-area::-webkit-scrollbar-thumb:hover {
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
            .student-sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .student-main-content {
                margin-left: 0;
            }

            .student-dashboard-wrapper {
                flex-direction: column;
                height: auto;
            }

            .student-content-area {
                padding: 20px;
            }

            .student-topbar {
                padding: 15px 20px;
            }
        }
    </style>

    <!-- Sidebar -->
    <aside class="student-sidebar">
        <div class="student-sidebar-brand">
            @if(auth()->user()->profile_photo)
                <div class="avatar">
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile">
                </div>
            @else
                <div class="avatar">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            <h6>{{ auth()->user()->name }}</h6>
            <small>{{ auth()->user()->student->class ?? 'Siswa' }}</small>
        </div>

        <ul class="student-sidebar-menu">
            <li>
                <a class="@if(Route::currentRouteName() === 'student.dashboard') active @endif" href="{{ route('student.dashboard') }}">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a class="@if(Route::currentRouteName() === 'student.schedule') active @endif" href="{{ route('student.schedule') }}">
                    <i class="fas fa-calendar"></i> <span>Jadwal Sekolah</span>
                </a>
            </li>
            <li>
                <a class="@if(Route::currentRouteName() === 'student.grades') active @endif" href="{{ route('student.grades') }}">
                    <i class="fas fa-star"></i> <span>Nilai</span>
                </a>
            </li>
            <li>
                <a class="@if(Route::currentRouteName() === 'student.profile') active @endif" href="{{ route('student.profile') }}">
                    <i class="fas fa-user-circle"></i> <span>Profil & Data</span>
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li>
                <a href="{{ route('student.informasi') }}">
                    <i class="fas fa-bell"></i> <span>Informasi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.kegiatan') }}">
                    <i class="fas fa-calendar-check"></i> <span>Kegiatan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.kontak') }}">
                    <i class="fas fa-envelope"></i> <span>Kontak</span>
                </a>
            </li>
            <div class="sidebar-divider"></div>
            <li>
                <a href="{{ route('logout') }}" onclick="confirmLogout(event)">
                    <i class="fas fa-sign-out-alt"></i> <span>Keluar</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="student-main-content">
        <!-- Topbar -->
        <div class="student-topbar">
            <div class="student-topbar-title">
                <img src="{{ asset('images/logo-nuzo.png') }}" alt="Logo" style="height: 40px; margin-right: 12px;">
                <span>Sekolah Nuurudzholaam</span>
            </div>
            <div class="student-topbar-user">
                <span style="color: var(--text-light); font-size: 14px;">{{ date('l, d F Y') }}</span>
            </div>
        </div>

        <!-- Content -->
        <div class="student-content-area">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <strong>Error!</strong>
                    <ul style="margin: 10px 0 0 20px; padding: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" onclick="this.parentElement.style.display='none';" style="position: absolute; right: 10px; top: 10px; border: none; background: none; font-size: 20px; cursor: pointer;">&times;</button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    {{ session('success') }}
                    <button type="button" onclick="this.parentElement.style.display='none';" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: none; font-size: 20px; cursor: pointer;">&times;</button>
                </div>
            @endif

            @yield('student-content')
        </div>
    </div>
</div>

<script>
    function confirmLogout(event) {
        event.preventDefault();

        if (confirm('Apakah Anda yakin ingin keluar dari sistem?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
@endsection
