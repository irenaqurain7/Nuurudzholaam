@extends('layouts.admin')

@section('title', 'Tambah Jadwal Siswa')
@section('page-title', 'Tambah Jadwal Siswa')
@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Tambah Jadwal Siswa Baru</h1>
            <p class="subtitle">Atur jadwal pelajaran untuk siswa (SD, SMP, SMA)</p>
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
        <form action="{{ route('admin.schedule.student.store') }}" method="POST" class="schedule-form">
            @csrf

            <div class="form-section">
                <h2 class="section-title">Informasi Jadwal Siswa</h2>

                <!-- Student Selection with Level Filter -->
                <div class="form-group">
                    <label for="student_level" class="form-label">
                        Pilih Level <span class="required">*</span>
                    </label>
                    <div class="level-buttons">
                        <button type="button" class="level-btn" data-level="SD" onclick="filterByLevel('SD')">
                            <i class="fas fa-book"></i> SD
                        </button>
                        <button type="button" class="level-btn" data-level="SMP" onclick="filterByLevel('SMP')">
                            <i class="fas fa-book"></i> SMP
                        </button>
                        <button type="button" class="level-btn" data-level="SMA" onclick="filterByLevel('SMA')">
                            <i class="fas fa-book"></i> SMA
                        </button>
                    </div>
                </div>

                <!-- Student Selection -->
                <div class="form-group">
                    <label for="student_id" class="form-label">
                        Pilih Siswa <span class="required">*</span>
                    </label>
                    <select name="student_id" id="student_id" class="form-control" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($students as $student)
                            @php
                                $classLevel = substr($student->class, 0, 1);
                                $level = 'SD';
                                if ($classLevel >= 4 && $classLevel <= 6) {
                                    $level = 'SMP';
                                } elseif ($classLevel >= 7) {
                                    $level = 'SMA';
                                }
                            @endphp
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}
                                    data-level="{{ $level }}" data-class="{{ $student->class }}">
                                {{ $student->user->name }} - Kelas {{ $student->class }} ({{ $level }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Subject -->
                <div class="form-group">
                    <label for="subject" class="form-label">
                        Mata Pelajaran <span class="required">*</span>
                    </label>
                    <input type="text" name="subject" id="subject" class="form-control" 
                           placeholder="Contoh: Matematika, Bahasa Indonesia, IPA" required
                           value="{{ old('subject') }}">
                    @error('subject')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

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
                            <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>
                                {{ $daysIndonesia[$day] ?? $day }}
                            </option>
                        @endforeach
                    </select>
                    @error('day')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Time Row -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="start_time" class="form-label">
                            Waktu Mulai <span class="required">*</span>
                        </label>
                        <input type="time" name="start_time" id="start_time" class="form-control" required
                               value="{{ old('start_time') }}">
                        @error('start_time')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="end_time" class="form-label">
                            Waktu Selesai <span class="required">*</span>
                        </label>
                        <input type="time" name="end_time" id="end_time" class="form-control" required
                               value="{{ old('end_time') }}">
                        @error('end_time')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Room -->
                <div class="form-group">
                    <label for="room" class="form-label">
                        Ruang Kelas <span class="optional">(Opsional)</span>
                    </label>
                    <input type="text" name="room" id="room" class="form-control" 
                           placeholder="Contoh: Ruang 1, Lab Komputer" value="{{ old('room') }}">
                    @error('room')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Simpan Jadwal
                </button>
                <a href="{{ route('admin.schedule.student.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
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
    color: #2c3e50;
    font-size: 1.8rem;
}

.subtitle {
    color: #7f8c8d;
    margin: 0;
    font-size: 0.95rem;
}

.btn-back {
    background: #95a5a6;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: background 0.3s;
}

.btn-back:hover {
    background: #7f8c8d;
}

.alert {
    padding: 1rem;
    margin-bottom: 1.5rem;
    border-radius: 6px;
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
}

.form-container {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    max-width: 600px;
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
    color: #2c3e50;
    font-size: 1.2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #ecf0f1;
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

.optional {
    color: #95a5a6;
    font-size: 0.85rem;
}

.level-buttons {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.level-btn {
    padding: 0.75rem 1rem;
    border: 2px solid #bdc3c7;
    border-radius: 6px;
    background: white;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.level-btn:hover {
    border-color: #3498db;
    color: #3498db;
}

.level-btn.active {
    background: #3498db;
    color: white;
    border-color: #3498db;
}

.form-control {
    padding: 0.75rem 1rem;
    border: 1px solid #bdc3c7;
    border-radius: 6px;
    font-size: 0.95rem;
    font-family: inherit;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.error-message {
    color: #e74c3c;
    font-size: 0.85rem;
    font-weight: 500;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.btn-submit,
.btn-cancel {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-submit {
    background: #27ae60;
    color: white;
    flex: 1;
}

.btn-submit:hover {
    background: #229954;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.btn-cancel {
    background: #e74c3c;
    color: white;
    flex: 1;
}

.btn-cancel:hover {
    background: #c0392b;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

@media (max-width: 768px) {
    .admin-page {
        padding: 1rem;
    }

    .page-header {
        flex-direction: column;
        gap: 1rem;
    }

    .btn-back {
        width: 100%;
        justify-content: center;
    }

    .form-container {
        max-width: 100%;
    }

    .level-buttons {
        grid-template-columns: 1fr;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-submit,
    .btn-cancel {
        flex: 1;
    }
}
</style>

<script>
function filterByLevel(level) {
    const buttons = document.querySelectorAll('.level-btn');
    const select = document.getElementById('student_id');
    const options = select.querySelectorAll('option');

    // Update button states
    buttons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.level === level) {
            btn.classList.add('active');
        }
    });

    // Filter and show relevant students
    options.forEach(opt => {
        if (opt.value === '') return; // Skip placeholder
        if (opt.dataset.level === level) {
            opt.style.display = '';
        } else {
            opt.style.display = 'none';
        }
    });

    // Reset selection
    select.value = '';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('student_id');
    const options = select.querySelectorAll('option');
    
    // Show all options initially
    options.forEach(opt => {
        if (opt.value !== '') {
            opt.style.display = '';
        }
    });
});
</script>
@endsection
