@extends('layouts.admin')

@section('title', 'Wizard Jadwal Siswa - Langkah 2')
@section('page-title', 'Wizard Upload Jadwal - Langkah 2 dari 3')

@section('content')
<div class="admin-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Wizard Jadwal Siswa</h1>
            <p class="subtitle">Langkah 2 dari 3: Unggah & Preview Jadwal</p>
        </div>
    </div>

    <!-- Stepper -->
    <div class="wizard-stepper">
        <div class="step completed">
            <div class="step-icon"><i class="fas fa-check"></i></div>
            <div class="step-text">Pengaturan Dasar</div>
        </div>
        <div class="step-line completed"></div>
        <div class="step active">
            <div class="step-icon">2</div>
            <div class="step-text">Unggah & Preview</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-icon">3</div>
            <div class="step-text">Review & Publikasi</div>
        </div>
    </div>

    <div class="wizard-grid">
        <!-- Main Content -->
        <div class="wizard-main">
            <!-- Upload/Input Card -->
            <div class="form-container mb-4">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                    <h2 class="section-title mb-0 border-0 pb-0">Data Jadwal</h2>
                    <span class="badge badge-primary">{{ session('wizard_upload_method', 'bulk') == 'bulk' ? 'Bulk Upload (Excel/CSV)' : 'Manual Input' }}</span>
                </div>

                @if(session('wizard_upload_method') == 'bulk')
                    <div class="upload-area">
                        <a href="{{ asset('templates/Template_' . $educationLevel . '.csv') }}" class="btn-download-template">
                            <i class="fas fa-file-csv"></i> Download Template CSV ({{ $educationLevel }})
                        </a>
                        
                        <form method="POST" action="{{ route('admin.schedule.student.wizard.step2.store') }}" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Pilih berkas (.xlsx, .xls, .csv) <span class="required">*</span></label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="file" id="file-upload" class="file-input" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required onchange="updateFileName(this)">
                                    <label for="file-upload" class="file-input-label">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span id="file-name">Pilih berkas atau tarik ke sini</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <button type="submit" class="btn-submit w-100 justify-content-center">
                                    <i class="fas fa-magic"></i> Unggah & Parse Data
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <form method="POST" action="{{ route('admin.schedule.student.wizard.step2.store') }}" class="manual-input-form">
                        @csrf
                        <div class="form-row-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">Kelas <span class="required">*</span></label>
                                <select name="class" class="form-control" required>
                                    @if($educationLevel === 'TK')
                                        <option value="TK-A">TK-A</option>
                                        <option value="TK-B">TK-B</option>
                                    @elseif($educationLevel === 'SD')
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    @elseif($educationLevel === 'SMP')
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    @elseif($educationLevel === 'SMK')
                                        <option value="10-RPL">10-RPL</option>
                                        <option value="10-TKJ">10-TKJ</option>
                                        <option value="11-RPL">11-RPL</option>
                                        <option value="11-TKJ">11-TKJ</option>
                                        <option value="12-RPL">12-RPL</option>
                                        <option value="12-TKJ">12-TKJ</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Mata Pelajaran <span class="required">*</span></label>
                                <input name="subject" class="form-control" placeholder="Contoh: Matematika" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Guru <span class="required">*</span></label>
                                <select name="teacher_id" class="form-control" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->user->name ?? 'Unknown' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row-3 mb-4">
                            <div class="form-group">
                                <label class="form-label">Hari <span class="required">*</span></label>
                                <select name="day" class="form-control" required>
                                    <option value="">Pilih Hari</option>
                                    <option value="Monday">Senin</option>
                                    <option value="Tuesday">Selasa</option>
                                    <option value="Wednesday">Rabu</option>
                                    <option value="Thursday">Kamis</option>
                                    <option value="Friday">Jumat</option>
                                    <option value="Saturday">Sabtu</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jam Mulai <span class="required">*</span></label>
                                <input type="time" name="start_time" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jam Selesai <span class="required">*</span></label>
                                <input type="time" name="end_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-plus"></i> Tambah Jadwal ke Preview
                            </button>
                        </div>
                    </form>
                @endif
            </div>

            <!-- Preview Card -->
            <div class="form-container">
                <h2 class="section-title">Preview Jadwal (Sementara)</h2>
                
                @if(count($previewItems) > 0)
                    <div class="table-responsive mt-3 mb-4">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">Kelas</th>
                                    <th width="25%">Mata Pelajaran</th>
                                    <th width="15%">Hari</th>
                                    <th width="15%">Waktu</th>
                                    <th width="25%">Guru</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($previewItems as $i => $it)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td><strong>{{ $it['class'] ?? '-' }}</strong></td>
                                        <td>{{ $it['subject'] ?? '-' }}</td>
                                        <td>
                                            @php
                                                $dayStr = $it['day'] ?? '-';
                                                $daysId = ['Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
                                                $displayDay = $daysId[$dayStr] ?? $dayStr;
                                            @endphp
                                            {{ $displayDay }}
                                        </td>
                                        <td>{{ ($it['start_time'] ?? '-') . ' - ' . ($it['end_time'] ?? '-') }}</td>
                                        <td>{{ $it['teacher'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <p>Belum ada data jadwal. Silakan unggah berkas atau tambahkan secara manual terlebih dahulu.</p>
                    </div>
                @endif

                <div class="form-actions mt-4">
                    <a href="{{ route('admin.schedule.student.wizard.step1') }}" class="btn-cancel">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('admin.schedule.student.wizard.step3') }}" class="btn-submit {{ count($previewItems) == 0 ? 'disabled' : '' }}" @if(count($previewItems) == 0) onclick="event.preventDefault(); alert('Silakan tambahkan jadwal terlebih dahulu.');" @endif>
                        Lanjutkan ke Review <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar Tips -->
        <div class="wizard-sidebar">
            <div class="info-card">
                <div class="info-icon"><i class="fas fa-lightbulb"></i></div>
                <h3 class="info-title">Tips Pengisian</h3>
                <ul class="info-list">
                    <li>Gunakan format template yang telah disediakan sesuai jenjang pendidikan.</li>
                    <li>Pastikan penulisan Hari menggunakan Bahasa Inggris (Monday, Tuesday, dll) jika menggunakan file CSV.</li>
                    <li>Format jam menggunakan standar 24-jam (contoh: 08:00, 14:30).</li>
                    <li>Kolom kelas harus persis sama dengan data kelas yang ada di sistem.</li>
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

/* Cards & Forms */
.form-container { background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 10px rgba(45,68,56,0.04); }
.section-title { margin: 0 0 1.5rem 0; color: #2D4438; font-size: 1.25rem; font-weight: 700; border-bottom: 1px solid #E2ECE8; padding-bottom: 1rem; }
.mb-4 { margin-bottom: 1.5rem; }
.mb-3 { margin-bottom: 1rem; }
.mt-4 { margin-top: 1.5rem; }
.mt-3 { margin-top: 1rem; }
.pb-3 { padding-bottom: 1rem; }
.pb-0 { padding-bottom: 0 !important; }
.border-0 { border: 0 !important; }
.border-bottom { border-bottom: 1px solid #E2ECE8; }
.d-flex { display: flex; }
.justify-content-between { justify-content: space-between; }
.align-items-center { align-items: center; }
.text-center { text-align: center; }
.text-right { text-align: right; }
.w-100 { width: 100%; }

.form-group { display: flex; flex-direction: column; gap: 0.5rem; }
.form-label { font-weight: 600; color: #2D4438; font-size: 0.95rem; }
.required { color: #ef4444; }
.form-control { padding: 0.75rem 1rem; border: 1px solid #E2ECE8; border-radius: 8px; font-size: 0.95rem; font-family: inherit; color: #1C2D25; transition: all 0.2s; background: #fff; width: 100%; }
.form-control:focus { outline: none; border-color: #709D88; box-shadow: 0 0 0 3px rgba(112,157,136,0.15); }
.form-row-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }

/* File Upload */
.upload-area { background: #F9FAFB; border: 1px dashed #E2ECE8; border-radius: 12px; padding: 2rem; }
.btn-download-template { display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; background: rgba(112,157,136,0.1); color: #2D4438; font-weight: 600; text-decoration: none; border-radius: 8px; font-size: 0.9rem; transition: all 0.2s; border: 1px solid rgba(112,157,136,0.2); }
.btn-download-template:hover { background: #709D88; color: white; }
.file-input-wrapper { position: relative; width: 100%; }
.file-input { opacity: 0; width: 0.1px; height: 0.1px; position: absolute; }
.file-input-label { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; padding: 3rem 2rem; background: white; border: 2px dashed #cbd5e1; border-radius: 8px; cursor: pointer; transition: all 0.2s; color: #64748b; font-weight: 500; }
.file-input-label i { font-size: 2.5rem; color: #94a3b8; }
.file-input-label:hover { border-color: #709D88; background: rgba(112,157,136,0.02); color: #2D4438; }
.file-input-label:hover i { color: #709D88; }
.file-input:focus + .file-input-label { border-color: #2D4438; box-shadow: 0 0 0 3px rgba(45,68,56,0.1); }

/* Empty State */
.empty-state { text-align: center; padding: 3rem 2rem; color: #64748b; background: #F9FAFB; border-radius: 8px; border: 1px dashed #E2ECE8; }
.empty-state i { font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem; }
.empty-state p { margin: 0; max-width: 400px; margin: 0 auto; font-size: 0.95rem; }

/* Buttons */
.form-actions { display: flex; gap: 1rem; justify-content: space-between; border-top: 1px solid #E2ECE8; padding-top: 1.5rem; }
.btn-submit, .btn-cancel { padding: 0.75rem 1.5rem; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; font-weight: 600; text-decoration: none; transition: all 0.2s; }
.btn-submit { background: #2D4438; color: white; }
.btn-submit:hover { background: #1C2D25; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(45,68,56,0.2); }
.btn-submit.disabled { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; }
.btn-cancel { background: white; border: 1px solid #E2ECE8; color: #6C8B7C; }
.btn-cancel:hover { background: #F4F7F5; color: #2D4438; border-color: #6C8B7C; }

/* Sidebar */
.info-card { background: linear-gradient(145deg, #2D4438, #1C2D25); border-radius: 12px; padding: 2rem 1.5rem; color: white; box-shadow: 0 4px 15px rgba(45,68,56,0.15); position: sticky; top: 100px; }
.info-icon { font-size: 2rem; color: #709D88; margin-bottom: 1rem; }
.info-title { margin: 0 0 1rem 0; font-size: 1.2rem; font-weight: 700; color: white; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.8rem; }
.info-list { padding-left: 1.2rem; margin: 0; display: flex; flex-direction: column; gap: 0.8rem; }
.info-list li { font-size: 0.9rem; color: rgba(255,255,255,0.85); line-height: 1.5; }

/* Table overrides to fit card */
.table-responsive { overflow-x: auto; border-radius: 8px; border: 1px solid #E2ECE8; }
.admin-table th { padding: 12px 16px; font-size: 12px; }
.admin-table td { padding: 12px 16px; }

@media (max-width: 768px) {
    .form-row-3 { grid-template-columns: 1fr; }
    .wizard-stepper { display: none; }
}
</style>

<script>
function updateFileName(input) {
    const fileName = input.files[0] ? input.files[0].name : 'Pilih berkas atau tarik ke sini';
    document.getElementById('file-name').textContent = fileName;
}
</script>
@endsection
