@extends('layouts.admin')

@section('title', 'Wizard Jadwal Siswa - Langkah 3')
@section('page-title', 'Wizard Upload Jadwal - Langkah 3 dari 3')

@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Wizard Jadwal Siswa</h1>
            <p class="subtitle">Langkah 3 dari 3: Review & Publikasi</p>
        </div>
    </div>

    <!-- Stepper -->
    <div class="wizard-stepper">
        <div class="step completed">
            <div class="step-icon"><i class="fas fa-check"></i></div>
            <div class="step-text">Pengaturan Dasar</div>
        </div>
        <div class="step-line completed"></div>
        <div class="step completed">
            <div class="step-icon"><i class="fas fa-check"></i></div>
            <div class="step-text">Unggah & Preview</div>
        </div>
        <div class="step-line completed"></div>
        <div class="step active">
            <div class="step-icon">3</div>
            <div class="step-text">Review & Publikasi</div>
        </div>
    </div>

    <div class="wizard-grid">
        <!-- Main Content -->
        <div class="wizard-main">
            <!-- Summary Stats -->
            @php
                $total = count($validation);
                $valid = collect($validation)->where('status','valid')->count();
                $conflicts = $total - $valid;
            @endphp

            <div class="stats-grid mb-4">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(112,157,136,0.1); color: #709D88;"><i class="fas fa-list-ul"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Total Rekaman</div>
                        <div class="stat-value">{{ $total }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(16,185,129,0.1); color: #10b981;"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Data Valid</div>
                        <div class="stat-value" style="color: #10b981;">{{ $valid }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(239,68,68,0.1); color: #ef4444;"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Konflik Terdeteksi</div>
                        <div class="stat-value" style="color: #ef4444;">{{ $conflicts }}</div>
                    </div>
                </div>
            </div>

            <!-- Detail Card -->
            <div class="form-container mb-4">
                <h2 class="section-title">Detail Validasi Rekaman</h2>

                @if($conflicts > 0)
                    <div class="alert alert-warning mb-4" style="background: #FFFBEB; border: 1px solid #FEF3C7; border-radius: 8px; padding: 1rem; display: flex; gap: 1rem; align-items: flex-start; color: #B45309;">
                        <i class="fas fa-exclamation-circle" style="font-size: 1.5rem; margin-top: 0.1rem;"></i>
                        <div>
                            <h4 style="margin: 0 0 0.25rem 0; font-size: 1rem; font-weight: 700;">Perhatian! Terdapat {{ $conflicts }} konflik data</h4>
                            <p style="margin: 0; font-size: 0.9rem;">Anda tidak dapat mempublikasikan jadwal jika masih ada konflik. Silakan periksa detailnya di bawah dan unggah ulang berkas yang sudah diperbaiki.</p>
                        </div>
                    </div>
                @endif

                <div class="table-responsive mt-3 mb-4">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">Kelas</th>
                                <th width="20%">Mata Pelajaran</th>
                                <th width="15%">Waktu</th>
                                <th width="20%">Pengajar</th>
                                <th width="15%">Ruangan</th>
                                <th width="15%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($validation as $i => $row)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td><strong>{{ $row['class'] ?? '-' }}</strong></td>
                                    <td>{{ $row['subject'] ?? '-' }}</td>
                                    <td>{{ ($row['start_time'] ?? '-') . ' - ' . ($row['end_time'] ?? '-') }}</td>
                                    <td>{{ $row['teacher'] ?? '-' }}</td>
                                    <td>{{ $row['room'] ?? '-' }}</td>
                                    <td>
                                        @if($row['status'] === 'valid')
                                            <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Valid</span>
                                        @else
                                            <span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Konflik</span>
                                            <div class="conflict-reasons">
                                                @foreach($row['reasons'] ?? [] as $reason)
                                                    <div>• {{ $reason }}</div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <form method="POST" action="{{ route('admin.schedule.student.wizard.publish') }}">
                    @csrf
                    <div class="form-actions mt-4">
                        <a href="{{ route('admin.schedule.student.wizard.step2') }}" class="btn-cancel">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <div style="display: flex; gap: 1rem;">
                            <a href="{{ route('admin.schedule.student.wizard.step2') }}" class="btn-outline">
                                <i class="fas fa-pen"></i> Edit Data Konflik
                            </a>
                            <button type="submit" class="btn-submit {{ $conflicts > 0 ? 'disabled' : '' }}" @if($conflicts > 0) disabled @endif>
                                <i class="fas fa-paper-plane"></i> Publikasikan Jadwal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Tips -->
        <div class="wizard-sidebar">
            <div class="info-card">
                <div class="info-icon"><i class="fas fa-shield-alt"></i></div>
                <h3 class="info-title">Sistem Validasi</h3>
                <ul class="info-list">
                    <li>Sistem otomatis mengecek potensi bentrok sebelum jadwal dipublikasikan.</li>
                    <li><strong>Jadwal Pengajar Ganda:</strong> Guru yang sama tidak dapat mengajar di dua kelas berbeda pada waktu yang bersamaan.</li>
                    <li><strong>Bentrok Waktu Kelas:</strong> Satu kelas tidak bisa memiliki dua mata pelajaran pada jam yang sama.</li>
                    <li>Jika terjadi konflik, perbaiki data di Excel/CSV Anda, lalu unggah kembali.</li>
                </ul>
            </div>
        </div>
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
.step.completed .step-icon { background: #709D88; border-color: #709D88; color: white; }
.step-text { font-size: 0.85rem; font-weight: 600; color: #6C8B7C; }
.step.active .step-text, .step.completed .step-text { color: #2D4438; }
.step-line { flex: 1; height: 2px; background: #E2ECE8; margin: 0 15px; margin-bottom: 25px; }
.step-line.completed { background: #709D88; }

/* Grid Layout */
.wizard-grid { display: grid; grid-template-columns: 1fr 300px; gap: 2rem; max-width: 1200px; margin: 0 auto; }
@media (max-width: 992px) { .wizard-grid { grid-template-columns: 1fr; } }

/* Stats Cards */
.stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.stat-card { background: white; padding: 1.5rem; border-radius: 12px; display: flex; align-items: center; gap: 1.25rem; box-shadow: 0 2px 10px rgba(45,68,56,0.04); }
.stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
.stat-info { flex: 1; }
.stat-label { font-size: 0.9rem; color: #6C8B7C; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.5px; }
.stat-value { font-size: 1.75rem; font-weight: 800; color: #2D4438; line-height: 1; }

@media (max-width: 768px) {
    .stats-grid { grid-template-columns: 1fr; }
}

/* Cards & Forms */
.form-container { background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 10px rgba(45,68,56,0.04); }
.section-title { margin: 0 0 1.5rem 0; color: #2D4438; font-size: 1.25rem; font-weight: 700; border-bottom: 1px solid #E2ECE8; padding-bottom: 1rem; }
.mb-4 { margin-bottom: 1.5rem; }
.mt-4 { margin-top: 1.5rem; }
.mt-3 { margin-top: 1rem; }
.mr-1 { margin-right: 0.25rem; }

/* Conflict List */
.conflict-reasons { margin-top: 0.5rem; font-size: 0.8rem; color: #ef4444; line-height: 1.4; padding: 0.5rem; background: #FEF2F2; border-radius: 4px; border: 1px solid #FCA5A5; }

/* Buttons */
.form-actions { display: flex; gap: 1rem; justify-content: space-between; border-top: 1px solid #E2ECE8; padding-top: 1.5rem; align-items: center; }
.btn-submit, .btn-cancel, .btn-outline { padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; font-weight: 600; text-decoration: none; transition: all 0.2s; }
.btn-submit { background: #10b981; color: white; }
.btn-submit:hover:not(:disabled) { background: #059669; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16,185,129,0.2); }
.btn-submit.disabled, .btn-submit:disabled { opacity: 0.5; cursor: not-allowed; background: #9ca3af; }
.btn-cancel { background: white; border: 1px solid #E2ECE8; color: #6C8B7C; }
.btn-cancel:hover { background: #F4F7F5; color: #2D4438; border-color: #6C8B7C; }
.btn-outline { background: white; border: 1px solid #709D88; color: #709D88; }
.btn-outline:hover { background: #709D88; color: white; }

/* Sidebar */
.info-card { background: linear-gradient(145deg, #2D4438, #1C2D25); border-radius: 12px; padding: 2rem 1.5rem; color: white; box-shadow: 0 4px 15px rgba(45,68,56,0.15); position: sticky; top: 100px; }
.info-icon { font-size: 2rem; color: #709D88; margin-bottom: 1rem; }
.info-title { margin: 0 0 1rem 0; font-size: 1.2rem; font-weight: 700; color: white; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.8rem; }
.info-list { padding-left: 1.2rem; margin: 0; display: flex; flex-direction: column; gap: 0.8rem; }
.info-list li { font-size: 0.9rem; color: rgba(255,255,255,0.85); line-height: 1.5; }
.info-list strong { color: #709D88; }

/* Table overrides to fit card */
.table-responsive { overflow-x: auto; border-radius: 8px; border: 1px solid #E2ECE8; }
.admin-table th { padding: 12px 16px; font-size: 12px; }
.admin-table td { padding: 12px 16px; font-size: 13px; }

@media (max-width: 768px) {
    .form-actions { flex-direction: column; gap: 1rem; }
    .form-actions > div { flex-direction: column; width: 100%; }
    .btn-cancel, .btn-outline, .btn-submit { width: 100%; justify-content: center; }
    .wizard-stepper { display: none; }
}
</style>
@endsection
