@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<div class="hero">
    <div class="container" style="text-align: center; z-index: 10;">
        <h1>Selamat Datang di Sekolah Islam Nuurudzholaam</h1>
        <p>Mendidik Generasi Islami yang Berkualitas dan Berakhlak Mulia</p>
        <div style="margin-top: 30px; display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('ppdb') }}" class="btn-primary">Daftar Sekarang</a>
            <a href="{{ route('profil') }}" class="btn-secondary">Pelajari Lebih Lanjut</a>
        </div>
    </div>
</div>

<!-- Announcements Section -->
@if($announcements->count() > 0)
<div class="section" style="background-color: #f7fafc;">
    <div class="container">
        <h2 class="section-title">Pengumuman Terbaru</h2>
        <div class="grid-responsive">
            @foreach($announcements as $announcement)
            <div class="card">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <span class="badge">{{ ucfirst($announcement->tipe) }}</span>
                </div>
                <h3 class="card-title">{{ $announcement->judul }}</h3>
                <p class="card-text">{{ Str::limit($announcement->konten, 150) }}</p>
                <p style="font-size: 13px; color: #999; margin-top: 15px;">
                    <i class="fas fa-calendar"></i> {{ $announcement->tanggal_mulai->format('d M Y') }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Statistics Section -->
<div class="section">
    <div class="container">
        <div class="grid-responsive-2" style="text-align: center;">
            <div>
                <div style="font-size: 48px; font-weight: bold; color: var(--hijau-islam); margin-bottom: 15px;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 20px; margin-bottom: 10px;">{{ $programs->count() }} Program</h3>
                <p style="color: var(--text-light);">Program studi berkualitas dengan kurikulum Islami</p>
            </div>
            <div>
                <div style="font-size: 48px; font-weight: bold; color: var(--hijau-islam); margin-bottom: 15px;">
                    <i class="fas fa-book"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 20px; margin-bottom: 10px;">Kurikulum Modern</h3>
                <p style="color: var(--text-light);">Menggabungkan pendidikan akademik dan nilai-nilai islami</p>
            </div>
            <div>
                <div style="font-size: 48px; font-weight: bold; color: var(--hijau-islam); margin-bottom: 15px;">
                    <i class="fas fa-users"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 20px; margin-bottom: 10px;">Guru Profesional</h3>
                <p style="color: var(--text-light);">Tenaga pendidik berpengalaman dan berdedikasi</p>
            </div>
            <div>
                <div style="font-size: 48px; font-weight: bold; color: var(--hijau-islam); margin-bottom: 15px;">
                    <i class="fas fa-mosque"></i>
                </div>
                <h3 style="color: var(--hijau-islam); font-size: 20px; margin-bottom: 10px;">Lingkungan Islami</h3>
                <p style="color: var(--text-light);">Suasana nyaman untuk belajar dan berkembang</p>
            </div>
        </div>
    </div>
</div>

<!-- Programs Section -->
<div class="section" style="background-color: #f7fafc;">
    <div class="container">
        <h2 class="section-title">Program Kami</h2>
        <div class="grid-responsive">
            @foreach($programs as $program)
            <div class="card">
                @if($program->gambar)
                <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}" class="card-img">
                @else
                <div style="width: 100%; height: 200px; background: linear-gradient(135deg, var(--hijau-islam), var(--emas)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; margin-bottom: 20px;">
                    <i class="fas fa-book"></i>
                </div>
                @endif
                <h3 class="card-title">{{ $program->nama_program }}</h3>
                <p class="card-text">{{ Str::limit($program->deskripsi, 100) }}</p>
                <p style="color: var(--hijau-islam); font-weight: 600; margin-top: 15px;">
                    <i class="fas fa-users"></i> Kuota: {{ $program->kuota }} siswa
                </p>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-40">
            <a href="{{ route('program') }}" class="btn-primary">Lihat Semua Program</a>
        </div>
    </div>
</div>

<!-- Latest Activities -->
@if($activities->count() > 0)
<div class="section">
    <div class="container">
        <h2 class="section-title">Kegiatan Terbaru</h2>
        <div class="grid-responsive">
            @foreach($activities as $activity)
            <div class="card">
                @if($activity->gambar)
                <img src="{{ asset('storage/' . $activity->gambar) }}" alt="{{ $activity->judul }}" class="card-img">
                @else
                <div style="width: 100%; height: 200px; background: linear-gradient(135deg, var(--hijau-islam-light), var(--emas-light)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; margin-bottom: 20px;">
                    <i class="fas fa-camera"></i>
                </div>
                @endif
                <span class="badge">{{ ucfirst($activity->kategori) }}</span>
                <h3 class="card-title">{{ $activity->judul }}</h3>
                <p class="card-text">{{ Str::limit($activity->deskripsi, 100) }}</p>
                <p style="font-size: 13px; color: #999; margin-top: 15px;">
                    <i class="fas fa-calendar"></i> {{ $activity->tanggal->format('d M Y') }}
                </p>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-40">
            <a href="{{ route('kegiatan') }}" class="btn-primary">Lihat Semua Kegiatan</a>
        </div>
    </div>
</div>
@endif

<!-- Gallery Section -->
@if($galleries->count() > 0)
<div class="section" style="background-color: #f7fafc;">
    <div class="container">
        <h2 class="section-title">Galeri Foto</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            @foreach($galleries as $photo)
            <div style="position: relative; overflow: hidden; border-radius: 12px; height: 250px; cursor: pointer; group;">
                <img src="{{ asset('storage/' . $photo->gambar) }}" alt="{{ $photo->judul }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(31, 127, 95, 0.9), transparent); padding: 20px; color: white; opacity: 0; transition: opacity 0.3s ease; height: 100%; display: flex; flex-direction: column; justify-content: flex-end;" class="photo-overlay">
                    <h4>{{ $photo->judul }}</h4>
                    <p style="font-size: 12px;">{{ $photo->tanggal->format('d M Y') }}</p>
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
</style>
@endif

<!-- CTA Section -->
<div style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); color: white; padding: 80px 20px; text-align: center; margin-top: 50px;">
    <div class="container">
        <h2 style="font-size: 40px; margin-bottom: 20px; font-weight: bold;">Siap Bergabung dengan Kami?</h2>
        <p style="font-size: 18px; margin-bottom: 30px; opacity: 0.95;">Pendaftaran PPDB dibuka sepanjang tahun. Jangan lewatkan kesempatan emas ini!</p>
        <a href="{{ route('ppdb') }}" class="btn-primary">Daftar Sekarang</a>
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
