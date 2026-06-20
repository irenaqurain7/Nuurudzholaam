@extends('layouts.admin')

@section('title', 'Wizard Jadwal Siswa - Langkah 1')
@section('page-title', 'Wizard Upload Jadwal - Langkah 1 dari 3')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Pilih Jenjang Pendidikan</h5>
            <form method="POST" action="{{ route('admin.schedule.student.wizard.step1.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Jenjang</label>
                    <div class="d-flex gap-2">
                        @foreach($educationLevels as $lvl)
                            <label class="card p-2" style="cursor:pointer;">
                                <input type="radio" name="education_level" value="{{ $lvl }}" @if(old('education_level')===$lvl) checked @endif style="display:none;">
                                <div style="min-width:90px;color:#2D4438;font-weight:700">{{ $lvl }}</div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Semester</label>
                        <select name="semester" class="form-control">
                            @foreach($semesters as $s)
                                <option value="{{ $s }}">Semester {{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tahun Akademik</label>
                        <select name="academic_year" class="form-control">
                            @foreach($years as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Metode Unggah</label>
                        <select name="upload_method" class="form-control">
                            <option value="bulk">Bulk Upload (Excel/CSV)</option>
                            <option value="manual">Manual Input</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.schedule.student.index') }}" class="btn btn-secondary">Batal</a>
                    <button class="btn btn-success">Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
