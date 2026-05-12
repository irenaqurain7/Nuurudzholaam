@extends('layouts.app')

@section('title', 'Informasi')

@section('content')
<!-- Hero Section -->
<div style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); position: relative; overflow: hidden; min-height: 300px; display: flex; align-items: center; justify-content: center;">
    <!-- Background Pattern -->
    <div style="position: absolute; top: -50%; right: -10%; width: 600px; height: 600px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; z-index: 0;"></div>
    <div style="position: absolute; bottom: -30%; left: 0; width: 400px; height: 400px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; z-index: 0;"></div>

    <div class="container" style="text-align: center; z-index: 10; position: relative;">
        <h1 style="font-size: 48px; color: white; margin-bottom: 15px; font-weight: bold;">Informasi & Pengumuman</h1>
        <p style="font-size: 18px; color: rgba(255, 255, 255, 0.95);">Dapatkan informasi terbaru seputar kegiatan dan pengumuman penting dari Al-Hikmah Academy</p>
    </div>
</div>

<!-- Main Content -->
<div style="background-color: #f8f9fa; padding: 60px 0;">
    <div class="container">
        <!-- Navigation Tabs -->
        <div style="display: flex; gap: 15px; margin-bottom: 40px; flex-wrap: wrap;">
            <a href="{{ route('informasi') }}" 
               style="padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: 600; background-color: {{ !isset($activeTipe) || $activeTipe === null ? 'var(--hijau-islam)' : '#e0e0e0' }}; color: {{ !isset($activeTipe) || $activeTipe === null ? 'white' : '#333' }}; transition: all 0.3s; border: 2px solid {{ !isset($activeTipe) || $activeTipe === null ? 'var(--hijau-islam)' : '#e0e0e0' }}; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-newspaper"></i> Berita
            </a>
            <a href="{{ route('informasi.tipe', 'penting') }}" 
               style="padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: 600; background-color: {{ isset($activeTipe) && $activeTipe === 'penting' ? 'var(--hijau-islam)' : '#e0e0e0' }}; color: {{ isset($activeTipe) && $activeTipe === 'penting' ? 'white' : '#333' }}; transition: all 0.3s; border: 2px solid {{ isset($activeTipe) && $activeTipe === 'penting' ? 'var(--hijau-islam)' : '#e0e0e0' }}; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-exclamation-circle"></i> Pengumuman Penting
            </a>
            <a href="{{ route('informasi.tipe', 'ppdb') }}" 
               style="padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: 600; background-color: {{ isset($activeTipe) && $activeTipe === 'ppdb' ? 'var(--hijau-islam)' : '#e0e0e0' }}; color: {{ isset($activeTipe) && $activeTipe === 'ppdb' ? 'white' : '#333' }}; transition: all 0.3s; border: 2px solid {{ isset($activeTipe) && $activeTipe === 'ppdb' ? 'var(--hijau-islam)' : '#e0e0e0' }}; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-graduation-cap"></i> PPDB
            </a>
            <a href="{{ route('informasi.tipe', 'libur') }}" 
               style="padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: 600; background-color: {{ isset($activeTipe) && $activeTipe === 'libur' ? 'var(--hijau-islam)' : '#e0e0e0' }}; color: {{ isset($activeTipe) && $activeTipe === 'libur' ? 'white' : '#333' }}; transition: all 0.3s; border: 2px solid {{ isset($activeTipe) && $activeTipe === 'libur' ? 'var(--hijau-islam)' : '#e0e0e0' }}; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-calendar-days"></i> Libur
            </a>
        </div>

        <!-- Announcements List -->
        @if($berita->count() > 0)
            <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                @foreach($berita as $item)
                    <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); transition: all 0.3s; border-left: 5px solid var(--hijau-islam);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                            <div>
                                <h3 style="color: var(--hijau-islam); margin: 0 0 8px 0; font-size: 22px; font-weight: bold;">{{ $item->judul }}</h3>
                                <div style="display: flex; gap: 15px; align-items: center; color: #999; font-size: 14px;">
                                    <span><i class="fas fa-calendar-alt"></i> {{ $item->tanggal_mulai->format('d M Y') }}</span>
                                    <span style="background: var(--emas); color: white; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; font-size: 12px; font-weight: 600;">
                                        @switch($item->tipe)
                                            @case('umum')
                                                Berita
                                                @break
                                            @case('penting')
                                                Penting
                                                @break
                                            @case('ppdb')
                                                PPDB
                                                @break
                                            @case('libur')
                                                Libur
                                                @break
                                        @endswitch
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p style="color: var(--text-light); line-height: 1.8; margin: 20px 0;">{{ Str::limit($item->konten, 300) }}</p>
                        <div style="border-top: 1px solid #eee; padding-top: 15px; text-align: right;">
                            @if($item->tanggal_selesai)
                                <small style="color: #999;">Berlaku hingga: <strong>{{ $item->tanggal_selesai->format('d M Y') }}</strong></small>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($berita->hasPages())
                <div style="margin-top: 40px; display: flex; justify-content: center; gap: 10px;">
                    {{ $berita->links() }}
                </div>
            @endif
        @else
            <div style="background: white; border-radius: 12px; padding: 60px; text-align: center; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);">
                <i style="font-size: 64px; color: #ccc; margin-bottom: 20px; display: block;"></i>
                <h3 style="color: var(--hijau-islam); margin-bottom: 10px; font-size: 22px;">Belum Ada Informasi</h3>
                <p style="color: var(--text-light); font-size: 16px;">Tidak ada informasi untuk kategori ini saat ini. Silakan cek kembali nanti atau pilih kategori lain.</p>
            </div>
        @endif
    </div>
</div>

<style>
    @media (max-width: 768px) {
        div[style*="display: flex; gap: 15px"] {
            flex-direction: column;
        }
        
        a[style*="padding: 12px 30px"] {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection
