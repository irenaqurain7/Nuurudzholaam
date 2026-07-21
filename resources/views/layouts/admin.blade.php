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
            --hijau-islam: #2D4438;
            --hijau-islam-light: #486E5A;
            --hijau-islam-lighter: #5B8572;
            --hijau-dark: #1C2D25;
            --putih: #ffffff;
            --emas: #709D88;
            --emas-light: #E2ECE8;
            --text-dark: #1C2D25;
            --text-light: #5A7E6B;
            --text-muted: #6C8B7C;
            --bg-light: #F4F7F5;
            --bg-white: #ffffff;
            --border-color: #E2ECE8;
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
            width: 250px;
            background: #ffffff;
            color: #1C2D25;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            border-right: 1px solid #E2ECE8;
            z-index: 1000;
            transition: width 0.3s ease;
        }

        .admin-sidebar-header {
            padding: 0 25px 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid #E2ECE8;
        }

        .admin-sidebar-title {
            font-size: 20px;
            font-weight: 700;
            color: #2D4438;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: 0.3px;
        }

        .admin-sidebar-title i {
            color: var(--emas);
        }

        .admin-sidebar-nav {
            list-style: none;
            padding: 0 15px;
        }

        .admin-sidebar-nav li {
            margin-bottom: 2px;
        }

        .admin-sidebar-nav .nav-label {
            margin-top: 20px;
            padding: 10px 15px;
            color: #5A7E6B;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .admin-sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 15px;
            color: #2D4438;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
        }

        .admin-sidebar-nav a:hover {
            background-color: #E2ECE8;
        }

        .admin-sidebar-nav a.active {
            background-color: #E2ECE8;
            color: #2D4438;
            font-weight: 600;
        }

        .admin-sidebar-nav a.active i {
            color: #2D4438;
        }

        .admin-sidebar-nav a i {
            width: 20px;
            text-align: center;
            font-size: 16px;
            color: #5A7E6B;
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .admin-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 2px;
        }

        /* ===== SIDEBAR COLLAPSED ===== */
        .admin-sidebar.collapsed {
            width: 75px;
        }
        .admin-sidebar.collapsed .admin-sidebar-title span {
            display: none;
        }
        .admin-sidebar.collapsed .nav-label {
            display: none;
        }
        .admin-sidebar.collapsed .admin-sidebar-nav a {
            font-size: 0;
            justify-content: center;
            padding: 12px 0;
            gap: 0;
        }
        .admin-sidebar.collapsed .admin-sidebar-nav a i {
            font-size: 18px;
            width: 100%;
        }
        .admin-sidebar.collapsed .admin-sidebar-header {
            flex-direction: column;
            gap: 12px;
            padding-bottom: 12px;
        }
        .admin-main.expanded {
            margin-left: 75px;
        }

        /* ===== MAIN CONTENT ===== */
        .admin-main {
            margin-left: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #F4F7F5;
            transition: margin-left 0.3s ease;
        }

        .admin-topbar {
            background: #F4F7F5;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .admin-topbar-left h2 {
            margin: 0;
            color: #2D4438;
            font-size: 24px;
            font-weight: 700;
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
        }

        .admin-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #E2ECE8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2D4438;
            font-size: 16px;
            font-weight: 700;
        }

        .admin-user-details {
            font-size: 13px;
        }

        .admin-user-name {
            font-weight: 600;
            color: #2D4438;
            display: block;
        }

        .admin-user-email {
            font-size: 11px;
            color: #5A7E6B;
            margin-top: 2px;
        }

        .admin-topbar-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            color: #2D4438;
            background: transparent;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .admin-topbar-action:hover {
            opacity: 0.8;
            color: #1f7f5f;
        }

        .admin-topbar-action i {
            color: #5A7E6B;
            font-size: 16px;
        }

        .admin-topbar-action.logout {
            color: #ef4444;
        }

        .admin-topbar-action.logout i {
            color: #ef4444;
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
            background: #ffffff;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .admin-table thead {
            background: linear-gradient(90deg, #2D4438 0%, #486E5A 100%);
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
            border-bottom: 1px solid #E2ECE8;
            font-size: 14px;
        }

        .admin-table tbody tr {
            transition: all 0.2s ease;
        }

        .admin-table tbody tr:hover {
            background-color: rgba(45, 68, 56, 0.02);
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
            background-color: #2D4438;
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
            background-color: #1f7f5f;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(45, 68, 56, 0.2);
        }

        .admin-btn:active {
            transform: translateY(0);
        }

        .admin-btn.danger {
            background-color: #ef4444;
        }

        .admin-btn.danger:hover {
            background-color: #dc2626;
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.2);
        }

        .admin-btn.warning {
            background-color: #f59e0b;
            color: #7c2d12;
        }

        .admin-btn.warning:hover {
            background-color: #d97706;
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.2);
            color: white;
        }

        .admin-btn.success {
            background-color: #10b981;
        }

        .admin-btn.success:hover {
            background-color: #059669;
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.2);
        }

        .admin-btn.secondary {
            background-color: #E2ECE8;
            color: #2D4438;
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

        /* ===== CUSTOM PAGINATION ===== */
        .custom-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        .custom-pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 600;
            color: var(--hijau-islam);
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .custom-pagination .page-link:hover:not(.disabled):not(.active) {
            background-color: var(--border-color);
            color: var(--text-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.04);
        }

        .custom-pagination .page-link.active {
            background-color: var(--hijau-islam);
            border-color: var(--hijau-islam);
            color: #ffffff;
            cursor: default;
            box-shadow: 0 4px 10px rgba(45, 68, 56, 0.15);
        }

        .custom-pagination .page-link.disabled {
            color: var(--text-muted);
            background-color: #f8faf9;
            border-color: var(--border-color);
            cursor: not-allowed;
            opacity: 0.6;
            box-shadow: none;
            transform: none;
        }

        .custom-pagination .page-numbers {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        @media (max-width: 640px) {
            .custom-pagination .page-numbers {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-sidebar-header" style="display: flex; justify-content: space-between; align-items: center; padding-right: 15px;">
            <div class="admin-sidebar-title">
                <i class="fas fa-building" style="color: var(--emas);"></i>
                <span style="color: #1C2D25;">Admin</span>
            </div>
            <button id="sidebarToggleBtn" style="background: none; border: none; cursor: pointer; color: #5A7E6B; font-size: 18px; padding: 4px;">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <nav>
            <ul class="admin-sidebar-nav">
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Dashboard</a></li>

                <div class="nav-label">MANAJEMEN AKUN</div>
                <li><a href="{{ route('admin.users.create') ?? '#' }}" class="{{ request()->routeIs('admin.users.create') ? 'active' : '' }}"><i class="fas fa-user-plus"></i> Tambah User</a></li>
                <li><a href="{{ route('admin.users.index') ?? '#' }}" class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}"><i class="fas fa-users"></i> Manajer User</a></li>



                <div class="nav-label">ARSIP</div>
                <li><a href="{{ route('admin.users.archive') }}" class="{{ request()->routeIs('admin.users.archive') ? 'active' : '' }}"><i class="fas fa-archive"></i> Arsip User</a></li>


                <div class="nav-label">JADWAL</div>
                <li><a href="{{ route('admin.schedule.teacher.index') }}" class="{{ request()->routeIs('admin.schedule.teacher.*') ? 'active' : '' }}"><i class="fas fa-chalkboard-user"></i> Jadwal Guru</a></li>
                <li><a href="{{ route('admin.schedule.student.index') }}" class="{{ request()->routeIs('admin.schedule.student.*') ? 'active' : '' }}"><i class="fas fa-calendar-days"></i> Jadwal Siswa</a></li>

                <div class="nav-label">BERITA & INFORMASI</div>
                <li><a href="{{ route('admin.announcement.index') }}" class="{{ request()->routeIs('admin.announcement.*') ? 'active' : '' }}"><i class="fas fa-bullhorn"></i> Pengumuman</a></li>

                <div class="nav-label">PANTAU WEBSITE</div>
                <li>
                    <a href="{{ route('admin.activity.index') }}" class="{{ request()->routeIs('admin.activity.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i> Kegiatan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.program.index') }}" class="{{ request()->routeIs('admin.program.*') ? 'active' : '' }}">
                        <i class="fas fa-book-open"></i> Program Pendidikan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.school-info.edit') }}" class="{{ request()->routeIs('admin.school-info.*') ? 'active' : '' }}">
                        <i class="fas fa-info-circle"></i> Info Sekolah
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.faq.index') }}" class="{{ request()->routeIs('admin.faq.*') ? 'active' : '' }}">
                        <i class="fas fa-question-circle"></i> FAQ
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Top Bar -->
        <div class="admin-topbar">
            <div class="admin-topbar-left">
                <h2>@yield('title', 'Dashboard')</h2>
            </div>
            <div class="admin-topbar-right">
                <div class="admin-user-info">
                    <div class="admin-user-avatar">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="admin-user-details">
                        <span class="admin-user-name">{{ Auth::user()->name ?? 'Admin Nuurudzholaam' }}</span>
                        <span class="admin-user-email">{{ Auth::user()->email ?? 'admin@nuurudzholaam.sch.id' }}</span>
                    </div>
                </div>
                <a href="{{ url('/') }}" class="admin-topbar-action" style="text-decoration: none; display: flex; align-items: center; gap: 5px; color: #6b7280; font-weight: 600;" target="_blank">
                    <i class="fas fa-globe"></i> Website
                </a>
                <button type="button" onclick="showLogoutModal(event)" class="admin-topbar-action logout" style="background:none; border:none; display: flex; align-items: center; gap: 5px; color: #ef4444; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
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

    <!-- Logout Modal -->
    <div id="logoutModal" class="logout-modal" style="display: none;">
        <div class="logout-modal-content">
            <h3>Apakah Anda yakin ingin keluar?</h3>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <div class="logout-modal-buttons">
                <button type="button" class="btn-cancel" onclick="closeLogoutModal()">Batal</button>
                <button type="button" class="btn-logout" onclick="confirmLogout()">Keluar</button>
            </div>
        </div>
    </div>

    <style>
        .logout-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .logout-modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
            min-width: 300px;
        }

        .logout-modal-content h3 {
            margin: 0 0 25px;
            font-size: 18px;
            color: #333;
            font-weight: 600;
        }

        .logout-modal-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .logout-modal-buttons button {
            padding: 10px 24px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel {
            background-color: #e5e7eb;
            color: #333;
        }

        .btn-cancel:hover {
            background-color: #d1d5db;
        }

        .btn-logout {
            background-color: #ef4444;
            color: white;
        }

        .btn-logout:hover {
            background-color: #dc2626;
        }
    </style>

    <script>
        function showLogoutModal(event) {
            event.preventDefault();
            document.getElementById('logoutModal').style.display = 'flex';
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }

        function confirmLogout() {
            document.getElementById('logout-form').submit();
        }

        document.getElementById('sidebarToggleBtn').addEventListener('click', function() {
            const sidebar = document.getElementById('adminSidebar');
            const main = document.querySelector('.admin-main');
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
        });
    </script>

    @stack('scripts')
</body>
</html>
</html>
