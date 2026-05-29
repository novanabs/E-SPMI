<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PilkomEvaluationSeeder extends Seeder
{
    private const PILKOM_EMAIL = 'pilkom@ulm.ac.id';
    private const UPM_EMAIL = 'upmfkip1@ulm.ac.id';
    private const AUDITOR1_EMAIL = 'madhan@ulm.ac.id';
    private const AUDITOR2_EMAIL = 'ariyono281201@gmail.com';
    private const LINK_BUKTI = 'https://drive.google.com/drive/folders/1AriPilkom';

    private const SCORE_PILKOM = 3.15;
    private const SCORE_UPM = 3.80;
    private const SCORE_AUDITOR_SHARED = 3.35;

    private const USER_SUBITEM_OVERRIDES = [
        'pilkom' => [
            19 => ['NDS3' => 0, 'NDL' => 1, 'NDLK' => 0, 'NDGB' => 1],
            15 => ['NM' => 40, 'SINTA1_MHS' => 1, 'SINTA2_MHS' => 1, 'SINTA3_MHS' => 1, 'SINTA4_MHS' => 1, 'SINTA5_MHS' => 0, 'SINTA6_MHS' => 0, 'INT_MHS' => 0, 'ISBN_MHS' => 0, 'PATEN_MHS' => 0],
            56 => ['NDTPS' => 20, 'NDTPS_PUB' => 0],
        ],
        'upm' => [
            19 => ['NDS3' => 1, 'NDL' => 1, 'NDLK' => 0, 'NDGB' => 1],
            2 => ['skor' => 3.0],
            3 => ['skor' => 3.0],
            4 => ['skor' => 3.0],
            15 => ['NM' => 20, 'SINTA1_MHS' => 1, 'SINTA2_MHS' => 1, 'SINTA3_MHS' => 1, 'SINTA4_MHS' => 1, 'SINTA5_MHS' => 0, 'SINTA6_MHS' => 0, 'INT_MHS' => 0, 'ISBN_MHS' => 0, 'PATEN_MHS' => 0],
            56 => ['NDTPS' => 20, 'NDTPS_PUB' => 3],
        ],
        'auditor_shared' => [
            19 => ['NDS3' => 0, 'NDL' => 1, 'NDLK' => 0, 'NDGB' => 1],
            2 => ['skor' => 2.5],
            3 => ['skor' => 2.5],
            4 => ['skor' => 2.5],
            15 => ['NM' => 40, 'SINTA1_MHS' => 1, 'SINTA2_MHS' => 1, 'SINTA3_MHS' => 1, 'SINTA4_MHS' => 1, 'SINTA5_MHS' => 0, 'SINTA6_MHS' => 0, 'INT_MHS' => 0, 'ISBN_MHS' => 0, 'PATEN_MHS' => 0],
            56 => ['NDTPS' => 20, 'NDTPS_PUB' => 6],
        ],
    ];

    /**
     * Contextual temuan/saran per element nomor.
     * Returns [temuan, saran] for the given element nomor and auditor email.
     */
    private function resolveTemuanSaran(int $nomor, string $auditorEmail): array
    {
        $map = [
            1 => [
                'madhan@ulm.ac.id' => ['t' => 'VMTS belum sepenuhnya terintegrasi dengan rencana strategis fakultas dan kurang melibatkan pemangku kepentingan eksternal.', 's' => 'Libatkan alumni dan pengguna lulusan dalam evaluasi VMTS secara berkala minimal 1 kali setahun.'],
                'ariyono281201@gmail.com' => ['t' => 'Sosialisasi VMTS kepada civitas akademika masih belum merata dan belum terdokumentasi dengan baik.', 's' => 'Buat agenda sosialisasi VMTS terjadwal setiap semester dengan bukti notulensi dan daftar hadir.'],
            ],
            2 => [
                'madhan@ulm.ac.id' => ['t' => 'Dokumen SOP tata pamong masih ada yang belum direvisi sesuai ketentuan terbaru, masa berlaku habis.', 's' => 'Lakukan review dan revisi SOP tata pamong setiap awal tahun akademik.'],
                'ariyono281201@gmail.com' => ['t' => 'Implementasi penjaminan mutu di tingkat UPPS belum optimal karena belum semua unit menerapkan siklus PPEPP.', 's' => 'Fasilitasi pelatihan implementasi PPEPP untuk semua ketua unit.'],
            ],
            3 => [
                'madhan@ulm.ac.id' => ['t' => 'Mekanisme monitoring dan evaluasi tata kelola belum sepenuhnya berbasis data dan belum terukur.', 's' => 'Kembangkan dashboard mutu berbasis IT untuk memantau capaian indikator kinerja secara real-time.'],
                'ariyono281201@gmail.com' => ['t' => 'Rencana tindak lanjut hasil audit mutu internal belum ditindaklanjuti secara sistematis.', 's' => 'Bentuk tim khusus yang bertugas memonitor tindak lanjut temuan audit.'],
            ],
            4 => [
                'madhan@ulm.ac.id' => ['t' => 'Kerjasama internasional masih terbatas pada MoU, belum banyak berujung implementasi kegiatan konkret.', 's' => 'Targetkan minimal 2 kerjasama internasional yang menghasilkan joint research setiap tahun.'],
                'ariyono281201@gmail.com' => ['t' => 'Dokumentasi dan pelaporan kerjasama belum terpusat, data tersebar di masing-masing unit.', 's' => 'Gunakan sistem informasi kerjasama terintegrasi untuk pencatatan dan monitoring.'],
            ],
            5 => [
                'madhan@ulm.ac.id' => ['t' => 'Jumlah mahasiswa asing dan kegiatan internasional masih di bawah target indikator kinerja utama.', 's' => 'Kembangkan program student exchange dan summer course yang menarik bagi mahasiswa asing.'],
                'ariyono281201@gmail.com' => ['t' => 'Belum ada sistem penghargaan bagi dosen yang mencapai prestasi internasional.', 's' => 'Buat skema insentif publikasi internasional dan paten yang kompetitif.'],
            ],
            6 => [
                'madhan@ulm.ac.id' => ['t' => 'Rasio jumlah dosen tetap terhadap mahasiswa belum memenuhi standar minimal yang ditetapkan.', 's' => 'Lakukan rekrutmen dosen baru secara bertahap untuk mencapai rasio ideal.'],
                'ariyono281201@gmail.com' => ['t' => 'Layanan bimbingan konseling bagi mahasiswa belum memiliki ruang khusus yang representatif.', 's' => 'Sediakan ruang konseling yang nyaman dan terjaga kerahasiaannya.'],
            ],
            7 => [
                'madhan@ulm.ac.id' => ['t' => 'Tingkat kepuasan mahasiswa terhadap layanan akademik masih di bawah target pada aspek administrasi.', 's' => 'Evaluasi dan percepat proses pelayanan administrasi akademik dengan sistem digital.'],
                'ariyono281201@gmail.com' => ['t' => 'Saluran pengaduan mahasiswa belum dimanfaatkan secara optimal karena sosialisasi kurang.', 's' => 'Integrasikan aplikasi pengaduan dengan media sosial kampus untuk akses lebih mudah.'],
            ],
            8 => [
                'madhan@ulm.ac.id' => ['t' => 'Data tracer study masih rendah, partisipasi alumni dalam pengisian kuesioner kurang.', 's' => 'Gunakan pendekatan direct messaging dan insentif untuk meningkatkan partisipasi tracer study.'],
                'ariyono281201@gmail.com' => ['t' => 'Hasil tracer study belum sepenuhnya dimanfaatkan untuk perbaikan kurikulum dan pembelajaran.', 's' => 'Buat forum tahunan dengan alumni untuk diskusi hasil tracer study dan rekomendasi perbaikan.'],
            ],
            9 => [
                'madhan@ulm.ac.id' => ['t' => 'Jumlah guru besar masih jauh dari target, hanya 2% dari total DTPS.', 's' => 'Buat program percepatan guru besar dengan pendampingan intensif dan insentif publikasi.'],
                'ariyono281201@gmail.com' => ['t' => 'Beban kerja dosen belum semuanya tercatat dalam BKD secara lengkap dan tepat waktu.', 's' => 'Sosialisasikan pelaporan BKD tepat waktu dan berikan sanksi bagi yang melanggar.'],
            ],
            10 => [
                'madhan@ulm.ac.id' => ['t' => 'Dosen dengan sertifikasi pendidik masih kurang dari 80% total DTPS.', 's' => 'Fasilitasi dan prioritaskan dosen yang belum sertifikasi untuk mengikuti serdos.'],
                'ariyono281201@gmail.com' => ['t' => 'Program pengembangan kompetensi tendik belum terencana sistematis dan berjenjang.', 's' => 'Buat peta kompetensi individu tendik dan program pelatihan tahunan berbasis gap analisis.'],
            ],
            11 => [
                'madhan@ulm.ac.id' => ['t' => 'Alokasi dana penelitian dan PkM belum mencapai 20% dari total anggaran unit.', 's' => 'Review anggaran dan alokasikan minimal 20% untuk kegiatan penelitian dan pengabdian.'],
                'ariyono281201@gmail.com' => ['t' => 'Laporan pertanggungjawaban keuangan sering terlambat akibat birokrasi panjang.', 's' => 'Sederhanakan prosedur pencairan dana, gunakan aplikasi monitoring keuangan digital.'],
            ],
            12 => [
                'madhan@ulm.ac.id' => ['t' => 'Ruang laboratorium belum memenuhi standar luasan minimal untuk jumlah mahasiswa saat ini.', 's' => 'Ajukan usulan penambahan ruang lab ke fakultas dan optimalkan jadwal penggunaan lab.'],
                'ariyono281201@gmail.com' => ['t' => 'Pemeliharaan sarpras belum terjadwal berkala, banyak peralatan rusak tidak segera diperbaiki.', 's' => 'Buat jadwal pemeliharaan rutin dan alokasikan dana perawatan minimal 5% dari anggaran.'],
            ],
            13 => [
                'madhan@ulm.ac.id' => ['t' => 'Kurikulum belum sepenuhnya mengakomodasi kebutuhan industri dan perkembangan IPTEK terkini.', 's' => 'Libatkan asosiasi profesi dan industri dalam evaluasi kurikulum setiap 2 tahun.'],
                'ariyono281201@gmail.com' => ['t' => 'RPS beberapa mata kuliah belum diperbarui, belum menggunakan case method atau PBL.', 's' => 'Adakan workshop pengembangan RPS berbasis pembelajaran aktif untuk semua dosen.'],
            ],
            14 => [
                'madhan@ulm.ac.id' => ['t' => 'Nilai IPK lulusan mengalami tren penurunan dalam 3 tahun terakhir.', 's' => 'Kembangkan remedial dan bimbingan akademik intensif bagi mahasiswa berpotensi dropout.'],
                'ariyono281201@gmail.com' => ['t' => 'Masa studi rata-rata lulusan masih melebihi 5 tahun, target 4,5 tahun.', 's' => 'Optimalkan monitoring akademik untuk deteksi dini mahasiswa dengan masa studi terancam panjang.'],
            ],
            15 => [
                'madhan@ulm.ac.id' => ['t' => 'Kesesuaian kurikulum dengan kebutuhan stakeholders belum dievaluasi secara periodik.', 's' => 'Selenggarakan tracer study pengguna lulusan setiap tahun dan tindak lanjuti hasilnya.'],
                'ariyono281201@gmail.com' => ['t' => 'Keterlibatan dosen dalam pengembangan kurikulum belum optimal dan belum terkoordinasi.', 's' => 'Bentuk tim kurikulum yang melibatkan perwakilan dosen dari setiap bidang keahlian.'],
            ],
            16 => [
                'madhan@ulm.ac.id' => ['t' => 'Monitoring proses pembelajaran belum berjalan efektif, dokumentasi masih manual.', 's' => 'Implementasikan sistem e-learning terintegrasi untuk monitoring dan dokumentasi pembelajaran.'],
                'ariyono281201@gmail.com' => ['t' => 'Belum ada standar baku mutu proses pembelajaran yang disosialisasikan ke semua dosen.', 's' => 'Tetapkan dan sosialisasikan standar mutu proses pembelajaran secara berkala.'],
            ],
            17 => [
                'madhan@ulm.ac.id' => ['t' => 'Inovasi pembelajaran seperti blended learning belum diterapkan secara luas.', 's' => 'Dorong pengembangan konten pembelajaran daring untuk setiap mata kuliah.'],
                'ariyono281201@gmail.com' => ['t' => 'Rasio dosen-mahasiswa pada mata kuliah praktikum melebihi batas ideal 1:15.', 's' => 'Atur ulang jadwal dan alokasi dosen untuk praktikum agar rasio sesuai standar.'],
            ],
            18 => [
                'madhan@ulm.ac.id' => ['t' => 'Monitoring beban belajar mahasiswa per semester belum dilakukan secara sistemik.', 's' => 'Gunakan SIAKAD untuk memonitor beban SKS mahasiswa setiap semester.'],
                'ariyono281201@gmail.com' => ['t' => 'Layanan bimbingan akademik belum terstruktur dengan baik, banyak mahasiswa tidak memiliki pembimbing.', 's' => 'Tetapkan dosen PA untuk setiap mahasiswa dan monitoring pertemuan secara berkala.'],
            ],
            19 => [
                'madhan@ulm.ac.id' => ['t' => 'Kualifikasi pendidikan DTPS masih kurang, jumlah S3 belum mencapai 50% dari total DTPS.', 's' => 'Programkan studi lanjut S3 bagi dosen yang masih S2 secara bertahap.'],
                'ariyono281201@gmail.com' => ['t' => 'Jabatan fungsional lektor kepala dan guru besar masih rendah dari target.', 's' => 'Buat roadmap kenaikan jabatan fungsional dan pendampingan individual bagi dosen.'],
            ],
            20 => [
                'madhan@ulm.ac.id' => ['t' => 'Kesesuaian bidang keahlian dosen dengan mata kuliah yang diampu belum optimal.', 's' => 'Lakukan pemetaan kompetensi dosen dan sesuaikan penugasan mengajar dengan bidang keahlian.'],
                'ariyono281201@gmail.com' => ['t' => 'Kegiatan penelitian dosen belum seluruhnya terintegrasi dengan bahan ajar.', 's' => 'Dorong integrasi hasil penelitian ke dalam materi perkuliahan setiap semester.'],
            ],
            21 => [
                'madhan@ulm.ac.id' => ['t' => 'Rasio jumlah DTPS terhadap mahasiswa belum ideal, terutama pada program studi tertentu.', 's' => 'Lakukan rekrutmen dosen baru prioritas pada prodi dengan rasio terendah.'],
                'ariyono281201@gmail.com' => ['t' => 'Distribusi dosen antar program studi tidak merata, ada prodi kelebihan dan kekurangan.', 's' => 'Evaluasi kebutuhan dosen per prodi dan lakukan redistribusi atau rekrutmen.'],
            ],
            22 => [
                'madhan@ulm.ac.id' => ['t' => 'Jumlah tenaga kependidikan belum memenuhi standar rasio terhadap jumlah mahasiswa.', 's' => 'Ajukan penambahan tenaga kependidikan sesuai analisis beban kerja.'],
                'ariyono281201@gmail.com' => ['t' => 'Kompetensi tenaga kependidikan di bidang IT masih perlu ditingkatkan.', 's' => 'Selenggarakan pelatihan IT untuk tenaga kependidikan secara berkala.'],
            ],
            23 => [
                'madhan@ulm.ac.id' => ['t' => 'Sistem rekrutmen dan seleksi dosen dan tendik belum sepenuhnya berbasis merit.', 's' => 'Implementasikan sistem rekrutman berbasis kompetensi dan transparan.'],
                'ariyono281201@gmail.com' => ['t' => 'Dokumen SOP pengelolaan SDM belum lengkap dan belum semuanya diimplementasikan.', 's' => 'Lengkapi SOP pengelolaan SDM dan lakukan audit implementasi secara berkala.'],
            ],
            24 => [
                'madhan@ulm.ac.id' => ['t' => 'Publikasi dosen di jurnal internasional terindeks masih sangat terbatas.', 's' => 'Fasilitasi proofreading dan translation fee untuk publikasi internasional.'],
                'ariyono281201@gmail.com' => ['t' => 'Jumlah sitasi artikel dosen masih rendah, menunjukkan dampak penelitian yang kurang.', 's' => 'Dorong kolaborasi riset dengan peneliti senior untuk meningkatkan kualitas dan sitasi.'],
            ],
            25 => [
                'madhan@ulm.ac.id' => ['t' => 'Hak kekayaan intelektual yang dihasilkan dosen masih sangat minim.', 's' => 'Buat sentra HKI untuk pendampingan paten dan hak cipta dari awal hingga granted.'],
                'ariyono281201@gmail.com' => ['t' => 'Luaran penelitian berupa prototipe, produk, atau teknologi tepat guna belum banyak.', 's' => 'Arahkan riset dosen pada pengembangan produk yang siap diterapkan di masyarakat.'],
            ],
            26 => [
                'madhan@ulm.ac.id' => ['t' => 'Anggaran penelitian masih tersentralisasi, dosen kesulitan akses dana hibah internal.', 's' => 'Sederhanakan prosedur pengajuan dana penelitian internal dan informasikan secara terbuka.'],
                'ariyono281201@gmail.com' => ['t' => 'Laboratorium penelitian belum memiliki standar operasional prosedur yang baku.', 's' => 'Buat dan sosialisasikan SOP penggunaan laboratorium penelitian.'],
            ],
            27 => [
                'madhan@ulm.ac.id' => ['t' => 'Data akreditasi program studi belum diperbarui secara real-time di pangkalan data.', 's' => 'Integrasikan sistem informasi akademik dengan pangkalan data akreditasi.'],
                'ariyono281201@gmail.com' => ['t' => 'Dokumen borang akreditasi belum dikelola dengan sistem dokumentasi yang baik.', 's' => 'Gunakan aplikasi manajemen dokumen untuk menyimpan dan mengelola borang akreditasi.'],
            ],
            28 => [
                'madhan@ulm.ac.id' => ['t' => 'Indikator kinerja tambahan belum seluruhnya tercapai pada periode evaluasi terakhir.', 's' => 'Buat rencana aksi pencapaian IKT dengan penanggung jawab dan timeline yang jelas.'],
                'ariyono281201@gmail.com' => ['t' => 'Strategi pencapaian kinerja belum dituangkan dalam dokumen rencana strategis yang terukur.', 's' => 'Tetapkan IKT tahunan yang SMART dan monitoring pencapaian setiap triwulan.'],
            ],
            29 => [
                'madhan@ulm.ac.id' => ['t' => 'Dokumen evaluasi kurikulum belum memuat analisis kebutuhan stakeholders secara komprehensif.', 's' => 'Lakukan survei kepuasan pengguna lulusan setiap tahun dan integrasikan hasilnya ke evaluasi kurikulum.'],
                'ariyono281201@gmail.com' => ['t' => 'Perubahan kurikulum belum didokumentasikan dengan baik dari sisi landasan dan proses.', 's' => 'Dokumentasikan setiap perubahan kurikulum lengkap dengan justifikasi akademik.'],
            ],
            30 => [
                'madhan@ulm.ac.id' => ['t' => 'Sistem penjaminan mutu internal belum berjalan pada tingkat program studi secara konsisten.', 's' => 'Aktifkan gugus mutu program studi dengan pelatihan dan pendampingan intensif.'],
                'ariyono281201@gmail.com' => ['t' => 'UMpan balik perbaikan mutu dari hasil evaluasi belum terdokumentasi dengan sistematis.', 's' => 'Buat bank data hasil evaluasi mutu dan tindak lanjutnya per siklus PPEPP.'],
            ],
            31 => [
                'madhan@ulm.ac.id' => ['t' => 'Laporan kinerja tahunan belum memuat analisis capaian dibandingkan target secara detail.', 's' => 'Sempurnakan format laporan kinerja dengan analisis gap dan rencana perbaikan.'],
                'ariyono281201@gmail.com' => ['t' => 'Sosialisasi capaian kinerja kepada pemangku kepentingan internal masih kurang.', 's' => 'Adakan forum rapat tahunan untuk menyampaikan capaian kinerja dan rencana strategis.'],
            ],
            32 => [
                'madhan@ulm.ac.id' => ['t' => 'Partisipasi dosen dalam kegiatan pengabdian kepada masyarakat masih rendah.', 's' => 'Jadwalkan kegiatan PkM rutin dan berikan insentif bagi dosen yang aktif.'],
                'ariyono281201@gmail.com' => ['t' => 'Pengabdian kepada masyarakat belum terintegrasi dengan hasil penelitian dosen.', 's' => 'Fasilitasi hilirisasi hasil penelitian menjadi program pengabdian yang bermanfaat.'],
            ],
            33 => [
                'madhan@ulm.ac.id' => ['t' => 'Publikasi mahasiswa pada jurnal nasional terakreditasi masih perlu ditingkatkan.', 's' => 'Wajibkan mahasiswa untuk mempunyai publikasi sebagai syarat sidang skripsi/tesis.'],
                'ariyono281201@gmail.com' => ['t' => 'Keterlibatan mahasiswa dalam penelitian dosen belum terstruktur dan terjadwal.', 's' => 'Integrasikan mahasiswa ke dalam roadmap penelitian dosen melalui program asisten riset.'],
            ],
            34 => [
                'madhan@ulm.ac.id' => ['t' => 'Prestasi mahasiswa di bidang penalaran dan karya ilmiah masih di bawah standar kompetitif nasional.', 's' => 'Bentuk tim pembinaan mahasiswa berprestasi dengan jadwal pembinaan rutin.'],
                'ariyono281201@gmail.com' => ['t' => 'Dana pengembangan prestasi mahasiswa belum dialokasikan secara khusus dalam anggaran.', 's' => 'Alokasikan anggaran khusus untuk pembinaan dan pengembangan prestasi mahasiswa.'],
            ],
            35 => [
                'madhan@ulm.ac.id' => ['t' => 'Proses seleksi dan penerimaan mahasiswa baru belum sepenuhnya transparan dan akuntabel.', 's' => 'Publikasikan mekanisme seleksi dan hasil penerimaan secara terbuka di website.'],
                'ariyono281201@gmail.com' => ['t' => 'Sosialisasi penerimaan mahasiswa baru belum menjangkau daerah-daerah terpencil.', 's' => 'Optimalkan sosialisasi melalui media sosial dan kerjasama dengan sekolah di daerah 3T.'],
            ],
            36 => [
                'madhan@ulm.ac.id' => ['t' => 'Layanan beasiswa bagi mahasiswa kurang mampu belum tersosialisasikan dengan baik.', 's' => 'Buat portal informasi beasiswa terpadu dan aktifkan sosialisasi melalui himpunan mahasiswa.'],
                'ariyono281201@gmail.com' => ['t' => 'Data mahasiswa penerima beasiswa belum terintegrasi antara bagian kemahasiswaan dan keuangan.', 's' => 'Integrasikan data beasiswa melalui sistem informasi kemahasiswaan.'],
            ],
            37 => [
                'madhan@ulm.ac.id' => ['t' => 'Kegiatan organisasi kemahasiswaan belum sepenuhnya didukung dari segi pendanaan dan fasilitas.', 's' => 'Alokasikan dana pengembangan organisasi kemahasiswaan secara transparan dan tepat waktu.'],
                'ariyono281201@gmail.com' => ['t' => 'Pembinaan softskill mahasiswa masih minim, belum terprogram secara terstruktur.', 's' => 'Kembangkan program pengembangan softskill yang terintegrasi dalam kurikulum.'],
            ],
            38 => [
                'madhan@ulm.ac.id' => ['t' => 'Alumni tracer study system belum terintegrasi dengan sistem informasi universitas.', 's' => 'Kembangkan tracer study berbasis web yang terintegrasi dengan data akademik alumni.'],
                'ariyono281201@gmail.com' => ['t' => 'Database alumni belum lengkap dan jarang diperbarui.', 's' => 'Lakukan pendataan ulang alumni melalui kerjasama dengan himpunan alumni.'],
            ],
            39 => [
                'madhan@ulm.ac.id' => ['t' => 'Rata-rata masa tunggu lulusan mendapatkan pekerjaan pertama masih terlalu panjang.', 's' => 'Tingkatkan kerjasama dengan BKK dan perusahaan rekrutmen untuk penempatan lulusan.'],
                'ariyono281201@gmail.com' => ['t' => 'Kesesuaian bidang kerja lulusan dengan program studi masih perlu ditingkatkan.', 's' => 'Evaluasi kurikulum berdasarkan data kesesuaian bidang kerja lulusan.'],
            ],
            40 => [
                'madhan@ulm.ac.id' => ['t' => 'Indeks prestasi kumulatif lulusan mengalami penurunan dalam tiga tahun terakhir.', 's' => 'Tingkatkan kualitas bimbingan akademik dan deteksi dini mahasiswa bermasalah.'],
                'ariyono281201@gmail.com' => ['t' => 'Persentase kelulusan tepat waktu masih di bawah target institusi.', 's' => 'Optimalkan sistem monitoring akademik dengan early warning system.'],
            ],
            41 => [
                'madhan@ulm.ac.id' => ['t' => 'Jumlah penelitian dosen yang terintegrasi dengan pembelajaran masih rendah.', 's' => 'Buat kebijakan integrasi hasil penelitian ke dalam bahan ajar setiap semester.'],
                'ariyono281201@gmail.com' => ['t' => 'Luaran penelitian dosen belum banyak yang hilirisasi ke pengabdian masyarakat.', 's' => 'Fasilitasi hilirisasi riset menjadi program PkM yang berdampak langsung.'],
            ],
            42 => [
                'madhan@ulm.ac.id' => ['t' => 'Rata-rata masa studi mahasiswa masih di atas 5 tahun untuk program sarjana.', 's' => 'Kembangkan program akselerasi dan bimbingan Skripsi/Tugas Akhir terstruktur.'],
                'ariyono281201@gmail.com' => ['t' => 'Tingkat kepuasan mahasiswa terhadap proses bimbingan skripsi masih rendah.', 's' => 'Evaluasi kinerja dosen pembimbing dan berikan penghargaan bagi pembimbing terbaik.'],
            ],
            43 => [
                'madhan@ulm.ac.id' => ['t' => 'Persentase partisipasi mahasiswa dalam kegiatan ekstrakurikuler masih rendah.', 's' => 'Kembangkan program ekstrakurikuler yang menarik dan relevan dengan kebutuhan industri.'],
                'ariyono281201@gmail.com' => ['t' => 'Fasilitas kegiatan ekstrakurikuler dan olahraga masih terbatas dan kurang terawat.', 's' => 'Ajukan penambahan dan perawatan fasilitas ekstrakurikuler secara periodik.'],
            ],
            44 => [
                'madhan@ulm.ac.id' => ['t' => 'Jumlah pengabdian masyarakat yang melibatkan mahasiswa masih rendah.', 's' => 'Programkan KKN tematik dan pengabdian berbasis riset yang melibatkan mahasiswa.'],
                'ariyono281201@gmail.com' => ['t' => 'Luaran PkM belum diukur dampaknya terhadap masyarakat secara sistematis.', 's' => 'Kembangkan instrumen pengukuran dampak PkM dan lakukan evaluasi setiap tahun.'],
            ],
            45 => [
                'madhan@ulm.ac.id' => ['t' => 'Jumlah lulusan yang melanjutkan studi ke jenjang lebih tinggi masih minim.', 's' => 'Adakan program sosialisasi beasiswa studi lanjut dan bimbingan aplikasi.'],
                'ariyono281201@gmail.com' => ['t' => 'Data karier alumni belum terupdate secara berkala untuk evaluasi program studi.', 's' => 'Gunakan jejaring sosial alumni untuk update data karier secara berkala.'],
            ],
            46 => [
                'madhan@ulm.ac.id' => ['t' => 'Ketersediaan dan pemanfaatan e-learning oleh dosen masih belum optimal.', 's' => 'Adakan pelatihan pengembangan konten e-learning dan berikan insentif.'],
                'ariyono281201@gmail.com' => ['t' => 'Kualitas bahan ajar yang diunggah di e-learning masih perlu ditingkatkan.', 's' => 'Tetapkan standar minimal konten e-learning dan lakukan review berkala.'],
            ],
            47 => [
                'madhan@ulm.ac.id' => ['t' => 'Unit kegiatan mahasiswa bidang penalaran ilmiah belum aktif secara konsisten.', 's' => 'Berikan dukungan dana dan pembinaan rutin untuk UKM penalaran ilmiah.'],
                'ariyono281201@gmail.com' => ['t' => 'Partisipasi mahasiswa dalam lomba karya ilmiah nasional masih rendah.', 's' => 'Buat program pembinaan lomba karya ilmiah dari tingkat prodi hingga universitas.'],
            ],
            48 => [
                'madhan@ulm.ac.id' => ['t' => 'Nilai evaluasi proses pembelajaran oleh mahasiswa belum digunakan sebagai feedback perbaikan.', 's' => 'Sosialisasikan hasil evaluasi dosen dan tindak lanjuti dalam forum koordinasi prodi.'],
                'ariyono281201@gmail.com' => ['t' => 'Umpan balik dari dosen wali terhadap perkembangan akademik mahasiswa belum terdokumentasi.', 's' => 'Bakukan format laporan perkembangan akademik mahasiswa dari dosen wali setiap semester.'],
            ],
            49 => [
                'madhan@ulm.ac.id' => ['t' => 'Dokumen RPS belum semuanya tersimpan di sistem dokumentasi prodi secara terpusat.', 's' => 'Wajibkan unggah RPS ke sistem informasi akademik setiap awal semester.'],
                'ariyono281201@gmail.com' => ['t' => 'Kesesuaian RPS dengan silabus dan kontrak kuliah masih perlu diverifikasi.', 's' => 'Lakukan verifikasi RPS oleh gugus mutu prodi setiap awal semester.'],
            ],
            50 => [
                'madhan@ulm.ac.id' => ['t' => 'Monitoring pelaksanaan ujian belum berjalan ketat, masih ada peluang kecurangan.', 's' => 'Tertibkan pengawasan ujian dengan SOP yang jelas dan kamera pengawas.'],
                'ariyono281201@gmail.com' => ['t' => 'Waktu pengembalian nilai ujian ke mahasiswa sering melebihi batas waktu yang ditentukan.', 's' => 'Tetapkan batas waktu penginputan nilai maksimal 2 minggu setelah ujian.'],
            ],
            51 => [
                'madhan@ulm.ac.id' => ['t' => 'Ketersediaan buku ajar yang ditulis dosen sendiri masih terbatas.', 's' => 'Dorong dosen untuk menulis buku ajar dengan insentif dan fasilitas penerbitan.'],
                'ariyono281201@gmail.com' => ['t' => 'Pemanfaatan perpustakaan digital oleh mahasiswa masih rendah.', 's' => 'Sosialisasikan akses perpustakaan digital dan integrasikan dengan tugas kuliah.'],
            ],
            52 => [
                'madhan@ulm.ac.id' => ['t' => 'Jumlah penelitian kerjasama dengan pihak eksternal masih rendah.', 's' => 'Tingkatkan networking dengan lembaga riset dan industri untuk penelitian kolaboratif.'],
                'ariyono281201@gmail.com' => ['t' => 'Hak paten dan HKI yang dihasilkan dari penelitian masih sangat sedikit.', 's' => 'Fasilitasi pendaftaran HKI dan paten dari hasil penelitian dosen dan mahasiswa.'],
            ],
            53 => [
                'madhan@ulm.ac.id' => ['t' => 'Jumlah publikasi dosen di jurnal bereputasi internasional masih rendah.', 's' => 'Prioritaskan pendanaan untuk publikasi di jurnal Q1 dan Q2.'],
                'ariyono281201@gmail.com' => ['t' => 'Jumlah sitasi publikasi dosen masih rendah, mempengaruhi reputasi institusi.', 's' => 'Promosikan publikasi dosen melalui media sosial akademik dan repository institusi.'],
            ],
            54 => [
                'madhan@ulm.ac.id' => ['t' => 'Persentase DTPS yang menjadi anggota asosiasi profesi masih rendah.', 's' => 'Fasilitasi dan berikan insentif bagi dosen untuk menjadi anggota asosiasi profesi.'],
                'ariyono281201@gmail.com' => ['t' => 'Partisipasi dosen dalam seminar internasional sebagai pembicara masih rendah.', 's' => 'Targetkan minimal 1 dosen sebagai invited speaker di forum internasional per tahun.'],
            ],
            55 => [
                'madhan@ulm.ac.id' => ['t' => 'Jumlah kerjasama penelitian dengan mitra internasional masih minim.', 's' => 'Kembangkan jejaring riset internasional melalui konferensi dan publikasi bersama.'],
                'ariyono281201@gmail.com' => ['t' => 'Belum ada MoU kerjasama penelitian yang ditindaklanjuti dengan joint research.', 's' => 'Monitoring implementasi MoU secara berkala dan evaluasi output kerjasama.'],
            ],
            56 => [
                'madhan@ulm.ac.id' => ['t' => 'DTPS dengan jabatan fungsional Lektor Kepala masih kurang dari target 30%.', 's' => 'Buat program percepatan Lektor Kepala dengan target 3 dosen per tahun.'],
                'ariyono281201@gmail.com' => ['t' => 'Produktivitas publikasi DTPS per tahun masih di bawah standar akreditasi unggul.', 's' => 'Tetapkan target minimal 1 publikasi per dosen per tahun di jurnal terakreditasi.'],
            ],
            57 => [
                'madhan@ulm.ac.id' => ['t' => 'Angka partisipasi mahasiswa dalam program magang masih rendah.', 's' => 'Perluas kerjasama magang dengan industri dan perusahaan terkemuka.'],
                'ariyono281201@gmail.com' => ['t' => 'Kualitas pelaksanaan program magang belum dimonitor secara sistematis.', 's' => 'Kembangkan instrumen monitoring magang dan lakukan visitasi ke tempat magang.'],
            ],
            58 => [
                'madhan@ulm.ac.id' => ['t' => 'Jumlah dosen yang mendapatkan hibah penelitian eksternal masih rendah.', 's' => 'Tingkatkan kemampuan penulisan proposal hibah melalui workshop dan mentoring.'],
                'ariyono281201@gmail.com' => ['t' => 'Dana penelitian dari mitra industri belum ada kontribusinya.', 's' => 'Jalin kerjasama riset terapan dengan industri yang didanai oleh mitra.'],
            ],
            59 => [
                'madhan@ulm.ac.id' => ['t' => 'Jumlah inovasi pembelajaran berbasis IT yang dikembangkan dosen masih minim.', 's' => 'Selenggarakan lomba inovasi pembelajaran berbasis IT dengan hadiah menarik.'],
                'ariyono281201@gmail.com' => ['t' => 'Penggunaan media pembelajaran interaktif masih terbatas pada beberapa dosen saja.', 's' => 'Adakan sharing session praktik baik pembelajaran inovatif secara rutin.'],
            ],
            60 => [
                'madhan@ulm.ac.id' => ['t' => 'Jumlah kegiatan PkM yang melibatkan mahasiswa masih kurang dari 50%.', 's' => 'Integrasikan kegiatan PkM dengan mata kuliah terkait pemberdayaan masyarakat.'],
                'ariyono281201@gmail.com' => ['t' => 'Dampak PkM terhadap masyarakat belum diukur secara kuantitatif.', 's' => 'Kembangkan indikator dampak PkM yang terukur dan lakukan survei dampak.'],
            ],
            61 => [
                'madhan@ulm.ac.id' => ['t' => 'Persentase lulusan yang bersertifikat kompetensi masih rendah.', 's' => 'Fasilitasi program sertifikasi kompetensi bagi mahasiswa tahun akhir.'],
                'ariyono281201@gmail.com' => ['t' => 'Jumlah kerjasama dengan LSP untuk sertifikasi kompetensi masih terbatas.', 's' => 'Jalin kerjasama dengan LSP dan BNSP untuk pelaksanaan uji kompetensi.'],
            ],
            62 => [
                'madhan@ulm.ac.id' => ['t' => 'Dokumen pedoman akademik belum direvisi sesuai kurikulum baru.', 's' => 'Revisi pedoman akademik secara berkala dan sosialisasikan ke dosen dan mahasiswa.'],
                'ariyono281201@gmail.com' => ['t' => 'Buku panduan skripsi belum mengakomodasi format penulisan artikel ilmiah.', 's' => 'Perbarui panduan skripsi dengan opsi format artikel ilmiah terbaru.'],
            ],
            63 => [
                'madhan@ulm.ac.id' => ['t' => 'Sistem informasi alumni belum terintegrasi dengan tracer study dan data akademik.', 's' => 'Kembangkan portal alumni terpadu yang terhubung dengan SIAKAD dan tracer study.'],
                'ariyono281201@gmail.com' => ['t' => 'Partisipasi alumni dalam kegiatan akademik prodi masih kurang.', 's' => 'Undang alumni sukses sebagai dosen tamu dan pembicara dalam kuliah umum.'],
            ],
            64 => [
                'madhan@ulm.ac.id' => ['t' => 'Kerjasama internasional bidang pendidikan seperti joint degree belum terealisasi.', 's' => 'Jajaki kerjasama joint degree dengan universitas mitra di Asia Tenggara.'],
                'ariyono281201@gmail.com' => ['t' => 'Dokumen MoU kerjasama belum dipantau masa berlakunya secara sistematis.', 's' => 'Buat database MoU dengan reminder perpanjangan otomatis.'],
            ],
            65 => [
                'madhan@ulm.ac.id' => ['t' => 'Evaluasi pasca magang belum dilakukan secara formal dan terdokumentasi.', 's' => 'Lakukan evaluasi pasca magang setiap semester dengan instrumen baku.'],
                'ariyono281201@gmail.com' => ['t' => 'Data penempatan lulusan pertama belum terintegrasi dengan tracer study.', 's' => 'Integrasikan data penempatan kerja lulusan dengan tracer study dan BKK.'],
            ],
        ];

        $entry = $map[$nomor] ?? null;
        if ($entry && isset($entry[$auditorEmail])) {
            return [$entry[$auditorEmail]['t'], $entry[$auditorEmail]['s']];
        }

        // Fallback — should not happen since we mapped 1-65
        return [
            'Perlu perbaikan pada dokumentasi dan implementasi elemen ini (Elemen ' . $nomor . ').',
            'Lakukan identifikasi gap, buat rencana aksi, dan monitoring implementasi secara berkala.',
        ];
    }

    public function run(): void
    {
        $pilkom = User::where('email', self::PILKOM_EMAIL)->first();
        $upm = User::where('email', self::UPM_EMAIL)->first();
        $auditor1 = User::where('email', self::AUDITOR1_EMAIL)->first();
        $auditor2 = User::where('email', self::AUDITOR2_EMAIL)->first();

        if (!$pilkom || !$upm || !$auditor1 || !$auditor2) {
            $this->command->error('PilkomEvaluationSeeder: One or more required users are missing.');
            return;
        }

        $matriksList = DB::table('matriks_lembar_evaluasi_diri')
            ->orderBy('id')
            ->get(['id', 'nomor', 'poin']);

        // ─────────────────────────────────────────────
        // 1. USERS_MATRIK (scores)
        //    pilkom  → id_users=pilkom, id_user_jurusan=null     (self-assessment)
        //    upm     → id_users=upm,    id_user_jurusan=pilkom   (FKIP evaluation)
        //    auditor → id_users=pilkom, id_user_jurusan=pilkom   (SHARED score)
        // ─────────────────────────────────────────────
        $scoreConfigs = [
            [
                'role'           => 'pilkom',
                'id_users'       => $pilkom->id,
                'id_user_jurusan'=> null,
                'score'          => self::SCORE_PILKOM,
            ],
            [
                'role'           => 'upm',
                'id_users'       => $upm->id,
                'id_user_jurusan'=> $pilkom->id,
                'score'          => self::SCORE_UPM,
            ],
            [
                'role'           => 'auditor_shared',
                'id_users'       => $pilkom->id,
                'id_user_jurusan'=> $pilkom->id,
                'score'          => self::SCORE_AUDITOR_SHARED,
            ],
        ];

        foreach ($matriksList as $matriks) {
            foreach ($scoreConfigs as $cfg) {
                $jawaban = $cfg['score'];
                $nilaiTotal = (float) $matriks->poin * $jawaban;
                $skorA = null;
                $skorB = null;

                if ((int) $matriks->nomor === 7) {
                    $skorA = 4;
                    $skorB = 4;
                }

                DB::table('users_matrik')->updateOrInsert(
                    [
                        'id_users'       => $cfg['id_users'],
                        'id_user_jurusan'=> $cfg['id_user_jurusan'],
                        'id_matriks_led' => $matriks->id,
                    ],
                    [
                        'jawaban'              => number_format($jawaban, 2, '.', ''),
                        'skor_a'               => $skorA,
                        'skor_b'               => $skorB,
                        'nilai_total'          => $nilaiTotal,
                        'link_bukti'           => self::LINK_BUKTI,
                        'kepemilikan_kriteria' => 'jurusan',
                        'temuan'               => '-',
                        'saran'                => '-',
                        'created_at'           => now(),
                        'updated_at'           => now(),
                    ]
                );
            }
        }

        // ─────────────────────────────────────────────
        // 2. AUDITOR_TEMUAN_SARAN (per-auditor, per-elemen)
        // ─────────────────────────────────────────────
        foreach ([$auditor1, $auditor2] as $auditor) {
            foreach ($matriksList as $matriks) {
                [$temuan, $saran] = $this->resolveTemuanSaran((int) $matriks->nomor, $auditor->email);

                DB::table('auditor_temuan_saran')->updateOrInsert(
                    [
                        'id_users'        => $auditor->id,
                        'id_user_jurusan' => $pilkom->id,
                        'id_matriks_led'  => $matriks->id,
                    ],
                    [
                        'temuan'     => $temuan,
                        'saran'      => $saran,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        // ─────────────────────────────────────────────
        // 3. SUB-ITEM ELEMEN VALUES
        // ─────────────────────────────────────────────
        $this->seedSubItemValues($pilkom, $upm);

        $this->command->info('PilkomEvaluationSeeder: Done. 2 auditors, shared scores, per-auditor temuan/saran.');
    }

    protected function seedSubItemValues(User $pilkom, User $upm): void
    {
        $allSubDefs = DB::table('sub_item_elemen')
            ->orderBy('nomor_elemen')
            ->get(['id', 'nomor_elemen', 'variabel']);

        $matriksByNomor = DB::table('matriks_lembar_evaluasi_diri')
            ->get(['id', 'nomor'])
            ->keyBy('nomor');

        // Three sets: pilkom (self), upm (FKIP), auditor_shared
        $subConfigs = [
            [
                'role'     => 'pilkom',
                'id_users' => $pilkom->id,
                'id_user_jurusan' => null,
            ],
            [
                'role'     => 'upm',
                'id_users' => $upm->id,
                'id_user_jurusan' => $pilkom->id,
            ],
            [
                'role'     => 'auditor_shared',
                'id_users' => $pilkom->id,
                'id_user_jurusan' => $pilkom->id,
            ],
        ];

        foreach ($allSubDefs as $subDef) {
            $nomorElemen = (int) $subDef->nomor_elemen;

            if (!isset($matriksByNomor[$nomorElemen])) {
                continue;
            }

            $matriksId = $matriksByNomor[$nomorElemen]->id;

            foreach ($subConfigs as $cfg) {
                $nilai = $this->resolveSubItemValue($nomorElemen, $subDef->variabel, $cfg['role']);
                if ($nilai === null) {
                    continue;
                }

                DB::table('users_sub_item_elemen')->updateOrInsert(
                    [
                        'id_sub_item_elemen' => $subDef->id,
                        'id_matriks'         => $matriksId,
                        'id_users'           => $cfg['id_users'],
                        'id_user_jurusan'    => $cfg['id_user_jurusan'],
                    ],
                    [
                        'nilai'      => $nilai,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    protected function resolveSubItemValue(int $nomorElemen, string $variabel, string $role): float|int|null
    {
        $override = self::USER_SUBITEM_OVERRIDES[$role][$nomorElemen][$variabel] ?? null;
        if ($override !== null) {
            return $override;
        }

        $map = [
            7 => [
                'RK'    => 5,
                'N1'    => 10,
                'N2'    => 8,
                'N3'    => 6,
                'NDTPS' => 18,
                'NI'    => 3,
                'NN'    => 10,
                'NW'    => 15,
            ],
            11 => [
                'NM'    => 200,
                'NDTPS' => 18,
                'RMD'   => 11.11,
            ],
            14 => [
                'RI' => 0.01,
                'RN' => 0.075,
                'RW' => 0.15,
                'NI' => 2,
                'NN' => 15,
                'NW' => 30,
                'NM' => 200,
            ],
            16 => [
                'JUMLAH_ASPEK' => 6,
                'TKM'          => 85,
            ],
            19 => [
                'NDS3'  => 2,
                'NDTPS' => 18,
                'NDGB'  => 0,
                'NDLK'  => 1,
                'NDL'   => 2,
                'PDS3'  => 11.11,
                'PGBLKL'=> 16.67,
            ],
            20 => [
                'BKD' => 14,
            ],
            21 => [
                'RRD'   => 1.11,
                'NRD'   => 20,
                'NDTPS' => 18,
            ],
            22 => [
                'NDTPSPK' => 90,
            ],
            23 => [
                'NTENDIKPK' => 60,
            ],
            33 => [
                'PDIPPKM' => 77.78,
                'NDIPPKM' => 14,
                'NDTPS'   => 18,
                'NMKI'    => 25,
                'NMK'     => 50,
                'PMKI'    => 50,
            ],
            40 => [
                'RIPK' => 3.50,
            ],
            42 => [
                'RMS' => 3.80,
            ],
            43 => [
                'PMTK' => 65,
            ],
            45 => [
                'NL'  => 150,
                'NJ'  => 135,
                'PLB' => 85,
            ],
            46 => [
                'NL'   => 150,
                'NJ'   => 135,
                'WTMP' => 4,
            ],
            47 => [
                'NL'  => 150,
                'NJ'  => 135,
                'PBS' => 75,
            ],
            48 => [
                'NL'  => 150,
                'NJ'  => 135,
                'TK1' => 85,
                'TK2' => 85,
                'TK3' => 80,
                'TK4' => 85,
                'TK5' => 82,
                'TK6' => 84,
                'TK7' => 83,
                'TK8' => 80,
                'TK9' => 81,
            ],
            53 => [
                'NI'    => 3,
                'NN'    => 20,
                'NL'    => 30,
                'NDTPS' => 18,
            ],
            54 => [
                'NPM' => 45,
                'NPD' => 50,
            ],
            55 => [
                'NA1'   => 5,
                'NA2'   => 10,
                'NA3'   => 8,
                'NA4'   => 5,
                'NB1'   => 8,
                'NB2'   => 12,
                'NB3'   => 6,
                'NC1'   => 3,
                'NC2'   => 5,
                'NC3'   => 2,
                'NDTPS' => 18,
            ],
            56 => [
                'NDTPS'       => 18,
                'NDTPS_PUB'   => 6,
                'S1_DTPS'     => 3,
                'S2_DTPS'     => 3,
                'S3_DTPS'     => 0,
                'S4_DTPS'     => 0,
                'INT_DTPS'    => 0,
                'INTREP_DTPS' => 3,
            ],
            57 => [
                'NAS'   => 150,
                'NDTPS' => 18,
            ],
            59 => [
                'NI'    => 2,
                'NN'    => 15,
                'NL'    => 20,
                'NDTPS' => 18,
            ],
            60 => [
                'NPkM'    => 35,
                'NPkDTPS' => 40,
            ],
        ];

        if (!isset($map[$nomorElemen])) {
            return null;
        }

        return $map[$nomorElemen][$variabel] ?? null;
    }
}
