@extends('layouts.app')

@section('title', 'Penetapan')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Dokumen {{ auth()->user()->homebase }}</h3>
        <a href="{{ route('penetapan.create') }}" class="btn btn-sm btn-primary" id="btnTambah">Tambah</a>
    </div>
    <div class="table-responsive">
        <table id="penetapanTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Waktu Unggah</th>
                    <th>Link Dokumen</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dinamis sesuai kebutuhan -->
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->created_at->translatedFormat('l, d M Y') }}</td>
                        <td>
                            <a href="{{ $item->link_bukti_dokumen }}" class="btn btn-sm btn-primary" target="_blank">Link</a>
                        </td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="{{ route('penetapan.edit', $item->id) }}">
                                Edit
                            </a>
                            <button class="btn btn-danger btn-sm"
                                onclick="confirmDelete('{{ route('penetapan.destroy', $item->id) }}')">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                    </tr>
                @endforelse
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
                    }
                }
            });
        });
    </script>

@endsection
