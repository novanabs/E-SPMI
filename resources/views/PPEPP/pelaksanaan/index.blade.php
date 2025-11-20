@extends('layouts.app')

@section('title', 'Pelaksanaan')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar LAPORAN FKIP</h2>
        <button class="btn btn-primary" id="btnTambah">Tambah LAPORAN</button>
    </div>
    <div class="table-responsive">
        <table id="akreditasiTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Laporan</th>
                    <th>Link Laporan</th>
                    <th>Nama Mitra</th>
                    <th>Dokumen Kerjasama</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dinamis sesuai kebutuhan -->
                <tr>
                    <td>1</td>
                    <td>Kegiatan Sosialisasi Jurusan</td>
                    <td> <button class="btn btn-sm btn-warning">Link</button></td>
                    <td>-</td>
                    <td> <button class="btn btn-sm btn-info">Link</button></td>
                    <td>
                        <button class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-info">Riwayat</button>
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>


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
                    }
                }
            });
        });
    </script>

@endsection
