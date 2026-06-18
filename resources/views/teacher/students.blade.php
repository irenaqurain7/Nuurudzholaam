@extends('teacher.layout')

@section('teacher-content')
<style>
    :root {
        --primary: #2d5016;
        --primary-light: rgba(45, 80, 22, 0.08);
        --text-primary: #1a1a1a;
        --text-secondary: #666;
        --text-muted: #999;
        --border: #e5e5e5;
        --bg-light: #f9f9f9;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .page-header p {
        color: var(--text-secondary);
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }

    .section {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    /* Search Box Customization */
    .search-container {
        max-width: 380px;
        margin-bottom: 2rem;
        position: relative;
    }

    .search-group {
        display: flex;
        align-items: center;
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 0.25rem 0.75rem;
        transition: all 0.2s ease;
    }

    .search-group:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(45, 80, 22, 0.1);
    }

    .search-input {
        border: none;
        outline: none;
        padding: 0.5rem 0.5rem 0.5rem 0.25rem;
        font-size: 0.9rem;
        color: var(--text-primary);
        width: 100%;
    }

    .search-icon {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    /* Dropdown Search Results */
    #searchResults {
        display: none;
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        width: 100%;
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
        background: white;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border);
    }

    /* Custom Clean Table */
    .class-student-scroll {
        max-height: clamp(320px, 60vh, 620px);
        overflow: auto;
    }

    .class-student-table {
        width: 100%;
        min-width: 900px;
        table-layout: fixed;
        border-collapse: collapse;
    }

    .class-student-table th {
        position: sticky;
        top: 0;
        z-index: 1;
        background: var(--bg-light);
        color: var(--text-secondary);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.25rem;
        border-bottom: 2px solid var(--border);
        text-align: left;
    }

    .class-student-table td {
        padding: 1.1rem 1.25rem;
        border-bottom: 1px solid var(--border);
        color: var(--text-primary);
        font-size: 0.95rem;
        vertical-align: middle;
    }

    .class-student-table tbody tr:hover:not(.class-divider-row) {
        background-color: rgba(45, 80, 22, 0.01);
    }

    /* Class Group Divider Row */
    .class-divider-row td {
        padding: 0;
        border: 0;
    }

    .class-divider {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1.25rem;
        background: linear-gradient(90deg, rgba(45, 80, 22, 0.06), rgba(45, 80, 22, 0.01));
        color: var(--primary);
        font-weight: 600;
        font-size: 0.9rem;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
    }

    /* Buttons Style */
    .btn-detail {
        background-color: white;
        color: var(--primary);
        border: 1px solid var(--primary);
        padding: 0.4rem 1rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.2s;
    }

    .btn-detail:hover {
        background-color: var(--primary);
        color: white;
    }

    /* Column Width Configuration */
    .class-student-table td:nth-child(1), .class-student-table th:nth-child(1) { min-width: 120px; width: 120px; }
    .class-student-table td:nth-child(2), .class-student-table th:nth-child(2) { min-width: 260px; }
    .class-student-table td:nth-child(3), .class-student-table th:nth-child(3) { min-width: 130px; width: 150px; }
    .class-student-table td:nth-child(4), .class-student-table th:nth-child(4) { min-width: 180px; width: 180px; }

    /* Elegant Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-icon {
        background-color: var(--bg-light);
        color: var(--text-muted);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        border: 1px solid var(--border);
    }

    .empty-state h3 {
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 0.5rem 0;
    }

    .empty-state p {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin: 0;
    }
</style>

<div class="page-header">
    <h1>Data Siswa Saya</h1>
    <p>Daftar informasi, rombongan belajar, dan data lengkap siswa Anda</p>
</div>

<div class="search-container">
    <div class="search-group">
        <span class="search-icon"><i class="fas fa-search"></i></span>
        <input type="text" id="studentSearch" class="search-input" placeholder="Cari nama atau NISN...">
    </div>
    <div id="searchResults"></div>
</div>

@if($students->count() > 0)
    <div class="section" style="padding: 0; overflow: hidden;">
        <div class="class-student-scroll">
            <table class="class-student-table">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentsByClass as $className => $classStudents)
                        <tr class="class-divider-row">
                            <td colspan="4">
                                <div class="class-divider">
                                    <span>Kelas {{ $className }}</span>
                                    <span style="font-size: 0.8rem; background-color: var(--bg-light); padding: 0.2rem 0.6rem; border-radius: 4px; border: 1px solid var(--border);">{{ $classStudents->count() }} Siswa</span>
                                </div>
                            </td>
                        </tr>

                        @foreach($classStudents as $student)
                            <tr>
                                <td style="font-weight: 600; color: var(--text-secondary);">{{ $student->class }}</td>
                                <td>
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $student->user->name }}</div>
                                </td>
                                <td style="color: var(--text-secondary); font-family: monospace; font-size: 0.95rem;">{{ $student->nisn }}</td>
                                <td style="text-align: right;">
                                    @if($student->id)
                                        <a href="{{ route('teacher.students.show', $student->id) }}" class="btn-detail">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    @else
                                        <span class="btn-detail" style="border-color: #ccc; color: #666; cursor: default;">
                                            <i class="fas fa-eye" style="opacity:0.6"></i> Detail
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="section">
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-user-slash"></i>
            </div>
            <h3>Belum Ada Data Siswa</h3>
            <p>Data siswa di bawah bimbingan atau kelas mengajar Anda belum tersedia.</p>
        </div>
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

    // Tutup dropdown saat klik di luar kotak pencarian
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container')) {
            searchResults.style.display = 'none';
        }
    });

    function performSearch(query) {
        fetch(`{{ route('teacher.students.search') }}?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    searchResults.innerHTML = `
                        <div style="padding: 1.5rem; text-align: center; color: var(--text-muted);">
                            <i class="fas fa-search" style="font-size: 20px; display: block; margin-bottom: 0.5rem;"></i>
                            <div style="font-size: 13px;">Tidak ada hasil untuk "<strong>${query}</strong>"</div>
                        </div>
                    `;
                } else {
                    searchResults.innerHTML = data.map((student, index) => `
                        <a href="${student.url}" style="display: flex; align-items: center; padding: 0.85rem 1rem; text-decoration: none; color: var(--text-primary); border-bottom: ${index < data.length - 1 ? '1px solid var(--border)' : 'none'}; transition: background-color 0.2s ease;" onmouseover="this.style.backgroundColor='var(--bg-light)'" onmouseout="this.style.backgroundColor='transparent'">
                            <div style="flex-shrink: 0; width: 36px; height: 36px; border-radius: 50%; background-color: var(--primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 13px; margin-right: 0.85rem;">
                                ${student.name.charAt(0).toUpperCase()}
                            </div>
                            <div style="flex-grow: 1; min-width: 0;">
                                <div style="font-weight: 600; font-size: 13.5px; margin-bottom: 0.15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${student.name}</div>
                                <div style="font-size: 12px; color: var(--text-secondary); display: flex; gap: 0.75rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <span><i class="fas fa-id-card" style="margin-right: 0.25rem; color: var(--text-muted);"></i>${student.nisn}</span>
                                    <span style="color: var(--border);">|</span>
                                    <span><i class="fas fa-home" style="margin-right: 0.25rem; color: var(--text-muted);"></i>${student.class}</span>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right" style="color: #ccc; margin-left: 0.5rem; flex-shrink: 0; font-size: 0.8rem;"></i>
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
