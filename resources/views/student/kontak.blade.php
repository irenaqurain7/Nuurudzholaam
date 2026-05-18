@extends('student.layout')

@section('student-content')
<div style="max-width: 1200px; margin: 0 auto;">
    <h1 style="font-size: 2rem; color: #2D4438; margin-bottom: 10px; font-weight: 700;">Hubungi Kami</h1>
    <p style="color: #666; margin-bottom: 40px; font-size: 16px; line-height: 1.6;">Kami siap melayani pertanyaan Anda seputar program pendidikan, pendaftaran, dan informasi lainnya</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 50px;">
        <!-- Contact Info Column -->
        <div>
            <h2 style="font-size: 1.5rem; color: #2D4438; margin-bottom: 30px; font-weight: 700;">Informasi Kontak</h2>

            <!-- Address Card -->
            <div style="background: white; border: 1px solid #E2ECE8; border-left: 4px solid #2D4438; border-radius: 8px; padding: 25px; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 12px;">
                    <i class="fas fa-map-marker-alt" style="font-size: 24px; color: #709D88; width: 32px; text-align: center;"></i>
                    <h3 style="color: #2D4438; margin: 0; font-weight: 600; font-size: 1rem;">Alamat</h3>
                </div>
                <p style="color: #666; line-height: 1.6; margin: 0 0 0 47px; font-size: 0.95rem;">
                    @if($schoolInfo && $schoolInfo->address)
                        {{ $schoolInfo->address }}
                    @else
                        Jl. Sindangreret, Dangdeur, Kec. Bungursari, Kab. Purwakarta, Jawa Barat 41181
                    @endif
                </p>
            </div>

            <!-- Phone Card -->
            <div style="background: white; border: 1px solid #E2ECE8; border-left: 4px solid #2D4438; border-radius: 8px; padding: 25px; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 12px;">
                    <i class="fas fa-phone" style="font-size: 24px; color: #709D88; width: 32px; text-align: center;"></i>
                    <h3 style="color: #2D4438; margin: 0; font-weight: 600; font-size: 1rem;">Telepon / WhatsApp</h3>
                </div>
                <p style="color: #666; margin: 0 0 0 47px; font-size: 0.95rem;">
                    <a href="tel:085714673916" style="color: #2D4438; text-decoration: none; font-weight: 600;">085714673916 (Dede Ali)</a>
                </p>
                <p style="color: #666; margin: 8px 0 0 47px; font-size: 0.95rem; line-height: 1.6;">
                    081958159264 (Wiwi Suherti)<br>
                    083816931133 (Ziun)
                </p>
            </div>

            <!-- Email Card -->
            <div style="background: white; border: 1px solid #E2ECE8; border-left: 4px solid #2D4438; border-radius: 8px; padding: 25px; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 12px;">
                    <i class="fas fa-envelope" style="font-size: 24px; color: #709D88; width: 32px; text-align: center;"></i>
                    <h3 style="color: #2D4438; margin: 0; font-weight: 600; font-size: 1rem;">Email:</h3>
                </div>
                <p style="color: #666; margin: 0 0 0 47px; font-size: 0.95rem;">
                    <a href="mailto:Nuurudz@gmail.com" style="color: #2D4438; text-decoration: none; font-weight: 400;">Nuurudz@gmail.com</a>
                </p>
            </div>

            <!-- Social Media Card -->
            <div style="background: white; border: 1px solid #E2ECE8; border-left: 4px solid #2D4438; border-radius: 8px; padding: 25px;">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                    <i class="fas fa-share-alt" style="font-size: 24px; color: #709D88; width: 32px; text-align: center;"></i>
                    <h3 style="color: #2D4438; margin: 0; font-weight: 600; font-size: 1rem;">Social media</h3>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-left: 47px;">
                    <a href="#" style="display: flex; align-items: center; gap: 10px; color: #2D4438; text-decoration: none; padding: 8px; border-radius: 6px; transition: all 0.3s; font-size: 0.95rem;">
                        <i class="fab fa-facebook-f" style="width: 18px; text-align: center;"></i> Ponpes Nuurudzholaam
                    </a>
                    <a href="#" style="display: flex; align-items: center; gap: 10px; color: #2D4438; text-decoration: none; padding: 8px; border-radius: 6px; transition: all 0.3s; font-size: 0.95rem;">
                        <i class="fab fa-instagram" style="width: 18px; text-align: center;"></i> Ponpes_Nuurudzholaam
                    </a>
                    <a href="#" style="display: flex; align-items: center; gap: 10px; color: #2D4438; text-decoration: none; padding: 8px; border-radius: 6px; transition: all 0.3s; font-size: 0.95rem;">
                        <i class="fab fa-youtube" style="width: 18px; text-align: center;"></i> Nuzo TV
                    </a>
                    <a href="#" style="display: flex; align-items: center; gap: 10px; color: #2D4438; text-decoration: none; padding: 8px; border-radius: 6px; transition: all 0.3s; font-size: 0.95rem;">
                        <i class="fab fa-tiktok" style="width: 18px; text-align: center;"></i> Media Nuzo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
