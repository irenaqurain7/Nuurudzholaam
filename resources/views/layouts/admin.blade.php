<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --hijau-islam: #1f7f5f;
            --hijau-islam-light: #2d8659;
            --hijau-islam-lighter: #4a9d7d;
            --putih: #ffffff;
            --emas: #d4af37;
            --emas-light: #ffc107;
            --text-dark: #1a202c;
            --text-light: #4a5568;
            --bg-light: #f7fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            background-color: var(--bg-light);
            display: flex;
        }

        .admin-sidebar {
            width: 260px;
            background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
            color: white;
            padding: 25px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.1);
        }

        .admin-sidebar-header {
            padding: 0 25px 25px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            margin-bottom: 25px;
        }

        .admin-sidebar-title {
            font-size: 20px;
            font-weight: bold;
            color: var(--emas);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-sidebar-nav {
            list-style: none;
        }

        .admin-sidebar-nav li {
            margin-bottom: 5px;
        }

        .admin-sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 25px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
        }

        .admin-sidebar-nav a:hover,
        .admin-sidebar-nav a.active {
            background-color: rgba(212, 175, 55, 0.1);
            color: var(--emas);
            border-left: 3px solid var(--emas);
            padding-left: 22px;
        }

        .admin-sidebar-nav i {
            width: 20px;
            text-align: center;
        }

        .admin-main {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .admin-topbar {
            background: white;
            padding: 20px 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-topbar-left h2 {
            margin: 0;
            color: var(--hijau-islam);
            font-size: 24px;
        }

        .admin-topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .admin-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-user-info img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--hijau-islam);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .admin-content {
            flex: 1;
            padding: 30px 30px;
            overflow-y: auto;
        }

        .admin-breadcrumb {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            font-size: 14px;
            color: var(--text-light);
        }

        .admin-breadcrumb a {
            color: var(--hijau-islam);
            text-decoration: none;
        }

        .admin-table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .admin-table thead {
            background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
            color: white;
        }

        .admin-table th {
            padding: 18px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        .admin-table td {
            padding: 15px 18px;
            border-bottom: 1px solid #e2e8f0;
        }

        .admin-table tbody tr:hover {
            background-color: #f7fafc;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        .admin-btn-group {
            display: flex;
            gap: 8px;
        }

        .admin-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: var(--hijau-islam);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .admin-btn:hover {
            background-color: var(--hijau-islam-light);
            transform: translateY(-2px);
        }

        .admin-btn.danger {
            background-color: #e74c3c;
        }

        .admin-btn.danger:hover {
            background-color: #c0392b;
        }

        .admin-btn.warning {
            background-color: #f39c12;
        }

        .admin-btn.warning:hover {
            background-color: #e67e22;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                width: 0;
                padding: 0;
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-topbar {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar-header">
            <div class="admin-sidebar-title">
                <i class="fas fa-mosque"></i>
                <span>Admin Panel</span>
            </div>
        </div>
        <nav>
            <ul class="admin-sidebar-nav">
                <li><a href="{{ route('admin.dashboard') }}" class="@if(Route::current()->getName() === 'admin.dashboard') active @endif"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                <li style="margin-top: 20px; padding: 0 25px; color: rgba(255,255,255,0.5); font-size: 12px; font-weight: 600; text-transform: uppercase;">Data PPDB</li>
                <li><a href="{{ route('admin.ppdb.index') }}" class="@if(str_contains(Route::current()->getName(), 'admin.ppdb')) active @endif"><i class="fas fa-users"></i> Pendaftar PPDB</a></li>
                <li style="margin-top: 20px; padding: 0 25px; color: rgba(255,255,255,0.5); font-size: 12px; font-weight: 600; text-transform: uppercase;">Manajemen Konten</li>
                <li><a href="{{ route('admin.activity.index') }}" class="@if(str_contains(Route::current()->getName(), 'admin.activity')) active @endif"><i class="fas fa-calendar"></i> Kegiatan</a></li>
                <li><a href="{{ route('admin.gallery.index') }}" class="@if(str_contains(Route::current()->getName(), 'admin.gallery')) active @endif"><i class="fas fa-images"></i> Galeri</a></li>
                <li><a href="{{ route('admin.announcement.index') }}" class="@if(str_contains(Route::current()->getName(), 'admin.announcement')) active @endif"><i class="fas fa-bell"></i> Pengumuman</a></li>
                <li style="margin-top: 20px; padding: 0 25px; color: rgba(255,255,255,0.5); font-size: 12px; font-weight: 600; text-transform: uppercase;">Pengaturan</li>
                <li><a href="{{ route('admin.program.index') }}" class="@if(str_contains(Route::current()->getName(), 'admin.program')) active @endif"><i class="fas fa-book-open"></i> Program</a></li>
                <li><a href="{{ route('admin.faq.index') }}" class="@if(str_contains(Route::current()->getName(), 'admin.faq')) active @endif"><i class="fas fa-question-circle"></i> FAQ</a></li>
                <li><a href="{{ route('admin.school-info.edit') }}" class="@if(str_contains(Route::current()->getName(), 'admin.school-info')) active @endif"><i class="fas fa-cog"></i> Info Sekolah</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <div class="admin-topbar-left">
                <h2>Admin Panel Nuurudzholaam</h2>
            </div>
            <div class="admin-topbar-right">
                <div class="admin-user-info">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--hijau-islam); display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                        <i class="fas fa-user"></i>
                    </div>
                    <span style="font-size: 14px; color: var(--text-light);">Admin User</span>
                </div>
                <a href="{{ route('home') }}" style="color: var(--hijau-islam); text-decoration: none; font-size: 14px; font-weight: 600;">
                    <i class="fas fa-home"></i> Ke Website
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="admin-content">
            @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle" style="font-size: 20px;"></i>
                <div>
                    <strong>Sukses!</strong>
                    <p style="margin-top: 5px;">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle" style="font-size: 20px;"></i>
                <div>
                    <strong>Terjadi kesalahan:</strong>
                    <ul style="margin-top: 10px; margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
