@extends('layouts.app')

@section('title', 'PPEPP Jurusan')

@section('content')

<style>

    .page-header-modern{

        background: linear-gradient(135deg,#0f172a,#1e3a8a);
        border-radius: 28px;
        padding: 32px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(15,23,42,.10);

    }

    .page-header-modern::before{

        content:'';
        position:absolute;
        width:260px;
        height:260px;
        border-radius:50%;
        background:rgba(255,255,255,.05);
        top:-120px;
        right:-120px;

    }

    .page-title-modern{

        color:white;
        font-size:32px;
        font-weight:800;
        margin-bottom:8px;
        position:relative;
        z-index:2;

    }

    .page-subtitle-modern{

        color:rgba(255,255,255,.85);
        line-height:1.8;
        position:relative;
        z-index:2;

    }

    .table-card{

        background:white;
        border-radius:28px;
        padding:26px;
        box-shadow:0 10px 28px rgba(15,23,42,.06);
        border:1px solid rgba(226,232,240,.7);

    }

    .table-modern{

        border-collapse:separate !important;
        border-spacing:0 14px !important;

    }

    .table-modern thead th{

        border:none !important;
        background:transparent !important;
        color:#64748b !important;
        font-size:13px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:.5px;

    }

    .table-modern tbody tr{

        background:white;
        box-shadow:0 5px 15px rgba(15,23,42,.04);
        transition:.25s ease;

    }

    .table-modern tbody tr:hover{

        transform:translateY(-2px);

    }

    .table-modern tbody td{

        border:none !important;
        padding:20px 16px !important;
        vertical-align:middle;

    }

    .table-modern tbody tr td:first-child{

        border-top-left-radius:16px;
        border-bottom-left-radius:16px;

    }

    .table-modern tbody tr td:last-child{

        border-top-right-radius:16px;
        border-bottom-right-radius:16px;

    }

    .jurusan-name{

        font-size:16px;
        font-weight:700;
        color:#0f172a;

    }

    .jurusan-email{

        color:#64748b;
        font-size:14px;

    }

    .ketua-badge{

        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:10px 14px;
        border-radius:999px;
        background:rgba(37,99,235,.08);
        color:#1d4ed8;
        font-size:13px;
        font-weight:700;

    }

    .btn-modern{

        border:none !important;
        border-radius:14px !important;
        padding:10px 18px !important;
        font-size:13px !important;
        font-weight:700 !important;
        display:inline-flex;
        align-items:center;
        gap:8px;
        transition:.25s ease;

    }

    .btn-modern:hover{

        transform:translateY(-2px);

    }

    .btn-ppepp{

        background:linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        ) !important;

        color:white !important;

        box-shadow:0 10px 20px rgba(37,99,235,.20);

    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select{

        border-radius:14px !important;
        border:1px solid #dbe2ea !important;
        min-height:44px;
        padding-inline:14px;
        box-shadow:none !important;

    }

    .dataTables_wrapper .dataTables_filter input:focus,
    .dataTables_wrapper .dataTables_length select:focus{

        border-color:#2563eb !important;
        box-shadow:0 0 0 4px rgba(37,99,235,.10) !important;

    }

    .dataTables_info,
    .dataTables_length,
    .dataTables_filter,
    .dataTables_paginate{

        margin-top:14px;

    }

    .stats-row{

        margin-bottom:24px;

    }

    .stats-card{

        background:white;
        border-radius:22px;
        padding:22px;
        text-align:center;
        box-shadow:0 10px 25px rgba(15,23,42,.05);
        height:100%;

    }

    .stats-card h3{

        font-size:32px;
        font-weight:800;
        color:#2563eb;
        margin-bottom:6px;

    }

    .stats-card span{

        color:#64748b;
        font-weight:600;

    }

</style>

{{-- HEADER --}}

<div class="page-header-modern">

    <div class="page-title-modern">

        PPEPP Jurusan

    </div>

    <div class="page-subtitle-modern">

        Monitoring dokumen PPEPP seluruh jurusan
        di lingkungan FKIP Universitas Lambung Mangkurat.

    </div>

</div>


{{-- TABLE --}}

<div class="table-card">

    <div class="table-responsive">

        <table id="penetapanTable"
            class="table table-modern align-middle">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Jurusan</th>
                    <th>Email</th>
                    <th>Nama</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($data as $item)

                    <tr>

                        <td width="60">

                            <strong>{{ $loop->iteration }}</strong>

                        </td>

                        <td>

                            <div class="jurusan-name">

                                {{ $item->homebase }}

                            </div>

                        </td>

                        <td>

                            <div class="jurusan-email">

                                {{ $item->email }}

                            </div>

                        </td>

                        <td>

                            <div class="ketua-badge">

                                <i class="bi bi-person-badge-fill"></i>

                                {{ $item->name }}

                            </div>

                        </td>

                        <td width="180">

                            <a class="btn btn-modern btn-ppepp"
                                href="{{ route('jurusan.show', $item->id) }}">

                                <i class="bi bi-folder2-open"></i>

                                Lihat PPEPP

                            </a>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

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

@endsection