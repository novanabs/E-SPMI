@extends('layouts.app')

@section('title', 'PPEPP Jurusan')

@section('content')

<style>
    .ppepp-header {
        background: linear-gradient(135deg, #0f172a, #1e3a8a);
        border-radius: 28px;
        padding: 32px;
        color: white;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(15, 23, 42, .10);
    }

    .ppepp-header::before {
        content: '';
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .05);
        top: -120px;
        right: -120px;
    }

    .ppepp-title {
        font-size: 32px;
        font-weight: 800;
        position: relative;
        z-index: 2;
    }

    .ppepp-subtitle {
        color: rgba(255, 255, 255, .85);
        margin-top: 8px;
        position: relative;
        z-index: 2;
    }

    .stats-card {
        background: white;
        border-radius: 22px;
        padding: 22px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(15, 23, 42, .05);
        height: 100%;
    }

    .stats-card h3 {
        color: #2563eb;
        font-size: 30px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .stats-card span {
        color: #64748b;
        font-weight: 600;
    }

    .tabs-wrapper {
        background: white;
        border-radius: 22px;
        padding: 12px;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, .05);
    }

    .ppepp-tabs .nav-link {
        border: none !important;
        border-radius: 14px !important;
        font-weight: 700;
        color: #64748b;
        padding: 12px 18px;
    }

    .ppepp-tabs .nav-link.active {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
    }

    .content-card {
        background: white;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, .05);
    }

    .table-modern {
        border-collapse: separate !important;
        border-spacing: 0 12px !important;
    }

    .table-modern thead th {
        border: none !important;
        background: transparent !important;
        color: #64748b !important;
        font-size: 13px;
        text-transform: uppercase;
        font-weight: 800;
    }

    .table-modern tbody tr {
        background: white;
        box-shadow: 0 5px 15px rgba(15, 23, 42, .04);
    }

    .table-modern tbody td {
        border: none !important;
        vertical-align: middle;
        padding: 18px 16px !important;
    }

    .table-modern tbody tr td:first-child {
        border-top-left-radius: 14px;
        border-bottom-left-radius: 14px;
    }

    .table-modern tbody tr td:last-child {
        border-top-right-radius: 14px;
        border-bottom-right-radius: 14px;
    }

    .btn-view {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white !important;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        padding: 8px 16px;
    }

    .btn-view:hover {
        color: white;
    }
</style>

<div class="ppepp-header">

    <div class="ppepp-title">
        PPEPP {{ $data->homebase }}
    </div>

    <div class="ppepp-subtitle">
        {{ $data->jabatan }} :
        <strong>{{ $data->name }}</strong>
    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-md">
        <div class="stats-card">
            <h3>{{ $penetapan->count() }}</h3>
            <span>Penetapan</span>
        </div>
    </div>

    <div class="col-md">
        <div class="stats-card">
            <h3>{{ $pelaksanaan->count() }}</h3>
            <span>Pelaksanaan</span>
        </div>
    </div>

    <div class="col-md">
        <div class="stats-card">
            <h3>{{ $evaluasi->count() }}</h3>
            <span>Evaluasi</span>
        </div>
    </div>

    <div class="col-md">
        <div class="stats-card">
            <h3>{{ $pengendalian->count() }}</h3>
            <span>Pengendalian</span>
        </div>
    </div>

    <div class="col-md">
        <div class="stats-card">
            <h3>{{ $peningkatan->count() }}</h3>
            <span>Peningkatan</span>
        </div>
    </div>

</div>

<div class="tabs-wrapper">

    <ul class="nav nav-pills ppepp-tabs" id="myTab" role="tablist">

        <li class="nav-item">
            <button class="nav-link active"
                id="penetapan-tab"
                data-bs-toggle="tab"
                data-bs-target="#penetapan">
                Penetapan
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                id="pelaksanaan-tab"
                data-bs-toggle="tab"
                data-bs-target="#pelaksanaan">
                Pelaksanaan
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                id="evaluasi-tab"
                data-bs-toggle="tab"
                data-bs-target="#evaluasi">
                Evaluasi
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                id="pengendalian-tab"
                data-bs-toggle="tab"
                data-bs-target="#pengendalian">
                Pengendalian
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                id="peningkatan-tab"
                data-bs-toggle="tab"
                data-bs-target="#peningkatan">
                Peningkatan
            </button>
        </li>

    </ul>

