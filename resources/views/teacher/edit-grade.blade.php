@extends('teacher.layout')

@section('teacher-content')
<style>
    /* Form polish for edit/add grade */
    .grade-card .card { border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(16,24,40,0.06); border: 1px solid rgba(16,24,40,0.04); }
    .grade-card .card-body { padding: 1.6rem; }
    .card-header h5 { font-size: 1.05rem; font-weight:700; color: #0f172a; }
    .form-label i { margin-right: .5rem; color: var(--hijau-islam); }
    .form-control, .form-select { border-radius: 10px; box-shadow: none; height: 48px; padding: .6rem .9rem; font-size: .95rem; }
    textarea.form-control { min-height:120px; padding:.75rem; }
    .input-group-text { background: #f4f7f5; border-radius: 0 10px 10px 0; font-weight:600; color:#0f172a; }
    /* Match front page button styles */
    .btn-primary.front { background-color: var(--emas); color: var(--hijau-islam); padding: .75rem 1.25rem; border-radius: 40px; font-weight:600; border: none; box-shadow: 0 6px 18px rgba(99,102,241,0.06); transition: transform .08s ease, box-shadow .12s ease; }
    .btn-primary.front:hover { transform: translateY(-1px); box-shadow: 0 12px 24px rgba(99,102,241,0.08); }
    .btn-outline-primary.front { padding: .65rem 1.25rem; border-radius: 40px; border: 2px solid var(--emas); color: var(--emas); background: transparent; }
    .btn-outline-primary.front:hover { background: rgba(245,242,230,0.9); }
    .grade-quality { display:inline-block; padding: .25rem .6rem; border-radius: 999px; font-weight:700; font-size:.9rem; }
    .grade-quality.a { background:#eafbe9; color: #056f2a; }
    .grade-quality.b { background:#fff7e6; color: #8a5b00; }
    .grade-quality.c { background:#fff3f2; color: #8b1e1e; }
    .form-row { gap: .9rem; }
    .helper { font-size:.85rem; color:#475569; }
    @media (max-width: 767px) { .col-md-8.offset-md-2 { padding: 0 1rem; } }
    /* Wrapper and alignment */
    .grade-wrapper { max-width: 900px; margin: 1.6rem auto; }
    .form-group { margin-bottom: 1.5rem; }
    /* Extra spacing for major feature blocks */
    .feature-block { margin-bottom: 1.6rem; padding-bottom: .4rem; border-bottom: 1px solid rgba(15,23,42,0.03); }
    .feature-block:last-child { border-bottom: none; margin-bottom: 0.6rem; }
    .field-row { display:flex; gap:1rem; align-items:flex-start; }
    .field-row .form-control, .field-row .form-select { flex:1; }
    .field-hint { margin-left: .6rem; color:#64748b; font-size:.88rem; }
    label.form-label { display:block; margin-bottom:.45rem; color:#0f172a; font-weight:600; }
    .helper { display:block; margin-top:.35rem; }
    .btns { display:flex; gap:.75rem; align-items:center; }
    @media (max-width: 576px) { .btns { flex-direction:column-reverse; } .btns .btn { width:100%; } }
</style>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="grade-wrapper">
        <div class="card">
            <div class="card-header" style="background: white;">
                <h5 class="mb-0">
                    <i class="fas fa-{{ $grade ? 'edit' : 'plus' }}"></i>
                    {{ $grade ? 'Edit Nilai' : 'Tambah Nilai Baru' }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ $grade ? route('teacher.grades.update', $grade->id) : route('teacher.grades.store') }}" method="POST" id="gradeForm" class="grade-card">
                    @csrf
                    @if($grade)
                        @method('PUT')
                    @endif

                    <!-- Student Selection -->
                    <div class="mb-4 feature-block form-group">
                        <label for="student_id" class="form-label">
                            <i class="fas fa-user"></i> Siswa <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-lg @error('student_id') is-invalid @enderror" id="student_id" name="student_id" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" @if((($grade->student_id ?? null) == $student->id) || (isset($selectedStudentId) && $selectedStudentId == $student->id)) selected @endif>
                                    {{ $student->user->name }} - {{ $student->class }} (NISN: {{ $student->nisn }})
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Subject Selection -->
                    <div class="mb-4 feature-block form-group">
                        <label for="subject" class="form-label">
                            <i class="fas fa-book"></i> Mata Pelajaran <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-lg @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Contoh: Matematika, Bahasa Indonesia, IPA" value="{{ $grade->subject ?? '' }}" required>
                        <small class="text-muted">Masukkan nama mata pelajaran</small>
                        @error('subject')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Grade Input -->
                    <div class="mb-4 feature-block form-group">
                        <label for="grade" class="form-label">
                            <i class="fas fa-star"></i> Nilai (0-100) <span class="text-danger">*</span>
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

                    <!-- Notes -->
                    <div class="mb-4 feature-block form-group">
                        <label for="notes" class="form-label">
                            <i class="fas fa-sticky-note"></i> Keterangan (Opsional)
                        </label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4" placeholder="Catatan tambahan tentang nilai siswa..." maxlength="500">{{ $grade->notes ?? '' }}</textarea>
                        <small class="text-muted">Maksimal 500 karakter</small>
                        @error('notes')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex gap-3 btns">
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
        </div>

        <!-- Info Box -->
        <div class="alert alert-info mt-4" role="alert">
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
</div>

<script>
    // Real-time grade quality feedback
    const gradeInput = document.getElementById('grade');
    const gradeQuality = document.getElementById('gradeQuality');

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
</script>
@endsection
