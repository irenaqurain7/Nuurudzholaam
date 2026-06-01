@extends('teacher.layout')

@section('teacher-content')
@php
    $studentsGroupedByClass = collect($students ?? [])
        ->sortBy(function ($student) {
            return [
                (string) ($student->class ?? ''),
                strtolower($student->user->name ?? ''),
            ];
        })
        ->groupBy('class');

    $selectedStudentLabel = 'Pilih Siswa';
    $selectedStudentClass = '';
    $selectedStudentNisn = '';

    if (!empty($selectedStudentId)) {
        $selectedStudentModel = collect($students ?? [])->firstWhere('id', $selectedStudentId);
        if ($selectedStudentModel) {
            $selectedStudentLabel = $selectedStudentModel->user->name ?? 'Pilih Siswa';
            $selectedStudentClass = $selectedStudentModel->class ?? '';
            $selectedStudentNisn = $selectedStudentModel->nisn ?? '';
        }
    }

    if (!empty($grade->student_id)) {
        $selectedStudentModel = collect($students ?? [])->firstWhere('id', $grade->student_id);
        if ($selectedStudentModel) {
            $selectedStudentLabel = $selectedStudentModel->user->name ?? 'Pilih Siswa';
            $selectedStudentClass = $selectedStudentModel->class ?? '';
            $selectedStudentNisn = $selectedStudentModel->nisn ?? '';
        }
    }
@endphp