</div>

<div class="content-card">

<div class="tab-content" id="myTabContent">

{{-- PENETAPAN --}}

<div class="tab-pane fade show active"
    id="penetapan">

    <div class="table-responsive">

        <table class="table table-modern datatable">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Masa Berlaku</th>
                    <th>Dokumen</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($penetapan as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->name }}{!! $item->bidang ? ' <strong>(' . e($item->bidang) . ')</strong>' : '' !!}</td>

                        <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_penetapan)->translatedFormat('d M Y') }}
    {{$item->tanggal_berakhir ? '- ' . \Carbon\Carbon::parse($item->tanggal_berakhir)->translatedFormat('d M Y') : '' }}
                        </td>

                        <td>

                            <a href="{{ $item->link_bukti_dokumen }}"
                                target="_blank"
                                class="btn btn-view">

                                Lihat

                            </a>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

{{-- PELAKSANAAN --}}

<div class="tab-pane fade"
    id="pelaksanaan">

    <div class="table-responsive">

        <table class="table table-modern datatable">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama Laporan</th>
                    <th>Periode</th>
                    <th>Link Kerjasama</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($pelaksanaan as $item)
                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->name }}{!! $item->bidang ? ' <strong>(' . e($item->bidang) . ')</strong>' : '' !!}</td>

                        <td>{{ $item->periode }}</td>

                        <td>

                            @if ($item->link_bukti_kerjasama)
                                <a href="{{ $item->link_bukti_kerjasama }}"
                                    target="_blank"
                                    class="btn btn-success">
                                    Lihat
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

{{-- EVALUASI --}}

<div class="tab-pane fade"
    id="evaluasi">

    <div class="table-responsive">

        <table class="table table-modern datatable">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Bidang</th>
                    <th>Jenis Laporan</th>
                    {{-- <th>Tanggal</th> --}}
                    <th>Link Laporan</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($evaluasi as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->bidang }}</td>

                        <td>{{ $item->jenis_laporan }}</td>

                        {{-- <td>
                            {{ $item->created_at->translatedFormat('d M Y') }}
                        </td> --}}

                        <td>

                            <a href="{{ $item->link_bukti_laporan }}"
                                target="_blank"
                                class="btn btn-view">

                                Lihat

                            </a>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

{{-- PENGENDALIAN --}}

<div class="tab-pane fade"
    id="pengendalian">

    <div class="table-responsive">

        <table class="table table-modern datatable">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Periode</th>
                    <th>Dokumen</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($pengendalian as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->name }}{!! $item->bidang ? ' <strong>(' . e($item->bidang) . ')</strong>' : '' !!}</td>

                        <td>
                            {{ $item->periode }}
                        </td>

                        <td>

                            <a href="{{ $item->link_bukti_laporan }}"
                                target="_blank"
                                class="btn btn-view">

                                Lihat

                            </a>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

{{-- PENINGKATAN --}}

<div class="tab-pane fade"
    id="peningkatan">

    <div class="table-responsive">

        <table class="table table-modern datatable">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Periode</th>
                    <th>Dokumen</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($peningkatan as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->name }}{!! $item->bidang ? ' <strong>(' . e($item->bidang) . ')</strong>' : '' !!}</td>

                        <td>
                            {{ $item->periode }}
                        </td>

                        <td>

                            <a href="{{ $item->link_bukti_laporan }}"
                                target="_blank"
                                class="btn btn-view">

                                Lihat

                            </a>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

</div> {{-- END TAB CONTENT --}}

</div> {{-- END CONTENT CARD --}}

<script>

    $(document).ready(function() {

        $('.datatable').DataTable({

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