@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<div class="hero-new" style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); position: relative; overflow: hidden; min-height: 600px; display: flex; align-items: center; justify-content: center;">
    <!-- Background Pattern -->
    <div style="position: absolute; top: -50%; right: -10%; width: 600px; height: 600px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; z-index: 0;"></div>
    <div style="position: absolute; bottom: -30%; left: 0; width: 400px; height: 400px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; z-index: 0;"></div>

    <div class="container" style="text-align: center; z-index: 10; position: relative;">
        <!-- Dynamic PPDB Status Badge -->
        @if($ppdbStatus === 'open')
            <div style="display: inline-block; background: rgba(46, 125, 50, 0.2); padding: 8px 20px; border-radius: 20px; margin-bottom: 30px; border: 2px solid rgba(46, 125, 50, 0.4);">
                <span style="color: #66bb6a; font-weight: 600; font-size: 14px;">
                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i>PENDAFTARAN DIBUKA
                </span>
            </div>
        @elseif($ppdbStatus === 'coming')
            <div style="display: inline-block; background: rgba(25, 118, 210, 0.2); padding: 8px 20px; border-radius: 20px; margin-bottom: 30px; border: 2px solid rgba(25, 118, 210, 0.4);">
                <span style="color: #64b5f6; font-weight: 600; font-size: 14px;">
                    <i class="fas fa-hourglass-start" style="margin-right: 8px;"></i>PENDAFTARAN AKAN DIBUKA
                </span>
            </div>
        @elseif($ppdbStatus === 'closed')
            <div style="display: inline-block; background: rgba(211, 47, 47, 0.2); padding: 8px 20px; border-radius: 20px; margin-bottom: 30px; border: 2px solid rgba(211, 47, 47, 0.4);">
                <span style="color: #ef5350; font-weight: 600; font-size: 14px;">
                    <i class="fas fa-times-circle" style="margin-right: 8px;"></i>PENDAFTARAN TELAH DITUTUP
                </span>
            </div>
        @else
            <div style="display: inline-block; background: rgba(212, 175, 55, 0.2); padding: 8px 20px; border-radius: 20px; margin-bottom: 30px;">
                <span style="color: var(--emas); font-weight: 600; font-size: 14px;">PENDAFTARAN PESERTA DIDIK BARU 2024/2025</span>
            </div>
        @endif

        <h1 style="font-size: 52px; color: white; margin-bottom: 20px; font-weight: bold; line-height: 1.3;">Membentuk Generasi Qurani dan Berakhlak Mulia</h1>
        <p style="font-size: 18px; color: rgba(255, 255, 255, 0.95); margin-bottom: 40px; line-height: 1.6;">SekolahNuurudzholaam menerapkan kurikulum berbasis alam sekitar yang memadukan pendikan formal sebagai pilihan strategis untuk menjawab kebutuhan masyarakat menghadapi tantangan zaman.</p>
        
        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            @if($ppdbStatus === 'open')
                <a href="{{ route('ppdb') }}" style="background-color: white; color: var(--hijau-islam); padding: 12px 35px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; border: 2px solid white;">
                    <i class="fas fa-edit" style="margin-right: 8px;"></i>Daftar Sekarang
                </a>
            @elseif($ppdbStatus === 'coming')
                <button disabled style="background-color: rgba(255,255,255,0.3); color: white; padding: 12px 35px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; border: 2px solid white; cursor: not-allowed; opacity: 0.6;">
                    <i class="fas fa-clock" style="margin-right: 8px;"></i>Pendaftaran Segera Dibuka
                </button>
            @elseif($ppdbStatus === 'closed')
                <button disabled style="background-color: rgba(255,255,255,0.3); color: white; padding: 12px 35px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; border: 2px solid white; cursor: not-allowed; opacity: 0.6;">
                    <i class="fas fa-lock" style="margin-right: 8px;"></i>Pendaftaran Ditutup
                </button>
            @else
                <button disabled style="background-color: rgba(255,255,255,0.3); color: white; padding: 12px 35px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; border: 2px solid white; cursor: not-allowed; opacity: 0.6;">
                    <i class="fas fa-ban" style="margin-right: 8px;"></i>Pendaftaran Tidak Aktif
                </button>
            @endif
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
                        <img src="{{ asset('storage/' . $school->gambar_utama) }}" alt="Sekolah Nuurudzholaam" style="width: 100%; border-radius: 12px; box-shadow: 0 12px 40px rgba(31, 127, 95, 0.15);">
                    @else
                        <img src="{{ asset('images/foto sekolah.jpeg') }}" alt="Sekolah Nuurudzholaam" style="width: 100%; height: 400px; object-fit: cover; border-radius: 12px; box-shadow: 0 12px 40px rgba(31, 127, 95, 0.15);">
                    @endif
                </div>
            </div>
            <div>
                <h2 style="font-size: 36px; color: var(--hijau-islam); margin-bottom: 15px; font-weight: bold;">Selamat Datang di <br><span style="color: var(--emas);">Sekolah Nuurudzholaam</span></h2>
                <p style="color: var(--text-light); line-height: 1.8; font-size: 16px; margin-bottom: 30px;">
                    @if($school && $school->deskripsi)
                        {!! nl2br(e($school->deskripsi)) !!}
                    @else
                        Nuurudzholaam didirikan oleh A Dede Ali Asy'ari, S.Pd. Pada tahun 2012 dengan menerapkan kurikulum berbasis alam sekitar yang memadukan pendikan formal sebagai pilihan strategis untuk menjawab kebutuhan masyarakat menghadapi tantangan zaman.
                    @endif
                </p>
                <a href="{{ route('profil') }}" style="background-color: var(--hijau-islam); color: white; padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s;">Pelajari Lebih Lanjut →</a>
            </div>
        </div>
    </div>
