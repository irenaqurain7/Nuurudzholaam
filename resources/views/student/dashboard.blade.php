@extends('student.layout')

@section('student-content')
<style>
    :root {
        --primary: #2d5016;
        --text-primary: #1a1a1a;
        --text-secondary: #666;
        --border: #e5e5e5;
        --bg-light: #f9f9f9;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .hero-section {
        background: linear-gradient(135deg, var(--primary) 0%, #3d6b1f 100%);
        color: white;
        padding: 2rem;
        border-radius: 14px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
    }

    .hero-section h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.4rem;
        letter-spacing: -0.5px;
    }

    .hero-section p {
        font-size: 0.95rem;
        opacity: 0.95;
        margin: 0;
        line-height: 1.6;
    }

    .summary-section {
        width: 100%;
        margin: 0 0 2rem 0;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        align-items: stretch;
    }

    .summary-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 14px;
        display: flex;
        flex-direction: column;
        min-height: 100%;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04);
    }

    .summary-card-header {
        background: linear-gradient(135deg, rgba(45, 80, 22, 0.08), rgba(61, 107, 31, 0.16));
        padding: 1.15rem 1.25rem;
        border-bottom: 1px solid rgba(45, 80, 22, 0.08);
    }

    .summary-card-header h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .summary-card-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .summary-body-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        align-items: start;
    }

    .summary-panel {
        min-width: 0;
    }

    .chart-section {
        margin-bottom: 0;
    }

    .chart-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 0.85rem;
    }

    .chart-title strong {
        font-size: 0.88rem;
        color: var(--text-primary);
    }

    .chart-title span {
        font-size: 0.82rem;
        color: var(--text-secondary);
    }

    .chart-list {
        display: grid;
        gap: 0.8rem;
    }

    .chart-item {
        display: grid;
        grid-template-columns: 110px minmax(0, 1fr) 80px;
        gap: 0.75rem;
        align-items: center;
    }

    .chart-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .chart-track {
        width: 100%;
        height: 14px;
        border-radius: 999px;
        background: #eef2ea;
        overflow: hidden;
        position: relative;
    }

    .chart-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #8bb06d, var(--primary));
    }

    .chart-value {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--primary);
        text-align: right;
    }

    .summary-label {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 0.9rem;
    }

    .summary-label i {
        color: var(--primary);
    }

    .summary-subtle {
        font-size: 0.95rem;
        color: var(--text-secondary);
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .summary-table {
        width: 100%;
        border-collapse: collapse;
    }

    .summary-table th,
    .summary-table td {
        padding: 0.95rem 0;
        text-align: left;
        border-bottom: 1px solid var(--border);
        font-size: 0.95rem;
        vertical-align: top;
    }

    .summary-table th {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.35px;
        color: var(--text-secondary);
        font-weight: 700;
    }

    .summary-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .summary-empty {
        padding: 1.25rem;
        text-align: center;
        color: var(--text-secondary);
        font-size: 0.95rem;
        background: #fafbfa;
        border: 1px dashed var(--border);
        border-radius: 10px;
    }

    .summary-value {
        font-weight: 700;
        color: var(--primary);
    }

    .summary-meta {
        margin-top: 0.15rem;
        font-size: 0.82rem;
        color: var(--text-secondary);
    }

    .summary-note {
        font-size: 0.92rem;
        color: var(--text-secondary);
        line-height: 1.5;
        margin-bottom: 0.85rem;
    }

    .schedule-index {
        white-space: nowrap;
        font-weight: 600;
        color: var(--primary);
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 1.5rem;
        }

        .hero-section h1 {
            font-size: 1.45rem;
        }

        .summary-card-body {
            padding: 1rem;
        }

        .summary-section {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .summary-card {
            width: 100%;
        }

        .summary-body-grid {
            grid-template-columns: 1fr;
            gap: 0.85rem;
        }

        .chart-item {
            grid-template-columns: 1fr;
            gap: 0.35rem;
        }

        .chart-value {
            text-align: left;
        }

        .summary-table th,
        .summary-table td {
            padding: 0.8rem 0;
            font-size: 0.9rem;
        }
    }
</style>

<div class="hero-section">
    <h1>Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
    <p>Ringkasan nilai semester Anda ditampilkan di bawah ini.</p>
</div>

<div class="summary-section">
    <div class="summary-card">
        <div class="summary-card-header">
            <h5>Jadwal Sekolah Hari Ini</h5>
        </div>
        <div class="summary-card-body">
            <div class="summary-body-grid">
                <div class="summary-panel">
                    <div class="summary-label">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $todayLabel ?? 'Hari ini' }}
                    </div>
                    <div class="summary-note">
                        Jadwal yang tampil hanya untuk hari ini, sesuai hari saat Anda login.
                    </div>
                    @if(($todayScheduleItems ?? collect())->isNotEmpty())
                        <table class="summary-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pelajaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayScheduleItems as $index => $scheduleItem)
                                    <tr>
                                        <td class="schedule-index">{{ $index + 1 }}</td>
                                        <td>{{ $scheduleItem }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="summary-empty" style="text-align: left;">Tidak ada jadwal pelajaran hari ini.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="summary-card">
        <div class="summary-card-header">
            <h5>Akumulasi Nilai per Semester</h5>
        </div>
        <div class="summary-card-body">
            <div class="summary-note">Ringkasan nilai berdasarkan semester yang telah ditempuh.</div>

            @if(($semesterSummaries ?? collect())->isNotEmpty())
                <div class="chart-section">
                    <div class="chart-title">
                        <strong>Grafik Ringkas</strong>
                        <span>Skala 0 - 100</span>
                    </div>
                    <div class="chart-list">
                        @foreach($semesterSummaries as $summary)
                            @php
                                $barWidth = max(0, min(100, (float) $summary['average']));
                            @endphp
                            <div class="chart-item">
                                <div class="chart-label">{{ $summary['label'] }}</div>
                                <div class="chart-track" aria-hidden="true">
                                    <div class="chart-fill" style="width: {{ $barWidth }}%;"></div>
                                </div>
                                <div class="chart-value">{{ number_format($summary['average'], 2) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <table class="summary-table">
                    <thead>
                        <tr>
                            <th>Semester</th>
                            <th>Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($semesterSummaries as $summary)
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color: var(--text-primary);">{{ $summary['label'] }}</div>
                                    <div class="summary-meta">{{ $summary['total_subjects'] }} mata pelajaran</div>
                                </td>
                                <td>
                                    <span class="summary-value">Rata-rata {{ number_format($summary['average'], 2) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="summary-empty" style="text-align: left;">Belum ada ringkasan nilai semester.</div>
            @endif
        </div>
    </div>
</div>
@endsection
