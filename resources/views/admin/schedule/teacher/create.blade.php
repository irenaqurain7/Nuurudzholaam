@extends('layouts.admin')

@section('title', 'Tambah Jadwal Guru')
@section('page-title', 'Tambah Jadwal Guru')
@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Tambah Jadwal Guru Baru</h1>
            <p class="subtitle">Atur jadwal mengajar untuk guru</p>
        </div>
        <a href="{{ route('admin.schedule.teacher.index') }}" class="btn-back">
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
        <form action="{{ route('admin.schedule.teacher.store') }}" method="POST" class="schedule-form">
            @csrf

            <div class="form-section">
                <h2 class="section-title">Informasi Jadwal Guru</h2>

                <!-- Teacher Selection -->
                <div class="form-group">
                    <label for="teacher_id" class="form-label">
                        Pilih Guru <span class="required">*</span>
                    </label>
                    <select name="teacher_id" id="teacher_id" class="form-control" required onchange="updateTeacherInfo()">
                        <option value="">-- Pilih Guru --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}
                                    data-specialization="{{ $teacher->specialization }}">
                                {{ $teacher->user->name }} ({{ $teacher->specialization }})
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Subject -->
                <div class="form-group">
                    <label for="subject" class="form-label">
                        Mata Pelajaran <span class="required">*</span>
                    </label>
                    <input type="text" name="subject" id="subject" class="form-control" 
                           placeholder="Contoh: Matematika, Bahasa Indonesia" required
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
                <a href="{{ route('admin.schedule.teacher.index') }}" class="btn-cancel">
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
function updateTeacherInfo() {
    const select = document.getElementById('teacher_id');
    const selected = select.options[select.selectedIndex];
    // You can add additional logic here if needed
}
</script>
@endsection
