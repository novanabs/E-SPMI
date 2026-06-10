@extends('layouts.app')

@section('title', 'Peningkatan')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* =========================
       PAGE STYLE
    ========================= */

        .page-header {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 18px;
            color: white;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
        }

        .page-title {
            font-size: 18px;
            font-weight: 800;
        }

        .page-subtitle {
            opacity: .85;
            font-size: 14px;
            margin-top: 4px;
        }

        .btn-add {
            border: none;
            background: white;
            color: #0f172a;
            padding: 8px 14px;
            border-radius: 12px;
            font-weight: 700;
            transition: .25s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            background: #f8fafc;
            color: #0f172a;
        }

        /* =========================
       ALERT INFO
    ========================= */

        .info-box {
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.12);
            border-radius: 18px;
            padding: 18px 20px;
            margin-bottom: 20px;
            color: #334155;
        }

        .info-box strong {
            color: #0f172a;
        }

        .template-link {
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
        }

        .template-link:hover {
            color: #1d4ed8;
        }

        /* =========================
       CARD
    ========================= */

        .table-card {
            background: white;
            border-radius: 24px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        /* =========================
       DATATABLE
    ========================= */

        .dataTables_wrapper {
            padding: 0;
        }

        .dataTables_length,
        .dataTables_filter {
            margin-bottom: 10px;
        }

        .dataTables_length label,
        .dataTables_filter label {
            font-weight: 600;
            color: #334155;
            font-size: 14px;
        }

        table.dataTable {
            border-collapse: separate !important;
            border-spacing: 0 12px !important;
        }

        table.dataTable thead th {
            border: none !important;
            background: #f8fafc !important;
            color: #0f172a !important;
            font-size: 15px;
            font-weight: 700;
            padding: 18px !important;
            white-space: nowrap;
        }

        table.dataTable tbody tr {
            background: white;
            transition: all .25s ease;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        }

        table.dataTable tbody tr:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06);
        }

        table.dataTable tbody td {
            border-top: none !important;
            padding: 10px 12px !important;
            vertical-align: middle;
            background: white;
            color: #334155;
        }

        table.dataTable tbody tr td:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        table.dataTable tbody tr td:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        /* PAGINATION */

        .dataTables_paginate {
            margin-top: 24px !important;
        }

        .dataTables_paginate .paginate_button {
            border: none !important;
            background: transparent !important;
            margin: 0 4px;
            padding: 0 !important;
            border-radius: 12px !important;
        }

        .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
            color: white !important;
            box-shadow: 0 6px 18px rgba(59, 130, 246, 0.3);
        }

        .dataTables_paginate .paginate_button:hover {
            background: #eff6ff !important;
            color: #2563eb !important;
        }

        .dataTables_info {
            color: #64748b !important;
            margin-top: 24px !important;
        }

        /* =========================
       CUSTOM CONTENT
    ========================= */

        .document-title {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .document-date {
            color: #64748b;
            font-size: 13px;
        }

        .btn-link-custom {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(59, 130, 246, 0.12);
            color: #2563eb;
            padding: 10px 14px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: .25s ease;
        }

        .btn-link-custom:hover {
            background: rgba(59, 130, 246, 0.2);
            color: #1d4ed8;
        }

        /* ACTION BUTTON */

        .action-group {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .25s ease;
            text-decoration: none;
        }

        .btn-edit {
            background: rgba(245, 158, 11, 0.12);
            color: #d97706;
        }

        .btn-edit:hover {
            background: #d97706;
            color: white;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.12);
            color: #dc2626;
        }

        .btn-delete:hover {
            background: #dc2626;
            color: white;
            transform: translateY(-2px);
        }

        /* RESPONSIVE */

        @media(max-width: 768px) {

            .page-header {
                padding: 22px;
            }

            .page-title {
                font-size: 22px;
            }

            .table-card {
                padding: 16px;
            }

            .info-box {
                padding: 16px;
            }

            .dataTables_filter input {
                min-width: 100%;
                margin-top: 10px;
            }

            .dataTables_length,
            .dataTables_filter,
            .dataTables_info,
            .dataTables_paginate {
                text-align: center !important;
            }

            table.dataTable tbody td {
                padding: 8px 10px !important;
            }
        }
    </style>

    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>

            <div class="page-title">
                Laporan Peningkatan {{ auth()->user()->homebase }}
            </div>

            <div class="page-subtitle">
                Kelola laporan peningkatan mutu dan tindak lanjut
            </div>

        </div>

        <a href="{{ route('peningkatan.create') }}" class="btn-add">

            <i class="fas fa-plus"></i>
            Tambah Laporan

        </a>

    </div>


    <div class="table-card">
        Link dokumen pendukung dan template dapat diunduh pada link berikut:
        <a href="https://drive.google.com/drive/folders/1krecO1sZfJCNaWIk7MwuICREdONdjluY?usp=sharing"
            target="_blank" class="template-link">Link</a>

        <div class="table-responsive">

            <table id="akreditasiTable" class="table dataTable align-middle">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Nama Dokumen</th>
                        <th>Periode</th>
                        <th>Link Laporan</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($data as $item)
                        <tr>

                            <td>
                                <strong>{{ $loop->iteration }}</strong>
                            </td>

                            <td>

                                <div class="document-title">
                                    {{ $item->name }}
                                    @if ($item->bidang)
                                        <span class="text-muted">({{ $item->bidang }})</span>
                                    @endif
                                </div>

                            </td>

                            <td>

                                <div class="document-date">
                                    {{ $item->periode }}
                                </div>

                            </td>

                            <td>

                                <a href="{{ $item->link_bukti_laporan }}" class="btn-link-custom" target="_blank">

                                    <i class="fas fa-file-alt"></i>
                                    Lihat

                                </a>

                            </td>

                            <td>

                                <div class="action-group">

                                    <a class="btn-action btn-edit" href="{{ route('peningkatan.edit', $item->id) }}">

                                        <i class="fas fa-pen"></i>

                                    </a>

                                    <button class="btn-action btn-delete"
                                        onclick="confirmDelete('{{ route('peningkatan.destroy', $item->id) }}')">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </div>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <script>
        $(document).ready(function() {

            $('#akreditasiTable').DataTable({

                responsive: true,
                pageLength: 10,

                language: {

                    search: "",
                    searchPlaceholder: "Cari laporan peningkatan...",

                    lengthMenu: "Tampilkan _MENU_ data",

                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "›",
                        previous: "‹"
                    },

                    emptyTable: "Belum ada data peningkatan"

                }

            });

        });
    </script>

@endsection