</div>

<!-- Four Pillars Section -->
<div class="section" style="background-color: #f7fafc;">
    <div class="container">
        <h2 style="font-size: 36px; text-align: center; color: var(--hijau-islam); margin-bottom: 15px; font-weight: bold;">Pilar Pendidikan Utama</h2>
        <p style="text-align: center; color: var(--text-light); margin-bottom: 25px; font-size: 16px; max-width: 600px; margin-left: auto; margin-right: auto;">Kami mengintegrasikan empat pilar fundamental untuk menciptakan pendidikan yang seimbang dan holistik.</p>

        @php
            $pilars = $school && !empty($school->pilar_pendidikan) ? $school->pilar_pendidikan : [
                ['icon' => 'fas fa-brain', 'judul' => 'Olah Pikir (Literasi)', 'deskripsi' => 'Mengasah daya pikir dan intelektual agar peserta didik memiliki pemikiran kritis, luas dan tajam.'],
                ['icon' => 'fas fa-heart', 'judul' => 'Olah Hati (Etika/Spiritual)', 'deskripsi' => 'Membina akhlak, moral dan budi pekerti luhur sehingga peserta didik menjadi individu yang berkarakter dan berintegritas.'],
                ['icon' => 'fas fa-palette', 'judul' => 'Olah Rasa (Estetika)', 'deskripsi' => 'Menumbuhkan kepekaan perasaan, welas asih dan apresiasi terhadap keindahan serta seni.'],
                ['icon' => 'fas fa-bolt', 'judul' => 'Olah Karsa (Kinestetik/Kemauan)', 'deskripsi' => 'Mengembangkan kemauan keras, semangat juang, kreativitas dan inovasi.']
            ];
        @endphp

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            @foreach($pilars as $pilar)
            <div class="card" style="text-align: center; padding: 40px 30px; border-top: 4px solid var(--hijau-islam);">
                <div style="font-size: 48px; color: var(--hijau-islam); margin-bottom: 20px;">
                    <i class="{{ $pilar['icon'] ?? 'fas fa-star' }}"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 20px; margin-bottom: 15px; font-weight: bold;">{{ $pilar['judul'] ?? '' }}</h3>
                <p style="color: var(--text-light); line-height: 1.6;">{{ $pilar['deskripsi'] ?? '' }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Testimonial Section -->
<div class="section" style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); color: white;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center;">
            <div>
                <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: visible; padding: 20px;">
                    <img src="{{ asset('images/wiwi-suherti-s-pd.jpeg') }}" alt="Wiwi Suherti, S.Pd" style="max-width: 100%; max-height: 500px; width: auto; height: auto; object-fit: contain; border-radius: 12px;">
                </div>
            </div>
            <div>
                <h2 style="font-size: 32px; margin-bottom: 20px; font-weight: bold;">Selamat Datang di Nuurudzholaam</h2>
                <p style="font-size: 16px; line-height: 1.8; margin-bottom: 20px; opacity: 0.95;">
                    "Assalamu alaikum wa rahmatullahi wa barakatuh. Pal syukur semua akum atas kehadiran Anda di Sekolah Nuurudzholaam. Sekolah kami adalah tempat di mana nilai-nilai keagamaan dan pendidikan akademik berpadu sempurna untuk menciptakan generasi yang tidak hanya cerdas secara intelektual, tetapi juga kuat dalam iman dan akhlak."
                </p>
                <div>
                    <p style="font-weight: bold; margin-bottom: 5px;">Wiwi Suherti, S.Pd</p>
                    <p style="opacity: 0.9; font-size: 14px;">Kepala Sekolah Nuurudzholaam</p>
                </div>
            </div>
        </div>
    </div>
</div>

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
