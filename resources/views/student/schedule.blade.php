@extends('student.layout')

@section('student-content')
<style>
    :root {
        --primary: #2d5016;
        --text-primary: #1a1a1a;
        --text-secondary: #666;
        --text-muted: #999;
        --border: #e5e5e5;
        --bg-light: #f9f9f9;
        --success: #2ecc71;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
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

    .table-container {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    table thead {
        background-color: var(--bg-light);
        border-bottom: 2px solid var(--border);
    }

    table thead th {
        padding: 1rem;
        text-align: left;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background-color 0.2s;
    }

    table tbody tr:hover {
        background-color: var(--bg-light);
    }

    table tbody tr:last-child {
        border-bottom: none;
    }

    table tbody td {
        padding: 1rem;
        font-size: 0.95rem;
        color: var(--text-primary);
    }

    .badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        background-color: var(--primary);
        color: white;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .empty-state {
        background-color: var(--bg-light);
        border: 1px dashed var(--border);
        border-radius: 8px;
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 2.5rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
        display: block;
    }

    .empty-state p {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin: 0;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.5rem;
        }

        table thead th,
        table tbody td {
            padding: 0.75rem;
            font-size: 0.85rem;
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
@endphp

@if(count($schedules) > 0)
    <div class="table-container">
        <div class="table-wrapper">
            @foreach($allDays as $day)
                @if(isset($schedules[$day]))
                    <div style="padding:1rem;border-bottom:1px solid #eee;">
                        <h3>{{ $daysIndonesia[$day] ?? $day }}</h3>
                        <ul>
                            @foreach($schedules[$day] as $entry)
                                @foreach($entry->activities as $activity)
                                    <li>{{ $activity }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-calendar-times"></i>
        <p>Belum ada jadwal yang tersedia untuk kelas {{ $student->class ?? '' }}</p>
    </div>
@endif
@endsection
