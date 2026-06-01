@extends('teacher.layout')

@section('teacher-content')
<style>
    :root {
        --primary: #2d5016;
        --text-primary: #1a1a1a;
        --text-secondary: #666;
        --text-muted: #999;
        --border: #e5e5e5;
        --bg-light: #f9f9f9;
    }

    .container {
        max-width: 1000px;
    }

    .page-header {
        margin-bottom: 2.5rem;
    }

    .page-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
        letter-spacing: -0.5px;
    }

    .page-header p {
        color: var(--text-secondary);
        font-size: 1rem;
        line-height: 1.6;
        max-width: 700px;
    }

    .section-title {
        font-weight: 600;
        color: var(--text-primary);
        margin: 2rem 0 1rem 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .contact-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .contact-card:hover {
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        transform: translateY(-2px);
    }

    .contact-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .contact-icon {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--bg-light);
        border-radius: 6px;
        color: var(--primary);
        font-size: 1.05rem;
        flex-shrink: 0;
    }

    .contact-header h3 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .contact-content {
        font-size: 0.95rem;
        color: var(--text-secondary);
        line-height: 1.6;
    }

    .contact-item {
        margin-bottom: 0.75rem;
    }

    .contact-item:last-child {
        margin-bottom: 0;
    }

    .contact-label {
        display: block;
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-top: 0.15rem;
    }

    .contact-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
        display: inline-block;
    }

    .contact-link:hover {
        color: #1f3a0f;
        text-decoration: underline;
    }

    .social-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }

    .social-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.8rem;
        background-color: var(--bg-light);
        border-radius: 6px;
        color: var(--primary);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .social-item:hover {
        background-color: var(--primary);
        color: white;
    }

    .social-item i {
        width: 18px;
        text-align: center;
        font-size: 1rem;
    }

    .info-box {
        background-color: #fafafa;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .info-box h4 {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .info-box p {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin: 0;
        line-height: 1.6;
    }

    .info-box strong {
        color: var(--text-primary);
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.75rem;
        }

        .contact-grid {
            grid-template-columns: 1fr;
        }

        .social-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Hubungi Kami</h1>
        <p>Kami siap melayani pertanyaan Anda seputar program pendidikan, pendaftaran, dan informasi akademis lainnya.</p>
    </div>

    <!-- Section: Informasi Kontak -->
    <h2 class="section-title">Informasi Kontak</h2>
    <div class="contact-grid">
        <!-- Address Card -->
        <div class="contact-card">
            <div class="contact-header">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Alamat</h3>
            </div>
            <div class="contact-content">
                @if($schoolInfo && $schoolInfo->address)
                    {{ $schoolInfo->address }}
                @else
                    Jl. Sindangreret, Dangdeur, Kec. Bungursari, Kab. Purwakarta, Jawa Barat 41181
                @endif
            </div>
        </div>

        <!-- Phone Card -->
        <div class="contact-card">
            <div class="contact-header">
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <h3>Telepon / WhatsApp</h3>
            </div>
            <div class="contact-content">
                <div class="contact-item">
                    <a href="tel:085714673916" class="contact-link">085714673916</a>
                    <span class="contact-label">Dede Ali</span>
                </div>
                <div class="contact-item">
                    <div style="font-weight: 500; color: var(--text-primary);">081958159264</div>
                    <span class="contact-label">Wiwi Suherti</span>
                </div>
                <div class="contact-item">
                    <div style="font-weight: 500; color: var(--text-primary);">083816931133</div>
                    <span class="contact-label">Ziun</span>
                </div>
            </div>
        </div>

        <!-- Email Card -->
        <div class="contact-card">
            <div class="contact-header">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Email Resmi</h3>
            </div>
            <div class="contact-content">
                <a href="mailto:Nuurudz@gmail.com" class="contact-link">Nuurudz@gmail.com</a>
                <span class="contact-label">Korespondensi Umum</span>
            </div>
        </div>
    </div>

    <!-- Section: Media Sosial -->
    <h2 class="section-title">Media Sosial</h2>
    <div class="contact-card" style="margin-bottom: 1.5rem;">
        <div class="social-grid">
            <a href="#" class="social-item" target="_blank" title="Facebook">
                <i class="fab fa-facebook-f"></i>
                <span>Ponpes Nuurudzholaam</span>
            </a>
            <a href="#" class="social-item" target="_blank" title="Instagram">
                <i class="fab fa-instagram"></i>
                <span>Ponpes_Nuurudzholaam</span>
            </a>
            <a href="#" class="social-item" target="_blank" title="YouTube">
                <i class="fab fa-youtube"></i>
                <span>Nuzo TV</span>
            </a>
            <a href="#" class="social-item" target="_blank" title="TikTok">
                <i class="fab fa-tiktok"></i>
                <span>Media Nuzo</span>
            </a>
        </div>
    </div>

    <!-- Section: Jam Layanan -->
    <div class="info-box">
        <h4><i class="fas fa-clock"></i>Jam Layanan Operasional</h4>
        <p>
            <strong>Senin - Jumat:</strong> 07:00 - 16:00 WIB<br>
            <strong>Sabtu:</strong> 07:00 - 12:00 WIB<br>
            <strong>Minggu & Hari Libur:</strong> Tutup
        </p>
    </div>
</div>
@endsection
