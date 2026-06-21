@extends('teacher.layout')

@section('teacher-content')
<style>
    :root {
        --primary: #2d5016;
        --text-primary: #1a1a1a;
        --text-secondary: #666;
        --text-muted: #999;
        --border: #e5e5e5;
        --bg-light: #f9f9f9;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .page-header p {
        color: var(--text-secondary);
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }

    .section {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    /* Custom Clean Table */
    .custom-table-container {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-table th {
        background-color: var(--bg-light);
        color: var(--text-secondary);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.25rem;
        border-bottom: 2px solid var(--border);
    }

    .custom-table td {
        padding: 1.25rem;
        border-bottom: 1px solid var(--border);
        color: var(--text-primary);
        font-size: 0.95rem;
        vertical-align: middle;
    }

    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    .custom-table tbody tr:hover {
        background-color: rgba(45, 80, 22, 0.01);
    }

    /* Clean Day Badge */
    .day-badge {
        background-color: rgba(45, 80, 22, 0.08);
        color: var(--primary);
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-senin { background: #e6f4ea; color: #2d7a3f; }
    .badge-selasa { background: #e8f0ff; color: #2b63d6; }
    .badge-rabu { background: #fff9e6; color: #c68f00; }
    .badge-kamis { background: #f3e9ff; color: #7b4db3; }
    .badge-jumat { background: #ffecec; color: #c0392b; }

    /* Elegant Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-icon {
        background-color: var(--bg-light);
        color: var(--text-muted);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        border: 1px solid var(--border);
    }

    .empty-state h3 {
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 0.5rem 0;
    }

    .empty-state p {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin: 0;
    }

    .time-text {
        font-weight: 500;
        color: var(--text-primary);
    }

    .room-text {
        color: var(--text-secondary);
    }

    /* Planner Cards */
    .planner-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .planner-grid { grid-template-columns: 1fr; }
    }

    .planner-card {
        background: linear-gradient(180deg, rgba(255,255,255,0.9), rgba(250,250,250,0.95));
        border-radius: 16px;
        padding: 0.8rem;
        box-shadow: 0 6px 18px rgba(45,80,22,0.06);
        border: 1px solid rgba(45,80,22,0.06);
        transition: transform 150ms ease, box-shadow 150ms ease;
        min-height: 120px;
        display: flex;
        flex-direction: column;
    }

    .planner-card:hover { transform: translateY(-4px); box-shadow: 0 12px 26px rgba(45,80,22,0.08); }

    .planner-card-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem; }
    .planner-day { font-weight:700; color:var(--primary); font-size:1.05rem; }
    .planner-count { background: rgba(45,80,22,0.08); color:var(--primary); padding:4px 8px; border-radius:12px; font-size:0.9rem; font-weight:600; }

    .planner-card-body { flex:1; overflow:auto; }
    .no-lessons { color:var(--text-secondary); padding:0.8rem; text-align:center; }

    .lesson-list { list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.5rem; }
    .lesson-item { display:flex; gap:0.75rem; align-items:center; padding:0.45rem; border-radius:10px; transition:background 120ms ease; }
    .lesson-item:hover { background: rgba(45,80,22,0.03); }
    .lesson-icon { width:36px; height:36px; display:flex; align-items:center; justify-content:center; background:rgba(45,80,22,0.06); color:var(--primary); padding:8px; border-radius:8px; font-size:14px; }
    .lesson-meta { display:flex; flex-direction:column; }
    .lesson-title { font-weight:700; color:var(--text-primary); font-size:0.95rem; }
    .lesson-time { font-size:0.82rem; color:var(--text-secondary); }

    /* Quick-select buttons */
    .qs-btn {
        display:inline-block;
        padding:6px 10px;
        font-size:0.85rem;
        background: #eef6ee;
        color: var(--primary);
        border-radius: 10px;
        border: 1px solid rgba(45,80,22,0.06);
        text-decoration: none;
        font-weight:600;
    }
    .qs-btn:hover { background:#e2efe2; }
</style>

<div class="page-header">
    <h1>Jadwal Mengajar</h1>
    <p>Daftar agenda dan waktu mengajar Anda di sekolah</p>
</div>
<div class="section" style="padding: 1.25rem;">
    {{-- Toolbar removed as per request: simplified view without tingkat/kelas filters and import controls --}}

    {{-- Weekly schedule table grouped by day --}}
    @php
        $allSchedules = collect($schedules ?? []);
        $daysOrderFull = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        $grouped = $allSchedules->groupBy(function($s){ return trim((string)($s->day ?? '')); });
    @endphp
    <div class="section" style="margin-top:1rem;">
        <div style="font-weight:700; margin-bottom:0.75rem;">Tabel Jadwal Mengajar (Kelompok per Hari)</div>
        @if($allSchedules->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-calendar-alt"></i></div>
                <h3>Tidak ada jadwal</h3>
                <p>Belum ada data jadwal yang tersedia.</p>
            </div>
        @else
            <div class="custom-table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width:120px">Hari</th>
                            <th style="width:160px">Waktu</th>
                            <th style="width:220px">Mata Pelajaran</th>
                            <th style="width:120px">Tingkat</th>
                            <th style="width:120px">Kelas</th>
                            <th>Ruangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daysOrderFull as $day)
                            @if(isset($grouped[$day]) && $grouped[$day]->isNotEmpty())
                                @foreach($grouped[$day] as $item)
                                    @php
                                        $start = trim((string)($item->start_time ?? ''));
                                        $end = trim((string)($item->end_time ?? ''));
                                        $timeText = '-';
                                        try { if ($start) $timeText = \Carbon\Carbon::createFromFormat('H:i:s', $start)->format('H:i'); } catch(\Exception $e) { $timeText = $start ?: '-'; }
                                        try { if ($end) $timeText .= $timeText && $end ? ' - '.\Carbon\Carbon::createFromFormat('H:i:s', $end)->format('H:i') : $end; } catch(\Exception $e) { $timeText .= $end ? ' - '.$end : ''; }
                                        $student = $item->student ?? null;
                                        $kelas = $student->class ?? ($item->class ?? '-');
                                        $tingkat = $item->tingkat ?? ($student->tingkat ?? '-');
                                        $subject = trim((string)($item->subject ?? '-')) ?: '-';
                                    @endphp
                                    <tr>
                                        <td><span class="day-badge">{{ $day }}</span></td>
                                        <td class="time-text">{{ $timeText }}</td>
                                        <td>{{ $subject }}</td>
                                        <td>{{ $tingkat }}</td>
                                        <td>{{ $kelas }}</td>
                                        <td class="room-text">{{ $item->room ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @if(empty($selectedClass))
        @php
            // Unified timeline view for today
            $todayEnglish = \Carbon\Carbon::now()->format('l');
            $todayName = getDayNameIndonesia($todayEnglish);
            // ensure $schedules is a collection
            $timeline = collect($schedules ?? []);
        @endphp

        <div class="section">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem;">
                <div style="font-weight:700;">Timeline Hari Ini — {{ $todayName }}</div>
                <div style="color:var(--text-secondary); font-weight:600;">{{ $timeline->count() }} sesi</div>
            </div>

            @if($timeline->isEmpty())
                <div class="empty-state" style="padding:2rem;">
                    <div class="empty-state-icon"><i class="fas fa-calendar-times"></i></div>
                    <h3>Tidak ada jadwal untuk hari ini</h3>
                    <p>Anda tidak memiliki sesi mengajar untuk hari {{ $todayName }}.</p>
                </div>
            @else
                <div class="custom-table-container">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th style="width:140px">Jam</th>
                                <th style="width:100px">Jenjang</th>
                                <th style="width:140px">Kelas</th>
                                <th>Mata Pelajaran / Agenda</th>
                                <th style="width:140px; text-align:right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($timeline as $item)
                                @php
                                    $start = trim((string)($item->start_time ?? ''));
                                    $end = trim((string)($item->end_time ?? ''));
                                    $timeText = '-';
                                    try { if ($start) $timeText = \Carbon\Carbon::createFromFormat('H:i:s', $start)->format('H:i'); } catch(\Exception $e) { $timeText = $start ?: '-'; }
                                    try { if ($end) $timeText .= $timeText && $end ? ' - '.\Carbon\Carbon::createFromFormat('H:i:s', $end)->format('H:i') : $end; } catch(\Exception $e) { $timeText .= $end ? ' - '.$end : ''; }
                                    $student = $item->student ?? null;
                                    $kelas = $student->class ?? ($item->class ?? '-');
                                    $jenjang = jenjangFromClass($kelas);
                                    $subject = trim((string)($item->subject ?? '-')) ?: '-';
                                @endphp
                                <tr>
                                    <td class="time-text">{{ $timeText }}</td>
                                    <td>{{ $jenjang }}</td>
                                    <td>{{ $kelas }}</td>
                                    <td>{{ $subject }} @if(!empty($item->room)) <span class="room-text">• {{ $item->room }}</span> @endif</td>
                                    <td style="text-align:right">
                                        <a href="#" class="btn-detail" style="margin-left:auto;">Jurnal</a>
                                        <a href="#" class="btn-detail" style="margin-left:0.6rem;">Absensi</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @else
        @php
            // Normalize schedules into a map by day (Senin..Jumat)
            $daysOrder = ['Senin','Selasa','Rabu','Kamis','Jumat'];
            $byDay = [];
            foreach ($daysOrder as $d) { $byDay[$d] = collect(); }
            foreach ($schedules as $s) {
                $day = trim((string) ($s->day ?? ''));
                if ($day === '') continue;
                // normalize common variants
                $dayNorm = ucfirst(strtolower(str_replace(["\r","\n"],'',$day)));
                if ($dayNorm === "Jum'at") $dayNorm = 'Jumat';
                if (!in_array($dayNorm, $daysOrder)) continue;
                $byDay[$dayNorm]->push($s);
            }

            // helper icon mapping
            $iconMap = [
                'matematika' => 'fas fa-calculator',
                'mat' => 'fas fa-calculator',
                'b. indonesia' => 'fas fa-book-open',
                'bahasa indonesia' => 'fas fa-book-open',
                'bahasa inggris' => 'fas fa-language',
                'pjok' => 'fas fa-running',
                'penjaskes' => 'fas fa-running',
                'pai' => 'fas fa-mosque',
                'pkn' => 'fas fa-balance-scale',
                'ips' => 'fas fa-globe',
                'ipa' => 'fas fa-flask',
                'seni' => 'fas fa-palette',
                'musik' => 'fas fa-music',
                'prakarya' => 'fas fa-wrench',
                'istirahat' => 'fas fa-coffee',
                'duha' => 'fas fa-mosque',
            ];

            function pickIcon($subject, $map, $default = 'fas fa-book') {
                $s = strtolower($subject);
                foreach ($map as $k => $v) {
                    if (strpos($s, $k) !== false) return $v;
                }
                return $default;
            }
        @endphp

        <div style="display:block;">
            <div style="margin-bottom:0.75rem; color:var(--text-secondary); font-weight:600;">Tampilan planner mingguan untuk Kelas {{ $selectedClass }}</div>

            <div class="planner-grid">
                @foreach($daysOrder as $day)
                    @php $list = $byDay[$day] ?? collect(); @endphp
                    <div class="planner-card">
                        <div class="planner-card-header">
                            <div class="planner-day">{{ $day }}</div>
                            <div class="planner-count">{{ $list->count() }} pelajaran</div>
                        </div>
                        <div class="planner-card-body">
                            @if($list->isEmpty())
                                <div class="no-lessons">Tidak ada jadwal</div>
                            @else
                                <ul class="lesson-list">
                                    @foreach($list as $lesson)
                                        @php
                                            $subject = trim((string)($lesson->subject ?? '-')) ?: '-';
                                            $icon = pickIcon($subject, $iconMap);
                                            $start = trim((string)($lesson->start_time ?? ''));
                                            $end = trim((string)($lesson->end_time ?? ''));
                                            $timeText = '';
                                            if ($start) {
                                                try { $timeText = \Carbon\Carbon::createFromFormat('H:i:s', $start)->format('H:i'); } catch (\Exception $e) { $timeText = $start; }
                                            }
                                            if ($end) {
                                                try { $timeText .= $timeText ? ' - '.\Carbon\Carbon::createFromFormat('H:i:s', $end)->format('H:i') : $end; } catch (\Exception $e) { $timeText .= $timeText ? ' - '.$end : $end; }
                                            }
                                        @endphp
                                        <li class="lesson-item">
                                            <i class="{{ $icon }} lesson-icon" aria-hidden="true"></i>
                                            <div class="lesson-meta">
                                                <div class="lesson-title">{{ $subject }}</div>
                                                <div class="lesson-time">{{ $timeText ?: '-' }}</div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@endsection
