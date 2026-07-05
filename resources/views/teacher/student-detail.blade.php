@extends('teacher.layout')

@section('teacher-content')
@php
    use Carbon\Carbon;

    $name    = $student->user->name ?? '-';
    $nisn    = $student->nisn ?? '-';
    $class   = $student->class ?? '-';
    $email   = $student->user->email ?? '-';
    $phone   = $student->user->phone ?? '-';
    $address = $student->user->address ?? '-';
    $photo   = $student->user->profile_photo ?? null;

    // Extended fields (may not exist — show dash gracefully)
    $nik         = $student->user->nik         ?? ($student->nik         ?? '-');
    $gender      = $student->user->gender      ?? ($student->gender      ?? null);
    $birthPlace  = $student->user->birth_place ?? ($student->birth_place ?? '-');
    $birthDate   = $student->user->birth_date  ?? ($student->birth_date  ?? null);
    $fatherName  = $student->user->father_name ?? ($student->father_name ?? '-');
    $motherName  = $student->user->mother_name ?? ($student->mother_name ?? '-');
    $parentPhone = $student->user->parent_phone?? ($student->parent_phone?? '-');

    // Jenjang
    $jenjang = '-';
    if ($class !== '-') {
        if (preg_match('/^(VII|VIII|IX|7|8|9)\b/i', $class))         $jenjang = 'SMP';
        elseif (preg_match('/^(X|XI|XII|10|11|12)\b|TKJ|RPL|AK\b/i', $class)) $jenjang = 'SMK';
        else                                                             $jenjang = 'SD';
    }

    // Gender guess fallback
    if (!$gender) {
        $low = mb_strtolower($name);
        $female = ['siti','nurul','ayu','yunita','rahma','vani','ajeng','eti','neng','syaidah',
                   'mega','dea','widya','mela','novi','suryani','asti','dinda','anita','indah',
                   'putri','gustiani','hidayah','kanesha','ayra','selva','ismania','citra',
                   'lestari','sari','dewi','ratih','wulan','dian','rini','sri','tuti','nina',
                   'maya','linda','ratna','aulia','safira','nisa','zahra','nadia','amalia',
                   'fatimah','aisyah','khadijah','aminah','maryam','zainab','asma','hafsah'];
        $gender = 'Laki-laki';
        foreach ($female as $kw) { if (mb_strpos($low,$kw) !== false) { $gender = 'Perempuan'; break; } }
    }

    $initial = mb_strtoupper(mb_substr($name, 0, 1));
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    .sd-page { font-family: 'Poppins', sans-serif; color: #111827; max-width: 900px; }

    /* Back link */
    .sd-back {
        display: inline-flex; align-items: center; gap: 6px;
        color: #1F4D3B; font-size: .88rem; font-weight: 600;
        text-decoration: none; border: 1.5px solid #1F4D3B;
        border-radius: 8px; padding: 6px 14px;
        transition: background .15s, color .15s;
        margin-bottom: 28px;
    }
    .sd-back:hover { background: #1F4D3B; color: #fff; }

    /* Card */
    .sd-card {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        box-shadow: 0 1px 6px rgba(0,0,0,.05);
        overflow: hidden;
    }
    .sd-card-head {
        padding: 20px 24px 16px;
        border-bottom: 1px solid #F3F4F6;
        font-size: .78rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .07em;
        color: #6B7280;
    }

    /* Profile section */
    .sd-avatar {
        width: 88px; height: 88px; border-radius: 50%;
        object-fit: cover;
        border: 3px solid #E5E7EB;
    }
    .sd-avatar-init {
        width: 88px; height: 88px; border-radius: 50%;
        background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
        color: #1F4D3B; font-size: 2rem; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .sd-student-name { font-size: 1.35rem; font-weight: 700; color: #111827; }
    .sd-class-pill {
        display: inline-flex; align-items: center; gap: 5px;
        background: #ECFDF5; color: #1F4D3B;
        border-radius: 999px; padding: 4px 12px;
        font-size: .8rem; font-weight: 600;
    }
    .sd-status-pill {
        display: inline-block;
        background: #ECFDF5; color: #059669;
        border-radius: 999px; padding: 4px 12px;
        font-size: .8rem; font-weight: 600;
    }

    /* Info rows */
    .sd-info-row {
        display: flex; padding: 14px 24px;
        border-bottom: 1px solid #F3F4F6;
        font-size: .9rem;
    }
    .sd-info-row:last-child { border-bottom: none; }
    .sd-info-label {
        width: 180px; flex-shrink: 0;
        color: #6B7280; font-size: .83rem; font-weight: 500;
    }
    .sd-info-value { color: #111827; font-weight: 500; }

    /* Gender icon */
    .g-laki     { color: #1D4ED8; }
    .g-perempuan{ color: #9D174D; }

    /* Note */
    .sd-note {
        background: #F0FDF4; border: 1px solid #BBF7D0;
        border-radius: 12px; padding: 14px 18px;
        font-size: .87rem; color: #166534;
    }
    .sd-note strong { color: #15803D; }
</style>

<div class="sd-page">

    {{-- Back --}}
    <a href="{{ route('teacher.students') }}" class="sd-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Siswa
    </a>

    {{-- Profile card --}}
    <div class="sd-card mb-4">
        <div class="sd-card-head">Informasi Siswa</div>
        <div class="p-5 d-flex align-items-center gap-4 flex-wrap"
             style="border-bottom: 1px solid #F3F4F6;">
            {{-- Avatar --}}
            @if($photo)
                <img src="{{ asset('storage/' . $photo) }}" alt="{{ $name }}" class="sd-avatar">
            @else
                <div class="sd-avatar-init">{{ $initial }}</div>
            @endif

            {{-- Name + badges --}}
            <div>
                <div class="sd-student-name mb-2">{{ $name }}</div>
                <div class="d-flex flex-wrap gap-2">
                    <span class="sd-class-pill">
                        <i class="fas fa-graduation-cap"></i> Kelas {{ $class }}
                    </span>
                    <span class="sd-class-pill" style="background:#EFF6FF; color:#1D4ED8;">
                        {{ $jenjang }}
                    </span>
                    <span class="sd-status-pill">Aktif</span>
                </div>
            </div>
        </div>

        {{-- Info rows --}}
        <div class="sd-info-row">
            <span class="sd-info-label"><i class="fas fa-id-badge me-2" style="color:#1F4D3B;opacity:.7;"></i>NISN</span>
            <span class="sd-info-value font-monospace">{{ $nisn }}</span>
        </div>
        <div class="sd-info-row">
            <span class="sd-info-label"><i class="fas fa-id-card me-2" style="color:#1F4D3B;opacity:.7;"></i>NIK</span>
            <span class="sd-info-value font-monospace">{{ $nik }}</span>
        </div>
        <div class="sd-info-row">
            <span class="sd-info-label">
                @if($gender === 'Perempuan')
                    <i class="fas fa-venus me-2 g-perempuan"></i>
                @else
                    <i class="fas fa-mars me-2 g-laki"></i>
                @endif
                Jenis Kelamin
            </span>
            <span class="sd-info-value">{{ $gender }}</span>
        </div>
        <div class="sd-info-row">
            <span class="sd-info-label"><i class="fas fa-map-marker-alt me-2" style="color:#1F4D3B;opacity:.7;"></i>Tempat Lahir</span>
            <span class="sd-info-value">{{ $birthPlace }}</span>
        </div>
        <div class="sd-info-row">
            <span class="sd-info-label"><i class="fas fa-calendar me-2" style="color:#1F4D3B;opacity:.7;"></i>Tanggal Lahir</span>
            <span class="sd-info-value">
                @if($birthDate)
                    {{ \Carbon\Carbon::parse($birthDate)->translatedFormat('d F Y') }}
                @else
                    —
                @endif
            </span>
        </div>
        <div class="sd-info-row">
            <span class="sd-info-label"><i class="fas fa-home me-2" style="color:#1F4D3B;opacity:.7;"></i>Alamat</span>
            <span class="sd-info-value">{{ $address }}</span>
        </div>
    </div>

    {{-- Data orang tua --}}
    <div class="sd-card mb-4">
        <div class="sd-card-head">Data Orang Tua / Wali</div>
        <div class="sd-info-row">
            <span class="sd-info-label"><i class="fas fa-user me-2" style="color:#1F4D3B;opacity:.7;"></i>Nama Ayah</span>
            <span class="sd-info-value">{{ $fatherName }}</span>
        </div>
        <div class="sd-info-row">
            <span class="sd-info-label"><i class="fas fa-user me-2" style="color:#9D174D;opacity:.7;"></i>Nama Ibu</span>
            <span class="sd-info-value">{{ $motherName }}</span>
        </div>
        <div class="sd-info-row">
            <span class="sd-info-label"><i class="fas fa-phone me-2" style="color:#1F4D3B;opacity:.7;"></i>No. HP Orang Tua</span>
            <span class="sd-info-value">{{ $parentPhone }}</span>
        </div>
        <div class="sd-info-row">
            <span class="sd-info-label"><i class="fas fa-envelope me-2" style="color:#1F4D3B;opacity:.7;"></i>Email</span>
            <span class="sd-info-value">{{ $email }}</span>
        </div>
    </div>

    {{-- Note --}}
    <div class="sd-note">
        <i class="fas fa-info-circle me-2"></i>
        Halaman ini hanya menampilkan <strong>data administrasi siswa</strong>.
        Untuk melihat nilai siswa, gunakan menu <strong>Kelola Nilai</strong>.
    </div>

</div>
@endsection
