@extends('teacher.layout')

@section('teacher-content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <h1 class="h2 mb-0">Data Siswa Saya</h1>
</div>

<!-- Search Box -->
<div class="mb-4" style="position: relative;">
    <div style="max-width: 380px;">
        <div class="input-group" style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <span class="input-group-text bg-white border-0" style="padding: 0.75rem 1rem;">
                <i class="fas fa-search" style="color: #2D4438; font-size: 16px;"></i>
            </span>
            <input 
                type="text" 
                class="form-control border-0 ps-0" 
                id="studentSearch"
                placeholder="Cari nama atau NISN..." 
                style="font-size: 14px; padding: 0.75rem 1rem 0.75rem 0.5rem;"
            >
        </div>
        <!-- Dropdown Hasil Pencarian -->
        <div id="searchResults" style="display: none; position: absolute; top: calc(100% + 8px); left: 0; width: 100%; max-height: 450px; overflow-y: auto; z-index: 1000; background: white; border-radius: 8px; box-shadow: 0 6px 16px rgba(0,0,0,0.1); border: 1px solid #e0e0e0;"></div>
    </div>
</div>

@if($students->count() > 0)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-users"></i> Total Siswa: <strong>{{ $students->count() }}</strong>
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 border-0 shadow-sm class-group-card">
        <div class="card-header bg-light border-0 class-group-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="mb-0">
                    <i class="fas fa-users me-1"></i>Daftar Siswa per Kelas
                </h5>
                <span class="badge bg-success-subtle text-success-emphasis">{{ $students->count() }} siswa</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive class-student-scroll">
                <table class="table table-hover align-middle mb-0 class-student-table">
                    <thead class="table-light">
                        <tr>
                            <th class="col-class-name">Kelas</th>
                            <th>Nama Siswa</th>
                            <th class="col-nisn">NISN</th>
                            <th class="text-end col-actions">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($studentsByClass as $className => $classStudents)
                            <tr class="class-divider-row">
                                <td colspan="4">
                                    <div class="class-divider">
                                        <span>Kelas {{ $className }}</span>
                                        <strong>{{ $classStudents->count() }} siswa</strong>
                                    </div>
                                </td>
                            </tr>
                            @foreach($classStudents as $student)
                                <tr>
                                    <td class="text-muted fw-semibold">{{ $student->class }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $student->user->name }}</div>
                                    </td>
                                    <td>{{ $student->nisn }}</td>
                                    <td class="text-end">
                                        <div class="d-inline-flex flex-wrap gap-2 justify-content-end">
                                            <a href="{{ route('teacher.students.show', $student->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye me-1"></i>Lihat Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
            transform: translateY(-2px);
        }

        .class-group-card {
            overflow: hidden;
        }

        .class-group-header {
            padding: 1rem 1.25rem;
        }

        .class-student-scroll {
            max-height: clamp(320px, 60vh, 620px);
            overflow: auto;
            border-top: 1px solid #e9ecef;
        }

        .class-student-table {
            width: 100%;
            min-width: 900px;
            table-layout: fixed;
        }

        .class-student-table th,
        .class-student-table td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
        }

        .class-student-table thead th {
            position: sticky;
            top: 0;
            z-index: 1;
            background: #f8f9fa;
            box-shadow: inset 0 -1px 0 #e9ecef;
        }

        .class-divider-row td {
            padding: 0;
            border: 0;
        }

        .class-divider {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: .8rem 1.25rem;
            background: linear-gradient(90deg, rgba(45, 68, 56, 0.08), rgba(45, 68, 56, 0.03));
            color: #21312a;
            font-weight: 700;
            border-top: 1px solid #e9ecef;
            border-bottom: 1px solid #e9ecef;
        }

        .class-divider strong {
            color: var(--hijau-islam);
        }

        .col-class-name {
            width: 120px;
        }

        .class-student-table td:nth-child(1),
        .class-student-table th:nth-child(1) {
            min-width: 120px;
        }

        .class-student-table td:nth-child(2),
        .class-student-table th:nth-child(2) {
            min-width: 260px;
        }

        .class-student-table td:nth-child(3),
        .class-student-table th:nth-child(3) {
            min-width: 130px;
        }

        .class-student-table td:nth-child(4),
        .class-student-table th:nth-child(4) {
            min-width: 240px;
        }

        .class-student-table td:nth-child(1) {
            word-break: break-word;
        }

        .class-student-table td:nth-child(4) .btn {
            white-space: nowrap;
        }
    </style>
@else
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        Belum ada data siswa yang tersedia.
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('studentSearch');
    const searchResults = document.getElementById('searchResults');
    let debounceTimer;

    if (!searchInput) return;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();
        
        if (query.length === 0) {
            searchResults.style.display = 'none';
            return;
        }

        debounceTimer = setTimeout(() => {
            performSearch(query);
        }, 300);
    });

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.mb-4')) {
            searchResults.style.display = 'none';
        }
    });

    function performSearch(query) {
        fetch(`{{ route('teacher.students.search') }}?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    searchResults.innerHTML = `
                        <div style="padding: 1.5rem; text-align: center; color: #999;">
                            <i class="fas fa-search" style="font-size: 24px; display: block; margin-bottom: 0.5rem;"></i>
                            <div style="font-size: 13px;">Tidak ada hasil untuk "<strong>${query}</strong>"</div>
                        </div>
                    `;
                } else {
                    searchResults.innerHTML = data.map((student, index) => `
                        <a href="${student.url}" style="display: flex; align-items: center; padding: 0.875rem 1rem; text-decoration: none; color: #333; border-bottom: ${index < data.length - 1 ? '1px solid #f0f0f0' : 'none'}; transition: background-color 0.2s ease;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                            <div style="flex-shrink: 0; width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #2D4438 0%, #486E5A 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; margin-right: 0.875rem;">
                                ${student.name.charAt(0).toUpperCase()}
                            </div>
                            <div style="flex-grow: 1; min-width: 0;">
                                <div style="font-weight: 600; font-size: 14px; margin-bottom: 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${student.name}</div>
                                <div style="font-size: 12px; color: #666; display: flex; gap: 0.75rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <span><i class="fas fa-id-card" style="margin-right: 0.35rem; color: #2D4438;"></i>${student.nisn}</span>
                                    <span style="color: #aaa;">|</span>
                                    <span><i class="fas fa-home" style="margin-right: 0.35rem; color: #2D4438;"></i>${student.class}</span>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right" style="color: #ccc; margin-left: 0.5rem; flex-shrink: 0;"></i>
                        </a>
                    `).join('');
                }
                searchResults.style.display = 'block';
            })
            .catch(error => {
                console.error('Search error:', error);
                searchResults.style.display = 'none';
            });
    }
});
</script>
@endsection

