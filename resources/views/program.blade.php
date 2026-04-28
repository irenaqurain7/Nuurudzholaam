@extends('layouts.app')

@section('title', 'Program Studi Kami')

@section('content')
<!-- Hero Section -->
<div class="hero">
    <div class="container">
        <h1>Program Studi Kami</h1>
        <p>Pilih program yang sesuai dengan minat dan kemampuan Anda</p>
    </div>
</div>

<!-- Main Content -->
<div class="section">
    <div class="container">
        @if($programs->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px;">
            @foreach($programs as $program)
            <div class="card">
                @if($program->gambar)
                <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}" class="card-img">
                @else
                <div style="width: 100%; height: 250px; background: linear-gradient(135deg, var(--hijau-islam), var(--emas)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 64px; margin-bottom: 20px;">
                    <i class="fas fa-book"></i>
                </div>
                @endif
                
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <h3 class="card-title" style="margin: 0;">{{ $program->nama_program }}</h3>
                        <p style="color: var(--hijau-islam); font-weight: 600; font-size: 14px; margin: 5px 0 0 0;">
                            <i class="fas fa-users"></i> Kuota: {{ $program->kuota }} siswa
                        </p>
                    </div>
                </div>

                <p class="card-text">{{ $program->deskripsi }}</p>

                @if($program->kurikulum)
                <div style="background-color: #f7fafc; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid var(--emas);">
                    <h4 style="color: var(--hijau-islam); margin: 0 0 10px 0; font-size: 14px;">Kurikulum:</h4>
                    <p style="margin: 0; font-size: 14px; color: var(--text-light); line-height: 1.6;">{{ $program->kurikulum }}</p>
                </div>
                @endif

                <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                    <a href="{{ route('ppdb') }}" class="btn-primary" style="width: 100%; text-align: center;">
                        <i class="fas fa-user-plus"></i> Daftar Program Ini
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align: center; padding: 80px 20px;">
            <i class="fas fa-inbox" style="font-size: 64px; color: var(--hijau-islam-lighter); margin-bottom: 20px; opacity: 0.5;"></i>
            <h3 style="color: var(--text-light); margin-bottom: 10px;">Program belum tersedia</h3>
            <p style="color: var(--text-light);">Program studi akan ditampilkan di sini. Silakan kembali lagi kemudian.</p>
        </div>
        @endif
    </div>
</div>

<!-- Features Section -->
<div class="section" style="background-color: #f7fafc;">
    <div class="container">
        <h2 class="section-title">Keunggulan Program Kami</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
            <div style="text-align: center;">
                <div style="font-size: 48px; color: var(--hijau-islam); margin-bottom: 15px;">
                    <i class="fas fa-chalkboard-user"></i>
                </div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 10px;">Guru Berpengalaman</h4>
                <p style="color: var(--text-light);">Guru-guru kami memiliki pengalaman mengajar lebih dari 10 tahun dan terus mengikuti perkembangan pendidikan terkini.</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 48px; color: var(--hijau-islam); margin-bottom: 15px;">
                    <i class="fas fa-book-open"></i>
                </div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 10px;">Kurikulum Modern</h4>
                <p style="color: var(--text-light);">Kurikulum kami mengintegrasikan nilai-nilai islami dengan pendidikan akademik berkualitas internasional.</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 48px; color: var(--hijau-islam); margin-bottom: 15px;">
                    <i class="fas fa-building"></i>
                </div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 10px;">Fasilitas Lengkap</h4>
                <p style="color: var(--text-light);">Laboratorium sains, perpustakaan modern, lab komputer, dan ruang multimedia tersedia untuk menunjang pembelajaran.</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 48px; color: var(--hijau-islam); margin-bottom: 15px;">
                    <i class="fas fa-mosque"></i>
                </div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 10px;">Lingkungan Islami</h4>
                <p style="color: var(--text-light);">Suasana sekolah mencerminkan nilai-nilai islami dengan penuh kedisiplinan, ketertiban, dan akhlak yang baik.</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 48px; color: var(--hijau-islam); margin-bottom: 15px;">
                    <i class="fas fa-trophy"></i>
                </div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 10px;">Prestasi Tinggi</h4>
                <p style="color: var(--text-light);">Siswa kami secara konsisten meraih prestasi akademik dan non-akademik di tingkat nasional dan internasional.</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 48px; color: var(--hijau-islam); margin-bottom: 15px;">
                    <i class="fas fa-users-gear"></i>
                </div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 10px;">Pembimbingan Personal</h4>
                <p style="color: var(--text-light);">Setiap siswa mendapatkan perhatian khusus dan bimbingan personal dari mentor yang berpengalaman.</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); color: white; padding: 60px 20px; text-align: center;">
    <div class="container">
        <h2 style="font-size: 36px; margin-bottom: 20px; font-weight: bold;">Tertarik dengan Program Kami?</h2>
        <p style="font-size: 18px; margin-bottom: 30px; opacity: 0.95;">Hubungi kami sekarang untuk mendapatkan informasi lebih detail atau langsung mendaftar!</p>
        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('ppdb') }}" class="btn-primary">Daftar Sekarang</a>
            <a href="{{ route('kontak') }}" class="btn-secondary">Hubungi Kami</a>
        </div>
    </div>
</div>

@endsection
