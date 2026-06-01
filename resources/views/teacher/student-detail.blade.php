@extends('teacher.layout')

@section('teacher-content')
<style>
    .student-detail-page {
        max-width: 1280px;
        margin: 0 auto;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        border-radius: 999px;
        padding: .55rem .95rem;
        font-weight: 700;
    }

    .student-card {
        border: 0;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
    }

    .student-card .card-header,
    .note-card .card-header {
        border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        padding: 1rem 1.25rem;
    }

    .student-photo {
        width: 118px;
        height: 118px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
    }

    .student-initial {
        width: 118px;
        height: 118px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #edf5f0, #dce8e1);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
        color: var(--hijau-islam);
    }

    .student-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: #102018;
        margin-bottom: .15rem;
    }

    .student-class-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .45rem .85rem;
        border-radius: 999px;
        background: #edf5f0;
        color: var(--hijau-islam);
        font-weight: 700;
        font-size: .85rem;
    }

    .info-list .list-group-item {
        padding: 1rem 1.15rem;
        border-color: rgba(15, 23, 42, 0.06);
    }

    .info-label {
        display: block;
        font-size: .82rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #6b7280;
        margin-bottom: .25rem;
    }

    .note-card,
    .grade-card {
        border: 0;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
    }

    .grade-card .table thead th {
        background: #f6faf8;
        color: var(--hijau-islam);
        border-bottom: 1px solid #e7efea;
        white-space: nowrap;
    }

    .grade-card .table tbody td {
        vertical-align: middle;
    }

    .grade-meta {
        color: #667085;
        font-size: .88rem;
    }

    .grade-empty {
        border: 1px dashed #d9e4dd;
        border-radius: 18px;
        padding: 1rem 1.1rem;
        background: #fbfdfc;
    }

    @media (max-width: 991px) {
        .student-photo,
        .student-initial {
            width: 96px;
            height: 96px;
        }
    }
</style>

<div class="row mb-4">
    <div class="col-md-12">
        <a href="{{ route('teacher.students') }}" class="btn btn-outline-secondary btn-sm back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Siswa
        </a>
    </div>
</div>

<div class="row g-4 student-detail-page">
    <!-- Student Info -->
    <div class="col-md-4">
        <div class="card student-card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informasi Siswa</h5>
            </div>
            <div class="card-body text-center py-4">
                @if($student->user->profile_photo)
                    <img src="{{ asset('storage/' . $student->user->profile_photo) }}" alt="{{ $student->user->name }}" class="student-photo mb-3">
                @else
                    <div class="student-initial mb-3">
                        <i class="fas fa-user fa-3x text-muted"></i>
                    </div>
                @endif
                <div class="student-name">{{ $student->user->name }}</div>
                <span class="student-class-pill"><i class="fas fa-graduation-cap"></i>{{ $student->class }}</span>
            </div>
            <div class="list-group list-group-flush info-list">
                <div class="list-group-item">
                    <small class="info-label">NISN</small>
                    <div class="fw-bold">{{ $student->nisn }}</div>
                </div>
                <div class="list-group-item">
                    <small class="info-label">Email</small>
                    <div>{{ $student->user->email }}</div>
                </div>
                <div class="list-group-item">
                    <small class="info-label">No. Telepon</small>
                    <div>{{ $student->user->phone ?? '-' }}</div>
                </div>
                <div class="list-group-item">
                    <small class="info-label">Alamat</small>
                    <div>{{ $student->user->address ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Grades -->
    <div class="col-md-8">
        <div class="card grade-card">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="mb-0">Detail Nilai</h5>
                        <div class="grade-meta">Menampilkan nilai siswa dalam mode lihat saja.</div>
                    </div>
                    <span class="badge bg-success-subtle text-success-emphasis">{{ $grades->count() }} data</span>
                </div>
            </div>
            <div class="card-body">
                @if($grades->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th>Nilai</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grades as $grade)
                                    <tr>
                                        <td><strong>{{ $grade->subject }}</strong></td>
                                        <td>
                                            <span class="badge bg-{{ $grade->grade >= 75 ? 'success' : ($grade->grade >= 70 ? 'warning' : 'danger') }}">
                                                {{ number_format($grade->grade, 2) }}
                                            </span>
                                        </td>
                                        <td>{{ $grade->notes ?? '-' }}</td>
                                        <td><small class="text-muted">{{ $grade->created_at->format('d M Y') }}</small></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <div class="grade-empty">
                                <small class="info-label mb-1">Rata-rata Nilai</small>
                                <div class="fw-bold" style="color: var(--hijau-islam); font-size: 1.05rem;">{{ number_format($grades->avg('grade'), 2) }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="grade-empty">
                                <small class="info-label mb-1">Total Mata Pelajaran</small>
                                <div class="fw-bold" style="color: var(--hijau-islam); font-size: 1.05rem;">{{ $grades->count() }}</div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-1"></i> Belum ada nilai yang tersedia untuk siswa ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
