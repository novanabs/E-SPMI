@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* =========================
                       PAGE HEADER
                    ========================= */

        .page-header {

            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            border-radius: 24px;
            padding: 28px;
            margin-bottom: 24px;
            color: white;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .10);

        }

        .page-title {

            font-size: 28px;
            font-weight: 800;
            margin-bottom: 6px;

        }

        .page-subtitle {

            opacity: .88;
            line-height: 1.8;
            max-width: 760px;

        }

        /* =========================
                       TABLE CARD
                    ========================= */

        .table-card {

            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .06);

        }

        .table-header {

            padding: 24px;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;

        }

        .table-title {

            font-size: 24px;
            font-weight: 800;
            color: #0f172a;

        }

        /* =========================
                       BUTTON
                    ========================= */

        .btn {

            border-radius: 12px !important;
            font-weight: 700 !important;

        }

        .btn-primary {

            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;

        }

        .btn-warning {

            background: linear-gradient(135deg, #f59e0b, #d97706);
            border: none;
            color: white !important;

        }

        .btn-danger {

            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;

        }

        .btn-secondary {

            background: linear-gradient(135deg, #64748b, #475569);
            border: none;

        }

        .btn-outline-primary {

            border-radius: 10px !important;

        }

        /* =========================
                       TABLE
                    ========================= */

        .table {

            margin-bottom: 0 !important;

        }

        .table thead {

            background: #f8fafc;

        }

        .table th {

            border-bottom: 1px solid #e2e8f0 !important;
            color: #64748b;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .5px;
            white-space: nowrap;

        }

        .table td {

            vertical-align: middle;
            color: #334155;

        }

        .table tbody tr {

            transition: .2s ease;

        }

        .table tbody tr:hover {

            background: rgba(37, 99, 235, .03);

        }

        /* =========================
                       ROLE BADGE
                    ========================= */

        .role-badge {

            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;

        }

        .role-admin {

            background: rgba(37, 99, 235, .12);
            color: #1d4ed8;

        }

        .role-user {

            background: rgba(34, 197, 94, .12);
            color: #15803d;

        }

        /* =========================
                       PASSWORD BOX
                    ========================= */

        .password-box {

            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 10px 14px;

        }

        .password-text {

            color: #2563eb;
            font-weight: 700;
            font-size: 14px;

        }

        /* =========================
                       DATATABLE
                    ========================= */

        .dataTables_filter input,
        .dataTables_length select {

            border-radius: 12px !important;
            border: 1px solid #dbe2ea !important;
            min-height: 42px;
            box-shadow: none !important;

        }

        .dataTables_filter input:focus {

            border-color: #2563eb !important;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12) !important;

        }

        /* =========================
                       RESPONSIVE
                    ========================= */

        @media(max-width:768px) {

            .page-title {

                font-size: 22px;

            }

            .table-header {

                flex-direction: column;
                align-items: stretch;

            }

        }
    </style>

    <!-- HEADER -->

    <div class="page-header">

        <div class="page-title">
            Manajemen User
        </div>

        <div class="page-subtitle">

            Kelola seluruh akun pengguna sistem E-SPMI FKIP ULM,
            termasuk reset password, pengaturan role,
            dan manajemen akses pengguna.

        </div>

    </div>

    <!-- TABLE CARD -->

    <div class="table-card">

        <div class="table-header">

            <div class="table-title">

                Daftar User

            </div>

            <a href="{{ route('user.create') }}" class="btn btn-primary">

                <i class="fas fa-plus me-2"></i>
                Tambah User

            </a>

        </div>

        <div class="table-responsive">

            <table id="penetapanTable" class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Nama</th>
                        <th>Homebase</th>
                        <th>Jabatan</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Password</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($data as $item)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                {{ $item->name }}
                            </td>

                            <td>
                                {{ $item->homebase }}
                            </td>

                            <td>
                                {{ $item->jabatan }}
                            </td>

                            <td>
                                {{ $item->email }}
                            </td>

                            <!-- ROLE -->

                            <td>

                                <span class="role-badge {{ $item->role == 'admin_FKIP' ? 'role-admin' : 'role-user' }}"
                                    style="white-space: nowrap;">
                                    {{ $item->role == 'admin_FKIP' ? 'UPM' : ($item->role == 'admin_jurusan' ? 'Admin Jurusan' : $item->role) }}
                                </span>

                            </td>

                            <!-- PASSWORD -->

                            <td>

                                @if ($item->generated_password == null)
                                    <span class="text-success fw-bold">

                                        <i class="fas fa-check-circle me-1"></i>
                                        Telah Diubah

                                    </span>
                                @else
                                    <div class="password-box d-flex justify-content-between align-items-center gap-2">

                                        <span class="password-text" id="pass-{{ $item->id }}">

                                            {{ $item->generated_password }}

                                        </span>

                                        <button class="btn btn-sm btn-outline-primary"
                                            onclick="copyToClipboard({{ $item->id }})">

                                            <i class="fas fa-copy"></i>

                                        </button>

                                    </div>
                                @endif

                            </td>

                            <!-- AKSI -->

                            <td>

                                <div class="d-flex flex-wrap gap-2">

                                    <button class="btn btn-warning btn-sm" onclick="resetPassword({{ $item->id }})">

                                        <i class="fas fa-rotate me-1"></i>
                                        Reset

                                    </button>

                                    <a class="btn btn-secondary btn-sm" href="{{ route('user.edit', $item->id) }}">

                                        <i class="fas fa-pen me-1"></i>
                                        Edit

                                    </a>

                                    <button class="btn btn-danger btn-sm"
                                        onclick="confirmDelete('{{ route('user.destroy', $item->id) }}')">

                                        <i class="fas fa-trash me-1"></i>
                                        Hapus

                                    </button>

                                </div>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <!-- DATATABLE -->

    <script>
        $(document).ready(function() {

            $('#penetapanTable').DataTable({

                pageLength: 10,

                language: {

                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

                    paginate: {

                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"

                    },

                    emptyTable: "Tidak ada data"

                }

            });

        });
    </script>

    <!-- RESET PASSWORD -->

    <script>
        function resetPassword(userId) {

            Swal.fire({

                title: 'Reset Password?',
                text: 'Password lama akan diganti dengan password baru.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal',

            }).then((result) => {

                if (result.isConfirmed) {

                    fetch(`/admin/reset-password/${userId}`, {

                            method: 'POST',

                            headers: {

                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',

                            }

                        })

                        .then(res => res.json())

                        .then(data => {

                            Swal.fire({

                                title: 'Password Baru',

                                html: `
                        <div style="font-size:18px;font-weight:700;color:#2563eb;">
                            ${data.password}
                        </div>
                        <br>
                        <small>Silakan salin dan kirim ke user</small>
                    `,

                                icon: 'success',

                            }).then(() => {

                                location.reload();

                            });

                        });

                }

            });

        }
    </script>

    <!-- COPY PASSWORD -->

    <script>
        function copyToClipboard(id) {

            var text = document.getElementById("pass-" + id).innerText;

            navigator.clipboard.writeText(text)

                .then(function() {

                    Swal.fire({

                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Password berhasil disalin.',
                        timer: 2000,
                        showConfirmButton: false

                    });

                })

                .catch(function(err) {

                    Swal.fire({

                        icon: 'error',
                        title: 'Oops!',
                        text: 'Gagal menyalin password.',

                    });

                    console.error("Gagal menyalin teks", err);

                });

        }
    </script>

@endsection
