<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>E-SPMI | Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />

    <link rel="icon" type="image/x-icon" href="{{ asset('img/ulm.ico') }}">

    <meta name="title" content="E-SPMI UPM FKIP ULM" />

    <meta name="author" content="UPM FKIP ULM" />

    <meta name="description"
        content="Dashboard PPEPP UPM FKIP ULM menyediakan sistem pengelolaan evaluasi, pemantauan, pengendalian, dan peningkatan mutu pendidikan." />

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />

    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />

    <style>

        body {

            min-height: 100vh;
            background:
                linear-gradient(rgba(15,23,42,.78), rgba(15,23,42,.78)),
                url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1600');

            background-size: cover;
            background-position: center;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;

        }

        /* =========================
           WRAPPER
        ========================= */

        .login-wrapper {

            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;

        }

        /* =========================
           CARD
        ========================= */

        .login-card {

            width: 100%;
            max-width: 1100px;
            border-radius: 32px;
            overflow: hidden;
            backdrop-filter: blur(16px);
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 30px 60px rgba(0,0,0,0.25);

        }

        /* =========================
           LEFT PANEL
        ========================= */

        .left-panel {

            background:
                linear-gradient(135deg, rgba(37,99,235,.92), rgba(15,23,42,.96));

            color: white;
            padding: 60px 48px;
            position: relative;
            overflow: hidden;

        }

        .left-panel::before {

            content: "";
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,.05);
            border-radius: 50%;
            top: -180px;
            right: -140px;

        }

        .left-panel::after {

            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            background: rgba(255,255,255,.04);
            border-radius: 50%;
            bottom: -100px;
            left: -80px;

        }

        .left-content {

            position: relative;
            z-index: 2;

        }

        .logo-box {

            width: 110px;
            height: 110px;
            border-radius: 24px;
            background: rgba(255,255,255,.12);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 28px;
            backdrop-filter: blur(10px);

        }

        .logo-box img {

            width: 70px;

        }

        .hero-badge {

            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,.12);
            padding: 10px 18px;
            border-radius: 999px;
            margin-bottom: 24px;
            font-size: 13px;
            font-weight: 700;

        }

        .hero-title {

            font-size: 38px;
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 20px;

        }

        .hero-desc {

            line-height: 1.9;
            opacity: .9;
            font-size: 15px;

        }

        /* =========================
           RIGHT PANEL
        ========================= */

        .right-panel {

            background: white;
            padding: 60px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;

        }

        .login-title {

            font-size: 34px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;

        }

        .login-subtitle {

            color: #64748b;
            margin-bottom: 36px;
            font-size: 15px;

        }

        /* =========================
           FORM
        ========================= */

        .form-label {

            font-weight: 700;
            color: #0f172a;
            margin-bottom: 10px;

        }

        .form-control {

            border-radius: 16px !important;
            min-height: 56px;
            border: 1px solid #e2e8f0 !important;
            padding: 14px 18px !important;
            box-shadow: none !important;
            transition: .25s ease;

        }

        .form-control:focus {

            border-color: #2563eb !important;
            box-shadow: 0 0 0 4px rgba(37,99,235,.12) !important;

        }

        .input-group .btn {

            border-radius: 16px !important;
            margin-left: 8px;
            width: 56px;
            border: 1px solid #e2e8f0;

        }

        /* =========================
           BUTTON
        ========================= */

        .btn-login {

            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            min-height: 56px;
            border-radius: 16px;
            font-weight: 700;
            font-size: 15px;
            color: white;
            width: 100%;
            transition: .25s ease;
            box-shadow: 0 12px 24px rgba(37,99,235,.22);

        }

        .btn-login:hover {

            transform: translateY(-2px);
            box-shadow: 0 20px 32px rgba(37,99,235,.3);

        }

        /* =========================
           FORGOT
        ========================= */

        .forgot-password {

            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
            transition: .2s ease;

        }

        .forgot-password:hover {

            color: #1d4ed8;

        }

        /* =========================
           FOOTER
        ========================= */

        .login-footer {

            margin-top: 40px;
            color: #94a3b8;
            font-size: 13px;
            text-align: center;

        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width: 992px){

            .left-panel {

                display: none;

            }

            .right-panel {

                padding: 42px 28px;

            }

            .login-card {

                max-width: 500px;

            }

        }

    </style>

</head>

<body>

    <div class="login-wrapper">

        <div class="login-card">

            <div class="row g-0">

                <!-- LEFT -->

                <div class="col-lg-6">

                    <div class="left-panel h-100">

                        <div class="left-content">

                            <div class="logo-box">

                                <img src="{{ asset('img/ulm.png') }}" alt="Logo">

                            </div>

                            <div class="hero-badge">

                                <i class="bi bi-shield-check"></i>
                                Internal Quality Assurance System

                            </div>

                            <div class="hero-title">

                                E-SPMI<br>
                                UPM FKIP ULM

                            </div>

                            <div class="hero-desc">

                                The Quality Assurance Unit (QAU) of FKIP ULM is committed
                                to maintaining and improving the quality of education,
                                research, and community service through sustainable quality assurance systems.

                            </div>

                            <div class="mt-4">
                                <a href="{{ route('ppepp.index') }}"
                                   class="btn btn-light rounded-pill px-4 py-2 fw-bold"
                                   style="color:#1e3a8a; text-decoration: none; font-size: 14px;">
                                    <i class="bi bi-diagram-3-fill me-2"></i>
                                    Lihat Siklus PPEPP
                                </a>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- RIGHT -->

                <div class="col-lg-6">

                    <div class="right-panel">

                        <div class="login-title">
                            Welcome Back
                        </div>

                        <div class="login-subtitle">
                            Silakan login untuk mengakses dashboard E-SPMI FKIP ULM
                        </div>

                        <form action="{{ route('login.auth') }}" method="POST">

                            @csrf

                            <div class="mb-4">

                                <label class="form-label">
                                    Email
                                </label>

                                <input type="email"
                                       name="email"
                                       placeholder="Masukkan email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}">

                                @error('email')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                            <div class="mb-4">

                                <label class="form-label">
                                    Password
                                </label>

                                <div class="input-group">

                                    <input type="password"
                                           name="password"
                                           placeholder="Masukkan password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password-input">

                                    <button type="button"
                                            class="btn btn-light"
                                            id="toggle-password">

                                        <i class="bi bi-eye-slash"
                                           id="toggle-icon"></i>

                                    </button>

                                </div>

                                @error('password')

                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                            <button type="submit" class="btn-login">

                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Login

                            </button>

                        </form>

                        <div class="mt-4 text-center">

                            <a href="#"
                               class="forgot-password"
                               data-bs-toggle="tooltip"
                               title="Silahkan hubungi admin UPM untuk melakukan reset password">

                                Lupa Password?

                            </a>

                        </div>

                        <div class="login-footer">

                            © {{ date('Y') }} E-SPMI FKIP ULM —
                            Quality Assurance Information System

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('js/adminlte.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });

        const passwordInput = document.getElementById('password-input');
        const toggleButton = document.getElementById('toggle-password');
        const toggleIcon = document.getElementById('toggle-icon');

        toggleButton.addEventListener('click', function() {

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');

            } else {

                passwordInput.type = 'password';

                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');

            }

        });

    </script>

</body>

</html>