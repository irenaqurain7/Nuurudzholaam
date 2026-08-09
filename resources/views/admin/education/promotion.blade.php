@extends('layouts.admin')

@section('title', 'Kenaikan & Kelanjutan Siswa')
@section('page-title', 'Kenaikan & Kelanjutan Siswa')

@section('content')
<style>
/* Promotion page tweaks: spacing, form, table */
.admin-page .page-header h1{font-size:28px;margin:0 0 6px 0}
.admin-page .page-header .subtitle{color:#6b6b6b;margin:0 0 8px 0}
.admin-page .card{background:#fff;border-radius:8px;border:1px solid #eef6f0}
.card{padding:16px;margin-bottom:18px}
.filter-select, .status-select, .target-jenjang, .target-class{padding:8px 10px;border-radius:6px;border:1px solid #e0e8e2;background:#fbfdfb}
.form-label{display:block;font-weight:600;margin-bottom:6px;color:#2b3b33}
#filterForm{display:flex;gap:12px;flex-wrap:wrap;align-items:center}
#filterForm > div{min-width:160px}
.admin-btn{background:#1f5a43;color:#fff;padding:9px 14px;border-radius:8px;border:none;cursor:pointer}
.admin-btn:hover{opacity:.95}
.table-wrap{overflow:auto;border-radius:6px}
.admin-table{width:100%;border-collapse:collapse}
.admin-table th,.admin-table td{padding:10px 12px;border-bottom:1px solid #f1f7f3}
.admin-table thead th{background:#fbfdfb;font-weight:700;text-align:left}
.small-note{color:#6b6b6b;margin-top:8px}
@media(max-width:720px){#filterForm{flex-direction:column;align-items:stretch} #filterForm > div{min-width:100%}}
</style>
<div class="admin-page">
    <div class="page-header" style="margin-bottom:18px;">
        <div>
            <h1>Kenaikan & Kelanjutan Siswa</h1>
            <p class="subtitle">Pilih tahun ajaran, jenjang, dan kelas asal untuk mengelola kenaikan/kelanjutan</p>
        </div>
    </div>

    <div class="card" style="padding:18px; margin-bottom:18px;">
        <form id="filterForm" method="GET" action="{{ route('admin.education.promotion.index') }}" style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
            <div style="min-width:220px;">
                <label class="form-label">Tahun Ajaran Asal</label>
                <select name="academic_year_from" class="filter-select">
                    @foreach($years as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <div style="min-width:220px;">
                <label class="form-label">Tahun Ajaran Tujuan</label>
                <select name="academic_year_to" class="filter-select">
                    @foreach($years as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <div style="min-width:160px;">
                <label class="form-label">Jenjang</label>
                <select name="jenjang" class="filter-select">
                    <option value="">Pilih Jenjang</option>
                    <option value="TK">TK</option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMK">SMK</option>
                </select>
            </div>

            <div style="min-width:160px;">
                <label class="form-label">Kelas Asal</label>
                <select name="class_from" id="classFromSelect" class="filter-select">
                    <option value="">Pilih Kelas</option>
                </select>
            </div>

            <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
                <button type="submit" class="admin-btn">Tampilkan Siswa</button>
            </div>
        </form>
    </div>

    @if($students && $students->count())
    <div class="card" style="padding:12px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; gap:16px;">
            <div>
                <h3 style="margin:0;">Daftar Siswa (<span id="totalFound">{{ $students->count() }}</span>)</h3>
                <div class="small-note">Terpilih: <strong id="totalSelected">0</strong> siswa</div>
            </div>
            <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
                <button id="btnPrepare" class="admin-btn" disabled>Preview & Konfirmasi</button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="admin-table" style="width:100%;">
                <thead>
                    <tr>
                        <th style="width:40px;"><input type="checkbox" id="selectAll"></th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>Kelas Asal</th>
                        <th>Status Kelanjutan</th>
                        <th>Kelas / Jenjang Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $s)
                    <tr data-student-id="{{ $s->id }}">
                        <td><input type="checkbox" class="rowCheckbox"></td>
                        <td>{{ $s->user->name }}</td>
                        <td>{{ $s->nisn ?? '—' }}</td>
                        <td>{{ $s->class }}</td>
                        <td>
                            <select class="status-select">
                                <option value="Naik Kelas">Naik Kelas</option>
                                <option value="Lanjut">Lanjut</option>
                                <option value="Tidak Naik">Tidak Naik</option>
                                <option value="Pindah Sekolah">Pindah Sekolah</option>
                                <option value="Tidak Lanjut">Tidak Lanjut</option>
                                <option value="Belum Ditentukan">Belum Ditentukan</option>
                            </select>
                        </td>
                        <td>
                            <div style="display:flex; gap:8px; align-items:center;">
                                <select class="target-jenjang">
                                    <option value="TK">TK</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMK">SMK</option>
                                </select>
                                <input type="text" class="target-class" value="{{ $s->class }}" style="min-width:90px;" />
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <form id="applyForm" method="POST" action="{{ route('admin.education.promotion.apply') }}" style="display:none;">
            @csrf
            <input type="hidden" name="academic_year_from" value="">
            <input type="hidden" name="academic_year_to" value="">
        </form>
    </div>
    @else
    <div class="card" style="padding:18px;">
        <p>Pilih filter dan klik <strong>Tampilkan Siswa</strong> untuk memulai.</p>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Populate class dropdown based on jenjang selection
    const jenjangSelect = document.querySelector('select[name="jenjang"]');
    const classFromSelect = document.getElementById('classFromSelect');

    // classesByJenjang is passed from controller (actual classes present in DB)
    const classOptions = @json($classesByJenjang ?? []);

    // fallback defaults if DB doesn't contain classes for a jenjang
    const fallback = {
        'TK': ['Kelompok A','Kelompok B','Kelompok C'],
        'SD': ['1','2','3','4','5','6'],
        'SMP': ['7','8','9'],
        'SMK': ['X','XI','XII']
    };

    function populateClassOptions(selectedJenjang, selectedClass) {
        classFromSelect.innerHTML = '<option value="">Pilih Kelas</option>';
        if (!selectedJenjang) return;
        const opts = (classOptions[selectedJenjang] && classOptions[selectedJenjang].length) ? classOptions[selectedJenjang] : (fallback[selectedJenjang] || []);
        opts.forEach(o => {
            const opt = document.createElement('option');
            opt.value = o;
            opt.textContent = o;
            if (selectedClass && selectedClass == o) opt.selected = true;
            classFromSelect.appendChild(opt);
        });
    }

    // initialize with request values if present
    const initialJenjang = '{{ request()->input('jenjang') }}';
    const initialClass = '{{ request()->input('class_from') }}';
    if (initialJenjang) {
        jenjangSelect.value = initialJenjang;
        populateClassOptions(initialJenjang, initialClass);
    }

    jenjangSelect.addEventListener('change', function() {
        populateClassOptions(this.value, '');
    });

    const selectAll = document.getElementById('selectAll');
    const rowCheckboxes = Array.from(document.querySelectorAll('.rowCheckbox'));
    const btnPrepare = document.getElementById('btnPrepare');
    const applyForm = document.getElementById('applyForm');
    const totalFoundEl = document.getElementById('totalFound');
    const totalSelectedEl = document.getElementById('totalSelected');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.rowCheckbox').forEach(cb => cb.checked = selectAll.checked);
            updateCounts();
        });
    }

    if (btnPrepare) {
        btnPrepare.addEventListener('click', function(e) {
            e.preventDefault();

            // gather selected rows
            const rows = Array.from(document.querySelectorAll('tbody tr'));
            const selected = [];
            rows.forEach(r => {
                const cb = r.querySelector('.rowCheckbox');
                if (!cb || !cb.checked) return;
                const id = r.getAttribute('data-student-id');
                const status = r.querySelector('.status-select').value;
                const targetJenjang = r.querySelector('.target-jenjang').value;
                const targetClass = r.querySelector('.target-class').value;
                selected.push({student_id: id, status: status, target_jenjang: targetJenjang, target_class: targetClass});
            });

            if (selected.length === 0) {
                alert('Pilih minimal satu siswa.');
                return;
            }

            // summary
            const counts = selected.reduce((acc, cur) => { acc[cur.status] = (acc[cur.status]||0)+1; return acc; }, {});
            let summaryText = '';
            for (const k in counts) {
                summaryText += `${counts[k]} siswa: ${k}\n`;
            }
            summaryText = `Konfirmasi Perubahan:\n` + summaryText + '\nLanjutkan menyimpan perubahan?';

            if (!confirm(summaryText)) return;

            // build form inputs
            // set academic years from filter form
            const fyFrom = document.querySelector('select[name="academic_year_from"]');
            const fyTo = document.querySelector('select[name="academic_year_to"]');
            applyForm.querySelector('input[name="academic_year_from"]').value = fyFrom ? fyFrom.value : '';
            applyForm.querySelector('input[name="academic_year_to"]').value = fyTo ? fyTo.value : '';

            // append student inputs
            // remove previous student inputs
            Array.from(applyForm.querySelectorAll('input[name^="students"]')).forEach(n=>n.remove());
            selected.forEach((s, idx) => {
                const fields = ['student_id','status','target_jenjang','target_class'];
                fields.forEach(f => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `students[${idx}][${f}]`;
                    input.value = s[f] || '';
                    applyForm.appendChild(input);
                });
            });

            applyForm.style.display = 'block';
            applyForm.submit();
        });
    }

    function updateCounts() {
        const rows = Array.from(document.querySelectorAll('tbody tr'));
        const total = rows.length;
        const selected = rows.filter(r => r.querySelector('.rowCheckbox') && r.querySelector('.rowCheckbox').checked).length;
        if (totalFoundEl) totalFoundEl.textContent = total;
        if (totalSelectedEl) totalSelectedEl.textContent = selected;
        if (btnPrepare) {
            btnPrepare.disabled = selected === 0;
            btnPrepare.textContent = `Preview & Konfirmasi (${selected})`;
        }
    }

    // Auto-check all rows when students are present
    const rows = Array.from(document.querySelectorAll('tbody tr'));
    if (rows.length) {
        rows.forEach(r => {
            const cb = r.querySelector('.rowCheckbox');
            if (cb) cb.checked = true;
            // auto-determine default target for normal promotions
            const jenjang = (r.querySelector('td:nth-child(5) .status-select') ? null : null);
            const studJenjang = '{{ $students->first() ? $students->first()->jenjang : '' }}';
            // compute based on the student's displayed class
            const classText = r.querySelector('td:nth-child(4)') ? r.querySelector('td:nth-child(4)').textContent.trim() : '';
            const statusSelect = r.querySelector('.status-select');
            const targetJenjang = r.querySelector('.target-jenjang');
            const targetClass = r.querySelector('.target-class');
            if (statusSelect && targetJenjang && targetClass) {
                // default behavior: if numeric class and not final, set Naik Kelas
                const curJenjang = r.querySelector('.target-jenjang') ? r.querySelector('.target-jenjang').value = r.querySelector('.target-jenjang').value : '';
                // parse numeric
                let nextClass = '';
                if (/^\d+$/.test(classText)) {
                    const n = parseInt(classText,10);
                    // SD 1-6 -> increment if <6
                    if (initialJenjang === 'SD' && n < 6) {
                        nextClass = (n+1).toString();
                        statusSelect.value = 'Naik Kelas';
                        targetJenjang.value = 'SD';
                        targetClass.value = nextClass;
                    }
                    // SMP 7-9
                    else if (initialJenjang === 'SMP' && n < 9) {
                        nextClass = (n+1).toString();
                        statusSelect.value = 'Naik Kelas';
                        targetJenjang.value = 'SMP';
                        targetClass.value = nextClass;
                    }
                } else {
                    // handle SMK roman X, XI
                    if (initialJenjang === 'SMK') {
                        if (classText === 'X') { statusSelect.value='Naik Kelas'; targetJenjang.value='SMK'; targetClass.value='XI'; }
                        if (classText === 'XI') { statusSelect.value='Naik Kelas'; targetJenjang.value='SMK'; targetClass.value='XII'; }
                    }
                }
            }
        });
        // check header
        if (selectAll) selectAll.checked = true;
        updateCounts();
    }

    // when any row checkbox changes, update counts
    document.addEventListener('change', function(e){
        if (e.target && e.target.classList && e.target.classList.contains('rowCheckbox')) {
            updateCounts();
        }
    });
});
</script>
@endpush

@endsection
