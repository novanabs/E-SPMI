<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>E-SPMI | Login</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/ulm.ico') }}">
    <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="E-SPMI UPM FKIP ULM" />
    <meta name="author" content="UPM FKIP ULM" />
    <meta name="description"
        content="Dashboard PPEPP UPM FKIP ULM menyediakan sistem pengelolaan evaluasi, pemantauan, pengendalian, dan peningkatan mutu pendidikan serta manajemen evaluasi diri berbasis web. Mempermudah pengelolaan data, monitoring, dan pelaporan mutu di lingkungan FKIP ULM." />

    <meta name="keywords"
        content="PPEPP, UPM FKIP ULM, Dashboard Mutu, Evaluasi Mutu, Penjaminan Mutu Pendidikan, Sistem Mutu FKIP, PPEPP ULM, Evaluasi Diri, Audit Mutu Internal, Mutu Pendidikan FKIP ULM" />
    <!--end::Primary Meta Tags-->



    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
</head>

<body class="login-page bg-body-secondary">

    <div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
        <div class="card border-0 shadow-sm overflow-hidden" style="max-width: 950px; width:100%; border-radius:10px;">
            <div class="row g-0">

                <!-- LEFT PANEL -->
                <div class="col-md-6 p-4 d-flex flex-column justify-content-center" style="background:#dff1ff;">
                    <img src="{{ asset('img/ulm.png') }}" alt="Logo" width="100" class="mx-auto d-block mb-3">
                    <h4 class="fw-bold text-primary mb-2">
                        E-SPMI:<br>Quality Assurance Unit FKIP ULM
                    </h4>

                    <p class="text-secondary mb-0" style="font-size:14px; line-height:1.7;">
                        The Quality Assurance Unit (QAU) of FKIP ULM is committed to maintaining
                        and improving the quality of education, research, and community service within the
                        Faculty of Teacher Training and Education, Lambung Mangkurat University.
                        QAU FKIP ULM develops, implements, and monitors quality standards to ensure academic
                        excellence and continuous improvement in all faculty activities.
                    </p>
                </div>

                <!-- RIGHT PANEL -->
                <div class="col-md-6 p-4 bg-white d-flex flex-column justify-content-center">
                    <h5 class="fw-bold text-primary mb-4">Login</h5>

                    <form action="{{ route('login.auth') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Username (Email)</label>
                            <input type="email" name="email" placeholder="Enter your email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" placeholder="Enter your password"
                                    class="form-control @error('password') is-invalid @enderror" id="password-input">

                                <button type="button" class="btn btn-outline-primary" id="toggle-password">
                                    <i class="bi bi-eye-slash" id="toggle-icon"></i>
                                </button>
                            </div>

                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary px-4">
                            Login
                        </button>
                    </form>

                    <a href="#" class="mt-3 text-decoration-none small" data-bs-toggle="tooltip"
                        title="Silahkan hubungi admin UPM untuk melakukan reset password">
                        Lupa Password
                    </a>
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
    </script>

    <script>
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
