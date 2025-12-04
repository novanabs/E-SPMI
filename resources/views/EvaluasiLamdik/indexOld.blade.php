@extends('layouts.app')

@section('title', 'Evalauasi Lamdik')

@section('content')

    <h3 class="mb-4">55. Assessment - Pembimbingan Magang / Internship Teknologi Pendidikan</h3>

    <div class="card shadow-lg">
        <div class="card-body">
            <h5 class="card-title">Deskripsi Kriteria</h5>
            <br><br>
            <p class="card-text">
                PS melaksanakan pembimbingan magang/internship teknologi pendidikan di lembaga pelatihan,
                lembaga penyiaran, Production House, Kementerian, atau Dunia Usaha/Dunia Industri (DuDi)
                yang dilakukan setidaknya sebanyak 3 kali dalam satu kegiatan magang, baik secara luring maupun daring.
                Pembimbingan dapat dilakukan di kampus atau di luar kampus, dan terdokumentasi dengan baik.
            </p>

            <form id="kriteriaForm">
                <div class="mb-3">
                    <label class="form-label"><strong>Pilihan Penilaian</strong></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="kriteria" value="4">
                        <label class="form-check-label">
                            Pilihan 1: Dosen pembimbing memberikan bimbingan magang ≥ 3 kali, terdokumentasi dengan sangat
                            baik.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="kriteria" value="3">
                        <label class="form-check-label">
                            Pilihan 2: Dosen pembimbing memberikan bimbingan magang 2 kali, terdokumentasi dengan baik.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="kriteria" value="2">
                        <label class="form-check-label">
                            Pilihan 3: Dosen pembimbing memberikan bimbingan magang 1 kali, terdokumentasi dengan baik.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="kriteria" value="1">
                        <label class="form-check-label">
                            Pilihan 4: Dosen pembimbing tidak memberikan bimbingan magang, hanya menguji di akhir masa
                            magang.
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="bukti" class="form-label">Link Bukti (Opsional)</label>
                    <input type="url" class="form-control" id="bukti" name="bukti"
                        placeholder="Masukkan link bukti jika ada">
                </div>
                <button type="button" class="btn btn-danger" onclick="hitungTotal()">Sebelumnya</button>
                <button type="button" class="btn btn-primary" onclick="hitungTotal()">Selanjutnya</button>
            </form>

            <!-- Hasil -->
            <div class="mt-4" id="hasil" style="display:none;">
                <h5>Hasil Assessment</h5>
                <p><strong>Total Assessment Mandiri:</strong> <span id="totalMandiri"></span></p>
                <p><strong>Total Assessment FKIP:</strong> <span id="totalFKIP"></span></p>
            </div>
        </div>
    </div>



    <script>
        function hitungTotal() {
            let pilihan = document.querySelector('input[name="kriteria"]:checked');
            let bobot = 0.5;

            if (!pilihan) {
                alert("Silakan pilih salah satu opsi terlebih dahulu!");
                return;
            }

            let skor = parseInt(pilihan.value) * bobot;

            // simulasi perbandingan dengan FKIP (misalnya beda +10%)
            let totalFKIP = (skor * 1.1).toFixed(2);

            document.getElementById("totalMandiri").innerText = skor.toFixed(2);
            document.getElementById("totalFKIP").innerText = totalFKIP;
            document.getElementById("hasil").style.display = "block";
        }
    </script>

@endsection
