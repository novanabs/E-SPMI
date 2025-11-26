@extends('layouts.app')

@section('title', 'Peningkatan')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h3>Laporan Peningkatan {{ auth()->user()->homebase }}</h3>
        <a href="{{ route('peningkatan.create') }}" class="btn btn-sm btn-primary" id="btnTambah">Tambah</a>
    </div>
    <p class="text-muted">
        <strong>Petunjuk:</strong> Silakan gunakan template berikut:
        <a href="https://docs.google.com/document/d/1n35WsisQ8y2zvpW-X-B0e4euU1BRclTT/edit?usp=sharing&ouid=111108309923080163994&rtpof=true&sd=true"
            target="_blank">Unduh
            Template</a>
    </p>
    <div class="table-responsive">
        <table id="akreditasiTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Waktu Unggah</th>
                    <th>Link Laporan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dinamis sesuai kebutuhan -->
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->created_at->translatedFormat('l, d M Y') }}</td>
                        <td>
                            <a href="{{ $item->link_bukti_laporan }}" class="btn btn-sm btn-primary"
                                target="_blank">Link</a>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a class="btn btn-warning btn-sm" href="{{ route('peningkatan.edit', $item->id) }}">
                                    Edit
                                </a>
                                <button class="btn btn-danger btn-sm"
                                    onclick="confirmDelete('{{ route('peningkatan.destroy', $item->id) }}')">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
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
                        },
                        emptyTable: "Tidak ada data"
                    }
                });
            });
        </script>
    </div>

@endsection
