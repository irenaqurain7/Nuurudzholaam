@extends('teacher.layout')

@section('teacher-content')
@php
    $selectedClassValue = $selectedClass ?? '';
    $selectedSubjectValue = $selectedSubject ?? '';
    $classes = collect($classes ?? []);
    $subjects = collect($subjects ?? []);
@endphp

<style>
    :root {
        --school-primary: #163827;
        --school-primary-contrast: #eaf6ef;
        --school-secondary: #4fb07a;
        --school-surface: #ffffff;
        --school-muted: #6b7280;
        --school-border: #e6f0ea;
    }

    .grades-page {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        max-width: 1180px;
        margin: 0 auto;
        padding: 1.25rem 1rem 2rem;
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .page-title {
        margin: 0;
        font-size: 1.7rem;
        font-weight: 800;
        color: var(--school-primary);
    }

    .page-subtitle {
        margin: 0.25rem 0 0;
        color: var(--school-muted);
    }

    .action-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .btn-school,
    .btn-outline-school {
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 10px 20px;
        box-shadow: 0 2px 6px rgba(27, 67, 50, 0.06);
        line-height: 1.4;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        width: fit-content;
        transition: all 0.2s ease;
    }

    .btn-school { padding: 11px 18px; }

    .badge-soft {
        padding: 0.45rem 0.9rem;
        font-size: 0.86rem;
    }

    .btn-school {
        background: linear-gradient(135deg, var(--school-primary), #133026);
        color: #fff;
    }

    .btn-school:hover {
        color: #fff;
        background: linear-gradient(135deg, #16382a, #0f241c);
        box-shadow: 0 4px 10px rgba(27, 67, 50, 0.12);
        transform: translateY(-1px);
    }

    .btn-outline-school {
        border: 1px solid rgba(27, 67, 50, 0.20);
        color: var(--school-primary);
        background: #fff;
    }

    .btn-outline-school:hover {
        background: rgba(82, 183, 136, 0.08);
        color: var(--school-primary);
        border-color: rgba(27, 67, 50, 0.30);
        box-shadow: 0 2px 8px rgba(27, 67, 50, 0.08);
    }

    /* Custom Dropdown */
    .export-dropdown-wrapper {
        position: relative;
        display: inline-block;
    }

    .export-dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: #fff;
        border: 1px solid rgba(27, 67, 50, 0.15);
        border-radius: 8px;
        box-shadow: 0 8px 20px rgba(27, 67, 50, 0.12);
        min-width: 200px;
        margin-top: 8px;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px);
        transition: all 0.2s ease;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .export-dropdown-menu { right: 0; left: 0; min-width: auto; width: 220px; }
    }

    .export-dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .export-dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        color: var(--school-primary);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        border: none;
        background: none;
        cursor: pointer;
        width: 100%;
        text-align: left;
        transition: all 0.15s ease;
    }

    .export-dropdown-item:hover {
        background: rgba(82, 183, 136, 0.08);
        padding-left: 20px;
    }

    .export-dropdown-item i {
        width: 18px;
        text-align: center;
        font-size: 1rem;
    }

    .export-dropdown-item:not(:last-child) {
        border-bottom: 1px solid rgba(27, 67, 50, 0.05);
    }

    /* Report Filter Modal */
    .report-filter-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        animation: fadeIn 0.2s ease;
    }

    .report-filter-modal-overlay.show {
        display: flex;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .report-filter-modal {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 450px;
        width: 90%;
        animation: slideUp 0.3s ease;
        overflow: hidden;
    }

    .report-filter-modal-header {
        padding: 24px;
        border-bottom: 1px solid rgba(27, 67, 50, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .report-filter-modal-header h3 {
        margin: 0;
        color: var(--school-primary);
        font-weight: 700;
        font-size: 1.2rem;
    }

    .report-filter-modal-close {
        background: none;
        border: none;
        color: var(--school-muted);
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.15s ease;
    }

    .report-filter-modal-close:hover {
        background: rgba(27, 67, 50, 0.08);
        color: var(--school-primary);
    }

    .report-filter-modal-body {
        padding: 24px;
    }

    .report-filter-form-group {
        margin-bottom: 20px;
    }

    .report-filter-form-group:last-child {
        margin-bottom: 0;
    }

    .report-filter-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--school-primary);
    }

    .report-filter-select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid rgba(27, 67, 50, 0.2);
        border-radius: 8px;
        font-size: 0.95rem;
        background: #fff;
        color: var(--school-primary);
        cursor: pointer;
        transition: all 0.2s ease;
        min-height: 44px;
    }

    .report-filter-select:hover {
        border-color: rgba(27, 67, 50, 0.3);
    }

    .report-filter-select:focus {
        outline: none;
        border-color: var(--school-secondary);
        box-shadow: 0 0 0 3px rgba(82, 183, 136, 0.1);
    }

    .report-filter-message {
        padding: 12px 14px;
        border-radius: 8px;
        font-size: 0.9rem;
        margin-bottom: 16px;
        display: none;
        animation: slideUp 0.2s ease;
    }

    .report-filter-message.show {
        display: block;
    }

    .report-filter-message.error {
        background: #fff0f1;
        color: #b42318;
        border: 1px solid #f4c8cc;
        border-left: 4px solid #d64545;
    }

    .report-filter-footer {
        padding: 20px 24px;
        border-top: 1px solid rgba(27, 67, 50, 0.1);
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .report-filter-btn {
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 10px 24px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .report-filter-btn-cancel {
        background: #f0f0f0;
        color: var(--school-primary);
    }

    .report-filter-btn-cancel:hover {
        background: #e0e0e0;
    }

    .report-filter-btn-submit {
        background: linear-gradient(135deg, var(--school-primary), #133026);
        color: #fff;
        box-shadow: 0 4px 12px rgba(27, 67, 50, 0.15);
    }

    .report-filter-btn-submit:hover:not(:disabled) {
        background: linear-gradient(135deg, #16382a, #0f241c);
        box-shadow: 0 6px 16px rgba(27, 67, 50, 0.20);
        transform: translateY(-1px);
    }

    .report-filter-btn-submit:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    @media (max-width: 640px) {
        .report-filter-modal {
            max-width: 95%;
            width: 95%;
        }

        .report-filter-modal-header,
        .report-filter-modal-body,
        .report-filter-footer {
            padding: 16px;
        }

        .report-filter-modal-header h3 {
            font-size: 1.1rem;
        }
    }

    .card-school {
        border: 1px solid var(--school-border);
        border-radius: 12px;
        box-shadow: 0 8px 22px rgba(22, 56, 39, 0.06);
        overflow: hidden;
        background: var(--school-surface);
    }

    .card-school .card-header {
        background: #f7fbf8;
        border-bottom: 1px solid #edf4ef;
        padding: 0.85rem 1rem;
    }

    .card-school .card-header h5,
    .card-school .card-header h6 {
        margin: 0;
        color: var(--school-primary);
        font-weight: 800;
    }

    .card-school .card-body {
        padding: 1.1rem 1.25rem;
    }

    .card-school .card-header h6 {
        font-size: 0.98rem;
        color: #23493b;
        font-weight: 700;
    }

    #saveAllBtn {
        min-width: 150px;
        padding: 10px 18px;
        font-weight: 800;
        box-shadow: 0 10px 24px rgba(22,56,39,0.08);
    }

    .workspace-section + .workspace-section {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #edf4ef;
    }

    .label-soft {
        display: block;
        margin-bottom: 0.35rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--school-primary);
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        border-color: #d1e6db;
        min-height: 48px;
        font-size: 0.96rem;
        padding: 10px 12px;
        background: linear-gradient(180deg, #fff, #fbfffb);
        transition: box-shadow 0.15s ease, border-color 0.12s ease;
        -webkit-appearance: none;
        appearance: none;
    }

    .form-select:hover,
    .form-control:hover {
        border-color: #b9ddc6;
    }

    .form-select:focus,
    .form-control:focus {
        outline: none;
        border-color: var(--school-secondary);
        box-shadow: 0 6px 18px rgba(79, 176, 122, 0.12);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--school-secondary);
        box-shadow: 0 0 0 0.2rem rgba(82, 183, 136, 0.15);
    }

    /* Horizontal filters row */
    .filters-row {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
        align-items: end;
        margin-bottom: 0.6rem;
    }

    .filters-row .filter-item .label-soft {
        font-size: 0.92rem;
        margin-bottom: 0.5rem;
    }

    .filter-item { min-width: 0; display:flex; flex-direction:column; }

    @media (max-width: 767px) {
        .filters-row {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
    }

    @media (max-width: 1024px) and (min-width: 768px) {
        .filters-row {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    .hint-box {
        background: #f7fbf8;
        border: 1px dashed #cfe0d8;
        color: #51665c;
        border-radius: 12px;
        padding: 0.75rem 0.9rem;
        font-size: 0.92rem;
    }

    .empty-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2.4rem 1.2rem;
    }

    .summary-grid {
        display: none;
    }

    .summary-box {
        display: none;
    }

    .summary-box span {
        display: block;
        color: var(--school-muted);
        font-size: 0.8rem;
        margin-bottom: 0.2rem;
    }

    .summary-box strong {
        color: var(--school-primary);
        font-size: 0.98rem;
    }

    .grade-table thead th {
        background: #f8fcf9;
        color: var(--school-primary);
        border-bottom: 1px solid #edf4ef;
        font-weight: 800;
        white-space: nowrap;
        vertical-align: middle;
        padding: 0.9rem 1rem;
    }

    .grade-table tbody td {
        vertical-align: middle;
        padding: 0.85rem 1rem;
        border-top: 1px solid #f2f6f3;
    }

    .grade-table tr:hover td {
        background: #fbfffb;
    }

    .grade-input {
        max-width: 120px;
        min-height: 42px;
    }

    .small-muted {
        color: var(--school-muted);
        font-size: 0.88rem;
    }

    .message-box {
        border: 1px solid transparent;
        border-left-width: 4px;
        border-radius: 12px;
        padding: 1rem 1.1rem;
        margin-bottom: 0;
        font-weight: 600;
        box-shadow: 0 6px 14px rgba(27, 67, 50, 0.06);
    }

    .message-box.is-info {
        max-width: 680px;
    }

    .card-header.d-flex {
        padding: 1.05rem 1.25rem;
    }

    /* Import card visual polish */
    .card-school + .card-school {
        margin-top: 1.25rem;
    }

    .message-box .message-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.15rem;
        font-size: 0.92rem;
    }

    .message-box .message-body {
        font-weight: 500;
        font-size: 0.94rem;
        line-height: 1.4;
    }

    .message-box.is-success {
        background: #eefaf2;
        border-color: #c9ebd4;
        border-left-color: #2f855a;
        color: #1f5e42;
    }

    .message-box.is-warning {
        background: #fff8e8;
        border-color: #f5e3b5;
        border-left-color: #d69e2e;
        color: #8a6412;
    }

    .message-box.is-danger {
        background: #fff0f1;
        border-color: #f4c8cc;
        border-left-color: #d64545;
        color: #b42318;
    }

    .message-box.is-info {
        background: #edf7fb;
        border-color: #cbe5f0;
        border-left-color: #2b6cb0;
        color: #23527c;
    }

    .row-saving {
        opacity: 0.7;
        background: rgba(82, 183, 136, 0.03);
    }

    .badge-soft {
        background: rgba(82, 183, 136, 0.12);
        color: var(--school-primary);
        border: 1px solid rgba(27, 67, 50, 0.10);
        font-weight: 700;
    }

    .save-grade-btn {
        width: 100%;
        min-height: 42px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #1B4332 0%, #52B788 100%);
        color: #fff;
        font-weight: 800;
        box-shadow: 0 8px 18px rgba(27, 67, 50, 0.18);
    }

    .save-grade-btn:hover:not(:disabled) {
        color: #fff;
        background: linear-gradient(135deg, #16382a 0%, #40986d 100%);
        box-shadow: 0 10px 22px rgba(27, 67, 50, 0.24);
        transform: translateY(-1px);
    }

    .save-grade-btn:disabled {
        opacity: 0.8;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.55rem;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .summary-grid {
            display: none;
        }

        .action-group {
            gap: 8px;
        }

        .btn-school,
        .btn-outline-school {
            padding: 8px 16px;
            font-size: 0.85rem;
        }

        .export-dropdown-menu {
            right: 0;
            left: auto;
        }
        .message-box {
            width: 100%;
            box-sizing: border-box;
        }
    }

    /* Ensure table area keeps visual height when empty */
    .table-responsive {
        min-height: 220px;
        display: block;
        background: linear-gradient(180deg, #fff, #fbfffb);
        border-radius: 10px;
        padding: 0.6rem;
        border: 1px solid rgba(28, 71, 52, 0.04);
    }
</style>

<div class="grades-page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Nilai Siswa</h1>
        </div>
        <div class="action-group">
            <button type="button" id="saveAllBtn" class="btn btn-school">Simpan Perubahan</button>
            <button type="button" id="reportBtn" class="btn btn-outline-school" title="Lihat laporan ringkasan">
                <i class="fas fa-chart-bar"></i> Laporan
            </button>
            <div class="export-dropdown-wrapper">
                <button type="button" class="btn btn-outline-school" id="exportBtn">
                    <i class="fas fa-download"></i> Export
                </button>
                <div class="export-dropdown-menu" id="exportDropdown">
                    <a href="{{ route('teacher.export-grades-excel') }}" class="export-dropdown-item">
                        <i class="fas fa-file-excel"></i>
                        <span>Export Excel</span>
                    </a>
                    <button type="button" class="export-dropdown-item" onclick="exportToPDF(); return false;">
                        <i class="fas fa-file-pdf"></i>
                        <span>Export PDF</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-school">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h5 class="mb-1">Filter Nilai</h5>
                <div class="small-muted">Satu area kerja untuk cari dan isi nilai.</div>
            </div>
            <span class="badge badge-soft rounded-pill px-3 py-2" id="tableStatus">Menunggu filter kelas dan mapel</span>
        </div>

        <div class="card-body">
            <div class="workspace-section">
                <div class="filters-row">
                    <div class="filter-item filter-class">
                        <label for="classSelect" class="label-soft">Kelas</label>
                        <select id="classSelect" class="form-select">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class }}" {{ $selectedClassValue === $class ? 'selected' : '' }}>{{ $class }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-item filter-subject">
                        <label for="subjectSelect" class="label-soft">Mapel</label>
                        <select id="subjectSelect" name="subject" class="form-select">
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject }}" {{ $selectedSubjectValue === $subject ? 'selected' : '' }}>{{ $subject }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-item filter-search">
                        <label for="studentSearch" class="label-soft">Cari</label>
                        <input type="search" id="studentSearch" class="form-control" placeholder="Cari nama atau NIS">
                    </div>
                </div>

            </div>

            <div class="workspace-section">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                    <div>
                        <h6 class="mb-0">Data Siswa</h6>
                    </div>
                </div>

                <div class="summary-grid mb-3 d-none" aria-hidden="true">
                    <div class="summary-box">
                        <span>Total Siswa</span>
                        <strong id="summaryTotal">0</strong>
                    </div>
                    <div class="summary-box">
                        <span>Sudah Ada Nilai</span>
                        <strong id="summaryFilled">0</strong>
                    </div>
                    <div class="summary-box">
                        <span>Rata-rata</span>
                        <strong id="summaryAverage">-</strong>
                    </div>
                </div>

                <div id="tableMessage" class="alert d-none message-box" role="alert" aria-hidden="true"></div>

                @if(!empty($selectedClassValue) && !empty($selectedSubjectValue))
                    <div class="table-responsive">
                        <table class="table grade-table align-middle mb-0 table-borderless">
                            <thead>
                                <tr>
                                    <th class="p-3">Nama</th>
                                    <th class="p-3">NIS</th>
                                    <th class="p-3">Kelas</th>
                                    <th class="p-3" style="width: 180px;">Nilai</th>
                                    <th class="p-3" style="width: 160px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTableBody">
                                {{-- Rows will be rendered by JS after fetching via AJAX --}}
                                <tr>
                                    <td colspan="5" class="text-center py-4 small-muted">Memuat data siswa...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-placeholder">
                        <div class="message-box is-info" style="display:inline-block;">
                            <div class="message-title"><i class="fas fa-info-circle"></i><span>Perhatian</span></div>
                            <div class="message-body">Silakan pilih kelas dan mapel terlebih dahulu.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Import section moved to its own card for clarity --}}
    <div class="card card-school mt-4">
        <div class="card-header">
            <h6 class="mb-0">Import Nilai</h6>
        </div>
        <div class="card-body">
            <div class="small-muted">Kolom: NISN, Mapel, Nilai, Keterangan.</div>
            <form id="importForm" class="mt-3">
                @csrf
                <div style="display:flex; gap:1rem; align-items:center; flex-wrap:wrap;">
                    <div style="flex:1; min-width:240px;">
                        <label for="importFile" class="label-soft">File</label>
                        <input type="file" id="importFile" name="file" class="form-control" accept=".xlsx,.csv,.txt" required>
                    </div>
                    <div style="min-width:160px;">
                        <button type="submit" class="btn btn-school" id="importSubmitBtn">
                            <i class="fas fa-file-import me-2"></i>Import
                        </button>
                    </div>
                    <div style="flex-basis:100%;"></div>
                    <div id="importMessage" class="mt-3" style="width:100%;"></div>
                </div>
            </form>
        </div>
    </div>
        </div>
    </div>
