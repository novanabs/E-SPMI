<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPEPP {{ $data->homebase }} — Siklus Penjaminan Mutu Internal</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/ulm.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.min.js"></script>

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 50%, #f1f5f9 100%);
        background-attachment: fixed;
        min-height: 100vh;
    }

    .ppepp-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 24px 60px;
    }

    .ppepp-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        font-weight: 600;
        text-decoration: none;
        margin-bottom: 24px;
        transition: color .2s;
        font-size: 15px;
    }

    .ppepp-back:hover {
        color: #2563eb;
    }

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

    .aspect-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(59, 130, 246, 0.12);
        color: #2563eb;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .btn-view:hover {
        color: white;
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
        min-height: 42px;
        padding: 8px 14px;
        box-shadow: none !important;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .10) !important;
    }
</style>
</head>
<body>

<div class="ppepp-wrapper">

    <a href="{{ route('ppepp.index') }}" class="ppepp-back">
        ← Kembali ke PPEPP
    </a>

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
                <button class="nav-link active" id="penetapan-tab" data-bs-toggle="tab" data-bs-target="#penetapan">Penetapan</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="pelaksanaan-tab" data-bs-toggle="tab" data-bs-target="#pelaksanaan">Pelaksanaan</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="evaluasi-tab" data-bs-toggle="tab" data-bs-target="#evaluasi">Evaluasi</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="pengendalian-tab" data-bs-toggle="tab" data-bs-target="#pengendalian">Pengendalian</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="peningkatan-tab" data-bs-toggle="tab" data-bs-target="#peningkatan">Peningkatan</button>
            </li>
        </ul>
    </div>

    <div class="content-card">
    <div class="tab-content" id="myTabContent">

    {{-- PENETAPAN --}}
    <div class="tab-pane fade show active" id="penetapan">
        <div class="table-responsive">
            <table class="table table-modern datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokumen</th>
                        <th>Bidang</th>
                        <th>Masa Berlaku</th>
                        <th>Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penetapan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>@if($item->bidang)<span class="aspect-badge"><i class="bi {{ $item->bidang == 'Pendidikan' ? 'bi-book' : ($item->bidang == 'Penelitian' ? 'bi-flask' : 'bi-hand-index-thumb') }}"></i> {{ $item->bidang }}</span>@else - @endif</td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_penetapan)->translatedFormat('d M Y') }}
                                {{ $item->tanggal_berakhir ? '- ' . \Carbon\Carbon::parse($item->tanggal_berakhir)->translatedFormat('d M Y') : '' }}
                            </td>
                            <td>
                                <a href="{{ $item->link_bukti_dokumen }}" target="_blank" class="btn btn-view">Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- PELAKSANAAN --}}
    <div class="tab-pane fade" id="pelaksanaan">
        <div class="table-responsive">
            <table class="table table-modern datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Laporan</th>
                        <th>Bidang</th>
                        <th>Periode</th>
                        <th>Link Kerjasama</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelaksanaan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>@if($item->bidang)<span class="aspect-badge"><i class="bi {{ $item->bidang == 'Pendidikan' ? 'bi-book' : ($item->bidang == 'Penelitian' ? 'bi-flask' : 'bi-hand-index-thumb') }}"></i> {{ $item->bidang }}</span>@else - @endif</td>
                            <td>{{ $item->periode }}</td>
                            <td>
                                @if ($item->link_bukti_kerjasama)
                                    <a href="{{ $item->link_bukti_kerjasama }}" target="_blank" class="btn btn-success">Lihat</a>
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
    <div class="tab-pane fade" id="evaluasi">
        <div class="table-responsive">
            <table class="table table-modern datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Laporan</th>
                        <th>Bidang</th>
                        <th>Jenis Laporan</th>
                        <th>Periode</th>
                        <th>Link Laporan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluasi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name ?? '-' }}</td>
                            <td>{{ $item->bidang }}</td>
                            <td>{{ $item->jenis_laporan }}</td>
                            <td>{{ $item->periode }}</td>
                            <td>
                                <a href="{{ $item->link_bukti_laporan }}" target="_blank" class="btn btn-view">Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- PENGENDALIAN --}}
    <div class="tab-pane fade" id="pengendalian">
        <div class="table-responsive">
            <table class="table table-modern datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokumen</th>
                        <th>Bidang</th>
                        <th>Periode</th>
                        <th>Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengendalian as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>@if($item->bidang)<span class="aspect-badge"><i class="bi {{ $item->bidang == 'Pendidikan' ? 'bi-book' : ($item->bidang == 'Penelitian' ? 'bi-flask' : 'bi-hand-index-thumb') }}"></i> {{ $item->bidang }}</span>@else - @endif</td>
                            <td>{{ $item->periode }}</td>
                            <td>
                                <a href="{{ $item->link_bukti_laporan }}" target="_blank" class="btn btn-view">Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- PENINGKATAN --}}
    <div class="tab-pane fade" id="peningkatan">
        <div class="table-responsive">
            <table class="table table-modern datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokumen</th>
                        <th>Bidang</th>
                        <th>Periode</th>
                        <th>Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peningkatan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>@if($item->bidang)<span class="aspect-badge"><i class="bi {{ $item->bidang == 'Pendidikan' ? 'bi-book' : ($item->bidang == 'Penelitian' ? 'bi-flask' : 'bi-hand-index-thumb') }}"></i> {{ $item->bidang }}</span>@else - @endif</td>
                            <td>{{ $item->periode }}</td>
                            <td>
                                <a href="{{ $item->link_bukti_laporan }}" target="_blank" class="btn btn-view">Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            pageLength: 10,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: { first: "Pertama", last: "Terakhir", next: "Berikutnya", previous: "Sebelumnya" },
                emptyTable: "Tidak ada data"
            }
        });
    });
</script>
</body>
</html>
