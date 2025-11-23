@extends('layouts.app')

@section('title', 'Peningkatan')

@section('content')

    <div class="card shadow-lg">
        <div class="card-body">
            <!-- Petunjuk -->
            <h5 class="card-title mb-3">Unggah Laporan Peningkatan</h5>
            <br><br>
            <p class="text-muted">
                <strong>Petunjuk:</strong> Unggah laporan peningkatan yang telah dilakukan.
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

    <!-- Script Preview -->
    <script>
        const fileInput = document.getElementById('laporanFile');
        const previewBtn = document.getElementById('previewBtn');
        const previewSection = document.getElementById('previewSection');
        const filePreview = document.getElementById('filePreview');

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                previewBtn.disabled = false;
            } else {
                previewBtn.disabled = true;
                previewSection.style.display = "none";
            }
        });

        previewBtn.addEventListener('click', () => {
            const file = fileInput.files[0];
            if (file) {
                const fileURL = URL.createObjectURL(file);
                filePreview.src = fileURL;
                previewSection.style.display = "block";
            }
        });
    </script>

@endsection
