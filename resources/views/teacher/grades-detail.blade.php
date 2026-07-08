@extends('teacher.layout')

@section('title', 'Kelola Nilai')

@section('teacher-content')
@php
    $classCard = $classCard ?? [];
    $rows = collect($rows ?? []);
    $availableSubjects = collect($availableSubjects ?? []);
    $subjectCards = collect($subjectCards ?? []);
    $activeSubject = $activeSubject ?? null;
    $semester = $semester ?? '-';
    $academicYear = $academicYear ?? '-';
    $returnTo = url()->full();
    $storeGradeUrl = route('teacher.grades.store');
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
    .detail-shell {
        background: #F8FAF9;
        border-radius: 24px;
        min-height: calc(100vh - 80px);
        padding: 24px 0 40px;
        font-family: 'Poppins', sans-serif;
        color: #1F2937;
    }

    .detail-hero {
        background: linear-gradient(135deg, rgba(31, 77, 59, 0.06), rgba(46, 125, 99, 0.02));
        border: 1px solid rgba(31, 77, 59, 0.06);
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.03);
    }

    .detail-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.45rem 0.8rem;
        border-radius: 999px;
        background: rgba(31, 77, 59, 0.08);
        color: #1F4D3B;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .detail-title {
        color: #1F4D3B;
        font-weight: 800;
        letter-spacing: -0.03em;
        margin: 12px 0 8px;
        font-size: clamp(1.8rem, 2.2vw, 2.5rem);
    }

    .detail-subtitle {
        color: #5F6F69;
        margin: 0;
        max-width: 760px;
        line-height: 1.7;
        font-size: 0.98rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-top: 18px;
    }

    .info-chip {
        background: #fff;
        border: 1px solid rgba(31, 77, 59, 0.08);
        border-radius: 16px;
        padding: 14px 16px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }

    .info-chip small {
        display: block;
        color: #64748B;
        font-size: 0.78rem;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .info-chip strong {
        color: #163827;
        font-size: 0.95rem;
        font-weight: 700;
    }

    .panel-card {
        background: #fff;
        border: 1px solid rgba(31, 77, 59, 0.08);
        border-radius: 18px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.05);
    }

    .panel-card .card-body,
    .panel-card .card-header {
        padding: 22px;
    }

    .panel-card .card-header {
        background: transparent;
        border-bottom: 1px solid rgba(148, 163, 184, 0.14);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .panel-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #1F2937;
    }

    .subject-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .subject-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border-radius: 16px;
        border: 1px solid rgba(31, 77, 59, 0.08);
        background: #fff;
        padding: 18px 20px;
        text-decoration: none;
        color: inherit;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }

    .subject-card:hover {
        transform: translateY(-3px);
        border-color: rgba(31, 77, 59, 0.16);
        box-shadow: 0 12px 20px rgba(15, 23, 42, 0.08);
    }

    .subject-card.active {
        border-color: rgba(46, 125, 99, 0.3);
        background: linear-gradient(135deg, rgba(46, 125, 99, 0.08), rgba(31, 77, 59, 0.04));
    }

    .subject-name {
        font-weight: 700;
        color: #163827;
        margin: 0;
    }

    .subject-note {
        margin: 4px 0 0;
        color: #64748B;
        font-size: 0.85rem;
    }

    .table-modern {
        margin: 0;
        color: #334155;
    }

    .table-modern thead th {
        border-bottom: 1px solid rgba(148, 163, 184, 0.18) !important;
        color: #64748B;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 700;
        padding-top: 0.9rem;
        padding-bottom: 0.9rem;
        background: #F8FAFC;
    }

    .table-modern tbody td {
        padding-top: 0.95rem;
        padding-bottom: 0.95rem;
        vertical-align: middle;
        border-color: rgba(148, 163, 184, 0.12);
    }

    .table-wrap {
        overflow: hidden;
        border-radius: 18px;
    }

    .student-name {
        font-weight: 700;
        color: #163827;
    }

    .score-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 72px;
        padding: 0.42rem 0.7rem;
        border-radius: 999px;
        background: rgba(31, 77, 59, 0.08);
        color: #1F4D3B;
        font-weight: 700;
    }

    .grade-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .grade-control-box {
        background: linear-gradient(135deg, rgba(31, 77, 59, 0.04), rgba(46, 125, 99, 0.02));
        border: 1px solid rgba(31, 77, 59, 0.08);
        border-radius: 16px;
        padding: 14px 16px;
        margin-bottom: 16px;
    }

    .grade-control-box strong {
        color: #163827;
    }

    .empty-state {
        border: 1px dashed rgba(100, 116, 139, 0.26);
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.78);
        padding: 34px 20px;
        text-align: center;
        color: #64748B;
    }

    /* ---- Rekap Nilai ---- */
    .rekap-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .rekap-stat-card {
        display: flex;
        align-items: center;
        gap: 14px;
        background: #fff;
        border: 1px solid rgba(31, 77, 59, 0.08);
        border-radius: 16px;
        padding: 16px 18px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }

    .rekap-stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    .rekap-stat-label {
        font-size: 0.75rem;
        color: #64748B;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .rekap-stat-value {
        font-size: 1.35rem;
        font-weight: 800;
        color: #163827;
        line-height: 1.2;
        display: flex;
        align-items: baseline;
        gap: 4px;
    }

    .rekap-progress-track {
        height: 10px;
        border-radius: 999px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .rekap-progress-bar {
        height: 100%;
        border-radius: 999px;
        transition: width 0.6s ease;
    }

    /* Predikat badges */
    .rekap-pred {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
    }
    .rekap-pred-a    { background: #dcfce7; color: #15803d; }
    .rekap-pred-b    { background: #dbeafe; color: #1d4ed8; }
    .rekap-pred-c    { background: #fef9c3; color: #a16207; }
    .rekap-pred-d    { background: #ffedd5; color: #c2410c; }
    .rekap-pred-e    { background: #fee2e2; color: #b91c1c; }
    .rekap-pred-none { background: #f1f5f9; color: #94a3b8; }

    @media (max-width: 991.98px) {
        .detail-shell {
            border-radius: 18px;
            padding-top: 20px;
        }

        .info-grid,
        .subject-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .rekap-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575.98px) {
        .info-grid,
        .subject-grid,
        .rekap-stats {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="detail-shell">
    <div class="container">
        <section class="detail-hero mb-4">
            <span class="detail-kicker"><i class="bi bi-journal-text"></i> Kelola Nilai</span>
            <h1 class="detail-title">Kelas {{ $classCard['class'] }}</h1>
            <p class="detail-subtitle">Pilih mata pelajaran untuk melihat daftar nilai siswa. SD menampilkan pilihan mapel terlebih dahulu, sedangkan SMP dan SMK langsung ke tabel nilai.</p>

            <div class="info-grid">
                <div class="info-chip">
                    <small>Semester</small>
                    <strong>{{ $semester }}</strong>
                </div>
                <div class="info-chip">
                    <small>Tahun Ajaran</small>
                    <strong>{{ $academicYear }}</strong>
                </div>
                <div class="info-chip">
                    <small>Status</small>
                    <strong>{{ $classCard['status'] ?? 'Guru Mapel' }}</strong>
                </div>
                <div class="info-chip">
                    <small>Jumlah Siswa</small>
                    <strong>{{ $classCard['student_label'] ?? '-' }}</strong>
                </div>
            </div>
        </section>

        <div class="mb-3">
            <a href="{{ route('teacher.grades') }}" class="back-link">
                <i class="bi bi-arrow-left"></i> Kembali ke daftar kelas
            </a>
        </div>

        @if ($level === 'sd')
            <section class="panel-card mb-4">
                @if ($activeSubject)
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="panel-title">Mata Pelajaran Terpilih</h2>
                            <div class="text-muted small">Hanya menampilkan mapel yang sedang dikelola</div>
                        </div>
                        <a href="{{ route('teacher.grades.detail', ['level' => $level, 'classSlug' => $classCard['slug']]) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                            <i class="bi bi-arrow-left-right me-1"></i> Ganti Mapel
                        </a>
                    </div>
                @else
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h2 class="panel-title">Pilih Mata Pelajaran</h2>
                            <span class="badge text-bg-light border rounded-pill px-3 py-2 mt-1">{{ $availableSubjects->count() }} mapel</span>
                        </div>
                        <a href="{{ route('teacher.grades.rekap', ['level' => $level, 'classSlug' => $classCard['slug']]) }}" 
                           class="btn btn-sm btn-success rounded-pill px-3 d-flex align-items-center gap-1 fw-semibold"
                           style="background: #1F4D3B; border-color: #1F4D3B;">
                            <i class="bi bi-download"></i> Unduh Rekap Keseluruhan
                        </a>
                    </div>
                @endif
                <div class="card-body">
                    @if ($activeSubject)
                        <div class="alert alert-success border-0 mb-3" style="background: rgba(46, 125, 99, 0.08); color: #1F4D3B; border-radius: 14px;">
                            Anda sedang melihat nilai untuk <strong>{{ $activeSubject }}</strong>.
                        </div>
                    @else
                        <div class="alert alert-info border-0 mb-3" style="background: rgba(59, 130, 246, 0.08); color: #1E40AF; border-radius: 14px;">
                            Guru harus memilih mata pelajaran terlebih dahulu sebelum tabel nilai ditampilkan.
                        </div>
                    @endif

                    <div class="subject-grid {{ $activeSubject ? 'd-flex justify-content-start' : '' }}">
                        @forelse ($subjectCards as $subjectCard)
                            @if (!$activeSubject || $activeSubject === $subjectCard['name'])
                                <a href="{{ $subjectCard['url'] }}" class="subject-card {{ $activeSubject === $subjectCard['name'] ? 'active' : '' }}" style="{{ $activeSubject ? 'max-width: 400px; width: 100%;' : '' }}">
                                    <div>
                                        <p class="subject-name">{{ $subjectCard['name'] }}</p>
                                        <p class="subject-note">{{ $activeSubject ? 'Mata pelajaran aktif' : 'Klik untuk membuka tabel nilai' }}</p>
                                    </div>
                                    @if ($activeSubject)
                                        <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                                    @else
                                        <i class="bi bi-arrow-right-circle fs-4 text-success"></i>
                                    @endif
                                </a>
                            @endif
                        @empty
                            <div class="empty-state w-100">
                                Belum ada mata pelajaran yang bisa ditampilkan untuk kelas ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        @endif

        @if ($level !== 'sd' || $activeSubject)
            <section class="panel-card">
                <div class="card-header">
                    <div>
                        <h2 class="panel-title mb-1">Tabel Nilai Siswa</h2>
                        <div class="text-muted small">{{ $classCard['class'] }} @if($activeSubject) • {{ $activeSubject }} @endif</div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap justify-content-end">
                        <span class="badge text-bg-light border rounded-pill px-3 py-2">{{ $rows->count() }} siswa</span>
                        @if ($rows->isNotEmpty())
                            <button type="button"
                                    class="btn btn-success rounded-pill px-3 js-open-grade-modal"
                                    data-action="{{ route('teacher.grades.store') }}"
                                    data-method=""
                                    data-title="Tambah Nilai Baru"
                                    data-student-id="{{ $rows->first()['student']->id ?? '' }}"
                                    data-grade=""
                                    data-notes=""
                                    data-grade-id="">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Nilai
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="grade-control-box mx-3 mt-3">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <strong>Kelola nilai langsung dari tabel</strong>
                                <div class="text-muted small">Klik Edit untuk memperbarui nilai, atau Hapus untuk menghapus input yang salah.</div>
                            </div>
                            <div class="text-muted small">Perubahan akan kembali ke halaman ini.</div>
                        </div>
                    </div>
                    <div class="table-responsive table-wrap">
                        <table class="table table-modern align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 72px;">No</th>
                                    <th>Nama Siswa</th>
                                    <th style="width: 130px;">NISN</th>
                                    <th style="width: 120px;">Nilai</th>
                                    <th>Catatan</th>
                                    <th style="width: 140px;">Update</th>
                                    <th style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rows as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="student-name">{{ $row['student']->user->name ?? 'Nama siswa' }}</div>
                                            <div class="text-muted small">{{ $classCard['class'] }}</div>
                                        </td>
                                        <td>{{ $row['student']->nisn ?? '-' }}</td>
                                        <td><span class="score-pill">{{ $row['score'] }}</span></td>
                                        <td>{{ $row['notes'] }}</td>
                                        <td>{{ $row['updated_at'] }}</td>
                                        <td>
                                            <div class="grade-actions">
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-success js-open-grade-modal"
                                                        data-action="{{ $row['grade_id'] ? route('teacher.grades.update', $row['grade_id']) : route('teacher.grades.store') }}"
                                                        data-method="{{ $row['grade_id'] ? 'PUT' : '' }}"
                                                        data-title="{{ $row['grade_id'] ? 'Edit Nilai' : 'Tambah Nilai' }}"
                                                        data-student-id="{{ $row['student']->id }}"
                                                        data-grade="{{ $row['grade'] ? $row['grade']->grade : '' }}"
                                                        data-notes="{{ e($row['grade'] && $row['grade']->notes ? $row['grade']->notes : '') }}"
                                                        data-grade-id="{{ $row['grade_id'] ?? '' }}">
                                                    <i class="bi bi-pencil-square me-1"></i> {{ $row['grade_id'] ? 'Edit' : 'Tambah' }}
                                                </button>

                                                @if ($row['grade_id'])
                                                    <form method="POST"
                                                          action="{{ route('teacher.grades.delete', $row['grade_id']) }}"
                                                          class="js-delete-grade"
                                                          data-confirm="{{ 'Hapus nilai ' . ($row['student']->user->name ?? 'ini') . '?' }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="return_to" value="{{ $returnTo }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state my-3">
                                                Belum ada data siswa atau nilai untuk kelas ini.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            {{-- ============================================================
                 REKAP NILAI
                 ============================================================ --}}
            @php
                $gradedRows = $rows->filter(fn($r) => $r['grade_id'] !== null);
                $scores     = $gradedRows->map(fn($r) => (float) $r['grade']->grade)->values();
                $avg        = $scores->isNotEmpty() ? round($scores->avg(), 1) : null;
                $highest    = $scores->isNotEmpty() ? $scores->max() : null;
                $lowest     = $scores->isNotEmpty() ? $scores->min() : null;
                $passCount  = $scores->filter(fn($s) => $s >= 75)->count();
                $passRate   = $scores->isNotEmpty() ? round($passCount / $scores->count() * 100) : null;

                $rekapUrl = route('teacher.grades.rekap', [
                    'level'      => $level,
                    'classSlug'  => $classCard['slug'],
                ]);
                if ($activeSubject) {
                    $rekapUrl .= '?subject=' . urlencode($activeSubject);
                }
            @endphp

            <section class="panel-card mt-4" id="rekap-nilai">
                <div class="card-header">
                    <div>
                        <h2 class="panel-title mb-1">
                            <i class="bi bi-bar-chart-line me-2" style="color:#1F4D3B;"></i>Rekap Nilai
                        </h2>
                        <div class="text-muted small">Ringkasan statistik & unduh laporan nilai</div>
                    </div>
                </div>
                <div class="card-body">

                    {{-- Stat cards --}}
                    @if ($scores->isNotEmpty())
                    <div class="rekap-stats mb-4">
                        <div class="rekap-stat-card">
                            <div class="rekap-stat-icon" style="background:rgba(31,77,59,.1);color:#1F4D3B;">
                                <i class="bi bi-calculator"></i>
                            </div>
                            <div>
                                <div class="rekap-stat-label">Rata-rata Nilai</div>
                                <div class="rekap-stat-value">{{ $avg }}</div>
                            </div>
                        </div>
                        <div class="rekap-stat-card">
                            <div class="rekap-stat-icon" style="background:rgba(34,197,94,.1);color:#16a34a;">
                                <i class="bi bi-arrow-up-circle"></i>
                            </div>
                            <div>
                                <div class="rekap-stat-label">Nilai Tertinggi</div>
                                <div class="rekap-stat-value" style="color:#16a34a;">{{ $highest }}</div>
                            </div>
                        </div>
                        <div class="rekap-stat-card">
                            <div class="rekap-stat-icon" style="background:rgba(239,68,68,.1);color:#dc2626;">
                                <i class="bi bi-arrow-down-circle"></i>
                            </div>
                            <div>
                                <div class="rekap-stat-label">Nilai Terendah</div>
                                <div class="rekap-stat-value" style="color:#dc2626;">{{ $lowest }}</div>
                            </div>
                        </div>
                        <div class="rekap-stat-card">
                            <div class="rekap-stat-icon" style="background:rgba(59,130,246,.1);color:#2563eb;">
                                <i class="bi bi-patch-check"></i>
                            </div>
                            <div>
                                <div class="rekap-stat-label">Tingkat Lulus (≥75)</div>
                                <div class="rekap-stat-value" style="color:#2563eb;">{{ $passRate }}%
                                    <small style="font-size:.7rem;font-weight:500;">{{ $passCount }}/{{ $scores->count() }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Progress bar rata-rata --}}
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="fw-semibold" style="color:#334155;">Rata-rata Kelas</small>
                            <small class="fw-bold" style="color:#1F4D3B;">{{ $avg }}/100</small>
                        </div>
                        <div class="rekap-progress-track">
                            <div class="rekap-progress-bar"
                                 style="width:{{ $avg }}%;
                                        background: {{ $avg >= 80 ? 'linear-gradient(90deg,#22c55e,#16a34a)' : ($avg >= 70 ? 'linear-gradient(90deg,#f59e0b,#d97706)' : 'linear-gradient(90deg,#ef4444,#dc2626)') }}">
                            </div>
                        </div>
                    </div>

                    {{-- Rekap table --}}
                    <div class="table-responsive table-wrap">
                        <table class="table table-modern align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width:60px;">No</th>
                                    <th>Nama Siswa</th>
                                    <th style="width:130px;">NISN</th>
                                    <th style="width:100px;">Nilai</th>
                                    <th style="width:120px;">Predikat</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $index => $row)
                                    @php
                                        $s = $row['grade'] ? (float) $row['grade']->grade : null;
                                        if ($s === null) {
                                            $predikat = '-'; $predClass = 'rekap-pred-none';
                                        } elseif ($s >= 90) {
                                            $predikat = 'A — Sangat Baik'; $predClass = 'rekap-pred-a';
                                        } elseif ($s >= 80) {
                                            $predikat = 'B — Baik'; $predClass = 'rekap-pred-b';
                                        } elseif ($s >= 70) {
                                            $predikat = 'C — Cukup'; $predClass = 'rekap-pred-c';
                                        } elseif ($s >= 60) {
                                            $predikat = 'D — Kurang'; $predClass = 'rekap-pred-d';
                                        } else {
                                            $predikat = 'E — Sangat Kurang'; $predClass = 'rekap-pred-e';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><div class="student-name">{{ $row['student']->user->name ?? '-' }}</div></td>
                                        <td class="font-monospace" style="font-size:.88rem;">{{ $row['student']->nisn ?? '-' }}</td>
                                        <td>
                                            @if ($row['score'] !== '-')
                                                <span class="score-pill">{{ $row['score'] }}</span>
                                            @else
                                                <span class="text-muted small">Belum dinilai</span>
                                            @endif
                                        </td>
                                        <td><span class="rekap-pred {{ $predClass }}">{{ $predikat }}</span></td>
                                        <td><span class="text-muted small">{{ $row['notes'] === '-' ? '' : $row['notes'] }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @else
                    <div class="empty-state">
                        <i class="bi bi-clipboard-x fs-2 d-block mb-2 opacity-50"></i>
                        Belum ada nilai yang diinput. Rekap akan tampil setelah nilai siswa ditambahkan.
                    </div>
                    @endif

                    {{-- Download hint --}}
                    <div class="mt-4 p-3 rounded-3 d-flex align-items-center gap-3"
                         style="background:linear-gradient(135deg,rgba(31,77,59,.05),rgba(46,125,99,.03));border:1px solid rgba(31,77,59,.1);">
                        <div style="width:40px;height:40px;border-radius:12px;background:rgba(31,77,59,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="bi bi-file-earmark-spreadsheet" style="color:#1F4D3B;font-size:1.2rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold" style="color:#163827;font-size:.93rem;">Unduh Rekap sebagai File CSV</div>
                            <div class="text-muted" style="font-size:.82rem;">File dapat dibuka langsung di Microsoft Excel, Google Sheets, atau LibreOffice Calc.</div>
                        </div>
                        <a href="{{ $rekapUrl }}" class="btn btn-success btn-sm rounded-pill px-3 fw-semibold"
                           style="background:#1F4D3B;border-color:#1F4D3B;white-space:nowrap;">
                            <i class="bi bi-download me-1"></i> Unduh Sekarang
                        </a>
                    </div>
                </div>
            </section>

            <div class="modal fade" id="gradeModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 rounded-4 shadow">
                        <form method="POST" action="{{ route('teacher.grades.store') }}" id="gradeForm">
                            @csrf
                            <input type="hidden" name="return_to" value="{{ $returnTo }}">
                            <input type="hidden" name="_method" value="">
                            <div class="modal-header border-0 pb-0">
                                <div>
                                    <h5 class="modal-title fw-bold text-success mb-1">Tambah Nilai Baru</h5>
                                    <div class="text-muted small">Gunakan form ini untuk menambah atau mengubah nilai siswa.</div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pt-3">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Siswa</label>
                                        <select name="student_id" class="form-select" id="gradeStudentSelect" required>
                                            @foreach ($rows as $row)
                                                <option value="{{ $row['student']->id }}">
                                                    {{ $row['student']->user->name ?? 'Nama siswa' }} @if($row['student']->nisn) - {{ $row['student']->nisn }} @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Mata Pelajaran</label>
                                        @if($level === 'sd')
                                            <input type="text" class="form-control" value="{{ $activeSubject }}" readonly>
                                            <input type="hidden" name="subject" value="{{ $activeSubject }}" id="gradeSubjectInput">
                                        @else
                                            <input type="text" class="form-control" value="{{ $activeSubject }}" readonly>
                                            <input type="hidden" name="subject" value="{{ $activeSubject }}" id="gradeSubjectInput">
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Nilai</label>
                                        <input type="number" name="grade" class="form-control" id="gradeValueInput" min="0" max="100" step="0.01" placeholder="Contoh: 88">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Catatan</label>
                                        <textarea name="notes" class="form-control" id="gradeNotesInput" rows="3" placeholder="Opsional"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success rounded-pill px-4 fw-semibold">Simpan Nilai</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const storeUrl = '{{ $storeGradeUrl }}';
        const modalElement = document.getElementById('gradeModal');
        const form = document.getElementById('gradeForm');
        const methodField = form ? form.querySelector('input[name="_method"]') : null;
        const titleElement = modalElement ? modalElement.querySelector('.modal-title') : null;
        const studentSelect = document.getElementById('gradeStudentSelect');
        const valueInput = document.getElementById('gradeValueInput');
        const notesInput = document.getElementById('gradeNotesInput');

        document.querySelectorAll('.js-delete-grade').forEach(function (formElement) {
            formElement.addEventListener('submit', function (event) {
                const message = this.dataset.confirm || 'Hapus nilai ini?';

                if (!window.confirm(message)) {
                    event.preventDefault();
                }
            });
        });

        if (!modalElement || !form || !methodField || !titleElement || !studentSelect || !valueInput || !notesInput || typeof bootstrap === 'undefined') {
            return;
        }

        const modal = new bootstrap.Modal(modalElement);

        const resetForm = function () {
            form.action = storeUrl;
            methodField.value = '';
            titleElement.textContent = 'Tambah Nilai Baru';
            valueInput.value = '';
            notesInput.value = '';
        };

        document.querySelectorAll('.js-open-grade-modal').forEach(function (button) {
            button.addEventListener('click', function () {
                form.action = this.dataset.action || storeUrl;
                methodField.value = this.dataset.method || '';
                titleElement.textContent = this.dataset.title || 'Tambah Nilai Baru';
                studentSelect.value = this.dataset.studentId || '';
                valueInput.value = this.dataset.grade || '';
                notesInput.value = this.dataset.notes || '';
                modal.show();
            });
        });

        modalElement.addEventListener('hidden.bs.modal', resetForm);
        resetForm();
    });
</script>
@endsection
