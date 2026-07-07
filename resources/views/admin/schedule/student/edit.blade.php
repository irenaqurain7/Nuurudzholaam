@extends('layouts.admin')

@section('title', 'Edit Jadwal Siswa')
@section('page-title', 'Edit Jadwal Siswa')
@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Edit Jadwal Siswa</h1>
            <p class="subtitle">Ubah informasi jadwal pelajaran secara detail</p>
        </div>
        <a href="{{ route('admin.schedule.student.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <div class="error-list">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Form -->
    <div class="form-container">
        <form action="{{ route('admin.schedule.student.update', $schedule->id) }}" method="POST" class="schedule-form">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h2 class="section-title">Detail Mata Pelajaran</h2>

                <div class="form-row">
                    <!-- Education Level Selection -->
                    <div class="form-group">
                        <label for="education_level" class="form-label">
                            Jenjang Pendidikan <span class="required">*</span>
                        </label>
                        <select name="education_level" id="education_level" class="form-control" required>
                            <option value="">-- Pilih Jenjang --</option>
                            @foreach($educationLevels as $level)
                                <option value="{{ $level }}" {{ old('education_level', $schedule->education_level) == $level ? 'selected' : '' }}>
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                        @error('education_level')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Class Input -->
                    <div class="form-group">
                        <label for="class" class="form-label">
                            Kelas <span class="required">*</span>
                        </label>
                        <select name="class" id="class" class="form-control" data-old-value="{{ old('class', $schedule->class) }}" required>
                            <!-- Diisi secara dinamis oleh JavaScript -->
                        </select>
                        @error('class')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="subject" class="form-label">
                        Mata Pelajaran <span class="required">*</span>
                    </label>
                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Contoh: Matematika" value="{{ old('subject', $schedule->subject) }}" required>
                    @error('subject')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="teacher_id" class="form-label">
                        Guru Pengajar <span class="required">*</span>
                    </label>
                    <select name="teacher_id" id="teacher_id" class="form-control" required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id', $schedule->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user->name ?? 'Unknown' }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <h2 class="section-title" style="margin-top: 1rem;">Waktu Pelaksanaan</h2>

                <!-- Day Selection -->
                <div class="form-group">
                    <label for="day" class="form-label">
                        Hari <span class="required">*</span>
                    </label>
                    <select name="day" id="day" class="form-control" required>
                        <option value="">-- Pilih Hari --</option>
                        @foreach($days as $day)
                            @php
                                $daysIndonesia = [
                                    'Monday' => 'Senin',
                                    'Tuesday' => 'Selasa',
                                    'Wednesday' => 'Rabu',
                                    'Thursday' => 'Kamis',
                                    'Friday' => 'Jumat',
                                    'Saturday' => 'Sabtu'
                                ];
                            @endphp
                            <option value="{{ $day }}" {{ old('day', $schedule->day) == $day ? 'selected' : '' }}>
                                {{ $daysIndonesia[$day] ?? $day }}
                            </option>
                        @endforeach
                    </select>
                    @error('day')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="start_time" class="form-label">
                            Jam Mulai <span class="required">*</span>
                        </label>
                        <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', substr($schedule->start_time, 0, 5)) }}" required>
                        @error('start_time')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="end_time" class="form-label">
                            Jam Selesai <span class="required">*</span>
                        </label>
                        <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', substr($schedule->end_time, 0, 5)) }}" required>
                        @error('end_time')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.admin-page {
    padding: 2rem;
    background: #f8f9fa;
    min-height: 100vh;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.page-header h1 {
    margin: 0 0 0.5rem 0;
    color: #2D4438;
    font-size: 1.8rem;
    font-weight: 700;
}

.subtitle {
    color: #7f8c8d;
    margin: 0;
    font-size: 0.95rem;
}

.btn-back {
    background: #e2e8e5;
    color: #2D4438;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-back:hover {
    background: #cfdcd6;
}

.alert {
    padding: 1rem;
    margin-bottom: 1.5rem;
    border-radius: 8px;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.error-list {
    flex: 1;
}

.error-list p {
    margin: 0.25rem 0;
    font-size: 0.95rem;
}

.form-container {
    background: white;
    border-radius: 12px;
    padding: 2.5rem;
    width: 100%;
    border: 1px solid #E2ECE8;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.schedule-form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.form-section {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.section-title {
    margin: 0;
    color: #1C2D25;
    font-size: 1.15rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f1f5f3;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.95rem;
}

.required {
    color: #e74c3c;
}

.form-control {
    padding: 0.75rem 1rem;
    border: 1px solid #d1dbd6;
    border-radius: 8px;
    font-size: 0.95rem;
    font-family: inherit;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: #fbfdfb;
}

.form-control:focus {
    outline: none;
    border-color: #2D4438;
    box-shadow: 0 0 0 3px rgba(45, 68, 56, 0.1);
    background: white;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.error-message {
    color: #e74c3c;
    font-size: 0.85rem;
    font-weight: 500;
    margin-top: 0.25rem;
}

.form-actions {
    margin-top: 1rem;
}

.btn-submit {
    background: #2D4438;
    color: white;
    padding: 0.85rem 1.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    width: 100%;
    transition: all 0.2s;
}

.btn-submit:hover {
    background: #1a2921;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(45, 68, 56, 0.15);
}

@media (max-width: 768px) {
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const classOptions = {
        'TK': ['TK-A', 'TK-B'],
        'SD': ['1', '2', '3', '4', '5', '6'],
        'SMP': ['7', '8', '9'],
        'SMK': ['10-OTKP', '10-AKUNTANSI', '11-OTKP', '11-AKUNTANSI', '12-OTKP', '12-AKUNTANSI']
    };

    const educationLevelSelect = document.getElementById('education_level');
    const classSelect = document.getElementById('class');

    function populateClassOptions() {
        const selectedLevel = educationLevelSelect.value;
        const selectedValue = classSelect.getAttribute('data-old-value') || classSelect.value;
        
        classSelect.innerHTML = '';
        
        if (classOptions[selectedLevel]) {
            classOptions[selectedLevel].forEach(option => {
                const optElement = document.createElement('option');
                optElement.value = option;
                optElement.textContent = option;
                if (option === selectedValue) {
                    optElement.selected = true;
                }
                classSelect.appendChild(optElement);
            });
        }
        classSelect.removeAttribute('data-old-value');
    }

    educationLevelSelect.addEventListener('change', populateClassOptions);
    
    // Initial load
    populateClassOptions();
});
</script>
@endsection
