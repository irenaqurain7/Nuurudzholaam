@extends('teacher.layout')

@section('teacher-content')
<style>
    :root {
        --primary: #365B47; /* requested primary */
        --secondary: #567C65;
        --hijau-islam: var(--primary);
        --hijau-light: var(--secondary);
        --hijau-subtle: rgba(54,91,71,0.06);
        --text-dark: #203A2F;
        --text-muted: #667A70;
        --border: #E8ECEF;
        --bg-light: #F5F7F6;
        --putih: #FFFFFF;
    }

    /* Hero Section - Dibuat lebih modern dan anggun */
    .hero-card {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-light) 100%);
        color: var(--putih);
        padding: 2.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(45, 68, 56, 0.12);
        position: relative;
        overflow: hidden;
    }

    /* Top site header (modern sticky header) */
    .site-header {
        background: var(--putih);
        border-bottom: 1px solid var(--border);
        height: 80px;
        box-sizing: border-box;
        padding: 24px 36px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        position: sticky;
        top: 0;
        z-index: 60;
    }

    .site-left { display:flex; align-items:center; gap:16px; }

    .hamburger {
        width:44px; height:44px; border-radius:10px; background:#F4F7F6; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; border: none;
    }
    .hamburger:hover { background:#E8ECEF; }

    .school-logo { width:40px; height:40px; object-fit:contain; border-radius:6px; }

    .brand-block { display:flex; flex-direction:column; gap:6px; }
    .school-name { font-size:32px; font-weight:700; color:#203A2F; line-height:1; }

    .search-bar {
        width:420px; height:48px; border-radius:30px; background:#F5F7F6; display:flex; align-items:center; gap:12px; padding:0 16px; box-shadow: 0 6px 18px rgba(54,91,71,0.04); border: none; outline: none;
    }
    .search-bar input { border:0; background:transparent; outline:none; width:100%; font-size:14px; color:var(--text-dark); }
    .search-bar svg { opacity:0.7; }

    .site-right { display:flex; align-items:center; gap:24px; }
    .date-text { font-size:14px; color:var(--text-dark); }

    .notif { width:44px; height:44px; border-radius:10px; background:#F4F7F6; display:flex; align-items:center; justify-content:center; position:relative; cursor:pointer; }
    .notif-badge { position:absolute; top:6px; right:6px; background:#E23B3B; color:#fff; font-size:12px; font-weight:700; width:20px; height:20px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; }

    .profile { display:flex; align-items:center; gap:12px; cursor:pointer; }
    .profile .avatar { width:40px; height:40px; border-radius:50%; overflow:hidden; }
    .profile .name { font-weight:700; color:var(--text-dark); }
    .profile .subject { font-size:13px; color:var(--text-muted); }

    .chev { width:20px; height:20px; opacity:0.8; }

    /* Dropdown */
    .profile-dropdown { position:absolute; right:36px; top:calc(80px + 12px); width:240px; background:#fff; border-radius:18px; box-shadow:0 20px 40px rgba(31,45,37,0.12); display:none; padding:8px 0; z-index:200; }
    .profile-dropdown a { display:flex; gap:12px; align-items:center; padding:10px 16px; color:var(--text-dark); text-decoration:none; }
    .profile-dropdown a:hover { background:#F4F7F6; }
    .profile-dropdown .sep { height:1px; background:var(--border); margin:6px 0; }

    /* Page content wrapper padding */
    .page-content { padding-top:32px; padding-left:32px; padding-right:32px; }

    .hero-card h1 {
        font-size: 1.85rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .hero-card p {
        font-size: 0.95rem;
        opacity: 0.85;
        margin: 0;
    }

    /* Dashboard Cards Grid */
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background-color: var(--putih);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(45, 68, 56, 0.06);
    }

    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .stat-card h6 {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.75px;
        margin: 0;
        font-weight: 600;
    }

    .stat-card .number {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1;
        margin: 0.25rem 0 1rem 0;
    }

    /* Icon wrappers dengan warna pastel yang clean */
    .icon-wrapper {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
    }

    .stat-card.siswa .icon-wrapper { background-color: rgba(52, 152, 219, 0.1); color: #2980b9; }
    .stat-card.nilai .icon-wrapper { background-color: rgba(46, 204, 113, 0.1); color: #27ae60; }
    .stat-card.jadwal .icon-wrapper { background-color: rgba(243, 156, 18, 0.1); color: #d35400; }
    .stat-card.profil .icon-wrapper { background-color: rgba(155, 89, 182, 0.1); color: #8e44ad; }

    .stat-card a {
        display: inline-flex;
        align-items: center;
        color: var(--hijau-islam);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: color 0.2s;
    }

    .stat-card a:hover {
        color: var(--hijau-light);
    }

    /* Info Card Profile - Dibuat clean tanpa tumpukan gradient kasar */
    .info-card {
        background-color: var(--putih);
        border-radius: 12px;
        border: 1px solid var(--border);
        overflow: hidden;
        width: 100%;
    }

    .info-card-header {
        background-color: var(--hijau-subtle);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .info-card-header h5 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .info-card-header i {
        color: var(--hijau-islam);
        font-size: 1.1rem;
    }

    .info-card-body {
        padding: 1.75rem 1.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem 2rem;
    }

    .info-item {
        border-bottom: 1px solid rgba(45, 68, 56, 0.06);
        padding-bottom: 0.75rem;
    }

    .info-item strong {
        display: block;
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }

    .info-item span {
        color: var(--text-dark);
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* Quick Actions */
    .quick-actions {
        background: transparent;
        border: none;
        box-shadow: none;
    }
    .quick-actions .action-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 18px 22px;
        margin-bottom: 14px;
        border: 1px solid #E7ECE9;
        border-radius: 20px;
        text-decoration: none;
        color: inherit;
        background: var(--putih);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .quick-actions .action-card:last-child {
        margin-bottom: 0;
    }
    .quick-actions .action-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(45, 68, 56, 0.08);
        border-color: rgba(54, 91, 71, 0.16);
    }
    .action-card .action-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: rgba(54,91,71,0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: var(--primary);
        flex-shrink: 0;
        transition: transform .2s ease;
    }
    .action-card:hover .action-icon {
        transform: scale(1.06);
    }
    .action-card-content {
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex: 1;
        min-width: 0;
    }
    .action-title { font-weight:700; font-size:18px; color:var(--text-dark); line-height:1.05; }
    .action-desc { font-size:14px; color:var(--text-muted); line-height:1.5; }
    .action-arrow {
        color:var(--primary);
        font-size:18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
    }
    .action-card:hover .action-arrow { transform: translateX(4px); }
    .section-heading { font-weight:700; color:var(--text-dark); }

    .summary-section {
        margin-bottom: 2rem;
        animation: fadeSlideUp 0.65s ease forwards;
    }

    .summary-section .section-title {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .summary-section .section-subtitle {
        font-size: 0.95rem;
        color: var(--text-muted);
        margin-bottom: 1.75rem;
    }

    .summary-card {
        background: var(--putih);
        border-radius: 20px;
        padding: 24px;
        height: 140px;
        box-shadow: 0 18px 40px rgba(38, 55, 42, 0.08);
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden;
        opacity: 0;
        transform: translateY(18px);
        animation: fadeSlideUp 0.7s ease forwards;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 24px 60px rgba(38, 55, 42, 0.12);
    }

    .summary-card:nth-child(1) {
        animation-delay: 0.05s;
    }
    .summary-card:nth-child(2) {
        animation-delay: 0.12s;
    }
    .summary-card:nth-child(3) {
        animation-delay: 0.18s;
    }
    .summary-card:nth-child(4) {
        animation-delay: 0.24s;
    }

    .summary-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #E8F5E9;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #2E5D4B;
        font-size: 30px;
    }

    .summary-value {
        font-size: 36px;
        font-weight: 700;
        margin: 0.75rem 0 0.25rem;
        color: var(--text-dark);
    }

    .summary-label {
        font-size: 16px;
        font-weight: 600;
        margin: 0;
        color: var(--text-dark);
    }

    .summary-note {
        font-size: 13px;
        color: #8A8A8A;
        margin: 0.5rem 0 0;
        line-height: 1.5;
    }

    @keyframes fadeSlideUp {
        from {
            opacity: 0;
            transform: translateY(18px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .search-bar { width: 100%; }
    }

    /* Action & Navigation Buttons */
    .edit-btn {
        background-color: var(--hijau-islam);
        color: var(--putih);
        border: none;
        padding: 0.6rem 1.25rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }

    .edit-btn:hover {
        background-color: var(--hijau-light);
        color: var(--putih);
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
        .hero-card {
            padding: 1.75rem;
        }
        .hero-card h1 {
            font-size: 1.5rem;
        }
    }
</style>

<header class="site-header">
    <div class="site-left">
        <button class="hamburger" aria-label="Toggle sidebar">
            <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg"><rect y="0" width="20" height="2" rx="1" fill="#203A2F"/><rect y="6" width="20" height="2" rx="1" fill="#203A2F"/><rect y="12" width="20" height="2" rx="1" fill="#203A2F"/></svg>
        </button>

        <img src="{{ asset('images/logo.png') }}" alt="logo" class="school-logo" onerror="this.style.display='none'" />

        <div class="brand-block">
            <div class="search-bar" role="search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24"><path stroke="#203A2F" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35"/><circle cx="11" cy="11" r="6" stroke="#203A2F" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                <input type="search" placeholder="Cari siswa, kelas, mapel..." aria-label="Cari" />
            </div>
        </div>
    </div>

    <div class="site-right">
        <div class="date-text">{{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</div>

        <div class="notif" title="Notifikasi">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 17H9v-6a3 3 0 10-6 0v6H1" stroke="#203A2F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <div class="notif-badge">3</div>
        </div>

        <div class="profile" id="profileToggle">
            <div class="avatar">
                @if(!empty(auth()->user()->photo))
                    <img src="{{ asset('storage/'.auth()->user()->photo) }}" alt="avatar" style="width:100%;height:100%;object-fit:cover;" />
                @else
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5z" fill="#DDEFE7"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6v1H4v-1z" fill="#DDEFE7"/></svg>
                @endif
            </div>
            <div style="display:flex;flex-direction:column;align-items:flex-start;">
                <div class="name">{{ auth()->user()->name ?? 'Test Guru' }}</div>
                <div class="subject">{{ auth()->user()->teacher->specialization ?? 'Matematika' }}</div>
            </div>
            <svg class="chev" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="#203A2F" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
        </div>

        <div class="profile-dropdown" id="profileDropdown" role="menu">
            <a href="{{ route('teacher.profile') }}"><span>👤</span> Profil</a>
            <div class="sep"></div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span>🚪</span> Keluar</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        </div>
    </div>
</header>

<div class="page-content">

    <section class="summary-section">
        <div class="section-title">Ringkasan Hari Ini</div>
        <div class="section-subtitle">Informasi singkat mengenai aktivitas mengajar hari ini.</div>

        <div class="row g-3">
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="summary-card h-100">
                    <div class="summary-icon"><i class="bi bi-calendar-week"></i></div>
                    <div>
                        <p class="summary-value">{{ $jumlahKelasHariIni ?? 0 }}</p>
                        <p class="summary-label">Kelas Hari Ini</p>
                        <p class="summary-note">Jadwal mengajar hari ini.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="summary-card h-100">
                    <div class="summary-icon"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <p class="summary-value">{{ $totalSiswa ?? 0 }}</p>
                        <p class="summary-label">Total Siswa</p>
                        <p class="summary-note">Jumlah siswa yang diajar.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="summary-card h-100">
                    <div class="summary-icon"><i class="bi bi-journal-check"></i></div>
                    <div>
                        <p class="summary-value">{{ $belumDinilai ?? 0 }}</p>
                        <p class="summary-label">Belum Dinilai</p>
                        <p class="summary-note">Tugas yang belum dinilai.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="summary-card h-100">
                    <div class="summary-icon"><i class="bi bi-clock-history"></i></div>
                    <div>
                        <p class="summary-value">{{ $jamMengajar ?? 0 }}</p>
                        <p class="summary-label">Jam Mengajar</p>
                        <p class="summary-note">Total jam mengajar hari ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="section-heading m-0">Quick Actions</h4>
        </div>

        <div class="quick-actions">
            <a href="{{ route('teacher.grades') ?? '#' }}" class="action-card">
                <div class="action-icon"><i class="fas fa-clipboard-check"></i></div>
                <div class="action-card-content">
                    <div class="action-title">Kelola Nilai</div>
                    <div class="action-desc">Kelola nilai siswa dan update catatan penilaian.</div>
                </div>
                <div class="action-arrow"><i class="fas fa-arrow-right"></i></div>
            </a>
            <a href="{{ route('teacher.students') ?? '#' }}" class="action-card">
                <div class="action-icon"><i class="fas fa-check-circle"></i></div>
                <div class="action-card-content">
                    <div class="action-title">Data Siswa</div>
                    <div class="action-desc">Lihat dan kelola data siswa Anda.</div>
                </div>
                <div class="action-arrow"><i class="fas fa-arrow-right"></i></div>
            </a>
            <a href="{{ route('teacher.schedule') ?? '#' }}" class="action-card">
                <div class="action-icon"><i class="fas fa-book-open"></i></div>
                <div class="action-card-content">
                    <div class="action-title">Jadwal Mengajar</div>
                    <div class="action-desc">Cek jadwal mengajar harian dan agenda kelas.</div>
                </div>
                <div class="action-arrow"><i class="fas fa-arrow-right"></i></div>
            </a>
        </div>
    </section>
    <script>
        (function(){
            const toggle = document.getElementById('profileToggle');
            const dropdown = document.getElementById('profileDropdown');
            if (!toggle || !dropdown) return;

            toggle.addEventListener('click', function(e){
                e.stopPropagation();
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', function(){
                dropdown.style.display = 'none';
            });
        })();
    </script>
</div>
@endsection
