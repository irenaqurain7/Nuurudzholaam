@extends('teacher.layout')

@section('teacher-content')
<style>
    :root {
        --primary: #2F4F3E;
        --secondary: #456652;
        --bg: #F5F7F6;
        --card: #FFFFFF;
        --border: #E5ECE7;
        --text: #1C2D25;
        --muted: #667A70;
        --shadow: 0 12px 30px rgba(31,45,37,0.06);
    }

    .schedule-page {
        background: var(--bg);
        min-height: 100%;
        padding-bottom: 2rem;
    }

    .page-header {
        margin-bottom: 1.75rem;
    }

    .page-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .page-header p {
        color: var(--muted);
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
        max-width: 760px;
    }

    .filter-row .form-select,
    .filter-row .btn,
    .filter-row .form-control {
        min-height: 46px;
        border-radius: 12px;
        border: 1px solid var(--border);
        font-size: 0.95rem;
    }

    .filter-row .btn-primary {
        background: var(--primary);
        border-color: var(--primary);
    }

    .filter-row .btn-outline-secondary {
        border-color: var(--border);
        color: var(--text);
        background: #fff;
    }

    .schedule-panel,
    .right-panel-card,
    .summary-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 18px;
        box-shadow: var(--shadow);
    }

    .schedule-panel {
        padding: 1.5rem;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        color: var(--text);
    }

    .section-note {
        color: var(--muted);
        font-size: 0.95rem;
        margin-bottom: 1rem;
    }

    .badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text);
        background: rgba(47,79,62,0.08);
        border-radius: 999px;
        padding: 0.55rem 0.85rem;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .calendar-board {
        overflow-x: auto;
    }

    .calendar-grid {
        min-width: 1000px;
        display: grid;
        grid-template-columns: 90px repeat(5, minmax(180px, 1fr));
        gap: 1px;
        background: var(--border);
        border-radius: 18px;
        overflow: hidden;
    }

    .calendar-header,
    .calendar-cell,
    .time-label {
        background: var(--card);
        color: var(--text);
    }

    .calendar-header {
        padding: 1rem 0.75rem;
        font-weight: 700;
        text-align: center;
        color: var(--primary);
        background: #F2F7F1;
    }

    .time-label {
        padding: 1rem 0.75rem;
        font-size: 0.85rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 75px;
    }

    .calendar-cell {
        min-height: 75px;
        padding: 0.85rem;
        background: #fff;
    }

    .calendar-cell.empty {
        background: #F8FAF8;
    }

    .lesson-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-left-width: 4px;
        border-radius: 16px;
        padding: 1rem;
        box-shadow: 0 12px 24px rgba(31,45,37,0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
        margin-bottom: 0.75rem;
    }

    .lesson-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 32px rgba(31,45,37,0.1);
    }

    .lesson-card .lesson-subj {
        font-size: 0.98rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
    }

    .lesson-card .lesson-meta {
        font-size: 0.85rem;
        color: var(--muted);
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .lesson-card .lesson-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
        margin-bottom: 0.75rem;
    }

    .lesson-tag {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.35rem 0.75rem;
        background: rgba(47,79,62,0.08);
        color: var(--primary);
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .lesson-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .lesson-actions .btn {
        flex: 1 1 100px;
        min-width: 100px;
        font-size: 0.78rem;
        padding: 0.55rem 0.75rem;
        border-radius: 10px;
    }

    .lesson-actions .btn-outline-primary {
        background: #fff;
        color: var(--primary);
        border-color: rgba(47,79,62,0.16);
    }

    .lesson-actions .btn-primary {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .summary-card {
        padding: 1.3rem;
    }

    .summary-card .label {
        color: var(--muted);
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
        display: inline-block;
    }

    .summary-card .value {
        font-size: 1.9rem;
        font-weight: 700;
        color: var(--text);
        line-height: 1.1;
    }

    .right-panel-card {
        padding: 1.4rem;
    }

    .right-panel-card h5 {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0.85rem;
        color: var(--text);
    }

    .right-panel-card p,
    .right-panel-card li {
        color: var(--muted);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .right-panel-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        gap: 0.9rem;
    }

    .right-panel-list li {
        background: #F8FAF8;
        border: 1px solid #E5ECE7;
        border-radius: 14px;
        padding: 0.95rem 1rem;
    }

    .right-panel-item-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.55rem;
        font-weight: 700;
        color: var(--text);
    }

    .right-panel-item-sub {
        color: var(--muted);
        font-size: 0.9rem;
    }

    @media (max-width: 1199px) {
        .calendar-grid { min-width: 820px; }
    }

    @media (max-width: 991px) {
        .summary-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 767px) {
        .filter-row .col-12 { margin-bottom: 0.5rem; }
        .calendar-grid { min-width: 100%; grid-template-columns: 70px repeat(5, minmax(140px, 1fr)); }
        .calendar-header { font-size: 0.9rem; }
        .time-label { font-size: 0.8rem; min-height: 80px; }
        .lesson-card { margin-bottom: 0.65rem; }
        .right-panel-list li { padding: 0.85rem; }
    }
</style>

@php
    use Carbon\Carbon;

    $schedulesCollection = collect($schedules ?? []);
    $dayOrder = ['Senin','Selasa','Rabu','Kamis','Jumat'];
    $hours = [
        '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', 
        '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', 
        '13:30', '14:00'
    ];

    function normalizeDay($value) {
        $value = strtolower(trim((string)$value));
        if ($value === 'jumat' || strpos($value, "jum'at") !== false) return 'Jumat';
        if (strpos($value, 'senin') !== false) return 'Senin';
        if (strpos($value, 'selasa') !== false) return 'Selasa';
        if (strpos($value, 'rabu') !== false) return 'Rabu';
        if (strpos($value, 'kamis') !== false) return 'Kamis';
        if (strpos($value, 'sabtu') !== false) return 'Sabtu';
        return '';
    }

    function formatHour($time) {
        $time = trim((string)$time);
        if (!$time) return '';
        try {
            return Carbon::createFromFormat('H:i:s', $time)->format('H:i');
        } catch (Exception $e) {
            try { return Carbon::createFromFormat('H:i', $time)->format('H:i'); } catch (Exception $e) { return substr($time,0,5); }
        }
    }

    function subjectBorderColor($subject) {
        $subject = strtolower($subject);
        if (strpos($subject, 'matematika') !== false) return '#2F4F3E';
        if (strpos($subject, 'bahasa') !== false) return '#456652';
        if (strpos($subject, 'ipa') !== false) return '#3598b6';
        if (strpos($subject, 'ips') !== false) return '#d37c1f';
        if (strpos($subject, 'pjok') !== false || strpos($subject, 'penjaskes') !== false) return '#6b8d2d';
        return '#7d5aa3';
    }

    function subjectBackground($subject) {
        $subject = strtolower($subject);
        if (strpos($subject, 'matematika') !== false) return '#e9f4eb';
        if (strpos($subject, 'bahasa') !== false) return '#edf7f0';
        if (strpos($subject, 'ipa') !== false) return '#eaf4fb';
        if (strpos($subject, 'ips') !== false) return '#fff2e3';
        if (strpos($subject, 'pjok') !== false || strpos($subject, 'penjaskes') !== false) return '#eff4e3';
        return '#f1edfb';
    }

    function calculateDuration($start, $end) {
        $start = formatHour($start);
        $end = formatHour($end);
        if (!$start || !$end) return 0;
        try {
            $a = Carbon::createFromFormat('H:i', $start);
            $b = Carbon::createFromFormat('H:i', $end);
            return max(0, $b->floatDiffInHours($a));
        } catch (Exception $e) {
            return 0;
        }
    }

    $grid = [];
    foreach ($dayOrder as $day) {
        foreach ($hours as $hour) {
            $grid[$day][$hour] = collect();
        }
    }

    foreach ($schedulesCollection as $item) {
        $day = normalizeDay($item->day ?? '');
        if (!$day || !in_array($day, $dayOrder)) continue;
        $time = formatHour($item->start_time ?? $item->time ?? '');
        if (in_array($time, $hours)) {
            $grid[$day][$time]->push($item);
        }
    }

    $totalHoursWeek = $schedulesCollection->sum(function ($item) {
        return calculateDuration($item->start_time ?? '', $item->end_time ?? '');
    });

    $totalClasses = $schedulesCollection->pluck('class')->filter()->unique()->count();
    $totalStudents = $schedulesCollection->pluck('student.id')->filter()->unique()->count();
    $todayName = normalizeDay(Carbon::now()->translatedFormat('l')) ?: normalizeDay(Carbon::now()->format('l'));
    $todayItems = $schedulesCollection->filter(fn($item) => normalizeDay($item->day ?? '') === $todayName);
    $hoursToday = $todayItems->sum(fn($item) => calculateDuration($item->start_time ?? '', $item->end_time ?? ''));
    $agendaItems = $schedulesCollection->sortBy(function ($item) use ($dayOrder) {
        $day = normalizeDay($item->day ?? '');
        return array_search($day, $dayOrder) ?: 99;
    })->take(4);
@endphp

<div class="schedule-page">
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1>Jadwal Mengajar</h1>
            <p>Kelola agenda mengajar mingguan dengan kalender jadwal dan ringkasan statistik.</p>
        </div>
        <div>
            <button class="btn btn-primary" onclick="window.print()" style="min-height: 46px; border-radius: 12px; font-weight: 600; padding: 0 24px; background: var(--primary); border-color: var(--primary); display: inline-flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                <span>Cetak Jadwal</span>
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="schedule-panel">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-3">
                    <div>
                        <div class="section-title">Kalender Mingguan</div>
                        <div class="section-note">Tampilan jam 06.30–14.00 untuk Senin sampai Jumat.</div>
                    </div>
                    <div class="badge-pill">{{ $schedulesCollection->count() }} sesi minggu ini</div>
                </div>
                <div class="calendar-board">
                    <div class="calendar-grid">
                        <div class="calendar-header"></div>
                        @foreach($dayOrder as $day)
                            <div class="calendar-header">{{ $day }}</div>
                        @endforeach

                        @foreach($hours as $hour)
                            <div class="time-label">{{ $hour }}</div>
                            @foreach($dayOrder as $day)
                                @php $items = $grid[$day][$hour] ?? collect(); @endphp
                                <div class="calendar-cell {{ $items->isEmpty() ? 'empty' : '' }}">
                                    @foreach($items as $item)
                                        @php
                                            $subject = trim((string)($item->subject ?? '-')) ?: '-';
                                            $kelas = trim((string)($item->class ?? ($item->student->class ?? '-')));
                                            $room = trim((string)($item->room ?? '-'));
                                            $timeText = trim(formatHour($item->start_time ?? '') . ' - ' . formatHour($item->end_time ?? ''));
                                        @endphp
                                        <div class="lesson-card" style="border-color: {{ subjectBorderColor($subject) }}; background: {{ subjectBackground($subject) }};">
                                            <div class="lesson-subj">{{ $subject }}</div>
                                            <div class="lesson-meta">{{ $kelas }} • {{ $timeText }} • {{ $room }}</div>
                                            <div class="lesson-tags">
                                                <span class="lesson-tag">{{ $item->student_count ?? ($item->students_count ?? '---') }} siswa</span>
                                                <span class="lesson-tag">{{ $room ?: 'Ruang belum ditetapkan' }}</span>
                                            </div>
                                            <div class="lesson-actions">
                                                <a href="#" class="btn btn-outline-primary">Input Absensi</a>
                                                <a href="#" class="btn btn-outline-primary">Input Nilai</a>
                                                <a href="#" class="btn btn-primary">Lihat Detail</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="summary-grid">
                <div class="summary-card">
                    <div class="label">Total Jam Mengajar Minggu Ini</div>
                    <div class="value">{{ number_format($totalHoursWeek, 1, '.', ',') }} jam</div>
                </div>
                <div class="summary-card">
                    <div class="label">Total Kelas</div>
                    <div class="value">{{ $totalClasses }}</div>
                </div>
                <div class="summary-card">
                    <div class="label">Total Siswa</div>
                    <div class="value">{{ $totalStudents }}</div>
                </div>
                <div class="summary-card">
                    <div class="label">Jam Mengajar Hari Ini</div>
                    <div class="value">{{ number_format($hoursToday, 1, '.', ',') }} jam</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="right-panel-card">
                <h5>Pemberitahuan Perubahan Jadwal</h5>
                <p>Belum ada pembaruan jadwal terbaru. Pastikan selalu memeriksa notifikasi jika ada perubahan dari admin sekolah.</p>
            </div>
            <div class="right-panel-card">
                <h5>Kelas Hari Ini</h5>
                <ul class="right-panel-list">
                    @forelse($todayItems->take(4) as $item)
                        @php
                            $subject = trim((string)($item->subject ?? '-')) ?: '-';
                            $timeText = trim(formatHour($item->start_time ?? '') . ' - ' . formatHour($item->end_time ?? ''));
                            $kelas = trim((string)($item->class ?? ($item->student->class ?? '-')));
                        @endphp
                        <li>
                            <div class="right-panel-item-title">{{ $subject }} <span>{{ $timeText }}</span></div>
                            <div class="right-panel-item-sub">{{ $kelas }} • {{ $item->room ?? 'Ruang belum ditetapkan' }}</div>
                        </li>
                    @empty
                        <li class="right-panel-item-sub">Tidak ada kelas hari ini.</li>
                    @endforelse
                </ul>
            </div>
            <div class="right-panel-card">
                <h5>Agenda Guru</h5>
                <ul class="right-panel-list">
                    @forelse($agendaItems as $item)
                        @php
                            $day = normalizeDay($item->day ?? '-');
                            $subject = trim((string)($item->subject ?? '-')) ?: '-';
                            $timeText = trim(formatHour($item->start_time ?? '') . ' - ' . formatHour($item->end_time ?? ''));
                        @endphp
                        <li>
                            <div class="right-panel-item-title">{{ $day }} <span>{{ $timeText }}</span></div>
                            <div class="right-panel-item-sub">{{ $subject }}</div>
                        </li>
                    @empty
                        <li class="right-panel-item-sub">Agenda belum tersedia.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
