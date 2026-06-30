@extends('layouts.admin')

@section('title', 'Kelola Jadwal Siswa')
@section('page-title', 'Kelola Jadwal Siswa')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <div>
            <h1>Kelola Jadwal Siswa</h1>
            <p class="subtitle">Atur jadwal pelajaran untuk setiap kelas (TK, SD, SMP, SMA)</p>
        </div>
        <a href="{{ route('admin.schedule.student.wizard.step1') }}" class="btn-add-new">
            <i class="fas fa-plus"></i> Jadwal Baru
        </a>
    </div>

    @php
        $daysIndonesia = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        
        $groupedByJenjang = [
            'TK' => collect(),
            'SD' => collect(),
            'SMP' => collect(),
            'SMK' => collect(),
        ];
        
        foreach ($schedules as $schedule) {
            $c = $schedule->class;
            $num = intval($c);
            if (stripos($c, 'tk') !== false) {
                $j = 'TK';
            } elseif ($num >= 1 && $num <= 6) {
                $j = 'SD';
            } elseif ($num >= 7 && $num <= 9) {
                $j = 'SMP';
            } elseif ($num >= 10) {
                $j = 'SMK';
            } else {
                $j = 'Lainnya';
                if (!isset($groupedByJenjang[$j])) $groupedByJenjang[$j] = collect();
            }
            $groupedByJenjang[$j]->push($schedule);
        }
    @endphp

    <div class="stats-grid">
        <div class="stat-card jenjang-card active" data-target="all" style="cursor:pointer">
            <div class="stat-icon bg-blue">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $schedules->count() }}</h3>
                <p>Semua Jadwal</p>
            </div>
        </div>
        <div class="stat-card jenjang-card" data-target="tk" style="cursor:pointer">
            <div class="stat-icon bg-green">
                <i class="fas fa-child"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $groupedByJenjang['TK']->count() }}</h3>
                <p>Jadwal TK</p>
            </div>
        </div>
        <div class="stat-card jenjang-card" data-target="sd" style="cursor:pointer">
            <div class="stat-icon bg-purple">
                <i class="fas fa-school"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $groupedByJenjang['SD']->count() }}</h3>
                <p>Jadwal SD</p>
            </div>
        </div>
        <div class="stat-card jenjang-card" data-target="smp" style="cursor:pointer">
            <div class="stat-icon bg-orange">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $groupedByJenjang['SMP']->count() }}</h3>
                <p>Jadwal SMP</p>
            </div>
        </div>
        <div class="stat-card jenjang-card" data-target="smk" style="cursor:pointer">
            <div class="stat-icon bg-red">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $groupedByJenjang['SMK']->count() }}</h3>
                <p>Jadwal SMK</p>
            </div>
        </div>
    </div>

    <div class="management-toolbar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari berdasarkan kelas atau mata pelajaran..." class="search-input">
        </div>
        <div class="filter-group">
            <select id="classFilter" class="filter-select">
                <option value="">Semua Kelas</option>
                @php
                    $uniqueClasses = $schedules->pluck('class')->unique()->sort();
                @endphp
                @foreach($uniqueClasses as $class)
                    <option value="{{ $class }}">{{ $class }}</option>
                @endforeach
            </select>
            <select id="dayFilter" class="filter-select">
                <option value="">Semua Hari</option>
                <option value="Monday">Senin</option>
                <option value="Tuesday">Selasa</option>
                <option value="Wednesday">Rabu</option>
                <option value="Thursday">Kamis</option>
                <option value="Friday">Jumat</option>
                <option value="Saturday">Sabtu</option>
            </select>
        </div>
    </div>

    <div class="schedule-wrapper">
        @php
            $groupedByJenjang = array_filter($groupedByJenjang, function($c) { return $c->count() > 0; });
        @endphp

        @if(empty($groupedByJenjang))
            <div class="no-data" style="padding:2rem;text-align:center;">
                <i class="fas fa-inbox" style="font-size:2rem;color:#7f8c8d"></i>
                <p>Belum ada jadwal siswa</p>
            </div>
        @else

            <div class="jenjang-contents">
                @foreach($groupedByJenjang as $jenjang => $items)
                    <div class="jenjang-section" id="jenjang-{{ Str::slug($jenjang) }}">
                        <div class="jenjang-header">
                            <h2><i class="fas fa-layer-group"></i> Jenjang {{ $jenjang }}</h2>
                        </div>
                        
                        @php $groupedByClass = $items->groupBy('class'); @endphp
                        @foreach($groupedByClass as $className => $classItems)
                            <div class="class-card schedule-container" data-class="{{ $className }}">
                                <div class="class-header">
                                    <div>
                                        <h3 class="class-title">Kelas {{ $className }}</h3>
                                        <p class="class-subtitle">Jadwal pelajaran mingguan untuk kelas {{ $className }}</p>
                                    </div>
                                    <a href="{{ route('admin.schedule.student.wizard.step1') }}?class={{ urlencode($className) }}" class="btn-add-text">
                                        <i class="fas fa-plus"></i> Tambah Jadwal
                                    </a>
                                </div>

                                <div class="class-body">
                                    @php $byDay = $classItems->groupBy('day'); @endphp
                                    @foreach($byDay as $day => $entries)
                                        @foreach($entries as $entry)
                                            @php
                                                $subj = $entry->subject ?? '-';
                                                $time = substr($entry->start_time, 0, 5) . ' - ' . substr($entry->end_time, 0, 5);
                                                $teacherName = $entry->teacher->user->name ?? '-';
                                            @endphp
                                            <div class="schedule-row-item" data-day="{{ $day }}" data-subject="{{ strtolower($subj) }}">
                                                <div class="day-col">
                                                    @if($loop->first)
                                                        {{ $daysIndonesia[$day] ?? $day }}
                                                    @endif
                                                </div>
                                                <div class="info-col">
                                                    <div class="blue-bar"></div>
                                                    <div class="subject-details">
                                                        <div class="subject-name">{{ $subj }} <span style="font-size: 0.85em; font-weight: normal; color: #6C8B7C;">(Guru: {{ $teacherName }})</span></div>
                                                        <div class="subject-time"><i class="far fa-clock"></i> {{ $time }}</div>
                                                    </div>
                                                </div>
                                                <div class="action-col">
                                                    <a href="{{ route('admin.schedule.student.edit', $entry->id) }}" class="btn-icon text-muted" title="Edit Jadwal"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('admin.schedule.student.destroy', $entry->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-icon text-danger" style="background:none;border:none;" title="Hapus Jadwal"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<style>
.admin-page { padding: 2rem; background: #f8f9fa; min-height: 100vh; }
    .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 1px 3px rgba(45,68,56,0.06); }
    .page-header h1 { margin: 0 0 0.25rem 0; color: #2D4438; font-size: 1.6rem; font-weight:700; }
.subtitle { color: #7f8c8d; margin: 0; font-size: 0.95rem; }
    .btn-add-new { background: #2D4438; color: white; padding: 0.6rem 1.1rem; border: none; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; transition: background 0.18s, transform 0.12s; box-shadow: 0 1px 2px rgba(45,68,56,0.12); }
    .btn-add-new:hover { background: #23362b; transform: translateY(-2px); }
.management-toolbar { display: flex; gap: 1rem; margin-bottom: 1.5rem; background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); flex-wrap: wrap; }
    .search-box { flex: 1; min-width: 250px; position: relative; display: flex; align-items: center; }
    .search-box i { position: absolute; left: 1rem; color: #c8d1cc; }
    .search-input { width: 100%; padding: 0.6rem 1rem 0.6rem 2.5rem; border: 1px solid #e6ebe6; border-radius: 8px; font-size: 0.95rem; background: #fbfdfb; }
.filter-group { display: flex; gap: 0.5rem; }
    .filter-select { padding: 0.6rem 0.9rem; border: 1px solid #e6ebe6; border-radius: 8px; background: white; cursor: pointer; min-width: 150px; }
    .alert { padding: 1rem; margin-bottom: 1.25rem; border-radius: 8px; display: flex; align-items: center; gap: 0.75rem; }
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
.close { background: none; border: none; font-size: 1.5rem; cursor: pointer; opacity: 0.7; margin-left: auto; }
    .table-responsive-container { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 1px 3px rgba(45,68,56,0.05); margin-bottom: 2rem; overflow-x: auto; }
.admin-table { width: 100%; border-collapse: collapse; min-width: 900px; }
    .admin-table thead { background: #2D4438; color: white; }
.admin-table th { padding: 1rem; text-align: left; font-weight: 600; }
.admin-table tbody tr { border-bottom: 1px solid #ecf0f1; transition: background 0.3s; }
.admin-table tbody tr:hover { background: #f8f9fa; }
.admin-table td { padding: 1rem; }

/* New Class Card UI */
.class-card { background: #ffffff; border-radius: 12px; border: 1px solid #E2ECE8; margin-bottom: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.02); overflow: hidden; }
.class-header { display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; border-bottom: 1px solid #E2ECE8; }
.class-title { margin: 0 0 0.25rem 0; font-size: 1.25rem; font-weight: 700; color: #1C2D25; }
.class-subtitle { margin: 0; font-size: 0.85rem; color: #6C8B7C; }
.btn-add-text { color: #2D4438; font-weight: 600; font-size: 0.95rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s; }
.btn-add-text:hover { color: #1a2921; }

.schedule-row-item { display: flex; align-items: center; padding: 1.25rem 1.5rem; border-bottom: 1px solid #E2ECE8; transition: background 0.2s; }
.schedule-row-item:last-child { border-bottom: none; }
.schedule-row-item:hover { background: #fbfdfb; }
.day-col { width: 120px; font-weight: 600; color: #1C2D25; font-size: 0.95rem; }
.info-col { flex: 1; display: flex; align-items: stretch; gap: 1rem; }
.blue-bar { width: 4px; background: #3b82f6; border-radius: 4px; }
.subject-details { display: flex; flex-direction: column; justify-content: center; gap: 0.25rem; }
.subject-name { font-weight: 500; color: #1f2937; font-size: 0.95rem; }
.subject-time { font-size: 0.85rem; color: #6b7280; display: flex; align-items: center; gap: 0.35rem; }
.action-col { display: flex; gap: 0.5rem; opacity: 0.4; transition: opacity 0.2s; }
.schedule-row-item:hover .action-col { opacity: 1; }
.btn-icon { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 6px; transition: all 0.2s; cursor: pointer; color: inherit; text-decoration: none; }
.btn-icon:hover { background: #f3f4f6; }

.no-data { padding: 3rem 1rem; color: #7f8c8d; }

/* Stats Grid & Jenjang Cards */
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
.stat-card { background: white; padding: 1.25rem; border-radius: 12px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05); display: flex; align-items: center; gap: 1.25rem; transition: all 0.2s; border: 2px solid transparent; }
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(45,68,56,0.1); }
.stat-card.active { border-color: #2D4438; box-shadow: 0 4px 12px rgba(45,68,56,0.15); background: #fbfdfb; }
.stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
.stat-icon.bg-blue { background: #eff6ff; color: #3b82f6; }
.stat-icon.bg-green { background: #ecfdf5; color: #10b981; }
.stat-icon.bg-purple { background: #f5f3ff; color: #8b5cf6; }
.stat-icon.bg-orange { background: #fff7ed; color: #f97316; }
.stat-icon.bg-red { background: #fef2f2; color: #ef4444; }
.stat-content h3 { margin: 0 0 0.2rem 0; font-size: 1.5rem; font-weight: 700; color: #1C2D25; }
.stat-content p { margin: 0; color: #6C8B7C; font-size: 0.9rem; font-weight: 600; }
.jenjang-header { margin-bottom: 1.5rem; padding-left: 0.5rem; }
.jenjang-header h2 { margin: 0; font-size: 1.4rem; color: #1C2D25; display: flex; align-items: center; gap: 0.75rem; font-weight: 700; }
.jenjang-header h2 i { color: #709D88; }

@media (max-width: 1024px) {
    .management-toolbar { flex-direction: column; }
    .filter-group { width: 100%; display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; }
}

@media (max-width: 768px) {
    .admin-page { padding: 1rem; }
    .page-header { flex-direction: column; gap: 1rem; }
    .btn-add-new { width: 100%; justify-content: center; }
    .search-box { width: 100%; }
    .admin-table th, .admin-table td { padding: 0.5rem; font-size: 0.85rem; }
    .admin-table th { width: auto !important; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const classFilter = document.getElementById('classFilter');
    const dayFilter = document.getElementById('dayFilter');
    const jenjangCards = document.querySelectorAll('.jenjang-card');
    const jenjangSections = document.querySelectorAll('.jenjang-section');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedClass = classFilter.value;
        const selectedDay = dayFilter.value;
        const activeTab = document.querySelector('.jenjang-card.active')?.dataset.target || 'all';

        jenjangSections.forEach(sec => {
            let hasVisibleCard = false;
            const isTabMatch = activeTab === 'all' || sec.id === 'jenjang-' + activeTab;
            
            const cardsInSec = sec.querySelectorAll('.schedule-container');
            cardsInSec.forEach(card => {
                const rowClass = card.dataset.class || '';
                const matchesClass = !selectedClass || rowClass === selectedClass;
                
                let hasVisibleRows = false;
                const rows = card.querySelectorAll('.schedule-row-item');
                
                rows.forEach(row => {
                    const day = row.dataset.day || '';
                    const subject = row.dataset.subject || '';
                    
                    const matchesSearch = rowClass.toLowerCase().includes(searchTerm) || subject.includes(searchTerm);
                    const matchesDay = !selectedDay || day === selectedDay;
                    
                    if (matchesSearch && matchesDay) {
                        row.style.display = '';
                        hasVisibleRows = true;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                if (matchesClass && hasVisibleRows) {
                    card.style.display = '';
                    hasVisibleCard = true;
                } else {
                    card.style.display = 'none';
                }
            });
            
            if (isTabMatch && hasVisibleCard) {
                sec.style.display = 'block';
            } else {
                sec.style.display = 'none';
            }
        });
    }

    jenjangCards.forEach(card => {
        card.addEventListener('click', () => {
            jenjangCards.forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            filterTable();
        });
    });

    searchInput?.addEventListener('keyup', filterTable);
    classFilter?.addEventListener('change', filterTable);
    dayFilter?.addEventListener('change', filterTable);
    
    // Initial filter execution to ensure correct display on load
    filterTable();
});
</script>
@endsection
