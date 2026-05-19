<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --hijau-islam: #2D4438;
            --hijau-light: #486E5A;
            --emas: #709D88;
            --emas-light: #E2ECE8;
            --text-dark: #1C2D25;
            --text-light: #5A7E6B;
            --bg-light: #F4F7F5;
            --putih: #ffffff;
        }

        body {
            background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-light) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .error-container {
            background-color: var(--putih);
            border-radius: 12px;
            padding: 60px 40px;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(45, 68, 56, 0.2);
        }

        .error-icon {
            font-size: 80px;
            color: #e74c3c;
            margin-bottom: 20px;
        }

        .error-code {
            font-size: 64px;
            font-weight: 700;
            color: var(--hijau-islam);
            margin-bottom: 10px;
        }

        .error-title {
            font-size: 28px;
            color: var(--text-dark);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .error-message {
            color: var(--text-light);
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn-home {
            background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-light) 100%);
            color: var(--putih);
            padding: 12px 35px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(45, 68, 56, 0.2);
            color: var(--putih);
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .error-container {
                padding: 40px 25px;
            }

            .error-code {
                font-size: 48px;
            }

            .error-title {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-lock"></i>
        </div>
        <div class="error-code">403</div>
        <h1 class="error-title">Akses Ditolak</h1>
        <p class="error-message">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. 
            Hubungi administrator jika Anda merasa ini adalah kesalahan.
        </p>
        <a href="{{ url('/') }}" class="btn-home">
            <i class="fas fa-home"></i> Kembali ke Beranda
        </a>
    </div>
</body>
</html>
