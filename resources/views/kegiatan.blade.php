@extends('layouts.app')

@section('title', 'Kegiatan dan Dokumentasi')

@section('content')
<!-- Hero Section -->
<div class="hero">
    <div class="container">
        <h1>Kegiatan dan Dokumentasi</h1>
        <p>Ikuti perkembangan dan kegiatan menarik di sekolah kami</p>
    </div>
</div>

<!-- Main Content -->
<div class="section">
    <div class="container">
        <h2 class="section-title">Kegiatan Sekolah</h2>

        @if($activities->count() > 0)
        <div class="grid-responsive">
            @foreach($activities as $activity)
            <div class="card">
                @if($activity->gambar)
                <img src="{{ asset('storage/' . $activity->gambar) }}" alt="{{ $activity->judul }}" class="card-img" style="cursor: pointer;" onclick="openLightbox(this.src, '{{ addslashes($activity->judul) }}')">
                @else
                <div style="width: 100%; height: 200px; background: linear-gradient(135deg, var(--hijau-islam-light), var(--emas-light)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; margin-bottom: 20px;">
                    <i class="fas fa-camera"></i>
                </div>
                @endif
                <span class="badge">{{ ucfirst($activity->kategori) }}</span>
                <h3 class="card-title">{{ $activity->judul }}</h3>
                <p class="card-text">{{ Str::limit($activity->deskripsi, 150) }}</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                    <p style="font-size: 13px; color: #999; margin: 0;">
                        <i class="fas fa-calendar"></i> {{ $activity->tanggal->format('d M Y') }}
                    </p>
                    <a href="javascript:void(0);" style="color: var(--hijau-islam); font-weight: 600; text-decoration: none; transition: all 0.3s;">
                        <i class="fas fa-arrow-right"></i> Lihat
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="display: flex; justify-content: center; gap: 10px; margin-top: 50px;">
            {{ $activities->links() }}
        </div>
        @else
        <div style="text-align: center; padding: 80px 20px;">
            <i class="fas fa-inbox" style="font-size: 64px; color: var(--hijau-islam-lighter); margin-bottom: 20px; opacity: 0.5;"></i>
            <h3 style="color: var(--text-light); margin-bottom: 10px;">Belum ada kegiatan</h3>
            <p style="color: var(--text-light);">Kegiatan dan dokumentasi akan ditampilkan di sini. Silakan kembali lagi kemudian.</p>
        </div>
        @endif
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.9); z-index: 10000; align-items: center; justify-content: center;">
    <button onclick="closeLightbox()" style="position: absolute; top: 20px; right: 30px; background: none; border: none; color: white; font-size: 28px; cursor: pointer; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">
        <i class="fas fa-times"></i>
    </button>
    <div style="display: flex; flex-direction: column; align-items: center; gap: 20px; max-width: 90%;">
        <img id="lightbox-img" src="" alt="" style="max-width: 100%; max-height: 80vh; border-radius: 8px;">
        <p id="lightbox-title" style="color: white; font-size: 18px; margin: 0;"></p>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openLightbox(src, title) {
        document.getElementById('lightbox').style.display = 'flex';
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox-title').textContent = title;
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close lightbox when clicking outside the image
    document.getElementById('lightbox').addEventListener('click', function(e) {
        if(e.target === this) {
            closeLightbox();
        }
    });

    // Close lightbox with Escape key
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') {
            closeLightbox();
        }
    });
</script>
@endpush
