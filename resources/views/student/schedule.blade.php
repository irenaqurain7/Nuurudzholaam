@extends('student.layout')

@section('student-content')
<style>
    :root {
        --primary: #2d5016;
        --primary-soft: rgba(45, 80, 22, 0.12);
        --text-primary: #1a1a1a;
        --text-secondary: #666;
        --text-muted: #999;
        --border: #e5e5e5;
        --bg-light: #f7f8f4;
        --card-bg: rgba(255, 255, 255, 0.92);
        --accent: #7aa66b;
        --shadow: 0 16px 40px rgba(24, 42, 14, 0.08);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .page-header {
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(45, 80, 22, 0.08), rgba(122, 166, 107, 0.14));
        border: 1px solid rgba(45, 80, 22, 0.08);
    }

    .page-header h1 {
        font-size: 1.9rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .page-header p {
        color: var(--text-secondary);
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }

    .schedule-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1rem;
    }

    .day-card {
        background: var(--card-bg);
        border: 1px solid rgba(45, 80, 22, 0.08);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: var(--shadow);
        backdrop-filter: blur(8px);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .day-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 48px rgba(24, 42, 14, 0.12);
    }

    .day-card-header {
        padding: 1rem 1rem 0.85rem;
        background: linear-gradient(135deg, rgba(45, 80, 22, 0.12), rgba(122, 166, 107, 0.08));
        border-bottom: 1px solid rgba(45, 80, 22, 0.08);
    }

    .day-card-header .meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .day-label {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .day-label .dot {
        width: 10px;
        height: 10px;
        border-radius: 999px;
        background: var(--primary);
        box-shadow: 0 0 0 6px var(--primary-soft);
        flex: 0 0 auto;
    }

    .day-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.35rem 0.65rem;
        border-radius: 999px;
        background: white;
        color: var(--primary);
        font-size: 0.78rem;
        font-weight: 700;
        border: 1px solid rgba(45, 80, 22, 0.12);
    }

    .day-subtitle {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    .day-card-body {
        padding: 1rem;
    }

    .activity-list {
        list-style: none;
        display: grid;
        gap: 0.65rem;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.85rem 0.9rem;
        border: 1px solid var(--border);
        border-radius: 14px;
        background: linear-gradient(180deg, #fff, #fbfcf8);
    }

    .activity-index {
        width: 30px;
        height: 30px;
        border-radius: 10px;
        background: var(--primary-soft);
        color: var(--primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.82rem;
        font-weight: 700;
        flex: 0 0 auto;
    }

    .activity-content {
        min-width: 0;
        flex: 1;
    }

    .activity-name {
        display: block;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.35;
    }

    .activity-note {
        margin-top: 0.2rem;
        font-size: 0.84rem;
        color: var(--text-secondary);
    }

    .empty-day {
        padding: 1rem;
        border-radius: 14px;
        border: 1px dashed rgba(45, 80, 22, 0.18);
        background: rgba(247, 248, 244, 0.8);
        color: var(--text-secondary);
        font-size: 0.9rem;
        text-align: center;
    }

    .schedule-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .legend-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.55rem 0.8rem;
        border-radius: 999px;
        background: white;
        border: 1px solid rgba(45, 80, 22, 0.1);
        color: var(--text-secondary);
        font-size: 0.85rem;
    }

    .legend-pill strong {
        color: var(--text-primary);
    }

    .empty-state {
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.92), rgba(247, 248, 244, 0.92));
        border: 1px dashed rgba(45, 80, 22, 0.18);
        border-radius: 18px;
        padding: 3rem 2rem;
        text-align: center;
        box-shadow: var(--shadow);
    }

    .empty-state i {
        width: 68px;
        height: 68px;
        border-radius: 20px;
        background: var(--primary-soft);
        color: var(--primary);
        margin: 0 auto 1rem;
        display: grid;
        place-items: center;
        font-size: 1.8rem;
    }

    .empty-state h3 {
        font-size: 1.1rem;
        color: var(--text-primary);
        margin: 0 0 0.4rem 0;
    }

    .empty-state p {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin: 0;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.55rem;
        }

        .page-header {
            padding: 1rem;
        }

        .schedule-grid {
            grid-template-columns: 1fr;
        }

        .day-card-body {
            padding: 0.85rem;
        }

        .activity-item {
            padding: 0.8rem;
        }

        .empty-state {
            padding: 2rem 1rem;
        }
    }
</style>

<div class="page-header">
    <h1>Jadwal Sekolah Saya</h1>
    <p>Lihat jadwal pelajaran Anda untuk minggu ini</p>
</div>

@php
    $daysIndonesia = [
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
    ];
    $allDays = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    $scheduleCount = collect($schedules ?? [])->flatten(1)->count();
@endphp

@if($scheduleCount > 0)
    <div class="schedule-legend">
        <div class="legend-pill"><strong>{{ $student->class ?? '-' }}</strong> Kelas aktif</div>
        <div class="legend-pill"><strong>{{ $scheduleCount }}</strong> aktivitas tersedia</div>
        <div class="legend-pill"><strong>6</strong> hari tampilan</div>
    </div>

    <div class="schedule-grid">
        @foreach($allDays as $day)
            @php
                $daySchedules = $schedules[$day] ?? collect();
                $activityItems = $daySchedules->flatMap(function ($entry) {
                    return collect($entry->activities ?? []);
                })->values();
            @endphp

            <section class="day-card">
                <div class="day-card-header">
                    <div class="meta">
                        <div class="day-label">
                            <span class="dot"></span>
                            <span>{{ $daysIndonesia[$day] ?? $day }}</span>
                        </div>
                        <span class="day-count">{{ $activityItems->count() }} item</span>
                    </div>
                    <div class="day-subtitle">Aktivitas belajar dan pembiasaan hari ini</div>
                </div>

                <div class="day-card-body">
                    @if($activityItems->count() > 0)
                        <ul class="activity-list">
                            @foreach($activityItems as $index => $activity)
                                <li class="activity-item">
                                    <span class="activity-index">{{ $index + 1 }}</span>
                                    <div class="activity-content">
                                        <span class="activity-name">{{ $activity }}</span>
                                        <div class="activity-note">Jadwal kelas {{ $student->class ?? '-' }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="empty-day">Tidak ada jadwal untuk hari ini.</div>
                    @endif
                </div>
            </section>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-calendar-times"></i>
        <h3>Belum ada jadwal tersedia</h3>
        <p>Belum ada jadwal yang tersedia untuk kelas {{ $student->class ?? '' }}</p>
    </div>
@endif
@endsection
