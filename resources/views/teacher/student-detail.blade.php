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

    // Extended fields
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
        elseif (preg_match('/^(TK|tk|paud|PAUD)/i', $class))         $jenjang = 'TK';
        else                                                           $jenjang = 'SD';
    }

    // Jenjang badge color
    $jenjangStyle = match($jenjang) {
        'SMP'  => 'background:#EFF6FF; color:#1D4ED8;',
        'SMK'  => 'background:#FFF7ED; color:#C2410C;',
        'TK'   => 'background:#FDF4FF; color:#7E22CE;',
        default=> 'background:#EFF6FF; color:#1D4ED8;',
    };

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
    $avatarColors = ['A'=>'#2F4F3E','B'=>'#456652','C'=>'#3598b6','D'=>'#d37c1f','E'=>'#6b8d2d','F'=>'#7d5aa3'];
    $avatarColor = $avatarColors[$initial] ?? '#2F4F3E';
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

    .sd-page {
        font-family: 'Poppins', sans-serif;
        color: #111827;
        max-width: 960px;
    }

    /* ---- Back button ---- */
    .sd-back {
        display: inline-flex; align-items: center; gap: 8px;
        color: #1F4D3B; font-size: .88rem; font-weight: 600;
        text-decoration: none;
        background: #fff;
        border: 1.5px solid #d4e8df;
        border-radius: 10px; padding: 8px 18px;
        transition: background .15s, color .15s, border-color .15s;
        margin-bottom: 24px;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
    }
    .sd-back:hover { background: #1F4D3B; color: #fff; border-color: #1F4D3B; }

    /* ---- Hero / Profile Banner ---- */
    .sd-hero {
        background: linear-gradient(135deg, #1F4D3B 0%, #2e7d63 100%);
        border-radius: 20px 20px 0 0;
        padding: 32px 32px 0;
        position: relative;
        overflow: hidden;
    }
    .sd-hero::before {
        content: '';
        position: absolute; top: -30px; right: -30px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
    }
    .sd-hero::after {
        content: '';
        position: absolute; bottom: -20px; right: 80px;
        width: 100px; height: 100px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .sd-hero-avatar {
        width: 96px; height: 96px; border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255,255,255,0.35);
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        flex-shrink: 0;
    }
    .sd-hero-initial {
        width: 96px; height: 96px; border-radius: 50%;
        background: rgba(255,255,255,0.18);
        backdrop-filter: blur(4px);
        border: 4px solid rgba(255,255,255,0.35);
        color: #fff; font-size: 2.4rem; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    }
    .sd-hero-name {
        font-size: 1.6rem; font-weight: 800;
        color: #fff; margin: 0 0 8px 0;
        line-height: 1.2;
    }
    .sd-hero-badges { display: flex; flex-wrap: wrap; gap: 8px; }
    .sd-hero-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(255,255,255,0.18);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 999px; padding: 5px 14px;
        font-size: .8rem; font-weight: 600; color: #fff;
        backdrop-filter: blur(4px);
    }
    .sd-hero-tab-bar {
        display: flex; gap: 4px;
        margin-top: 20px;
        position: relative; z-index: 1;
    }
    .sd-hero-tab {
        padding: 10px 20px;
        font-size: .85rem; font-weight: 600;
        color: rgba(255,255,255,0.65);
        border-radius: 10px 10px 0 0;
        cursor: default;
        background: transparent;
        border: none;
    }
    .sd-hero-tab.active {
        background: #F8FAF9;
        color: #1F4D3B;
    }

    /* ---- Card body ---- */
    .sd-body {
        background: #F8FAF9;
        border-radius: 0 0 20px 20px;
        padding: 24px;
        border: 1px solid #E5E7EB;
        border-top: none;
    }

    /* ---- Info sections ---- */
    .sd-section {
        background: #fff;
        border: 1px solid #E9EDEF;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 16px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.04);
    }
    .sd-section-head {
        padding: 14px 20px;
        font-size: .75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .07em;
        color: #6B7280;
        background: #FAFAFA;
        border-bottom: 1px solid #F0F0F0;
        display: flex; align-items: center; gap: 8px;
    }
    .sd-section-head-icon {
        width: 28px; height: 28px; border-radius: 8px;
        background: linear-gradient(135deg, #d4ede2, #bbdeca);
        display: inline-flex; align-items: center; justify-content: center;
        color: #1F4D3B; font-size: .8rem;
    }

    /* ---- Info grid (2 columns) ---- */
    .sd-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
    }
    .sd-info-item {
        padding: 14px 20px;
        border-right: 1px solid #F0F0F0;
        border-bottom: 1px solid #F0F0F0;
    }
    .sd-info-item:nth-child(even) { border-right: none; }
    .sd-info-item:nth-last-child(1),
    .sd-info-item:nth-last-child(2) { border-bottom: none; }
    .sd-info-label {
        font-size: .75rem; font-weight: 600;
        color: #9CA3AF; text-transform: uppercase; letter-spacing: .04em;
        margin-bottom: 4px;
    }
    .sd-info-value {
        font-size: .95rem; font-weight: 600;
        color: #111827;
    }
    .sd-info-value.muted { color: #9CA3AF; font-weight: 400; font-style: italic; }

    /* ---- Full-width row (address) ---- */
    .sd-info-full {
        padding: 14px 20px;
        border-bottom: 1px solid #F0F0F0;
    }
    .sd-info-full:last-child { border-bottom: none; }

    /* ---- Gender badge ---- */
    .gender-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 3px 12px; border-radius: 999px;
        font-size: .85rem; font-weight: 600;
    }
    .gender-laki     { background: #EFF6FF; color: #1D4ED8; }
    .gender-perempuan{ background: #FDF2F8; color: #9D174D; }

    /* ---- Note ---- */
    .sd-note {
        background: linear-gradient(135deg, #F0FDF4, #ECFDF5);
        border: 1px solid #BBF7D0;
        border-radius: 14px; padding: 16px 20px;
        font-size: .87rem; color: #166534;
        display: flex; align-items: flex-start; gap: 12px;
    }
    .sd-note-icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: #BBF7D0; color: #15803D;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 1rem;
    }

    @media (max-width: 600px) {
        .sd-info-grid { grid-template-columns: 1fr; }
        .sd-info-item { border-right: none; }
        .sd-hero { padding: 24px 20px 0; }
        .sd-body { padding: 16px; }
    }
</style>

<div class="sd-page">

    {{-- Back --}}
    <a href="{{ route('teacher.students') }}" class="sd-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Siswa
    </a>

    {{-- Hero banner --}}
    <div class="sd-hero">
        <div class="d-flex align-items-center gap-4 flex-wrap mb-4" style="position:relative;z-index:1;">
            {{-- Avatar --}}
            @if($photo)
                <img src="{{ asset('storage/' . $photo) }}" alt="{{ $name }}" class="sd-hero-avatar">
            @else
                <div class="sd-hero-initial">{{ $initial }}</div>
            @endif

            {{-- Name + badges --}}
            <div>
                <h1 class="sd-hero-name">{{ $name }}</h1>
                <div class="sd-hero-badges">
                    <span class="sd-hero-badge">
                        <i class="fas fa-graduation-cap"></i> Kelas {{ $class }}
                    </span>
                    <span class="sd-hero-badge">{{ $jenjang }}</span>
                    <span class="sd-hero-badge" style="background:rgba(16,185,129,0.25); border-color:rgba(16,185,129,0.3);">
                        <i class="fas fa-circle" style="font-size:.5rem;"></i> Aktif
                    </span>
                    @if($nisn !== '-')
                    <span class="sd-hero-badge" style="font-family:monospace;">
                        NISN: {{ $nisn }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tab bar --}}
        <div class="sd-hero-tab-bar">
            <div class="sd-hero-tab active">
                <i class="fas fa-user me-1"></i> Data Siswa
            </div>
        </div>
    </div>

    {{-- Body --}}
    <div class="sd-body">

        {{-- Section: Identitas --}}
        <div class="sd-section">
            <div class="sd-section-head">
                <span class="sd-section-head-icon"><i class="fas fa-id-card"></i></span>
                Data Identitas Siswa
            </div>
            <div class="sd-info-grid">
                <div class="sd-info-item">
                    <div class="sd-info-label">NISN</div>
                    <div class="sd-info-value {{ $nisn === '-' ? 'muted' : 'font-monospace' }}">{{ $nisn }}</div>
                </div>
                <div class="sd-info-item">
                    <div class="sd-info-label">NIK</div>
                    <div class="sd-info-value {{ $nik === '-' ? 'muted' : 'font-monospace' }}">{{ $nik === '-' ? 'Belum diisi' : $nik }}</div>
                </div>
                <div class="sd-info-item">
                    <div class="sd-info-label">Jenis Kelamin</div>
                    <div class="sd-info-value">
                        @if($gender === 'Perempuan')
                            <span class="gender-badge gender-perempuan">
                                <i class="fas fa-venus"></i> Perempuan
                            </span>
                        @else
                            <span class="gender-badge gender-laki">
                                <i class="fas fa-mars"></i> Laki-laki
                            </span>
                        @endif
                    </div>
                </div>
                <div class="sd-info-item">
                    <div class="sd-info-label">Tempat Lahir</div>
                    <div class="sd-info-value {{ $birthPlace === '-' ? 'muted' : '' }}">
                        {{ $birthPlace === '-' ? 'Belum diisi' : $birthPlace }}
                    </div>
                </div>
                <div class="sd-info-item">
                    <div class="sd-info-label">Tanggal Lahir</div>
                    <div class="sd-info-value {{ !$birthDate ? 'muted' : '' }}">
                        @if($birthDate)
                            {{ \Carbon\Carbon::parse($birthDate)->translatedFormat('d F Y') }}
                            <span style="font-size:.8rem; color:#6B7280; font-weight:400;">
                                ({{ \Carbon\Carbon::parse($birthDate)->age }} tahun)
                            </span>
                        @else
                            Belum diisi
                        @endif
                    </div>
                </div>
                <div class="sd-info-item">
                    <div class="sd-info-label">Jenjang</div>
                    <div class="sd-info-value">
                        <span style="display:inline-block; padding:2px 12px; border-radius:999px; font-size:.85rem; {{ $jenjangStyle }}">
                            {{ $jenjang }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="sd-info-full">
                <div class="sd-info-label">Alamat Lengkap</div>
                <div class="sd-info-value {{ $address === '-' ? 'muted' : '' }}" style="line-height:1.6;">
                    {{ $address === '-' ? 'Belum diisi' : $address }}
                </div>
            </div>
        </div>

        {{-- Section: Kontak --}}
        <div class="sd-section">
            <div class="sd-section-head">
                <span class="sd-section-head-icon"><i class="fas fa-phone-alt"></i></span>
                Kontak & Komunikasi
            </div>
            <div class="sd-info-grid">
                <div class="sd-info-item">
                    <div class="sd-info-label">Email</div>
                    <div class="sd-info-value {{ $email === '-' ? 'muted' : '' }}">
                        @if($email !== '-')
                            <a href="mailto:{{ $email }}" style="color:#1F4D3B; text-decoration:none;">{{ $email }}</a>
                        @else
                            Belum diisi
                        @endif
                    </div>
                </div>
                <div class="sd-info-item">
                    <div class="sd-info-label">No. HP</div>
                    <div class="sd-info-value {{ $phone === '-' ? 'muted' : '' }}">
                        {{ $phone === '-' ? 'Belum diisi' : $phone }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Section: Orang Tua --}}
        <div class="sd-section">
            <div class="sd-section-head">
                <span class="sd-section-head-icon"><i class="fas fa-users"></i></span>
                Data Orang Tua / Wali
            </div>
            <div class="sd-info-grid">
                <div class="sd-info-item">
                    <div class="sd-info-label"><i class="fas fa-male me-1" style="color:#1D4ED8;opacity:.7;"></i> Nama Ayah</div>
                    <div class="sd-info-value {{ $fatherName === '-' ? 'muted' : '' }}">
                        {{ $fatherName === '-' ? 'Belum diisi' : $fatherName }}
                    </div>
                </div>
                <div class="sd-info-item">
                    <div class="sd-info-label"><i class="fas fa-female me-1" style="color:#9D174D;opacity:.7;"></i> Nama Ibu</div>
                    <div class="sd-info-value {{ $motherName === '-' ? 'muted' : '' }}">
                        {{ $motherName === '-' ? 'Belum diisi' : $motherName }}
                    </div>
                </div>
                <div class="sd-info-item">
                    <div class="sd-info-label">No. HP Orang Tua</div>
                    <div class="sd-info-value {{ $parentPhone === '-' ? 'muted' : '' }}">
                        @if($parentPhone !== '-')
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $parentPhone) }}" target="_blank"
                               style="color:#1F4D3B; text-decoration:none;">
                               <i class="fab fa-whatsapp me-1"></i>{{ $parentPhone }}
                            </a>
                        @else
                            Belum diisi
                        @endif
                    </div>
                </div>
                <div class="sd-info-item">
                    <div class="sd-info-label">Status Siswa</div>
                    <div class="sd-info-value">
                        <span style="display:inline-flex; align-items:center; gap:6px; padding:3px 12px; border-radius:999px; background:#ECFDF5; color:#059669; font-size:.85rem;">
                            <i class="fas fa-circle" style="font-size:.4rem;"></i> Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Note --}}
        <div class="sd-note">
            <div class="sd-note-icon"><i class="fas fa-info-circle"></i></div>
            <div>
                Halaman ini hanya menampilkan <strong>data administrasi siswa</strong>.
                Untuk melihat nilai siswa, gunakan menu <strong>Kelola Nilai</strong>.
            </div>
        </div>

    </div>
</div>
@endsection
