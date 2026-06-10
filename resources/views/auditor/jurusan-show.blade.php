@extends('layouts.app')

@section('title', 'PPEPP Jurusan')

@section('content')

<style>

    .ppepp-header{

        background: linear-gradient(135deg,#0f172a,#1e3a8a);
        border-radius: 28px;
        padding: 32px;
        color: white;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;

    }

    .ppepp-header::before{

        content:'';
        position:absolute;
        width:250px;
        height:250px;
        border-radius:50%;
        background:rgba(255,255,255,.05);
        right:-100px;
        top:-100px;

    }

    .ppepp-title{

        font-size:32px;
        font-weight:800;
        margin-bottom:8px;
        position:relative;
        z-index:2;

    }

    .ppepp-subtitle{

        color:rgba(255,255,255,.85);
        position:relative;
        z-index:2;

    }

    .stats-card{

        background:white;
        border-radius:22px;
        padding:24px;
        text-align:center;
        box-shadow:0 10px 25px rgba(15,23,42,.05);
        height:100%;

    }

    .stats-card h2{

        font-size:34px;
        font-weight:800;
        color:#2563eb;
        margin-bottom:6px;

    }

    .stats-card span{

        color:#64748b;
        font-weight:600;

    }

    .ppepp-tabs{

        background:white;
        padding:10px;
        border-radius:20px;
        box-shadow:0 10px 25px rgba(15,23,42,.05);
        margin-bottom:24px;

    }

    .ppepp-tabs .nav-link{

        border:none !important;
        border-radius:14px !important;
        font-weight:700;
        color:#64748b;

    }

    .ppepp-tabs .nav-link.active{

        background:linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

        color:white;

    }

    .content-card{

        background:white;
        border-radius:24px;
        padding:24px;
        box-shadow:0 10px 25px rgba(15,23,42,.05);

    }

    .table-modern{

        border-collapse:separate !important;
        border-spacing:0 12px !important;

    }

    .table-modern thead th{

        border:none !important;
        background:transparent !important;
        color:#64748b;
        font-size:13px;
        text-transform:uppercase;
        font-weight:800;

    }

    .table-modern tbody tr{

        background:white;
        box-shadow:0 5px 15px rgba(15,23,42,.04);

    }

    .table-modern tbody td{

        padding:18px 14px !important;
        vertical-align:middle;
        border:none !important;

    }

    .table-modern tbody tr td:first-child{

        border-top-left-radius:14px;
        border-bottom-left-radius:14px;

    }

    .table-modern tbody tr td:last-child{

        border-top-right-radius:14px;
        border-bottom-right-radius:14px;

    }

    .btn-view{

        background:linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

        color:white !important;
        border:none;
        border-radius:12px;
        font-weight:700;
        padding:8px 14px;

    }

    .btn-view:hover{

        color:white;

    }

</style>

{{-- HEADER --}}

<div class="ppepp-header">

    <div class="ppepp-title">

        PPEPP {{ $data->homebase }}

    </div>

    <div class="ppepp-subtitle">

        Ketua Jurusan :
        <strong>{{ $data->ketua }}</strong>

    </div>

</div>

{{-- STATISTIK --}}

<div class="row g-4 mb-4">

    <div class="col-md-2">
        <div class="stats-card">
            <h2>{{ $penetapan->count() }}</h2>
            <span>Penetapan</span>
        </div>
    </div>

    <div class="col-md-2">
        <div class="stats-card">
            <h2>{{ $pelaksanaan->count() }}</h2>
            <span>Pelaksanaan</span>
        </div>
    </div>

    <div class="col-md-2">
        <div class="stats-card">
            <h2>{{ $evaluasi->count() }}</h2>
            <span>Evaluasi</span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stats-card">
            <h2>{{ $pengendalian->count() }}</h2>
            <span>Pengendalian</span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stats-card">
            <h2>{{ $peningkatan->count() }}</h2>
            <span>Peningkatan</span>
        </div>
    </div>

</div>

{{-- TABS --}}

<ul class="nav nav-pills ppepp-tabs" id="myTab">

    <li class="nav-item">
        <button class="nav-link active"
            data-bs-toggle="tab"
            data-bs-target="#penetapan">
            Penetapan
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link"
            data-bs-toggle="tab"
            data-bs-target="#pelaksanaan">
            Pelaksanaan
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link"
            data-bs-toggle="tab"
            data-bs-target="#evaluasi">
            Evaluasi
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link"
            data-bs-toggle="tab"
            data-bs-target="#pengendalian">
            Pengendalian
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link"
            data-bs-toggle="tab"
            data-bs-target="#peningkatan">
            Peningkatan
        </button>
    </li>

</ul>

<div class="tab-content">

    {{-- PENETAPAN --}}

    <div class="tab-pane fade show active" id="penetapan">

        <div class="content-card">

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

                    @foreach($penetapan as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}{!! $item->bidang ? ' <strong>(' . e($item->bidang) . ')</strong>' : '' !!}</td>
                            <td> {{ \Carbon\Carbon::parse($item->tanggal_penetapan)->translatedFormat('d M Y') }}
    {{$item->tanggal_berakhir ? '- ' . \Carbon\Carbon::parse($item->tanggal_berakhir)->translatedFormat('d M Y') : '' }}</td>

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

    <div class="tab-pane fade" id="pelaksanaan">

        <div class="content-card">

            <table class="table table-modern datatable">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Laporan</th>
                        <th>Mitra</th>
                        <th>Link Laporan</th>
                        <th>Dokumen</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($pelaksanaan as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}{!! $item->bidang ? ' <strong>(' . e($item->bidang) . ')</strong>' : '' !!}</td>
                            <td>{{ $item->nama_mitra ?? '-' }}</td>
                            <td>
                            <a href="{{ $item->link_bukti_laporan }}" target="_blank" class="btn  btn-success">
                                {{ $item->tahun }} - Ganjil
                            </a>

                            @if ($item->link_bukti_laporan_genap)
                                <a href="{{ $item->link_bukti_laporan_genap }}" target="_blank" class="btn  btn-success">
                                    {{ $item->tahun }} - Genap
                                </a>
                            @endif
                        </td>

                            <td>

                                <a href="{{ $item->link_bukti_kerjasama }}"
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

    {{-- EVALUASI --}}

    <div class="tab-pane fade" id="evaluasi">

        <div class="content-card">

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

                                {{ $item->tahun }} - Ganjil

                            </a>

                            @if ($item->link_bukti_laporan_genap)
                                <a href="{{ $item->link_bukti_laporan_genap }}"
                                    target="_blank"
                                    class="btn btn-view">

                                    {{ $item->tahun }} - Genap

                                </a>
                            @endif

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        </div>

    </div>

    {{-- PENGENDALIAN --}}

    <div class="tab-pane fade" id="pengendalian">

        <div class="content-card">

            <table class="table table-modern datatable">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Tahun</th>
                    <th>Dokumen</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($pengendalian as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->name }}</td>

                        <td>
                            {{ $item->tahun }}
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

    <div class="tab-pane fade" id="peningkatan">

        <div class="content-card">

            <table class="table table-modern datatable">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Tahun</th>
                    <th>Dokumen</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($peningkatan as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->name }}</td>

                        <td>
                            {{ $item->tahun }}
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

</div>

<script>

$(document).ready(function(){

    $('.datatable').DataTable({

        pageLength:10,

        language:{

            search:"Cari:",
            lengthMenu:"Tampilkan _MENU_ data",
            info:"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            paginate:{
                first:"Pertama",
                last:"Terakhir",
                next:"Berikutnya",
                previous:"Sebelumnya"
            },

            emptyTable:"Tidak ada data"

        }

    });

});

</script>

@endsection