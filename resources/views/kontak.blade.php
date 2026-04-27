@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('content')
<!-- Hero Section -->
<div class="hero">
    <div class="container">
        <h1>Hubungi Kami</h1>
        <p>Kami siap membantu menjawab semua pertanyaan Anda</p>
    </div>
</div>

<!-- Main Content -->
<div class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; margin-bottom: 60px;">
            <!-- Contact Info -->
            <div>
                <h2 class="section-title" style="text-align: left;">Informasi Kontak</h2>

                <div class="card mb-30">
                    <h3 style="color: var(--hijau-islam); margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-map-marker-alt" style="font-size: 24px; color: var(--emas);"></i>
                        Alamat
                    </h3>
                    <p style="color: var(--text-light); line-height: 1.8; margin: 0;">
                        {{ $school->alamat ?? 'Jl. Pendidikan No. 123, Kota, Indonesia' }}
                    </p>
                </div>

                <div class="card mb-30">
                    <h3 style="color: var(--hijau-islam); margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-phone" style="font-size: 24px; color: var(--emas);"></i>
                        Telepon
                    </h3>
                    <p style="color: var(--text-light); line-height: 1.8; margin: 0;">
                        <a href="tel:{{ $school->no_telepon }}" style="color: inherit; text-decoration: none; font-weight: 600;">{{ $school->no_telepon }}</a>
                    </p>
                    <p style="color: var(--text-light); margin: 10px 0 0 0; font-size: 14px;">Tersedia Senin-Jumat, 08:00-16:00 WIB</p>
                </div>

                <div class="card mb-30">
                    <h3 style="color: var(--hijau-islam); margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-envelope" style="font-size: 24px; color: var(--emas);"></i>
                        Email
                    </h3>
                    <p style="color: var(--text-light); line-height: 1.8; margin: 0;">
                        <a href="mailto:{{ $school->email }}" style="color: inherit; text-decoration: none; font-weight: 600;">{{ $school->email }}</a>
                    </p>
                </div>

                <div class="card">
                    <h3 style="color: var(--hijau-islam); margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-share-alt" style="font-size: 24px; color: var(--emas);"></i>
                        Media Sosial
                    </h3>
                    <div style="display: grid; gap: 12px;">
                        <a href="#" style="display: flex; align-items: center; gap: 12px; color: var(--text-light); text-decoration: none; transition: all 0.3s;">
                            <i class="fab fa-facebook" style="font-size: 24px; color: var(--hijau-islam);"></i>
                            <span>Facebook: Sekolah Islam Nuurudzholaam</span>
                        </a>
                        <a href="#" style="display: flex; align-items: center; gap: 12px; color: var(--text-light); text-decoration: none; transition: all 0.3s;">
                            <i class="fab fa-instagram" style="font-size: 24px; color: var(--hijau-islam);"></i>
                            <span>Instagram: @nuurudzholaam_school</span>
                        </a>
                        <a href="#" style="display: flex; align-items: center; gap: 12px; color: var(--text-light); text-decoration: none; transition: all 0.3s;">
                            <i class="fab fa-youtube" style="font-size: 24px; color: var(--hijau-islam);"></i>
                            <span>YouTube: Nuurudzholaam Channel</span>
                        </a>
                        <a href="#" style="display: flex; align-items: center; gap: 12px; color: var(--text-light); text-decoration: none; transition: all 0.3s;">
                            <i class="fab fa-whatsapp" style="font-size: 24px; color: var(--hijau-islam);"></i>
                            <span>WhatsApp: Hubungi Admin</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <h2 class="section-title" style="text-align: left;">Kirim Pesan</h2>

                @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle" style="font-size: 20px;"></i>
                    <div>
                        <strong>Terjadi kesalahan:</strong>
                        <ul style="margin-top: 10px; margin-left: 20px;">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle" style="font-size: 20px;"></i>
                    <div>
                        <strong>Sukses!</strong>
                        <p style="margin-top: 5px;">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('kontak.send') }}" class="card">
                    @csrf

                    <div class="form-group">
                        <label for="nama">Nama Lengkap *</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="subjek">Subjek *</label>
                        <input type="text" id="subjek" name="subjek" value="{{ old('subjek') }}" placeholder="Contoh: Pertanyaan tentang PPDB" required>
                    </div>

                    <div class="form-group">
                        <label for="pesan">Pesan *</label>
                        <textarea id="pesan" name="pesan" required placeholder="Tulis pesan Anda di sini...">{{ old('pesan') }}</textarea>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%; padding: 15px; font-size: 16px;">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>

                <div style="margin-top: 30px; padding: 20px; background-color: #d1ecf1; border-radius: 8px; border-left: 4px solid #17a2b8;">
                    <p style="color: #0c5460; margin: 0;">
                        <i class="fas fa-info-circle"></i> <strong>Tip:</strong> Kami biasanya merespons dalam waktu 24 jam. Terima kasih telah menghubungi kami!
                    </p>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div style="background-color: #f7fafc; padding: 40px; border-radius: 12px; margin-bottom: 60px;">
            <h2 class="section-title">Lokasi Kami</h2>
            <div style="width: 100%; height: 400px; background: linear-gradient(135deg, var(--hijau-islam-lighter), var(--emas-light)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px;">
                <div style="text-align: center;">
                    <i class="fas fa-map" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                    <p>Peta akan ditampilkan di sini</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
