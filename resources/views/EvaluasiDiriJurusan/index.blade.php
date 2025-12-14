@extends('layouts.app')

@section('title', 'Evaluasi Diri Jurusan')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Jurusan</h3>
        {{-- <a href="{{ route('jurusan.create') }}" class="btn btn-sm btn-primary" id="btnTambah">Tambah</a> --}}
    </div>
    <div class="table-responsive">
        <table id="penetapanTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th> <!-- Homebase -->
                    <th>Email</th>
                    <th>Ketua Jurusan</th>
                    <th>Evaluasi Diri</th>
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
                        <td><a class="btn btn-primary btn-sm mt-1"
                                href="{{ route('evaluasi_diri_jurusan.show', $item->id) }}">
                                Bandingkan
                            </a>
                            <a class="btn btn-success btn-sm mt-1"
                                href="{{ route('evaluasi_diri_jurusan.edit.custom', $item->id) }}">
                                Isi Evaluasi
                            </a>
                        </td>
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
