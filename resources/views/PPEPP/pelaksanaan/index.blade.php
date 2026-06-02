@extends('layouts.app')

@section('title', 'Pelaksanaan')

@section('content')

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

/* =========================
   PAGE STYLE
========================= */

.page-header {
    background: linear-gradient(135deg, #0f172a, #1e3a8a);
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    color: white;
    box-shadow: 0 10px 30px rgba(15,23,42,0.12);
}

.page-title {
    font-size: 18px;
    font-weight: 800;
}

.page-subtitle {
    opacity: .8;
    font-size: 14px;
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
   CARD
========================= */

.table-card {
    background: white;
    border-radius: 24px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(15,23,42,0.06);
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
    box-shadow: 0 4px 20px rgba(15,23,42,0.05);
}

table.dataTable tbody tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(15,23,42,0.08);
}

table.dataTable tbody td {
    border-top: none !important;
    padding: 18px !important;
    vertical-align: middle;
    background: white;
    color: #334155;
}

table.dataTable tbody tr td:first-child {
    border-top-left-radius: 18px;
    border-bottom-left-radius: 18px;
}

table.dataTable tbody tr td:last-child {
    border-top-right-radius: 18px;
    border-bottom-right-radius: 18px;
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
    box-shadow: 0 6px 18px rgba(59,130,246,0.3);
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

.report-title {
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 4px;
}

.report-date {
    color: #64748b;
    font-size: 13px;
}

.badge-empty {
    background: #f1f5f9;
    color: #64748b;
    padding: 8px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.btn-link-custom {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(245,158,11,0.12);
    color: #d97706;
    padding: 10px 14px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    transition: .25s ease;
}

.btn-link-custom:hover {
    background: rgba(245,158,11,0.2);
    color: #b45309;
}

.btn-doc {
    background: rgba(59,130,246,0.12);
    color: #2563eb;
}

.btn-doc:hover {
    background: rgba(59,130,246,0.2);
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
}

.btn-edit {
    background: rgba(245,158,11,0.12);
    color: #d97706;
}

.btn-edit:hover {
    background: #d97706;
    color: white;
    transform: translateY(-2px);
}

.btn-delete {
    background: rgba(239,68,68,0.12);
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
        padding: 24px;
    }

    .page-title {
        font-size: 24px;
    }

    .table-card {
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
        padding: 14px !important;
    }
}

</style>

<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">

    <div>

        <div class="page-title">
            Daftar Laporan {{ auth()->user()->homebase }}
        </div>

        <div class="page-subtitle">
            Kelola laporan pelaksanaan dan dokumen kerjasama
        </div>

    </div>

    <a href="{{ route('pelaksanaan.create') }}" class="btn-add">

        <i class="fas fa-plus"></i>
        Tambah Laporan

    </a>

</div>

<div class="table-card">

    <div class="table-responsive">

        <table id="akreditasiTable" class="table dataTable align-middle">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Nama Laporan</th>
                    <th>Periode</th>
                    <th>Nama Mitra</th>
                    <th>Link Kerjasama</th>
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

                            <div class="report-title">
                                {{ $item->name }}
                            </div>

                        </td>

                        {{-- <td>

                            <div class="report-date">
                                {{ $item->tahun }}
                            </div>

                        </td> --}}

                        <td>

                            <span class="fw-semibold">
                                {{ $item->periode }}
                            </span>

                        </td>

                        <td>

                            @if ($item->nama_mitra)

                                <strong>
                                    {{ $item->nama_mitra }}
                                </strong>

                            @else

                                <span class="badge-empty">
                                    Tidak Ada
                                </span>

                            @endif

                        </td>

                        <td>

                            @if ($item->link_bukti_kerjasama)

                                <a href="{{ $item->link_bukti_kerjasama }}"
                                   class="btn-link-custom btn-doc"
                                   target="_blank">

                                    <i class="fas fa-file-contract"></i>
                                    Lihat

                                </a>

                            @else

                                <span class="badge-empty">
                                    Tidak Ada
                                </span>

                            @endif

                        </td>

                        <td>

                            <div class="action-group">

                                <a class="btn-action btn-edit"
                                   href="{{ route('pelaksanaan.edit', $item->id) }}">

                                    <i class="fas fa-pen"></i>

                                </a>

                                <button class="btn-action btn-delete"
                                        onclick="confirmDelete('{{ route('pelaksanaan.destroy', $item->id) }}')">

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
            searchPlaceholder: "Cari laporan...",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "›",
                previous: "‹"
            },

            emptyTable: "Belum ada data laporan"

        }

    });

});

</script>

@endsection