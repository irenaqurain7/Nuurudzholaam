@extends('layouts.app')

@section('title', 'Profil Sekolah')

@section('content')
<!-- Hero Section -->
<div class="hero-new" style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); padding: 100px 20px; text-align: center; color: white;">
    <div class="container">
        <h1 style="font-size: 40px; margin-bottom: 15px; font-weight: bold;">Profil Sekolah</h1>
        <p style="font-size: 16px; opacity: 0.95;">Mengenal lebih dekat sekolah nuurudzholaam, tempat di mana tradisi keilmuan berpadu dengan standar pendidikan modern berkualitas tinggi</p>
    </div>
</div>

<!-- Sejarah Singkat -->
<div class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center;">
            <div>
                <h2 style="font-size: 32px; color: var(--hijau-islam); margin-bottom: 25px; font-weight: bold;">Sejarah Singkat</h2>
                <p style="color: var(--text-light); line-height: 1.8; font-size: 15px; margin-bottom: 20px;">
                    Sekolah Nuurudzholaam didirikan dengan semangat untuk menghadirkan inovasi pendidikan yang tidak hanya akademis namun juga mengintegrasikan nilai-nilai keislaman. Kami percaya bahwa pendidikan adalah investasi terbaik untuk masa depan generasi bangsa.
                </p>
                <p style="color: var(--text-light); line-height: 1.8; font-size: 15px; margin-bottom: 20px;">
                    Perjalanan kami dimulai dengan komitmen teguh terhadap kualitas pembelajaran dan pengembangan karakter. Fasilitas kami dibangun dengan konsistensi teguh terhadap kualitas pengajaran yang menghangatkan dan mempersiapkan setiap siswa untuk menjadi pemimpin masa depan yang berani, bijaksana, dan bermoral.
                </p>
                <p style="color: var(--text-light); line-height: 1.8; font-size: 15px;">
                    Saat ini, dengan ratusan siswa dari berbagai latar belakang keluarga, kami terus berinovasi dan berkembang guna memberikan pendidikan terbaik yang dapat membentuk generasi yang tidak hanya cerdas secara intelektual namun juga kuat dalam iman dan akhlak.
                </p>
            </div>
            <div>
                @if($school && $school->gambar_utama)
                    <img src="{{ asset('storage/' . $school->gambar_utama) }}" alt="Al-Hikmah Academy" style="width: 100%; border-radius: 12px; box-shadow: 0 12px 40px rgba(31, 127, 95, 0.15);">
                @else
                    <div style="width: 100%; height: 400px; background: linear-gradient(135deg, var(--hijau-islam), var(--emas)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 80px; box-shadow: 0 12px 40px rgba(31, 127, 95, 0.15);">
                        <i class="fas fa-school"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Visi & Misi -->
<div class="section" style="background-color: #f7fafc;">
    <div class="container">
        <h2 style="font-size: 36px; text-align: center; color: var(--hijau-islam); margin-bottom: 50px; font-weight: bold;">Visi & Misi</h2>
        <p style="text-align: center; color: var(--text-light); margin-bottom: 40px; font-size: 16px; max-width: 600px; margin-left: auto; margin-right: auto;">Kompass perjalanan Sekolah Nuurudzholaam dalam mendidik generasi Qur'ani dan berakhlak mulia</p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
            <div class="card" style="text-align: center;">
                <div style="font-size: 48px; color: var(--hijau-islam); margin-bottom: 20px;">
                    <i class="fas fa-eye"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 22px; margin-bottom: 15px; font-weight: bold;">Visi</h3>
                <p style="color: var(--text-light); line-height: 1.8; font-size: 15px; margin: 0;">
                    @if($school && $school->visi)
                        "{{ $school->visi }}"
                    @else
                        Terwujudnya pribadi anak yang beriman bertaqwa. berakhlak mulia, kreatif, sehat, cerdas dan memiliki kesiapan fisik maupun mental dalam memasuki pendidikan lebih lanjut.
                    @endif
                </p>
            </div>

            <div class="card" style="text-align: center;">
                <div style="font-size: 48px; color: var(--emas-light); margin-bottom: 20px;">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 22px; margin-bottom: 15px; font-weight: bold;">Misi</h3>
                <div style="color: var(--text-light); line-height: 1.8; font-size: 14px; text-align: left;">
                    @if($school && $school->misi)
                        <p style="margin: 0;">{{ $school->misi }}</p>
                    @else
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            <li style="margin-bottom: 10px;">• Mengembangkan pesantren berkualitas dalam ilmu agama, umum dan teknologi informasi dan komunikasi berlandaskan ahlakul karimah.</li>
                            <li style="margin-bottom: 10px;">• Mengembangkan SDM secara mandiri untuk memajukan pesantren melalui kewirausahaan (Entrepreneurship).</li>
                            <li style="margin-bottom: 10px;">• Mengembangkan pesantren yang memiliki jiwa kepemimpinan (Leadership).</li>
                            <li style="margin-bottom: 10px;">• Mengembangkan pesantren yang berwawasan keagamaan dan kebangsaan</li>
                            <li>• Mengembangkan pesantren yang berkehidupan Tertib dan Disiplin.</li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Keunggulan Kami -->
