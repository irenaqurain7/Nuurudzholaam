@extends('layouts.app')

@section('title', 'Program Pendidikan')

@section('content')
<!-- Hero Section -->
<div class="hero-new" style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); padding: 100px 20px; text-align: center; color: white;">
    <div class="container">
        <h1 style="font-size: 40px; margin-bottom: 15px; font-weight: bold;">Program Pendidikan</h1>
        <p style="font-size: 16px; opacity: 0.95;">Kami mengintegrasikan empat pilar fundamental untuk menciptakan pendidikan yang seimbang dan holistik.</p>
    </div>
</div>

<!-- Four Pillars Section -->
<div class="section" style="background-color: #f7fafc;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            @forelse($programs as $program)
                <div class="card" style="text-align: center; padding: 40px 30px; border-top: 4px solid var(--hijau-islam);">
                    <div style="font-size: 48px; color: var(--hijau-islam); margin-bottom: 20px;">
                        @if($program->gambar)
                            <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama_program }}" style="width: 64px; height: 64px; object-fit: cover; border-radius: 8px;">
                        @else
                            <i class="fas fa-book-open"></i>
                        @endif
                    </div>
                    <h3 style="color: var(--hijau-islam); font-size: 20px; margin-bottom: 15px; font-weight: bold;">{{ $program->nama_program }}</h3>
                    <div class="program-desc-container">
                        <p class="desc-short" id="desc-short-{{ $program->id }}" style="color: var(--text-light); line-height: 1.6; margin-bottom: 0;">
                            {{ Str::limit($program->deskripsi, 150) }}
                            @if(strlen($program->deskripsi) > 150)
                                <br><a href="javascript:void(0)" onclick="toggleDesc({{ $program->id }}, true)" style="color: var(--hijau-islam); font-weight: 600; text-decoration: none; font-size: 14px; display: inline-block; margin-top: 5px;">Lihat detail <i class="fas fa-chevron-down" style="font-size: 12px; margin-left: 3px;"></i></a>
                            @endif
                        </p>
                        <p class="desc-full" id="desc-full-{{ $program->id }}" style="color: var(--text-light); line-height: 1.6; margin-bottom: 0; display: none; text-align: left;">
                            {{ $program->deskripsi }}
                            <br><a href="javascript:void(0)" onclick="toggleDesc({{ $program->id }}, false)" style="color: var(--hijau-islam); font-weight: 600; text-decoration: none; font-size: 14px; display: inline-block; margin-top: 5px;"><i class="fas fa-chevron-up" style="font-size: 12px; margin-right: 3px;"></i> Tutup detail</a>
                        </p>
                    </div>
                </div>
            @empty
                <div class="card" style="text-align: center; padding: 40px 30px; border-top: 4px solid var(--text-light); grid-column: 1 / -1;">
                    <p style="color: var(--text-light); line-height: 1.6;">Belum ada program pendidikan yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- CTA Section -->
<div style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); color: white; padding: 80px 20px; text-align: center;">
    <div class="container">
        <h2 style="font-size: 36px; margin-bottom: 15px; font-weight: bold;">Mulai Perjalanan Mulia Anda</h2>
        <p style="font-size: 16px; margin-bottom: 30px; opacity: 0.95;">Bergabunglah dengan ribuan siswa yang telah merasakan pendidikan berkualitas di Sekolah Nuurudzholaam</p>
        <a href="{{ route('ppdb') }}" style="background-color: white; color: var(--hijau-islam); padding: 14px 40px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; font-size: 16px;">Daftar Sekarang →</a>
    </div>
</div>

@push('scripts')
<script>
    function toggleDesc(id, showFull) {
        const shortDesc = document.getElementById('desc-short-' + id);
        const fullDesc = document.getElementById('desc-full-' + id);
        
        if (showFull) {
            shortDesc.style.display = 'none';
            fullDesc.style.display = 'block';
        } else {
            fullDesc.style.display = 'none';
            shortDesc.style.display = 'block';
        }
    }
</script>
@endpush

@endsection
