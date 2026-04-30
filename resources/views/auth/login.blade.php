<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Panel</title>
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
        }

        body {
            background: linear-gradient(135deg, #1f7f5f 0%, #15543a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
        }

        .login-wrapper {
            width: 100%;
            max-width: 450px;
        }

        .login-box {
            background: white;
            border-radius: 16px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.35);
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #1f7f5f 0%, #15543a 100%);
            color: white;
            padding: 50px 35px 35px;
            text-align: center;
        }

        .logo-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 25px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            backdrop-filter: blur(10px);
        }

        .login-header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-header p {
            font-size: 15px;
            opacity: 0.95;
            font-weight: 500;
        }

        .login-content {
            padding: 45px 35px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 10px;
            letter-spacing: 0.3px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            color: #1f7f5f;
            font-size: 18px;
            pointer-events: none;
        }

        .input-wrapper input {
            width: 100%;
            padding: 13px 16px 13px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            color: #1a202c;
            background: #f8fafc;
        }

        .input-wrapper input:hover {
            border-color: #cbd5e1;
            background: white;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: #1f7f5f;
            background: white;
            box-shadow: 0 0 0 4px rgba(31, 127, 95, 0.08);
        }

        .input-wrapper input.is-invalid {
            border-color: #ef4444;
        }

        .input-wrapper input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.08);
        }

        .input-wrapper input::placeholder {
            color: #94a3b8;
        }

        .error-message {
            display: block;
            color: #ef4444;
            font-size: 13px;
            margin-top: 7px;
            font-weight: 500;
        }

        .form-group.checkbox {
            margin-bottom: 28px;
            display: flex;
            align-items: center;
        }

        .form-group.checkbox label {
            display: flex;
            align-items: center;
            margin-bottom: 0;
            cursor: pointer;
            font-weight: 500;
            color: #475569;
            gap: 8px;
        }

        .form-group.checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #1f7f5f;
            border: 2px solid #cbd5e1;
            border-radius: 5px;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1f7f5f 0%, #15543a 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 8px 20px rgba(31, 127, 95, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(31, 127, 95, 0.3);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .login-footer {
            background: #f8fafc;
            padding: 25px 35px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .login-footer p {
            font-size: 13px;
            color: #64748b;
            margin: 0;
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .login-box {
                border-radius: 14px;
            }

            .login-header {
                padding: 40px 25px 25px;
            }

            .logo-icon {
                width: 60px;
                height: 60px;
                margin: 0 auto 20px;
                font-size: 28px;
            }

            .login-header h1 {
                font-size: 28px;
                margin-bottom: 6px;
            }

            .login-header p {
                font-size: 14px;
            }

            .login-content {
                padding: 35px 25px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .input-wrapper input {
                padding: 12px 14px 12px 44px;
                font-size: 16px;
            }

            .input-wrapper i {
                left: 14px;
                font-size: 16px;
            }

            .btn-login {
                padding: 13px;
                font-size: 15px;
            }

            .login-footer {
                padding: 20px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box">
            <!-- Header -->
            <div class="login-header">
                <div class="logo-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h1>Admin Panel</h1>
                <p>Sekolah Islam Nuurudzholaam</p>
            </div>

            <!-- Form -->
            <div class="login-content">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="admin@nuurudzholaam.sch.id"
                                required
                                autocomplete="email"
                                class="@error('email') is-invalid @enderror"
                            >
                        </div>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password"
                                required
                                autocomplete="current-password"
                                class="@error('password') is-invalid @enderror"
                            >
                        </div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-group checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Masuk ke Admin Panel
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <p>© 2024 Sekolah Islam Nuurudzholaam<br>All rights reserved</p>
            </div>
        </div>
    </div>
</body>
</html>
