@extends('layouts.app')

@section('title', 'Daftar Akreditasi Jurusan FKIP ULM')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Jurusan</h3>

        @if (auth()->user()->role == 'admin_FKIP')
            <a href="{{ route('akreditasi.create') }}" class="btn btn-sm btn-primary" id="btnTambah">
                Tambah Akreditasi
            </a>
        @endif
    </div>

    <div class="table-responsive">
        <table id="akreditasiTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jurusan</th>
                    <th>Akreditasi</th>
                    <th>Nomor SK</th>
                    <th>Tanggal SK</th>
                    <th>Tanggal Kadaluarsa</th>
                    @if (auth()->user()->role == 'admin_FKIP')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_jurusan }}</td>
                        <td>{{ $item->akreditasi }}</td>
                        <td>{{ $item->nomor_sk }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_sk)->translatedFormat('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->translatedFormat('d M Y') }}</td>

                        @if (auth()->user()->role == 'admin_FKIP')
                            <td>
                                <a href="{{ route('akreditasi.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <button class="btn btn-danger btn-sm"
                                    onclick="confirmDelete('{{ route('akreditasi.destroy', $item->id) }}')">
                                    Hapus
                                </button>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>



    <script>
        $(document).ready(function() {
            $('#akreditasiTable').DataTable({
                pageLength: 10,
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
