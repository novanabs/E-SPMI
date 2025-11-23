@extends('layouts.app')

@section('title', 'Pengendalian')

@section('content')



    <div class="d-flex justify-content-between align-items-center">
        <h3>Laporan Pengendalian {{ auth()->user()->homebase }}</h3>
        <button class="btn btn-sm btn-primary" id="btnTambah">Tambah</button>
    </div>
    <p class="text-muted nb-3">
        <strong>Petunjuk:</strong> Hasil dari rapat tinjauan manajemen menggunakan laporan rencana tindak lanjut.
        Silakan gunakan template berikut:
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dinamis sesuai kebutuhan -->
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ $item->link_bukti_laporan }}" class="btn btn-sm btn-primary" target="_blank">Link</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                    </tr>
                @endforelse
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
