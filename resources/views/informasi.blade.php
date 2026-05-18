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
        @php
            $descriptions = [
                'penting' => 'Pengumuman penting terkait kebijakan, jadwal, dan informasi mendesak dari Sekolah Nuurudzholaam',
                'libur' => 'Pengumuman hari libur dan jadwal cuti sekolah dari Sekolah Nuurudzholaam'
            ];
            $tipeUntukDeskripsi = isset($activeTipe) ? $activeTipe : 'penting';
        @endphp

        <p style="font-size: 18px; color: rgba(255, 255, 255, 0.95);">
            {{ $descriptions[$tipeUntukDeskripsi] ?? $descriptions['penting'] }}
        </p>
    </div>
</div>

<!-- Main Content -->
<div style="background-color: #f8f9fa; padding: 60px 0;">
    <div class="container">
        <!-- Navigation Tabs removed from page; navigation remains available in navbar dropdown -->

        @php
            $titles = [
                'penting' => 'Pengumuman Penting',
                'libur' => 'Libur'
            ];
            $current = isset($activeTipe) ? ($titles[$activeTipe] ?? 'Pengumuman Penting') : 'Pengumuman Penting';
        @endphp

        <div style="margin: 30px 0 40px; text-align: left;">
            <h2 style="font-size: 28px; margin: 0 0 6px 0; font-weight: 700; color: var(--hijau-islam);">{{ $current }}</h2>
            <p style="margin: 0; color: var(--text-light);">{{ $descriptions[isset($activeTipe) ? $activeTipe : 'penting'] ?? 'Informasi terbaru dari Sekolah Nuurudzholaam' }}</p>
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
                                            @case('penting')
                                                Penting
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
