@php
    $sdHomeroomClass = null;
    $sdHomeroomStudents = collect();

    if (isset($homeroomClass) && $homeroomClass && getSchoolLevel($homeroomClass) === 'SD') {
        $sdHomeroomClass = $homeroomClass;
        $sdHomeroomStudents = $studentsByClass->get($homeroomClass, collect());
    } else {
        $firstSDKey = $sdSchedules->keys()->first();
        if ($firstSDKey) {
            $sdHomeroomClass = $firstSDKey;
            $sdHomeroomStudents = $sdSchedules->get($firstSDKey, collect());
        }
    }

    $studentsCount = $sdHomeroomStudents->count();
    $tahunAjaran = '2025/2026';
@endphp

{{-- PRINT STYLES --}}
<style>
    .print-area { display: none; }

    @media print {
        body * { visibility: hidden !important; }
        .print-area, .print-area * { visibility: visible !important; }
        .print-area {
            display: block !important;
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            padding: 32px;
            font-family: 'Poppins', Arial, sans-serif;
            font-size: 12pt;
            color: #000;
        }
        .print-school-name {
            font-size: 16pt;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2px;
        }
        .print-subtitle {
            font-size: 10.5pt;
            text-align: center;
            color: #555;
            margin-bottom: 8px;
        }
        .print-divider {
            border: none;
            border-top: 2px solid #2F5D50;
            margin: 10px 0 16px 0;
        }
        .print-class-title {
            font-size: 13pt;
            font-weight: 700;
            margin-bottom: 2px;
        }
        .print-meta {
            font-size: 10pt;
            color: #555;
            margin-bottom: 14px;
        }
        .print-table {
            width: 100%;
            border-collapse: collapse;
        }
        .print-table th {
            background-color: #2F5D50 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color: #fff;
            padding: 8px 12px;
            font-size: 10.5pt;
            text-align: left;
        }
        .print-table td {
            padding: 7px 12px;
            border-bottom: 1px solid #ddd;
            font-size: 10pt;
        }
        .print-table tr:nth-child(even) td {
            background-color: #f4f8f6 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .print-footer {
            margin-top: 28px;
            font-size: 9.5pt;
            color: #888;
            text-align: right;
        }
    }
</style>

@if($sdHomeroomClass)

{{-- Hidden Print Area --}}
<div class="print-area" id="sdPrintArea">
    <div class="print-school-name">Sekolah Nuurudzholaam</div>
    <div class="print-subtitle">Daftar Siswa &mdash; Kelas {{ $sdHomeroomClass }} &mdash; Jenjang SD</div>
    <hr class="print-divider">
    <div class="print-class-title">Kelas {{ $sdHomeroomClass }}</div>
    <div class="print-meta">
        Jumlah Siswa: <strong>{{ $studentsCount }}</strong> &nbsp;&bull;&nbsp; Tahun Ajaran: {{ $tahunAjaran }}
    </div>
    <table class="print-table">
        <thead>
            <tr>
                <th style="width:36px;">No</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Jenis Kelamin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sdHomeroomStudents as $i => $student)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $student->user->name }}</td>
                    <td>{{ $student->nisn ?: '-' }}</td>
                    <td>{{ guessGender($student->user->name) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="print-footer">
        Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }}
    </div>
</div>

{{-- ====== INFO CARD (referensi gambar 3) ====== --}}
<div class="card card-custom mb-4">
    <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-4">

            {{-- Left group --}}
            <div class="d-flex align-items-center flex-wrap gap-0">

                {{-- People icon --}}
                <div class="d-flex align-items-center justify-content-center me-4"
                     style="width:64px; height:64px; border-radius:16px; background:rgba(47,93,80,0.08); flex-shrink:0;">
                    <i class="fas fa-users" style="font-size:1.8rem; color:#2F5D50;"></i>
                </div>

                {{-- Kelas --}}
                <div class="pe-4 me-4" style="border-right:1px solid #E2E8F0;">
                    <div class="text-muted fw-semibold mb-1" style="font-size:0.78rem; text-transform:uppercase; letter-spacing:.6px;">
                        Kelas yang Anda Wali
                    </div>
                    <div class="fw-bold lh-sm" style="font-size:2rem; color:#2F5D50; font-family:'Poppins',sans-serif;">
                        {{ $sdHomeroomClass }}
                    </div>
                    <div class="text-muted" style="font-size:0.82rem;">SD Nuurudzholaam</div>
                </div>

                {{-- Jumlah Siswa --}}
                <div class="pe-4 me-4 d-flex align-items-start gap-2" style="border-right:1px solid #E2E8F0;">
                    <i class="fas fa-user-graduate mt-1" style="font-size:1.2rem; color:#2F5D50; opacity:.8;"></i>
                    <div>
                        <div class="text-muted" style="font-size:0.78rem;">Jumlah Siswa</div>
                        <div class="fw-bold" style="font-size:1.4rem; color:#1A202C; line-height:1.2;">{{ $studentsCount }}</div>
                        <div class="text-muted" style="font-size:0.78rem;">Siswa</div>
                    </div>
                </div>

                {{-- Jenjang --}}
                <div class="pe-4 me-4 d-flex align-items-start gap-2" style="border-right:1px solid #E2E8F0;">
                    <i class="fas fa-graduation-cap mt-1" style="font-size:1.2rem; color:#2F5D50; opacity:.8;"></i>
                    <div>
                        <div class="text-muted" style="font-size:0.78rem;">Jenjang</div>
                        <div class="fw-bold" style="font-size:1.4rem; color:#1A202C; line-height:1.2;">SD</div>
                    </div>
                </div>

                {{-- Tahun Ajaran --}}
                <div class="d-flex align-items-start gap-2">
                    <i class="fas fa-calendar-alt mt-1" style="font-size:1.2rem; color:#2F5D50; opacity:.8;"></i>
                    <div>
                        <div class="text-muted" style="font-size:0.78rem;">Tahun Ajaran</div>
                        <div class="fw-bold" style="font-size:1.4rem; color:#1A202C; line-height:1.2;">{{ $tahunAjaran }}</div>
                    </div>
                </div>

            </div>

            {{-- Right: Cetak button --}}
            <button class="btn btn-custom-primary flex-shrink-0" onclick="window.print()"
                    style="padding:12px 24px; font-size:0.95rem;">
                <i class="fas fa-download me-2"></i> Cetak Daftar Siswa
            </button>

        </div>
    </div>
</div>

{{-- ====== TABLE CARD ====== --}}
<div class="card card-custom">
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="padding-left:24px; width:48px;">No</th>
                    <th>Nama</th>
                    <th>NISN</th>
                    <th>Jenis Kelamin</th>
                    <th>Status</th>
                    <th style="width:120px; text-align:center; padding-right:24px;">Aksi</th>
                </tr>
            </thead>
            <tbody class="searchable-table-rows">
                @forelse($sdHomeroomStudents as $i => $student)
                    <tr class="student-row-item">
                        <td class="text-muted" style="padding-left:24px;">{{ $i + 1 }}</td>
                        <td class="fw-semibold search-target-name">{{ $student->user->name }}</td>
                        <td class="text-secondary font-monospace search-target-nisn" style="font-size:0.9rem;">
                            {{ $student->nisn ?: '-' }}
                        </td>
                        <td>{{ guessGender($student->user->name) }}</td>
                        <td>
                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2"
                                  style="font-size:0.8rem; font-weight:600;">Aktif</span>
                        </td>
                        <td class="text-center" style="padding-right:24px;">
                            @if($student->id)
                                <a href="{{ route('teacher.students.show', $student->id) }}"
                                   class="btn btn-sm btn-custom-outline px-3"
                                   style="padding:6px 12px; font-size:0.85rem;">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                            @else
                                <span class="text-muted" style="font-size:0.85rem; font-weight:500;">
                                    <i class="fas fa-eye me-1" style="opacity:.5;"></i> Detail
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-user-slash d-block mb-3" style="font-size:2.5rem; opacity:.3;"></i>
                            Tidak ada data siswa di kelas ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($studentsCount > 0)
        <div class="px-4 py-3 d-flex flex-wrap align-items-center justify-content-between gap-3 border-top border-light">
            <div class="text-muted" style="font-size:0.85rem;">
                Menampilkan {{ $studentsCount }} dari {{ $studentsCount }} siswa
            </div>
            <nav>
                <ul class="pagination-custom">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    @endif
</div>

@else
    <div class="card card-custom p-5 text-center">
        <div class="mb-3 text-muted" style="font-size:3rem; opacity:.4;">
            <i class="fas fa-folder-open"></i>
        </div>
        <h5 class="fw-bold text-dark" style="font-family:'Poppins',sans-serif;">Tidak Ada Data Peran</h5>
        <p class="text-secondary mb-0">Anda tidak terdaftar sebagai Wali Kelas SD.</p>
    </div>
@endif
