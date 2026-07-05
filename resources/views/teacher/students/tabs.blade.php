<!-- Tab Navigation -->
<ul class="nav nav-pills-custom" id="studentRolesTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="wali-kelas-tab" data-bs-toggle="pill" data-bs-target="#wali-kelas-content" type="button" role="tab" aria-controls="wali-kelas-content" aria-selected="true">
            <span style="font-size: 1.1rem;">👨‍🏫</span> Wali Kelas SD
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="guru-smp-tab" data-bs-toggle="pill" data-bs-target="#guru-smp-content" type="button" role="tab" aria-controls="guru-smp-content" aria-selected="false">
            <span style="font-size: 1.1rem;">📐</span> Guru SMP
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="guru-smk-tab" data-bs-toggle="pill" data-bs-target="#guru-smk-content" type="button" role="tab" aria-controls="guru-smk-content" aria-selected="false">
            <span style="font-size: 1.1rem;">🎓</span> Guru SMK
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content" id="studentRolesTabContent">
    <div class="tab-pane fade show active" id="wali-kelas-content" role="tabpanel" aria-labelledby="wali-kelas-tab">
        @include('teacher.students.wali-kelas')
    </div>
    <div class="tab-pane fade" id="guru-smp-content" role="tabpanel" aria-labelledby="guru-smp-tab">
        @include('teacher.students.guru-smp')
    </div>
    <div class="tab-pane fade" id="guru-smk-content" role="tabpanel" aria-labelledby="guru-smk-tab">
        @include('teacher.students.guru-smk')
    </div>
</div>
