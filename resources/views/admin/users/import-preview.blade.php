@extends('layouts.admin')

@section('title', 'Preview & Validasi Import Data Siswa & Guru')

@section('content')
<div class="admin-form-shell">
    <section class="form-hero">
        <div>
            <p class="form-kicker">Validasi Data</p>
            <h1>Preview Import Data</h1>
            <p class="form-subtitle">
                Periksa validasi data Anda sebelum menyimpan ke database. Data berwarna merah menunjukkan ada kesalahan.
            </p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="form-back-link">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </section>

    @if (!empty($validation_errors))
        <div class="alert-box" style="background: #fee; border-color: #fcb; color: #c33;">
            <i class="fas fa-circle-exclamation"></i>
            <div>
                <strong>Periksa kembali file Anda.</strong>
                <ul>
                    @foreach ($validation_errors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Summary -->
    <div class="validation-summary">
        <div class="summary-card valid">
            <div class="summary-number">{{ $summary['valid'] ?? 0 }}</div>
            <div class="summary-label">Data Valid</div>
        </div>
        <div class="summary-card invalid">
            <div class="summary-number">{{ $summary['invalid'] ?? 0 }}</div>
            <div class="summary-label">Data Error</div>
        </div>
        <div class="summary-card total">
            <div class="summary-number">{{ $summary['total'] ?? 0 }}</div>
            <div class="summary-label">Total Baris</div>
        </div>
    </div>

    @if (!empty($warnings))
        <div class="alert-box" style="background: #fef3c7; border-color: #fcd34d; color: #92400e;">
            <i class="fas fa-triangle-exclamation"></i>
            <div>
                <strong>Peringatan:</strong>
                <ul style="margin: 8px 0 0; padding-left: 20px;">
                    @foreach ($warnings as $warning)
                        <li style="font-size: 13px;">{{ $warning }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Valid Data Preview -->
    @if (!empty($valid_rows))
        <div class="preview-section">
            <h3><i class="fas fa-check-circle" style="color: #10b981;"></i> Data Valid ({{ count($valid_rows) }})</h3>

            <div class="table-responsive">
                <table class="preview-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>NISN/NIP</th>
                            <th>Jenjang/Spesialisasi</th>
                            <th>Kelas</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($valid_rows as $index => $row)
                            <tr class="row-valid">
                                <td><i class="fas fa-check" style="color: #10b981; font-weight: bold;"></i></td>
                                <td>{{ $row['name'] }}</td>
                                <td>{{ $row['email'] }}</td>
                                <td>
                                    <span class="badge badge-{{ $row['role'] === 'siswa' ? 'primary' : 'success' }}">
                                        {{ ucfirst($row['role']) }}
                                    </span>
                                </td>
                                <td><code>{{ $row['nisn_nip'] }}</code></td>
                                <td>{{ $row['jenjang_spesialisasi'] }}</td>
                                <td>{{ $row['kelas'] ?? '-' }}</td>
                                <td>{{ $row['phone'] ?? '-' }}</td>
                                <td>{{ $row['address'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Invalid Data Preview -->
    @if (!empty($invalid_rows))
        <div class="preview-section">
            <h3><i class="fas fa-circle-xmark" style="color: #ef4444;"></i> Data Dengan Error ({{ count($invalid_rows) }})</h3>

            <div class="table-responsive">
                <table class="preview-table error">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Baris</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Keterangan Error</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invalid_rows as $index => $row)
                            <tr class="row-invalid">
                                <td><i class="fas fa-times" style="color: #ef4444; font-weight: bold;"></i></td>
                                <td>{{ $row['row_number'] }}</td>
                                <td>{{ $row['name'] }}</td>
                                <td>{{ $row['email'] }}</td>
                                <td>
                                    <ul class="error-list">
                                        @foreach ($row['errors'] as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px; padding: 16px; background: #fef2f2; border-radius: 8px; border-left: 4px solid #ef4444;">
                <p style="margin: 0 0 12px; color: #7f1d1d; font-weight: 600;">Ada data dengan error. Silakan perbaiki dan upload kembali.</p>
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('admin.users.create') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i> Upload Ulang
                    </a>
                    <a href="javascript:void(0)" onclick="downloadErrorLog()" class="btn-secondary">
                        <i class="fas fa-download"></i> Download Log Error
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Confirm & Save if all valid -->
        @if (!empty($valid_rows))
            <div class="preview-section">
                <h3 style="color: #10b981;"><i class="fas fa-check-circle"></i> Semua Data Valid!</h3>
                <p style="color: #666; margin-top: 8px;">Anda siap untuk menyimpan {{ count($valid_rows) }} data ke dalam database.</p>

                <form action="{{ route('admin.users.process-import') }}" method="POST" style="margin-top: 20px;">
                    @csrf
                    <input type="hidden" name="validated_data" value="{{ json_encode($valid_rows) }}">

                    <div style="display: flex; gap: 12px;">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i> Simpan {{ count($valid_rows) }} Data
                        </button>
                        <a href="{{ route('admin.users.create') }}" class="btn-secondary">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        @endif
    @endif
</div>

<style>
    .admin-form-shell {
        max-width: 1200px;
        margin: 0 auto;
        padding: 28px;
    }

    .form-hero {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        align-items: flex-start;
        padding: 28px;
        border-radius: 24px;
        background: linear-gradient(135deg, #23352c 0%, #2d4438 48%, #486e5a 100%);
        color: #ffffff;
        box-shadow: 0 18px 40px rgba(28, 45, 37, 0.16);
        margin-bottom: 24px;
    }

    .form-hero h1 {
        margin: 0;
        font-size: clamp(28px, 3vw, 42px);
        line-height: 1.08;
    }

    .form-kicker {
        margin: 0 0 10px;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        font-size: 12px;
        font-weight: 700;
        opacity: 0.82;
    }

    .form-subtitle {
        margin: 14px 0 0;
        max-width: 62ch;
        color: rgba(255, 255, 255, 0.84);
    }

    .form-back-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 14px;
        text-decoration: none;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.12);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.18);
        white-space: nowrap;
        font-size: 14px;
        transition: all 0.2s;
    }

    .form-back-link:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .validation-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }

    .summary-card {
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        border: 2px solid;
    }

    .summary-card.valid {
        background: #f0fdf4;
        border-color: #10b981;
    }

    .summary-card.valid .summary-number {
        color: #10b981;
    }

    .summary-card.invalid {
        background: #fef2f2;
        border-color: #ef4444;
    }

    .summary-card.invalid .summary-number {
        color: #ef4444;
    }

    .summary-card.total {
        background: #f0f9ff;
        border-color: #3b82f6;
    }

    .summary-card.total .summary-number {
        color: #3b82f6;
    }

    .summary-number {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .summary-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #666;
        font-weight: 600;
    }

    .alert-box {
        padding: 16px 20px;
        border-radius: 12px;
        border-left: 4px solid;
        margin-bottom: 24px;
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }

    .alert-box i {
        flex-shrink: 0;
        margin-top: 2px;
    }

    .alert-box ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert-box li {
        margin-bottom: 4px;
        font-size: 14px;
    }

    .preview-section {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid #e5e7eb;
    }

    .preview-section h3 {
        margin: 0 0 16px;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-responsive {
        overflow-x: auto;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .preview-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .preview-table thead {
        background: #f9fafb;
    }

    .preview-table th {
        padding: 12px 14px;
        text-align: left;
        font-weight: 600;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }

    .preview-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f3f4f6;
    }

    .preview-table tbody tr:last-child td {
        border-bottom: none;
    }

    .preview-table code {
        background: #f3f4f6;
        padding: 2px 6px;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        font-size: 12px;
    }

    .row-valid {
        background: #f0fdf4;
    }

    .row-invalid {
        background: #fef2f2;
    }

    .error-list {
        margin: 0;
        padding-left: 18px;
        color: #ef4444;
        font-weight: 500;
        font-size: 12px;
    }

    .error-list li {
        margin-bottom: 4px;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .badge-primary {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-success {
        background: #dcfce7;
        color: #15803d;
    }

    .btn-primary, .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #10b981;
        color: #fff;
    }

    .btn-primary:hover {
        background: #059669;
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #d1d5db;
    }
</style>

<script>
function downloadErrorLog() {
    const errorLog = @json($invalid_rows ?? []);
    let csv = 'Baris,Nama,Email,Error\n';

    errorLog.forEach(row => {
        const errorText = row.errors.join('; ');
        csv += `${row.row_number},"${row.name}","${row.email}","${errorText}"\n`;
    });

    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'error-log-' + new Date().getTime() + '.csv';
    a.click();
}
</script>
@endsection