<div class="section">
    <div class="container">
        <h2 style="font-size: 36px; text-align: center; color: var(--hijau-islam); margin-bottom: 50px; font-weight: bold;">Keunggulan Kami</h2>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
            <div class="card" style="text-align: center; padding: 40px 30px; border-top: 4px solid var(--hijau-islam);">
                <div style="font-size: 48px; color: var(--hijau-islam); margin-bottom: 20px;">
                    <i class="fas fa-book"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 18px; margin-bottom: 15px; font-weight: bold;">Lingkungan Islami</h3>
                <p style="color: var(--text-light); line-height: 1.6;">Ekosistem sekolah yang mendukung pembentukan akhlak dan ketakwaan melalui pendekatan terintegrasi</p>
            </div>

            <div class="card" style="text-align: center; padding: 40px 30px; border-top: 4px solid var(--emas-light);">
                <div style="font-size: 48px; color: var(--emas-light); margin-bottom: 20px;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 18px; margin-bottom: 15px; font-weight: bold;">Kurikulum Integratif</h3>
                <p style="color: var(--text-light); line-height: 1.6;">Perpaduan sempurna antara kurikulum nasional dan nilai-nilai agama Islam yang komprehensif</p>
            </div>

            <div class="card" style="text-align: center; padding: 40px 30px; border-top: 4px solid var(--hijau-islam-light);">
                <div style="font-size: 48px; color: var(--hijau-islam-light); margin-bottom: 20px;">
                    <i class="fas fa-users"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 18px; margin-bottom: 15px; font-weight: bold;">Guru Berdedikasi</h3>
                <p style="color: var(--text-light); line-height: 1.6;">Tenaga pendidik profesional yang berkomitmen untuk membantu setiap siswa mencapai potensi maksimal</p>
            </div>
        </div>
    </div>
</div>

<!-- Tim Pengajar & Manajemen -->
<div class="section" style="background-color: #f7fafc;">
    <div class="container">
        <h2 style="font-size: 36px; text-align: center; color: var(--hijau-islam); margin-bottom: 50px; font-weight: bold;">Tenaga Pendidik</h2>
        <p style="text-align: center; color: var(--text-light); margin-bottom: 40px; font-size: 16px; max-width: 600px; margin-left: auto; margin-right: auto;">Pilar utama kesuksesan Sekolah Nuurudzholaam adalah tenaga pendidik yang berdedikasi tinggi.</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 30px;">
            {{-- Display teachers from database with profile photos --}}
            @if($teachers->count() > 0)
                @foreach($teachers as $teacher)
                    <div style="text-align: center;">
                        <div style="width: 150px; height: 150px; border-radius: 18px; overflow: hidden; margin: 0 auto 20px; box-shadow: 0 8px 24px rgba(31, 127, 95, 0.15);">
                            @if($teacher->user && $teacher->user->profile_photo)
                                <img src="{{ asset('storage/' . $teacher->user->profile_photo) }}" alt="{{ $teacher->user->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            @else
                                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--hijau-islam), var(--emas)); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <h4 style="color: var(--hijau-islam); margin-bottom: 8px; font-weight: bold;">{{ $teacher->user->name ?? 'Tenaga Pendidik' }}</h4>
                        <p style="color: var(--emas); font-weight: 600; font-size: 14px; margin: 0;">{{ $teacher->specialization ?? 'Tenaga Pendidik Nuurudzholaam' }}</p>
                    </div>
                @endforeach
            @endif
            
            {{-- Display default teachers from public/images/ --}}
            @foreach($defaultTeachers as $teacher)
                <div style="text-align: center;">
                    <div style="width: 150px; height: 150px; border-radius: 18px; overflow: hidden; margin: 0 auto 20px; box-shadow: 0 8px 24px rgba(31, 127, 95, 0.15);">
                        @if($teacher->photo && file_exists(public_path('images/' . $teacher->photo)))
                            <img src="{{ asset('images/' . $teacher->photo) }}" alt="{{ $teacher->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
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

        </div>
    </div>
</div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); color: white; padding: 80px 20px; text-align: center;">
    <div class="container">
        <h2 style="font-size: 36px; margin-bottom: 15px; font-weight: bold;">Siap Bergabung dengan Sekolah Nuurudzholaam?</h2>
        <p style="font-size: 16px; margin-bottom: 30px; opacity: 0.95;">Jadilah bagian dari komunitas pembelajar yang dinamis dan bermimpi besar untuk masa depan</p>
        <a href="{{ route('ppdb') }}" style="background-color: white; color: var(--hijau-islam); padding: 14px 40px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; font-size: 16px;">Daftar Sekarang →</a>
    </div>
</div>

@endsection
