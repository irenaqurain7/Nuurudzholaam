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
        --school-primary: #1B4332;
        --school-secondary: #52B788;
        --school-surface: #ffffff;
        --school-muted: #6b7280;
        --school-border: #dbe7e1;
    }

    .grades-page {
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }

    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .page-title {
        margin: 0;
        font-size: 1.9rem;
        font-weight: 800;
        color: var(--school-primary);
    }

    .page-subtitle {
        margin: 0.35rem 0 0;
        color: var(--school-muted);
    }

    .action-group {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-school,
    .btn-outline-school {
        border-radius: 12px;
        font-weight: 700;
        padding: 0.7rem 1rem;
        box-shadow: 0 6px 16px rgba(27, 67, 50, 0.10);
    }

    .btn-school {
        background: linear-gradient(135deg, var(--school-primary), #133026);
        color: #fff;
        border: none;
    }

    .btn-school:hover {
        color: #fff;
        background: linear-gradient(135deg, #16382a, #0f241c);
    }

    .btn-outline-school {
        border: 1px solid rgba(27, 67, 50, 0.20);
        color: var(--school-primary);
        background: #fff;
    }

    .btn-outline-school:hover {
        background: rgba(82, 183, 136, 0.08);
        color: var(--school-primary);
    }

    .card-school {
        border: 1px solid var(--school-border);
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(27, 67, 50, 0.06);
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
        padding: 0.95rem 1rem;
    }

    .workspace-section + .workspace-section {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #edf4ef;
    }

    .label-soft {
        display: block;
        margin-bottom: 0.45rem;
        font-weight: 700;
        color: var(--school-primary);
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        border-color: #cfdcd5;
        min-height: 46px;
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
        gap: 0.85rem;
        align-items: end;
    }

    .filter-item { min-width: 0; display:flex; flex-direction:column; }

    @media (max-width: 767px) {
        .filters-row {
            grid-template-columns: 1fr;
            gap: 0.75rem;
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
        padding-top: 0.55rem;
        padding-bottom: 0.55rem;
    }

    .grade-table tbody td {
        vertical-align: middle;
        padding-top: 0.6rem;
        padding-bottom: 0.6rem;
        border-top: 1px solid #f2f6f3;
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
        padding: 0.8rem 1rem;
        margin-bottom: 0;
        font-weight: 600;
        box-shadow: 0 6px 14px rgba(27, 67, 50, 0.06);
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

        .summary-grid {
            display: none;
        }

        .action-group {
            width: 100%;
        }

        .action-group .btn {
            flex: 1 1 auto;
        }
    }
</style>

<div class="grades-page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Nilai Siswa</h1>
        </div>
        <div class="action-group">
            <button type="button" id="saveAllBtn" class="btn btn-school">Simpan Perubahan</button>
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
                        <label for="subjectInput" class="label-soft">Mapel</label>
                        <input list="subjectList" id="subjectInput" class="form-control" placeholder="Contoh: Matematika" value="{{ $selectedSubjectValue }}">
                        <datalist id="subjectList">
                            @foreach($subjects as $subject)
                                <option value="{{ $subject }}"></option>
                            @endforeach
                        </datalist>
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

                <div class="table-responsive">
                    <table class="table grade-table align-middle mb-0 table-borderless">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIS</th>
                                <th>Kelas</th>
                                <th style="width: 180px;">Nilai</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="studentsTableBody">
                            <tr>
                                <td colspan="5" class="text-center py-4 small-muted">Pilih kelas dan mapel.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="workspace-section" id="importSection">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                    <div>
                        <h6 class="mb-1">Import Nilai</h6>
                        <div class="small-muted">Kolom: NISN, Mapel, Nilai, Keterangan.</div>
                    </div>
                </div>

                <form id="importForm">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-9">
                            <label for="importFile" class="label-soft">File</label>
                            <input type="file" id="importFile" name="file" class="form-control" accept=".xlsx,.csv,.txt" required>
                        </div>
                        <div class="col-lg-3 d-grid">
                            <button type="submit" class="btn btn-school" id="importSubmitBtn">
                                <i class="fas fa-file-import me-2"></i>Import
                            </button>
                        </div>
                    </div>
                </form>

                <div id="importMessage" class="alert d-none mt-3 message-box" role="alert"></div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const classSelect = document.getElementById('classSelect');
    const subjectInput = document.getElementById('subjectInput');
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
        const selectedSubject = subjectInput.value.trim();
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
        const selectedSubject = subjectInput.value.trim();
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
    subjectInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(loadStudents, 300);
    });
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
                    subject: subjectInput.value.trim(),
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

    if (classSelect.value && subjectInput.value.trim()) {
        loadStudents();
    } else {
        renderEmptyRow('Pilih kelas dan mapel untuk menampilkan tabel siswa.');
    }
});
</script>
@endsection
