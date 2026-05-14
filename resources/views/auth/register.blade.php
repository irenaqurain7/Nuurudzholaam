<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sekolah Islam Nuurudzholaam</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #2D4438;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }

        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .circle-1 { width: 350px; height: 350px; top: -100px; left: -100px; }
        .circle-2 { width: 100px; height: 100px; top: 15%; left: 25%; }
        .circle-3 { width: 450px; height: 450px; bottom: -150px; right: -150px; }
        .circle-4 { width: 80px; height: 80px; bottom: 15%; right: 25%; }

        .register-wrapper {
            display: flex;
            width: 100%;
            max-width: 1040px;
            height: 650px;
            background-color: #2D4438;
            border-radius: 40px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 10;
        }

        .register-left {
            flex: 0.9;
            background-color: #ffffff;
            position: relative;
            border-radius: 30px 120px 120px 30px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 2;
        }

        .left-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .left-logo img {
            height: 45px;
            width: auto;
        }

        .left-logo .logo-text {
            color: #19466e;
            font-weight: bold;
            font-size: 14px;
            line-height: 1.1;
        }

        .illustration {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .illustration-bg {
            position: absolute;
            width: 90%;
            height: 80%;
            background-color: #E2ECE8;
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            z-index: 0;
            opacity: 0.8;
            left: 5%;
        }

        .illustration i.main-icon {
            font-size: 140px;
            color: #1f7f5f;
            position: relative;
            z-index: 1;
        }

        .illustration i.float-icon-1 { position: absolute; font-size: 30px; color: #72A08B; top: 20%; right: 20%; z-index: 2; }
        .illustration i.float-icon-2 { position: absolute; font-size: 40px; color: #1a5c42; bottom: 20%; left: 15%; z-index: 2; }

        .left-footer {
            font-size: 10px;
            color: #64748b;
        }

        .left-footer span {
            display: block;
            margin-bottom: 3px;
        }

        .register-right {
            flex: 1.1;
            background-color: transparent;
            padding: 42px 60px 36px 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #ffffff;
            overflow-y: auto;
        }

        .register-right h1 {
            font-size: 30px;
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
            color: #ffffff;
        }

        .register-subtitle {
            font-size: 13px;
            color: #9cb8ab;
            margin-bottom: 18px;
        }

        .form-group {
            margin-bottom: 12px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input,
        .input-wrapper select {
            width: 100%;
            padding: 12px 18px;
            border: none;
            border-radius: 50px;
            font-size: 14px;
            color: #ffffff;
            background: #1C2D25;
            transition: all 0.3s ease;
            appearance: none;
        }

        .input-wrapper input[type="password"] {
            padding-right: 44px;
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #5A7E6B;
            cursor: pointer;
            z-index: 10;
        }

        .password-toggle:hover {
            color: #ffffff;
        }

        .input-wrapper input:focus,
        .input-wrapper select:focus {
            outline: none;
            background: #15221B;
            box-shadow: 0 0 0 1px #486E5A;
        }

        .input-wrapper input::placeholder {
            color: #5A7E6B;
        }

        .input-wrapper select {
            color: #9cb8ab;
        }

        .input-wrapper select option {
            color: #ffffff;
            background: #1C2D25;
        }

        .input-wrapper .chevron {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #5A7E6B;
            pointer-events: none;
        }

        .input-wrapper input.is-invalid,
        .input-wrapper select.is-invalid {
            box-shadow: 0 0 0 1px #ef4444;
        }

        .error-message {
            display: block;
            color: #fca5a5;
            font-size: 12px;
            margin-top: 6px;
            padding-left: 12px;
        }

        .field-help {
            display: block;
            color: #8fb0a0;
            font-size: 11px;
            margin-top: 5px;
            padding-left: 12px;
        }

        .alert-danger {
            border: 1px solid rgba(248, 113, 113, 0.5);
            background: rgba(127, 29, 29, 0.35);
            border-radius: 16px;
            padding: 12px 14px;
            margin-bottom: 14px;
            color: #fecaca;
            font-size: 12px;
        }

        .alert-danger ul {
            margin-top: 6px;
            padding-left: 16px;
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background-color: #709D88;
            color: #ffffff;
            border: none;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 6px;
            margin-bottom: 14px;
        }

        .btn-register:hover {
            background-color: #5B8572;
        }

        .login-link {
            text-align: center;
            font-size: 12px;
            color: #e2e8f0;
        }

        .login-link a {
            color: #709D88;
            text-decoration: underline;
            margin-left: 5px;
        }

        .login-link a:hover {
            color: #ffffff;
        }

        @media (max-width: 900px) {
            body {
                padding: 10px;
            }

            .register-wrapper {
                flex-direction: column;
                height: auto;
                max-width: 540px;
                border-radius: 30px;
            }

            .register-left {
                border-radius: 30px 30px 0 0;
                padding: 30px;
                min-height: 240px;
            }

            .register-right {
                padding: 34px 26px;
                max-height: 62vh;
            }
        }
    </style>
</head>
<body>
    <div class="bg-circle circle-1"></div>
    <div class="bg-circle circle-2"></div>
    <div class="bg-circle circle-3"></div>
    <div class="bg-circle circle-4"></div>

    <div class="register-wrapper">
        <div class="register-left">
            <div class="left-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo-nuzo.png') }}" alt="Logo">
                </a>
                <span class="logo-text">SEKOLAH ISLAM<br>NUURUDZHOLAAM</span>
            </div>

            <div class="illustration">
                <div class="illustration-bg"></div>
                <i class="fas fa-user-plus main-icon"></i>
                <i class="fas fa-user-check float-icon-1"></i>
                <i class="fas fa-lock float-icon-2"></i>
            </div>

            <div class="left-footer">
                <span>&copy; {{ date('Y') }} Sekolah Islam Nuurudzholaam</span>
                <span>Powered by Nuurudzholaam Tech</span>
            </div>
        </div>

        <div class="register-right">
            <h1>Daftar Akun</h1>
            <p class="register-subtitle">Lengkapi username dan password untuk membuat akun baru.</p>

            @if ($errors->any())
                <div class="alert-danger">
                    <strong>Terjadi kesalahan saat mendaftar:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <input id="name" name="name" type="text" autocomplete="name" class="@error('name') is-invalid @enderror" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                    </div>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <input id="username" name="username" type="text" autocomplete="username" class="@error('username') is-invalid @enderror" placeholder="Huruf, angka, underscore (tanpa spasi)" value="{{ old('username') }}" required>
                    </div>
                    <span class="field-help">Username ini akan dipakai saat login.</span>
                    @error('username')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <input id="email" name="email" type="email" autocomplete="email" class="@error('email') is-invalid @enderror" placeholder="Masukkan email" value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <div class="input-wrapper">
                        <input id="phone" name="phone" type="tel" autocomplete="tel" class="@error('phone') is-invalid @enderror" placeholder="Opsional" value="{{ old('phone') }}">
                    </div>
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role">Tipe Akun</label>
                    <div class="input-wrapper">
                        <select id="role" name="role" class="@error('role') is-invalid @enderror" required>
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih tipe akun</option>
                            <option value="siswa" {{ old('role') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="orangtua" {{ old('role') === 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
                            <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <i class="fas fa-chevron-down chevron"></i>
                    </div>
                    @error('role')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input id="password" name="password" type="password" autocomplete="new-password" class="@error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                    <span class="field-help">Gunakan kombinasi huruf dan angka agar lebih aman.</span>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="@error('password_confirmation') is-invalid @enderror" placeholder="Ulangi password" required>
                        <i class="fas fa-eye password-toggle" id="togglePasswordConfirmation"></i>
                    </div>
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-register">Daftar</button>

                <p class="login-link">
                    Sudah punya akun?
                    <a href="{{ route('login') }}">Login di sini</a>
                </p>
            </form>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
        const passwordConfirmation = document.querySelector('#password_confirmation');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

        togglePasswordConfirmation.addEventListener('click', function () {
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
