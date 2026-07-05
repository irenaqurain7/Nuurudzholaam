@extends('teacher.layout')

@section('title', 'Kelola Nilai')

@section('teacher-content')
@php
    $sections = $sections ?? ['sd' => [], 'smp' => [], 'smk' => []];
    $pageMeta = $pageMeta ?? [];
    $pageTitle = $pageMeta['title'] ?? 'Kelola Nilai';
    $pageSubtitle = $pageMeta['subtitle'] ?? 'Pilih kelas yang ingin Anda kelola untuk menginput nilai siswa.';
    $sdCards = collect($sections['sd'] ?? [])->filter(function ($card) {
        return ($card['status'] ?? '') === 'Wali Kelas';
    })->values();

    if ($sdCards->isEmpty()) {
        $sdCards = collect($sections['sd'] ?? [])->take(1)->values();
    }
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
    .grades-shell {
        background: #F8FAF9;
        border-radius: 24px;
        min-height: calc(100vh - 80px);
        padding: 24px 0 40px;
        font-family: 'Poppins', sans-serif;
        color: #1F2937;
    }

    .grades-hero {
        background: linear-gradient(135deg, rgba(31, 77, 59, 0.06), rgba(46, 125, 99, 0.02));
        border: 1px solid rgba(31, 77, 59, 0.06);
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.03);
    }

    .grades-kicker {
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

    .grades-title {
        color: #1F4D3B;
        font-weight: 800;
        letter-spacing: -0.03em;
        margin: 12px 0 8px;
        font-size: clamp(1.8rem, 2.2vw, 2.5rem);
    }

    .grades-subtitle {
        color: #5F6F69;
        margin: 0;
        max-width: 720px;
        line-height: 1.7;
        font-size: 0.98rem;
    }

    .section-block {
        margin-top: 26px;
    }

    .section-head {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 12px;
        margin-bottom: 14px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        color: #1F2937;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .section-title .dot {
        width: 12px;
        height: 12px;
        border-radius: 999px;
        display: inline-block;
    }

    .dot-sd { background: #2BB673; }
    .dot-smp { background: #F59E0B; }
    .dot-smk { background: #3B82F6; }

    .grade-card {
        min-height: 182px;
        border: 1px solid rgba(31, 77, 59, 0.08);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        overflow: hidden;
    }

    .grade-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
        border-color: rgba(31, 77, 59, 0.16);
    }

    .grade-card .card-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .grade-topline {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 16px;
    }

    .grade-icon-badge {
        width: 44px;
        height: 44px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(31, 77, 59, 0.08);
        color: #1F4D3B;
        flex: 0 0 auto;
        box-shadow: inset 0 0 0 1px rgba(31, 77, 59, 0.05);
    }

    .grade-icon-badge.sd {
        background: rgba(46, 125, 99, 0.10);
    }

    .grade-icon-badge.mapel {
        background: rgba(46, 125, 99, 0.06);
    }

    .grade-meta {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 10px;
    }

    .grade-class {
        font-size: 1.05rem;
        font-weight: 800;
        color: #163827;
        line-height: 1.3;
        margin: 0;
    }

    .grade-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.35rem 0.65rem;
        border-radius: 999px;
        background: rgba(31, 77, 59, 0.08);
        color: #1F4D3B;
        font-size: 0.76rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .grade-chip.sd-badge {
        background: rgba(46, 125, 99, 0.12);
        color: #1F4D3B;
    }

    .grade-chip.mapel-badge {
        background: #EEF2F6;
        color: #516070;
    }

    .grade-info {
        display: grid;
        gap: 10px;
        margin-bottom: auto;
    }

    .grade-info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        color: #475569;
        font-size: 0.9rem;
    }

    .grade-info-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748B;
        font-weight: 500;
    }

    .grade-info-value {
        font-weight: 700;
        color: #1F2937;
        text-align: right;
    }

    .grade-action {
        margin-top: 14px;
    }

    .btn-grade {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 0.72rem 1rem;
        border-radius: 999px;
        background: linear-gradient(135deg, #2E7D63, #1F4D3B);
        color: #fff;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        border: none;
        box-shadow: 0 10px 18px rgba(31, 77, 59, 0.14);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-grade:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 12px 20px rgba(31, 77, 59, 0.18);
    }

    .empty-card {
        border: 1px dashed rgba(100, 116, 139, 0.24);
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.72);
        min-height: 170px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #64748B;
    }

    .info-card {
        border: 1px solid rgba(31, 77, 59, 0.08);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.05);
        padding: 22px 24px;
    }

    .info-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(31, 77, 59, 0.08);
        color: #1F4D3B;
        flex: 0 0 auto;
    }

    @media (max-width: 991.98px) {
        .grades-shell {
            border-radius: 18px;
            padding-top: 20px;
        }
    }
