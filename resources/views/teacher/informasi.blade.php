@extends('teacher.layout')

@section('teacher-content')
<style>
    :root {
        --hijau-islam: #2D4438;
        --hijau-light: #486E5A;
        --emas-light: #E2ECE8;
        --text-dark: #1C2D25;
        --text-muted: #667A70;
        --border: #E2ECE8;
        --bg-light: #F4F7F5;
        --putih: #ffffff;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--hijau-islam);
        margin: 0;
    }

    .announcement-container {
        display: grid;
        gap: 1.5rem;
        max-width: 1000px;
    }

    .announcement-card {
        background: var(--putih);
        border: 1px solid var(--border);
        border-left: 4px solid var(--hijau-islam);
        padding: 1.75rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(45, 68, 56, 0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .announcement-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(45, 68, 56, 0.06);
    }

    .announcement-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .announcement-title {
        margin: 0;
        color: var(--text-dark);
        font-size: 1.15rem;
        font-weight: 600;
        line-height: 1.4;
    }

    .announcement-date {
        background: var(--emas-light);
        color: var(--hijau-islam);
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .announcement-body {
        color: #4A5568;
        line-height: 1.65;
        font-size: 0.95rem;
    }

    /* Elegant Empty State */
    .empty-state {
        background: var(--putih);
        border: 1px solid var(--border);
        border-radius: 8px;
        text-align: center;
        padding: 4rem 2rem;
        max-width: 1000px;
    }

    .empty-state-icon {
        background-color: var(--bg-light);
        color: var(--text-muted);
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        font-size: 1.6rem;
        border: 1px solid var(--border);
    }

    .empty-state h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0 0 0.35rem 0;
    }

    .empty-state p {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin: 0;
    }
</style>

<div class="page-header">
    <h1>Informasi Penting</h1>
</div>

@if($announcements->isEmpty())
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-bell-slash"></i>
        </div>
        <h3>Belum Ada Informasi</h3>
        <p>Tidak ada pengumuman atau informasi terbaru yang diterbitkan saat ini.</p>
    </div>
@else
    <div class="announcement-container">
        @foreach($announcements as $announcement)
            <div class="announcement-card">
                <div class="announcement-header">
                    <h2 class="announcement-title">{{ $announcement->judul }}</h2>
                    <span class="announcement-date">
                        <i class="far fa-calendar-alt"></i> {{ $announcement->created_at->format('d M Y') }}
                    </span>
                </div>
                <div class="announcement-body">
                    {!! nl2br(e($announcement->konten)) !!}
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