<style>
    .grade-page {
        max-width: 980px;
        margin: 1.5rem auto 2rem;
        padding: 0 0.5rem;
    }

    .grade-shell {
        position: relative;
        border: 1px solid rgba(16, 24, 40, 0.06);
        border-radius: 24px;
        overflow: hidden;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdfc 100%);
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
    }

    .grade-shell::before {
        content: '';
        position: absolute;
        inset: 0 0 auto 0;
        height: 8px;
        background: linear-gradient(90deg, var(--hijau-islam), #7da38e 60%, #d8b46b 100%);
    }

    .grade-shell .card-header {
        background: transparent;
        border-bottom: 1px solid #edf2ef;
        padding: 1.5rem 1.6rem 1.1rem;
    }

    .grade-shell .card-body {
        padding: 1.6rem;
    }

    .grade-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .35rem .7rem;
        border-radius: 999px;
        background: #edf5f0;
        color: var(--hijau-islam);
        font-size: .82rem;
        font-weight: 700;
        letter-spacing: .02em;
        margin-bottom: .85rem;
    }

    .grade-title {
        display: flex;
        align-items: center;
        gap: .75rem;
        margin: 0;
        font-size: 1.55rem;
        font-weight: 800;
        color: #102018;
    }

    .grade-subtitle {
        margin-top: .45rem;
        color: #607065;
        font-size: .95rem;
    }

    .section-card {
        border: 1px solid #e8efea;
        border-radius: 18px;
        background: #ffffff;
        padding: 1.15rem;
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.04);
        margin-bottom: 1rem;
    }

    .section-label {
        display: flex;
        align-items: center;
        gap: .55rem;
        margin-bottom: .75rem;
        color: #15251d;
        font-weight: 700;
        font-size: .96rem;
    }

    .section-label i,
    .form-label i {
        color: var(--hijau-islam);
    }

    .form-label {
        display: block;
        margin-bottom: .55rem;
        color: #0f172a;
        font-weight: 700;
    }

    .student-picker {
        position: relative;
    }

    .student-picker-toggle {
        width: 100%;
        min-height: 56px;
        border-radius: 14px;
        border: 1px solid #d9e4dd;
        background: #fff;
        padding: .75rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        text-align: left;
        transition: border-color .15s ease, box-shadow .15s ease, transform .15s ease;
    }

    .student-picker-toggle:focus {
        outline: none;
        border-color: rgba(45, 68, 56, 0.35);
        box-shadow: 0 0 0 .2rem rgba(45, 68, 56, 0.08);
    }

    .student-picker-value {
        display: flex;
        flex-direction: column;
        gap: .1rem;
        min-width: 0;
    }

    .student-picker-name {
        font-weight: 700;
        color: #102018;
        line-height: 1.2;
    }

    .student-picker-meta {
        color: #607065;
        font-size: .88rem;
        line-height: 1.2;
    }

    .student-picker-arrow {
        color: #50655b;
        transition: transform .15s ease;
        flex: 0 0 auto;
    }

    .student-picker.is-open .student-picker-arrow {
        transform: rotate(180deg);
    }

    .student-picker-panel {
        position: absolute;
        left: 0;
        right: 0;
        top: calc(100% + .5rem);
        z-index: 20;
        display: none;
        border-radius: 16px;
        border: 1px solid #d9e4dd;
        background: #fff;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.16);
        overflow: hidden;
    }

    .student-picker.is-open .student-picker-panel {
        display: block;
    }

    .student-picker-group {
        max-height: 280px;
        overflow: auto;
    }

    .student-picker-class {
        padding: .75rem 1rem .5rem;
        background: #f7faf8;
        color: var(--hijau-islam);
        font-size: .82rem;
        font-weight: 800;
        letter-spacing: .03em;
        text-transform: uppercase;
        border-top: 1px solid #edf2ef;
    }

    .student-picker-class:first-child {
        border-top: none;
    }

    .student-picker-option {
        width: 100%;
        border: 0;
        background: transparent;
        padding: .9rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        text-align: left;
        transition: background-color .12s ease;
    }

    .student-picker-option:hover,
    .student-picker-option:focus {
        background: rgba(45, 68, 56, 0.05);
        outline: none;
    }

    .student-picker-option.active {
        background: rgba(45, 68, 56, 0.08);
    }

    .student-picker-option-name {
        font-weight: 700;
        color: #102018;
    }

    .student-picker-option-meta {
        color: #607065;
        font-size: .84rem;
        white-space: nowrap;
    }

    .form-control,
    .form-select {
        border-radius: 14px;
        border: 1px solid #d9e4dd;
        box-shadow: none;
        min-height: 52px;
        padding: .75rem 1rem;
        font-size: .96rem;
        background: #fff;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: rgba(45, 68, 56, 0.35);
        box-shadow: 0 0 0 .2rem rgba(45, 68, 56, 0.08);
    }

    textarea.form-control {
        min-height: 130px;
        resize: vertical;
    }

    .input-group-text {
        background: #edf5f0;
        border: 1px solid #d9e4dd;
        border-left: none;
        border-radius: 0 14px 14px 0;
        font-weight: 700;
        color: #21312a;
    }

    .input-group .form-control {
        border-radius: 14px 0 0 14px;
    }

    .helper,
    .text-muted.small {
        color: #627267 !important;
    }

    .grade-quality {
        display: inline-flex;
        align-items: center;
        padding: .25rem .7rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: .88rem;
    }

    .grade-quality.a { background: #eafbe9; color: #056f2a; }
    .grade-quality.b { background: #fff7e6; color: #8a5b00; }
    .grade-quality.c { background: #fff3f2; color: #8b1e1e; }

    .btns {
        display: flex;
        gap: .85rem;
        align-items: center;
        flex-wrap: wrap;
        margin-top: .25rem;
    }

    .btn-primary.front,
    .btn-outline-primary.front {
        min-height: 48px;
        border-radius: 999px;
        font-weight: 700;
        padding: .78rem 1.3rem;
    }

    .btn-primary.front {
        background: var(--hijau-islam);
        color: #fff;
        border: none;
        box-shadow: 0 12px 22px rgba(45, 68, 56, 0.16);
    }

    .btn-primary.front:hover {
        background: #163022;
        transform: translateY(-1px);
        box-shadow: 0 16px 28px rgba(45, 68, 56, 0.18);
    }

    .btn-outline-primary.front {
        border: 2px solid var(--hijau-islam);
        color: var(--hijau-islam);
        background: transparent;
    }

    .btn-outline-primary.front:hover {
        background: rgba(45, 68, 56, 0.06);
        color: var(--hijau-islam);
    }

    .grade-tips {
        border: 1px solid #e8efea;
        border-radius: 18px;
        background: linear-gradient(180deg, #ffffff 0%, #f9fbfa 100%);
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.04);
    }

    .grade-tips .alert-heading {
        color: #102018;
        font-size: 1rem;
    }

    .grade-tips ul {
        color: #42544a;
    }

    @media (max-width: 767px) {
        .grade-page {
            padding: 0 .75rem;
            margin-top: 1rem;
        }

        .grade-shell .card-header,
        .grade-shell .card-body {
            padding: 1.1rem;
        }

        .grade-title {
            font-size: 1.25rem;
        }
    }

    @media (max-width: 576px) {
        .btns {
            flex-direction: column-reverse;
        }

        .btns .btn {
            width: 100%;
        }
    }
</style>
<div class="grade-page">
    <div class="card grade-shell">
        <div class="card-header">
            <h1 class="grade-title">
                <i class="fas fa-clipboard-list"></i>
                {{ $grade ? 'Perbarui Data Nilai' : 'Buat Nilai Siswa Baru' }}
            </h1>
            <p class="grade-subtitle mb-0">
                Pilih siswa, isi mata pelajaran, lalu masukkan nilai dan keterangan jika diperlukan.
            </p>
        </div>
        <div class="card-body">
            <form action="{{ $grade ? route('teacher.grades.update', $grade->id) : route('teacher.grades.store') }}" method="POST" id="gradeForm">
                @csrf
                @if($grade)
                    @method('PUT')
                @endif

                <div class="section-card">
                    <div class="section-label">
                        <i class="fas fa-user"></i>
                        <span>Data Siswa</span>
                    </div>
                    <label for="student_id" class="form-label">
                        Siswa <span class="text-danger">*</span>
                    </label>
                    <div class="student-picker @error('student_id') is-invalid @enderror" id="studentPicker">
                        <input type="hidden" id="student_id" name="student_id" value="{{ $grade->student_id ?? $selectedStudentId ?? '' }}" required>
                        <button type="button" class="student-picker-toggle" id="studentPickerToggle" aria-haspopup="listbox" aria-expanded="false">
                            <span class="student-picker-value">
                                <span class="student-picker-name" id="studentPickerName">{{ $selectedStudentLabel }}</span>
                                <span class="student-picker-meta" id="studentPickerMeta">
                                    @if($selectedStudentClass !== '')
                                        Kelas {{ $selectedStudentClass }} @if($selectedStudentNisn !== '') | NISN: {{ $selectedStudentNisn }} @endif
                                    @else
                                        -- Pilih Siswa --
                                    @endif
                                </span>
                            </span>
                            <i class="fas fa-chevron-down student-picker-arrow"></i>
                        </button>
                        <div class="student-picker-panel" id="studentPickerPanel" role="listbox">
                            <div class="student-picker-group">
                                @foreach($studentsGroupedByClass as $className => $classStudents)
                                    <div class="student-picker-class">Kelas {{ $className }}</div>
                                    @foreach($classStudents as $student)
                                        @php
                                            $isSelectedStudent = (($grade->student_id ?? null) == $student->id) || (isset($selectedStudentId) && $selectedStudentId == $student->id);
                                        @endphp
                                        <button
                                            type="button"
                                            class="student-picker-option {{ $isSelectedStudent ? 'active' : '' }}"
                                            data-student-id="{{ $student->id }}"
                                            data-student-name="{{ $student->user->name }}"
                                            data-student-class="{{ $student->class }}"
                                            data-student-nisn="{{ $student->nisn }}"
                                        >
                                            <span class="student-picker-option-name">{{ $student->user->name }}</span>
                                            <span class="student-picker-option-meta">NISN: {{ $student->nisn }}</span>
                                        </button>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @error('student_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="section-card">
                    <div class="section-label">
                        <i class="fas fa-book"></i>
                        <span>Informasi Nilai</span>
                    </div>
                    <div class="mb-4">
                        <label for="subject" class="form-label">
                            Mata Pelajaran <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-lg @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Contoh: Matematika, Bahasa Indonesia, IPA" value="{{ $grade->subject ?? '' }}" required>
                        <small class="text-muted helper">Masukkan nama mata pelajaran</small>
                        @error('subject')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="grade" class="form-label">
                            Nilai (0-100) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-lg">
                            <input type="number" class="form-control @error('grade') is-invalid @enderror" id="grade" name="grade" min="0" max="100" step="0.01" value="{{ $grade->grade ?? '' }}" placeholder="Masukkan nilai 0-100" required>
                            <span class="input-group-text">/ 100</span>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted" id="gradeQuality">Status: -</small>
                        </div>
                        @error('grade')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="section-card mb-4">
                    <div class="section-label">
                        <i class="fas fa-sticky-note"></i>
                        <span>Keterangan</span>
                    </div>
                    <label for="notes" class="form-label">
                        Keterangan <span class="text-muted fw-normal">(Opsional)</span>
                    </label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4" placeholder="Catatan tambahan tentang nilai siswa..." maxlength="500">{{ $grade->notes ?? '' }}</textarea>
                    <small class="text-muted helper">Maksimal 500 karakter</small>
                    @error('notes')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="btns">
                    <button type="submit" class="btn btn-primary front">
                        <i class="fas fa-save me-1"></i> {{ $grade ? 'Update Nilai' : 'Simpan Nilai' }}
                    </button>
                    <a href="{{ route('teacher.grades') }}" class="btn btn-outline-primary front">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="alert alert-info mt-4 grade-tips" role="alert">
        <h5 class="alert-heading"><i class="fas fa-lightbulb"></i> Tips Penilaian</h5>
        <ul class="mb-0 ms-2">
            <li>Nilai A (85-100): Sangat Baik</li>
            <li>Nilai B (75-84): Baik</li>
            <li>Nilai C (65-74): Cukup</li>
            <li>Nilai D (55-64): Kurang</li>
            <li>Nilai E (0-54): Sangat Kurang</li>
        </ul>
    </div>
</div>

<script>
    // Real-time grade quality feedback
    const gradeInput = document.getElementById('grade');
    const gradeQuality = document.getElementById('gradeQuality');
    const studentPicker = document.getElementById('studentPicker');
    const studentPickerToggle = document.getElementById('studentPickerToggle');
    const studentPickerPanel = document.getElementById('studentPickerPanel');
    const studentPickerName = document.getElementById('studentPickerName');
    const studentPickerMeta = document.getElementById('studentPickerMeta');
    const studentPickerInput = document.getElementById('student_id');

    gradeInput.addEventListener('input', function() {
        const value = parseFloat(this.value);
            if (value >= 85) {
                gradeQuality.innerHTML = '<span class="badge bg-success">Sangat Baik (A)</span>';
            } else if (value >= 75) {
                gradeQuality.innerHTML = '<span class="badge bg-info">Baik (B)</span>';
            } else if (value >= 65) {
                gradeQuality.innerHTML = '<span class="badge bg-warning">Cukup (C)</span>';
            } else if (value >= 55) {
                gradeQuality.innerHTML = '<span class="badge bg-warning">Kurang (D)</span>';
            } else if (value >= 0) {
                gradeQuality.innerHTML = '<span class="badge bg-danger">Sangat Kurang (E)</span>';
            } else {
                gradeQuality.innerHTML = 'Status: -';
            }
    });

    // Trigger initial feedback
    if (gradeInput.value) {
        gradeInput.dispatchEvent(new Event('input'));
    }

    if (studentPicker && studentPickerToggle && studentPickerPanel) {
        const closePicker = () => {
            studentPicker.classList.remove('is-open');
            studentPickerToggle.setAttribute('aria-expanded', 'false');
        };

        studentPickerToggle.addEventListener('click', function() {
            const isOpen = studentPicker.classList.toggle('is-open');
            studentPickerToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        studentPickerPanel.querySelectorAll('.student-picker-option').forEach(function(option) {
            option.addEventListener('click', function() {
                const studentId = this.dataset.studentId;
                const studentName = this.dataset.studentName;
                const studentClass = this.dataset.studentClass;
                const studentNisn = this.dataset.studentNisn;

                studentPickerInput.value = studentId;
                studentPickerName.textContent = studentName;
                studentPickerMeta.textContent = `Kelas ${studentClass} | NISN: ${studentNisn}`;

                studentPickerPanel.querySelectorAll('.student-picker-option').forEach(function(item) {
                    item.classList.remove('active');
                });
                this.classList.add('active');

                closePicker();
            });
        });

        document.addEventListener('click', function(event) {
            if (!studentPicker.contains(event.target)) {
                closePicker();
            }
        });
    }
</script>
@endsection
