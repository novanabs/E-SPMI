@extends('layouts.app')

@section('title', 'Perbandingan Evaluasi Diri ' . ($user->homebase ?? ''))

@section('content')

    <div class="row align-items-stretch mb-3">

        <div class="col-md-5 d-flex">
            <div class="card shadow-sm h-100 w-100">

                <div class="card-header py-2">
                    <h5 class="mb-0">Penilaian Mandiri Jurusan</h5>
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
                        <p class="mb-0 me-2">Peringkat:</p>
                        <p class="mb-0" id="peringkat_jurusan"></p>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-5 d-flex">
            <div class="card shadow-sm h-100 w-100">

                <div class="card-header py-2">
                    <h5 class="mb-0">Penilaian UPM</h5>
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
                        <p class="mb-0 me-2">Peringkat:</p>
                        <p class="mb-0" id="peringkat_fkip"></p>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-2 d-flex">
            <div class="card shadow-sm h-100 w-100">

                <div class="card-header py-2">
                    <h5 class="mb-0">Selisih</h5>
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
    </div>
    <div class="table-responsive">
        <table id="penetapanTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kriteria</th> <!-- Homebase -->
                    <th>Elemen</th>
                    <th>Penilaian Jurusan</th>
                    <th>Penilaian UPM</th>
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
                        <td>{{ $item->userMatrikByUser->temuan ?? '-' }}</td>
                        <td>{{ $item->userMatrikByUser->saran ?? '-' }}</td>


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
        function hitungAkreditasi(NA) {
            let status = "";
            let peringkat = "";

            if (NA >= 361) {
                status = "Terakreditasi";
                peringkat = "Unggul";
            } else if (NA >= 301) {
                status = "Terakreditasi";
                peringkat = "Baik Sekali";
            } else if (NA >= 200) {
                status = "Terakreditasi";
                peringkat = "Baik";
            } else {
                status = "Tidak Terakreditasi";
                peringkat = "-";
            }

            return {
                status,
                peringkat
            };
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let totalJurusan = 0;
            let totalFKIP = 0;

            // Akumulasi Jurusan
            document.querySelectorAll(".nilai-jurusan").forEach(el => {
                totalJurusan += parseFloat(el.dataset.nilai) || 0;
                console.log(totalJurusan)
            });

            // Akumulasi FKIP
            document.querySelectorAll(".nilai-fkip").forEach(el => {
                totalFKIP += parseFloat(el.dataset.nilai) || 0;
            });

            // Total Gabungan
            let total = totalJurusan + totalFKIP;

            console.log("Jurusan:", totalJurusan);
            console.log("FKIP:", totalFKIP);
            console.log("Total:", total);

            // document.getElementById("total_nilai_semua").innerText = total;

            let hasil = hitungAkreditasi(total);
            // document.getElementById("status").innerText = hasil.status;
            // document.getElementById("peringkat").innerText = hasil.peringkat;

            // Ini yang benar
            document.getElementById("nilai_jurusan").innerHTML = totalJurusan;
            document.getElementById("nilai_fakultas").innerHTML = totalFKIP;

            let hasilJurusan = hitungAkreditasi(totalJurusan);
            document.getElementById("status_jurusan").innerHTML = hasilJurusan.status;
            document.getElementById("peringkat_jurusan").innerHTML = hasilJurusan.peringkat;

            let hasilFKIP = hitungAkreditasi(totalFKIP);
            document.getElementById("status_fkip").innerHTML = hasilFKIP.status;
            document.getElementById("peringkat_fkip").innerHTML = hasilFKIP.peringkat;

            // Selisih
            document.getElementById("selisih").innerHTML = Math.abs(totalJurusan - totalFKIP)
        });
    </script>

@endsection
