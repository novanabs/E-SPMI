@extends('layouts.app')

@section('title', 'Pengendalian')

@section('content')

    <div class="card shadow-lg">
        <div class="card-body">
            <!-- Petunjuk -->
            <h5 class="card-title mb-3">Unggah Laporan Rencana Tindak Lanjut</h5>
            <br><br>
            <p class="text-muted">
                <strong>Petunjuk:</strong> Hasil dari rapat tinjauan manajemen menggunakan laporan rencana tindak lanjut.
                Silakan gunakan template berikut:
                <a href="link-template.docx" target="_blank">Unduh Template</a>
            </p>

            <!-- Form Upload -->
            <form>
                <div class="mb-3">
                    <label for="laporanFile" class="form-label">Unggah Laporan</label>
                    <input class="form-control" type="file" id="laporanFile" accept=".pdf,.doc,.docx">
                </div>

                <!-- Tombol Preview -->
                <button type="button" class="btn btn-primary" id="previewBtn">
                    Lihat Preview
                </button>
            </form>

            <!-- Preview Section -->
            <div class="mt-4" id="previewSection" style="display: none;">
                <h6>Preview Laporan:</h6>
                <iframe id="filePreview" class="w-100 border rounded" style="height: 500px;"></iframe>
            </div>
        </div>
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
