@extends('teacher.layout')

@section('teacher-content')
@php
    $hasSelectedStudent = !empty($selectedStudent);
    $selectedClassValue = $selectedClass ?? '';

    $classStats = collect($students ?? [])->groupBy('class')->map(function ($group) {
        return $group->count();
    });

    $baseClasses = collect(['1A', '2A', '3A', '4A', '5A', '6A']);
    $extraClasses = collect($classes ?? [])->filter(function ($c) use ($baseClasses) {
        return !$baseClasses->contains((string) $c);
    });
    $displayClasses = $baseClasses->merge($extraClasses)->unique()->values();

    $selectedStudentObj = collect($students ?? [])->firstWhere('id', $selectedStudent ?? null);
    $studentsInSelectedClass = collect($students ?? [])->filter(function ($student) use ($selectedClassValue) {
        if ($selectedClassValue === '' || $selectedClassValue === null) {
            return false;
        }

        return (string) $student->class === (string) $selectedClassValue;
    })->values();
@endphp

<style>
    /* Header */
    .grades-header { display:flex; align-items:center; justify-content:space-between; gap:1rem; margin-bottom:1.5rem; }
    .grades-header h1 { margin:0; font-size:1.75rem; font-weight:700; color:var(--hijau-islam); }
    /* Tidy table and class cards for cleaner layout */
    .classes-grid { gap: 1.1rem; }
    .class-card { border-radius: 10px; padding: .9rem 1rem; transition: transform .08s ease; }
    .class-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(2,6,23,0.06); }
    .custom-grades-table th, .custom-grades-table td { padding: .95rem 1.2rem; vertical-align: middle; }
    .custom-grades-table tbody tr:hover { background: #fbfbfb; }
    .table-action-group { display:flex; gap:.5rem; align-items:center; }
    .table-action-group .btn { padding:.45rem .7rem; border-radius:8px; }
    .student-summary { gap:1rem; align-items:center; }
    @media (max-width: 767px) { .class-card { padding:.7rem; } }

    /* Class grid */
    .class-grid { display:grid; grid-template-columns:repeat(6, minmax(0,1fr)); gap:.75rem; margin-bottom:1.5rem; }
    .class-card {
        background:#fff;
        border:1px solid #e6f0ea;
        border-left:6px solid rgba(45,68,56,0.12);
        border-radius:12px;
        padding:1rem;
        box-shadow:0 3px 10px rgba(45, 68, 56, 0.06);
        transition:transform .18s ease, box-shadow .18s ease;
        display:flex;
        flex-direction:column;
        justify-content:space-between;
    }
    .class-card:hover { transform:translateY(-3px); box-shadow:0 12px 22px rgba(45, 68, 56, 0.08); }
    .hover-shadow:hover { box-shadow: 0 12px 22px rgba(0,0,0,0.08) !important; transform: translateY(-3px); }
    .class-card.active { border-left-color:var(--hijau-islam); }
    .class-card h6 { margin:0 0 .35rem 0; font-size:.82rem; color:#5a7e6b; text-transform:uppercase; letter-spacing:.4px; }
    .class-card strong { font-size:1.35rem; color:#163022; }
    .class-card .small a { text-decoration:none; font-size:.82rem; color:#2d4438; font-weight:600; }

    /* Cards and summaries */
    .filter-card, .student-summary, .table-card {
        border-radius:12px;
        border:1px solid #e6f0ea;
        box-shadow:0 3px 10px rgba(45, 68, 56, 0.06);
        overflow:hidden;
    }

    .filter-card .card-header,
    .table-card .card-header,
    .student-summary .card-header {
        border-bottom:1px solid #eef6f2;
        background:transparent;
        padding:0.9rem 1rem;
    }

    .student-summary .avatar {
        width:56px;
        height:56px;
        border-radius:50%;
        background:#e9f0eb;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        font-size:22px;
        color:var(--hijau-islam);
    }
    .stat-box {
        background:#f7faf8;
        border-radius:8px;
        padding:.65rem;
        text-align:center;
    }
    .stat-box strong { display:block; font-size:1.1rem; color:var(--hijau-islam); }

    /* Table styles */
    .table thead th {
        background:#f6faf8;
        border-bottom:2px solid rgba(0,0,0,.03);
        white-space:nowrap;
        color:var(--hijau-islam);
        font-size:.92rem;
        vertical-align:middle;
    }
    .table tbody td { vertical-align:middle; }
    .table a { text-decoration:none; }

    /* Students list specific tweaks */
    .custom-grades-table th, .custom-grades-table td { padding: 0.9rem 1.1rem; }
    .custom-grades-table thead th { background: #eef6f2; color: var(--hijau-islam); font-weight:600; }
    .custom-grades-table tbody tr:hover { background: rgba(45,68,56,0.03); }
    .col-nis { width: 110px; }
    .col-class { width: 120px; }
    .col-actions { width: 220px; }
    .action-buttons { display:flex; gap:0.5rem; align-items:center; }
    .action-buttons .btn { padding: .35rem .6rem; font-size:.82rem; }

    /* Button theme overrides to match teacher pages */
    .btn-success {
        background-color:var(--hijau-islam);
        border-color:var(--hijau-islam);
        color:#fff;
    }
    .btn-success:hover, .btn-success:focus { background-color:#163022; border-color:#163022; }

    .btn-outline-primary { color:var(--hijau-islam); border-color:var(--hijau-islam); }
    .btn-outline-primary:hover { background:rgba(45,68,56,0.06); }

    .btn-outline-success { color:var(--hijau-islam); border-color:var(--hijau-islam); }
    .btn-outline-success:hover { background:rgba(45,68,56,0.04); }

    .btn-outline-warning { color:#9a6b1a; border-color:#9a6b1a; }
    .btn-outline-danger { color:#b02a37; border-color:#b02a37; }

    /* Small action buttons spacing */
    .table .btn { padding:.35rem .5rem; font-size:.82rem; }

    /* Header buttons styling */
    .btn-header-group { display:flex; gap:0.75rem; flex-wrap:wrap; align-items:center; }
    .btn-header-group .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 0.65rem 1.3rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(45, 68, 56, 0.2);
        border: none;
    }
    .btn-header-group .btn-success {
        background: linear-gradient(135deg, #2D4438 0%, #163022 100%);
        color: white;
    }
    .btn-header-group .btn-success:hover:not(:disabled) {
        background: linear-gradient(135deg, #163022 0%, #0f1f18 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(45, 68, 56, 0.3);
    }
    .btn-header-group .btn-success:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .btn-header-group .btn-dark {
        background: linear-gradient(135deg, #2D4438 0%, #163022 100%);
        color: white;
    }
    .btn-header-group .btn-dark:hover {
        background: linear-gradient(135deg, #163022 0%, #0f1f18 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(45, 68, 56, 0.3);
    }
    .btn-header-group .dropdown-toggle::after {
        margin-left: 0.4rem;
    }

    /* Dropdown menu styling */
    .btn-header-group .dropdown-menu {
        border-radius: 8px;
        border: none;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        min-width: 180px;
        display: none !important;
    }
    .btn-header-group .dropdown-menu.show {
        display: block !important;
    }
    .btn-header-group .dropdown-item {
        padding: 0.7rem 1.2rem;
        font-weight: 500;
        color: #2D4438;
        transition: all 0.2s ease;
    }
    .btn-header-group .dropdown-item:hover {
        background: rgba(45, 68, 56, 0.08);
        color: #163022;
    }
    .btn-header-group .dropdown-item i {
        margin-right: 0.6rem;
        width: 14px;
        color: #2D4438;
    }

    @media (max-width: 1199px) { .class-grid { grid-template-columns:repeat(3, minmax(0,1fr)); } }
    @media (max-width: 768px) { .class-grid { grid-template-columns:repeat(2, minmax(0,1fr)); } }
    @media (max-width: 576px) { 
        .grades-header { flex-direction:column; align-items:flex-start; }
        .btn-header-group { width: 100%; }
        .btn-header-group .btn { flex: 1; }
    }
</style>

<div class="grades-header">
    <h1 class="h2">Kelola Nilai Siswa</h1>
    <div class="btn-header-group">
        <button
            class="btn btn-success"
            id="add-grade-ajax-btn"
            {{ !$hasSelectedStudent ? 'disabled' : '' }}
            data-bs-toggle="modal"
            data-bs-target="#addGradeModal"
            title="Tambah nilai dengan form cepat"
        >
            <i class="fas fa-plus me-2"></i> Tambah Nilai
        </button>
        <button
            class="btn btn-dark"
            id="import-grades-btn"
            data-bs-toggle="modal"
            data-bs-target="#importGradesModal"
            title="Import nilai dari file CSV/Excel"
        >
            <i class="fas fa-file-import me-2"></i> Import
        </button>
        <div class="dropdown">
            <button
                class="btn btn-dark dropdown-toggle"
                type="button"
                id="exportDropdownBtn"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                title="Download laporan nilai"
            >
                <i class="fas fa-file-export me-2"></i> Export
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdownBtn">
                <li>
                    <a class="dropdown-item" href="{{ route('teacher.grades.export') }}">
                        <i class="fas fa-file-csv"></i> Export CSV
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('teacher.grades.export-excel') }}">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="class-grid">
    @foreach($displayClasses as $class)
        @php
            $classKey = (string) $class;
            $count = $classStats->get($classKey, 0);
            $active = ((string) $selectedClassValue === $classKey);
        @endphp
        <div class="class-card hover-shadow {{ $active ? 'active' : '' }}">
            <h6>Kelas {{ $classKey }}</h6>
            <strong>{{ $count }} siswa</strong>
            <div class="mt-2 small">
                <a href="{{ route('teacher.grades', ['class' => $classKey]) }}">Lihat kelas</a>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card student-summary">
            <div class="card-body">
                @if($hasSelectedStudent)
                    @php $selectedNis = $selectedStudentObj->nis ?? $selectedStudentObj->nisn ?? '-'; @endphp
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="avatar"><i class="fas fa-user"></i></div>
                        <div>
                            <div class="fw-bold">{{ $selectedStudentObj->user->name ?? '-' }}</div>
                            <div class="text-muted small">Kelas {{ $selectedStudentObj->class ?? '-' }} | NIS: {{ $selectedNis }}</div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="stat-box">
                                Rata-rata
                                <strong>{{ $grades->count() ? number_format($grades->avg('grade'), 2) : '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-box">
                                Total Nilai
                                <strong>{{ $grades->count() }}</strong>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('teacher.grades.edit') . '?student_id=' . $selectedStudent }}" class="btn btn-outline-success w-100 mt-3">
                        Tambah Nilai untuk Siswa Ini
                    </a>
                @elseif(!empty($selectedClassValue))
                    <h6 class="mb-2">Ringkasan Kelas {{ $selectedClassValue }}</h6>
                    <p class="text-muted mb-2">Siswa terdaftar pada kelas ini:</p>
                    <div class="stat-box text-start">
                        <span class="text-muted">Jumlah Siswa</span>
                        <strong>{{ $studentsInSelectedClass->count() }}</strong>
                    </div>
                    <p class="text-muted small mt-3 mb-0">Pilih siswa pada daftar untuk melihat dan mengelola nilai.</p>
                @else
                    <h6 class="mb-2">Data Dummy Kelas 1-6</h6>
                    <p class="text-muted mb-0">Pilih kelas pada daftar untuk melihat daftar siswa dari data dummy, lalu pilih siswa untuk mulai mengelola nilai.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@if($hasSelectedStudent)
    <div class="card table-card mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-star me-1"></i>Daftar Nilai Siswa
            </h5>
            <small class="text-muted">Total: {{ $grades->count() }} | Rata-rata: {{ $grades->count() ? number_format($grades->avg('grade'), 2) : '-' }}</small>
        </div>
        <div class="card-body">
            @if($grades->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Nilai</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $grade)
                                <tr>
                                    <td class="fw-semibold">{{ $grade->subject }}</td>
                                    <td>
                                        <span class="badge bg-{{ $grade->grade >= 85 ? 'success' : ($grade->grade >= 75 ? 'info' : ($grade->grade >= 65 ? 'warning' : 'danger')) }}">
                                            {{ number_format($grade->grade, 2) }}
                                        </span>
                                    </td>
                                    <td>{{ $grade->notes ?? '-' }}</td>
                                    <td>{{ $grade->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('teacher.grades.edit', $grade->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('teacher.grades.delete', $grade->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus nilai ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">Belum ada nilai untuk siswa ini. Silakan klik tombol Tambah Nilai.</div>
            @endif
        </div>
    </div>
@elseif(!empty($selectedClassValue))
    <div class="card table-card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-users me-1"></i>Daftar Siswa Kelas {{ $selectedClassValue }}</h5>
        </div>
        <div class="card-body">
            @if($studentsInSelectedClass->count() > 0)
                <div class="table-responsive">
                    <table class="table custom-grades-table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="col-name">Nama Siswa</th>
                                <th class="col-nis">NIS</th>
                                <th class="col-class">Kelas</th>
                                <th class="col-actions">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($studentsInSelectedClass as $student)
                                @php $studentNis = $student->nis ?? $student->nisn ?? '-'; @endphp
                                <tr>
                                    <td class="fw-semibold">{{ $student->user->name ?? '-' }}</td>
                                    <td>{{ $studentNis }}</td>
                                    <td>Kelas {{ $student->class }}</td>
                                    <td class="col-actions">
                                        <div class="action-buttons">
                                            <a href="{{ route('teacher.grades', ['class' => $student->class, 'student_id' => $student->id]) }}" class="btn btn-sm btn-primary" title="Lihat Nilai">
                                                <i class="fas fa-eye me-1"></i> Lihat
                                            </a>
                                            <a href="{{ route('teacher.grades.edit') . '?student_id=' . $student->id }}" class="btn btn-sm btn-outline-success" title="Tambah Nilai">
                                                <i class="fas fa-plus me-1"></i> Tambah
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning mb-0">Belum ada siswa di kelas ini.</div>
            @endif
        </div>
    </div>
@else
    <div class="card table-card">
        <div class="card-body">
            <div class="alert alert-info mb-0">
                Silakan pilih kelas 1A-6A untuk melihat daftar siswa dari data dummy, lalu pilih siswa untuk mulai mengelola nilai.
            </div>
        </div>
    </div>
@endif

<!-- Filter removed: no client-side JS required -->

<!-- MODAL: Tambah Nilai dengan AJAX -->
<div class="modal fade" id="addGradeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white" style="background: linear-gradient(135deg, #2D4438 0%, #163022 100%) !important;">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Tambah Nilai Cepat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addGradeForm">
                <div class="modal-body">
                    <input type="hidden" id="studentIdField" name="student_id" value="{{ $selectedStudent ?? '' }}">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Siswa</label>
                        <div class="form-text text-dark">{{ $selectedStudentObj->user->name ?? '-' }}</div>
                        <div class="form-text text-muted small">{{ $selectedStudentObj->nisn ?? '-' }} | Kelas {{ $selectedStudentObj->class ?? '-' }}</div>
                    </div>

                    <div class="mb-3">
                        <label for="subjectField" class="form-label fw-bold">Mata Pelajaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="subjectField" name="subject" placeholder="Contoh: Matematika" required>
                    </div>

                    <div class="mb-3">
                        <label for="gradeField" class="form-label fw-bold">Nilai (0-100) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="gradeField" name="grade" min="0" max="100" step="0.01" placeholder="85" required>
                    </div>

                    <div class="mb-3">
                        <label for="notesField" class="form-label fw-bold">Keterangan</label>
                        <textarea class="form-control" id="notesField" name="notes" rows="2" placeholder="Opsional"></textarea>
                    </div>

                    <div id="formMessage" class="alert d-none" role="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" style="background: linear-gradient(135deg, #2D4438 0%, #163022 100%) !important;">
                        <i class="fas fa-save me-2"></i>Simpan Nilai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: Import Nilai dari File -->
<div class="modal fade" id="importGradesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white" style="background: linear-gradient(135deg, #2D4438 0%, #163022 100%) !important;">
                <h5 class="modal-title"><i class="fas fa-file-import me-2"></i>Import Nilai (CSV/Excel)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="importGradesForm">
                <div class="modal-body">
                    <div class="alert alert-info mb-3">
                        <strong>Format File CSV:</strong><br>
                        <small>NISN | Mata Pelajaran | Nilai | Keterangan</small><br>
                        <small class="text-muted">Contoh: 1234567890 | Matematika | 85.5 | Bagus</small>
                    </div>

                    <div class="mb-3">
                        <label for="fileInput" class="form-label fw-bold">Pilih File <span class="text-danger">*</span></label>
                        <input 
                            type="file" 
                            class="form-control" 
                            id="fileInput" 
                            name="file" 
                            accept=".csv,.xlsx,.txt"
                            required
                        >
                        <small class="form-text text-muted">Max 2MB. Format: CSV, TXT, XLSX</small>
                    </div>

                    <div id="importMessage" class="alert d-none" role="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" id="importSubmitBtn" style="background: linear-gradient(135deg, #2D4438 0%, #163022 100%) !important;">
                        <i class="fas fa-upload me-2"></i>Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JAVASCRIPT: AJAX Form & File Upload -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==================== AJAX FORM TAMBAH NILAI ====================
    const addGradeForm = document.getElementById('addGradeForm');
    const formMessage = document.getElementById('formMessage');

    if (addGradeForm) {
        addGradeForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';

            try {
                const response = await fetch('{{ route("teacher.grades.ajax.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    formMessage.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + data.message;
                    formMessage.className = 'alert alert-success';
                    formMessage.classList.remove('d-none');

                    addGradeForm.reset();
                    setTimeout(() => location.reload(), 1200);
                } else {
                    formMessage.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + data.message;
                    formMessage.className = 'alert alert-danger';
                    formMessage.classList.remove('d-none');
                }
            } catch (error) {
                formMessage.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan: ' + error.message;
                formMessage.className = 'alert alert-danger';
                formMessage.classList.remove('d-none');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Nilai';
            }
        });
    }

    // ==================== FILE IMPORT ====================
    const importGradesForm = document.getElementById('importGradesForm');
    const importMessage = document.getElementById('importMessage');
    const importSubmitBtn = document.getElementById('importSubmitBtn');

    if (importGradesForm) {
        importGradesForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const fileInput = document.getElementById('fileInput');
            if (!fileInput.files.length) {
                importMessage.innerHTML = 'Pilih file terlebih dahulu';
                importMessage.className = 'alert alert-warning';
                importMessage.classList.remove('d-none');
                return;
            }

            const formData = new FormData();
            formData.append('file', fileInput.files[0]);

            importSubmitBtn.disabled = true;
            importSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Uploading...';

            try {
                const response = await fetch('{{ route("teacher.grades.import") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    importMessage.innerHTML = `
                        <strong>✅ ${data.message}</strong><br>
                        <small>Berhasil: ${data.imported} | Gagal: ${data.failed}</small>
                    `;
                    importMessage.className = 'alert alert-success';
                    importMessage.classList.remove('d-none');

                    setTimeout(() => location.reload(), 2000);
                } else {
                    importMessage.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + data.message;
                    importMessage.className = 'alert alert-danger';
                    importMessage.classList.remove('d-none');
                }
            } catch (error) {
                importMessage.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Error: ' + error.message;
                importMessage.className = 'alert alert-danger';
                importMessage.classList.remove('d-none');
            } finally {
                importSubmitBtn.disabled = false;
                importSubmitBtn.innerHTML = '<i class="fas fa-upload me-2"></i>Upload & Import';
            }
        });
    }
});
</script>

@endsection
