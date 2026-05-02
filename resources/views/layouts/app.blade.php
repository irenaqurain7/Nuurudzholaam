<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sekolah Islam Nuurudzholaam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --hijau-islam: #1f7f5f;
            --hijau-islam-light: #2d8659;
            --hijau-islam-lighter: #4a9d7d;
            --putih: #ffffff;
            --emas: #d4af37;
            --emas-light: #ffc107;
            --text-dark: #1a202c;
            --text-light: #4a5568;
            --bg-light: #f7fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            background-color: var(--bg-light);
        }

        .navbar {
            background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
            box-shadow: 0 4px 12px rgba(31, 127, 95, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: var(--emas);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-nav {
            display: flex;
            gap: 30px;
            list-style: none;
            align-items: center;
        }

        .navbar-nav a {
            color: var(--putih);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav a:hover,
        .navbar-nav a.active {
            color: var(--emas);
        }

        .navbar-nav a.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--emas);
            border-radius: 3px;
        }

        .hero {
            background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
            color: var(--putih);
            padding: 100px 20px;
            text-align: center;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 400px;
            height: 400px;
            background-color: rgba(212, 175, 55, 0.05);
            border-radius: 50%;
            transform: translate(100px, -100px);
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            font-weight: bold;
            position: relative;
            z-index: 1;
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
            opacity: 0.95;
        }

        .btn-primary {
            display: inline-block;
            padding: 12px 35px;
            background-color: var(--emas);
            color: var(--hijau-islam);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: var(--emas-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3);
        }

        .btn-secondary {
            display: inline-block;
            padding: 12px 35px;
            background-color: transparent;
            color: var(--emas);
            text-decoration: none;
            border: 2px solid var(--emas);
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-secondary:hover {
            background-color: var(--emas);
            color: var(--hijau-islam);
        }

        .section-title {
            font-size: 36px;
            font-weight: bold;
            color: var(--hijau-islam);
            margin-bottom: 50px;
            text-align: center;
            position: relative;
            padding-bottom: 20px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--emas);
            border-radius: 2px;
        }

        .card {
            background: var(--putih);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(31, 127, 95, 0.15);
        }

        .card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            color: var(--hijau-islam);
            margin-bottom: 15px;
        }

        .card-text {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .footer {
            background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-islam-light) 100%);
            color: var(--putih);
            padding: 50px 20px 20px;
            margin-top: 100px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            color: var(--emas);
            margin-bottom: 20px;
            font-size: 18px;
        }

        .footer-section a,
        .footer-section p {
            color: var(--putih);
            text-decoration: none;
            margin-bottom: 12px;
            opacity: 0.9;
            transition: all 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--emas);
            padding-left: 5px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(212, 175, 55, 0.3);
            padding-top: 30px;
            text-align: center;
            opacity: 0.8;
        }

        .grid-responsive {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .grid-responsive-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 40px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #f5c6cb;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--hijau-islam);
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--hijau-islam);
            box-shadow: 0 0 0 3px rgba(31, 127, 95, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section {
            padding: 80px 20px;
        }

        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
                gap: 15px;
            }

            .hero h1 {
                font-size: 32px;
            }

            .hero p {
                font-size: 16px;
            }

            .section-title {
                font-size: 28px;
            }

            .grid-responsive,
            .grid-responsive-2 {
                grid-template-columns: 1fr;
            }
        }

        .navbar-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--putih);
            font-size: 24px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .navbar-toggle {
                display: block;
            }

            .navbar-nav {
                display: none;
            }

            .navbar-nav.active {
                display: flex;
            }
        }

        .text-center {
            text-align: center;
        }

        .mt-40 {
            margin-top: 40px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .mb-30 {
            margin-bottom: 30px;
        }

        .mb-50 {
            margin-bottom: 50px;
        }

        .text-emas {
            color: var(--emas);
        }

        .text-hijau {
            color: var(--hijau-islam);
        }

        .accent-line {
            width: 4px;
            height: 40px;
            background-color: var(--emas);
            border-radius: 2px;
            margin-right: 15px;
        }

        .badge {
            display: inline-block;
            padding: 6px 15px;
            background-color: var(--hijau-islam-lighter);
            color: var(--putih);
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px;">
            <a href="{{ route('home') }}" class="navbar-brand">
                <i class="fas fa-mosque"></i>
                <span>Nuurudzholaam</span>
            </a>
            <button class="navbar-toggle" id="navbar-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="navbar-nav" id="navbar-menu">
                <li><a href="{{ route('home') }}" class="@if(Route::current()->getName() === 'home') active @endif">Beranda</a></li>
                <li><a href="{{ route('ppdb') }}" class="@if(Route::current()->getName() === 'ppdb') active @endif">PPDB</a></li>
                <li><a href="{{ route('program') }}" class="@if(Route::current()->getName() === 'program') active @endif">Program</a></li>
                <li><a href="{{ route('kegiatan') }}" class="@if(Route::current()->getName() === 'kegiatan') active @endif">Kegiatan</a></li>
                <li><a href="{{ route('profil') }}" class="@if(Route::current()->getName() === 'profil') active @endif">Profil</a></li>
                <li><a href="{{ route('faq') }}" class="@if(Route::current()->getName() === 'faq') active @endif">FAQ</a></li>
                <li><a href="{{ route('kontak') }}" class="@if(Route::current()->getName() === 'kontak') active @endif">Kontak</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3><i class="fas fa-info-circle"></i> Tentang Kami</h3>
                <p>Sekolah Islam Nuurudzholaam berkomitmen memberikan pendidikan berkualitas dengan nuansa islami yang kuat.</p>
            </div>
            <div class="footer-section">
                <h3><i class="fas fa-map-marker-alt"></i> Alamat</h3>
                <p id="footer-alamat">Kp, Jl. Sindangreret, Dangdeur, Kec. Bungursari, Kabupaten Purwakarta, Jawa Barat 41181</p>
            </div>
            <div class="footer-section">
                <h3><i class="fas fa-phone"></i> Hubungi Kami</h3>
                <p><a href="tel:085714673916(Dede ali)">081958159264(Wiwi suherti)</a></p>
                <p><a href="mailto:Nuurudz@gmail.com">Nuurudz@gmail.com</a></p>
            </div>
            <div class="footer-section">
                <h3><i class="fas fa-share-alt"></i> Media Sosial</h3>
                <div style="display: flex; gap: 15px; font-size: 20px;">
                    <a href="#" style="color: var(--emas); transition: all 0.3s;"><i class="fab fa-facebook"></i></a>
                    <a href="#" style="color: var(--emas); transition: all 0.3s;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: var(--emas); transition: all 0.3s;"><i class="fab fa-youtube"></i></a>
                    <a href="#" style="color: var(--emas); transition: all 0.3s;"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Sekolah Islam Nuurudzholaam. All rights reserved. | Designed with <i class="fas fa-heart" style="color: var(--emas);"></i> for Education</p>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        document.getElementById('navbar-toggle').addEventListener('click', function() {
            const menu = document.getElementById('navbar-menu');
            menu.classList.toggle('active');
        });

        // Close menu when a link is clicked
        document.querySelectorAll('.navbar-nav a').forEach(link => {
            link.addEventListener('click', function() {
                document.getElementById('navbar-menu').classList.remove('active');
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
