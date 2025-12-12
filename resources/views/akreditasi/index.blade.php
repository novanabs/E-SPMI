@extends('layouts.app')

@section('title', 'Jurusan')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Akreditasi Jurusan FKIP ULM</h2>
        <button class="btn btn-primary" id="btnTambah">Tambah Akreditasi</button>
    </div>
    <div class="table-responsive">
        <table id="akreditasiTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jurusan/Prodi</th>
                    <th>Tanggal Diterbitkan</th>
                    <th>Tanggal Habis</th>
                    <th>Predikat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dinamis sesuai kebutuhan -->
                <tr>
                    <td>1</td>
                    <td>Pendidikan Matematika</td>
                    <td>2022-01-15</td>
                    <td>2027-01-15</td>
                    <td>Unggul</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Pendidikan Bahasa Inggris</td>
                    <td>2021-08-10</td>
                    <td>2026-08-10</td>
                    <td>Unggul</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    </section>
    </div>

    <!-- DataTables & Bootstrap CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
    <!--end::Container-->

@endsection
