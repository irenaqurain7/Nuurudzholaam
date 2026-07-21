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
                        <a href="tel:{{ $school->no_telepon ?? '085714673916' }}" style="color: var(--hijau-islam); text-decoration: none; font-weight: 600; transition: color 0.3s;">{{ $school->no_telepon ?? '085714673916' }}</a>
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
                        <a href="mailto:{{ $school->email ?? 'Nuurudz@gmail.com' }}" style="color: var(--hijau-islam); text-decoration: none; font-weight: 400; transition: color 0.3s;">{{ $school->email ?? 'Nuurudz@gmail.com' }}</a>
                    </p>
                </div>

                <!-- Social Media Card -->
                <div style="background: white; border: 1px solid #e0e7ff; border-left: 4px solid var(--hijau-islam); border-radius: 8px; padding: 25px;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                        <i class="fas fa-share-alt" style="font-size: 24px; color: var(--emas); width: 32px; text-align: center;"></i>
                        <h3 style="color: var(--hijau-islam); margin: 0; font-weight: 600; font-size: 1rem;">Social media</h3>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-left: 47px;">

                        <a href="https://www.facebook.com/share/1NoBMULdSX/" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 10px; color: var(--hijau-islam); text-decoration: none; padding: 8px; border-radius: 6px; transition: all 0.3s; font-size: 0.95rem;">
                            <i class="fab fa-facebook-f" style="width: 18px; text-align: center;"></i> Ponpes Nuurudzholaam
                        </a>

                        <a href="https://www.instagram.com/ponpes_nuurudzholaam?igsh=OGxzdXAwdHUzcmhm" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 10px; color: var(--hijau-islam); text-decoration: none; padding: 8px; border-radius: 6px; transition: all 0.3s; font-size: 0.95rem;">
                            <i class="fab fa-instagram" style="width: 18px; text-align: center;"></i> Ponpes_Nuurudzholaam
                        </a>

                        <a href="https://youtube.com/@nuzotv512?si=2qczakQK_rskbbBk" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 10px; color: var(--hijau-islam); text-decoration: none; padding: 8px; border-radius: 6px; transition: all 0.3s; font-size: 0.95rem;">
                            <i class="fab fa-youtube" style="width: 18px; text-align: center;"></i> Nuzo TV
                        </a>

                        <a href="https://www.tiktok.com/@ponpes_nuurudzholaam?_r=1&_t=ZS-96VuElyQSP7" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 10px; color: var(--hijau-islam); text-decoration: none; padding: 8px; border-radius: 6px; transition: all 0.3s; font-size: 0.95rem;">
                            <i class="fab fa-tiktok" style="width: 18px; text-align: center;"></i> Media Nuzo
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

<!-- Map Section -->
<div style="background-color: var(--bg-light); padding: 60px 20px;">
    <div class="container">
        <h2 style="font-size: 1.75rem; text-align: center; color: var(--hijau-islam); margin-bottom: 40px; font-weight: 700;">Lokasi Kami</h2>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <div id="mapContainer" style="position: relative; width: 100%; height: 450px; border-radius: 10px; overflow: hidden; box-shadow: 0 10px 30px rgba(26, 92, 66, 0.15); cursor: grab;">
                <style>
                    #mapContainer:active {
                        cursor: grabbing;
                    }
                    #mapContainer iframe {
                        pointer-events: auto;
                    }
                    .map-hint {
                        position: absolute;
                        top: 15px;
                        left: 50%;
                        transform: translateX(-50%);
                        background-color: rgba(0, 0, 0, 0.7);
                        color: white;
                        padding: 8px 16px;
                        border-radius: 6px;
                        font-size: 0.85rem;
                        font-weight: 500;
                        z-index: 10;
                        pointer-events: none;
                        animation: fadeInOut 3s ease-in-out;
                    }
                    @keyframes fadeInOut {
                        0% { opacity: 0; }
                        10% { opacity: 1; }
                        90% { opacity: 1; }
                        100% { opacity: 0; }
                    }
                    .map-button-container {
                        display: flex;
                        gap: 12px;
                        justify-content: flex-start;
                        flex-wrap: wrap;
                    }
                    .map-button {
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                        padding: 12px 20px;
                        background-color: white;
                        color: var(--hijau-islam);
                        border: 2px solid var(--hijau-islam);
                        border-radius: 8px;
                        text-decoration: none;
                        font-weight: 600;
                        font-size: 0.95rem;
                        box-shadow: 0 4px 12px rgba(26, 92, 66, 0.1);
                        transition: all 0.3s ease;
                        cursor: pointer;
                    }
                    .map-button:hover {
                        background-color: var(--hijau-islam);
                        color: white;
                        transform: translateY(-2px);
                        box-shadow: 0 6px 16px rgba(26, 92, 66, 0.2);
                    }
                    .map-button i {
                        font-size: 1.1rem;
                    }
                </style>
                <div class="map-hint">
                    <i class="fas fa-hand-paper" style="margin-right: 6px;"></i>Geser peta untuk melihat lokasi lainnya
                </div>
                <iframe 
                    id="googleMaps"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.3654521989736!2d107.6369!3d-6.484599!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e691d16b5b5b5b5%3A0x5b5b5b5b5b5b5b5b!2sJl.%20Sindangreret%2C%20Dangdeur%2C%20Kec.%20Bungursari%2C%20Kab.%20Purwakarta%2C%20Jawa%20Barat%2041181!5e0!3m2!1sid!2sid!4v1687000000000" 
                    width="100%" 
                    height="100%" 
                    style="border:0; margin: 0; padding: 0; display: block;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div class="map-button-container">
                <a href="https://maps.app.goo.gl/GPtgJaHTQzNngfKQ7?g_st=aw" target="_blank" rel="noopener noreferrer" class="map-button">
                    <i class="fas fa-map-marker-alt"></i>Buka di Google Maps
                </a>
                <a href="https://maps.google.com/maps?q=Jl.%20Sindangreret%2C%20Dangdeur%2C%20Kec.%20Bungursari%2C%20Kab.%20Purwakarta" target="_blank" rel="noopener noreferrer" class="map-button">
                    <i class="fas fa-directions"></i>Dapatkan Arah
                </a>
            </div>
        </div>
        
        <script>
            // Enhanced map interaction
            document.addEventListener('DOMContentLoaded', function() {
                const mapContainer = document.getElementById('mapContainer');
                const googleMaps = document.getElementById('googleMaps');
                
                // Show grab cursor on hover
                mapContainer.addEventListener('mouseenter', function() {
                    mapContainer.style.cursor = 'grab';
                });
                
                // Enable smooth scrolling interaction
                googleMaps.style.pointerEvents = 'auto';
                
                // Touch support for mobile
                let isDragging = false;
                mapContainer.addEventListener('touchstart', function() {
                    isDragging = true;
                    googleMaps.style.pointerEvents = 'auto';
                });
                
                mapContainer.addEventListener('touchend', function() {
                    isDragging = false;
                });
                
                // Show hint when user moves mouse over map
                let hintShown = false;
                mapContainer.addEventListener('mousemove', function() {
                    if (!hintShown && mapContainer.querySelector('.map-hint')) {
                        hintShown = true;
                        setTimeout(() => {
                            hintShown = false;
                        }, 5000);
                    }
                });
            });
        </script>
    </div>
</div>

@endsection
