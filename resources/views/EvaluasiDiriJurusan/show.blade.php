@extends('layouts.app')

@section('title', 'Perbandingan Evaluasi Diri ' . ($user->homebase ?? ''))

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Elemen</h3>
        {{-- <a href="{{ route('jurusan.create') }}" class="btn btn-sm btn-primary" id="btnTambah">Tambah</a> --}}
        <a class="btn btn-success btn-sm" href="{{ route('evaluasi_diri_jurusan.edit.custom', $user->id) }}">
            Isi Evaluasi
        </a>
    </div>
    <div class="table-responsive">
        <table id="penetapanTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kriteria</th> <!-- Homebase -->
                    <th>Elemen</th>
                    <th>Penilaian Jurusan</th>
                    <th>Penilaian UPM</th>
                    <th>Selisih</th>
                    <th>Temuan</th>
                    <th>Saran</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dinamis sesuai kebutuhan -->
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kriteria->name }}</td>
                        <td>{{ $item->elemen }}</td>
                        {{-- Jurusan --}}
                        <td>{{ $item->userMatrik->jawaban ?? '-' }}</td>
                        {{-- FKIP --}}
                        <td>{{ $item->userMatrikByUser->jawaban ?? '-' }}</td>
                        <td>
                            {{ !is_null(data_get($item, 'userMatrik.jawaban')) && !is_null(data_get($item, 'userMatrikByUser.jawaban'))
                                ? abs(data_get($item, 'userMatrik.jawaban') - data_get($item, 'userMatrikByUser.jawaban'))
                                : '-' }}
                        </td>
                        <td>{{ $item->userMatrikByUser->temuan ?? '-' }}</td>
                        <td>{{ $item->userMatrikByUser->saran ?? '-' }}</td>


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
                pageLength: 65, // Jumlah data per halaman
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
