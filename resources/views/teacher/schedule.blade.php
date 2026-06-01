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
</style>

<div class="page-header">
    <h1>Jadwal Mengajar</h1>
    <p>Daftar agenda dan waktu mengajar Anda di sekolah</p>
</div>

<div class="section" style="padding: 0; overflow: hidden;">
    @if($schedules->count() > 0)
        <div class="custom-table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Mata Pelajaran</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Ruangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                        <tr>
                            <td>
                                <span class="day-badge">{{ $schedule->day }}</span>
                            </td>
                            <td style="font-weight: 600;">{{ $schedule->subject }}</td>
                            <td>
                                <span class="time-text">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('H:i') }}
                                </span>
                            </td>
                            <td>
                                <span class="time-text">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('H:i') }}
                                </span>
                            </td>
                            <td>
                                <span class="room-text">
                                    <i class="fas fa-door-open" style="color: var(--text-muted); margin-right: 4px; font-size: 0.85rem;"></i>
                                    {{ $schedule->room ?? '-' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h3>Belum Ada Jadwal</h3>
            <p>Data jadwal mengajar Anda belum tersedia atau belum diatur oleh admin.</p>
        </div>
    @endif
</div>
@endsection
