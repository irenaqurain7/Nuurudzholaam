@extends('teacher.layout')

@section('teacher-content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-{{ $grade ? 'edit' : 'plus' }}"></i>
                    {{ $grade ? 'Edit Nilai' : 'Tambah Nilai Baru' }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ $grade ? route('teacher.grades.update', $grade->id) : route('teacher.grades.store') }}" method="POST" id="gradeForm">
                    @csrf
                    @if($grade)
                        @method('PUT')
                    @endif

                    <!-- Student Selection -->
                    <div class="mb-4">
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
                    <div class="mb-4">
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
                    <div class="mb-4">
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
                    <div class="mb-4">
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
                    <div class="d-grid gap-2 gap-md-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> {{ $grade ? 'Update Nilai' : 'Simpan Nilai' }}
                        </button>
                        <a href="{{ route('teacher.grades') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
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
            gradeQuality.innerHTML = '<span class="badge bg-success">Baik (B)</span>';
        } else if (value >= 65) {
            gradeQuality.innerHTML = '<span class="badge bg-info">Cukup (C)</span>';
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
