@extends('layouts.app')

@section('title', 'PPEPP Jurusan')

@section('content')

    <h3 class="mb-3">PPEPP {{ $data->homebase }}</h3>
    <p><span class="fw-semibold">Ketua : </span>{{ $data->ketua }}</p>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="penetapan-tab" data-bs-toggle="tab" data-bs-target="#penetapan" type="button"
                role="tab" aria-controls="penetapan" aria-selected="true">Penetapan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pelaksanaan-tab" data-bs-toggle="tab" data-bs-target="#pelaksanaan" type="button"
                role="tab" aria-controls="pelaksanaan" aria-selected="false">Pelaksanaan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="evaluasi-tab" data-bs-toggle="tab" data-bs-target="#evaluasi" type="button"
                role="tab" aria-controls="evaluasi" aria-selected="false">Evaluasi</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pengendalian-tab" data-bs-toggle="tab" data-bs-target="#pengendalian"
                type="button" role="tab" aria-controls="pengendalian" aria-selected="false">Pengendalian</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="peningkatan-tab" data-bs-toggle="tab" data-bs-target="#peningkatan" type="button"
                role="tab" aria-controls="peningkatan" aria-selected="false">Peningkatan</button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="penetapan" role="tabpanel" aria-labelledby="penetapan-tab">
            <div class="table-responsive">
                <table id="penetapanTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Dokumen</th>
                            <th>Waktu Unggah</th>
                            <th>Link Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penetapan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->created_at->translatedFormat('l, d M Y') }}</td>
                                <td>
                                    <a href="{{ $item->link_bukti_dokumen }}" class="btn btn-sm btn-primary"
                                        target="_blank">Link</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="pelaksanaan" role="tabpanel" aria-labelledby="pelaksanaan-tab">
            <div class="table-responsive">
                <table id="pelaksanaanTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Laporan</th>
                            <th>Waktu Unggah</th>
                            <th>Link Laporan</th>
                            <th>Nama Mitra</th>
                            <th>Dokumen Kerjasama</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelaksanaan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->created_at->translatedFormat('l, d M Y') }}</td>
                                <td>
                                    <a href="{{ $item->link_bukti_laporan }}" class="btn btn-sm btn-warning"
                                        target="_blank">Link</a>
                                </td>
                                <td>
                                    @if ($item->nama_mitra)
                                        {{ $item->nama_mitra }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($item->link_bukti_kerjasama)
                                        <a href="{{ $item->link_bukti_kerjasama }}" class="btn btn-sm btn-primary"
                                            target="_blank">Link</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="evaluasi" role="tabpanel" aria-labelledby="evaluasi-tab">
            <div class="table-responsive">
                <table id="evaluasiTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aspek</th>
                            <th>Jenis Laporan</th>
                            <th>Waktu Unggah</th>
                            <th>Link Laporan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($evaluasi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->aspek }}</td>
                                <td>{{ $item->jenis_laporan }}</td>
                                <td>{{ $item->created_at->translatedFormat('l, d M Y') }}</td>
                                <td>
                                    <a href="{{ $item->link_bukti_laporan }}" class="btn btn-sm btn-primary"
                                        target="_blank">Link</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="pengendalian" role="tabpanel" aria-labelledby="pengendalian-tab">
            <div class="table-responsive">
                <table id="pengendalianTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Dokumen</th>
                            <th>Waktu Unggah</th>
                            <th>Link Laporan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengendalian as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->created_at->translatedFormat('l, d M Y') }}</td>
                                <td>
                                    <a href="{{ $item->link_bukti_laporan }}" class="btn btn-sm btn-primary"
                                        target="_blank">Link</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="peningkatan" role="tabpanel" aria-labelledby="peningkatan-tab">
            <div class="table-responsive">
                <table id="akreditasiTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Dokumen</th>
                            <th>Waktu Unggah</th>
                            <th>Link Laporan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peningkatan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->created_at->translatedFormat('l, d M Y') }}</td>
                                <td>
                                    <a href="{{ $item->link_bukti_laporan }}" class="btn btn-sm btn-primary"
                                        target="_blank">Link</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

    <script>
        $(document).ready(function() {
            $('#pelaksanaanTable').DataTable({
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

    <script>
        $(document).ready(function() {
            $('#evaluasiTable').DataTable({
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

    <script>
        $(document).ready(function() {
            $('#pengendalianTable').DataTable({
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

    <script>
        $(document).ready(function() {
            $('#akreditasiTable').DataTable({
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