@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar User</h3>
        <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary" id="btnTambah">Tambah</a>
    </div>
    <div class="table-responsive">
        <table id="penetapanTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th> <!-- Homebase -->
                    <th>Homebase</th>
                    <th>Ketua</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Password</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dinamis sesuai kebutuhan -->
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->homebase }}</td>
                        <td>{{ $item->ketua }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->role }}</td>
                        <td>

                            @if ($item->generated_password == null)
                                <span class="text-success">Telah Diubah</span>
                            @else
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-primary"
                                        id="pass-{{ $item->id }}">{{ $item->generated_password }}</span>
                                    <button class="btn btn-sm btn-outline-primary ms-2"
                                        onclick="copyToClipboard({{ $item->id }})">Copy
                                    </button>
                                </div>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="resetPassword({{ $item->id }})">
                                Reset
                            </button>

                            <a class="btn btn-secondary btn-sm mt-1" href="{{ route('user.edit', $item->id) }}">
                                Edit
                            </a>
                            <button class="btn btn-danger btn-sm mt-1"
                                onclick="confirmDelete('{{ route('user.destroy', $item->id) }}')">
                                Hapus
                            </button>
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

    <script>
        function resetPassword(userId) {
            Swal.fire({
                title: 'Reset Password?',
                text: 'Password lama akan diganti dengan password baru.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/reset-password/${userId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire({
                                title: 'Password Baru',
                                html: `
                        <strong>${data.password}</strong>
                        <br><small>Silakan salin dan kirim ke user</small>
                    `,
                                icon: 'success',
                            }).then(() => {
                                location.reload();
                            });
                        });
                }
            });
        }
    </script>


    <script>
        function copyToClipboard(id) {
            var text = document.getElementById("pass-" + id).innerText;
            navigator.clipboard.writeText(text).then(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Password ' + text + ' berhasil disalin ke clipboard.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }).catch(function(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal menyalin Password ' + text + '.',
                });
                console.error("Gagal menyalin teks", err);
            });
        }
    </script>

@endsection
