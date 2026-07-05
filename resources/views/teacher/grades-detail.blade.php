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
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

    .empty-state {
        border: 1px dashed rgba(100, 116, 139, 0.26);
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.78);
        padding: 34px 20px;
        text-align: center;
        color: #64748B;
    }

    .subject-empty,
    .table-empty {
        border: 1px dashed rgba(100, 116, 139, 0.24);
        border-radius: 16px;
        background: rgba(248, 250, 249, 0.85);
        padding: 28px 18px;
        text-align: center;
        color: #64748B;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: #1F4D3B;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .back-link:hover {
        color: #163827;
    }

    @media (max-width: 991.98px) {
        .detail-shell {
            border-radius: 18px;
            padding-top: 20px;
        }

        .info-grid,
        .subject-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575.98px) {
        .info-grid,
        .subject-grid {
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
                <div class="card-header">
                    <h2 class="panel-title">Pilih Mata Pelajaran</h2>
                    <span class="badge text-bg-light border rounded-pill px-3 py-2">{{ $availableSubjects->count() }} mapel</span>
                </div>
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

                    <div class="subject-grid">
                        @forelse ($subjectCards as $subjectCard)
                            <a href="{{ $subjectCard['url'] }}" class="subject-card {{ $activeSubject === $subjectCard['name'] ? 'active' : '' }}">
                                <div>
                                    <p class="subject-name">{{ $subjectCard['name'] }}</p>
                                    <p class="subject-note">Klik untuk membuka tabel nilai</p>
                                </div>
                                <i class="bi bi-arrow-right-circle fs-4 text-success"></i>
                            </a>
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
                    <span class="badge text-bg-light border rounded-pill px-3 py-2">{{ $rows->count() }} siswa</span>
                </div>
                <div class="card-body p-0">
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
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
        @endif
    </div>
</div>
@endsection