</div>

<!-- Report Filter Modal -->
<div class="report-filter-modal-overlay" id="reportFilterOverlay">
    <div class="report-filter-modal">
        <div class="report-filter-modal-header">
            <h3><i class="fas fa-filter"></i> Filter Laporan</h3>
            <button type="button" class="report-filter-modal-close" id="reportFilterClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="report-filter-modal-body">
            <div id="reportFilterMessage" class="report-filter-message"></div>
            <form id="reportFilterForm">
                <div class="report-filter-form-group">
                    <label for="reportClassSelect" class="report-filter-label">Kelas</label>
                    <select id="reportClassSelect" class="report-filter-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        <option value="1A">1A</option>
                        <option value="2A">2A</option>
                        <option value="3A">3A</option>
                        <option value="4A">4A</option>
                        <option value="5A">5A</option>
                        <option value="6A">6A</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="report-filter-footer">
            <button type="button" class="report-filter-btn report-filter-btn-cancel" id="reportFilterCancel">
                Batal
            </button>
            <button type="button" class="report-filter-btn report-filter-btn-submit" id="reportFilterSubmit" disabled>
                Tampilkan Laporan
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const classSelect = document.getElementById('classSelect');
    const subjectSelect = document.getElementById('subjectSelect');
    const studentSearch = document.getElementById('studentSearch');
    const studentsTableBody = document.getElementById('studentsTableBody');
    const tableMessage = document.getElementById('tableMessage');
    const tableStatus = document.getElementById('tableStatus');
    const summaryTotal = document.getElementById('summaryTotal');
    const summaryFilled = document.getElementById('summaryFilled');
    const summaryAverage = document.getElementById('summaryAverage');
    const importForm = document.getElementById('importForm');
    const importMessage = document.getElementById('importMessage');
    const importSubmitBtn = document.getElementById('importSubmitBtn');
    const importFile = document.getElementById('importFile');

    const routes = {
        students: '{{ route("teacher.grades.students-by-class") }}',
        save: '{{ route("teacher.grades.ajax.store") }}',
        import: '{{ route("teacher.grades.import") }}',
        batch: '{{ route("teacher.grades.ajax.batch") }}'
    };

    let debounceTimer = null;

    function showTableMessage(type, message) {
        const iconMap = {
            success: 'fa-circle-check',
            warning: 'fa-triangle-exclamation',
            danger: 'fa-circle-xmark',
            info: 'fa-circle-info'
        };

        const titleMap = {
            success: 'Tersimpan',
            warning: 'Perhatian',
            danger: 'Gagal',
            info: 'Info'
        };

        const resolvedType = iconMap[type] ? type : 'info';
        tableMessage.className = 'message-box is-' + resolvedType;
        tableMessage.innerHTML =
            '<div class="message-title"><i class="fas ' + iconMap[resolvedType] + '"></i><span>' + titleMap[resolvedType] + '</span></div>' +
            '<div class="message-body">' + message + '</div>';
        tableMessage.classList.remove('d-none');
    }

    function hideTableMessage() {
        tableMessage.classList.add('d-none');
    }

    function safeParseResponseBody(bodyText) {
        if (!bodyText) {
            return null;
        }

        try {
            return JSON.parse(bodyText);
        } catch (error) {
            return {
                message: bodyText
            };
        }
    }

    function formatGrade(value) {
        if (value === null || value === undefined || value === '') {
            return '-';
        }

        const numericValue = Number(value);
        if (Number.isNaN(numericValue)) {
            return '-';
        }

        return numericValue.toFixed(2).replace(/\.00$/, '');
    }

    function gradeBadgeClass(value) {
        const numericValue = Number(value);
        if (Number.isNaN(numericValue)) {
            return 'secondary';
        }
        if (numericValue >= 85) return 'success';
        if (numericValue >= 75) return 'info';
        if (numericValue >= 65) return 'warning';
        return 'danger';
    }

    function renderEmptyRow(text) {
        studentsTableBody.innerHTML = '<tr><td colspan="5" class="text-center py-4 small-muted">' + text + '</td></tr>';
    }

    function updateSummary(students) {
        const total = students.length;
        const filled = students.filter(function(student) {
            return student.grade !== null && student.grade !== '';
        }).length;

        const averageValues = students
            .filter(function(student) { return student.grade !== null && student.grade !== ''; })
            .map(function(student) { return Number(student.grade); })
            .filter(function(value) { return !Number.isNaN(value); });

        summaryTotal.textContent = total;
        summaryFilled.textContent = filled;
        summaryAverage.textContent = averageValues.length ? (averageValues.reduce(function(sum, item) { return sum + item; }, 0) / averageValues.length).toFixed(2) : '-';
    }

    function renderStudents(students) {
        if (!students.length) {
            renderEmptyRow('Tidak ada siswa pada filter ini.');
            updateSummary([]);
            tableStatus.textContent = 'Data kosong';
            return;
        }

        studentsTableBody.innerHTML = students.map(function(student) {
            const gradeValue = student.grade === null || student.grade === undefined ? '' : student.grade;
            const badgeClass = gradeBadgeClass(student.grade);
            const badgeText = gradeValue === '' ? 'Belum ada nilai' : formatGrade(gradeValue);

            return [
                '<tr data-student-id="' + student.id + '">',
                    '<td class="fw-semibold">' + (student.name || '-') + '</td>',
                    '<td>' + (student.nisn || '-') + '</td>',
                    '<td>' + (student.class || '-') + '</td>',
                    '<td>',
                        '<input type="number" class="form-control grade-input" min="0" max="100" step="0.01" value="' + gradeValue + '" data-original-value="' + (gradeValue === '' ? '' : gradeValue) + '" placeholder="0 - 100">',
                        '<div class="mt-2"><span class="badge bg-' + badgeClass + '" data-grade-badge>' + badgeText + '</span></div>',
                    '</td>',
                    '<td>',
                        '<button type="button" class="save-grade-btn" disabled>',
                            'Simpan',
                        '</button>',
                    '</td>',
                '</tr>'
            ].join('');
        }).join('');

        updateSummary(students);
        tableStatus.textContent = students.length + ' siswa ditampilkan';
    }

    async function loadStudents() {
        const selectedClass = classSelect.value.trim();
        const selectedSubject = (subjectSelect ? subjectSelect.value : '').trim();
        const search = studentSearch.value.trim();

        if (!selectedClass || !selectedSubject) {
            tableStatus.textContent = 'Menunggu filter kelas dan mapel';
            renderEmptyRow('Pilih kelas dan mapel untuk menampilkan tabel siswa.');
            return;
        }

        studentsTableBody.innerHTML = '<tr><td colspan="5" class="text-center py-4 small-muted">Memuat data siswa...</td></tr>';
        tableStatus.textContent = 'Memuat data...';
        hideTableMessage();

        const params = new URLSearchParams({
            class: selectedClass,
            subject: selectedSubject,
            search: search,
        });

        try {
            const response = await fetch(routes.students + '?' + params.toString(), {
                headers: { 'Accept': 'application/json' }
            });
            const data = await response.json();

            if (data.success) {
                renderStudents(data.students || []);
            } else {
                renderEmptyRow('Gagal memuat data siswa.');
                tableStatus.textContent = 'Gagal memuat';
            }
        } catch (error) {
            renderEmptyRow('Gagal memuat data siswa.');
            tableStatus.textContent = 'Gagal memuat';
        }
    }

    async function saveRow(row) {
        const studentId = row.getAttribute('data-student-id');
        const gradeInput = row.querySelector('.grade-input');
        const badge = row.querySelector('[data-grade-badge]');
        const button = row.querySelector('.save-grade-btn');
        const selectedSubject = (subjectSelect ? subjectSelect.value : '').trim();
        const gradeValue = gradeInput.value.trim();
        let result = false;

        if (!selectedSubject) {
            showTableMessage('warning', 'Pilih mapel terlebih dahulu.');
            return;
        }

        if (gradeValue === '') {
            showTableMessage('warning', 'Isi nilai sebelum menyimpan.');
            return;
        }

        const numericGrade = Number(gradeValue);
        if (Number.isNaN(numericGrade) || numericGrade < 0 || numericGrade > 100) {
            showTableMessage('warning', 'Nilai harus berada di rentang 0-100.');
            return;
        }

        const originalLabel = button.innerHTML;
        row.classList.add('row-saving');
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan';

        try {
            const formData = new FormData();
            formData.append('student_id', studentId);
            formData.append('subject', selectedSubject);
            formData.append('grade', numericGrade);
            formData.append('notes', '');

            const response = await fetch(routes.save, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const responseText = await response.text();
            const data = safeParseResponseBody(responseText) || {};

            if (response.ok && data.success) {
                badge.className = 'badge bg-' + gradeBadgeClass(numericGrade);
                badge.textContent = formatGrade(numericGrade);
                // update original value so change detection resets
                gradeInput.setAttribute('data-original-value', String(numericGrade));
                // set button back to idle disabled state
                button.disabled = true;
                button.textContent = 'Simpan';

                showTableMessage('success', data.message || 'Nilai berhasil disimpan.');
                setTimeout(function() {
                    hideTableMessage();
                }, 1800);
                result = true;
            } else {
                const validationMessage = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Gagal menyimpan nilai.');
                showTableMessage('danger', validationMessage);
                // restore button label so user can retry
                button.disabled = false;
                button.innerHTML = originalLabel;
                result = false;
            }
        } catch (error) {
            showTableMessage('danger', 'Terjadi kesalahan saat menyimpan nilai. Coba lagi.');
            result = false;
        } finally {
            row.classList.remove('row-saving');
        }

        return result;
    }

    classSelect.addEventListener('change', loadStudents);
    if (subjectSelect) {
        subjectSelect.addEventListener('change', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(loadStudents, 300);
        });
    }
    studentSearch.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(loadStudents, 300);
    });

    studentsTableBody.addEventListener('click', function(event) {
        const saveButton = event.target.closest('.save-grade-btn');
        if (!saveButton) {
            return;
        }

        const row = saveButton.closest('tr');
        if (row) {
            saveRow(row);
        }
    });

    // Bulk save: find rows with changed values and save sequentially
    const saveAllBtn = document.getElementById('saveAllBtn');
    if (saveAllBtn) {
        saveAllBtn.addEventListener('click', async function() {
            const allRows = Array.from(studentsTableBody.querySelectorAll('tr[data-student-id]'));
            const changedRows = allRows.filter(function(row) {
                const input = row.querySelector('.grade-input');
                if (!input) return false;
                const original = String(input.getAttribute('data-original-value') ?? '');
                const current = String((input.value ?? '').trim());
                return current !== original;
            });

            if (!changedRows.length) {
                showTableMessage('info', 'Tidak ada perubahan untuk disimpan.');
                setTimeout(hideTableMessage, 1800);
                return;
            }

            // Build payload
            const payload = changedRows.map(function(row) {
                const input = row.querySelector('.grade-input');
                const studentId = row.getAttribute('data-student-id');
                const val = input.value.trim();
                const gradeVal = val === '' ? null : Number(val);
                return {
                    student_id: studentId,
                    subject: (subjectSelect ? subjectSelect.value.trim() : ''),
                    grade: gradeVal,
                    notes: ''
                };
            });

            saveAllBtn.disabled = true;
            const originalTxt = saveAllBtn.innerHTML;
            saveAllBtn.innerHTML = 'Menyimpan...';

            try {
                const response = await fetch(routes.batch, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ grades: payload })
                });

                const data = await response.json().catch(function() { return { success: false, message: 'Invalid server response' }; });

                if (response.ok && data.success) {
                    // update UI per-row
                    changedRows.forEach(function(row, idx) {
                        const input = row.querySelector('.grade-input');
                        const badge = row.querySelector('[data-grade-badge]');
                        const val = payload[idx].grade;
                        input.setAttribute('data-original-value', val === null ? '' : String(val));
                        badge.className = 'badge bg-' + gradeBadgeClass(val);
                        badge.textContent = formatGrade(val);
                        const btn = row.querySelector('.save-grade-btn');
                        if (btn) { btn.disabled = true; btn.textContent = 'Simpan'; }
                    });

                    showTableMessage('success', data.message || 'Perubahan berhasil disimpan.');
                } else {
                    const msg = data.message || 'Gagal menyimpan perubahan.';
                    showTableMessage('danger', msg);
                }
            } catch (e) {
                showTableMessage('danger', 'Terjadi kesalahan saat menyimpan perubahan.');
            } finally {
                saveAllBtn.disabled = false;
                saveAllBtn.innerHTML = originalTxt;
                setTimeout(hideTableMessage, 2200);
            }
        });
    }

    // Detect input changes per-row and toggle save button label/state
    studentsTableBody.addEventListener('input', function(event) {
        const input = event.target.closest('.grade-input');
        if (!input) return;

        const row = input.closest('tr');
        if (!row) return;

        const button = row.querySelector('.save-grade-btn');
        const original = String(input.getAttribute('data-original-value') ?? '');
        const current = String(input.value ?? '');

        if (current !== original) {
            button.disabled = false;
            button.textContent = 'Simpan Perubahan';
        } else {
            button.disabled = true;
            button.textContent = 'Simpan';
        }
    });

    importForm.addEventListener('submit', async function(event) {
        event.preventDefault();

        if (!importFile.files.length) {
            importMessage.className = 'alert alert-warning message-box';
            importMessage.textContent = 'Pilih file terlebih dahulu.';
            importMessage.classList.remove('d-none');
            return;
        }

        const formData = new FormData(importForm);
        const originalLabel = importSubmitBtn.innerHTML;

        importSubmitBtn.disabled = true;
        importSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';

        try {
            const response = await fetch(routes.import, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const responseText = await response.text();
            const data = safeParseResponseBody(responseText) || {};

            if (response.ok && data.success) {
                importMessage.className = 'alert alert-success message-box';
                importMessage.textContent = data.message || 'Import selesai.';
                importMessage.classList.remove('d-none');
                importForm.reset();
                loadStudents();
            } else {
                const fallback = responseText && responseText.length < 800 ? responseText : (data.message || 'Gagal import file.');
                const validationMessage = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : fallback);
                importMessage.className = 'alert alert-danger message-box';
                importMessage.textContent = validationMessage;
                importMessage.classList.remove('d-none');
            }
        } catch (error) {
            importMessage.className = 'alert alert-danger message-box';
            importMessage.textContent = 'Terjadi kesalahan saat import file.';
            importMessage.classList.remove('d-none');
        } finally {
            importSubmitBtn.disabled = false;
            importSubmitBtn.innerHTML = originalLabel;
        }
    });

    if (classSelect.value && (subjectSelect ? subjectSelect.value.trim() : '')) {
        loadStudents();
    } else {
        renderEmptyRow('Pilih kelas dan mapel untuk menampilkan tabel siswa.');
    }

    // Export functions
    window.exportToPDF = function() {
        const selectedClass = classSelect.value;
        if (!selectedClass) {
            alert('Pilih kelas terlebih dahulu');
            return;
        }
        const selectedSubject = (subjectSelect ? subjectSelect.value : '');
        window.location.href = '{{ route("teacher.export-report-pdf") }}?class=' + encodeURIComponent(selectedClass) + '&subject=' + encodeURIComponent(selectedSubject);
    };

    window.exportToExcel = function() {
        const selectedClass = classSelect.value;
        if (!selectedClass) {
            alert('Pilih kelas terlebih dahulu');
            return;
        }
        const selectedSubject = (subjectSelect ? subjectSelect.value : '');
        window.location.href = '{{ route("teacher.export-grades-excel") }}?class=' + encodeURIComponent(selectedClass) + '&subject=' + encodeURIComponent(selectedSubject);
    };

    // Custom Export Dropdown Handler
    const exportBtn = document.getElementById('exportBtn');
    const exportDropdown = document.getElementById('exportDropdown');

    if (exportBtn && exportDropdown) {
        // Toggle dropdown when button is clicked
        exportBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            exportDropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!exportBtn.contains(e.target) && !exportDropdown.contains(e.target)) {
                exportDropdown.classList.remove('show');
            }
        });

        // Close dropdown after clicking on an item
        const exportItems = exportDropdown.querySelectorAll('.export-dropdown-item');
        exportItems.forEach(item => {
            item.addEventListener('click', function() {
                setTimeout(() => {
                    exportDropdown.classList.remove('show');
                }, 100);
            });
        });
    }

    // Report Filter Modal Handler
    const reportBtn = document.getElementById('reportBtn');
    const reportFilterOverlay = document.getElementById('reportFilterOverlay');
    const reportFilterClose = document.getElementById('reportFilterClose');
    const reportFilterCancel = document.getElementById('reportFilterCancel');
    const reportFilterSubmit = document.getElementById('reportFilterSubmit');
    const reportClassSelect = document.getElementById('reportClassSelect');
    const reportFilterMessage = document.getElementById('reportFilterMessage');
    const reportFilterForm = document.getElementById('reportFilterForm');

    // Open modal when Laporan button is clicked
    if (reportBtn) {
        reportBtn.addEventListener('click', function() {
            reportFilterOverlay.classList.add('show');
            reportClassSelect.focus();
        });
    }

    // Close modal
    function closeReportModal() {
        reportFilterOverlay.classList.remove('show');
        reportFilterMessage.classList.remove('show', 'error');
        reportClassSelect.value = '';
        reportFilterSubmit.disabled = true;
    }

    if (reportFilterClose) {
        reportFilterClose.addEventListener('click', closeReportModal);
    }

    if (reportFilterCancel) {
        reportFilterCancel.addEventListener('click', closeReportModal);
    }

    // Close modal when clicking outside
    if (reportFilterOverlay) {
        reportFilterOverlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeReportModal();
            }
        });
    }

    // Handle class selection
    if (reportClassSelect) {
        reportClassSelect.addEventListener('change', function() {
            if (this.value) {
                reportFilterSubmit.disabled = false;
                reportFilterMessage.classList.remove('show');
            } else {
                reportFilterSubmit.disabled = true;
                reportFilterMessage.classList.remove('show');
            }
        });
    }

    // Handle form submission
    if (reportFilterSubmit) {
        reportFilterSubmit.addEventListener('click', function() {
            const selectedClass = reportClassSelect.value;
            
            if (!selectedClass) {
                reportFilterMessage.textContent = 'Silakan pilih kelas terlebih dahulu';
                reportFilterMessage.classList.add('show', 'error');
                return;
            }

            // Redirect to report page with selected class
            window.location.href = '{{ route("teacher.report-summary") }}?class=' + encodeURIComponent(selectedClass);
        });
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && reportFilterOverlay.classList.contains('show')) {
            closeReportModal();
        }
    });
});
</script>
@endsection
