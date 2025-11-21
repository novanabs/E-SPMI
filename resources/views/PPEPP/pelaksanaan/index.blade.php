@extends('layouts.app')

@section('title', 'Pelaksanaan')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Dokumen {{ auth()->user()->homebase }}</h3>
        <button class="btn btn-primary" id="btnTambah">Tambah Dokumen</button>
    </div>
    <div class="table-responsive">
        <table id="akreditasiTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Nama Mitra</th>
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
                        <td>
                            @if ($item->nama_mitra)
                                {{ $item->nama_mitra }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                        <td>
                            {{-- <a href="" class="btn btn-info btn-sm">Lihat</a> --}}
                            {{-- <button class="btn btn-sm btn-info">Lihat</button>
                            <button class="btn btn-sm btn-warning">Edit</button>

                            <button class="btn btn-sm btn-danger">Hapus</button> --}}
                            <!-- Tombol -->
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#pdfModal">
                                Bukti Laporan
                            </button>
                            @if ($item->link_bukti_kerjasama)
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#pdfModal2">
                                    Bukti Kerjasama
                                </button>
                            @endif


                            <!-- Modal -->
                            <div class="modal fade" id="pdfModal" tabindex="-1">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $item->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">

                                            <iframe src="{{ $item->link_bukti_laporan }}" width="100%" height="600px"
                                                style="border: none;"></iframe>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="pdfModal2" tabindex="-2">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Bukti Kerjasama {{ auth()->user()->homebase }} &
                                                {{ $item->nama_mitra }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">

                                            <iframe src="{{ $item->link_bukti_kerjasama }}" width="100%" height="600px"
                                                style="border: none;"></iframe>

                                        </div>
                                    </div>
                                </div>
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
