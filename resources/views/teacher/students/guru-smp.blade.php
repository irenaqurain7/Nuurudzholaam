@php
    $smpClassesList = $smpSchedules->keys();
    $firstSMPClass = $smpClassesList->first();
@endphp

@if($firstSMPClass)
    <!-- Info & Select Card -->
    <div class="card card-custom mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h5 class="fw-bold text-muted mb-1" style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">📐 Guru SMP</h5>
                    <h2 class="fw-bold mb-1" style="color: #2F5D50; font-family: 'Poppins', sans-serif;" id="smp-active-class-title">Kelas {{ $firstSMPClass }}</h2>
                    <p class="text-secondary mb-0"><i class="fas fa-users me-2"></i><strong id="smp-active-student-count">{{ $smpSchedules->get($firstSMPClass)->count() }}</strong> Siswa yang diajar</p>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="fw-bold text-secondary mb-0 me-2" style="font-size: 0.95rem;">Pilih Kelas:</label>
                        <select class="form-select smp-class-select" style="min-width: 140px; border-radius: 10px; border-color: #E2E8F0; padding: 8px 12px; font-weight: 600;" onchange="switchSMPClass(this.value)">
                            @foreach($smpClassesList as $smpClass)
                                <option value="{{ $smpClass }}" data-count="{{ $smpSchedules->get($smpClass)->count() }}">{{ $smpClass }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Class containers -->
    @foreach($smpSchedules as $className => $classStudents)
        <div class="smp-class-container" id="smp-class-container-{{ $className }}" style="display: {{ $className === $firstSMPClass ? 'block' : 'none' }};">
            <!-- Table Card -->
            <div class="card card-custom">
                <div class="table-responsive">
                    <table class="table table-custom table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="padding-left: 24px;">Nama</th>
                                <th>Kelas</th>
                                <th>Nilai</th>
                                <th style="width: 120px; text-align: center; padding-right: 24px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="searchable-table-rows">
                            @forelse($classStudents as $student)
                                @php
                                    $nilai = ($student->id ? (75 + ($student->id % 20)) : (75 + (crc32($student->user->name) % 20)));
                                    $gradeLetter = 'C';
                                    if ($nilai >= 90) $gradeLetter = 'A';
                                    elseif ($nilai >= 80) $gradeLetter = 'B';
                                @endphp
                                <tr class="student-row-item">
                                    <td class="fw-semibold search-target-name" style="padding-left: 24px;">{{ $student->user->name }}</td>
                                    <td class="text-secondary search-target-nisn">{{ $student->class }}</td>
                                    <td>
                                        <span class="fw-bold" style="color: #2F5D50;">{{ $nilai }}</span>
                                        <span class="text-muted" style="font-size: 0.85rem;">({{ $gradeLetter }})</span>
                                    </td>
                                    <td class="text-center" style="padding-right: 24px;">
                                        @if($student->id)
                                            <a href="{{ route('teacher.students.show', $student->id) }}" class="btn btn-sm btn-custom-outline px-3" style="padding: 6px 12px; font-size: 0.85rem;">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </a>
                                        @else
                                            <span class="text-muted" style="font-size: 0.85rem; font-weight: 500;">
                                                <i class="fas fa-eye me-1" style="opacity: 0.5;"></i> Detail
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-user-slash d-block mb-3" style="font-size: 2.5rem; opacity: 0.3;"></i>
                                        Tidak ada data siswa di kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($classStudents->count() > 0)
                    <div class="px-4 py-3 d-flex align-items-center justify-content-between border-top border-light">
                        <div class="text-muted" style="font-size: 0.85rem;">
                            Showing 1 to {{ $classStudents->count() }} of {{ $classStudents->count() }} entries
                        </div>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#" style="border-radius: 6px 0 0 6px;">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#" style="background-color: #2F5D50; border-color: #2F5D50;">1</a></li>
                                <li class="page-item disabled"><a class="page-link" href="#" style="border-radius: 0 6px 6px 0;">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <script>
        function switchSMPClass(className) {
            // Hide all containers
            document.querySelectorAll('.smp-class-container').forEach(el => {
                el.style.display = 'none';
            });
            
            // Show target container
            const target = document.getElementById('smp-class-container-' + className);
            if (target) {
                target.style.display = 'block';
            }
            
            // Update title
            document.getElementById('smp-active-class-title').innerText = 'Kelas ' + className;
            
            // Update count
            const selectEl = document.querySelector('.smp-class-select');
            const selectedOption = selectEl.options[selectEl.selectedIndex];
            const studentCount = selectedOption.getAttribute('data-count');
            document.getElementById('smp-active-student-count').innerText = studentCount;
        }
    </script>
@else
    <!-- Empty Role Card -->
    <div class="card card-custom p-5 text-center">
        <div class="mb-3 text-muted" style="font-size: 3rem; opacity: 0.4;">
            <i class="fas fa-folder-open"></i>
        </div>
        <h5 class="fw-bold text-dark" style="font-family: 'Poppins', sans-serif;">Tidak Ada Data Peran</h5>
        <p class="text-secondary mb-0">Anda tidak terdaftar sebagai Guru SMP.</p>
    </div>
@endif
