@extends('layouts.app')

@section('title', 'Penetapan')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Dokumen FKIP</h2>
        <button class="btn btn-primary" id="btnTambah">Tambah Dokumen</button>
    </div>
    <div class="table-responsive">
        <table id="akreditasiTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Waktu Unggah</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dinamis sesuai kebutuhan -->
                <tr>
                    <td>1</td>
                    <td>Panduan Akademik FKIP 2024</td>
                    <td>02-10-2025</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-info">Riwayat</button>
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Tata Pemong FKIP ULM</td>
                    <td>02-10-2025</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-info">Riwayat</button>
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>

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
    </div>

@endsection
