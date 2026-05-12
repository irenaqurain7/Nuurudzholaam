@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<div class="hero-new" style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); position: relative; overflow: hidden; min-height: 600px; display: flex; align-items: center; justify-content: center;">
    <!-- Background Pattern -->
    <div style="position: absolute; top: -50%; right: -10%; width: 600px; height: 600px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; z-index: 0;"></div>
    <div style="position: absolute; bottom: -30%; left: 0; width: 400px; height: 400px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; z-index: 0;"></div>

    <div class="container" style="text-align: center; z-index: 10; position: relative;">
        <div style="display: inline-block; background: rgba(212, 175, 55, 0.2); padding: 8px 20px; border-radius: 20px; margin-bottom: 30px;">
            <span style="color: var(--emas); font-weight: 600; font-size: 14px;">PENDAFTARAN PESERTA DIDIK BARU 2024/2025</span>
        </div>
        <h1 style="font-size: 52px; color: white; margin-bottom: 20px; font-weight: bold; line-height: 1.3;">Membentuk Generasi Qurani dan Berakhlak Mulia</h1>
        <p style="font-size: 18px; color: rgba(255, 255, 255, 0.95); margin-bottom: 40px; line-height: 1.6;">Al-Hikmah Academy mengabungkan kurikulum nasional berkualitas dengan pendidikan nilai agama dan takhfidz Al-Qur'an untuk menciptakan pemimpin masa depan yang berkarakter</p>
        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('ppdb') }}" style="background-color: white; color: var(--hijau-islam); padding: 12px 35px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; border: 2px solid white;">Daftar Sekarang</a>
            <a href="{{ route('profil') }}" style="background-color: transparent; color: white; padding: 12px 35px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; border: 2px solid white;">Lihat Program</a>
        </div>
    </div>
</div>

<!-- Welcome Section -->
<div class="section" style="background-color: white;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center;">
            <div>
                <div style="position: relative;">
                    @if($school && $school->gambar_utama)
                        <img src="{{ asset('storage/' . $school->gambar_utama) }}" alt="Al-Hikmah Academy" style="width: 100%; border-radius: 12px; box-shadow: 0 12px 40px rgba(31, 127, 95, 0.15);">
                    @else
                        <div style="width: 100%; height: 400px; background: linear-gradient(135deg, var(--hijau-islam), var(--emas)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 80px; box-shadow: 0 12px 40px rgba(31, 127, 95, 0.15);">
                            <i class="fas fa-school"></i>
                        </div>
                    @endif
                </div>
            </div>
            <div>
                <h2 style="font-size: 36px; color: var(--hijau-islam); margin-bottom: 15px; font-weight: bold;">Selamat Datang di <br><span style="color: var(--emas);">Al-Hikmah Academy</span></h2>
                <p style="color: var(--text-light); line-height: 1.8; font-size: 16px; margin-bottom: 20px;">
                    Assalamu alaikum wa rahmatullahi wa barakatuh. Pal syukur semua akum atas kehadiran Anda di Al-Hikmah Academy. Sekolah kami berkomitmen untuk menciptakan pendidikan yang holistik dengan menggabungkan standar akademik internasional dengan nilai-nilai keislaman.
                </p>
                <p style="color: var(--text-light); line-height: 1.8; font-size: 16px; margin-bottom: 30px;">
                    Di tengah perkembangan zaman modern, kami meyakini perlunya keseimbangan antara ilmu pengetahuan, keterampilan abad 21, dan pemahaman mendalam tentang agama Islam untuk menghasilkan generasi yang tidak hanya cerdas secara akademis namun juga berakhlak mulia.
                </p>
                <a href="{{ route('profil') }}" style="background-color: var(--hijau-islam); color: white; padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s;">Pelajari Lebih Lanjut →</a>
            </div>
        </div>
    </div>
</div>

