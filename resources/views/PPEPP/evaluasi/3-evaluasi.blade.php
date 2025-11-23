@extends('layouts.app')

@section('title', 'Evaluasi')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar LAPORAN FKIP</h2>
        <button class="btn btn-sm btn-primary" id="btnTambah">Tambah</button>
    </div>
    <div class="table-responsive">
        <table id="akreditasiTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Aspek</th>
                    <th>Jenis Laporan</th>
                    <th>Waktu Unggah</th>
                    <th>Link Laporan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dinamis sesuai kebutuhan -->
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->aspek }}</td>
                        <td>{{ $item->jenis_laporan }}</td>
                        <td>{{ $item->created_at->translatedFormat('l, d M Y') }}</td>
                        <td>
                            <a href="{{ $item->link_bukti_laporan }}" class="btn btn-sm btn-primary" target="_blank">Link</a>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a class="btn btn-warning btn-sm" href="{{ route('evaluasi.edit', $item->id) }}">
                                    Edit
                                </a>
                                <button class="btn btn-danger btn-sm"
                                    onclick="confirmDelete('{{ route('evaluasi.destroy', $item->id) }}')">
                                    Hapus
                                </button>
                            </div>
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
