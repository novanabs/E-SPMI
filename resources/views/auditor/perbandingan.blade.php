@extends('layouts.app')

@section('title', 'Perbandingan AMI ' . ($user->homebase ?? ''))

@section('content')

    <div class="row align-items-stretch g-3 py-3 py-md-0 my-2 my-md-0 mb-2">


        <div class="col-md-5 d-flex">
            <div class="card shadow-sm h-100 w-100">

                <div class="card-header py-2">
                    <h5 class="mb-0">Penilaian Mandiri Jurusan </h5>
                </div>

                <div class="card-body py-2">
                    <div class="d-flex">
                        <p class="mb-1 me-2">Nilai Akreditasi:</p>
                        <p class="mb-1 fw-bold" id="nilai_jurusan"></p>
                    </div>

                    <div class="d-flex">
                        <p class="mb-1 me-2">Status:</p>
                        <p class="mb-1" id="status_jurusan"></p>
                    </div>

                    <div class="d-flex">
                        <p class="mb-0 me-2">Masa Berlaku:</p>
                        <p class="mb-0 fw-bold" id="masa_jurusan"></p>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-5 d-flex">
            <div class="card shadow-sm h-100 w-100">

                <div class="card-header py-2">
                    <h5 class="mb-0">Penilaian Auditor</h5>
                </div>

                <div class="card-body py-2">
                    <div class="d-flex">
                        <p class="mb-1 me-2">Nilai Akreditasi:</p>
                        <p class="mb-1 fw-bold" id="nilai_fakultas"></p>
                    </div>

                    <div class="d-flex">
                        <p class="mb-1 me-2">Status:</p>
                        <p class="mb-1" id="status_fkip"></p>
                    </div>

                    <div class="d-flex">
                        <p class="mb-0 me-2">Masa Berlaku:</p>
                        <p class="mb-0 fw-bold" id="masa_fkip"></p>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-2 d-flex">
            <div class="card shadow-sm h-100 w-100">

                <div class="card-header py-2">
                    <h5 class="mb-0 text-nowrap text-center">Selisih</h5>
                </div>

                <div class="card-body py-2 d-flex align-items-center justify-content-center">
                    <h3 class="mb-0" id="selisih"></h3>
                </div>

            </div>
        </div>

    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Elemen</h3>
        {{-- <a href="{{ route('jurusan.create') }}" class="btn btn-sm btn-primary" id="btnTambah">Tambah</a> --}}
        <button class="btn btn-sm btn-primary ms-auto" onclick="previewPdf()">
            Export PDF
        </button>
        <a class="btn btn-success btn-sm ms-2" href="{{ route('auditor.evaluasi', $assigned->id) }}">
            Isi Evaluasi
        </a>
    </div>
    <div class="table-responsive">
        <table id="penetapanTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kriteria</th> <!-- Homebase -->
                    <th>Elemen</th>
                    <th>Penilaian Jurusan</th>
                    <th>Penilaian Auditor</th>
                    <th>Selisih</th>
                    <th>Temuan</th>
                    <th>Saran</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dinamis sesuai kebutuhan -->
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kriteria->name }}</td>
                        <td>{{ $item->elemen }}</td>
                        {{-- Jurusan --}}
                        <td class="nilai-jurusan" data-nilai="{{ $item->userMatrik->nilai_total ?? 0 }}">
                            {{ $item->userMatrik->nilai_total ?? '-' }}
                        </td>

                        {{-- FKIP --}}
                        <td class="nilai-fkip" data-nilai="{{ $item->userMatrikByUser->nilai_total ?? 0 }}">
                            {{ $item->userMatrikByUser->nilai_total ?? '-' }}
                        </td>
                        <td>
                            {{ !is_null(data_get($item, 'userMatrik.nilai_total')) &&
                            !is_null(data_get($item, 'userMatrikByUser.nilai_total'))
                                ? abs(data_get($item, 'userMatrik.nilai_total') - data_get($item, 'userMatrikByUser.nilai_total'))
                                : '-' }}
                        </td>
                        <td>{!! $item->auditorTemuan ?? '-' !!}</td>
                        <td>{!! $item->auditorSaran ?? '-' !!}</td>


                        {{-- <td>
                            <a class="btn btn-warning btn-sm" href="{{ route('jurusan.edit', $item->id) }}">
                                Edit
                            </a>
                            <button class="btn btn-danger btn-sm"
                                onclick="confirmDelete('{{ route('jurusan.destroy', $item->id) }}')">
                                Hapus
                            </button>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="previewPdfModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Preview Laporan Evaluasi Diri {{ auth()->user()->homebase ?? '' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="previewPdfContent">
                    <div class="text-center text-muted">
                        Memuat preview...
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="{{ url('/export/export-pdf/perbandingan/upm/' . $user->id) }}" target="_blank"
                        class="btn btn-primary">
                        Export
                    </a>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#penetapanTable').DataTable({
                pageLength: 65, // Jumlah data per halaman
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

    {{-- Hitung akumulasi --}}

    <script>
        function hitungAkreditasi(NA, syarat3, syarat5) {
            let status = "";
            let masa = "";

            if (NA >= 361) {
                if (syarat5) {
                    status = "Terakreditasi Unggul";
                    masa = "5 Tahun";
                } else if (syarat3) {
                    status = "Terakreditasi Unggul";
                    masa = "3 Tahun";
                } else {
                    status = "Terakreditasi";
                    masa = "5 Tahun";
                }
            } else if (NA >= 321) {
                if (syarat5) {
                    status = "Terakreditasi Unggul";
                    masa = "5 Tahun";
                } else if (syarat3) {
                    status = "Terakreditasi Unggul";
                    masa = "3 Tahun";
                } else {
                    status = "Terakreditasi";
                    masa = "5 Tahun";
                }
            } else if (NA >= 200) {
                status = "Terakreditasi";
                masa = "5 Tahun";
            } else {
                status = "Tidak Terakreditasi";
                masa = "-";
            }

            return { status, masa };
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let totalJurusan = 0;
            let totalFKIP = 0;

            document.querySelectorAll(".nilai-jurusan").forEach(el => {
                totalJurusan += parseFloat(el.dataset.nilai) || 0;
            });

            document.querySelectorAll(".nilai-fkip").forEach(el => {
                totalFKIP += parseFloat(el.dataset.nilai) || 0;
            });

            document.getElementById("nilai_jurusan").innerHTML = totalJurusan;
            document.getElementById("nilai_fakultas").innerHTML = totalFKIP;

            let hasilJurusan = hitungAkreditasi(totalJurusan);
            document.getElementById("status_jurusan").innerHTML = hasilJurusan.status;
            document.getElementById("masa_jurusan").innerHTML = hasilJurusan.masa;

            let hasilFKIP = hitungAkreditasi(totalFKIP);
            document.getElementById("status_fkip").innerHTML = hasilFKIP.status;
            document.getElementById("masa_fkip").innerHTML = hasilFKIP.masa;

            document.getElementById("selisih").innerHTML = Math.abs(totalJurusan - totalFKIP).toFixed(2);
        });
    </script>

    {{-- Ini script untuk Export --}}
    <script>
        const jurusanId = {{ $user->id }};

        function previewPdf() {
            const modal = new bootstrap.Modal(document.getElementById('previewPdfModal'));
            const content = document.getElementById('previewPdfContent');
            console.log('CONTENT:', content);
            modal.show();

            content.innerHTML = '<div class="text-center text-muted">Memuat preview...</div>';

            fetch(`/export/preview/perbandingan/upm/${jurusanId}`)
                .then(res => res.text())
                .then(html => {
                    console.log(html);
                    content.innerHTML = html;
                })
                .catch(() => {
                    content.innerHTML = '<div class="text-danger">Gagal memuat preview</div>';
                });


        }
    </script>

@endsection
