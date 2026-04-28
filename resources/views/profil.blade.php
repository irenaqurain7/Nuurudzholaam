@extends('layouts.app')

@section('title', 'Profil Sekolah')

@section('content')
<!-- Hero Section -->
<div class="hero">
    <div class="container">
        <h1>Profil Sekolah Kami</h1>
        <p>Mengenal lebih dekat Sekolah Islam Nuurudzholaam</p>
    </div>
</div>

<!-- Main Content -->
<div class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: start; margin-bottom: 80px;">
            <!-- Left Column -->
            <div>
                <h2 style="color: var(--hijau-islam); font-size: 32px; margin-bottom: 20px; font-weight: bold;">
                    <span style="display: inline-block; width: 4px; height: 40px; background: var(--emas); margin-right: 15px; border-radius: 2px;"></span>
                    {{ $school->nama_sekolah ?? 'Sekolah Islam Nuurudzholaam' }}
                </h2>
                
                <p style="color: var(--text-light); line-height: 1.8; font-size: 16px; margin-bottom: 30px;">
                    {{ $school->deskripsi ?? 'Sekolah kami berkomitmen untuk memberikan pendidikan berkualitas dengan nuansa islami yang kuat.' }}
                </p>

                @if($school->visi)
                <div class="card mb-30">
                    <h3 style="color: var(--hijau-islam); margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-eye" style="color: var(--emas);"></i>
                        Visi Kami
                    </h3>
                    <p style="margin: 0; color: var(--text-light); line-height: 1.8;">{{ $school->visi }}</p>
                </div>
                @endif

                @if($school->misi)
                <div class="card">
                    <h3 style="color: var(--hijau-islam); margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-bullseye" style="color: var(--emas);"></i>
                        Misi Kami
                    </h3>
                    <p style="margin: 0; color: var(--text-light); line-height: 1.8;">{{ $school->misi }}</p>
                </div>
                @endif
            </div>

            <!-- Right Column -->
            <div>
                @if($school->gambar_utama)
                <img src="{{ asset('storage/' . $school->gambar_utama) }}" alt="Sekolah" style="width: 100%; border-radius: 12px; box-shadow: 0 12px 30px rgba(31, 127, 95, 0.15); margin-bottom: 30px;">
                @else
                <div style="width: 100%; height: 400px; background: linear-gradient(135deg, var(--hijau-islam), var(--emas)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 80px; margin-bottom: 30px; box-shadow: 0 12px 30px rgba(31, 127, 95, 0.15);">
                    <i class="fas fa-school"></i>
                </div>
                @endif

                <div class="card">
                    <h3 style="color: var(--hijau-islam); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-info-circle" style="color: var(--emas);"></i>
                        Informasi Kontak
                    </h3>
                    <div style="display: grid; gap: 15px;">
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            <i class="fas fa-map-marker-alt" style="color: var(--hijau-islam); margin-top: 3px; min-width: 20px;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--hijau-islam); margin: 0 0 5px 0;">Alamat</p>
                                <p style="color: var(--text-light); margin: 0;">{{ $school->alamat ?? 'Jl. Pendidikan No. 123' }}</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            <i class="fas fa-phone" style="color: var(--hijau-islam); margin-top: 3px; min-width: 20px;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--hijau-islam); margin: 0 0 5px 0;">Telepon</p>
                                <p style="color: var(--text-light); margin: 0;">
                                    <a href="tel:{{ $school->no_telepon }}" style="color: inherit; text-decoration: none;">{{ $school->no_telepon }}</a>
                                </p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            <i class="fas fa-envelope" style="color: var(--hijau-islam); margin-top: 3px; min-width: 20px;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--hijau-islam); margin: 0 0 5px 0;">Email</p>
                                <p style="color: var(--text-light); margin: 0;">
                                    <a href="mailto:{{ $school->email }}" style="color: inherit; text-decoration: none;">{{ $school->email }}</a>
                                </p>
                            </div>
                        </div>
                        @if($school->website)
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            <i class="fas fa-globe" style="color: var(--hijau-islam); margin-top: 3px; min-width: 20px;"></i>
                            <div>
                                <p style="font-weight: 600; color: var(--hijau-islam); margin: 0 0 5px 0;">Website</p>
                                <p style="color: var(--text-light); margin: 0;">
                                    <a href="{{ $school->website }}" target="_blank" style="color: inherit; text-decoration: none;">{{ $school->website }}</a>
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Section -->
        @if($galleries->count() > 0)
        <h2 class="section-title">Galeri Sekolah</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 80px;">
            @foreach($galleries as $photo)
            <div style="position: relative; overflow: hidden; border-radius: 12px; height: 250px; cursor: pointer;">
                <img src="{{ asset('storage/' . $photo->gambar) }}" alt="{{ $photo->judul }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(31, 127, 95, 0.9), transparent); padding: 20px; color: white; opacity: 0; transition: opacity 0.3s ease; height: 100%; display: flex; flex-direction: column; justify-content: flex-end;">
                    <h4 style="margin: 0 0 5px 0; font-size: 16px;">{{ $photo->judul }}</h4>
                    <p style="font-size: 12px; margin: 0;">{{ $photo->tanggal->format('d M Y') }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<!-- Statistics Section -->
<div class="section" style="background-color: #f7fafc;">
    <div class="container">
        <h2 class="section-title">Pencapaian Kami</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 40px; text-align: center;">
            <div>
                <div style="font-size: 56px; font-weight: bold; color: var(--hijau-islam); margin-bottom: 15px;">20+</div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 10px; font-size: 18px;">Tahun Pengalaman</h4>
                <p style="color: var(--text-light);">Melayani pendidikan dengan dedikasi penuh</p>
            </div>
            <div>
                <div style="font-size: 56px; font-weight: bold; color: var(--hijau-islam); margin-bottom: 15px;">5000+</div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 10px; font-size: 18px;">Lulusan Sukses</h4>
                <p style="color: var(--text-light);">Tersebar di universitas ternama</p>
            </div>
            <div>
                <div style="font-size: 56px; font-weight: bold; color: var(--hijau-islam); margin-bottom: 15px;">150+</div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 10px; font-size: 18px;">Siswa Aktif</h4>
                <p style="color: var(--text-light);">Belajar dalam lingkungan islami</p>
            </div>
            <div>
                <div style="font-size: 56px; font-weight: bold; color: var(--hijau-islam); margin-bottom: 15px;">50+</div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 10px; font-size: 18px;">Guru Profesional</h4>
                <p style="color: var(--text-light);">Bersertifikat dan berpengalaman</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); color: white; padding: 60px 20px; text-align: center;">
    <div class="container">
        <h2 style="font-size: 36px; margin-bottom: 20px; font-weight: bold;">Jadilah Bagian dari Keluarga Besar Kami</h2>
        <p style="font-size: 18px; margin-bottom: 30px; opacity: 0.95;">Daftarkan diri Anda sekarang dan raih kesempatan terbaik untuk masa depan yang cerah!</p>
        <a href="{{ route('ppdb') }}" class="btn-primary">Daftar PPDB</a>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Add hover effect to gallery
    document.querySelectorAll('[style*="position: absolute"]').forEach(overlay => {
        const parent = overlay.parentElement;
        parent.addEventListener('mouseenter', function() {
            overlay.style.opacity = '1';
            this.querySelector('img').style.transform = 'scale(1.1)';
        });
        parent.addEventListener('mouseleave', function() {
            overlay.style.opacity = '0';
            this.querySelector('img').style.transform = 'scale(1)';
        });
    });
</script>
@endpush
