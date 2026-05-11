@extends('layouts.app')

@section('title', 'Program Studi Kami')

@section('content')
<!-- Hero Section -->
<div class="hero-new" style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); padding: 100px 20px; text-align: center; color: white;">
    <div class="container">
        <h1 style="font-size: 40px; margin-bottom: 15px; font-weight: bold;">Program Pendidikan Unggulan</h1>
        <p style="font-size: 16px; opacity: 0.95;">Membentuk generasi Qur'ani yang berakhlak mulia, cerdas, dan tangguh melalui perpaduan kurikulum nasional dengan nilai-nilai Islam yang komprehensif.</p>
    </div>
</div>

<!-- Main Content -->
<div class="section" style="background-color: white;">
    <div class="container">
        @if($programs->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px;">
                @foreach($programs as $program)
                <div class="card" style="overflow: hidden; transition: all 0.3s; border-top: 4px solid var(--hijau-islam);">
                    @if($program->gambar)
                        <div style="width: 100%; height: 250px; overflow: hidden;">
                            <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;">
                        </div>
                    @else
                        <div style="width: 100%; height: 250px; background: linear-gradient(135deg, var(--hijau-islam), var(--emas)); display: flex; align-items: center; justify-content: center; color: white; font-size: 64px;">
                            <i class="fas fa-book"></i>
                        </div>
                    @endif
                    
                    <div style="padding: 30px;">
                        <h3 style="color: var(--hijau-islam); font-size: 24px; margin: 0 0 15px 0; font-weight: bold;">{{ $program->nama_program }}</h3>
                        
                        <p style="color: var(--text-light); line-height: 1.6; margin-bottom: 20px; font-size: 15px;">{{ $program->deskripsi }}</p>

                        @if($program->kurikulum)
                        <div style="background-color: #f7fafc; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid var(--emas);">
                            <h4 style="color: var(--hijau-islam); margin: 0 0 10px 0; font-size: 14px; font-weight: bold;">Kurikulum:</h4>
                            <p style="margin: 0; font-size: 13px; color: var(--text-light); line-height: 1.6;">{{ $program->kurikulum }}</p>
                        </div>
                        @endif

                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                            <i class="fas fa-users" style="color: var(--hijau-islam); font-size: 16px;"></i>
                            <p style="color: var(--hijau-islam); font-weight: 600; font-size: 14px; margin: 0;">Target Lulusan: <strong>{{ $program->kuota }} siswa</strong></p>
                        </div>

                        <a href="{{ route('ppdb') }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; background-color: var(--hijau-islam); color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; transition: all 0.3s; width: 100%; border: none; cursor: pointer; font-size: 15px;">
                            <i class="fas fa-user-plus"></i> Daftar Program Ini
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
        <div style="text-align: center; padding: 80px 20px;">
            <i class="fas fa-inbox" style="font-size: 64px; color: var(--hijau-islam-lighter); margin-bottom: 20px; opacity: 0.5;"></i>
            <h3 style="color: var(--text-light); margin-bottom: 10px; font-size: 24px;">Program belum tersedia</h3>
            <p style="color: var(--text-light);">Program studi akan ditampilkan di sini. Silakan kembali lagi kemudian.</p>
        </div>
        @endif
    </div>
</div>

<!-- CTA Section -->
<div style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); color: white; padding: 80px 20px; text-align: center;">
    <div class="container">
        <h2 style="font-size: 36px; margin-bottom: 15px; font-weight: bold;">Tertarik dengan Salah Satu Program?</h2>
        <p style="font-size: 16px; margin-bottom: 30px; opacity: 0.95;">Daftarkan diri Anda sekarang dan mulai perjalanan pendidikan berkualitas bersama kami</p>
        <a href="{{ route('ppdb') }}" style="background-color: white; color: var(--hijau-islam); padding: 14px 40px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; font-size: 16px;">Daftar Sekarang →</a>
    </div>
</div>

@endsection
