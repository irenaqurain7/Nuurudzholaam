<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Kelas {{ $selectedClass }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2d5016;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #2d5016;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
            font-size: 14px;
            margin: 3px 0;
        }

        .header .info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 15px;
            font-size: 13px;
            text-align: left;
        }

        .info-item {
            padding: 5px 0;
        }

        .info-label {
            font-weight: bold;
            color: #2d5016;
            width: 120px;
            display: inline-block;
        }

        .summary-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: #f8f9fa;
            border: 2px solid #2d5016;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .stat-box .label {
            font-size: 13px;
            color: #666;
            margin-bottom: 5px;
        }

        .stat-box .value {
            font-size: 28px;
            font-weight: bold;
            color: #2d5016;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table thead {
            background: #2d5016;
            color: white;
        }

        table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border: 1px solid #2d5016;
        }

        table td {
            padding: 10px 12px;
            border: 1px solid #ddd;
        }

        table tbody tr:nth-child(odd) {
            background: #f9f9f9;
        }

        table tbody tr:hover {
            background: #f0f0f0;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .footer {
            margin-top: 40px;
            border-top: 2px solid #2d5016;
            padding-top: 20px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            font-size: 12px;
        }

        .footer-item {
            text-align: center;
        }

        .footer-item .title {
            font-weight: bold;
            margin-bottom: 40px;
            color: #2d5016;
        }

        .footer-item .name {
            font-weight: 600;
            margin-top: 5px;
        }

        .page-break {
            page-break-after: always;
        }

        .highlight {
            background: #fffacd;
            padding: 2px 4px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📊 LAPORAN RINGKASAN NILAI SISWA</h1>
            <p>Kelas {{ $selectedClass }}</p>
            <p style="font-size: 12px; color: #999;">Semester: Tahun Ajaran 2024/2025</p>

            <div class="info">
                <div class="info-item">
                    <span class="info-label">Guru:</span> {{ $user->name }}
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal:</span> {{ now()->format('d-m-Y H:i:s') }}
                </div>
                <div class="info-item">
                    <span class="info-label">Total Siswa:</span> {{ count($studentSummary) }}
                </div>
                <div class="info-item">
                    <span class="info-label">Rata-rata Kelas:</span> <span class="highlight">{{ number_format($averageClass, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="summary-stats">
            <div class="stat-box">
                <div class="label">Total Siswa</div>
                <div class="value">{{ count($studentSummary) }}</div>
            </div>
            <div class="stat-box">
                <div class="label">Rata-rata Kelas</div>
                <div class="value">{{ number_format($averageClass, 2) }}</div>
            </div>
            <div class="stat-box">
                <div class="label">Siswa Lulus</div>
                <div class="value" style="color: #28a745;">
                    {{ collect($studentSummary)->where('average', '>=', 70)->count() }}
                </div>
            </div>
            <div class="stat-box">
                <div class="label">Butuh Remediasi</div>
                <div class="value" style="color: #dc3545;">
                    {{ collect($studentSummary)->where('average', '<', 70)->count() }}
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <table>
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th width="80">NISN</th>
                    <th width="200">Nama Siswa</th>
                    <th width="60">Mapel</th>
                    <th width="80">Avg. Nilai</th>
                    <th width="100">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($studentSummary as $index => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['student']->nisn ?? '-' }}</td>
                    <td>{{ $item['student']->user->name ?? '-' }}</td>
                    <td>{{ $item['total_subjects'] }}</td>
                    <td style="text-align: center; font-weight: bold;">
                        {{ number_format($item['average'], 2) }}
                    </td>
                    <td style="text-align: center;">
                        @if($item['average'] >= 70)
                            <span class="status-badge badge-success">✓ LULUS</span>
                        @else
                            <span class="status-badge badge-danger">✗ REMEDIASI</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Section -->
        <div style="background: #f8f9fa; border-left: 4px solid #2d5016; padding: 15px; margin-bottom: 30px;">
            <h3 style="color: #2d5016; margin-bottom: 10px;">📋 Catatan Penting:</h3>
            <ul style="margin-left: 20px; color: #666; font-size: 13px;">
                <li>Nilai lulus adalah ≥ 70 (sesuai KKM sekolah)</li>
                <li>Siswa dengan rata-rata &lt; 70 perlu mengikuti remediasi</li>
                <li>Laporan ini dibuat otomatis oleh sistem</li>
                <li>Untuk info detail per siswa, hubungi guru terkait</li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-item">
                <div class="title">Diketahui,<br>Kepala Sekolah</div>
                <div class="name">_________________</div>
            </div>
            <div class="footer-item">
                <div class="title">Dibuat oleh,<br>{{ $user->name }}</div>
                <div class="name">_________________</div>
            </div>
            <div class="footer-item">
                <div class="title">Tanggal Cetak</div>
                <div class="name">{{ now()->format('d-m-Y') }}</div>
            </div>
        </div>
    </div>
</body>
</html>
