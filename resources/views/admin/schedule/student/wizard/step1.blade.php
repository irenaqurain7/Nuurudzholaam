@extends('layouts.admin')

@section('title', 'Wizard Jadwal Siswa - Langkah 1')
@section('page-title', 'Wizard Upload Jadwal - Langkah 1 dari 3')

@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Wizard Jadwal Siswa</h1>
            <p class="subtitle">Langkah 1 dari 3: Pilih Pengaturan Dasar</p>
        </div>
    </div>

    <!-- Stepper -->
    <div class="wizard-stepper">
        <div class="step active">
            <div class="step-icon">1</div>
            <div class="step-text">Pengaturan Dasar</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-icon">2</div>
            <div class="step-text">Unggah & Preview</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-icon">3</div>
            <div class="step-text">Review & Publikasi</div>
        </div>
    </div>

    <div class="form-container" style="max-width: 800px; margin: 0 auto;">
        <h2 class="section-title">Pilih Jenjang Pendidikan</h2>
        <form method="POST" action="{{ route('admin.schedule.student.wizard.step1.store') }}" class="schedule-form mt-4">
            @csrf

            <div class="form-group">
                <label class="form-label">Jenjang <span class="required">*</span></label>
                <div class="education-levels">
                    @foreach($educationLevels as $lvl)
                        <label class="level-card {{ old('education_level') === $lvl ? 'selected' : '' }}">
                            <input type="radio" name="education_level" value="{{ $lvl }}" @if(old('education_level')===$lvl) checked @endif onchange="updateSelectedLevel(this)">
                            <div class="level-icon"><i class="fas fa-school"></i></div>
                            <div class="level-name">{{ $lvl }}</div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-row-3">
                <div class="form-group">
                    <label class="form-label">Semester <span class="required">*</span></label>
                    <select name="semester" class="form-control">
                        @foreach($semesters as $s)
                            <option value="{{ $s }}">Semester {{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun Akademik <span class="required">*</span></label>
                    @php
                        $oldYear = old('academic_year');
                        $isOther = $oldYear && !in_array($oldYear, $years);
                    @endphp
                    <select name="{{ $isOther ? 'academic_year_select' : 'academic_year' }}" id="academic_year_select" class="form-control" onchange="checkAcademicYear(this)">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ ($oldYear === $y || (!$oldYear && $loop->first)) ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                        <option value="other" {{ $isOther ? 'selected' : '' }}>Lainnya...</option>
                    </select>
                    <input type="text" name="academic_year" id="academic_year_manual" class="form-control mt-2" placeholder="Contoh: 2024/2025" style="{{ $isOther ? 'display: block;' : 'display: none;' }}" {{ $isOther ? '' : 'disabled' }} value="{{ $isOther ? $oldYear : '' }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Metode Unggah <span class="required">*</span></label>
                    <select name="upload_method" class="form-control">
                        <option value="bulk">Bulk Upload (Excel/CSV)</option>
                        <option value="manual">Manual Input</option>
                    </select>
                </div>
            </div>

            <div class="form-actions mt-4">
                <a href="{{ route('admin.schedule.student.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn-submit">
                    Lanjutkan <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.admin-page { padding: 2rem; background: #F4F7F5; min-height: 100vh; }
.page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(45,68,56,0.04); }
.page-header h1 { margin: 0 0 0.5rem 0; color: #2D4438; font-size: 1.6rem; font-weight:700; }
.subtitle { color: #6C8B7C; margin: 0; font-size: 0.95rem; }

/* Stepper */
.wizard-stepper { display: flex; align-items: center; justify-content: center; margin-bottom: 3rem; max-width: 800px; margin-left: auto; margin-right: auto; }
.step { display: flex; flex-direction: column; align-items: center; gap: 10px; position: relative; z-index: 2; }
.step-icon { width: 40px; height: 40px; border-radius: 50%; background: white; border: 2px solid #E2ECE8; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #6C8B7C; font-size: 1.1rem; transition: all 0.3s ease; }
.step.active .step-icon { background: #2D4438; border-color: #2D4438; color: white; box-shadow: 0 0 0 4px rgba(45,68,56,0.1); }
.step-text { font-size: 0.85rem; font-weight: 600; color: #6C8B7C; }
.step.active .step-text { color: #2D4438; }
.step-line { flex: 1; height: 2px; background: #E2ECE8; margin: 0 15px; margin-bottom: 25px; }

.form-container { background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 10px rgba(45,68,56,0.04); }
.section-title { margin: 0 0 1.5rem 0; color: #2D4438; font-size: 1.25rem; font-weight: 700; border-bottom: 1px solid #E2ECE8; padding-bottom: 1rem; }
.schedule-form { display: flex; flex-direction: column; gap: 1.5rem; }
.form-group { display: flex; flex-direction: column; gap: 0.5rem; }
.form-label { font-weight: 600; color: #2D4438; font-size: 0.95rem; }
.required { color: #ef4444; }
.form-control { padding: 0.75rem 1rem; border: 1px solid #E2ECE8; border-radius: 8px; font-size: 0.95rem; font-family: inherit; color: #1C2D25; transition: all 0.2s; background: #fff; }
.form-control:focus { outline: none; border-color: #709D88; box-shadow: 0 0 0 3px rgba(112,157,136,0.15); }
.form-control:disabled { background: #F4F7F5; color: #6C8B7C; cursor: not-allowed; }

/* Level Cards */
.education-levels { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 1rem; }
.level-card { border: 2px solid #E2ECE8; border-radius: 12px; padding: 1.5rem 1rem; text-align: center; cursor: pointer; transition: all 0.2s; background: white; position: relative; overflow: hidden; }
.level-card input { display: none; }
.level-icon { font-size: 2rem; color: #709D88; margin-bottom: 0.5rem; transition: all 0.2s; }
.level-name { font-weight: 700; color: #2D4438; font-size: 1.1rem; }
.level-card:hover { border-color: #709D88; transform: translateY(-2px); }
.level-card.selected { border-color: #2D4438; background: rgba(45,68,56,0.03); }
.level-card.selected .level-icon { color: #2D4438; }

.form-row-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.mt-2 { margin-top: 0.5rem; }
.mt-4 { margin-top: 1.5rem; }

.form-actions { display: flex; gap: 1rem; justify-content: flex-end; border-top: 1px solid #E2ECE8; padding-top: 1.5rem; }
.btn-submit, .btn-cancel { padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; font-weight: 600; text-decoration: none; transition: all 0.2s; }
.btn-submit { background: #2D4438; color: white; }
.btn-submit:hover { background: #1C2D25; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(45,68,56,0.2); }
.btn-cancel { background: white; border: 1px solid #E2ECE8; color: #6C8B7C; }
.btn-cancel:hover { background: #F4F7F5; color: #2D4438; border-color: #6C8B7C; }

@media (max-width: 768px) {
    .form-row-3 { grid-template-columns: 1fr; }
    .education-levels { grid-template-columns: 1fr 1fr; }
    .wizard-stepper { display: none; }
}
</style>

<script>
function updateSelectedLevel(radio) {
    document.querySelectorAll('.level-card').forEach(card => card.classList.remove('selected'));
    if(radio.checked) {
        radio.closest('.level-card').classList.add('selected');
    }
}

function checkAcademicYear(select) {
    var manualInput = document.getElementById('academic_year_manual');
    if (select.value === 'other') {
        manualInput.style.display = 'block';
        manualInput.disabled = false;
        select.name = 'academic_year_select';
        manualInput.focus();
    } else {
        manualInput.style.display = 'none';
        manualInput.disabled = true;
        select.name = 'academic_year';
    }
}
</script>
@endsection
