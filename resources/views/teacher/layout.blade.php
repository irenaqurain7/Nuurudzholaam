@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 bg-light sidebar">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x text-white"></i>
                        </div>
                    @endif
                    <h6 class="mt-2">{{ auth()->user()->name }}</h6>
                    <small class="text-muted">{{ auth()->user()->teacher->specialization ?? 'Guru' }}</small>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() === 'teacher.dashboard') active @endif" href="{{ route('teacher.dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() === 'teacher.schedule') active @endif" href="{{ route('teacher.schedule') }}">
                            <i class="fas fa-calendar"></i> Jadwal Mengajar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() === 'teacher.students') active @endif" href="{{ route('teacher.students') }}">
                            <i class="fas fa-users"></i> Data Siswa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() === 'teacher.grades') active @endif" href="{{ route('teacher.grades') }}">
                            <i class="fas fa-star"></i> Kelola Nilai
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Route::currentRouteName() === 'teacher.profile') active @endif" href="{{ route('teacher.profile') }}">
                            <i class="fas fa-user-circle"></i> Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto px-md-4 py-4">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('teacher-content')
        </main>
    </div>
</div>

<style>
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        z-index: 100;
    }

    main {
        margin-left: 25%;
        padding-left: 2rem !important;
        padding-right: 2rem !important;
    }

    @media (max-width: 768px) {
        .sidebar {
            position: relative;
            height: auto;
        }

        main {
            margin-left: 0;
        }
    }
</style>
@endsection
