@extends('teacher.layout')

@section('teacher-content')
@php
    use Carbon\Carbon;

    // ---- Helpers ----
    if (!function_exists('dsGuessGender')) {
        function dsGuessGender(string $name): string {
            $name = mb_strtolower($name);
            $female = [
                'siti','nurul','ayu','yunita','rahma','vani','ajeng','eti','neng','syaidah',
                'mega','dea','widya','mela','novi','suryani','asti','dinda','anita','indah',
                'putri','gustiani','hidayah','kanesha','ayra','selva','ismania','citra',
                'lestari','sari','dewi','ratih','wulan','dian','rini','sri','tuti','nina',
                'maya','linda','ratna','aulia','safira','nisa','zahra','nadia','amalia',
                'fatimah','aisyah','khadijah','aminah','maryam','zainab','asma','hafsah',
            ];
            foreach ($female as $kw) {
                if (mb_strpos($name, $kw) !== false) return 'Perempuan';
            }
            return 'Laki-laki';
        }
    }

    if (!function_exists('dsSchoolLevel')) {
        function dsSchoolLevel(string $class): string {
            if (preg_match('/^(VII|VIII|IX|7|8|9)\b/i', $class)) return 'SMP';
            if (preg_match('/^(X|XI|XII|10|11|12)\b|OTKP|AKUNTANSI/i', $class)) return 'SMK';
            return 'SD';
        }
    }

    // ---- Resolve wali-kelas data ----
    $homeroomStudents = collect();
    $homeroomClass    = $homeroomClass ?? null;
    $targetClass      = '';

    if ($homeroomClass) {
        $targetClass = $homeroomClass;
        // Try DB first
        $homeroomStudents = $studentsByClass->get($homeroomClass, collect());
        // Flatten fallback stubs
        if ($homeroomStudents->isEmpty()) {
            $homeroomStudents = $students ?? collect();
        }
    } else {
        // No homeroom detected — use first class from studentsByClass
        $firstKey = ($studentsByClass ?? collect())->keys()->first();
        if ($firstKey) {
            $targetClass      = $firstKey;
            $homeroomStudents = $studentsByClass->get($firstKey, collect());
        }
    }

    $studentsCount = $homeroomStudents->count();
    $jenjang       = $targetClass ? dsSchoolLevel($targetClass) : 'SD';
    $tahunAjaran   = '2025/2026';
@endphp

