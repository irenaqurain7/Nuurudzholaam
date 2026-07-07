@extends('layouts.app')

@section('title', 'Profil Sekolah')

@section('content')
<style>
    .profil-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .section {
        padding: 70px 20px;
    }

    .section-light {
        background-color: #f8fafc;
    }

    .section h2:first-child {
        margin-top: 0;
    }

    .hero-new {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
        padding: 100px 20px;
        text-align: center;
        color: white;
    }

    .hero-new h1 {
        font-size: 40px;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .hero-new p {
        font-size: 16px;
        opacity: 0.95;
    }

    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(31, 127, 95, 0.08);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(31, 127, 95, 0.15);
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 48px;
        align-items: center;
    }

    .grid-auto {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 28px;php
    }

    .teacher-card {
        text-align: center;
    }

    .teacher-photo {
        width: 160px;
        height: 160px;
        border-radius: 16px;
        overflow: hidden;
        margin: 0 auto 20px;
        box-shadow: 0 8px 24px rgba(31, 127, 95, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--hijau-islam), var(--emas));
    }

    .teacher-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .teacher-name {
        color: var(--hijau-islam);
        margin-bottom: 8px;
        font-weight: 700;
        font-size: 16px;
    }

    .teacher-role {
        color: var(--emas);
        font-weight: 600;
        font-size: 14px;
        margin: 0;
    }

    .history-text {
        color: var(--text-light);
        line-height: 1.8;
        font-size: 15px;
        margin-bottom: 16px;
    }

    .history-text:last-child {
        margin-bottom: 0;
    }

    h2 {
        font-size: 38px;
        text-align: center;
        color: var(--hijau-islam);
        margin-bottom: 16px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .sejarah-image {
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 12px 40px rgba(31, 127, 95, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .section-light h2 {
        color: var(--hijau-islam);
    }

    .section-subtitle {
        text-align: center;
        color: var(--text-light);
        margin-bottom: 48px;
        font-size: 15px;
        max-width: 580px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
        font-weight: 500;
    }

    .visi-misi-card {
        padding: 44px 32px;
        text-align: center;
    }

    .visi-misi-icon {
        font-size: 48px;
        margin-bottom: 20px;
    }

    .visi-misi-title {
        color: var(--hijau-islam);
        font-size: 22px;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .visi-misi-content {
        color: var(--text-light);
        line-height: 1.8;
        font-size: 15px;
        text-align: left;
    }

    .visi-misi-content ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .visi-misi-content li {
        margin-bottom: 12px;
    }

    .cta-section {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
        color: white;
        padding: 70px 20px;
        text-align: center;
    }

    .cta-section h2 {
        color: white;
        font-size: 38px;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .cta-section p {
        font-size: 16px;
        margin-bottom: 30px;
        opacity: 0.95;
    }

    .cta-btn {
        background-color: white;
        color: var(--hijau-islam);
        padding: 14px 40px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        transition: all 0.3s;
        font-size: 16px;
    }

    .cta-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .grid-2 {
            grid-template-columns: 1fr;
            gap: 32px;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 12px;
        }

        .section {
            padding: 50px 20px;
        }

        .section-subtitle {
            margin-bottom: 36px;
            font-size: 14px;
        }
    }
</style>

<!-- Hero Section -->
<div class="hero-new">
    <div class="profil-container">
        <h1>Profil Sekolah</h1>
        <p>Mengenal lebih dekat sekolah nuurudzholaam, tempat di mana tradisi keilmuan berpadu dengan standar pendidikan modern berkualitas tinggi</p>
    </div>
</div>

<!-- Sejarah Singkat -->
<div class="section">
    <div class="profil-container">
        <div class="grid-2">
            <div>
                <h2 style="text-align: left; margin-bottom: 24px;">Sejarah Singkat</h2>
                <div class="history-text">
                    @if($school && $school->deskripsi)
                        {!! nl2br(e($school->deskripsi)) !!}
                    @else
                        Sekolah Nuurudzholaam didirikan dengan semangat untuk menghadirkan inovasi pendidikan yang tidak hanya akademis namun juga mengintegrasikan nilai-nilai keislaman. Kami percaya bahwa pendidikan adalah investasi terbaik untuk masa depan generasi bangsa.
                    @endif
                </div>
            </div>
            <div>
                @if($school && $school->gambar_utama)
                    <img src="{{ asset('storage/' . $school->gambar_utama) }}" alt="Sekolah Nuurudzholaam" class="sejarah-image">
                @else
                    <img src="{{ asset('images/foto sejarah sekolah.jpeg') }}" alt="Sejarah Sekolah Nuurudzholaam" class="sejarah-image" style="height: 400px; object-fit: cover;">
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Visi & Misi -->
<div class="section section-light">
    <div class="profil-container">
        <h2>Visi & Misi</h2>
        <p class="section-subtitle">Kompass perjalanan Sekolah Nuurudzholaam dalam mendidik generasi Qur'ani dan berakhlak mulia</p>

        <div class="grid-2">
            <div class="card visi-misi-card">
                <div class="visi-misi-icon" style="color: var(--hijau-islam);">
                    <i class="fas fa-eye"></i>
                </div>
                <h3 class="visi-misi-title">Visi</h3>
                <p class="visi-misi-content" style="text-align: center;">
                    @if($school && $school->visi)
                        {!! nl2br(e($school->visi)) !!}
                    @else
                        Terwujudnya pribadi siswa siswi yang beriman bertaqwa. berakhlak mulia, kreatif, sehat, cerdas dan memiliki kesiapan fisik maupun mental dalam memasuki pendidikan lebih lanjut.
                    @endif
                </p>
            </div>

            <div class="card visi-misi-card">
                <div class="visi-misi-icon" style="color: var(--emas);">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3 class="visi-misi-title">Misi</h3>
                <div class="visi-misi-content">
                    @if($school && $school->misi)
                        <div style="margin: 0;">{!! nl2br(e($school->misi)) !!}</div>
                    @else
                        <p style="margin-bottom: 12px;">Mewujudkan cita-cita luhur sekolah nuurudzholaam berupa :</p>
                        <ul>
                            <li>1. Menanamkan keimanan & taqwa kepada Allah SWT. serta sikap dan perilaku yang mulia kepada anak</li>
                            <li>2. Meningkatkan kecerdasan/kemampuan siswa siswi melalui kegiatan interaktif sambil belajar yang menyenangkan</li>
                            <li>3. Meningkatkan kesadaran, kemampuan dan berpartisipasi aktif kepada masyarakat dalam memberikan layanan pendidikan sekolah</li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tim Pengajar & Manajemen -->
<div class="section section-light">
    <div class="profil-container">
        <h2>Tenaga Pendidik</h2>
        <p class="section-subtitle">Pilar utama kesuksesan Sekolah Nuurudzholaam adalah tenaga pendidik yang berdedikasi tinggi.</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 30px;">
            @if($teachers->count() > 0)
                @foreach($teachers as $teacher)
                    <div class="teacher-card">
                        <div class="teacher-photo">
                            @if($teacher->user && $teacher->user->profile_photo)
                                <img src="{{ asset('storage/' . $teacher->user->profile_photo) }}" alt="{{ $teacher->user->name }}">
                            @else
                                <i class="fas fa-user" style="color: white; font-size: 70px;"></i>
                            @endif
                        </div>
                        <h4 class="teacher-name">{{ $teacher->user->name ?? 'Tenaga Pendidik' }}</h4>
                        <p class="teacher-role">{{ $teacher->specialization ?? 'Tenaga Pendidik Nuurudzholaam' }}</p>
                    </div>
                @endforeach
            @else
                @foreach($defaultTeachers as $teacher)
                    <div style="text-align: center;">
                        <div style="width: 150px; height: 150px; border-radius: 18px; overflow: hidden; margin: 0 auto 20px; box-shadow: 0 8px 24px rgba(31, 127, 95, 0.15);">
                            @if($teacher->photo)
                                @php
                                    $photoName = $teacher->photo;
                                    $candidates = [];
                                    if (!empty($photoName)) {
                                        $candidates[] = $photoName;
                                        $base = pathinfo($photoName, PATHINFO_FILENAME);
                                        $ext = pathinfo($photoName, PATHINFO_EXTENSION);
                                        $candidates[] = \Illuminate\Support\Str::slug($base, '-') . '.' . $ext;
                                        $candidates[] = \Illuminate\Support\Str::slug($base, '_') . '.' . $ext;
                                        $candidates[] = preg_replace('/[.,]+/', '', $photoName);
                                    }
                                    $found = false;
                                    foreach ($candidates as $cand) {
                                        if (empty($cand)) continue;
                                        if (file_exists(public_path('images/' . $cand))) {
                                            $photoName = $cand;
                                            $found = true;
                                            break;
                                        }
                                    }
                                @endphp
                                <img src="{{ asset('images/' . urlencode($photoName)) }}" alt="{{ $teacher->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            @else
                                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--hijau-islam), var(--emas)); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <h4 style="color: var(--hijau-islam); margin-bottom: 8px; font-weight: bold;">{{ $teacher->name }}</h4>
                        <p style="color: var(--emas); font-weight: 600; font-size: 14px; margin: 0;">{{ $teacher->role }}</p>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="cta-section">
    <div class="profil-container">
        <h2>Siap Bergabung dengan Sekolah Nuurudzholaam?</h2>
        <p>Jadilah bagian dari komunitas pembelajar yang dinamis dan bermimpi besar untuk masa depan</p>
        <a href="{{ route('ppdb') }}" class="cta-btn">Daftar Sekarang →</a>
    </div>
</div>

@endsection