<!-- Four Pillars Section -->
<div class="section" style="background-color: #f7fafc;">
    <div class="container">
        <h2 style="font-size: 36px; text-align: center; color: var(--hijau-islam); margin-bottom: 50px; font-weight: bold;">Pilar Pendidikan Utama</h2>
        <p style="text-align: center; color: var(--text-light); margin-bottom: 40px; font-size: 16px; max-width: 600px; margin-left: auto; margin-right: auto;">Kami mengintegrasikan empat pilar fundamental untuk menciptakan pendidikan yang seimbang dan holistik.</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            <div class="card" style="text-align: center; padding: 40px 30px; border-top: 4px solid var(--hijau-islam);">
                <div style="font-size: 48px; color: var(--hijau-islam); margin-bottom: 20px;">
                    <i class="fas fa-book"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 20px; margin-bottom: 15px; font-weight: bold;">Program Tahfidz Terpadu</h3>
                <p style="color: var(--text-light); line-height: 1.6;">Program menghafal Al-Qur'an dengan metode talaqi dan muroja'ah, didampingi oleh asatidz berpengalaman.</p>
            </div>

            <div class="card" style="text-align: center; padding: 40px 30px; border-top: 4px solid var(--emas-light);">
                <div style="font-size: 48px; color: var(--emas-light); margin-bottom: 20px;">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 20px; margin-bottom: 15px; font-weight: bold;">Pembinaan Karakter</h3>
                <p style="color: var(--text-light); line-height: 1.6;">Pembangunan akhlak mulia, kedisiplinan, dan kepemimpinan sejak dini untuk masa depan yang cerah.</p>
            </div>

            <div class="card" style="text-align: center; padding: 40px 30px; border-top: 4px solid var(--hijau-islam-light);">
                <div style="font-size: 48px; color: var(--hijau-islam-light); margin-bottom: 20px;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 20px; margin-bottom: 15px; font-weight: bold;">Kurikulum Integratif</h3>
                <p style="color: var(--text-light); line-height: 1.6;">Perpaduan kurikulum nasional dengan kearifan lokal dan standar internasional untuk pembelajaran berkelanjutan.</p>
            </div>

            <div class="card" style="text-align: center; padding: 40px 30px; border-top: 4px solid var(--text-dark);">
                <div style="font-size: 48px; color: var(--text-dark); margin-bottom: 20px;">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 20px; margin-bottom: 15px; font-weight: bold;">Pengembangan Bakat</h3>
                <p style="color: var(--text-light); line-height: 1.6;">Program ekstrakurikuler beragam untuk mengasah bakat, minat, dan potensi unik setiap siswa.</p>
            </div>
        </div>
    </div>
</div>

<!-- Testimonial Section -->
<div class="section" style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); color: white;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center;">
            <div>
                <div style="width: 100%; height: 350px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    <img src="{{ asset('images/testimonial-placeholder.jpg') }}" alt="Kepala Sekolah" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
            <div>
                <h2 style="font-size: 32px; margin-bottom: 20px; font-weight: bold;">Selamat Datang di Al-Hikmah Academy</h2>
                <p style="font-size: 16px; line-height: 1.8; margin-bottom: 20px; opacity: 0.95;">
                    "Assalamu alaikum wa rahmatullahi wa barakatuh. Pal syukur semua akum atas kehadiran Anda di Al-Hikmah Academy. Sekolah kami adalah tempat di mana nilai-nilai keagamaan dan pendidikan akademik berpadu sempurna untuk menciptakan generasi yang tidak hanya cerdas secara intelektual, tetapi juga kuat dalam iman dan akhlak."
                </p>
                <div>
                    <p style="font-weight: bold; margin-bottom: 5px;">Ugi. H. Ahmad Farwuz, M.Pd</p>
                    <p style="opacity: 0.9; font-size: 14px;">Kepala Sekolah Al-Hikmah Academy</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Programs Preview Section -->
