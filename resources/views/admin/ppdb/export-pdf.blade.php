<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pendaftar PPDB</title>
    <style>
        @page { margin: 22px 24px 30px 24px; }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #1f2937;
            font-size: 11px;
            line-height: 1.45;
        }
        .header {
            display: table;
            width: 100%;
            margin-bottom: 14px;
            border-bottom: 2px solid #1f7f5f;
            padding-bottom: 12px;
        }
        .header-cell {
            display: table-cell;
            vertical-align: middle;
        }
        .logo {
            width: 58px;
            height: 58px;
            object-fit: contain;
            margin-right: 12px;
        }
        .school-title {
            font-size: 17px;
            font-weight: 700;
            color: #1f7f5f;
            margin: 0 0 3px 0;
        }
        .report-title {
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 4px 0;
        }
        .meta {
            color: #6b7280;
            font-size: 10px;
            margin: 0;
        }
        .table-wrap { margin-top: 10px; }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead th {
            background: #1f7f5f;
            color: white;
            text-align: center;
            font-size: 10px;
            padding: 8px 6px;
            border: 1px solid #d1d5db;
        }
        tbody td {
            border: 1px solid #d1d5db;
            padding: 7px 6px;
            vertical-align: top;
        }
        tbody tr:nth-child(even) td { background: #f9fafb; }
        .center { text-align: center; }
        .footer {
            margin-top: 12px;
            text-align: right;
            font-size: 11px;
            font-weight: 700;
            color: #111827;
        }
        .empty-state {
            margin-top: 24px;
            padding: 18px;
            border: 1px dashed #cbd5e1;
            text-align: center;
            color: #64748b;
            background: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-cell" style="width: 72px;">
            @if($logoBase64)
                <img class="logo" src="{{ $logoBase64 }}" alt="Logo Sekolah">
            @endif
        </div>
        <div class="header-cell">
            <p class="report-title">DATA PENDAFTAR PPDB</p>
            <p class="school-title">{{ $school->nama_sekolah ?? 'Sekolah Nururudzholam' }}</p>
            <p class="meta">Tanggal Cetak : {{ $exportDate }}</p>
        </div>
    </div>

    @if($rows->isEmpty())
        <div class="empty-state">Belum ada data pendaftar.</div>
        <div class="footer">Total Data : 0</div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width: 28px;">No</th>
                        <th>Nama Lengkap</th>
                        <th style="width: 48px;">Jenjang</th>
                        <th>Email</th>
                        <th style="width: 74px;">Nomor HP</th>
                        <th>Asal Sekolah</th>
                        <th>Program/Jurusan</th>
                        <th style="width: 60px;">Status</th>
                        <th style="width: 84px;">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                        <tr>
                            <td class="center">{{ $row['no'] }}</td>
                            <td>{{ $row['nama_lengkap'] }}</td>
                            <td class="center">{{ $row['jenjang'] }}</td>
                            <td>{{ $row['email'] }}</td>
                            <td>{{ $row['nomor_hp'] }}</td>
                            <td>{{ $row['asal_sekolah'] }}</td>
                            <td>{{ $row['program_jurusan'] }}</td>
                            <td class="center">{{ $row['status'] }}</td>
                            <td>{{ $row['tanggal_daftar'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer">Total Data : {{ $totalData }}</div>
    @endif
</body>
</html>
