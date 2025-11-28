@extends('layouts.app')

@section('title', 'Dokumen')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Dokumen</h3>
        @if (auth()->user()->role == 'admin_FKIP')
            <a href="{{ route('dokumen.create') }}" class="btn btn-sm btn-primary" id="btnTambah">Tambah</a>
        @endif

    </div>
    <div class="table-responsive">
        <table id="dokumenTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Deskripsi</th>
                    <th>Waktu Unggah</th>
                    <th>Link Dokumen</th>
                    @if (auth()->user()->role == 'admin_FKIP')
                        <th>Action</th>
                    @endif

                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dinamis sesuai kebutuhan -->
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>{{ $item->created_at->translatedFormat('l, d M Y') }}</td>
                        <td>
                            <a href="{{ $item->link_dokumen }}" class="btn btn-sm btn-primary" target="_blank">Link</a>
                        </td>
                        @if (auth()->user()->role == 'admin_FKIP')
                            <td>
                                <a class="btn btn-warning btn-sm" href="{{ route('dokumen.edit', $item->id) }}">
                                    Edit
                                </a>
                                <button class="btn btn-danger btn-sm"
                                    onclick="confirmDelete('{{ route('dokumen.destroy', $item->id) }}')">
                                    Hapus
                                </button>
                            </td>
                        @endif

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <script>
        $(document).ready(function() {
            $('#dokumenTable').DataTable({
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
