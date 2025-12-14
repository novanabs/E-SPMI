<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>E-SPMI | Reset Password</title>
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />
</head>

<body class="login-page bg-body-secondary">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <a href="../index2.html"
                    class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
                    <h2 class="mb-0">Reset Password</h2>
                </a>
            </div>
            <div class="card-body login-card-body">
                <form action="{{ route('update.auth') }}" method="post">
                    @csrf
                    <!-- Input Password Baru -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" name="password" placeholder="Password"
                            class="form-control @error('password') is-invalid @enderror" id="password-input">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Input Konfirmasi Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password-confirmation-input">
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Checkbox Show Password -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="show-password">
                        <label class="form-check-label" for="show-password">Tampilkan Password</label>
                    </div>

                    <!-- Tombol Reset -->
                    <div class="mt-4">
                        <button type="submit" class="me-2 btn btn-primary">RESET</button>
                    </div>
                </form>

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
        document.getElementById('show-password').addEventListener('change', function() {
            let passwordInput = document.getElementById('password-input');
            let confirmPasswordInput = document.getElementById('password-confirmation-input');

            if (this.checked) {
                passwordInput.type = "text";
                confirmPasswordInput.type = "text";
            } else {
                passwordInput.type = "password";
                confirmPasswordInput.type = "password";
            }
        });
    </script>


</body>