{{-- ============================================================
     STYLES
     ============================================================ --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    .ds-page { font-family: 'Poppins', sans-serif; color: #111827; }

    /* Header */
    .ds-title   { font-size: 1.75rem; font-weight: 700; margin-bottom: 2px; }
    .ds-subtitle{ font-size: .95rem; color: #6B7280; margin-bottom: 0; }

    /* Card base */
    .ds-card {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        box-shadow: 0 1px 6px rgba(0,0,0,.05);
    }

    /* Info card */
    .ds-info-card {
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: nowrap;          /* force single row on desktop */
        min-height: 100px;
    }
    .ds-info-left {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-shrink: 0;
    }
    .ds-icon-box  {
        width: 56px; height: 56px;
        border-radius: 12px;
        background: rgba(31,77,59,.09);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .ds-icon-box i  { font-size: 1.5rem; color: #1F4D3B; }
    .ds-class-name  { font-size: 1.6rem; font-weight: 800; color: #1F4D3B; line-height: 1.1; }
    .ds-school-sub  { font-size: .78rem; color: #9CA3AF; margin-top: 1px; }

    .ds-stats-row {
        display: flex;
        align-items: center;
        gap: 0;
        flex: 1 1 auto;
        justify-content: center;
    }
    .ds-stat-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 24px;
        border-right: 1px solid #E5E7EB;
    }
    .ds-stat-item:first-child { border-left: 1px solid #E5E7EB; }
    .ds-stat-label { font-size: .7rem; color: #6B7280; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 1px; }
    .ds-stat-value { font-size: 1.15rem; font-weight: 700; color: #111827; line-height: 1.2; }
    .ds-stat-sub   { font-size: .75rem; color: #9CA3AF; }
    .ds-stat-icon  { font-size: 1rem; color: #1F4D3B; opacity: .75; flex-shrink: 0; }

    /* Responsive: stack on mobile */
    @media (max-width: 768px) {
        .ds-info-card   { flex-wrap: wrap; min-height: unset; }
        .ds-stats-row   { justify-content: flex-start; flex-wrap: wrap; width: 100%; }
        .ds-stat-item   { border-left: none !important; padding: 12px 16px; }
        .ds-stat-item:first-child { border-left: none !important; }
    }

    /* Print button */
    .btn-ds-print {
        background: #1F4D3B; color: #fff;
        border: none; border-radius: 10px;
        padding: 11px 22px; font-size: .9rem;
        font-weight: 600; font-family: 'Poppins',sans-serif;
        display: inline-flex; align-items: center; gap: 8px;
        transition: background .2s;
        white-space: nowrap;
    }
    .btn-ds-print:hover { background: #163829; color: #fff; }

    /* Search */
    .ds-search-wrap {
        display: flex; align-items: center; gap: 10px;
        background: #fff; border: 1.5px solid #E5E7EB;
        border-radius: 10px; padding: 9px 16px;
        max-width: 400px;
        transition: border-color .2s, box-shadow .2s;
    }
    .ds-search-wrap:focus-within {
        border-color: #1F4D3B;
        box-shadow: 0 0 0 3px rgba(31,77,59,.12);
    }
    .ds-search-wrap i   { color: #9CA3AF; font-size: 1rem; flex-shrink: 0; }
    .ds-search-input {
        border: none; outline: none; background: transparent;
        font-size: .93rem; color: #111827; width: 100%;
        font-family: 'Poppins', sans-serif;
    }

    /* Table */
    .ds-table thead th {
        background: #F9FAFB;
        font-size: .75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .05em;
        color: #6B7280;
        padding: 14px 20px;
        border-bottom: 1.5px solid #E5E7EB;
        white-space: nowrap;
    }
    .ds-table tbody td {
        padding: 15px 20px;
        font-size: .9rem;
        border-bottom: 1px solid #F3F4F6;
        vertical-align: middle;
    }
    .ds-table tbody tr:last-child td { border-bottom: none; }
    .ds-table tbody tr:hover td { background: #FAFAFA; }

    /* Gender badge */
    .badge-laki      { background: #EFF6FF; color: #1D4ED8; }
    .badge-perempuan { background: #FDF2F8; color: #9D174D; }
    .ds-gender-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 999px;
        font-size: .78rem; font-weight: 600;
    }

    /* Status badge */
    .badge-aktif {
        background: #ECFDF5; color: #059669;
        display: inline-block; padding: 4px 12px;
        border-radius: 999px; font-size: .78rem; font-weight: 600;
    }

    /* Detail btn */
    .btn-ds-detail {
        border: 1.5px solid #1F4D3B; color: #1F4D3B;
        background: transparent; border-radius: 8px;
        padding: 5px 14px; font-size: .82rem; font-weight: 600;
        display: inline-flex; align-items: center; gap: 5px;
        text-decoration: none;
        transition: background .15s, color .15s;
    }
    .btn-ds-detail:hover { background: #1F4D3B; color: #fff; }

    /* Note card */
    .ds-note-card {
        background: #F0FDF4; border: 1px solid #BBF7D0;
        border-radius: 12px; padding: 16px 20px;
    }
    .ds-note-card .note-icon { color: #16A34A; font-size: 1.05rem; margin-right: 6px; }
    .ds-note-card .note-title { font-weight: 700; color: #15803D; margin-bottom: 2px; }
    .ds-note-card .note-text  { font-size: .88rem; color: #166534; margin: 0; }

    /* Empty state */
    .ds-empty { padding: 56px 24px; text-align: center; color: #9CA3AF; }
    .ds-empty i { font-size: 2.5rem; margin-bottom: 12px; display: block; opacity: .4; }

    /* Pagination */
    .ds-pager {
        display: flex; gap: 4px;
        list-style: none; padding: 0; margin: 0; flex-wrap: wrap;
    }
    .ds-pager .page-link {
        border: 1.5px solid #E5E7EB; border-radius: 8px;
        padding: 5px 12px; font-size: .82rem; font-weight: 600;
        color: #6B7280; background: #fff; text-decoration: none;
        transition: all .15s;
    }
    .ds-pager .page-item.active .page-link  { background: #1F4D3B; border-color: #1F4D3B; color: #fff; }
    .ds-pager .page-item.disabled .page-link{ background: #F9FAFB; color: #D1D5DB; }

    /* ============ PRINT ============ */
    .ds-print-only { display: none; }
    @media print {
        body * { visibility: hidden !important; }
        .ds-print-only, .ds-print-only * { visibility: visible !important; }
        .ds-print-only {
            display: block !important;
            position: absolute; top: 0; left: 0;
            width: 100%; padding: 32px;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .ds-print-school  { font-size: 16pt; font-weight: 800; text-align: center; }
        .ds-print-subt    { font-size: 10pt; text-align: center; color: #555; margin-bottom: 6px; }
        .ds-print-rule    { border: none; border-top: 2px solid #1F4D3B; margin: 10px 0 16px; }
        .ds-print-kelas   { font-size: 13pt; font-weight: 700; margin-bottom: 2px; }
        .ds-print-meta    { font-size: 10pt; color: #555; margin-bottom: 14px; }
        .ds-print-table   { width: 100%; border-collapse: collapse; }
        .ds-print-table th{
            background: #1F4D3B !important; -webkit-print-color-adjust: exact;
            print-color-adjust: exact; color: #fff;
            padding: 8px 12px; font-size: 10pt; text-align: left;
        }
        .ds-print-table td{ padding: 7px 12px; border-bottom: 1px solid #ddd; font-size: 9.5pt; }
        .ds-print-table tr:nth-child(even) td {
            background: #f0f9f4 !important;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }
        .ds-print-foot    { margin-top: 28px; font-size: 9pt; color: #999; text-align: right; }
    }
</style>

{{-- ============================================================
     PRINT AREA (hidden on screen)
     ============================================================ --}}
<div class="ds-print-only">
    <div class="ds-print-school">Sekolah Nuurudzholaam</div>
    <div class="ds-print-subt">Daftar Siswa — Kelas {{ $targetClass }} — Jenjang {{ $jenjang }}</div>
    <hr class="ds-print-rule">
    <div class="ds-print-kelas">Kelas {{ $targetClass }}</div>
    <div class="ds-print-meta">
        Jumlah Siswa: <strong>{{ $studentsCount }}</strong> &bull; Tahun Ajaran: {{ $tahunAjaran }}
    </div>
    <table class="ds-print-table">
        <thead>
            <tr>
                <th style="width:34px">No</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Jenis Kelamin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($homeroomStudents as $i => $s)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $s->user->name }}</td>
                <td>{{ $s->nisn ?: '-' }}</td>
                <td>{{ dsGuessGender($s->user->name) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="ds-print-foot">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</div>
</div>

{{-- ============================================================
     PAGE CONTENT
     ============================================================ --}}
<div class="ds-page">

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="ds-title">Data Siswa</h1>
        <p class="ds-subtitle">Daftar siswa pada kelas yang Anda wali.</p>
    </div>

    @if($targetClass)

    {{-- ── Info Card ── --}}
    <div class="ds-card ds-info-card mb-4">

        {{-- LEFT: icon + class name --}}
        <div class="ds-info-left">
            <div class="ds-icon-box">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="ds-stat-label" style="margin-bottom:2px;">Kelas</div>
                <div class="ds-class-name">{{ $targetClass }}</div>
                <div class="ds-school-sub">{{ $jenjang }} Nuurudzholaam</div>
            </div>
        </div>

        {{-- MIDDLE: 3 stats --}}
        <div class="ds-stats-row">
            {{-- Jumlah Siswa --}}
            <div class="ds-stat-item">
                <i class="ds-stat-icon fas fa-user-graduate"></i>
                <div>
                    <div class="ds-stat-label">Jumlah Siswa</div>
                    <div class="ds-stat-value">{{ $studentsCount }}</div>
                    <div class="ds-stat-sub">Siswa</div>
                </div>
            </div>
            {{-- Jenjang --}}
            <div class="ds-stat-item">
                <i class="ds-stat-icon fas fa-graduation-cap"></i>
                <div>
                    <div class="ds-stat-label">Jenjang</div>
                    <div class="ds-stat-value">{{ $jenjang }}</div>
                </div>
            </div>
            {{-- Tahun Ajaran --}}
            <div class="ds-stat-item">
                <i class="ds-stat-icon fas fa-calendar-alt"></i>
                <div>
                    <div class="ds-stat-label">Tahun Ajaran</div>
                    <div class="ds-stat-value">{{ $tahunAjaran }}</div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Cetak button --}}
        <button class="btn-ds-print flex-shrink-0" onclick="window.print()">
            <i class="fas fa-download"></i> Cetak Daftar Siswa
        </button>
        </div>
    </div>

    {{-- ── Search ── --}}
    <div class="mb-4">
        <div class="ds-search-wrap">
            <i class="fas fa-search"></i>
            <input id="dsSearch" type="text" class="ds-search-input"
                   placeholder="Cari nama atau NISN siswa...">
        </div>
    </div>

    {{-- ── Table Card ── --}}
    <div class="ds-card mb-4">
        <div class="table-responsive">
            <table class="table ds-table mb-0">
                <thead>
                    <tr>
                        <th style="padding-left:24px; width:48px;">No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Status</th>
                        <th style="text-align:center; padding-right:24px; width:110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dsTableBody">
                    @forelse($homeroomStudents as $i => $s)
                    @php $gender = dsGuessGender($s->user->name); @endphp
                    <tr class="ds-row"
                        data-name="{{ mb_strtolower($s->user->name) }}"
                        data-nisn="{{ $s->nisn }}">
                        <td class="text-muted" style="padding-left:24px;">{{ $i + 1 }}</td>
                        <td class="font-monospace" style="font-size:.88rem; color:#374151;">
                            {{ $s->nisn ?: '—' }}
                        </td>
                        <td class="fw-semibold">{{ $s->user->name }}</td>
                        <td>
                            @if($gender === 'Perempuan')
                                <span class="ds-gender-badge badge-perempuan">
                                    <i class="fas fa-venus"></i> Perempuan
                                </span>
                            @else
                                <span class="ds-gender-badge badge-laki">
                                    <i class="fas fa-mars"></i> Laki-laki
                                </span>
                            @endif
                        </td>
                        <td><span class="badge-aktif">Aktif</span></td>
                        <td style="text-align:center; padding-right:24px;">
                            @if($s->id)
                                <a href="{{ route('teacher.students.show', $s->id) }}"
                                   class="btn-ds-detail">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            @else
                                <span class="btn-ds-detail" style="opacity:.4; pointer-events:none;">
                                    <i class="fas fa-eye"></i> Detail
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="ds-empty">
                                <i class="fas fa-user-slash"></i>
                                Belum ada data siswa pada kelas ini.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Empty search result --}}
        <div id="dsNoResult" style="display:none;" class="ds-empty">
            <i class="fas fa-search"></i>
            Tidak ada siswa yang cocok dengan pencarian.
        </div>

        @if($studentsCount > 0)
        <div class="px-4 py-3 d-flex flex-wrap align-items-center justify-content-between gap-3"
             style="border-top: 1px solid #F3F4F6;">
            <span class="text-muted" style="font-size:.83rem;">
                Menampilkan {{ $studentsCount }} siswa
            </span>
            <nav>
                <ul class="ds-pager">
                    <li class="page-item disabled"><a class="page-link" href="#">← Sebelumnya</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#">Selanjutnya →</a></li>
                </ul>
            </nav>
        </div>
        @endif
    </div>

    {{-- ── Note Card ── --}}
    <div class="ds-note-card">
        <div class="d-flex align-items-start gap-2">
            <i class="fas fa-info-circle note-icon mt-1"></i>
            <div>
                <div class="note-title">Catatan</div>
                <p class="note-text">
                    Menu ini hanya menampilkan siswa pada kelas yang Anda wali.
                    Untuk melihat siswa pada kelas lain, gunakan menu
                    <strong>Jadwal Mengajar</strong> atau <strong>Kelola Nilai</strong>.
                </p>
            </div>
        </div>
    </div>

    @else
    {{-- No homeroom detected --}}
    <div class="ds-card p-5 text-center">
        <i class="fas fa-chalkboard-teacher d-block mb-3" style="font-size:3rem; color:#D1D5DB;"></i>
        <h5 class="fw-bold mb-2" style="color:#374151;">Belum Ada Kelas Wali</h5>
        <p class="text-muted mb-0">Anda belum ditetapkan sebagai wali kelas. Silakan hubungi administrator.</p>
    </div>
    @endif

</div>{{-- /ds-page --}}

{{-- ============================================================
     SEARCH JS
     ============================================================ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input    = document.getElementById('dsSearch');
    const rows     = document.querySelectorAll('.ds-row');
    const noResult = document.getElementById('dsNoResult');
    if (!input) return;

    input.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        let visible = 0;
        rows.forEach(function (row) {
            const name = row.dataset.name || '';
            const nisn = row.dataset.nisn || '';
            const match = name.includes(q) || nisn.includes(q);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        noResult.style.display = (visible === 0 && q !== '') ? 'block' : 'none';
    });
});
</script>
@endsection
