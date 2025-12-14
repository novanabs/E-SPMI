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
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <div class="link-dark text-center">
                    <img class="mb-2" src="{{ asset('img/ulm.ico') }}" alt="Logo ULM" height="100px">
                    <h2 class="mb-0"><b>E-SPMI</b></h2>
                    <p class="mb-0 fw-semibold">UPM FKIP ULM</p>
                </div>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Login</p>
                <form action="{{ route('login.auth') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" placeholder="Email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="Password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" placeholder="Password"
                                class="form-control @error('password') is-invalid @enderror" id="password-input">
                            <button type="button" class="btn btn-outline-primary" id="toggle-password">
                                <i class="bi bi-eye-slash" id="toggle-icon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--begin::Row-->
                    <div class="row">

                        <!-- /.col -->
                        <div class="mt-2 mb-2">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!--end::Row-->
                </form>
                <a href="#" data-bs-toggle="tooltip"
                    title="Silahkan hubungi admin UPM untuk melakukan reset password">
                    Lupa Password
                </a>

            </div>
            <!-- /.login-card-body -->
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
        })
    </script>


</body>