</style>

<div class="grades-shell">
    <div class="container">
        <section class="grades-hero mb-4">
            <h1 class="grades-title">{{ $pageTitle }}</h1>
            <p class="grades-subtitle">{{ $pageSubtitle }}</p>
        </section>

        @foreach (['sd' => ['label' => 'SD', 'dot' => 'dot-sd'], 'smp' => ['label' => 'SMP', 'dot' => 'dot-smp'], 'smk' => ['label' => 'SMK', 'dot' => 'dot-smk']] as $levelKey => $levelMeta)
            @php
                $cards = $levelKey === 'sd'
                    ? $sdCards
                    : collect($sections[$levelKey] ?? []);
            @endphp

            <section class="section-block">
                <div class="section-head">
                    <h2 class="section-title">
                        <span class="dot {{ $levelMeta['dot'] }}"></span>
                        {{ $levelMeta['label'] }}
                    </h2>
                </div>

                <div class="row g-4">
                    @forelse ($cards as $card)
                        <div class="col-12 col-md-6 col-xl-4">
                            <article class="card grade-card">
                                <div class="card-body">
                                    <div class="grade-topline">
                                        <div class="d-flex gap-3 align-items-start">
                                            <div class="grade-icon-badge {{ $levelKey === 'sd' ? 'sd' : 'mapel' }}">
                                                <i class="bi bi-book fs-4"></i>
                                            </div>
                                            <div>
                                                <p class="grade-class mb-2">Kelas {{ $card['class'] }}</p>
                                                <span class="grade-chip {{ $levelKey === 'sd' ? 'sd-badge' : 'mapel-badge' }}">
                                                    <i class="bi {{ $levelKey === 'sd' ? 'bi-star-fill' : 'bi-journal-text' }}"></i>
                                                    {{ $levelKey === 'sd' ? 'Wali Kelas' : 'Guru Mapel' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-end small text-muted fw-semibold pt-1">
                                            {{ $levelMeta['label'] }}
                                        </div>
                                    </div>

                                    <div class="grade-info">
                                        <div class="grade-info-row">
                                            <span class="grade-info-label"><i class="bi bi-book"></i> Kelas</span>
                                            <span class="grade-info-value">{{ $card['class'] }}</span>
                                        </div>
                                        <div class="grade-info-row">
                                            <span class="grade-info-label"><i class="bi bi-building"></i> Jenjang</span>
                                            <span class="grade-info-value">{{ $levelMeta['label'] }}</span>
                                        </div>
                                        <div class="grade-info-row">
                                            <span class="grade-info-label"><i class="bi bi-book"></i> Mapel</span>
                                            <span class="grade-info-value">{{ $card['subject_text'] }}</span>
                                        </div>
                                        <div class="grade-info-row">
                                            <span class="grade-info-label"><i class="bi bi-people"></i> Jumlah Siswa</span>
                                            <span class="grade-info-value">{{ $card['student_label'] }}</span>
                                        </div>
                                    </div>

                                    <div class="grade-action">
                                        <a href="{{ $card['url'] }}" class="btn-grade">
                                            Kelola Nilai <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-card">
                                <div>
                                    <div class="mb-2"><i class="bi bi-inbox fs-3"></i></div>
                                    <div class="fw-semibold">Belum ada kelas {{ strtolower($levelMeta['label']) }} yang ditugaskan.</div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </section>
        @endforeach

        <section class="mt-4">
            <div class="info-card d-flex gap-3 align-items-start">
                <div class="info-card-icon">
                    <i class="bi bi-info-circle-fill fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold mb-1" style="color: #1F4D3B;">Keterangan</div>
                    <div class="text-muted" style="line-height: 1.7;">
                        Hanya kelas yang menjadi tanggung jawab Anda yang ditampilkan pada halaman ini. Untuk mengelola nilai kelas lain, guru harus memiliki penugasan mengajar pada kelas tersebut.
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
