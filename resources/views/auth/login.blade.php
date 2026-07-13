<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sekolah Nuurudzholaam</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #23422A;
            --primary-container: #3A5A40;
            --secondary: #566342;
            --secondary-container: #D7E5BB;
            --tertiary: #A90022;
            --background: #F8F9FA;
            --surface: #FFFFFF;
            --outline: #C2C8BF;
            --border-radius-card: 16px;
            --border-radius-button: 8px;
            --border-radius-input: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--background);
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
        }

        .container {
            width: 100%;
            max-width: 1280px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background-color: var(--surface);
            border-radius: var(--border-radius-card);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            display: flex;
            width: 100%;
            max-width: 900px;
            overflow: hidden;
            min-height: 500px;
        }

        /* Left Side */
        .login-left {
            flex: 1;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-left h1 {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .login-subtitle {
            font-size: 16px;
            font-weight: 400;
            color: #666;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--outline);
            border-radius: var(--border-radius-input);
            font-size: 14px;
            font-weight: 400;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: #333;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px var(--primary);
        }

        .input-wrapper input.is-invalid {
            border-color: var(--tertiary);
        }
        
        .input-wrapper input.is-invalid:focus {
            box-shadow: 0 0 0 2px var(--tertiary);
        }

        .input-wrapper input[type="password"],
        .input-wrapper input#password {
            padding-right: 45px;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            cursor: pointer;
            z-index: 10;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .error-message {
            display: block;
            color: var(--tertiary);
            font-size: 12px;
            font-weight: 400;
            margin-top: 8px;
        }

        .field-help {
            display: block;
            color: #666;
            font-size: 12px;
            font-weight: 400;
            margin-top: 8px;
        }

        .forgot-password {
            text-align: right;
            margin-top: -12px;
            margin-bottom: 24px;
        }

        .forgot-password a {
            color: var(--primary);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: var(--primary);
            color: var(--surface);
            border: none;
            border-radius: var(--border-radius-button);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-bottom: 24px;
        }

        .btn-login:hover {
            background-color: var(--primary-container);
        }

        .system-note {
            text-align: center;
            font-size: 12px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 32px;
        }

        .left-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #888;
        }

        .left-footer a {
            color: #888;
            text-decoration: none;
        }

        .left-footer a:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        .contact {
            text-align: right;
        }

        /* Right Side / Image Side */
        .login-right {
            flex: 1;
            background-color: var(--primary-container);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            color: var(--surface);
        }

        .right-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .right-logo img {
            height: 48px;
            width: auto;
        }

        .right-logo .logo-text {
            font-weight: 700;
            font-size: 16px;
            line-height: 1.2;
            color: var(--surface);
        }

        .right-logo a {
            text-decoration: none;
        }

        .illustration {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .illustration i.main-icon {
            font-size: 120px;
            color: var(--secondary-container);
            position: relative;
            z-index: 1;
        }

        .right-footer {
            font-size: 12px;
            color: var(--secondary-container);
            text-align: left;
        }

        .right-footer span {
            display: block;
            margin-bottom: 4px;
        }

        @media (max-width: 900px) {
            .login-card {
                flex-direction: column-reverse;
                max-width: 500px;
            }
            .login-right {
                padding: 32px;
                min-height: 250px;
            }
            .login-left {
                padding: 32px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card">
            <!-- LEFT SIDE (Form) -->
            <div class="login-left">
                <h1>Login</h1>
                <p class="login-subtitle">Masuk menggunakan username dan password akun Anda.</p>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="login">Username</label>
                        <div class="input-wrapper">
                            <input type="text" id="login" name="login" class="@error('login') is-invalid @enderror" placeholder="Masukkan username, email, NISN, atau NIP" value="{{ old('login') }}" required autofocus>
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

                    <div class="system-note">
                        *Hanya siswa dan guru yang sudah terdaftar dan berstatus aktif di sekolah yang dapat mengakses sistem ini.
                    </div>
                </form>

                <div class="left-footer">
                    <div>
                        <a href="#">Terms and Services</a>
                    </div>
                    <div class="contact">
                        Have a problem? Contact us at<br>
                        <a href="mailto:admin@nuurudzholaam.sch.id">admin@nuurudzholaam.sch.id</a>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE (Illustration & Brand) -->
            <div class="login-right">
                <div class="right-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo-nuzo.png') }}" alt="Logo">
                    </a>
                    <a href="{{ route('home') }}" class="logo-text">SEKOLAH<br>NUURUDZHOLAAM</a>
                </div>

                <div class="illustration">
                    <i class="fas fa-school main-icon"></i>
                </div>

                <div class="right-footer">
                    <span>&copy; {{ date('Y') }} Sekolah Islam Nuurudzholaam</span>
                    <span>Powered by Nuurudzholaam Tech</span>
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
