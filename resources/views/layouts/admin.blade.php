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
            --hijau-dark: #0f5038;
            --putih: #ffffff;
            --emas: #d4af37;
            --emas-light: #ffc107;
            --text-dark: #0f172a;
            --text-light: #475569;
            --text-muted: #64748b;
            --bg-light: #f1f5f9;
            --bg-white: #ffffff;
            --border-color: #e2e8f0;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #06b6d4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
            color: var(--text-dark);
            background-color: var(--bg-light);
            display: flex;
            line-height: 1.6;
        }

        /* ===== SIDEBAR ===== */
        .admin-sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--hijau-islam) 0%, var(--hijau-dark) 100%);
            color: white;
            padding: 30px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 8px 0 24px rgba(0, 0, 0, 0.12);
            z-index: 1000;
        }

        .admin-sidebar-header {
            padding: 0 25px 30px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.15);
            margin-bottom: 30px;
        }

        .admin-sidebar-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--emas);
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: 0.3px;
        }

        .admin-sidebar-nav {
            list-style: none;
        }

        .admin-sidebar-nav li {
            margin-bottom: 3px;
        }

        .admin-sidebar-nav .nav-label {
            margin-top: 25px;
            padding: 12px 25px;
            color: rgba(255, 255, 255, 0.4);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .admin-sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 25px;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            position: relative;
        }

        .admin-sidebar-nav a:hover {
            background-color: rgba(212, 175, 55, 0.08);
            color: white;
        }

        .admin-sidebar-nav a.active {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.2) 0%, rgba(212, 175, 55, 0.05) 100%);
            color: var(--emas);
            border-left: 3px solid var(--emas);
            padding-left: 22px;
        }

        .admin-sidebar-nav i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .admin-sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(212, 175, 55, 0.3);
            border-radius: 3px;
        }

        /* ===== MAIN CONTENT ===== */
        .admin-main {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .admin-topbar {
            background: var(--bg-white);
            padding: 20px 35px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .admin-topbar-left h2 {
            margin: 0;
            color: var(--text-dark);
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .admin-topbar-right {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .admin-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-right: 20px;
            border-right: 1px solid var(--border-color);
        }

        .admin-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            font-weight: 600;
        }

        .admin-user-details {
            font-size: 13px;
        }

        .admin-user-name {
            font-weight: 600;
            color: var(--text-dark);
            display: block;
        }

        .admin-user-email {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .admin-topbar-action {
            display: flex;
            align-items: center;
            gap: 3px;
            padding: 8px 12px;
            color: var(--hijau-islam);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .admin-topbar-action:hover {
            background-color: var(--bg-light);
            color: var(--hijau-dark);
        }

        .admin-topbar-action.logout {
            color: var(--danger);
        }

        .admin-topbar-action.logout:hover {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .admin-topbar-action i {
            font-size: 16px;
        }

        .admin-content {
            flex: 1;
            padding: 35px;
            overflow-y: auto;
        }

        .admin-content::-webkit-scrollbar {
            width: 8px;
        }

        .admin-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .admin-content::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        /* ===== ALERTS ===== */
        .alert {
            padding: 16px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: #991b1b;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert i {
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .alert strong {
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }

        /* ===== TABLES ===== */
        .admin-table {
            width: 100%;
            background: var(--bg-white);
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .admin-table thead {
            background: linear-gradient(90deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
            color: white;
        }

        .admin-table th {
            padding: 16px 18px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .admin-table td {
            padding: 16px 18px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
        }

        .admin-table tbody tr {
            transition: all 0.2s ease;
        }

        .admin-table tbody tr:hover {
            background-color: rgba(31, 127, 95, 0.02);
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== BUTTONS ===== */
        .admin-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            background-color: var(--hijau-islam);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .admin-btn:hover {
            background-color: var(--hijau-islam-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(31, 127, 95, 0.2);
        }

        .admin-btn:active {
            transform: translateY(0);
        }

        .admin-btn.danger {
            background-color: var(--danger);
        }

        .admin-btn.danger:hover {
            background-color: #dc2626;
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.2);
        }

        .admin-btn.warning {
            background-color: var(--warning);
            color: #7c2d12;
        }

        .admin-btn.warning:hover {
            background-color: #d97706;
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.2);
            color: white;
        }

        .admin-btn.success {
            background-color: var(--success);
        }

        .admin-btn.success:hover {
            background-color: #059669;
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.2);
        }

        .admin-btn.secondary {
            background-color: var(--border-color);
            color: var(--text-dark);
        }

        .admin-btn.secondary:hover {
            background-color: #cbd5e1;
        }

        .admin-btn-group {
            display: flex;
            gap: 8px;
        }

        /* ===== BADGES ===== */
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-success {
            background-color: rgba(16, 185, 129, 0.15);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .badge-danger {
            background-color: rgba(239, 68, 68, 0.15);
            color: #991b1b;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .badge-warning {
            background-color: rgba(245, 158, 11, 0.15);
            color: #92400e;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .badge-info {
            background-color: rgba(6, 182, 212, 0.15);
            color: #0e7490;
            border: 1px solid rgba(6, 182, 212, 0.3);
        }

        .badge-primary {
            background-color: rgba(31, 127, 95, 0.15);
            color: #065f46;
            border: 1px solid rgba(31, 127, 95, 0.3);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .admin-sidebar {
                width: 260px;
            }

            .admin-main {
                margin-left: 260px;
            }

            .admin-topbar-right {
                gap: 15px;
            }

            .admin-content {
                padding: 25px;
            }
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
                flex-wrap: wrap;
                gap: 15px;
            }

            .admin-topbar-left h2 {
                font-size: 18px;
            }

            .admin-user-info {
                border-right: none;
                padding-right: 0;
                order: 2;
                width: 100%;
            }

            .admin-content {
                padding: 15px;
            }

            .admin-table {
                font-size: 12px;
            }

            .admin-table th, .admin-table td {
                padding: 10px 12px;
            }

            .admin-btn {
                padding: 8px 12px;
                font-size: 12px;
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
                <span>Admin</span>
            </div>
        </div>
        <nav>
            <ul class="admin-sidebar-nav">
                <li><a href="{{ route('admin.dashboard') }}" class="@if(Route::current()->getName() === 'admin.dashboard') active @endif"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                <li class="nav-label">Data PPDB</li>
                <li><a href="{{ route('admin.ppdb.index') }}" class="@if(str_contains(Route::current()->getName(), 'admin.ppdb')) active @endif"><i class="fas fa-users"></i> Pendaftar PPDB</a></li>
                <li class="nav-label">Manajemen Konten</li>
                <li><a href="{{ route('admin.activity.index') }}" class="@if(str_contains(Route::current()->getName(), 'admin.activity')) active @endif"><i class="fas fa-calendar-alt"></i> Kegiatan</a></li>
                <li><a href="{{ route('admin.gallery.index') }}" class="@if(str_contains(Route::current()->getName(), 'admin.gallery')) active @endif"><i class="fas fa-image"></i> Galeri</a></li>
                <li><a href="{{ route('admin.announcement.index') }}" class="@if(str_contains(Route::current()->getName(), 'admin.announcement')) active @endif"><i class="fas fa-bell"></i> Pengumuman</a></li>
                <li class="nav-label">Pengaturan</li>
                <li><a href="{{ route('admin.program.index') }}" class="@if(str_contains(Route::current()->getName(), 'admin.program')) active @endif"><i class="fas fa-book"></i> Program</a></li>
                <li><a href="{{ route('admin.faq.index') }}" class="@if(str_contains(Route::current()->getName(), 'admin.faq')) active @endif"><i class="fas fa-question-circle"></i> FAQ</a></li>
                <li><a href="{{ route('admin.school-info.edit') }}" class="@if(str_contains(Route::current()->getName(), 'admin.school-info')) active @endif"><i class="fas fa-sliders-h"></i> Info Sekolah</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <div class="admin-topbar-left">
                <h2>@yield('page-title', 'Dashboard')</h2>
            </div>
            <div class="admin-topbar-right">
                <div class="admin-user-info">
                    <div class="admin-user-avatar">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="admin-user-details">
                        <span class="admin-user-name">{{ Auth::user()->name ?? 'Admin User' }}</span>
                        <span class="admin-user-email">{{ Auth::user()->email ?? 'admin@example.com' }}</span>
                    </div>
                </div>
                <a href="{{ route('home') }}" class="admin-topbar-action">
                    <i class="fas fa-globe"></i> Website
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="admin-topbar-action logout" style="padding: 8px 12px;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="admin-content">
            @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>Sukses!</strong>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
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