@if($programs->count() > 0)
<div class="section" style="background-color: white;">
    <div class="container">
        <h2 style="font-size: 36px; text-align: center; color: var(--hijau-islam); margin-bottom: 15px; font-weight: bold;">Program Pendidikan Unggulan</h2>
        <p style="text-align: center; color: var(--text-light); margin-bottom: 40px; font-size: 16px;">Membentuk generasi Qur'ani yang berakhlak mulia, cerdas, dan tangguh melalui perpadian kurikulum nasional dengan nilai-nilai Islam yang komprehensif.</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            @foreach($programs->take(3) as $program)
            <div class="card" style="overflow: hidden; transition: all 0.3s;">
                @if($program->gambar)
                    <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}" style="width: 100%; height: 200px; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 200px; background: linear-gradient(135deg, var(--hijau-islam), var(--emas)); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                        <i class="fas fa-book"></i>
                    </div>
                @endif
                <div style="padding: 25px;">
                    <h3 style="color: var(--hijau-islam); font-size: 20px; margin-bottom: 10px; font-weight: bold;">{{ $program->nama_program }}</h3>
                    <p style="color: var(--text-light); line-height: 1.6; margin-bottom: 15px;">{{ Str::limit($program->deskripsi, 80) }}</p>
                    <p style="color: var(--hijau-islam); font-weight: 600; font-size: 14px;">
                        <i class="fas fa-users"></i> Target Lulusan: {{ $program->kuota }} siswa
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="{{ route('program') }}" style="background-color: var(--hijau-islam); color: white; padding: 12px 35px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s;">Lihat Semua Program →</a>
        </div>
    </div>
</div>
@endif

<!-- Gallery Section -->
@if($galleries->count() > 0)
<div class="section" style="background-color: #f7fafc;">
    <div class="container">
        <h2 style="font-size: 36px; text-align: center; color: var(--hijau-islam); margin-bottom: 50px; font-weight: bold;">Galeri Kegiatan Siswa</h2>
        <p style="text-align: center; color: var(--text-light); margin-bottom: 40px; font-size: 16px; max-width: 600px; margin-left: auto; margin-right: auto;">Potret keseharian siswa dalam menuntut ilmu dan beraktivitas</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            @foreach($galleries->take(6) as $photo)
            <div style="position: relative; overflow: hidden; border-radius: 12px; height: 280px; cursor: pointer;">
                <img src="{{ asset('storage/' . $photo->gambar) }}" alt="{{ $photo->judul }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(31, 127, 95, 0.95), transparent); padding: 25px; color: white; opacity: 0; transition: opacity 0.3s ease; height: 100%; display: flex; flex-direction: column; justify-content: flex-end;" class="photo-overlay">
                    <h4 style="margin: 0; font-size: 18px; font-weight: bold;">{{ $photo->judul }}</h4>
                    <p style="font-size: 12px; margin: 5px 0 0 0; opacity: 0.9;">{{ $photo->tanggal->format('d M Y') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .photo-overlay:hover {
        opacity: 1 !important;
    }

    .section > .container > div[style*="grid"] > div:hover img {
        transform: scale(1.05);
    }
</style>
@endif

<!-- CTA Section -->
<div style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); color: white; padding: 80px 20px; text-align: center;">
    <div class="container">
        <h2 style="font-size: 40px; margin-bottom: 20px; font-weight: bold;">Mulai Perjalanan Mulia Anda Bersama Kami</h2>
        <p style="font-size: 18px; margin-bottom: 30px; opacity: 0.95; line-height: 1.6;">Pendaftaran untuk tahun ajaran baru telah dibuka. Kuota terbatas untuk memastikan kualitas pembelajaran yang optimal</p>
        <a href="{{ route('ppdb') }}" style="background-color: white; color: var(--hijau-islam); padding: 14px 40px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; font-size: 16px;">Daftar Sekarang →</a>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Add hover effect to photo gallery
    document.querySelectorAll('.photo-overlay').forEach(overlay => {
        overlay.parentElement.addEventListener('mouseenter', function() {
            overlay.style.opacity = '1';
            this.querySelector('img').style.transform = 'scale(1.1)';
        });
        overlay.parentElement.addEventListener('mouseleave', function() {
            overlay.style.opacity = '0';
            this.querySelector('img').style.transform = 'scale(1)';
        });
    });
</script>
@endpush
