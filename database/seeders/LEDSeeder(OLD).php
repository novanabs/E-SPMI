<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LEDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nomor'                => 1,
                'id_kriteria'          => 1,
                'elemen'               => 'Ketepatan Rumusan Visi Keilmuan PS',
                'poin'                 => '1.25',
                'indikator'            =>
                    'PS memiliki  visi keilmuan yang dirumuskan (a) secara tepat sebagai visi keilmuan, (b) menunjukkan kekhasan PS, (c) berwawasan ke depan, (d) relevan dengan perkembangan IPTEKS dan kebutuhan masyarakat, dan (e) selaras dengan visi kelembagaan PT/UPPS.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PS memiliki visi keilmuan yang perumusannya memenuhi 5 aspek.',
                    3 => 'PS memiliki visi keilmuan yang perumusannya memenuhi 4 aspek.',
                    2 => 'PS memiliki visi keilmuan yang perumusannya memenuhi 3 aspek.',
                    1 => 'PS memiliki visi keilmuan yang perumusannya memenuhi kurang dari 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],

            [
                'nomor'                => 2,
                'id_kriteria'          => 1,
                'elemen'               => 'Sosialisasi dan Tingkat Pemahaman Visi Keilmuan PS',
                'poin'                 => '1.30',
                'indikator'            =>
                    'Dalam tiga tahun terakhir, PS (a) melakukan sosialisasi visi keilmuan kepada para pemangku kepentingan melalui (1) rapat PS, (2) kuliah umum PS, (3) flyer/banner/ papan, dll, (4) website PS, (5) media sosial PS, (b) mengukur, menganalisis dan mengevaluasi pemahaman pemangku kepentingan terhadap visi keilmuan tersebut secara periodik, dan (c) menindaklanjuti hasil evaluasi tersebut.  ',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a. PS melakukan sosialisasi visi keilmuan kepada para pemangku kepentingan melalui 5 cara; b. PS mengukur, menganalisis dan mengevaluasi pemahaman pemangku kepentingan terhadap visi keilmuan PS 1 kali setahun dalam 3 tahun terakhir; c. PS menindaklanjuti hasil evaluasi pemahaman pemangku kepentingan terhadap visi keilmuan.',
                    3 => 'a. PS melakukan sosialisasi visi keilmuan kepada para pemangku kepentingan melalui 4 cara; b. PS mengukur, menganalisis dan mengevaluasi pemahaman pemangku kepentingan terhadap visi keilmuan PS 2 kali dalam 3 tahun terakhir; c. PS menindaklanjuti hasil evaluasi pemahaman pemangku kepentingan terhadap visi keilmuan. ',
                    2 => 'a. PS melakukan sosialisasi visi keilmuan kepada para pemangku kepentingan melalui 3 cara; b. PS mengukur, menganalisis dan mengevaluasi pemahaman pemangku kepentingan terhadap visi keilmuan PS sekali dalam 3 tahun terakhir; c. PS tidak menindaklanjuti hasil evaluasi. ',
                    1 => 'a. PS melakukan sosialisasi visi keilmuannya  kepada pemangku kepentingan melalui < 3 cara; b. PS tidak melakukan pengukuran terhadap pemahaman visi keilmuan PS. '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],

            [
                'nomor'                => 3,
                'id_kriteria'          => 1,
                'elemen'               => 'Peran Visi Keilmuan sebagai Rujukan Pengembangan Kurikulum, Pembelajaran, Penelitian, dan PkM',
                'poin'                 => '1.50',
                'indikator'            =>
                    'Visi keilmuan PS  menjadi rujukan  (a) pengembangan kurikulum; (b) pembelajaran; (c) penelitian, dan (d) PkM',
                'option_pilihan_ganda' => json_encode([
                    4 => 'Visi keilmuan PS menjadi rujukan bagi 4 kegiatan.',
                    3 => 'Visi keilmuan PS menjadi rujukan bagi 3 kegiatan.',
                    2 => 'Visi keilmuan PS menjadi rujukan bagi 2 kegiatan.',
                    1 => 'Visi keilmuan PS menjadi rujukan bagi < 2 kegiatan. '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],

            [
                'nomor'                => 4,
                'id_kriteria'          => 1,
                'elemen'               => 'Evaluasi Visi Keilmuan PS dan Tindak Lanjut',
                'poin'                 => '1.50',
                'indikator'            =>
                    'PS melakukan evaluasi dan tindak lanjut terhadap visi keilmuan, dengan ketentuan sebagai berikut. (a) Evaluasi (1) dilakukan terhadap elemenelemen visi keilmuan dengan cara mengidentiﬁkasi minimal kelebihan dan kelemahannya, (2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif, (3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai, (4) didokumenta- sikan secara lengkap dan sahih. (b) Tindak lanjut (1) didasarkan pada hasil evaluasi, (2) dirumuskan secara spesiﬁk, terukur, realistis, dan berbasis waktu, (3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan, dan (4) didukung bukti pelaksanaan yang lengkap dan sahih.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a. PS melakukan evaluasi terhadap visi keilmuannya dengan memenuhi  4 aspek. b. PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap visi keilmuannya dengan memenuhi  4 aspek. ',
                    3 => 'a. PS melakukan evaluasi terhadap visi keilmuannya dengan memenuhi  3 aspek. b. PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap visi keilmuannya dengan memenuhi  3 aspek. ',
                    2 => 'a. PS melakukan evaluasi terhadap visi keilmuannya dengan memenuhi  2 aspek. b. PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap visi keilmuannya dengan memenuhi  aspek 2 aspek. ',
                    1 => 'a. PS melakukan evaluasi terhadap visi keilmuannya dengan memenuhi  < 2 aspek. b. PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap visi keilmuannya dengan memenuhi  < 2 aspek. '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 5,
                'id_kriteria'          => 2,
                'elemen'               => 'Keberadaan Tata Pamong',
                'poin'                 => '1.25',
                'indikator'            => 'Tata pamong di UPPS yang: (a) memiliki 5 aspek: (1) struktur organisasi, (2) job description tiap organ, (3) staﬃng, (4) tata hubungan antar organ, (5) mekanisme dan sistem kontrol. (b) memenuhi prinsip good governance: (1) kredibel, (2) transparan, (3) akuntabel, (4) bertanggung jawab, dan (5) adil. ',
                'option_pilihan_ganda' => json_encode([
                    4 => 'Tata pamong di UPPS: a. memiliki 5 aspek. b. memenuhi 5 prinsip good governance.',
                    3 => 'Tata pamong di UPPS: a. memiliki 4 aspek. b. memenuhi 4 prinsip good governance.',
                    2 => 'Tata pamong di UPPS: a. memiliki 3 aspek. b. memenuhi 3 prinsip good governance.',
                    1 => 'Tata pamong di UPPS: a. memiliki < 3 aspek. b. memenuhi < 3 prinsip good governance. '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 6,
                'id_kriteria'          => 2,
                'elemen'               => 'Pelaksanaan Tata Kelola',
                'poin'                 => '1.50',
                'indikator'            => 'UPPS menjalankan proses tata kelola yang mencakup aspek (a) perencanaan, (b) pengorganisasian, (c) penempatan personel, (d) pelaksanaan, (e) pengendalian dan pengawasan, (f) pelaporan yang menjadi dasar tindak lanjut.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'UPPS menjalankan tata kelola yang mencakup 6 aspek.',
                    3 => 'UPPS menjalankan tata kelola yang mencakup 5 aspek.',
                    2 => 'UPPS menjalankan tata kelola yang mencakup 4 aspek.',
                    1 => 'UPPS menjalankan tata kelola yang mencakup < 4 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 8,
                'id_kriteria'          => 2,
                'elemen'               => 'Evaluasi Tata Pamong dan Tata Kelola UPPS dan Tindak Lanjut',
                'poin'                 => '1.50',
                'indikator'            => 'UPPS melakukan evaluasi dan tindak lanjut terhadap tata kelola, dengan ketentuan sebagai berikut. (a) Evaluasi: (1) dilakukan terhadap elemen-elemen tata kelola dengan cara mengidentifikasi minimal kelebihan dan kelemahannya, (2) dilakukan berdasarkan parameter tertentu secara kuantitatif/kualitatif, (3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai, (4) didokumentasikan secara lengkap dan sahih. (b) Tindak lanjut: (1) didasarkan pada hasil evaluasi, (2) dirumuskan secara spesifik, terukur, realistis, dan berbasis waktu, (3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan, dan (4) didukung bukti pelaksanaan yang lengkap dan sahih.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a. UPPS melakukan evaluasi terhadap tata kelola dengan memenuhi  4 aspek. b. UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap tata kelola dengan memenuhi  4 aspek.',
                    3 => 'a. UPPS melakukan evaluasi terhadap tata kelola dengan memenuhi  3 aspek. b. UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap tata kelola dengan memenuhi  3 aspek. ',
                    2 => 'a. UPPS melakukan evaluasi terhadap tata kelola dengan memenuhi  2 aspek. b. UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap tata kelola dengan memenuhi  aspek 2 aspek. ',
                    1 => 'a. UPPS melakukan evaluasi terhadap tata kelola dengan memenuhi  < 2 aspek. b. UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap tata kelola dengan memenuhi  < 2 aspek'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 9,
                'id_kriteria'          => 3,
                'elemen'               => 'Pelaksanaan seleksi mahasiswa baru',
                'poin'                 => '1.50',
                'indikator'            => 'PT/UPPS melaksanakan seleksi calon mahasiswa baru yang mencerminkan prinsip (a) kualitas, (b) keadilan, (c) inklusifitas, (d) transparansi, (e) akuntabilitas, dan (f) fleksibilitas.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PT/UPPS melaksanakan seleksi mahasiswa baru yang memenuhi 6 prinsip.',
                    3 => 'PT/UPPS melaksanakan seleksi mahasiswa baru yang memenuhi 5 prinsip.',
                    2 => 'PT/UPPS melaksanakan seleksi mahasiswa baru yang memenuhi 4 prinsip.',
                    1 => 'PT/UPPS melaksanakan seleksi mahasiswa baru yang memenuhi < 4 prinsip.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 10,
                'id_kriteria'          => 3,
                'elemen'               => 'Kualitas input mahasiswa',
                'poin'                 => '1.25',
                'indikator'            => 'PT memperoleh mahasiswa baru dengan prestasi akademik dan nonakademik yang baik, yang memenuhi aspek-aspek sebagai berikut: (a) memiliki kriteria seleksi yang tinggi, (b) memiliki mekanisme seleksi yang ketat, (c) rasio pendaftar dan yang diterima minimal 1:1, dan (d) jumlah pendaftar memenuhi daya tampung dalam 5 tahun terakhir. ',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PT memperoleh mahasiswa baru dengan prestasi akademik dan non-akademik yang baik, memenuhi 4 aspek; dengan rasio pendaftar:lulus seleksi ≥ 3:1.',
                    3 => 'PT memperoleh mahasiswa baru dengan prestasi akademik dan non-akademik yang baik, memenuhi 3 aspek; dengan rasio pendaftar:lulus seleksi 2:1.',
                    2 => 'PT memperoleh mahasiswa baru dengan prestasi akademik dan non-akademik yang baik, memenuhi 2 aspek; dengan rasio pendaftar:lulus seleksi 1:1.',
                    1 => 'PT memperoleh mahasiswa baru dengan prestasi akademik dan non-akademik yang baik, memenuhi < 2 aspek; dengan rasio pendaftar:lulus seleksi < 1:1.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 12,
                'id_kriteria'          => 3,
                'elemen'               => 'Ketersediaan, aksesibilitas, dan kualitas layanan mahasiswa',
                'poin'                 => '1.25',
                'indikator'            => 'PT/UPPS (a) menyediakan layanan mahasiswa yang mencakup: (1) administrasi akademik, (2) bimbingan konseling, (3) Kesehatan, (4) keperluan dasar untuk mahasiswa berkebutuhan khusus, (5) beasiswa, (6) layanan Teknologi Informasi (TI),  dan (7) bimbingan penulisan dan publikasi artikel; (b) Layanan tersebut dapat diakses oleh mahasiswa; (c) Layanan tersebut memiliki kualitas yang baik. ',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PT/UPPS menyediakan   semua jenis layanan  mahasiswa, dengan kualitas yang baik dan dapat diakses oleh semua mahasiswa. ',
                    3 => 'PT/UPPS menyediakan 4  jenis layanan  mahasiswa (1 s.d 4) dan 1-2 jenis layanan lainnya, dengan kualitas yang baik dan dapat diakses oleh semua mahasiswa. ',
                    2 => 'PT/UPPS menyediakan 4  jenis layanan mahasiswa (1 s.d. 4) dengan kualitas yang baik dan dapat diakses oleh semua mahasiswa. ',
                    1 => 'PT/UPPS menyediakan  < 4  jenis layanan  mahasiswa. '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 13,
                'id_kriteria'          => 3,
                'elemen'               => 'Perlindungan Mahasiswa',
                'poin'                 => '1.50',
                'indikator'            => 'PT/UPPS/PS menyediakan layanan perlindungan  kepada mahasiswa dari perundungan, pelecehan seksual, dan intoleransi yang meliputi aspek-aspek berikut: (a) Ketersediaan unit /organ/satuan tugas pelaksana, (b) Ketersediaan panduan, (c) Kegiatan sosialisasi dan pelatihan di PS, dan (d) Ketersediaan bukti pelaksanaan di tingkat PS. ',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PT/UPPS/PS menyediakan layanan perlindungan terhadap perundungan, pelecehan seksual, dan intoleransi yang mencakup 4 aspek. ',
                    3 => 'PT/UPPS/PS menyediakan layanan perlindungan terhadap perundungan, pelecehan seksual, dan intoleransi yang mencakup 3 aspek. ',
                    2 => 'PT/UPPS/PS menyediakan layanan perlindungan terhadap perundungan, pelecehan seksual, dan intoleransi yang mencakup 2 aspek.  ',
                    1 => 'PT/UPPS/PS menyediakan layanan perlindungan terhadap perundungan, pelecehan seksual, dan intoleransi hanya  1 aspek atau tidak memiliki.  '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 15,
                'id_kriteria'          => 3,
                'elemen'               => 'Produktivitas karya inovatif mahasiswa',
                'poin'                 => '2.00',
                'indikator'            => 'Dalam 5 tahun terakhir, mahasiswa menghasilkan karya inovatif dan/atau publikasi ilmiah yang relevan dengan bidang keilmuan PS pada jurnal nasional terakreditasi minimal Sinta 4. PKIM = Persentase jumlah mahasiswa memiliki karya inovatif yang  berbentuk book chapter,  buku ber-ISBN, paten/paten sederhana, Hak Kekayaan Intelektual (HKI) pada karya modul pembelajaran, media pembelajaran interaktif, aplikasi pembelajaran, karya seni, atau karya lain yang sejenis, dan/atau publikasi ilmiah  yang dipublikasi pada jurnal nasional terakreditasi minimal Sinta 4 sesuai bidang keilmuannya dalam 5 tahun terakhir. ',
                'option_pilihan_ganda' => json_encode([
                    4 => 'Dalam 5 tahun terakhir, ≥ 25% mahasiswa memiliki karya inovatif yang  berbentuk book chapter,  buku ber-ISBN, paten/paten sederhana, Hak Kekayaan Intelektual (HKI) pada karya modul pembelajaran, media pembelajaran interaktif, aplikasi pembelajaran, karya seni, atau karya lain yang sejenis, dan/atau publikasi ilmiah  yang dipublikasi pada jurnal nasional terakreditasi minimal Sinta 4 sesuai bidang keilmuannya. ',
                    3 => '5 % >  mahasiswa ≥ 20% dalam 5 tahun terakhir memiliki karya inovatif yang berbentuk book chapter,  buku ber-ISBN, paten/paten sederhana, Hak Kekayaan Intelektual (HKI) pada karya modul pembelajaran, media pembelajaran interaktif, aplikasi pembelajaran, karya seni, atau karya lain yang sejenis, dan/atau publikasi ilmiah  yang dipublikasi pada jurnal nasional terakreditasi minimal Sinta 4 sesuai bidang keilmuannya.  ',
                    2 => '20 % >  mahasiswa ≥15% dalam 5 tahun terakhir memiliki karya inovatif yang berbentuk book chapter,  buku ber-ISBN, paten/paten sederhana, Hak Kekayaan Intelektual (HKI) pada karya modul pembelajaran, media pembelajaran interaktif, aplikasi pembelajaran, karya seni, atau karya lain yang sejenis, dan/atau publikasi ilmiah  yang dipublikasi pada jurnal nasional terakreditasi minimal Sinta 4 sesuai bidang keilmuannya. ',
                    1 => '<15% mahasiswa dalam 5 tahun terakhir memiliki karya inovatif yang  berbentuk book chapter,  buku ber-ISBN, paten/paten sederhana, Hak Kekayaan Intelektual (HKI) pada karya modul pembelajaran, media pembelajaran interaktif, aplikasi pembelajaran, karya seni, atau karya lain yang sejenis, dan/atau publikasi ilmiah  yang dipublikasi pada jurnal nasional terakreditasi minimal Sinta 4 sesuai bidang keilmuannya.   '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 17,
                'id_kriteria'          => 3,
                'elemen'               => ' Evaluasi Mahasiswa  dan Tindak Lanjut ',
                'poin'                 => ' 1.50 ',
                'indikator'            => ' UPPS/PS melakukan evaluasi dan tindak lanjut terhadap mahasiswa, dengan ketentuan sebagai berikut. (a) Evaluasi (1) dilakukan terhadap elemen-elemen mahasiswa dengan cara mengidentiﬁkasi minimal kelebihan dan kelemahannya, (2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif, (3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai, (4) didokumenta- sikan secara lengkap dan sahih. (b) Tindak lanjut (1) didasarkan pada hasil evaluasi, (2) dirumuskan secara spesiﬁk, terukur, realistis, dan berbasis waktu, (3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan, dan (4) didukung bukti pelaksanaan yang lengkap dan sahih.   ',
                'option_pilihan_ganda' => json_encode([
                    4 => ' a. UPPS/PS melakukan evaluasi terhadap mahasiswa dengan memenuhi  4 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap mahasiswa dengan memenuhi  4 aspek.  ',
                    3 => ' a. UPPS/PS melakukan evaluasi terhadap mahasiswa dengan memenuhi  3 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap mahasiswa dengan memenuhi  3 aspek.  ',
                    2 => ' a. UPPS/PS melakukan evaluasi terhadap mahasiswa dengan memenuhi  2 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap mahasiswa dengan memenuhi  2 aspek.  ',
                    1 => ' a. UPPS/PS melakukan evaluasi terhadap mahasiswa dengan memenuhi  < 2 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap mahasiswa dengan memenuhi  < 2 aspek. '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 18,
                'id_kriteria'          => 4,
                'elemen'               => ' Pelaksanaan seleksi dosen dan tenaga kependidikan  ',
                'poin'                 => ' 1.50 ',
                'indikator'            => ' PT/UPPS/PS melaksanakan seleksi calon dosen dan tenaga kependidikan yang memenuhi aspek-aspek sbb: (a) melakukan analisis kebutuhan, (b) pengumuman yang transparan, (c) seleksi berbasisi kompetensi, (d) metode seleksi yang beragam, (e) pengumuman hasil, dan (f) memberi kesempatan banding.   ',
                'option_pilihan_ganda' => json_encode([
                    4 => ' PT/UPPS melaksanakan seleksi calon dosen dan tenaga kependidikan yang yang meliputi 6 aspek.  ',
                    3 => ' PT/UPPS melaksanakan seleksi calon dosen dan tenaga kependidikan yang yang meliputi 5 aspek.  ',
                    2 => ' PT/UPPS melaksanakan seleksi calon dosen dan tenaga kependidikan yang yang meliputi 4 aspek.  ',
                    1 => ' PT/UPPS melaksanakan seleksi calon dosen dan tenaga kependidikan yang yang meliputi < 4 aspek.  '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 22,
                'id_kriteria'          => 4,
                'elemen'               => ' Pengembangan kompetensi DTPS ',
                'poin'                 => ' 1.75 ',
                'indikator'            => ' Pengembangan kompetensi DTPS   ',
                'option_pilihan_ganda' => json_encode([
                    4 => ' NPKDTPS ≥ 80%.  ',
                    3 => ' 70% ≤ NPKDTPS <80%. ',
                    2 => ' 60% ≤ NPKDTPS < 70%. ',
                    1 => ' NPKDTPS < 60%. '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 23,
                'id_kriteria'          => 4,
                'elemen'               => ' Pengembangan kompetensi tenaga kependidikan  ',
                'poin'                 => ' 1.25 ',
                'indikator'            => '  Tenaga kependidikan mengikuti kegiatan pengembangan kompetensi (studi lanjut, sertiﬁkasi kompetensi dari BNSP atau lembaga sertiﬁkasi internasional, workshop/pelatihan minimal 16 jam yang relevan) yang mendukung pengembangan tenaga kependidikan dalam 3 tahun terakhir. ',
                'option_pilihan_ganda' => json_encode([
                    4 => ' NPKTENDIK ≥ 40%.  ',
                    3 => ' 25% ≤ NPKTENDIK< 40 %.  ',
                    2 => ' 10% ≤ NPKTENDIK < 25%.  ',
                    1 => ' NPKTENDIK < 10%.  '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 24,
                'id_kriteria'          => 4,
                'elemen'               => ' Evaluasi Dosen dan Tenaga Kependidikan dan Tindak Lanjut ',
                'poin'                 => ' 1.50 ',
                'indikator'            => ' UPPS melakukan evaluasi dan tindak lanjut terhadap dosen dan tendik, dengan ketentuan sebagai berikut. (a) Evaluasi (1) dilakukan terhadap elemen-elemen dosen dan tendik dengan cara mengidentiﬁkasi minimal kelebihan dan kelemahannya, (2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif, (3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai, (4) didokumenta- sikan secara lengkap dan sahih. (b) Tindak lanjut (1) didasarkan pada hasil evaluasi, (2) dirumuskan secara spesiﬁk, terukur, realistis, dan berbasis waktu, (3)  dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan, dan (4) didukung bukti pelaksanaan yang lengkap dan sahih.    ',
                'option_pilihan_ganda' => json_encode([
                    4 => ' a. UPPS melakukan evaluasi terhadap dosen dan tendik dengan memenuhi  4 aspek. b. UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap dosen dan tendik dengan memenuhi  4 aspek.  ',
                    3 => ' a. UPPS melakukan evaluasi terhadap dosen dan tendik dengan memenuhi  3 aspek. b. UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap dosen dan tendik dengan memenuhi  3 aspek.  ',
                    2 => ' a. UPPS melakukan evaluasi terhadap dosen dan tendik dengan memenuhi  2 aspek. b. UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap dosen dan tendik dengan memenuhi  2 aspek.  ',
                    1 => ' a. UPPS melakukan evaluasi terhadap dosen dan tendik dengan memenuhi  < 2 aspek. b. UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap dosen dan tendik dengan memenuhi  < 2 aspek.  '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 25,
                'id_kriteria'          => 5,
                'elemen'               => ' Perencanaan dan pengelolaan keuangan',
                'poin'                 => ' 1.00 ',
                'indikator'            => '  UPPS menjalankan prinsip keuangan yang tercermin dari aspek (a) perencanaan, (b) pelaksanaan, (c) evaluasi, (d) tindak lanjut, (e) berbasis sistem informasi    ',
                'option_pilihan_ganda' => json_encode([4 => ' UPPS menjalankan prinsip keuangan yang tercermin dari 5 aspek.   ', 3 => ' UPPS menjalankan prinsip keuangan yang tercermin dari 4aspek.   ', 2 => ' UPPS menjalankan prinsip keuangan yang tercermin dari 3 aspek.  ', 1 => ' UPPS menjalankan prinsip keuangan yang tercermin dari < 3 aspek.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 26,
                'id_kriteria'          => 5,
                'elemen'               => ' Penggunaan anggaran ',
                'poin'                 => ' 1.5 ',
                'indikator'            => '  PS mengelola angggaran operasional pendidikan, penelitian, dan PkM yang memadai dari UPPS.    ',
                'option_pilihan_ganda' => json_encode([4 => ' a. Biaya operasional pendidikan PS senilai ≥ 18 Juta/mahasiswa/ tahun. b. Dana penelitian PS senilai ≥ 10 juta/dosen/ tahun. c. Dana PkM PS senilai ≥ 5 juta/dosen/tahun ', 3 => ' a. Biaya operasional pendidikan PS senilai antara ≥ 10 sampai dengan < 18 Juta/mahasiswa/ tahun. b. Dana penelitian senilai antara ≥ 7 sampai dengan < 10 Juta/ dosen/tahun. c. Dana PkM PS senilai antara ≥ 3 sampai dengan < 5 Juta/ dosen/tahun.   ', 2 => ' a. Biaya operasional pendidikan PS senilai antara ≥ 5 sampai dengan < 10 Juta/mahasiswa/ tahun b. Dana penelitian PS senilai antara ≥ 4 sampai dengan < 7 Juta/ dosen/tahun c. Dana PkM PS senilai antara ≥ 1 sampai dengan < 3 Juta/ dosen/tahun. ', 1 => ' a. Biaya operasional pendidikan PS senilai < 5 Juta/mahasiswa/ tahun. b. Dana penelitian PS senilai < 4 juta/dosen/ tahun. c. Dana PkM PS senilai < 1 juta/dosen/ tahun.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 27,
                'id_kriteria'          => 5,
                'elemen'               => ' Ketersediaan dan aksesibilitas, dan kemanfaatan  sarana dan prasarana utama pendidikan',
                'poin'                 => ' 1.25 ',
                'indikator'            => ' PT/UPPS menyediakan   sarana dan prasarana utama untuk mendukung kegiatan akademik dan administrasi   yang memenuhi aspek (a) kelengkapan, (b) kualitas, (c) aksesibilitas, (d) keterawatan,  (e) kemutakhiran, dan (f) kemanfaatan. ',
                'option_pilihan_ganda' => json_encode([4 => ' PT/UPPS menyediakan   sarana dan prasarana yang mendukung kegiatan akademik dan administrasi yang memenuhi 6 aspek ', 3 => ' PT/UPPS menyediakan   sarana dan prasarana yang mendukung kegiatan akademik  dan administrasi yang memenuhi  5 aspek. ', 2 => ' PT/UPPS menyediakan   sarana dan prasarana yang mendukung kegiatan akademik   dan administrasi yang memenuhi  4 aspek. ', 1 => ' PT/UPPS menyediakan   sarana dan prasarana yang mendukung kegiatan akademik dan  administrasi yang memenuhi  < 4 aspek. ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 28,
                'id_kriteria'          => 5,
                'elemen'               => ' Ketersediaan dan aksesibilitas teknologi informasi  ',
                'poin'                 => ' 1.00 ',
                'indikator'            => ' PT/UPPS menyediakan infrastruktur dan teknologi informasi (TI) untuk mendukung kegiatan akademik dan administrasi yang memenuhi aspek (a) kelengkapan, (b) kualitas, (c) kemutakhiran, (d) keterintegrasian, (e) keterawatan,  dan (f) aksesibilitas.     ',
                'option_pilihan_ganda' => json_encode([4 => ' PT/UPPS menyediakan infrastruktur teknologi informasi (TI) untuk mendukung kegiatan akademik dan administrasi yang memenuhi 6 aspek.  ', 3 => ' PT/UPPS menyediakan infrastruktur teknologi informasi (TI) untuk mendukung kegiatan akademik dan administrasi yang memenuhi 5 aspek.  ', 2 => ' PT/UPPS menyediakan infrastruktur teknologi informasi (TI) untuk mendukung kegiatan akademik dan administrasi yang memenuhi 4 aspek.  ', 1 => ' PT/UPPS menyediakan infrastruktur teknologi informasi (TI) untuk mendukung kegiatan akademik dan administrasi yang memenuhi < 4 aspek.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 29,
                'id_kriteria'          => 5,
                'elemen'               => ' Keamanan, keselamatan, dan kesehatan lingkungan (K3L) ',
                'poin'                 => ' 1.0 ',
                'indikator'            => ' PT/UPPS menjamin pemenuhan standar K3L belajar/bekerja yang memenuhi aspek (a) ketersediaan kebijakan, (b) ketersediaan  sistem manajemen, (c) ketersediaan peralatan dan fasilitas pendukung, (d) pelaksanaan sosialisasi dan edukasi, dan (e) pelaksanaan penilaian dan audit K3L secara berkala.    ',
                'option_pilihan_ganda' => json_encode([4 => ' PT/UPPS menjamin pemenuhan standar K3L belajar/bekerja yang memenuhi 5 aspek.  ', 3 => ' PT/UPPS menjamin pemenuhan standar K3L belajar/bekerja yang memenuhi 4 aspek.  ', 2 => ' PT/UPPS menjamin pemenuhan standar K3L belajar/bekerja yang memenuhi 3 aspek.  ', 1 => ' PT/UPPS menjamin pemenuhan standar K3L belajar/bekerja yang memenuhi  < 3 aspek.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 30,
                'id_kriteria'          => 5,
                'elemen'               => ' Evaluasi Keuangan, Sarana, dan Prasarana Pendidikan dan Tindak Lanjut ',
                'poin'                 => ' 1.50 ',
                'indikator'            => ' PT/UPPS melakukan evaluasi dan tindak lanjut terhadap keuangan dan sarpras pendidikan dengan ketentuan sebagai berikut. (a) Evaluasi (1) dilakukan terhadap elemen-elemen keuangan dan sarpras pendidikan dengan cara mengidentiﬁkasi minimal kelebihan dan kelemahannya, (2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif, (3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai, (4) didokumenta- sikan secara lengkap dan sahih. (b) Tindak lanjut (1) didasarkan pada hasil evaluasi, (2) dirumuskan secara spesiﬁk, terukur, realistis, dan berbasis waktu,(3)  dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan, dan (4) didukung bukti pelaksanaan yang lengkap dan sahih.    ',
                'option_pilihan_ganda' => json_encode([4 => ' a. PT/UPPS melakukan evaluasi terhadap terhadap keuangan dan sarpras pendidikan dengan memenuhi  4 aspek. b. PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap keuangan dan sarpras pendidikan dengan memenuhi  4 aspek.  ', 3 => ' a. PT/UPPS melakukan evaluasi terhadap terhadap keuangan dan sarpras pendidikan dengan memenuhi  3 aspek. b. PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap keuangan dan sarpras pendidikan dengan memenuhi  3 aspek.  ', 2 => ' a. PT/UPPS melakukan evaluasi terhadap terhadap keuangan dan sarpras pendidikan dengan memenuhi  2 aspek. b. PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap keuangan dan sarpras pendidikan dengan memenuhi  2 aspek.  ', 1 => ' a. PT/UPPS melakukan evaluasi terhadap terhadap keuangan dan sarpras pendidikan dengan memenuhi < 2 aspek. b. PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap keuangan dan sarpras pendidikan dengan memenuhi < 2 aspek.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 31,
                'id_kriteria'          => 6,
                'elemen'               => ' Pengembangan kurikulum ',
                'poin'                 => ' 1.75 ',
                'indikator'            => ' UPPS/PS memiliki  kurikulum berbasis luaran (OBE) yang: (a) disusun secara sistematis dengan tahapan sbb: (1) evaluasi kurikulum berjalan, (2) penyusunan draf awal kurikulum, (3) ujicoba dan perbaikan, (4) pengesahan, (5) pelaksanaan, dan (6) evaluasi dan tindak lanjut., (b) melibatkan stakeholder internal (pimpinan UPPS/PS, dosen, mahasiswa, tenaga kependidikan) dan stakeholder eksternal (alumni, pengguna lulusan, asosiasi program studi/profesi, pakar) dalam proses penyusunan kurikulum., dan (c) memenuhi karakteristik kurukulum yang baik sbb: (1) lengkap, (2) sesuai dengan level KKNI, (3) koheren (ketepatan struktur kurikulum dalam pencapaian CPL), (4) mutakhir, (5) memperlihatkan ciri khusus PS, dan (6) memberi kesempatan mahasiswa belajar di luar program studi.   ',
                'option_pilihan_ganda' => json_encode([4 => ' a. UPPS/PS menyusun kurikulum berbasis luaran (OBE) yang memenuhi 6 tahapan. b. UPPS/PS melibatkan stakeholder semua internal dan eksternal. c. UPPS/PS memiliki 6 karakteristik kurikulum yang baik.  ', 3 => ' a. UPPS/PS menyusun kurikulum berbasis luaran (OBE) yang memenuhi 5 tahapan. b. UPPS/PS melibatkan semua stakeholder internal dan 13 stakeholder eksternal. c. UPPS/PS memiliki 5 karakteristik kurikulum yang baik.  ', 2 => ' a. UPPS/PS menyusun kurikulum berbasis luaran yang memenuhi 4 tahapan. b. UPPS/PS melibatkan semua stakeholder internal. c. UPPS/PS memiliki 4 karakteristik kurikulum yang baik.  ', 1 => ' a. UPPS/PS menyusun kurikulum berbasis luaran yang memenuhi < 4 tahapan. b. UPPS/PS melibatkan < 4 stakeholder internal. c. UPPS/PS memiliki  < 4 karakteristik kurikulum yang baik.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 32,
                'id_kriteria'          => 6,
                'elemen'               => ' Pelaksanaan pembelajaran ',
                'poin'                 => ' 1.75 ',
                'indikator'            => '  DTPS melaksanakan pembelajaran yang (a) sesuai dengan RPS yang telah disusun, (b) menggunakan metode mengajar yang berpusat pada mahasiswa, (c) merealisasikan CPL melalui sub-CPMK, (d) melaksanakan assessment for learning, (e) mengintegrasikan hasil penelitian/PkM, dan (f) memanfaatkan Teknologi Informasi yang relevan.    ',
                'option_pilihan_ganda' => json_encode([4 => ' DTPS melaksanakan pembelajaran yang memenuhi 6 aspek   ', 3 => ' DTPS melaksanakan pembelajaran yang memenuhi 5 aspek.  ', 2 => ' DTPS melaksanakan pembelajaran yang memenuhi 3 - 4 aspek  ', 1 => ' DTPS melaksanakan pembelajaran yang memenuhi  < 3 aspek   ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 34,
                'id_kriteria'          => 6,
                'elemen'               => ' Penilaian hasil belajar ',
                'poin'                 => ' 1.75 ',
                'indikator'            => ' DTPS melaksanakan penilaian hasil belajar yang (a) sesuai dengan tujuan khusus pembelajaran/Sub-CPMK, (b) menggunakan teknik penilaian yang bervariasi, (c) memiliki tingkat kesulitan yang proporsional, (d) memberikan umpan balik yang konstruktif, dan (e) memberi kesempatan kepada mahasiswa untuk melakukan banding terhadap hasil penilaian.    ',
                'option_pilihan_ganda' => json_encode([4 => ' DTPS melaksanakan penilaian hasil belajar yang memenuhi 5 aspek.  ', 3 => ' DTPS melaksanakan penilaian hasil belajar yang memenuhi 4 aspek.  ', 2 => ' DTPS melaksanakan penilaian hasil belajar yang memenuhi 3 aspek.  ', 1 => ' DTPS melaksanakan penilaian hasil belajar yang memenuhi  < 3 aspek.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 35,
                'id_kriteria'          => 6,
                'elemen'               => ' Perkuliahan micro-teaching atau ketrampilan sejenis ',
                'poin'                 => ' 1.75 ',
                'indikator'            => ' DTPS melaksanakan perkuliahan micro-teaching atau kegiatan lain yang sejenis bagi PS kependidikan nonmengajar, yang memenuhi asepaspek sebagai berikut: (a) Perkuliahan dilaksanakan di laboratorium microteaching atau yang sejenis untuk PS kependidikan non-mengajar; (b) Frekuensi pertemuan memungkinkan setiap mahasiswa berlatih secara memadai; (c) Micro-teaching melatihkan keterampilan dasar mengajar atau keterampilan sejenis untuk PS Kependidikan non-mengajar; (d) Mahasiswa menerima umpan balik yang konstruktif setelah berlatih mengajar; dan  (e) Dosen memberi kesempatan kepada mahasiswa untuk melakukan reﬂeksi. ',
                'option_pilihan_ganda' => json_encode([4 => ' DTPS  melaksanakan perkuliahan micro-teaching atau nama setara untuk PS kependidikan nonmengajar: a. di laboratorium microteaching atau yang sejenis untuk PS Kependidikan nonmengajar yang memiliki peralatan yang lengkap  dan terawat; b. dengan frekuensi praktik untuk masing-masing mahasiswa ≥ 5 kali selama periode semester praktek. c. melatihkan 8 keterampilan mengajar atau keterampilan sejenis untuk PS kependidikan nonmengajar. d. mahasiswa melakukan reﬂeksi diri atas kompetensi mengajar yang sudah dikuasai pada perkuliahan microteaching atau nama sejenis.  ', 3 => ' DTPS  melaksanakan perkuliahan micro-teaching atau nama setara untuk PS kependidikan non-mengajar: a. di laboratorium microteaching atau sejenis untuk PS Kependidikan non mengajar yang memiliki peralatan yang lengkap dan terawat; b. dengan frekuensi praktik untuk masing-masing mahasiswa 3- 4 kali praktik. c. melatihkan 8 keterampilan mengajar atau ketrampilan sejenis untuk PS kependidikan non mengajar; d. mahasiswa melakukan reﬂeksi diri atas kompetensi mengajar yang sudah  dikuasai pada perkuliahan microteaching atau nama sejenis. ', 2 => ' DTPS  melaksanakan perkuliahan micro-teaching atau nama setara untuk PS kependidikan non-mengajar: a. di laboratorium microteaching atau sejenis untuk PS non kependidikan yang memiliki peralatan yang lengkap; b. dengan frekuensi praktik untuk masing-masing mahasiswa 2 kali praktik. c. melatihkan 8 keterampilan mengajar atau ketrampilan sejenis untuk PS kependidikan non mengajar ', 1 => ' DTPS  melaksanakan perkuliahan micro-teaching atau nama setara untuk PS kependidikan nonmengajar: a. di ruang kelas; b. frekuensi praktek untuk masing-masing mahasiswa 1 kali praktik; c. melatihkan < 8 keterampilan mengajar atau ketrampilan sejenis untuk PS non Kependidikan;  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 36,
                'id_kriteria'          => 6,
                'elemen'               => ' Magang kependidikan ',
                'poin'                 => ' 1.75 ',
                'indikator'            => ' UPPS melaksanakan program magang kependidikan, yang tercermin dari adanya (a) kerja sama antara UPPS dengan lembaga mitra; (b) panduan pelaksanaan magang; (c) unit pelaksana magang; (d) laporan pelaksanaan magang; (e) laporan monitoring dan evaluasi pelaksanaan magang; dan (f) laporan tindak lanjut hasil monitoring dan evaluasi pelaksanaan magang.    ',
                'option_pilihan_ganda' => json_encode([4 => ' UPPS melaksanakan program magang kependidikan yang memenuhi 6 aspek dan pelaksanaan magang kependidikan selama 3-6 bulan.  ', 3 => ' UPPS melaksanakan program magang kependidikan yang memenuhi 5 aspek (aspek a – d harus terpenuhi) dan pelaksanaan magang kependidikan selama 2-3 bulan.  ', 2 => ' UPPS melaksanakan program magang kependidikan yang memenuhi 4 aspek (aspek a-d) dan pelaksanaan magang kependidikan selama < 2 bulan.  ', 1 => ' UPPS melaksanakan program magang kependidikan yang memenuhi  < 4 aspek dan pelaksanaan magang kependidikan selama < 1 bulan.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 37,
                'id_kriteria'          => 6,
                'elemen'               => ' Pembimbingan magang kependidikan ',
                'poin'                 => ' 1.60 ',
                'indikator'            => ' Dosen pembimbing dan guru pamong melaksanakan pembimbingan magang kependidikan secara intensif dan berkualitas yang tercermin dari: (a) kemudahan pembimbing untuk diakses oleh mahasiswa; (b) frekuensi pembimbingan yang memadai; (c) pemberian umpan balik yang konstrukstif; (d) pelaksanaan reﬂeksi setiap kali mahasiswa selesai praktik mengajar; dan (e) pendokumentasian kegiatan pembimbingan yang lengkap.    ',
                'option_pilihan_ganda' => json_encode([4 => ' Dosen pembimbing dan guru pamong  melaksanakan pembimbingan magang Kependidikan yang memenuhi 5 aspek dan jumlah pembimbingan ≥ 4 kali kunjungan (daring atau luring).  ', 3 => ' Dosen pembimbing dan guru pamong  melaksanakan pembimbingan magang Kependidikan yang memenuhi 4 aspek dan jumlah pembimbingan ≥ 3 kali kunjungan (daring atau luring).  ', 2 => ' Dosen pembimbing dan guru pamong  melaksanakan pembimbingan magang Kependidikan yang memenuhi 3 aspek dan jumlah pembimbingan sebanyak 2 kali kunjungan (daring atau luring).  ', 1 => ' Dosen pembimbing dan guru pamong  melaksanakan pembimbingan magang Kependidikan yang memenuhi  < 3 aspek dan jumlah pembimbingan sebanyak 1 kali kunjungan (daring atau luring).  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 38,
                'id_kriteria'          => 6,
                'elemen'               => ' Peningkatan suasana akademik ',
                'poin'                 => ' 1.50 ',
                'indikator'            => ' PS meningkatkan suasana akademik dengan cara menyelenggarakan kegiatan akademik di luar kelas yang: (a) beragam, (b) intensif dan berkelanjutan, (c) memiliki lingkup lokal, nasional, dan/atau internasional, (d) relevan dengan visi keilmuan PS, (e) didokumentasikan secara lengkap dan terstruktur.    ',
                'option_pilihan_ganda' => json_encode([4 => ' PS menyelenggarakan kegiatan di luar kelas untuk meningkatkan suasana akademik sebanyak minimal 4 kali setiap semester dengan memenuhi 5 aspek dalam 3 tahun terakhir.  ', 3 => ' PS menyelenggarakan kegiatan di luar kelas untuk meningkatkan suasana akademik sebanyak 2-3 kali setiap semester dengan memenuhi 4 aspek dalam 3 tahun terakhir.  ', 2 => ' PS menyelenggarakan kegiatan di luar kelas untuk meningkatkan suasana akademik sebanyak 1 kali setiap semester dengan memenuhi 3 aspek dalam 3 tahun terakhir.  ', 1 => ' PS menyelenggarakan kegiatan di luar kelas untuk meningkatkan suasana akademik sebanyak kurang dari 1 setiap semester dengan memenuhi  < 3 aspek dalam 3 tahun terakhir.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 39,
                'id_kriteria'          => 6,
                'elemen'               => ' Pembimbingan tugas akhir ',
                'poin'                 => ' 1.60 ',
                'indikator'            => ' Pembimbingan Tugas Akhir oleh DTPS memenuhi aspek: (a) Ketersediaan panduan dan sistem informasi tugas akhir, (c) Kecukupan jumlah pembimbing utama tugas akhir, (d) Frekuensi pembimbingan.    ',
                'option_pilihan_ganda' => json_encode([4 => ' Pembimbingan Tugas Akhir oleh DTPS memenuhi aspek: a. Tersedia panduan dan sistem informasi tugas akhir yang digunakan  dalam semua tahapan pembimbingan tugas akhir b. Jumlah bimbingan sebagai pembimbing utama tugas akhir tiap semester = 1:1-6 c. Frekuensi pembimbingan minimal 16 kali ', 3 => ' Pembimbingan Tugas Akhir oleh DTPS memenuhi aspek: a. Tersedia panduan dan sistem informasi tugas akhir yang digunakan dalam  sebagian pembimbingan tugas akhir b. Jumlah bimbingan sebagai pembimbing utama tugas akhir tiap semester = 1:7-12 c. Frekuensi pembimbingan = 14 - 15 kali ', 2 => ' Pembimbingan utama Tugas Akhir oleh DTPS memenuhi aspek: a. Tersedia panduan dan sistem informasi tugas akhir  b. Jumlah bimbingan sebagai pembimbing utama tugas akhir tiap semester = 1:1318 Frekuensi pembimbingan = 12 - 13 kali ', 1 => ' Pembimbingan utama Tugas Akhir oleh DTPS memenuhi aspek: a. Tersedia panduan tetapi tidak tersedia sistem informasi tugas akhir  b. Jumlah bimbingan sebagai pembimbing utama tugas akhir tiap semester = 1:> 18 c. Frekuensi pembimbingan < 12 kali ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 41,
                'id_kriteria'          => 6,
                'elemen'               => ' Tracer study ',
                'poin'                 => ' 1.75 ',
                'indikator'            => ' UPPS/PS melakukan tracer study yang mencakup 5 aspek, yaitu: (a) terkoordinasi ditingkat PT/ UPPS, (b) dilakukan secara regular setiap tahun dan terdokumentasi, (c) menggunakan instrumen yang mencakup seluruh inti pertanyaan tracer study Pendidikan tinggi, (d) ditargetkan pada seluruh lulusan TS-4 s.d TS-2, dan (e) hasilnya disosialisasikan dan digunakan untuk pengembangan kurikulum dan pembelajaran.    ',
                'option_pilihan_ganda' => json_encode([4 => ' UPPS/PS melaksanakan tracer study dengan memenuhi 5 aspek.  ', 3 => ' UPPS/PS melaksanakan tracer study dengan memenuhi 4 aspek. ', 2 => ' UPPS/PS melaksanakan tracer study dengan memenuhi 3 aspek.  ', 1 => ' UPPS/PS melaksanakan tracer study dengan memenuhi < 3 aspek atau tidak melakukan tracer study.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 49,
                'id_kriteria'          => 6,
                'elemen'               => ' Asesmen pencapaian CPL ',
                'poin'                 => ' 1.50 ',
                'indikator'            => ' PS melakukan asesmen pencapaian CPL berdasarkan capaian hasil belajar mahasiswa pada mata kuliah sebagai bagian dari OBE, mengevaluasi hasilnya, dan menindaklanjuti hasil evaluasi tersebut. ',
                'option_pilihan_ganda' => json_encode([4 => ' a. PS melakukan asesmen pencapaian CPL  pada mata kuliah penciri keilmuan PS minimal 25% yang didukung bukti sahih; b. PS melakukan evaluasi terhadap asesmen pencapaian CPL berdasarkan capaian hasil belajar mahasiswa, didukung bukti yang sahih; c. PS melakukan tindak lanjut hasil evaluasi terhadap asesmen pencapaian CPL berdasarkan capaian hasil belajar mahasiswa, didukung bukti yang sahih.  ', 3 => ' a. PS melakukan asesmen pencapaian CPL  pada mata kuliah penciri keilmuan PS minimal 25% yang didukung bukti sahih; b. PS melakukan evaluasi terhadap asesmen pencapaian CPL berdasarkan capaian hasil belajar mahasiswa, didukung bukti yang sahih; c. PS tidak melakukan tindak lanjut berdasarkan hasil evaluasi.  ', 2 => ' a. PS melakukan asesmen pencapaian CPL  pada mata kuliah penciri keilmuan PS minimal 20% yang didukung bukti sahih; b. PS tidak melakukan evaluasi terhadap asesmen pencapaian CPL berdasarkan capaian hasil belajar mahasiswa. ', 1 => ' PS tidak melakukan asesmen pencapaian CPL.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 50,
                'id_kriteria'          => 6,
                'elemen'               => ' Evaluasi kurikulum ',
                'poin'                 => ' 1.75 ',
                'indikator'            => ' UPPS/PS melakukan evaluasi kurikulum PS yang memenuhi aspekaspek sebagai berikut: (a) evaluasi mikro dilakukan paling lama 1 tahun sekali; (b) evaluasi makro dilakukan paling lama 5 tahun sekali; (c) evaluasi merujuk pada kebijakan pemerintah, visi keilmuan PS, perkembangan IPTEKS, tuntutan IDUKA, dan   kebutuhan Masyarakat; (d) evaluasi melibatkan stakeholder internal dan eksternal; (e) evaluasi didokumentasikan secara lengkap. ',
                'option_pilihan_ganda' => json_encode([4 => ' UPPS/PS melaksanakan evaluasi kurikulum dengan memenuhi 5 aspek.  ', 3 => ' UPPS/PS melaksanakan evaluasi kurikulum dengan memenuhi 4 aspek.  ', 2 => ' UPPS/PS melaksanakan evaluasi kurikulum dengan memenuhi 3 aspek.  ', 1 => ' UPPS/PS melaksanakan evaluasi kurikulum dengan memenuhi  < 3 aspek.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 51,
                'id_kriteria'          => 6,
                'elemen'               => ' Evaluasi Pendidikan dan Tindak Lanjut ',
                'poin'                 => ' 1.50 ',
                'indikator'            => ' UPPS/PS melakukan evaluasi dan tindak lanjut terhadap pendidikan, dengan ketentuan sebagai berikut. (a) Evaluasi (1) dilakukan terhadap elemen-elemen pendidikan dengan cara mengidentiﬁkasi minimal kelebihan dan kelemahannya, (2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif, (3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai, (4) didokumenta- sikan secara lengkap dan sahih. (b) Tindak lanjut (1) didasarkan pada hasil evaluasi, (2) dirumuskan secara spesiﬁk, terukur, realistis, dan berbasis waktu, (3)  dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan, dan (4) didukung bukti pelaksanaan yang lengkap dan sahih.   ',
                'option_pilihan_ganda' => json_encode([4 => ' a. UPPS/PS melakukan evaluasi terhadap terhadap pendidikan dengan memenuhi  4 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap pendidikan dengan memenuhi  4 aspek.  ', 3 => ' a. UPPS/PS melakukan evaluasi terhadap terhadap pendidikan dengan memenuhi  3 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap pendidikan dengan memenuhi  3 aspek.  ', 2 => ' a. UPPS/PS melakukan evaluasi terhadap terhadap pendidikan dengan memenuhi  2 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap pendidikan dengan memenuhi  2 aspek.  ', 1 => ' a. UPPS/PS melakukan evaluasi terhadap terhadap pendidikan dengan memenuhi  < 2 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap pendidikan dengan memenuhi  < 2 aspek.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 52,
                'id_kriteria'          => 7,
                'elemen'               => ' Peta Jalan penelitian ',
                'poin'                 => ' 1.00 ',
                'indikator'            => ' PS memiliki peta jalan penelitian yang a) mendukung pencapaian visi keilmuan PS, (b) relevan dengan bidang keilmuan PS, (c) terintegrasi dengan kegiatan tridharma PT, (d) memiliki fokus dan tahapan yang jelas, e) didukung oleh SDM yang kompeten dalam keilmuan.    ',
                'option_pilihan_ganda' => json_encode([4 => ' PS memiliki peta jalan penelitian yang memenuhi 5 aspek.   ', 3 => ' PS memiliki peta jalan penelitian yang memenuhi 4 aspek.   ', 2 => ' PS memiliki peta jalan penelitian yang memenuhi 3 aspek.   ', 1 => ' PS memiliki peta jalan  penelitian yang memenuhi  < 3 aspek.   ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 56,
                'id_kriteria'          => 7,
                'elemen'               => ' Jumlah DTPS yang melakukan publikasi karya ilmiah ',
                'poin'                 => ' 2.00 ',
                'indikator'            => ' Dalam tiga tahun terakhir, DTPS memiliki publikasi di jurnal nasional terakreditasi minimal Sinta 2 dan/atau jurnal internasional bereputasi sebagai penulis pertama atau corresponding author. PPDTPS = Persentase jumlah DTPS memiliki publikasi pada jurnal nasional terakreditasi minimal Sinta 2 dan/atau internasional bereputasi (terindeks scopus atau WoS) sebagai penulis pertama atau corresponding authors dalam 3 tahun terakhir. ',
                'option_pilihan_ganda' => json_encode([4 => ' PPDTPS ≥ 20%  ', 3 => ' 15% ≤ PPDTPS < 20% ', 2 => ' 10% ≤ PPDTPS <15% ', 1 => ' PPDTPS  <10%. ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 58,
                'id_kriteria'          => 7,
                'elemen'               => ' Evaluasi Penelitian dan Tindak Lanjut ',
                'poin'                 => ' 1.50 ',
                'indikator'            => ' UPPS/PS melakukan evaluasi dan tindak lanjut terhadap penelitian, dengan ketentuan sebagai berikut. (a) Evaluasi (1) dilakukan terhadap elemen-elemen penelitian dengan cara mengidentiﬁkasi minimal kelebihan dan kelemahannya, (2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif, (3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai, (4) didokumenta- sikan secara lengkap dan sahih. (b) Tindak lanjut (1) didasarkan pada hasil evaluasi, (2) dirumuskan secara spesiﬁk, terukur, realistis, dan berbasis waktu, (3)  dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan, dan (4) didukung bukti pelaksanaan yang lengkap dan sahih.    ',
                'option_pilihan_ganda' => json_encode([4 => ' a. UPPS/PS melakukan evaluasi terhadap terhadap penelitian dengan memenuhi  4 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap penelitian dengan memenuhi  4 aspek.  ', 3 => ' a. UPPS/PS melakukan evaluasi terhadap terhadap penelitian dengan memenuhi  3 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap penelitian dengan memenuhi  3 aspek.  ', 2 => ' a. UPPS/PS melakukan evaluasi terhadap terhadap penelitian dengan memenuhi  2 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap penelitian dengan memenuhi  2 aspek.  ', 1 => ' a. UPPS/PS melakukan evaluasi terhadap terhadap penelitian dengan memenuhi  < 2 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap penelitian dengan memenuhi  < 2 aspek.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 61,
                'id_kriteria'          => 8,
                'elemen'               => ' Evaluasi Pengabdian kepada Masyarakat  dan Tindak Lanjut ',
                'poin'                 => ' 1.50 ',
                'indikator'            => ' UPPS/PS melakukan evaluasi dan tindak lanjut terhadap PkM, dengan ketentuan sebagai berikut. (a) Evaluasi (1) dilakukan terhadap elemenelemen PkM dengan cara mengidentiﬁkasi minimal kelebihan dan kelemahannya, (2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif, (3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai, (4) didokumenta- sikan secara lengkap dan sahih. (b) Tindak lanjut (1) didasarkan pada hasil evaluasi, (2) dirumuskan secara spesiﬁk, terukur, realistis, dan berbasis waktu, (3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan, dan (4) didukung bukti pelaksanaan yang lengkap dan sahih. ',
                'option_pilihan_ganda' => json_encode([4 => ' a. UPPS/PS melakukan evaluasi terhadap terhadap PkM dengan memenuhi  4 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap PkM dengan memenuhi  4 aspek.  ', 3 => ' a. UPPS/PS melakukan evaluasi terhadap terhadap PkM dengan memenuhi  3 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap PkM dengan memenuhi  3 aspek.  ', 2 => ' a. UPPS/PS melakukan evaluasi terhadap terhadap PkM dengan memenuhi  2 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap PkM dengan memenuhi  2 aspek.  ', 1 => ' a. UPPS/PS melakukan evaluasi terhadap terhadap PkM dengan memenuhi < 2 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap PkM dengan memenuhi  < 2 aspek.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 62,
                'id_kriteria'          => 9,
                'elemen'               => ' Terbentuknya unsur pelaksana penjaminan mutu ',
                'poin'                 => ' 1.25',
                'indikator'            => '   UPPS memiliki unsur pelaksana penjaminan mutu di UPPS yang tercermin dari  aspek (a) surat keputusan pembentukan unit penjaminan mutu,  (b) struktur organisasi penjaminan mutu, (c) deskripsi kerja personil yang ada dalam struktur organisasi, dan (d) personil yang kompeten dalam bidang penjaminan mutu.    ',
                'option_pilihan_ganda' => json_encode([4 => ' UPPS memiliki unsur pelaksana penjaminan mutu di UPPS yang tercermin dari  terpenuhinya 4 aspek. ', 3 => ' UPPS memiliki unsur pelaksana penjaminan mutu di UPPS yang tercermin dari  terpenuhinya 3 aspek.  ', 2 => ' UPPS memiliki unsur pelaksana penjaminan mutu di UPPS yang tercermin dari  terpenuhinya 2 aspek.  ', 1 => ' UPPS memiliki unsur pelaksana penjaminan mutu di UPPS yang tercermin dari  terpenuhinya hanya  < 2 aspek.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 63,
                'id_kriteria'          => 9,
                'elemen'               => ' Ketersediaan perangkat penjaminan mutu ',
                'poin'                 => ' 1.25 ',
                'indikator'            => ' PT/UPPS  menetapkan perangkat SPMI yang minimal mencakup: (a) kebijakan SPMI; (b) pedoman penerapan siklus PPEPP standar pendidikan tinggi dalam SPMI; (c) standar dan/atau  kriteria penyelenggaraan pendidikan dan pengelolaan perguruan tinggi; dan (d)  tata cara pendokumentasian implementasi SPMI ',
                'option_pilihan_ganda' => json_encode([4 => ' PT/UPPS menetapkan 4 perangkat SPMI. ', 3 => ' PT/UPPS menetapkan 3 perangkat SPMI. ', 2 => ' PT/UPPS menetapkan 2 perangkat SPMI. ', 1 => ' PT/UPPS menetapkan < 2 perangkat SPMI.  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 64,
                'id_kriteria'          => 9,
                'elemen'               => ' Pelaksanaan penjaminan mutu dengan siklus PPEPP ',
                'poin'                 => ' 2.50 ',
                'indikator'            => ' UPPS memiliki dan melaksanakan Sistem Penjaminan Mutu Internal (SPMI) dengan mengikuti siklus Penetapan, Pelaksanaan, Evaluasi, Pengendalian, dan Peningkatan (PPEPP).  ',
                'option_pilihan_ganda' => json_encode([4 => ' Keterlaksanaan SPMI meliputi: a. Memiliki kebijakan penjaminan mutu. b. Memiliki perangkat SPMI lengkap. c. Melaksanakan standar SPMI d. Mengevaluasi pemenuhan standar SPMI secara berkala. e. Mengendalikan pelaksanaan standar SPMI. f. Meningkatkan pencapaian standar SPMI. ', 3 => ' Keterlaksanaan SPMI meliputi: a. Memiliki kebijakan penjaminan mutu. b. Memiliki perangkat SPMI lengkap. c. Melaksanakan standar SPMI d. Mengevaluasi pemenuhan standar SPMI secara berkala. e. Mengendalikan pelaksanaan standar SPMI.  ', 2 => ' Keterlaksanaan SPMI meliputi: a. Memiliki kebijakan penjaminan mutu. b. Memiliki perangkat SPMI lengkap. c. Melaksanakan standar SPMI d. Mengevaluasi pemenuhan standar SPMI secara berkala.  ', 1 => ' Keterlaksanaan SPMI meliputi: a. Memiliki kebijakan penjaminan mutu. b. Memiliki perangkat SPMI lengkap. c. Melaksanakan standar SPMI  ']),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 65,
                'id_kriteria'          => 9,
                'elemen'               => ' Evaluasi Penjaminan Mutu dan Tindak Lanjut ',
                'poin'                 => ' 1.50 ',
                'indikator'            => ' PT/UPPS melakukan evaluasi dan tindak lanjut terhadap penjaminan mutu, dengan ketentuan sebagai berikut. (a) Evaluasi (1) dilakukan terhadap elemenelemen penjaminan mutu dengan cara mengidentiﬁkasi minimal kelebihan dan kelemahannya, (2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif, (3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai, (4) didokumenta- sikan secara lengkap dan sahih. (b) Tindak lanjut (1) didasarkan pada hasil evaluasi, (2) dirumuskan secara spesiﬁk, terukur, realistis, dan berbasis waktu, (3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan, dan (4) didukung bukti pelaksanaan yang lengkap dan sahih. ',
                'option_pilihan_ganda' => json_encode([4 => ' a. PT/UPPS melakukan evaluasi terhadap terhadap penjaminan mutu dengan memenuhi  4 aspek. b. PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap penjaminan mutu dengan memenuhi  4 aspek.  ', 3 => ' a. PT/UPPS melakukan evaluasi terhadap terhadap penjaminan mutu dengan memenuhi  3 aspek. b. PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap penjaminan mutu dengan memenuhi  3 aspek.  ', 2 => ' a. PT/UPPS melakukan evaluasi terhadap terhadap penjaminan mutu dengan memenuhi  2 aspek. b. PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap penjaminan mutu dengan memenuhi  2 aspek.  ', 1 => ' c. PT/UPPS melakukan evaluasi terhadap terhadap penjaminan mutu dengan memenuhi < 2 aspek. d. PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap penjaminan mutu dengan memenuhi  < 2 aspek.  ']),
                'jenis'                => 'pilihan_ganda',
            ],

        ];

        DB::table('matriks_lembar_evaluasi_diri')->insertOrIgnore($data);

    }
}
