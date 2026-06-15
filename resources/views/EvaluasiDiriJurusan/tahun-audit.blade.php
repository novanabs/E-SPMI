@extends('layouts.app')

@section('title', 'Tahun Audit')

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

    <div class="page-header">

        <div class="page-title">
            Manajemen Tahun Audit
        </div>

        <div class="page-subtitle">
            Kelola tahun audit yang digunakan dalam proses Audit Mutu Internal (AMI).
        </div>

    </div>

    <div class="table-card">

        <div class="table-header">

            <div class="table-title" hidden>
                Daftar Tahun Audit
            </div>

            <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalTambahTahun">

                <i class="fas fa-plus me-2"></i>
                Tambah Tahun

            </button>

        </div>

        <div class="table-responsive">

            <table id="tahunAuditTable" class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th>Tahun Audit</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($tahunAudits as $item)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-bold">
                                {{ $item->tahun }}
                            </td>

                            <td>

                                <button class="btn btn-danger btn-sm"
                                    onclick="hapusTahun('{{ route('tahun-audit.destroy', $item->id) }}')">

                                    <i class="fas fa-trash me-1"></i>
                                    Hapus

                                </button>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <!-- Modal Tambah Tahun -->

    <div class="modal fade" id="modalTambahTahun" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="{{ route('tahun-audit.store') }}" method="POST">

                    @csrf

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Tambah Tahun Audit
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                    </div>

                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label">
                                Tahun Audit
                            </label>

                            <input type="number" name="tahun" class="form-control" min="2000" max="2100"
                                value="{{ date('Y') }}" required>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            Batal

                        </button>

                        <button type="submit" class="btn btn-primary">

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        $(document).ready(function() {

            $('#tahunAuditTable').DataTable({

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

                    emptyTable: "Belum ada tahun audit"

                }

            });

        });

        function hapusTahun(url) {

            Swal.fire({

                title: 'Hapus Tahun Audit?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',

            }).then((result) => {

                if (result.isConfirmed) {

                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    form.innerHTML = `
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                `;

                    document.body.appendChild(form);
                    form.submit();

                }

            });

        }
    </script>

@endsection
