@extends('layouts.app')

@section('title', 'PPEPP')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar PPEPP</h3>
        {{-- <a href="{{ route('jurusan.create') }}" class="btn btn-sm btn-primary" id="btnTambah">Tambah</a> --}}
    </div>
    <div class="table-responsive">
        <table id="penetapanTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th> <!-- Homebase -->
                    <th>Email</th>
                    <th>Ketua</th>
                    <th>PPEPP</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dinamis sesuai kebutuhan -->
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->homebase }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->ketua }}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{ route('pimpinan.show', $item->id) }}">
                                Lihat
                            </a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#penetapanTable').DataTable({
                pageLength: 10, // Jumlah data per halaman
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
