@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('content')
<!-- Hero Section -->
<div style="background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%); padding: 100px 20px; text-align: center; color: white;">
    <div class="container">
        <h1 style="font-size: 2.5rem; margin-bottom: 15px; font-weight: 700; letter-spacing: -0.5px;">Hubungi Kami</h1>
        <p style="font-size: 16px; opacity: 0.9; line-height: 1.6;">Kami siap melayani pertanyaan Anda seputar program pendidikan, pendaftaran, dan informasi lainnya</p>
    </div>
</div>

<!-- Main Content -->
<div style="padding: 60px 20px; background-color: white;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 50px; margin-bottom: 60px;">
            <!-- Contact Info Column -->
            <div>
                <h2 style="font-size: 1.75rem; color: var(--hijau-islam); margin-bottom: 35px; font-weight: 700;">Informasi Kontak</h2>

                <!-- Address Card -->
                <div style="background: white; border: 1px solid #e0e7ff; border-left: 4px solid var(--hijau-islam); border-radius: 8px; padding: 25px; margin-bottom: 20px; transition: all 0.3s;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 12px;">
                        <i class="fas fa-map-marker-alt" style="font-size: 24px; color: var(--emas); width: 32px; text-align: center;"></i>
                        <h3 style="color: var(--hijau-islam); margin: 0; font-weight: 600; font-size: 1rem;">Alamat</h3>
                    </div>
                    <p style="color: var(--text-light); line-height: 1.6; margin: 0 0 0 47px; font-size: 0.95rem;">
                        {{ $school->alamat ?? 'Jl. Sindangreret, Dangdeur, Kec. Bungursari, Kab. Purwakarta, Jawa Barat 41181' }}
                    </p>
                </div>

                <!-- Phone Card -->
                <div style="background: white; border: 1px solid #e0e7ff; border-left: 4px solid var(--hijau-islam); border-radius: 8px; padding: 25px; margin-bottom: 20px; transition: all 0.3s;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 12px;">
                        <i class="fas fa-phone" style="font-size: 24px; color: var(--emas); width: 32px; text-align: center;"></i>
                        <h3 style="color: var(--hijau-islam); margin: 0; font-weight: 600; font-size: 1rem;">Telepon / WhatsApp</h3>
                    </div>
                    <p style="color: var(--text-light); margin: 0 0 0 47px; font-size: 0.95rem;">
                        <a href="tel:{{ $school->no_telepon }}" style="color: var(--hijau-islam); text-decoration: none; font-weight: 600; transition: color 0.3s;">{{ $school->no_telepon }}</a>
                    </p>
                    <p style="color: var(--text-light); margin: 8px 0 0 47px; font-size: 0.85rem; line-height: 1.6;">
                        085714673916 (Dede Ali)<br>
                        081958159264 (Wiwi Suherti)<br>
                        083816931133 (Ziun)
                    </p>
                </div>

                <!-- Email Card -->
                <div style="background: white; border: 1px solid #e0e7ff; border-left: 4px solid var(--hijau-islam); border-radius: 8px; padding: 25px; margin-bottom: 20px; transition: all 0.3s;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 12px;">
                        <i class="fas fa-envelope" style="font-size: 24px; color: var(--emas); width: 32px; text-align: center;"></i>
                        <h3 style="color: var(--hijau-islam); margin: 0; font-weight: 600; font-size: 1rem;">Email:</h3>
                    </div>
                    <p style="color: var(--text-light); margin: 0 0 0 47px; font-size: 0.95rem;">
                        <a href="mailto:{{ $school->email }}" style="color: var(--hijau-islam); text-decoration: none; font-weight: 400; transition: color 0.3s;">{{ $school->email }}Nuurudz@gmail.com</a>
                    </p>
                </div>

                <!-- Social Media Card -->
                <div style="background: white; border: 1px solid #e0e7ff; border-left: 4px solid var(--hijau-islam); border-radius: 8px; padding: 25px;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                        <i class="fas fa-share-alt" style="font-size: 24px; color: var(--emas); width: 32px; text-align: center;"></i>
                        <h3 style="color: var(--hijau-islam); margin: 0; font-weight: 600; font-size: 1rem;">Social media</h3>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-left: 47px;">
                        <a href="#" style="display: flex; align-items: center; gap: 10px; color: var(--hijau-islam); text-decoration: none; padding: 8px; border-radius: 6px; transition: all 0.3s; font-size: 0.95rem;">
                            <i class="fab fa-facebook-f" style="width: 18px; text-align: center;"></i> Ponpes Nuurudzholaam
                        </a>
                        <a href="#" style="display: flex; align-items: center; gap: 10px; color: var(--hijau-islam); text-decoration: none; padding: 8px; border-radius: 6px; transition: all 0.3s; font-size: 0.95rem;">
                            <i class="fab fa-instagram" style="width: 18px; text-align: center;"></i> Ponpes_Nuurudzholaam
                        </a>
                        <a href="#" style="display: flex; align-items: center; gap: 10px; color: var(--hijau-islam); text-decoration: none; padding: 8px; border-radius: 6px; transition: all 0.3s; font-size: 0.95rem;">
                            <i class="fab fa-youtube" style="width: 18px; text-align: center;"></i> Nuzo TV
                        </a>
                        <a href="#" style="display: flex; align-items: center; gap: 10px; color: var(--hijau-islam); text-decoration: none; padding: 8px; border-radius: 6px; transition: all 0.3s; font-size: 0.95rem;">
                            <i class="fab fa-tiktok" style="width: 18px; text-align: center;"></i>Media Nuzo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form Column -->
            <div>
                <h2 style="font-size: 1.75rem; color: var(--hijau-islam); margin-bottom: 35px; font-weight: 700;">Kirim Pesan</h2>

                @if ($errors->any())
                <div style="background-color: #fce4e6; border: 1px solid #f8bbd0; border-left: 4px solid #c62828; padding: 15px 20px; border-radius: 6px; margin-bottom: 25px; display: flex; gap: 12px;">
                    <i class="fas fa-exclamation-circle" style="font-size: 20px; color: #c62828; flex-shrink: 0; margin-top: 2px;"></i>
                    <div style="color: #c62828; font-size: 0.95rem;">
                        <strong>Terjadi kesalahan:</strong>
                        <ul style="margin: 10px 0 0 20px; padding: 0;">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                @if (session('success'))
                <div style="background-color: #e8f5e9; border: 1px solid #c8e6c9; border-left: 4px solid #2e7d32; padding: 15px 20px; border-radius: 6px; margin-bottom: 25px; display: flex; gap: 12px;">
                    <i class="fas fa-check-circle" style="font-size: 20px; color: #2e7d32; flex-shrink: 0; margin-top: 2px;"></i>
                    <div style="color: #2e7d32; font-size: 0.95rem;">
                        <strong>Berhasil!</strong>
                        <p style="margin: 5px 0 0 0;">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('kontak.send') }}" style="background: white; border: 1px solid #e0e7ff; border-radius: 8px; padding: 30px;">
                    @csrf

                    <div style="margin-bottom: 20px;">
                        <label for="nama" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">Nama Lengkap <span style="color: #d32f2f;">*</span></label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda" value="{{ old('nama') }}" required style="width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem; transition: border-color 0.3s;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="email" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">Alamat Email <span style="color: #d32f2f;">*</span></label>
                        <input type="email" id="email" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required style="width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem; transition: border-color 0.3s;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="subjek" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">Pilih Subjek <span style="color: #d32f2f;">*</span></label>
                        <select id="subjek" name="subjek" required style="width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem; transition: border-color 0.3s;">
                            <option value="">-- Pilih Subjek --</option>
                            <option value="Pertanyaan PPDB" @selected(old('subjek') === 'Pertanyaan PPDB')>Pertanyaan PPDB</option>
                            <option value="Informasi Program" @selected(old('subjek') === 'Informasi Program')>Informasi Program</option>
                            <option value="Pertanyaan Umum" @selected(old('subjek') === 'Pertanyaan Umum')>Pertanyaan Umum</option>
                            <option value="Kerjasama" @selected(old('subjek') === 'Kerjasama')>Kerjasama</option>
                            <option value="Lainnya" @selected(old('subjek') === 'Lainnya')>Lainnya</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 25px;">
                        <label for="pesan" style="display: block; color: var(--hijau-islam); font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">Pesan <span style="color: #d32f2f;">*</span></label>
                        <textarea id="pesan" name="pesan" placeholder="Tulis pesan Anda..." required style="width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem; height: 120px; resize: vertical; transition: border-color 0.3s;">{{ old('pesan') }}</textarea>
                    </div>

                    <button type="submit" style="background-color: var(--hijau-islam); color: white; width: 100%; padding: 12px 20px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.95rem; transition: all 0.3s;">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>

                <div style="margin-top: 25px; padding: 16px 20px; background-color: #e8f5e9; border-radius: 6px; border-left: 4px solid var(--hijau-islam); display: flex; gap: 12px;">
                    <i class="fas fa-info-circle" style="color: #2e7d32; flex-shrink: 0; margin-top: 2px; font-size: 18px;"></i>
                    <p style="color: #2e7d32; margin: 0; font-size: 0.9rem;">
                        <strong>Catatan:</strong> Kami merespons dalam waktu kurang dari 24 jam. Terima kasih!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Map Section -->
<div style="background-color: var(--bg-light); padding: 60px 20px;">
    <div class="container">
        <h2 style="font-size: 1.75rem; text-align: center; color: var(--hijau-islam); margin-bottom: 40px; font-weight: 700;">Lokasi Kami</h2>
        <div style="width: 100%; height: 450px; background: linear-gradient(135deg, var(--hijau-islam-lighter) 0%, var(--emas-light) 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 10px 30px rgba(26, 92, 66, 0.15);">
            <div style="text-align: center;">
                <i class="fas fa-map" style="font-size: 56px; margin-bottom: 15px; display: block; opacity: 0.9;"></i>
                <p style="margin: 0; font-weight: 500; font-size: 1.1rem;">Google Maps Embedded</p>
                <p style="font-size: 0.9rem; opacity: 0.85; margin: 8px 0 0 0;">Peta lokasi Al-Hikmah Academy dapat diintegrasikan di sini</p>
            </div>
        </div>
    </div>
</div>

@endsection
