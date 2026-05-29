<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixTemuanSaranSeeder extends Seeder
{
    public function run(): void
    {
        // [nomor, admin_temuan, admin_saran, auditor_temuan, auditor_saran]
        $data = [
            // === VISI KEILMUAN (1-4) ===
            [1, 'Dokumen visi misi belum selaras dengan Renstra Universitas', 'Sinkronkan visi misi PS dengan Renstra ULM',
             'Visi belum mengakomodasi perkembangan IPTEK terkini', 'Kaji ulang visi setiap 4 tahun melibatkan stakeholder'],
            [2, 'Sosialisasi visi misi perlu ditingkatkan ke stakeholder eksternal', 'Adakan workshop sosialisasi visi misi dengan alumni dan pengguna lulusan',
             'Tingkat pemahaman mahasiswa terhadap visi masih rendah', 'Integrasikan sosialisasi visi dalam kegiatan PKKMB dan bimbingan akademik'],
            [3, 'Mekanisme evaluasi visi misi belum terdokumentasi dengan baik', 'Buat SOP evaluasi visi misi yang terdokumentasi',
             'Keterkaitan visi dengan kegiatan tridharma belum terukur', 'Kembangkan matriks keterkaitan visi dengan indikator tridharma'],
            [4, 'Strategi pencapaian visi misi tidak terukur', 'Tetapkan KPI yang terukur untuk setiap strategi pencapaian visi',
             'Refleksi terhadap capaian visi belum dilakukan secara periodik', 'Lakukan evaluasi capaian visi setiap semester dalam rapat tinjauan manajemen'],

            // === TATA PAMONG (5-8) ===
            [5, 'Struktur tata pamong belum lengkap sesuai ketentuan', 'Lengkapi struktur organisasi dengan SK formal',
             'Uraian tugas dan fungsi setiap unit belum terdokumentasi', 'Buat dokumen SOP untuk setiap fungsi tata pamong'],
            [6, 'Pelaksanaan tata kelola belum sepenuhnya berbasis risiko', 'Kembangkan sistem manajemen risiko di tingkat PS',
             'Laporan kinerja tahunan belum menggambarkan capaian IKU', 'Sempurnakan laporan kinerja dengan analisis capaian IKU'],
            [7, 'Kerjasama tridharma masih didominasi bidang pendidikan', 'Tingkatkan kerjasama penelitian dan PkM dengan industri',
             'Dokumen MOU kerjasama belum diperbaharui dalam 3 tahun terakhir', 'Lakukan monitoring dan perpanjangan MOU secara berkala'],
            [8, 'Evaluasi tata pamong belum dilaksanakan secara berkala', 'Jadwalkan evaluasi tata kelola setiap akhir tahun akademik',
             'Tindak lanjut hasil evaluasi tata pamong belum terdokumentasi', 'Buat sistem dokumentasi tindak lanjut hasil evaluasi'],

            // === MAHASISWA (9-17) ===
            [9, 'Seleksi mahasiswa baru belum sepenuhnya berbasis data', 'Gunakan data traced study untuk menentukan target kuota',
             'Sosialisasi PMB di luar Kalimantan Selatan masih minim', 'Perluas jangkauan sosialisasi ke provinsi tetangga'],
            [10, 'Kualitas input mahasiswa bervariasi antar jalur masuk', 'Evaluasi kembali bobot seleksi setiap jalur penerimaan',
             'Rata-rata nilai UTBK masih di bawah rata-rata nasional', 'Tingkatkan branding PS untuk menarik calon mahasiswa berkualitas'],
            [11, 'Rasio dosen:mahasiswa belum ideal untuk beberapa bidang', 'Usulkan penambahan kuota DTPS ke FKIP',
             'Distribusi bimbingan mahasiswa tidak merata antar dosen', 'Buat sistem pemerataan distribusi bimbingan akademik'],
            [12, 'Layanan perpustakaan digital masih terbatas', 'Tingkatkan akses ke jurnal internasional berlangganan',
             'Ruang kuliah belum dilengkapi LCD di semua kelas', 'Ajukan pengadaan sarana multimedia secara bertahap'],
            [13, 'Belum ada asuransi kecelakaan bagi mahasiswa', 'Kerjasamakan dengan BPJS atau asuransi swasta untuk mahasiswa',
             'Sistem pengaduan mahasiswa belum berjalan efektif', 'Optimalkan layanan pengaduan berbasis aplikasi'],
            [14, 'Prestasi mahasiswa tingkat internasional masih minim', 'Fasilitasi mahasiswa untuk mengikuti kompetisi internasional',
             'Tidak ada pendampingan khusus untuk mahasiswa berpotensi', 'Bentuk tim pembinaan mahasiswa berprestasi'],
            [15, 'Publikasi ilmiah mahasiswa masih rendah', 'Integrasikan tugas akhir dengan publikasi ilmiah',
             'Karya inovatif mahasiswa belum didata secara sistematis', 'Buat portal dokumentasi karya inovatif mahasiswa'],
            [16, 'Survei kepuasan mahasiswa belum dilakukan rutin', 'Laksanakan survei kepuasan setiap semester',
             'Hasil survei kepuasan belum ditindaklanjuti secara sistemik', 'Buat SOP tindak lanjut hasil survei kepuasan'],
            [17, 'Refleksi capaian kriteria mahasiswa belum komprehensif', 'Buat laporan evaluasi tahunan capaian kriteria mahasiswa',
             'Data tracer study belum dimanfaatkan untuk perbaikan', 'Gunakan hasil tracer study untuk evaluasi kurikulum'],

            // === DOSEN DAN TENDIK (18-24) ===
            [18, 'Seleksi dosen belum sepenuhnya berbasis kebutuhan riil', 'Lakukan analisis beban kerja sebelum usulan seleksi',
             'Rekrutmen tendik belum sesuai dengan analisis jabatan', 'Susun peta kebutuhan tendik jangka panjang'],
            [19, 'Jumlah guru besar masih sangat terbatas', 'Fasilitasi percepatan kenaikan jabatan akademik ke Lektor Kepala dan Guru Besar',
             'DTPS dengan sertifikasi pendidik masih belum 100%', 'Dorong DTPS untuk mengikuti sertifikasi pendidik'],
            [20, 'Beban kerja DTPS belum merata antar bidang', 'Evaluasi distribusi beban kerja setiap semester',
             'Beberapa DTPS mengajar di luar bidang keahlian', 'Sesuaikan penugasan mengajar dengan bidang keahlian'],
            [21, 'Pengakuan kepakaran DTPS sebagai narasumber masih rendah', 'Promosikan kepakaran DTPS melalui media dan seminar',
             'DTPS belum banyak yang menjadi reviewer jurnal', 'Fasilitasi DTPS untuk menjadi reviewer jurnal nasional/internasional'],
            [22, 'Program pengembangan kompetensi belum terencana secara sistematis', 'Buat roadmap pengembangan kompetensi DTPS 5 tahun',
             'Anggaran pelatihan DTPS masih terbatas', 'Usulkan peningkatan anggaran pengembangan SDM'],
            [23, 'Tenaga kependidikan belum banyak yang mengikuti pelatihan teknis', 'Jadwalkan pelatihan teknis tendik secara periodik',
             'Sertifikasi tendik masih sangat kurang', 'Fasilitasi tendik untuk mengikuti sertifikasi profesi'],
            [24, 'Refleksi capaian kriteria SDM belum terintegrasi', 'Buat dashboard capaian kinerja DTPS dan tendik',
             'Beberapa DTPS belum memiliki jabatan akademik Lektor', 'Dorong DTPS untuk mengurus kenaikan jabatan akademik'],

            // === KEUANGAN, SARANA, PRASARANA (25-30) ===
            [25, 'Perencanaan keuangan belum mengacu pada analisis kebutuhan riil', 'Kembangkan sistem perencanaan berbasis prioritas',
             'RKAT belum sepenuhnya menjadi pedoman pelaksanaan anggaran', 'Sinkronkan RKAT dengan realisasi secara berkala'],
            [26, 'Penyerapan anggaran masih timpang antar kegiatan', 'Evaluasi efektivitas penggunaan anggaran setiap triwulan',
             'SPJ kegiatan sering terlambat', 'Sosialisasikan batas waktu pelaporan SPJ'],
            [27, 'Ruang kuliah belum memenuhi standar luas minimal', 'Ajukan rencana rehabilitasi ruang kuliah',
             'Laboratorium komputer perlu pembaharuan spesifikasi', 'Usulkan upgrade laboratorium secara bertahap'],
            [28, 'Bandwidth internet belum mencukupi kebutuhan pembelajaran', 'Tingkatkan kapasitas bandwidth sesuai kebutuhan',
             'LMS belum dimanfaatkan secara optimal oleh dosen', 'Adakan pelatihan penggunaan LMS untuk dosen'],
            [29, 'Belum ada prosedur tanggap darurat yang terdokumentasi', 'Buat SOP tanggap darurat dan lakukan simulasi',
             'Alat pemadam kebakaran belum tersedia di setiap lantai', 'Lengkapi APAR dan rambu evakuasi'],
            [30, 'Evaluasi sarana prasarana belum dilakukan terjadwal', 'Buat jadwal evaluasi sarpras setiap semester',
             'Inventaris aset belum terupdate secara real-time', 'Terapkan sistem informasi manajemen aset'],

            // === PENDIDIKAN (31-51) ===
            [31, 'Kurikulum belum sepenuhnya mengakomodasi MBKM', 'Integrasikan program MBKM ke dalam struktur kurikulum',
             'RPS belum diperbaharui secara konsisten setiap semester', 'Buat jadwal review dan update RPS setiap semester'],
            [32, 'Pembelajaran masih berpusat pada dosen (teacher-centered)', 'Dorong penerapan metode student-centered learning',
             'Penggunaan teknologi pembelajaran masih terbatas', 'Kembangkan konten pembelajaran digital interaktif'],
            [33, 'Hasil penelitian belum banyak diintegrasikan ke pembelajaran', 'Buat kebijakan integrasi riset ke bahan ajar',
             'PkM dosen belum termanfaatkan sebagai sumber belajar', 'Dokumentasikan hasil PkM sebagai studi kasus perkuliahan'],
            [34, 'Instrumen penilaian belum divalidasi secara sistemik', 'Kembangkan bank soal yang terstandar dan tervalidasi',
             'Rubrik penilaian belum tersedia untuk semua mata kuliah', 'Lengkapi RPS dengan rubrik penilaian yang jelas'],
            [35, 'Perkuliahan microteaching belum terintegrasi dengan kurikulum', 'Jadwalkan microteaching secara terstruktur setiap semester',
             'Rasio dosen:mahasiswa pada microteaching tidak ideal', 'Tambah jumlah dosen pengampu microteaching'],
            [36, 'Mitra magang kependidikan masih terbatas', 'Perluas jaringan mitra magang ke sekolah unggulan',
             'Pendampingan magang belum optimal karena rasio pembimbing', 'Tambah jumlah dosen pembimbing magang'],
            [37, 'SOP pembimbingan magang belum terdokumentasi', 'Buat panduan pembimbingan magang yang terstandar',
             'Monitoring magang belum dilakukan secara terjadwal', 'Buat jadwal monitoring magang rutin setiap bulan'],
            [38, 'Kegiatan suasana akademik masih kurang variatif', 'Adakan seminar dan diskusi ilmiah rutin setiap bulan',
             'Partisipasi mahasiswa dalam kegiatan akademik masih rendah', 'Buat program insentif partisipasi kegiatan akademik'],
            [39, 'Pembimbingan tugas akhir belum terstandar', 'Buat buku panduan pembimbingan tugas akhir yang seragam',
             'Rasio pembimbingan tugas akhir tidak ideal', 'Tetapkan batas maksimal bimbingan per dosen'],
            [40, 'IPK lulusan menurun dalam 3 tahun terakhir', 'Evaluasi kurikulum dan proses pembelajaran',
             'Distribusi IPK tidak merata antar angkatan', 'Terapkan sistem early warning untuk mahasiswa berpotensi dropout'],
            [41, 'Masa studi lulusan masih di atas 4,5 tahun', 'Evaluasi efektivitas bimbingan akademik',
             'Masa studi mahasiswa transfer lebih lama dari ketentuan', 'Buat kebijakan khusus percepatan studi mahasiswa transfer'],
            [42, 'Persentase kelulusan tepat waktu masih rendah', 'Optimalkan sistem monitoring akademik mahasiswa',
             'Masa studi antar program studi tidak konsisten', 'Tetapkan target kelulusan tepat waktu per prodi'],
            [43, 'Angka keberhasilan studi belum mencapai target', 'Kembangkan program remedial dan pengayaan akademik',
             'Tingkat dropout mahasiswa masih perlu diwaspadai', 'Buat sistem konseling akademik yang responsif'],
            [44, 'Tracer study belum menjangkau seluruh lulusan', 'Kembangkan tracer study berbasis aplikasi dan media sosial',
             'Response rate tracer study masih di bawah 50%', 'Buat insentif bagi lulusan yang mengisi tracer study'],
            [45, 'Data kesiapkerjaan lulusan belum terkelola dengan baik', 'Bangun database alumni yang terintegrasi',
             'Program kewirausahaan bagi mahasiswa masih terbatas', 'Kembangkan pusat karir dan inkubasi bisnis'],
            [46, 'Waktu tunggu lulusan rata-rata >6 bulan', 'Perkuat jejaring karir dan tracer study',
             'Informasi lowongan kerja belum tersosialisasi dengan baik', 'Buat portal informasi lowongan kerja khusus alumni'],
            [47, 'Kesesuaian bidang kerja lulusan perlu ditingkatkan', 'Selaraskan kurikulum dengan kebutuhan dunia kerja',
             'Data kepuasan pengguna lulusan belum dikumpulkan rutin', 'Laksanakan survei kepuasan pengguna setiap tahun'],
            [48, 'Survei kepuasan pengguna lulusan belum dilakukan rutin', 'Jadwalkan survei kepuasan pengguna setiap tahun',
             'Instrumen survei kepuasan belum terstandar', 'Kembangkan instrumen survei yang terstandar dan komprehensif'],
            [49, 'Asesmen pencapaian CPL belum dilakukan secara sistemik', 'Kembangkan sistem asesmen CPL terintegrasi',
             'Bukti pencapaian CPL belum terdokumentasi rapi', 'Buat portofolio pencapaian CPL setiap mahasiswa'],
            [50, 'Evaluasi kurikulum belum melibatkan seluruh stakeholder', 'Libatkan alumni dan pengguna lulusan dalam evaluasi kurikulum',
             'Hasil evaluasi kurikulum belum ditindaklanjuti secara konkret', 'Buat roadmap tindak lanjut hasil evaluasi kurikulum'],
            [51, 'Refleksi capaian kriteria pendidikan belum komprehensif', 'Buat laporan evaluasi tahunan capaian pembelajaran',
             'Benchmarking kurikulum dengan PT lain belum dilakukan', 'Lakukan benchmarking kurikulum secara periodik'],

            // === PENELITIAN (52-58) ===
            [52, 'Peta jalan penelitian belum diimplementasikan secara konsisten', 'Sosialisasikan peta jalan penelitian ke semua DTPS',
             'Penelitian DTPS belum sepenuhnya mengacu pada peta jalan', 'Integrasikan peta jalan ke dalam sistem monitoring penelitian'],
            [53, 'Produktivitas penelitian DTPS masih perlu ditingkatkan', 'Buat target publikasi tahunan per DTPS',
             'Penelitian DTPS masih fokus pada satu bidang', 'Dorong riset multidisiplin dan kolaboratif'],
            [54, 'Pelibatan mahasiswa dalam penelitian masih rendah', 'Integrasikan penelitian dengan tugas akhir mahasiswa',
             'Skema pendanaan penelitian mahasiswa belum tersedia', 'Buka skema hibah penelitian mahasiswa'],
            [55, 'Jumlah publikasi ilmiah DTPS di jurnal bereputasi masih rendah', 'Adakan writing bootcamp untuk publikasi internasional',
             'Publikasi internasional DTPS masih sangat minim', 'Fasilitasi proofreading dan biaya publikasi internasional'],
            [56, 'Tidak semua DTPS memiliki publikasi ilmiah', 'Buat program insentif publikasi bagi DTPS',
             'DTPS muda belum produktif dalam publikasi', 'Bentuk kelompok riset yang membina DTPS muda'],
            [57, 'Rata-rata sitasi artikel DTPS masih rendah', 'Promosikan publikasi melalui Google Scholar dan ResearchGate',
             'Sitasi artikel masih sangat rendah', 'Dorong publikasi di jurnal terindeks Scopus'],
            [58, 'Refleksi capaian kriteria penelitian belum optimal', 'Buat laporan evaluasi tahunan capaian penelitian',
             'Data capaian penelitian belum terintegrasi dalam satu sistem', 'Kembangkan sistem informasi penelitian terpadu'],

            // === PENGABDIAN (59-61) ===
            [59, 'Produktivitas PkM DTPS masih perlu ditingkatkan', 'Buat target PkM tahunan per DTPS',
             'PkM yang melibatkan mitra internasional belum ada', 'Jalin kerjasama PkM dengan mitra luar negeri'],
            [60, 'Pelibatan mahasiswa dalam PkM masih rendah', 'Integrasikan PkM ke dalam mata kuliah terkait',
             'Mahasiswa belum banyak terlibat dalam kegiatan PkM dosen', 'Buat skema PkM mahasiswa bina desa'],
            [61, 'Refleksi capaian kriteria PkM belum terdokumentasi', 'Buat laporan evaluasi tahunan capaian PkM',
             'Luaran PkM belum banyak yang berupa publikasi atau HKI', 'Dorong luaran PkM berupa publikasi dan HKI'],

            // === PENJAMINAN MUTU (62-65) ===
            [62, 'Unsur pelaksana penjaminan mutu sudah terbentuk tetapi belum optimal', 'Aktifkan rapat koordinasi SPMI rutin setiap bulan',
             'Anggota SPMI belum mendapatkan pelatihan yang memadai', 'Adakan pelatihan SPMI bagi anggota baru'],
            [63, 'Dokumen SPMI belum lengkap dan terintegrasi', 'Lengkapi dokumen SPMI sesuai standar LAMDIK',
             'SOP mutu belum tersedia untuk semua standar', 'Susun SOP mutu untuk setiap standar secara bertahap'],
            [64, 'Siklus PPEPP belum berjalan penuh untuk semua standar', 'Implementasikan PPEPP secara konsisten untuk 9 standar',
             'Dokumentasi PPEPP masih kurang rapi', 'Buat template dokumentasi PPEPP yang seragam'],
            [65, 'Refleksi capaian kriteria penjaminan mutu belum optimal', 'Buat laporan evaluasi tahunan SPMI',
             'Tindak lanjut hasil audit mutu internal belum maksimal', 'Buat sistem monitoring tindak lanjut hasil AMI'],
        ];

        $userIds = [1, 3];  // admin_jurusan + admin_FKIP
        $userIdAuditor = 4;

        foreach ($data as [$nomor, $adminTemuan, $adminSaran, $auditorTemuan, $auditorSaran]) {
            $matriks = DB::table('matriks_lembar_evaluasi_diri')->where('nomor', $nomor)->first();
            if (!$matriks) continue;

            foreach ($userIds as $uid) {
                DB::table('users_matrik')
                    ->where('id_matriks_led', $matriks->id)
                    ->where('id_users', $uid)
                    ->update(['temuan' => $adminTemuan, 'saran' => $adminSaran]);
            }

            DB::table('users_matrik')
                ->where('id_matriks_led', $matriks->id)
                ->where('id_users', $userIdAuditor)
                ->update(['temuan' => $auditorTemuan, 'saran' => $auditorSaran]);
        }

        $this->command->info('Fixed temuan/saran for ' . count($data) . ' elements (users 1, 3 & 4)');
    }
}
