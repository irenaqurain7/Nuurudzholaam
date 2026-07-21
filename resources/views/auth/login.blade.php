<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sekolah Nuurudzholaam</title>
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

        /* Decorative Background Circles */
        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.05);
        }
        .circle-1 { width: 350px; height: 350px; top: -100px; left: -100px; }
        .circle-2 { width: 100px; height: 100px; top: 15%; left: 25%; }
        .circle-3 { width: 450px; height: 450px; bottom: -150px; right: -150px; }
        .circle-4 { width: 80px; height: 80px; bottom: 15%; right: 25%; }

        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 1000px;
            height: 600px;
            background-color: #2D4438;
            border-radius: 40px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 10;
        }

        /* LEFT SIDE */
        .login-left {
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
            font-family: inherit;
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

        .illustration i.float-icon-1 { position: absolute; font-size: 30px; color: #72A08B; top: 20%; right: 20%; z-index: 2;}
        .illustration i.float-icon-2 { position: absolute; font-size: 40px; color: #1a5c42; bottom: 20%; left: 15%; z-index: 2;}

        .left-footer {
            font-size: 10px;
            color: #64748b;
        }

        .left-footer span {
            display: block;
            margin-bottom: 3px;
        }

        /* RIGHT SIDE */
        .login-right {
            flex: 1.1;
            background-color: transparent;
            padding: 50px 60px 40px 100px; /* added left padding to push content right of the wavy curve */
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #ffffff;
        }

        .login-right h1 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
            color: #ffffff;
        }

        .login-subtitle {
            font-size: 13px;
            color: #9cb8ab;
            margin-bottom: 22px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            padding: 13px 20px;
            border: none;
            border-radius: 50px;
            font-size: 14px;
            color: #ffffff;
            background: #1C2D25;
            transition: all 0.3s ease;
        }

        .input-wrapper input[type="password"],
        .input-wrapper input#password {
            padding-right: 45px;
        }

        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #5A7E6B;
            cursor: pointer;
            z-index: 10;
        }

        .password-toggle:hover {
            color: #ffffff;
        }

        .input-wrapper input:focus {
            outline: none;
            background: #15221B;
            box-shadow: 0 0 0 1px #486E5A;
        }

        .input-wrapper input::placeholder {
            color: #5A7E6B;
        }

        .input-wrapper input.is-invalid {
            box-shadow: 0 0 0 1px #ef4444;
        }

        .error-message {
            display: block;
            color: #fca5a5;
            font-size: 12px;
            margin-top: 6px;
            padding-left: 15px;
        }

        .field-help {
            display: block;
            color: #8fb0a0;
            font-size: 11px;
            margin-top: 6px;
            padding-left: 15px;
        }

        .forgot-password {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 25px;
            padding-right: 10px;
        }

        .forgot-password a {
            color: #5A7E6B;
            font-size: 12px;
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #ffffff;
        }

        .btn-login {
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
            margin-bottom: 20px;
        }

        .btn-login:hover {
            background-color: #5B8572;
        }

        .register-link {
            text-align: center;
            font-size: 12px;
            color: #e2e8f0;
            margin-bottom: 30px;
        }

        .register-link a {
            color: #709D88;
            text-decoration: underline;
            margin-left: 5px;
        }

        .register-link a:hover {
            color: #ffffff;
        }

        .right-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10px;
            color: #5A7E6B;
        }

        .right-footer a {
            color: #5A7E6B;
            text-decoration: underline;
        }

        .right-footer a:hover {
            color: #ffffff;
        }

        .right-footer .contact {
            text-align: right;
        }

        /* Responsive */
        @media (max-width: 900px) {
            body {
                padding: 10px;
            }
            .login-wrapper {
                flex-direction: column;
                height: auto;
                max-width: 500px;
                border-radius: 30px;
            }
            .login-left {
                border-radius: 30px 30px 0 0;
                padding: 30px;
                min-height: 250px;
            }
            .illustration {
                margin-right: 0;
                margin-top: 20px;
            }
            .login-right {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <!-- Decorative Circles -->
    <div class="bg-circle circle-1"></div>
    <div class="bg-circle circle-2"></div>
    <div class="bg-circle circle-3"></div>
    <div class="bg-circle circle-4"></div>

    <div class="login-wrapper">
        <!-- LEFT SIDE -->
        <div class="login-left">
            <div class="left-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo-nuzo.png') }}" alt="Logo">
                </a>
                <span class="logo-text">SEKOLAH<br>NUURUDZHOLAAM</span>
            </div>

            <div class="illustration">
                <div class="illustration-bg"></div>
                <!-- Abstract generic educational illustration using icons -->
                <i class="fas fa-school main-icon"></i>
                <i class="fas fa-book-open float-icon-1"></i>
                <i class="fas fa-graduation-cap float-icon-2"></i>
            </div>

            <div class="left-footer">
                <span>&copy; {{ date('Y') }} Sekolah Islam Nuurudzholaam</span>
                <span>Powered by Nuurudzholaam Tech</span>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="login-right">
            <h1>Login</h1>
            <p class="login-subtitle">Masuk menggunakan username dan password akun Anda.</p>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="login">Username</label>
                    <div class="input-wrapper">
                        <input type="text" id="login" name="login" class="@error('login') is-invalid @enderror" placeholder="Masukkan username, email, atau NIP" value="{{ old('login') }}" required autofocus>
                    </div>
                    <span class="field-help">Gunakan username yang dibuat saat registrasi.</span>
                    @error('login')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" class="@error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-login">Login</button>

                <div style="text-align: center; font-size: 11px; color: #6C8B7C; margin-bottom: 30px; line-height: 1.5; padding: 0 10px;">
                    *Hanya guru dan pengurus sekolah yang berstatus aktif yang dapat mengakses sistem ini.
                </div>
            </form>

            <div class="right-footer">
                <div>
                    <a href="#">Terms and Services</a>
                </div>
                <div class="contact">
                    Have a problem? Contact us at<br>
                    <a href="mailto:admin@nuurudzholaam.sch.id">admin@nuurudzholaam.sch.id</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // Toggle type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle icon
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
