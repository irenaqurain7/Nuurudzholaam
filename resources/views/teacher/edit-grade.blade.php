@extends('teacher.layout')

@section('teacher-content')
<h1 class="h2 mb-4">{{ $grade ? 'Edit Nilai' : 'Tambah Nilai Baru' }}</h1>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ $grade ? route('teacher.grades.update', $grade->id) : route('teacher.grades.store') }}" method="POST">
                    @csrf
                    @if($grade)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="student_id" class="form-label">Siswa <span class="text-danger">*</span></label>
                        <select class="form-select @error('student_id') is-invalid @enderror" id="student_id" name="student_id" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" @if(($grade->student_id ?? null) == $student->id) selected @endif>
                                    {{ $student->user->name }} ({{ $student->class }})
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ $grade->subject ?? '' }}" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="grade" class="form-label">Nilai (0-100) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('grade') is-invalid @enderror" id="grade" name="grade" min="0" max="100" step="0.01" value="{{ $grade->grade ?? '' }}" required>
                        @error('grade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ $grade->notes ?? '' }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ $grade ? 'Update Nilai' : 'Simpan Nilai' }}
                        </button>
                        <a href="{{ route('teacher.grades') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
