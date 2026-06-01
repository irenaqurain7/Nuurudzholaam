@extends('student.layout')

@section('student-content')
<style>
    :root {
        --primary: #2d5016;
        --text-primary: #1a1a1a;
        --text-secondary: #666;
        --text-muted: #999;
        --border: #e5e5e5;
        --bg-light: #f9f9f9;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container {
        max-width: 1000px;
    }

    .page-header {
        margin-bottom: 3rem;
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
        max-width: 600px;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 1.5rem 0 1rem 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .contact-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.2rem;
        transition: all 0.3s ease;
    }

    .contact-card:hover {
        border-color: var(--primary);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .contact-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .contact-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--bg-light);
        border-radius: 6px;
        color: var(--primary);
        font-size: 1rem;
        flex-shrink: 0;
    }

    .contact-header h3 {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .contact-content {
        font-size: 0.9rem;
        color: var(--text-secondary);
        line-height: 1.6;
    }

    .contact-item {
        margin-bottom: 0.6rem;
    }

    .contact-item:last-child {
        margin-bottom: 0;
    }

    .contact-label {
        display: block;
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-top: 0.2rem;
    }

    .contact-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
        display: inline-block;
    }

    .contact-link:hover {
        color: #1f3a0f;
    }

    .social-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.6rem;
    }

    .social-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.65rem;
        background-color: var(--bg-light);
        border-radius: 6px;
        color: var(--primary);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .social-item:hover {
        background-color: var(--primary);
        color: white;
    }

    .social-item i {
        width: 16px;
        text-align: center;
        font-size: 0.95rem;
    }

    .info-box {
        background-color: #fafafa;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.2rem;
        margin-top: 1.5rem;
    }

    .info-box h4 {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .info-box p {
        color: var(--text-secondary);
        font-size: 0.9rem;
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
            gap: 1rem;
        }

        .social-grid {
            grid-template-columns: 1fr;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .section-title {
            margin: 1.5rem 0 1rem 0;
        }
    }
</style>

<div class="page-header" style="display: none;"></div>

<h2 class="section-title">Informasi Kontak</h2>

<div class="contact-grid">
    <!-- Address -->
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

    <!-- Phone -->
    <div class="contact-card">
        <div class="contact-header">
            <div class="contact-icon">
                <i class="fas fa-phone"></i>
            </div>
            <h3>Telepon</h3>
        </div>
        <div class="contact-content">
            <div class="contact-item">
                <a href="tel:085714673916" class="contact-link">085714673916</a>
                <span class="contact-label">Dede Ali</span>
            </div>
            <div class="contact-item">
                <div>081958159264</div>
                <span class="contact-label">Wiwi Suherti</span>
            </div>
            <div class="contact-item">
                <div>083816931133</div>
                <span class="contact-label">Ziun</span>
            </div>
        </div>
    </div>

    <!-- Email -->
    <div class="contact-card">
        <div class="contact-header">
            <div class="contact-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <h3>Email</h3>
        </div>
        <div class="contact-content">
            <a href="mailto:Nuurudz@gmail.com" class="contact-link">Nuurudz@gmail.com</a>
        </div>
    </div>
</div>

<h2 class="section-title">Media Sosial</h2>

<div class="contact-card" style="margin-bottom: 1.5rem;">
    <div class="social-grid">
        <a href="#" class="social-item" title="Facebook">
            <i class="fab fa-facebook-f"></i>
            <span>Facebook</span>
        </a>
        <a href="#" class="social-item" title="Instagram">
            <i class="fab fa-instagram"></i>
            <span>Instagram</span>
        </a>
        <a href="#" class="social-item" title="YouTube">
            <i class="fab fa-youtube"></i>
            <span>YouTube</span>
        </a>
        <a href="#" class="social-item" title="TikTok">
            <i class="fab fa-tiktok"></i>
            <span>TikTok</span>
        </a>
    </div>
</div>

<!-- Service Hours -->
<div class="info-box">
    <h4><i class="fas fa-clock"></i>Jam Layanan</h4>
    <p>
        <strong>Senin - Jumat:</strong> 07:00 - 16:00 WIB<br>
        <strong>Sabtu:</strong> 07:00 - 12:00 WIB<br>
        <strong>Minggu & Hari Libur:</strong> Tutup
    </p>
</div>
@endsection
