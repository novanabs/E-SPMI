<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LEDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Update data LAMDIK 3.0 (Kamis, 7 Mei 2026)
     */
    public function run(): void
    {
        $data = [
            [
                'nomor'                => 1,
                'id_kriteria'          => 1,
                'elemen'               => 'Ketepatan Rumusan Visi Keilmuan PS',
                'poin'                 => '1',
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
                'poin'                 => '1.25',
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
                'elemen'               => 'Peran Visi Keilmuan dalam Pelaksanaan Tridharma PT ',
                'poin'                 => '1.50',
                'indikator'            =>
                    'Visi keilmuan PS menjadi rujukan (a) pengembangan kurikulum; (b) pelaksanaan pembelajaran; (c) pelaksanaan penelitian, dan (d) pelaksanaan PkM.',
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
                'elemen'               => 'Evaluasi dan Refleksi terhadap Kriteria Visi Keilmuan PS dan Tindak Lanjut',
                'poin'                 => '1.50',
                'indikator'            =>
                    'PS melakukan evaluasi dan refleksi terhadap kriteria visi keilmuan serta tindak lanjut, dengan ketentuan sebagai berikut. (a) Evaluasi dan Refleksi (1) dilakukan terhadap elemen-elemen visi keilmuan dengan cara mengidentifikasi minimal kelebihan dan kelemahannya, (2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif, (3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai, (4) didokumentasikan secara lengkap dan sahih. (b) Tindak lanjut (1) didasarkan pada hasil evaluasi, (2) dirumuskan secara spesifik, terukur, realistis, dan berbasis waktu, (3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan, (4) didukung bukti pelaksanaan yang lengkap dan sahih, dan (5) digunakan sebagai dasar pengembangan program berkelanjutan.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a. PS melakukan evaluasi dan refleksi terhadap visi keilmuannya dengan memenuhi 4 aspek. b. PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap visi keilmuannya dengan memenuhi 5 aspek.',
                    3 => 'a. PS melakukan evaluasi dan refleksi terhadap visi keilmuannya dengan memenuhi 3 aspek. b. PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap visi keilmuannya dengan memenuhi 4 aspek.',
                    2 => 'a. PS melakukan evaluasi dan refleksi terhadap visi keilmuannya dengan memenuhi 2 aspek. b. PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap visi keilmuannya dengan memenuhi 3 aspek.',
                    1 => 'a. PS melakukan evaluasi dan refleksi terhadap visi keilmuannya dengan memenuhi < 2 aspek. b. PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap visi keilmuannya dengan memenuhi < 3 aspek.'
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
                'indikator'            => 'UPPS menjalankan proses tata kelola secara efektif yang mencakup aspek (a) perencanaan, (b) pengorganisasian, (c) penempatan personel, (d) pelaksanaan, (e) pengendalian dan pengawasan, dan (f) pelaporan yang menjadi dasar tindak lanjut.',
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
                'elemen'               => 'Evaluasi dan Refleksi terhadap Kriteria Tata Pamong dan Tata Kelola UPPS dan Tindak Lanjut ',
                'poin'                 => '1.50',
                'indikator'            => 'UPPS melakukan evaluasi dan refleksi terhadap kriteria Tata Pamong dan Tata Kelola serta tindak lanjut, dengan ketentuan sebagai berikut; (a) Evaluasi (1) dilakukan terhadap elemen-elemen tata kelola dengan cara mengidentifikasi minimal kelebihan dan kelemahannya, (2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif, (3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai, (4) didokumentasikan secara lengkap dan sahih;(b) Tindak lanjut (1) didasarkan pada hasil evaluasi, (2) dirumuskan secara spesifik, terukur, realistis, dan berbasis waktu, (3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan, (4) didukung bukti pelaksanaan yang lengkap dan sahih, dan (5) digunakan sebagai dasar pengembangan program berkelanjutan.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a. UPPS melakukan evaluasi terhadap tata kelola dengan memenuhi  4 aspek. b. UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap tata kelola dengan memenuhi  5 aspek.',
                    3 => 'a. UPPS melakukan evaluasi terhadap tata kelola dengan memenuhi  3 aspek. b. UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap tata kelola dengan memenuhi  4 aspek. ',
                    2 => 'a. UPPS melakukan evaluasi terhadap tata kelola dengan memenuhi  2 aspek. b. UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap tata kelola dengan memenuhi  aspek 3 aspek. ',
                    1 => 'a. UPPS melakukan evaluasi terhadap tata kelola dengan memenuhi  < 2 aspek. b. UPPS melakukan tindak lanjut berdasarkan hasil evaluasi terhadap tata kelola dengan memenuhi  < 3 aspek'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 9,
                'id_kriteria'          => 3,
                'elemen'               => 'Pelaksanaan Penerimaan Mahasiswa Baru',
                'poin'                 => '1.25',
                'indikator'            => 'PT/UPPS melaksanakan seleksi calon mahasiswa baru yang mencerminkan prinsip (1) kualitas, (2) keadilan, (3) inklusivitas, (4) transparansi, (5) akuntabilitas, dan (6) fleksibilitas.',
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
                'elemen'               => 'Kualitas Input Mahasiswa',
                'poin'                 => '1.25',
                'indikator'            => <<<TEXT
(a) PS memperoleh mahasiswa baru dengan kualitas input yang baik, memenuhi aspek: (1) kriteria seleksi tinggi, (2) mekanisme seleksi ketat, (3) rasio pendaftar:diterima min 1:1, dan (4) jumlah pendaftar memenuhi daya tampung dalam 5 tahun terakhir.

(b) PS melakukan analisis terhadap: (1) rasio pendaftar:diterima, (2) jumlah pendaftar vs daya tampung, (3) kualitas input berdasarkan mekanisme dan hasil seleksi.

Skor Akhir = (3 x Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    [
                        'label'   => 'Skor (a) — Kualitas Input',
                        'options' => [
                            4 => 'Memenuhi 4 aspek; rasio pendaftar:lulus seleksi ≥ 4:1',
                            3 => 'Memenuhi 3 aspek; rasio ≥ 3:1',
                            2 => 'Memenuhi 2 aspek; rasio ≥ 2:1',
                            1 => 'Memenuhi <2 aspek; rasio 1:1 atau tidak memenuhi daya tampung',
                        ],
                    ],
                    [
                        'label'   => 'Skor (b) — Analisis',
                        'options' => [
                            4 => 'Analisis 3 aspek',
                            3 => 'Analisis 2 aspek',
                            2 => 'Analisis 1 aspek',
                            1 => 'Tidak ada analisis',
                        ],
                    ],
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 11,
                'id_kriteria'          => 3,
                'elemen'               => 'Rasio Jumlah Dosen terhadap Jumlah Mahasiswa',
                'poin'                 => '1.25',
                'indikator'            => <<<TEXT
(a) Rasio jumlah DTPS terhadap jumlah mahasiswa memungkinkan mahasiswa berinteraksi dan memperoleh bimbingan dosen dengan baik. RMD = NM / NDTPS

(b) PS melakukan analisis ketercapaian rasio dosen terhadap mahasiswa meliputi: (1) mutu pembelajaran, (2) efektivitas penelitian mahasiswa, (3) pencapaian profil lulusan.

Skor Akhir = (3 x Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    [
                        'label'   => 'Skor (a) — Rasio Dosen:Mahasiswa',
                        'options' => [
                            4 => 'RMD dalam rentang ideal (Sains: 15-25, Sosial: 25-35)',
                            3 => 'RMD mendekati rentang ideal',
                            2 => 'RMD cukup jauh dari rentang ideal',
                            1 => 'RMD sangat jauh dari rentang ideal',
                        ],
                    ],
                    [
                        'label'   => 'Skor (b) — Analisis',
                        'options' => [
                            4 => 'Analisis 3 aspek',
                            3 => 'Analisis 2 aspek',
                            2 => 'Analisis 1 aspek',
                            1 => 'Tidak ada analisis',
                        ],
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — RASIO DOSEN:MAHASISWA ━━━
RMD = NM / NDTPS

── Kelompok Sains Teknologi ──
15 ≤ RMD ≤ 25 → Skor = 4
RMD < 15 → Skor = (4 × RMD) / 15
25 < RMD ≤ 35 → Skor = (70 − 2×RMD) / 5
RMD > 35 → Skor = 1

── Kelompok Sosial Humaniora ──
25 ≤ RMD ≤ 35 → Skor = 4
RMD < 25 → Skor = (4 × RMD) / 25
35 < RMD ≤ 50 → Skor = (200 − 4×RMD) / 15
RMD > 50 → Skor = 1

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis 3 aspek
3 = Analisis 2 aspek
2 = Analisis 1 aspek
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 12,
                'id_kriteria'          => 3,
                'elemen'               => 'Ketersediaan, Aksesibilitas, dan Kualitas Layanan Mahasiswa',
                'poin'                 => '1.25',
                'indikator'            => 'PT/UPPS (a) menyediakan layanan mahasiswa yang mencakup: (1) administrasi akademik, (2) bimbingan konseling, (3) Kesehatan, (4) keperluan dasar untuk mahasiswa berkebutuhan khusus, (5) beasiswa, (6) layanan Teknologi Informasi (TI), dan (7) bimbingan penulisan dan publikasi artikel; (b) Layanan tersebut dapat diakses oleh mahasiswa; (c) Layanan tersebut memiliki kualitas yang baik. ',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PT/UPPS menyediakan semua jenis layanan  mahasiswa, dengan kualitas yang baik dan dapat diakses oleh semua mahasiswa.',
                    3 => 'PT/UPPS menyediakan 4 jenis layanan mahasiswa (1 s.d 4) dan 1-2 jenis layanan lainnya, dengan kualitas yang baik dan dapat diakses oleh semua mahasiswa. ',
                    2 => 'PT/UPPS menyediakan 4 jenis layanan mahasiswa (1 s.d. 4) dengan kualitas yang baik dan dapat diakses oleh semua mahasiswa. ',
                    1 => 'PT/UPPS menyediakan < 4 jenis layanan mahasiswa. '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 13,
                'id_kriteria'          => 3,
                'elemen'               => 'Perlindungan Mahasiswa',
                'poin'                 => '1.50',
                'indikator'            => 'PT/UPPS/PS menyediakan layanan perlindungan kepada mahasiswa dari perundungan, pelecehan seksual, dan intoleransi yang meliputi aspek-aspek berikut: (a) Ketersediaan unit /organ/satuan tugas pelaksana, (b) Ketersediaan panduan, (c) Kegiatan sosialisasi dan pelatihan di PS, dan (d) Ketersediaan bukti pelaksanaan di tingkat PS',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PT/UPPS/PS menyediakan layanan perlindungan terhadap perundungan, pelecehan seksual, dan intoleransi yang mencakup 4 aspek. ',
                    3 => 'PT/UPPS/PS menyediakan layanan perlindungan terhadap perundungan, pelecehan seksual, dan intoleransi yang mencakup 3 aspek. ',
                    2 => 'PT/UPPS/PS menyediakan layanan perlindungan terhadap perundungan, pelecehan seksual, dan intoleransi yang mencakup 2 aspek.  ',
                    1 => 'PT/UPPS/PS menyediakan layanan perlindungan terhadap perundungan, pelecehan seksual, dan intoleransi hanya  1 aspek atau tidak memiliki.  '
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 14,
                'id_kriteria'          => 3,
                'elemen'               => 'Prestasi Akademik dan Non-Akademik Mahasiswa',
                'poin'                 => '2.00',
                'indikator'            => <<<TEXT
(a) Mahasiswa memiliki prestasi akademik dan non-akademik dalam 3 tahun terakhir. RI = NI/NM | RN = NN/NM | RW = NW/NM

(b) PS melakukan analisis kontribusi prestasi mahasiswa terhadap: (1) peningkatan reputasi akademik PS, (2) penguatan jejaring eksternal, (3) pembentukan profil lulusan unggul dan berdaya saing global.

Skor Akhir = (3 x Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    [
                        'label'   => 'Skor (a) — Prestasi Mahasiswa',
                        'options' => [
                            4 => 'RI ≥ 0.5%',
                            3 => 'RI < 0.5% dan RN ≥ 5%, atau kombinasi RI dan RN',
                            2 => 'RI=0, RN=0, RW ≥ 10%',
                            1 => 'RI=0, RN=0, RW < 10%',
                        ],
                    ],
                    [
                        'label'   => 'Skor (b) — Analisis',
                        'options' => [
                            4 => 'Analisis 3 aspek',
                            3 => 'Analisis 2 aspek',
                            2 => 'Analisis 1 aspek',
                            1 => 'Tidak ada analisis',
                        ],
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — PRESTASI MAHASISWA ━━━
RI = NI/NM | RN = NN/NM | RW = NW/NM
Faktor: a = 0.5%, b = 5%, c = 10%

RI ≥ a (0.5%) → Skor = 4
RI < a dan RN ≥ b (5%) → Skor = 3 + (RI / a)
0 < RI < a dan 0 < RN < b → Skor = 2 + (RI/a) + (RN/b) − (RI×RN)/(a×b)
RI = 0, RN = 0, RW ≥ c (10%) → Skor = 2
RI = 0, RN = 0, RW < c → Skor = 1

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis 3 aspek
3 = Analisis 2 aspek
2 = Analisis 1 aspek
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 15,
                'id_kriteria'          => 3,
                'elemen'               => 'Produktivitas Karya Inovatif dan/atau Publikasi Ilmiah Mahasiswa',
                'poin'                 => '2.50',
                'indikator'            => <<<TEXT
(a) Dalam 5 tahun terakhir, mahasiswa menghasilkan karya inovatif, publikasi ilmiah sesuai bidang PS, dan/atau karya seni yang dipamerkan/dipagelarkan.

(b) PS melakukan analisis kontribusi produktivitas karya inovatif/publikasi ilmiah terhadap: (1) penguatan budaya akademik, (2) peningkatan daya saing lulusan, (3) reputasi PS nasional/internasional.

Skor Akhir = (3 x Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    [
                        'label'   => 'Skor (a) — Karya Inovatif/Publikasi',
                        'options' => [
                            4 => '≥ 20% mahasiswa memiliki karya inovatif/publikasi',
                            3 => '≥ 15% mahasiswa',
                            2 => '≥ 10% mahasiswa',
                            1 => '< 10% mahasiswa',
                        ],
                    ],
                    [
                        'label'   => 'Skor (b) — Analisis',
                        'options' => [
                            4 => 'Analisis 3 aspek',
                            3 => 'Analisis 2 aspek',
                            2 => 'Analisis 1 aspek',
                            1 => 'Tidak ada analisis',
                        ],
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — KARYA INOVATIF/PUBLIKASI ━━━
PKIM = Persentase mahasiswa memiliki karya inovatif/publikasi ilmiah

PKIM ≥ 20% → Skor = 4
15% ≤ PKIM < 20% → Skor = 3
10% ≤ PKIM < 15% → Skor = 2
PKIM < 10% → Skor = 1

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis 3 aspek
3 = Analisis 2 aspek
2 = Analisis 1 aspek
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 16,
                'id_kriteria'          => 3,
                'elemen'               => 'Kepuasan Mahasiswa',
                'poin'                 => '1.50',
                'indikator'            => <<<TEXT
(a) UPPS/PS melakukan pengukuran kepuasan mahasiswa terhadap performa mengajar dosen, layanan administrasi akademik, dan fasilitas pendidikan, memenuhi 6 aspek: (1) instrumen valid, (2) dilaksanakan tiap akhir semester, (3) dianalisis tepat, (4) ada review hasil, (5) ditindaklanjuti, (6) hasilnya dipublikasikan.

(b) Tingkat kepuasan mahasiswa hasil pengukuran. TKM = Σ TKM_i / 5

Skor Akhir = (Skor(a) + 3 × Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    [
                        'label'   => 'Skor (a) — Aspek Pengukuran',
                        'options' => [
                            4 => 'Memenuhi 6 aspek',
                            3 => 'Memenuhi 5 aspek',
                            2 => 'Memenuhi 4 aspek',
                            1 => 'Memenuhi < 4 aspek',
                        ],
                    ],
                    [
                        'label'   => 'Skor (b) — TKM',
                        'options' => [
                            4 => 'TKM ≥ 75%',
                            3 => '50% ≤ TKM < 75%',
                            2 => '25% ≤ TKM < 50%',
                            1 => 'TKM < 25%',
                        ],
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — ASPEK PENGUKURAN ━━━
6 aspek → Skor = 4
5 aspek → Skor = 3
4 aspek → Skor = 2
< 4 aspek → Skor = 1

━━━ SKOR (b) — TKM ━━━
TKM = ΣTKM_i / 5
TKM ≥ 75% → Skor = 4
50% ≤ TKM < 75% → Skor = 3
25% ≤ TKM < 50% → Skor = 2
TKM < 25% → Skor = 1

━━━ SKOR AKHIR ━━━
Skor Akhir = (Skor(a) + 3 × Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 17,
                'id_kriteria'          => 3,
                'elemen'               => 'Evaluasi dan Refleksi terhadap Kriteria Mahasiswa dan Tindak Lanjut ',
                'poin'                 => ' 1.50 ',
                'indikator'            => 'UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria mahasiswa serta tindak lanjut, dengan ketentuan sebagai berikut. (a) Evaluasi dan refleksi (1) dilakukan terhadap elemenelemen pada kriteria mahasiswa dengan cara mengidentifikasi minimal kelebihan dan kelemahannya, (2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif, (3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai, (4) didokumentasikan secara lengkap dan sahih. (b) Tindak lanjut (1) didasarkan pada hasil evaluasi, (2) dirumuskan secara spesifik, terukur, realistis, dan berbasis waktu, (3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan, (4) didukung bukti pelaksanaan yang lengkap dan sahih, dan (5) digunakan sebagai dasar pengembangan program berkelanjutan. ',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a. UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria mahasiswa dengan memenuhi 4 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria mahasiswa dengan memenuhi 5 aspek.',
                    3 => 'a. UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria mahasiswa dengan memenuhi 3 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria mahasiswa dengan memenuhi 4 aspek.',
                    2 => 'a. UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria mahasiswa dengan memenuhi 2 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria mahasiswa dengan memenuhi 3 aspek.',
                    1 => 'a. UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria mahasiswa dengan memenuhi < 2 aspek. b. UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria mahasiswa dengan memenuhi < 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 18,
                'id_kriteria'          => 4,
                'elemen'               => 'Pelaksanaan Seleksi Dosen dan Tenaga Kependidikan',
                'poin'                 => '1.25',
                'indikator'            => 'PT/UPPS/PS melaksanakan seleksi calon dosen dan tenaga kependidikan yang memenuhi aspek-aspek sbb:(a) melakukan analisis kebutuhan,(b) pengumuman yang transparan,(c) seleksi berbasisi kompetensi,(d) metode seleksi yang beragam,(e) pengumuman hasil,dan (f) memberi kesempatan banding.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PT/UPPS melaksanakan seleksi calon dosen dan tenaga kependidikan yang yang meliputi 6 aspek.',
                    3 => 'PT/UPPS melaksanakan seleksi calon dosen dan tenaga kependidikan yang yang meliputi 5 aspek.',
                    2 => 'PT/UPPS melaksanakan seleksi calon dosen dan tenaga kependidikan yang yang meliputi 4 aspek.',
                    1 => 'PT/UPPS melaksanakan seleksi calon dosen dan tenaga kependidikan yang yang meliputi < 4 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 19,
                'id_kriteria'          => 4,
                'elemen'               => 'Kualifikasi Akademik dan Jabatan Akademik DTPS',
                'poin'                 => '1.50',
                'indikator'            => <<<TEXT
(a) Kualifikasi akademik DTPS. PDS3 = (NDS3 / NDTPS) × 100%

(b) Jabatan akademik DTPS. PGBLKL = ((NDGB + NDLK + NDL) / NDTPS) × 100%

(c) PS melakukan analisis terhadap keterpenuhan kualifikasi akademik, ketercapaian jabatan akademik, dan dampaknya.

Skor Akhir = (3 × (Skor(a) + Skor(b)) + Skor(c)) / 7
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (c) — Analisis',
                    'options' => [
                        4 => 'Analisis kualifikasi + jabatan + dampak',
                        3 => 'Analisis kualifikasi + jabatan',
                        2 => 'Analisis salah satu (kualifikasi atau jabatan)',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — KUALIFIKASI AKADEMIK ━━━
PDS3 = (NDS3 / NDTPS) × 100%
PDS3 ≥ 40% → Skor(a) = 4
PDS3 < 40% → Skor(a) = 2 + (5 × PDS3)

━━━ SKOR (b) — JABATAN AKADEMIK ━━━
PGBLKL = ((NDGB + NDLK + NDL) / NDTPS) × 100%
PGBLKL ≥ 70% → Skor(b) = 4
PGBLKL < 70% → Skor(b) = 2 + (20 × PGBLKL / 7)

━━━ SKOR (c) — ANALISIS ━━━
4 = Kualifikasi + jabatan + dampak
3 = Kualifikasi + jabatan
2 = Kualifikasi atau jabatan
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
Skor Akhir = (3 × (Skor(a) + Skor(b)) + Skor(c)) / 7
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 20,
                'id_kriteria'          => 4,
                'elemen'               => 'Beban Kerja DTPS',
                'poin'                 => '1.25',
                'indikator'            => <<<TEXT
(a) Beban kerja DTPS dalam satu tahun terakhir memungkinkan DTPS bekerja secara maksimal. BKD = rata-rata beban kerja dosen (SKS)

(b) PS melakukan analisis distribusi BKD dalam mendukung: (1) kualitas tridarma yang seimbang, (2) kesejahteraan dosen, (3) keberlanjutan mutu PS.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Distribusi BKD',
                    'options' => [
                        4 => 'Analisis 3 aspek (tridarma seimbang, kesejahteraan, keberlanjutan mutu)',
                        3 => 'Analisis 2 aspek',
                        2 => 'Analisis 1 aspek',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — BEBAN KERJA ━━━
BKD = rata-rata beban kerja dosen (SKS)
12 ≤ BKD ≤ 16 → Skor = 4
6 ≤ BKD < 12 → Skor = (2×BKD − 12) / 3
16 < BKD ≤ 18 → Skor = 36 − (2×BKD)
BKD < 6 atau BKD > 18 → Skor = 1

━━━ SKOR (b) — ANALISIS ━━━
4 = 3 aspek (tridarma, kesejahteraan, mutu)
3 = 2 aspek
2 = 1 aspek
1 = Tidak ada

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 21,
                'id_kriteria'          => 4,
                'elemen'               => 'Pengakuan Kepakaran DTPS',
                'poin'                 => '1.75',
                'indikator'            => <<<TEXT
(a) DTPS memiliki prestasi/pengakuan kepakaran di tingkat wilayah/lokal, nasional, dan/atau internasional. RRD = NRD / NDTPS

(b) PS melakukan analisis: (1) pengakuan reputasi kepakaran, (2) penyebab, (3) dampaknya.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Kepakaran',
                    'options' => [
                        4 => 'Analisis 3 aspek (reputasi, penyebab, dampak)',
                        3 => 'Analisis 2 aspek',
                        2 => 'Analisis 1 aspek',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — PENGUKUAN KEPAKARAN ━━━
RRD = NRD / NDTPS
RRD ≥ 1 → Skor(a) = 4
RRD < 1 → Skor(a) = 2 + (2 × RRD)
Tidak ada skor 1

━━━ SKOR (b) — ANALISIS ━━━
4 = 3 aspek (reputasi, penyebab, dampak)
3 = 2 aspek
2 = 1 aspek
1 = Tidak ada

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 22,
                'id_kriteria'          => 4,
                'elemen'               => 'Pengembangan Kompetensi DTPS',
                'poin'                 => '1.75',
                'indikator'            => <<<TEXT
(a) DTPS mengikuti kegiatan pengembangan kompetensi (postdoct/ARP, sertifikasi BNSP/internasional, workshop ≥ 32 jam, seminar/konferensi relevan) dalam 3 tahun terakhir. NDTPSPK = % DTPS yang mengikuti pengembangan kompetensi relevan.

(b) PS melakukan analisis kontribusi keterlibatan DTPS dalam pengembangan kompetensi terhadap: (1) peningkatan kualitas tridarma, (2) penguatan jejaring akademik, (3) pencapaian visi keilmuan PS.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Kontribusi',
                    'options' => [
                        4 => 'Analisis 3 aspek (tridarma, jejaring, visi keilmuan)',
                        3 => 'Analisis 2 aspek',
                        2 => 'Analisis 1 aspek',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — PENGEMBANGAN KOMPETENSI ━━━
NDTPSPK = % DTPS yang ikut pengembangan kompetensi
NDTPSPK ≥ 80% → Skor = 4
70% ≤ NDTPSPK < 80% → Skor = 3
60% ≤ NDTPSPK < 70% → Skor = 2
NDTPSPK < 60% → Skor = 1

━━━ SKOR (b) — ANALISIS ━━━
4 = 3 aspek (kualitas tridarma, jejaring, visi)
3 = 2 aspek
2 = 1 aspek
1 = Tidak ada

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 23,
                'id_kriteria'          => 4,
                'elemen'               => 'Pengembangan Kompetensi Tenaga Kependidikan',
                'poin'                 => '1.25',
                'indikator'            => <<<TEXT
(a) Tenaga kependidikan mengikuti kegiatan pengembangan kompetensi (studi lanjut, sertifikasi BNSP/internasional, workshop ≥ 16 jam relevan) dalam 3 tahun terakhir. NTENDIKPK = % tenaga kependidikan yang mengikuti pengembangan kompetensi.

(b) PS melakukan analisis kontribusi kecukupan, kompetensi, dan partisipasi tenaga kependidikan dalam program pengembangan pada: (1) peningkatan kualitas layanan administrasi, (2) keefektifan tata kelola, (3) pencapaian mutu akademik dan non-akademik.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Tenaga Kependidikan',
                    'options' => [
                        4 => 'Analisis 3 aspek (layanan, tata kelola, mutu)',
                        3 => 'Analisis 2 aspek',
                        2 => 'Analisis 1 aspek',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — PENGEMBANGAN TENAGA KEPENDIDIKAN ━━━
NTENDIKPK = % tenaga kependidikan ikut pengembangan
NTENDIKPK ≥ 40% → Skor = 4
25% ≤ NTENDIKPK < 40% → Skor = 3
10% ≤ NTENDIKPK < 25% → Skor = 2
NTENDIKPK < 10% → Skor = 1

━━━ SKOR (b) — ANALISIS ━━━
4 = 3 aspek (layanan, tata kelola, mutu)
3 = 2 aspek
2 = 1 aspek
1 = Tidak ada

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 24,
                'id_kriteria'          => 4,
                'elemen'               => 'Evaluasi dan Refleksi terhadap Kriteria Dosen dan Tenaga Kependidikan dan Tindak Lanjut',
                'poin'                 => '1.50',
                'indikator'            => 'UPPS melakukan evaluasi dan refleksi terhadap kriteria dosen dan tenaga kependidikan serta tindak lanjut,dengan ketentuan sebagai berikut.(a) Evaluasi:(1) dilakukan terhadap elemen-elemen dosen dan tendik dengan cara mengidentifikasi minimal kelebihan dan kelemahannya,(2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif,(3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai,(4) didokumentasikan secara lengkap dan sahih.(b) Tindak lanjut:(1) didasarkan pada hasil evaluasi,(2) dirumuskan secara spesifik,terukur,realistis,dan berbasis waktu,(3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan,(4) didukung bukti pelaksanaan yang lengkap dan sahih,dan (5) digunakan sebagai dasar pengembangan program berkelanjutan.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a.UPPS melakukan evaluasi dan refleksi terhadap kriteria dosen dan tenaga kependidikan yang memenuhi 4 aspek.b.UPPS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria dosen dan tendik dengan memenuhi 5 aspek.',
                    3 => 'a.UPPS melakukan evaluasi dan refleksi terhadap kriteria dosen dan tenaga kependidikan yang memenuhi 3 aspek.b.UPPS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria dosen dan tendik dengan memenuhi 4 aspek.',
                    2 => 'a.UPPS melakukan evaluasi dan refleksi terhadap kriteria dosen dan tenaga kependidikan yang memenuhi 2 aspek.b.UPPS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria dosen dan tendik dengan memenuhi 3 aspek.',
                    1 => 'a.UPPS melakukan evaluasi dan refleksi terhadap kriteria dosen dan tenaga kependidikan kurang dari 2 aspek.b.UPPS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria dosen dan tendik dengan memenuhi kurang dari 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 25,
                'id_kriteria'          => 5,
                'elemen'               => 'Perencanaan dan Pengelolaan Keuangan',
                'poin'                 => '1.00',
                'indikator'            => 'UPPS menjalankan prinsip keuangan yang transparan tercermin dari aspek (a) perencanaan,(b) pelaksanaan,(c) evaluasi,(d) tindak lanjut,(e) berbasis sistem informasi.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'UPPS menjalankan prinsip keuangan yang transparan tercermin dari 5 aspek.',
                    3 => 'UPPS menjalankan prinsip keuangan yang transparan tercermin dari 4 aspek.',
                    2 => 'UPPS menjalankan prinsip keuangan yang transparan tercermin dari 3 aspek.',
                    1 => 'UPPS menjalankan prinsip keuangan yang transparan tercermin dari < 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 26,
                'id_kriteria'          => 5,
                'elemen'               => 'Penggunaan Anggaran',
                'poin'                 => '1.50',
                'indikator'            => 'PS mengelola anggaran operasional pendidikan,penelitian,PkM yang memadai dari PT/UPPS,dan melakukan analisis terhadap aspek:(a) penggunaan anggaran untuk menjamin terlaksananya kegiatan tridharma secara efektif,dan (b) dampak penggunaan anggaran terhadap kinerja PS.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a.Biaya operasional pendidikan PS senilai ≥ 18 Juta/mahasiswa/tahun.b.Dana penelitian PS senilai ≥ 10 juta/dosen/tahun.c.Dana PkM PS senilai ≥ 5 juta/dosen/tahun.d.PS melakukan analisis terhadap pengelolaan anggaran pada 2 aspek.',
                    3 => 'a.Biaya operasional pendidikan PS senilai antara ≥ 10 sampai dengan < 18 Juta/mahasiswa/tahun.b.Dana penelitian PS senilai antara ≥ 7 sampai dengan < 10 Juta/dosen/tahun.c.Dana PkM PS senilai antara ≥ 3 sampai dengan < 5 Juta/dosen/tahun.d.PS melakukan analisis terhadap pengelolaan anggaran pada 1 aspek.',
                    2 => 'a.Biaya operasional pendidikan PS senilai antara ≥ 5 sampai dengan < 10 Juta/mahasiswa/tahun.b.Dana penelitian PS senilai antara ≥ 4 sampai dengan < 7 Juta/dosen/tahun.c.Dana PkM PS senilai antara ≥ 1 sampai dengan < 3 Juta/dosen/tahun.d.PS melakukan analisis terhadap pengelolaan anggaran pada 1 aspek.',
                    1 => 'a.Biaya operasional pendidikan PS senilai < 5 Juta/mahasiswa/tahun.b.Dana penelitian PS senilai < 4 juta/dosen/tahun.c.Dana PkM PS senilai < 1 juta/dosen/tahun.d.PS tidak melakukan analisis.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 27,
                'id_kriteria'          => 5,
                'elemen'               => 'Ketersediaan dan Aksesibilitas Sarana dan Prasarana Utama Pendidikan',
                'poin'                 => '1.25',
                'indikator'            => 'PT/UPPS menyediakan sarana dan prasarana utama untuk mendukung kegiatan akademik dan administrasi yang memenuhi aspek (a) kelengkapan,(b) kualitas,(c) aksesibilitas,(d) keterawatan,(e) kemutakhiran,(f) kemanfaatan,dan (g) analisis dampaknya terhadap kegiatan akademik dan administrasi.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PT/UPPS menyediakan sarana dan prasarana yang mendukung kegiatan akademik dan administrasi yang memenuhi 7 aspek.',
                    3 => 'PT/UPPS menyediakan sarana dan prasarana yang mendukung kegiatan akademik dan administrasi yang memenuhi 5 - 6 aspek.',
                    2 => 'PT/UPPS menyediakan sarana dan prasarana yang mendukung kegiatan akademik dan administrasi yang memenuhi 3 - 4 aspek.',
                    1 => 'PT/UPPS menyediakan sarana dan prasarana yang mendukung kegiatan akademik dan administrasi yang memenuhi < 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 28,
                'id_kriteria'          => 5,
                'elemen'               => 'Ketersediaan dan Aksesibilitas Teknologi Informasi',
                'poin'                 => '1.25',
                'indikator'            => 'PT/UPPS menyediakan infrastruktur dan teknologi informasi (TI) dan mengembangkan platform digital untuk mendukung kegiatan akademik dan administrasi yang memenuhi aspek (a) kelengkapan,(b) kualitas,(c) kemutakhiran,(d) keterintegrasian,(e) keterawatan,(f) aksesibilitas,dan (g) analisis dampaknya terhadap kegiatan akademik dan administrasi.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PT/UPPS menyediakan infrastruktur teknologi informasi (TI) dan mengembangkan platform digital untuk mendukung kegiatan akademik dan administrasi yang memenuhi 7 aspek.',
                    3 => 'PT/UPPS menyediakan infrastruktur teknologi informasi (TI) dan mengembangkan platform digital untuk mendukung kegiatan akademik dan administrasi yang memenuhi 5 - 6 aspek.',
                    2 => 'PT/UPPS menyediakan infrastruktur teknologi informasi (TI) dan mengembangkan platform digital untuk mendukung kegiatan akademik dan administrasi yang memenuhi 3 - 4 aspek.',
                    1 => 'PT/UPPS menyediakan infrastruktur teknologi informasi (TI) dan mengembangkan platform digital untuk mendukung kegiatan akademik dan administrasi yang memenuhi < 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 29,
                'id_kriteria'          => 5,
                'elemen'               => 'Keamanan,Keselamatan,dan Kesehatan Lingkungan (K3L)',
                'poin'                 => '1.25',
                'indikator'            => 'PT/UPPS menjamin pemenuhan standar K3L belajar/bekerja yang memenuhi aspek (a) ketersediaan kebijakan,(b) ketersediaan sistem manajemen,(c) ketersediaan peralatan dan fasilitas pendukung,(d) pelaksanaan sosialisasi dan edukasi,dan (e) pelaksanaan penilaian dan audit K3L secara berkala.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PT/UPPS menjamin pemenuhan standar K3L yang memenuhi 5 aspek.',
                    3 => 'PT/UPPS menjamin pemenuhan standar K3L yang memenuhi 4 aspek.',
                    2 => 'PT/UPPS menjamin pemenuhan standar K3L yang memenuhi 3 aspek.',
                    1 => 'PT/UPPS menjamin pemenuhan standar K3L < 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 30,
                'id_kriteria'          => 5,
                'elemen'               => 'Evaluasi dan Refleksi terhadap Kriteria Keuangan,Sarana,dan Prasarana Pendidikan dan Tindak Lanjut',
                'poin'                 => '1.50',
                'indikator'            => 'PT/UPPS melakukan evaluasi dan refleksi serta tindak lanjut terhadap kriteria keuangan dan sarpras pendidikan dengan ketentuan sebagai berikut.(a) Evaluasi dan refleksi:(1) dilakukan terhadap elemen-elemen keuangan dan sarpras pendidikan dengan cara mengidentifikasi minimal kelebihan dan kelemahannya,(2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif,(3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai,(4) didokumentasikan secara lengkap dan sahih.(b) Tindak lanjut:(1) didasarkan pada hasil evaluasi,(2) dirumuskan secara spesifik,terukur,realistis,dan berbasis waktu,(3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan,(4) didukung bukti pelaksanaan yang lengkap dan sahih,dan (5) digunakan sebagai dasar pengembangan program berkelanjutan.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a.PT/UPPS melakukan evaluasi dan refleksi terhadap kriteria keuangan dan sarpras pendidikan dengan memenuhi 4 aspek.b.PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria keuangan dan sarpras pendidikan dengan memenuhi 5 aspek.',
                    3 => 'a.PT/UPPS melakukan evaluasi dan refleksi terhadap kriteria keuangan dan sarpras pendidikan dengan memenuhi 3 aspek.b.PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria keuangan dan sarpras pendidikan dengan memenuhi 4 aspek.',
                    2 => 'a.PT/UPPS melakukan evaluasi dan refleksi terhadap kriteria keuangan dan sarpras pendidikan dengan memenuhi 2 aspek.b.PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria keuangan dan sarpras pendidikan dengan memenuhi 3 aspek.',
                    1 => 'a.PT/UPPS melakukan evaluasi dan refleksi terhadap kriteria keuangan dan sarpras pendidikan dengan memenuhi < 2 aspek.b.PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria keuangan dan sarpras pendidikan dengan memenuhi < 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 31,
                'id_kriteria'          => 6,
                'elemen'               => 'Pengembangan Kurikulum',
                'poin'                 => '1.50',
                'indikator'            => 'UPPS/PS memiliki kurikulum berbasis luaran (OBE) yang:(a) disusun secara sistematis dengan tahapan sbb:(1) evaluasi kurikulum berjalan,(2) penyusunan dokumen kurikulum,(3) review dan perbaikan,(4) pelaksanaan,dan (5) evaluasi dan tindak lanjut,(6) melibatkan stakeholders internal (pimpinan UPPS/PS,dosen,mahasiswa,tenaga kependidikan) dan stakeholders eksternal (alumni,pengguna lulusan,asosiasi program studi/profesi,pakar) dalam proses penyusunan kurikulum;dan (b) memenuhi karakteristik kurikulum yang baik sbb:(1) lengkap,(2) sesuai dengan level KKNI,(3) koheren (ketepatan struktur kurikulum dalam pencapaian CPL),(4) mutakhir,(5) memperlihatkan ciri khusus PS,(6) memiliki fleksibilitas (keleluasaan untuk mengikuti pendidikan dari berbagai tahapan kurikulum dan keleluasaan untuk menyelesaikan pendidikan melalui rekognisi pembelajaran lampau sesuai dengan ketentuan peraturan perundang-undangan),dan (7) memberi kesempatan mahasiswa belajar di luar program studi termasuk microcredential.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a.UPPS/PS menyusun kurikulum berbasis luaran (OBE) yang memenuhi 6 tahapan dengan melibatkan stakeholders internal dan eksternal.b.Kurikulum PS memenuhi 7 karakteristik kurikulum yang baik.',
                    3 => 'a.UPPS/PS menyusun kurikulum berbasis luaran (OBE) yang memenuhi 5 tahapan dengan melibatkan stakeholders internal dan eksternal.b.Kurikulum PS memenuhi 6 karakteristik kurikulum yang baik.',
                    2 => 'a.UPPS/PS menyusun kurikulum berbasis luaran (OBE) yang memenuhi 4 tahapan dengan melibatkan stakeholders internal dan eksternal.b.Kurikulum PS memenuhi 5 karakteristik kurikulum yang baik.',
                    1 => 'a.UPPS/PS menyusun kurikulum berbasis luaran yang memenuhi < 4 tahapan dengan melibatkan stakeholders internal dan eksternal.b.Kurikulum PS memenuhi < 5 karakteristik kurikulum yang baik.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 32,
                'id_kriteria'          => 6,
                'elemen'               => 'Pelaksanaan Pembelajaran',
                'poin'                 => '2.00',
                'indikator'            => 'DTPS melaksanakan pembelajaran yang (a) sesuai dengan RPS yang telah disusun,(b) menciptakan suasana belajar yang menyenangkan,inklusif,kolaboratif,kreatif,dan efektif serta berpusat pada mahasiswa,(c) merealisasikan CPL melalui sub-CPMK,(d) fleksibel:luring,daring,atau bauran (hybrid),(e) melaksanakan assessment for learning,(f) mengintegrasikan hasil penelitian/PkM,(g) memanfaatkan Teknologi Informasi yang relevan,dan (h) melakukan refleksi terhadap pelaksanaan pembelajaran.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'DTPS melaksanakan pembelajaran yang memenuhi 8 aspek.',
                    3 => 'DTPS melaksanakan pembelajaran yang memenuhi 6-7 aspek.',
                    2 => 'DTPS melaksanakan pembelajaran yang memenuhi 4-5 aspek.',
                    1 => 'DTPS melaksanakan pembelajaran yang memenuhi < 4 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 33,
                'id_kriteria'          => 6,
                'elemen'               => 'Integrasi Penelitian dan/atau PkM dalam Pembelajaran',
                'poin'                 => '2.00',
                'indikator'            => <<<TEXT
(a) DTPS mengintegrasikan penelitian dan/atau PkM dalam pembelajaran: (1) relevan dengan mata kuliah, (2) hasil menjadi bagian materi, (3) disertai bukti.

(b) DTPS yang mengintegrasikan hasil penelitian/PkM dalam pembelajaran. PDIPPKM = (NDIPPKM / NDTPS) × 100%

(c) Jumlah MK inti PS yang dikembangkan berdasarkan integrasi penelitian/PkM. PMKI = (NMKI / NMK) × 100%

(d) Analisis terhadap kontribusi integrasi pada: (1) peningkatan mutu proses belajar, (2) relevansi kurikulum, (3) penguatan kompetensi lulusan.

Skor Akhir = Skor(a) + (3 × (Skor(b) + Skor(c)) + Skor(d)) / 8
TEXT,
                'option_pilihan_ganda' => json_encode([
                    [
                        'label'   => 'Skor (a) — Integrasi dalam Pembelajaran',
                        'options' => [
                            4 => 'Memenuhi 3 aspek (relevan, hasil jadi materi, bukti)',
                            3 => 'Memenuhi 2 aspek',
                            2 => 'Memenuhi 1 aspek',
                            1 => 'Tidak memenuhi semua aspek',
                        ],
                    ],
                    [
                        'label'   => 'Skor (d) — Analisis Kontribusi',
                        'options' => [
                            4 => 'Analisis 3 aspek (mutu belajar, relevansi, kompetensi)',
                            3 => 'Analisis 2 aspek',
                            2 => 'Analisis 1 aspek',
                            1 => 'Tidak ada analisis',
                        ],
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — INTEGRASI PEMBELAJARAN ━━━
4 = 3 aspek (relevan, hasil jadi materi, bukti)
3 = 2 aspek
2 = 1 aspek
1 = Tidak ada

━━━ SKOR (b) — PDIPPKM ━━━
PDIPPKM = (NDIPPKM / NDTPS) × 100%
PDIPPKM ≥ 50% → Skor = 4
30% ≤ PDIPPKM < 50% → Skor = 3
10% ≤ PDIPPKM < 30% → Skor = 2
PDIPPKM < 10% → Skor = 1

━━━ SKOR (c) — PMKI ━━━
PMKI = (NMKI / NMK) × 100%
PMKI ≥ 25% → Skor = 4
15% ≤ PMKI < 25% → Skor = 3 + (PMKI − 0.25) / 0.10
PMKI < 15% → Skor = 2
Tidak ada skor 1

━━━ SKOR (d) — ANALISIS ━━━
4 = 3 aspek (mutu, relevansi, kompetensi)
3 = 2 aspek
2 = 1 aspek
1 = Tidak ada

━━━ SKOR AKHIR ━━━
Skor(a) + (3 × (Skor(b) + Skor(c)) + Skor(d)) / 8
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 34,
                'id_kriteria'          => 6,
                'elemen'               => 'Penilaian Pembelajaran',
                'poin'                 => '2.00',
                'indikator'            => 'DTPS melaksanakan penilaian pembelajaran yang (a) sesuai dengan tujuan khusus pembelajaran/Sub-CPMK,(b) menggunakan teknik penilaian yang bervariasi,(c) memiliki tingkat kesulitan yang proporsional,(d) memberikan umpan balik yang konstruktif,dan (e) memberi kesempatan kepada mahasiswa untuk melakukan banding terhadap hasil penilaian.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'DTPS melaksanakan penilaian pembelajaran yang memenuhi 5 aspek.',
                    3 => 'DTPS melaksanakan penilaian pembelajaran yang memenuhi 4 aspek.',
                    2 => 'DTPS melaksanakan penilaian pembelajaran yang memenuhi 3 aspek.',
                    1 => 'DTPS melaksanakan penilaian pembelajaran < 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 35,
                'id_kriteria'          => 6,
                'elemen'               => 'Perkuliahan Microteaching atau Keterampilan Sejenis',
                'poin'                 => '2.00',
                'indikator'            => 'PS melaksanakan microteaching atau nama lain yang sejenis bagi PS kependidikan nonmengajar yang:(a) memenuhi kecukupan laboratorium microteaching dan sarana prasarana pendukung,(b) memenuhi frekuensi praktik,(c) melatihkan 8 keterampilan dasar mengajar,dan (d) melakukan refleksi diri.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a.Memiliki laboratorium microteaching dan sarana prasarana pendukung yang lengkap,terawat dan berfungsi.b.Frekuensi praktik untuk setiap mahasiswa ≥ 3 kali selama semester praktikum di laboratorium.c.Pembelajaran melatihkan 8 keterampilan mengajar atau keterampilan sejenis untuk PS kependidikan nonmengajar.d.Mahasiswa melakukan refleksi diri atas keterampilan mengajar yang telah dipraktikkan pada perkuliahan microteaching atau nama lain yang sejenis.',
                    3 => 'a.Memiliki laboratorium microteaching dan sarana prasarana pendukung yang lengkap dan berfungsi.b.Frekuensi praktik untuk setiap mahasiswa ≥ 2 kali selama semester praktikum di laboratorium.c.Pembelajaran melatihkan 8 keterampilan mengajar atau keterampilan sejenis untuk PS kependidikan nonmengajar.d.Mahasiswa melakukan refleksi diri atas keterampilan mengajar yang telah dipraktikkan pada perkuliahan microteaching atau nama lain yang sejenis.',
                    2 => 'a.Memiliki laboratorium microteaching dan sarana prasarana pendukung yang berfungsi.b.Frekuensi praktik untuk setiap mahasiswa ≥ 1 kali selama semester praktikum di laboratorium.c.Pembelajaran melatihkan 8 keterampilan mengajar atau keterampilan sejenis untuk PS kependidikan nonmengajar.d.Mahasiswa melakukan refleksi diri atas keterampilan mengajar yang telah dipraktikkan pada perkuliahan microteaching atau nama lain yang sejenis.',
                    1 => 'a.Tidak memiliki laboratorium microteaching.b.Frekuensi praktik untuk setiap mahasiswa hanya 1 kali praktik selama semester praktikum di luar laboratorium.c.Pembelajaran melatihkan < 8 keterampilan mengajar atau keterampilan sejenis untuk PS non Kependidikan.d.Mahasiswa tidak melakukan refleksi diri atas keterampilan mengajar yang telah dipraktikkan pada perkuliahan microteaching atau nama lain yang sejenis.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 36,
                'id_kriteria'          => 6,
                'elemen'               => 'Magang Kependidikan',
                'poin'                 => '1.75',
                'indikator'            => 'UPPS melaksanakan program magang kependidikan dengan lama waktu tertentu,yang tercermin dari adanya:(a) kerja sama antara UPPS dengan lembaga mitra;(b) panduan pelaksanaan magang;(c) unit pelaksana magang;(d) laporan pelaksanaan magang;(e) laporan monitoring dan evaluasi pelaksanaan magang;(f) laporan tindak lanjut hasil monitoring dan evaluasi pelaksanaan magang;dan (g) analisis terhadap keefektifan program magang kependidikan.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'UPPS melaksanakan program magang kependidikan yang memenuhi 7 aspek dan berlangsung selama 3-6 bulan.',
                    3 => 'UPPS melaksanakan program magang kependidikan yang memenuhi 6 aspek (aspek a-d harus terpenuhi) dan berlangsung selama 2-3 bulan.',
                    2 => 'UPPS melaksanakan program magang kependidikan yang memenuhi 5 aspek (aspek a-d harus terpenuhi) dan berlangsung selama < 2 bulan.',
                    1 => 'UPPS melaksanakan program magang kependidikan yang memenuhi < 5 aspek dan berlangsung selama < 1 bulan.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 37,
                'id_kriteria'          => 6,
                'elemen'               => 'Pembimbingan Magang Kependidikan',
                'poin'                 => '1.50',
                'indikator'            => 'Dosen pembimbing melaksanakan pembimbingan magang kependidikan dengan frekuensi tertentu secara intensif dan berkualitas yang tercermin dari:(a) kemudahan pembimbing untuk diakses oleh mahasiswa;(b) frekuensi pembimbingan yang memadai;(c) pemberian umpan balik yang konstrukstif;(d) pelaksanaan refleksi setiap kali mahasiswa selesai praktik mengajar;(e) pendokumentasian kegiatan pembimbingan yang lengkap;dan (f) analisis terhadap keefektifan pembimbingan magang kependidikan.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'Dosen pembimbing melaksanakan pembimbingan magang Kependidikan yang memenuhi 6 aspek dan frekuensi pembimbingan ≥ 4 kali kunjungan (daring atau luring).',
                    3 => 'Dosen melaksanakan pembimbingan magang Kependidikan yang memenuhi 5 aspek dan frekuensi pembimbingan ≥ 3 kali kunjungan (daring atau luring).',
                    2 => 'Dosen pembimbing melaksanakan pembimbingan magang Kependidikan yang memenuhi 4 aspek dan frekuensi pembimbingan sebanyak 2 kali kunjungan (daring atau luring).',
                    1 => 'Dosen pembimbing melaksanakan pembimbingan magang Kependidikan yang memenuhi < 4 aspek dan frekuensi pembimbingan sebanyak 1 kali kunjungan (daring atau luring).'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 38,
                'id_kriteria'          => 6,
                'elemen'               => 'Peningkatan Suasana Akademik',
                'poin'                 => '1.50',
                'indikator'            => 'PS meningkatkan suasana akademik melalui kebebasan mimbar akademik dan otonomi keilmuan dengan menyelenggarakan kegiatan akademik di luar kelas yang:(a) beragam,(b) intensif dan berkelanjutan,(c) relevan dengan visi keilmuan PS,dan (d) didokumentasikan secara lengkap dan terstruktur.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PS menyelenggarakan kegiatan di luar kelas untuk meningkatkan suasana akademik sebanyak minimal 4 kali setiap semester dengan memenuhi 4 aspek dalam 3 tahun terakhir.',
                    3 => 'PS menyelenggarakan kegiatan di luar kelas untuk meningkatkan suasana akademik sebanyak 2-3 kali setiap semester dengan memenuhi 3 aspek dalam 3 tahun terakhir.',
                    2 => 'PS menyelenggarakan kegiatan di luar kelas untuk meningkatkan suasana akademik sebanyak 1 kali setiap semester dengan memenuhi 2 aspek dalam 3 tahun terakhir.',
                    1 => 'PS menyelenggarakan kegiatan di luar kelas untuk meningkatkan suasana akademik sebanyak kurang dari 1 setiap semester dengan memenuhi 1 aspek dalam 3 tahun terakhir.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 39,
                'id_kriteria'          => 6,
                'elemen'               => 'Pembimbingan Tugas Akhir',
                'poin'                 => '1.75',
                'indikator'            => 'Pembimbingan Tugas Akhir oleh DTPS memenuhi aspek:(a) Ketersediaan panduan dan sistem informasi tugas akhir,(b) Kecukupan jumlah pembimbing utama tugas akhir,(c) Frekuensi pembimbingan,dan (d) analisis terhadap keefektifan pembimbingan tugas akhir.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'Pembimbingan Tugas Akhir oleh DTPS memenuhi aspek:a.Tersedia panduan dan sistem informasi tugas akhir yang digunakan dalam semua tahapan pembimbingan tugas akhir.b.Rasio pembimbing utama terhadap mahasiswa bimbingan per semester = 1:1-6.c.Frekuensi pembimbingan oleh pembimbing utama minimal 16 kali.d.Analisis terhadap keefektifan pembimbingan tugas akhir.',
                    3 => 'Pembimbingan Tugas Akhir oleh DTPS memenuhi aspek:a.Tersedia panduan dan sistem informasi tugas akhir yang digunakan dalam sebagian pembimbingan tugas akhir.b.Rasio pembimbing utama terhadap mahasiswa bimbingan per semester = 1:7-12.c.Frekuensi pembimbingan oleh pembimbing utama = 14-15 kali.d.Analisis terhadap keefektifan pembimbingan tugas akhir.',
                    2 => 'Pembimbingan utama Tugas Akhir oleh DTPS memenuhi aspek:a.Tersedia panduan dan sistem informasi tugas akhir.b.Rasio pembimbing utama terhadap mahasiswa bimbingan per semester = 1:13-18.c.Frekuensi pembimbingan oleh pembimbing utama = 12-13 kali.d.Analisis terhadap keefektifan pembimbingan tugas akhir.',
                    1 => 'Pembimbingan utama Tugas Akhir oleh DTPS memenuhi aspek:a.Tersedia panduan tetapi tidak tersedia sistem informasi tugas akhir.b.Rasio pembimbing utama terhadap mahasiswa bimbingan per semester = 1:>18.c.Frekuensi pembimbingan oleh pembimbing utama < 12 kali.d.Tidak ada analisis terhadap keefektifan pembimbingan tugas akhir.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 40,
                'id_kriteria'          => 6,
                'elemen'               => 'Indeks Prestasi Kumulatif (IPK) Rata-Rata Lulusan',
                'poin'                 => '1.00',
                'indikator'            => <<<TEXT
(a) Lulusan PS memiliki rata-rata IPK yang baik dalam 3 tahun terakhir. RIPK = Rata-rata IPK lulusan.

(b) PS melakukan analisis terhadap tren IPK lulusan dan faktor-faktor penyebabnya.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis IPK Lulusan',
                    'options' => [
                        4 => 'Analisis tren + faktor dari aspek layanan akademik dan mahasiswa',
                        3 => 'Analisis tren + faktor dari aspek layanan akademik',
                        2 => 'Analisis tren + faktor dari aspek mahasiswa',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — IPK RATA-RATA ━━━
RIPK = Rata-rata IPK lulusan 3 tahun
RIPK ≥ 3,25 → Skor = 4
2,00 ≤ RIPK < 3,25 → Skor = ((8 × RIPK) − 6) / 5
Tidak ada skor 1

━━━ SKOR (b) — ANALISIS ━━━
4 = Tren + faktor (layanan akademik & mahasiswa)
3 = Tren + faktor (layanan akademik)
2 = Tren + faktor (mahasiswa)
1 = Tidak ada

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 41,
                'id_kriteria'          => 6,
                'elemen'               => 'Masa Studi Lulusan',
                'poin'                 => '1.50',
                'indikator'            => <<<TEXT
(a) Rata-rata masa studi lulusan dalam 3 tahun terakhir. RMS = rata-rata masa studi lulusan (dalam tahun)

(b) PS melakukan analisis tren masa studi lulusan, faktor-faktor penyebab, dan dampaknya.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Masa Studi',
                    'options' => [
                        4 => 'Analisis tren + faktor penyebab + dampak',
                        3 => 'Analisis tren + faktor penyebab',
                        2 => 'Analisis tren saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — MASA STUDI ━━━
RMS = rata-rata masa studi lulusan (tahun)
3,5 < RMS ≤ 4,0 → Skor = 4
4 < RMS ≤ 5 → Skor = 4 − ((RMS−4)/0,5) × 1,5
RMS > 5 → Skor = 1

━━━ SKOR (b) — ANALISIS ━━━
4 = Tren + faktor + dampak
3 = Tren + faktor
2 = Tren saja
1 = Tidak ada

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 42,
                'id_kriteria'          => 6,
                'elemen'               => 'Kelulusan Tepat Waktu',
                'poin'                 => '1.50',
                'indikator'            => <<<TEXT
(a) Mahasiswa dapat menyelesaikan studinya sesuai masa tempuh kurikulum (MTK). PMTK = Persentase mahasiswa menyelesaikan studi sesuai MTK

(b) PS melakukan analisis terhadap tren kelulusan tepat waktu, faktor-faktor penyebab, dan dampaknya.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Kelulusan Tepat Waktu',
                    'options' => [
                        4 => 'Analisis tren + faktor penyebab + dampak',
                        3 => 'Analisis tren + faktor penyebab',
                        2 => 'Analisis tren saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — KELULUSAN TEPAT WAKTU ━━━
PMTK = Persentase mahasiswa menyelesaikan studi sesuai MTK
PMTK ≥ 50% → Skor = 4
PMTK < 50% → Skor = 1 + (6 × PMTK)

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis tren + faktor penyebab + dampak
3 = Analisis tren + faktor penyebab
2 = Analisis tren saja
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 43,
                'id_kriteria'          => 6,
                'elemen'               => 'Keberhasilan Studi Mahasiswa',
                'poin'                 => '1.50',
                'indikator'            => <<<TEXT
(a) Mahasiswa berhasil menyelesaikan studinya. PKMS = Persentase keberhasilan studi mahasiswa

(b) PS melakukan analisis keberhasilan studi mahasiswa, faktor-faktor penyebab, dan dampaknya.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Keberhasilan Studi',
                    'options' => [
                        4 => 'Analisis keberhasilan + faktor penyebab + dampak',
                        3 => 'Analisis keberhasilan + faktor penyebab',
                        2 => 'Analisis keberhasilan saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — KEBERHASILAN STUDI ━━━
PKMS = Persentase keberhasilan studi mahasiswa
PKMS ≥ 85% → Skor = 4
45% ≤ PKMS < 85% → Skor = ((80 × PKMS) − 24) / 11
PKMS < 45% → Skor = 1

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis keberhasilan + faktor penyebab + dampak
3 = Analisis keberhasilan + faktor penyebab
2 = Analisis keberhasilan saja
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 44,
                'id_kriteria'          => 6,
                'elemen'               => 'Tracer Study',
                'poin'                 => '1.50',
                'indikator'            => 'UPPS/PS melakukan tracer study yang mencakup 6 aspek,yaitu:(a) terkoordinasi ditingkat PT/UPPS,(b) dilakukan secara regular setiap tahun dan terdokumentasi,(c) menggunakan instrumen yang mencakup seluruh inti pertanyaan tracer study Pendidikan tinggi,(d) ditargetkan pada seluruh lulusan TS-4 s.d TS-2,(e) analisis terhadap hasil tracer study,dan (f) hasilnya disosialisasikan dan digunakan untuk pengembangan kurikulum dan pembelajaran.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'UPPS/PS melaksanakan tracer study dengan memenuhi 6 aspek.',
                    3 => 'UPPS/PS melaksanakan tracer study dengan memenuhi 5 aspek.',
                    2 => 'UPPS/PS melaksanakan tracer study dengan memenuhi 4 aspek.',
                    1 => 'UPPS/PS melaksanakan tracer study dengan memenuhi < 4 aspek atau tidak melakukan tracer study.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 45,
                'id_kriteria'          => 6,
                'elemen'               => 'Kesiapkerjaan, Kewirausahaan, dan Studi Lanjut',
                'poin'                 => '1.25',
                'indikator'            => <<<TEXT
(a) Lulusan PS bekerja di lembaga pendidikan/bidang relevan, usaha mandiri, studi lanjut S2, atau mengikuti PPG. PLB = persentase lulusan yang bekerja + usaha mandiri + studi lanjut + PPG.

(b) PS melakukan analisis terhadap kesiapkerjaan, kewirausahaan, studi lanjut, faktor-faktor penyebab, dan dampaknya.

Ketentuan Responden (berlaku untuk elemen 45, 46, 47, 48):
NL = Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2)
NJ = Jumlah lulusan yang terlacak
PJ = (NJ / NL) × 100%
NL ≥ 150 → Prmin = 30%
NL < 150 → Prmin = 50% − ((NL/150) × 20%)
Jika PJ ≥ Prmin → Skor akhir = Skor
Jika PJ < Prmin → Skor akhir = (PJ / Prmin) × Skor

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis',
                    'options' => [
                        4 => 'Analisis + faktor penyebab + dampak',
                        3 => 'Analisis + faktor penyebab',
                        2 => 'Analisis saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — KESIAPKERJAAN, KEWIRAUSAHAAN, STUDI LANJUT ━━━
PLB = persentase lulusan yang bekerja + usaha mandiri + studi lanjut + PPG
PLB ≥ 80% → Skor = 4
60% ≤ PLB < 80% → Skor = 3
40% ≤ PLB < 60% → Skor = 2
PLB < 40% → Skor = 1

━━━ KETENTUAN RESPONDEN ━━━
NL = Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2)
NJ = Jumlah lulusan yang terlacak
PJ = (NJ / NL) × 100%
NL ≥ 150 → Prmin = 30%
NL < 150 → Prmin = 50% − ((NL/150) × 20%)
Jika PJ ≥ Prmin → faktor = 1
Jika PJ < Prmin → faktor = (PJ / Prmin)
Skor(a) akhir = Skor(a) × faktor

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis + faktor penyebab + dampak
3 = Analisis + faktor penyebab
2 = Analisis saja
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 46,
                'id_kriteria'          => 6,
                'elemen'               => 'Waktu Tunggu Mendapatkan Pekerjaan Pertama',
                'poin'                 => '1.00',
                'indikator'            => <<<TEXT
(a) Mahasiswa PS mendapatkan pekerjaan pertama setelah lulus. WTMP = waktu tunggu lulusan mendapatkan pekerjaan pertama (bulan), dalam 3 tahun TS-4 s.d. TS-2.

(b) PS melakukan analisis terhadap tren waktu tunggu mendapatkan pekerjaan pertama, faktor-faktor penyebab, dan dampaknya.

Ketentuan Responden: berlaku sama seperti elemen 45.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Waktu Tunggu',
                    'options' => [
                        4 => 'Analisis tren + faktor penyebab + dampak',
                        3 => 'Analisis tren + faktor penyebab',
                        2 => 'Analisis tren saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — WAKTU TUNGGU ━━━
WTMP = waktu tunggu lulusan mendapatkan pekerjaan pertama (bulan)
WTMP < 6 → Skor = 4
6 ≤ WTMP ≤ 12 → Skor = (18 − WTMP) / 3
WTMP > 12 → Skor = 1

━━━ KETENTUAN RESPONDEN ━━━
Penyesuaian responden berlaku (lihat elemen 45).

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis tren + faktor penyebab + dampak
3 = Analisis tren + faktor penyebab
2 = Analisis tren saja
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 47,
                'id_kriteria'          => 6,
                'elemen'               => 'Kesesuaian Bidang Kerja Lulusan',
                'poin'                 => '1.00',
                'indikator'            => <<<TEXT
(a) Lulusan PS memperoleh pekerjaan pertama yang sesuai dengan bidang keilmuan PS (TS-4 s.d. TS-2). PBS = persentase kesesuaian bidang kerja lulusan.

(b) PS melakukan analisis terhadap kesesuaian bidang kerja lulusan, faktor-faktor penyebab, dan dampaknya.

Ketentuan Responden: berlaku sama seperti elemen 45.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Kesesuaian Bidang Kerja',
                    'options' => [
                        4 => 'Analisis kesesuaian + faktor penyebab + dampak',
                        3 => 'Analisis kesesuaian + faktor penyebab',
                        2 => 'Analisis kesesuaian saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — KESESUAIAN BIDANG KERJA ━━━
PBS = persentase kesesuaian bidang kerja lulusan
PBS ≥ 60% → Skor = 4
15% < PBS < 60% → Skor = (20 × PBS) / 3
PBS ≤ 15% → Skor = 1

━━━ KETENTUAN RESPONDEN ━━━
Penyesuaian responden berlaku (lihat elemen 45).

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis kesesuaian + faktor penyebab + dampak
3 = Analisis kesesuaian + faktor penyebab
2 = Analisis kesesuaian saja
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 48,
                'id_kriteria'          => 6,
                'elemen'               => 'Kepuasan Pengguna Lulusan',
                'poin'                 => '1.50',
                'indikator'            => <<<TEXT
(a) UPPS/PS melakukan evaluasi tingkat kepuasan pengguna lulusan terhadap kompetensi lulusan, mencakup 9 aspek: (1) etika, (2) keahlian bidang ilmu, (3) kemampuan bahasa asing, (4) penggunaan TI, (5) kemampuan berkomunikasi, (6) kerjasama, (7) pengembangan diri, (8) berpikir kritis, (9) kreativitas.

Skor(a) = Σ TKi / 9, dengan TKi = (4 × ai) + (3 × bi) + (2 × ci) + di, i = 1..9
ai = % "Sangat Baik", bi = % "Baik", ci = % "Cukup", di = % "Kurang"

(b) PS melakukan analisis terhadap tingkat kepuasan pengguna lulusan, faktor-faktor penyebab, dan dampaknya.

Ketentuan Responden: berlaku sama seperti elemen 45.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Kepuasan Pengguna',
                    'options' => [
                        4 => 'Analisis kepuasan + faktor penyebab + dampak',
                        3 => 'Analisis kepuasan + faktor penyebab',
                        2 => 'Analisis kepuasan saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — KEPUASAN PENGGUNA LULUSAN ━━━
TKi = (4 × ai) + (3 × bi) + (2 × ci) + di, i = 1..9
ai = % "Sangat Baik", bi = % "Baik", ci = % "Cukup", di = % "Kurang"
Skor(a) = Σ TKi / 9

━━━ KETENTUAN RESPONDEN ━━━
Penyesuaian responden berlaku (lihat elemen 45).

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis kepuasan + faktor penyebab + dampak
3 = Analisis kepuasan + faktor penyebab
2 = Analisis kepuasan saja
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 49,
                'id_kriteria'          => 6,
                'elemen'               => 'Asesmen Pencapaian CPL',
                'poin'                 => '2.00',
                'indikator'            => 'PS melakukan asesmen pencapaian Capaian Pembelajaran Lulusan (CPL) berdasarkan capaian hasil belajar mahasiswa pada mata kuliah penciri keilmuan PS,melakukan evaluasi terhadap hasil asesmen pencapaian CPL,dan melakukan tindak lanjut hasil evaluasi terhadap hasil asesmen pencpaian CPL.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a.PS melakukan asesmen pencapaian CPL pada mata kuliah penciri keilmuan PS minimal 20% yang didukung bukti sahih;b.PS melakukan evaluasi secara rinci dan komprehensif terhadap asesmen pencapaian CPL berdasarkan capaian hasil belajar mahasiswa,didukung bukti yang lengkap dan sahih;c.PS melakukan tindak lanjut hasil evaluasi terhadap asesmen pencapaian CPL berdasarkan capaian hasil belajar mahasiswa,didukung bukti yang lengkap dan sahih.',
                    3 => 'a.PS melakukan asesmen pencapaian CPL pada mata kuliah penciri keilmuan PS minimal 15% yang didukung bukti sahih;b.PS melakukan evaluasi secara rinci tetapi terbatas terhadap asesmen pencapaian CPL berdasarkan capaian hasil belajar mahasiswa,didukung bukti yang lengkap;c.PS melakukan tindak lanjut hasil evaluasi terhadap asesmen pencapaian CPL berdasarkan capaian hasil belajar mahasiswa,didukung bukti yang lengkap.',
                    2 => 'a.PS melakukan asesmen pencapaian CPL pada mata kuliah penciri keilmuan PS minimal 10% yang didukung bukti sahih;b.PS melakukan evaluasi secara umum terhadap asesmen pencapaian CPL berdasarkan capaian hasil belajar mahasiswa,didukung bukti;c.PS melakukan tindak lanjut hasil evaluasi terhadap asesmen pencapaian CPL berdasarkan capaian hasil belajar mahasiswa,didukung bukti.',
                    1 => 'PS tidak melakukan asesmen pencapaian CPL.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 50,
                'id_kriteria'          => 6,
                'elemen'               => 'Evaluasi Kurikulum',
                'poin'                 => '1.50',
                'indikator'            => 'UPPS/PS melakukan evaluasi kurikulum PS yang memenuhi aspek-aspek sebagai berikut:(a) evaluasi mikro dilakukan paling lama 1 tahun sekali;(b) evaluasi makro dilakukan paling lama 5 tahun sekali;(c) evaluasi merujuk pada kebijakan pemerintah;visi keilmuan PS;perkembangan IPTEKS (termasuk literasi digital),tuntutan industri,dunia usaha,dan dunia kerja (IDUKA);kebutuhan masyarakat,dan keterampilan abad 21:kreativitas,bernalar kritis,komunikasi,kolaborasi,kemampuan adaptif,karakter,dan kesadaran berkewarganegaraan;(d) evaluasi melibatkan stakeholder internal dan eksternal;(e) evaluasi didokumentasikan secara lengkap.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'UPPS/PS melaksanakan evaluasi kurikulum dengan memenuhi 5 aspek.',
                    3 => 'UPPS/PS melaksanakan evaluasi kurikulum dengan memenuhi 4 aspek.',
                    2 => 'UPPS/PS melaksanakan evaluasi kurikulum dengan memenuhi 3 aspek.',
                    1 => 'UPPS/PS melaksanakan evaluasi kurikulum dengan memenuhi < 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 51,
                'id_kriteria'          => 6,
                'elemen'               => 'Evaluasi dan Refleksi terhadap Kriteria Pendidikan dan Tindak Lanjut',
                'poin'                 => '1.50',
                'indikator'            => 'UPPS/PS melakukan evaluasi dan refleksi serta tindak lanjut terhadap pendidikan,dengan ketentuan sebagai berikut.(a) Evaluasi:(1) dilakukan terhadap elemen-elemen pendidikan dengan cara mengidentifikasi minimal kelebihan dan kelemahannya,(2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif,(3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai,(4) didokumentasikan secara lengkap dan sahih.(b) Tindak lanjut:(1) didasarkan pada hasil evaluasi,(2) dirumuskan secara spesifik,terukur,realistis,dan berbasis waktu,(3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan,(4) didukung bukti pelaksanaan yang lengkap dan sahih,dan (5) digunakan sebagai dasar pengembangan program berkelanjutan.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a.UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria pendidikan dengan memenuhi 4 aspek.b.UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria pendidikan dengan memenuhi 5 aspek.',
                    3 => 'a.UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria pendidikan dengan memenuhi 3 aspek.b.UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria pendidikan dengan memenuhi 4 aspek.',
                    2 => 'a.UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria pendidikan dengan memenuhi 2 aspek.b.UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria pendidikan dengan memenuhi 3 aspek.',
                    1 => 'a.UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria pendidikan dengan memenuhi < 2 aspek.b.UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria pendidikan dengan memenuhi < 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 52,
                'id_kriteria'          => 7,
                'elemen'               => 'Peta Jalan Penelitian',
                'poin'                 => '1.00',
                'indikator'            => 'PS memiliki peta jalan penelitian yang (a) mendukung pencapaian visi keilmuan PS,(b) memiliki fokus dan tahapan yang jelas,(c) didukung oleh SDM yang kompeten dalam keilmuan,dan (d) disertasi dengan analisis terhadap ketepatan dan relevansi peta jalan penelitian.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PS memiliki peta jalan penelitian yang memenuhi 4 aspek.',
                    3 => 'PS memiliki peta jalan penelitian yang memenuhi 3 aspek.',
                    2 => 'PS memiliki peta jalan penelitian yang memenuhi 2 aspek.',
                    1 => 'PS memiliki peta jalan penelitian yang memenuhi 1 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 53,
                'id_kriteria'          => 7,
                'elemen'               => 'Produktivitas Penelitian DTPS',
                'poin'                 => '2.25',
                'indikator'            => <<<TEXT
(a) DTPS melakukan penelitian dengan dana mandiri/PT, dalam negeri, dan luar negeri dalam 3 tahun terakhir.
RI = NI/3/NDTPS | RN = NN/3/NDTPS | RL = NL/3/NDTPS
NI = Jumlah penelitian pembiayaan luar negeri
NN = Jumlah penelitian pembiayaan dalam negeri
NL = Jumlah penelitian pembiayaan PT/mandiri
Faktor: a = 0,05 | b = 0,3 | c = 1

(b) PS melakukan analisis terhadap produktivitas penelitian DTPS, faktor-faktor penyebab, dan dampaknya.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Produktivitas Penelitian',
                    'options' => [
                        4 => 'Analisis + faktor penyebab + dampak',
                        3 => 'Analisis + faktor penyebab',
                        2 => 'Analisis saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — PRODUKTIVITAS PENELITIAN DTPS ━━━
RI = NI / 3 / NDTPS
RN = NN / 3 / NDTPS
RL = NL / 3 / NDTPS
a = 0,05 | b = 0,3 | c = 1

RI ≥ a → Skor = 4
RI < a dan RN ≥ b → Skor = 3 + (RI/a)
0 < RI < a dan 0 < RN < b → Skor = 2 + (RI/a) + (RN/b) − (RI×RN)/(a×b)
RI = 0, RN = 0, RL ≥ c → Skor = 2
RI = 0, RN = 0, RL < c → Skor = 1

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis + faktor penyebab + dampak
3 = Analisis + faktor penyebab
2 = Analisis saja
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 54,
                'id_kriteria'          => 7,
                'elemen'               => 'Pelibatan Mahasiswa dalam Penelitian DTPS',
                'poin'                 => '1.00',
                'indikator'            => <<<TEXT
(a) DTPS melibatkan mahasiswa dalam kegiatan penelitiannya. PPDM = (NPM / NPD) × 100%

(b) PS melakukan analisis terhadap keterlibatan mahasiswa dalam penelitian DTPS, faktor-faktor penyebab, dan dampaknya.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Pelibatan Mahasiswa',
                    'options' => [
                        4 => 'Analisis + faktor penyebab + dampak',
                        3 => 'Analisis + faktor penyebab',
                        2 => 'Analisis saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — PELIBATAN MAHASISWA ━━━
PPDM = (NPM / NPD) × 100%
PPDM ≥ 75% → Skor = 4
PPDM < 75% → Skor = 2 + (8 × PPDM)
Tidak ada skor 1

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis + faktor penyebab + dampak
3 = Analisis + faktor penyebab
2 = Analisis saja
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 55,
                'id_kriteria'          => 7,
                'elemen'               => 'Jumlah Publikasi Karya Ilmiah DTPS',
                'poin'                 => '2.50',
                'indikator'            => <<<TEXT
(a) Dalam 3 tahun terakhir, ≥ 20% DTPS memiliki publikasi ilmiah.

RW = (NA1+NB1+NC1)/NDTPS
RN = (NA2+NA3+NB2+NC2)/NDTPS
RI = (NA4+NB3+NC3)/NDTPS

Faktor: a = 0,1 | b = 1 | c = 2

(b) PS melakukan analisis terhadap tren produktivitas dan relevansi publikasi ilmiah DTPS, faktor-faktor penyebab, dan dampaknya.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Publikasi Ilmiah',
                    'options' => [
                        4 => 'Analisis tren + relevansi + faktor penyebab + dampak',
                        3 => 'Analisis tren + relevansi + faktor penyebab',
                        2 => 'Analisis tren produktivitas saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — PUBLIKASI KARYA ILMIAH DTPS ━━━
RI = (NA4+NB3+NC3)/NDTPS | RN = (NA2+NA3+NB2+NC2)/NDTPS | RW = (NA1+NB1+NC1)/NDTPS
a = 0,1 | b = 1 | c = 2

RI ≥ a → Skor = 4
RI < a dan RN ≥ b → Skor = 3 + (RI/a)
0 < RI < a dan 0 < RN < b → Skor = 2 + (RI/a) + (RN/b) − (RI×RN)/(a×b)
RI = 0, RN = 0, RW ≥ c → Skor = 2
RI = 0, RN = 0, RW < c → Skor = 1

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis tren + relevansi + faktor penyebab + dampak
3 = Analisis tren + relevansi + faktor penyebab
2 = Analisis tren produktivitas saja
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 56,
                'id_kriteria'          => 7,
                'elemen'               => 'Jumlah DTPS yang Melakukan Publikasi Karya Ilmiah',
                'poin'                 => '2.00',
                'indikator'            => <<<TEXT
(a) Dalam 3 tahun terakhir, DTPS memiliki publikasi di jurnal nasional dan/atau internasional sebagai penulis pertama atau corresponding author. PPDTPS = (NDTPS_PUB / NDTPS) × 100%

(b) PS melakukan analisis terhadap tren jumlah DTPS yang melakukan publikasi ilmiah, faktor-faktor penyebab, dan dampaknya.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Publikasi DTPS',
                    'options' => [
                        4 => 'Analisis tren + faktor penyebab + dampak',
                        3 => 'Analisis tren + faktor penyebab',
                        2 => 'Analisis tren saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — PERSENTASE DTPS PUBLIKASI ━━━
NDTPS_PUB = S4_DTPS + S3_DTPS + S2_DTPS + S1_DTPS + INT_DTPS
PPDTPS = (NDTPS_PUB / NDTPS) × 100%
PPDTPS ≥ 20% → Skor = 4
15% ≤ PPDTPS < 20% → Skor = 3
10% ≤ PPDTPS < 15% → Skor = 2
PPDTPS < 10% → Skor = 1

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis tren + faktor penyebab + dampak
3 = Analisis tren + faktor penyebab
2 = Analisis tren saja
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 57,
                'id_kriteria'          => 7,
                'elemen'               => 'Jumlah Artikel Ilmiah DTPS yang Disitasi',
                'poin'                 => '2.00',
                'indikator'            => <<<TEXT
(a) Jumlah artikel ilmiah DTPS yang disitasi dalam 3 tahun terakhir. RSA = NAS / NDTPS

(b) PS melakukan analisis terhadap jumlah artikel ilmiah DTPS yang disitasi, faktor-faktor penyebab, dan dampaknya.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Sitasi Artikel',
                    'options' => [
                        4 => 'Analisis + faktor penyebab + dampak',
                        3 => 'Analisis + faktor penyebab',
                        2 => 'Analisis saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — RASIO SITASI ARTIKEL ━━━
RSA = NAS / NDTPS
RSA ≥ 9 → Skor = 4
6 ≤ RSA < 9 → Skor = 3
3 ≤ RSA < 6 → Skor = 2
RSA < 3 → Skor = 1

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis + faktor penyebab + dampak
3 = Analisis + faktor penyebab
2 = Analisis saja
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 58,
                'id_kriteria'          => 7,
                'elemen'               => 'Evaluasi dan Refleksi terhadap Kriteria Penelitian dan Tindak Lanjut',
                'poin'                 => '1.50',
                'indikator'            => 'UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria penelitian serta tindak lanjut,dengan ketentuan sebagai berikut.(a) Evaluasi dan refleksi:(1) dilakukan terhadap elemen-elemen penelitian dengan cara mengidentifikasi minimal kelebihan dan kelemahannya,(2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif,(3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai,(4) didokumentasikan secara lengkap dan sahih.(b) Tindak lanjut:(1) didasarkan pada hasil evaluasi dan refleksi,(2) dirumuskan secara spesifik,terukur,realistis,dan berbasis waktu,(3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan,(4) didukung bukti pelaksanaan yang lengkap dan sahih,dan (5) digunakan sebagai dasar pengembangan program berkelanjutan.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a.UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria penelitian dengan memenuhi 4 aspek.b.UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria penelitian dengan memenuhi 5 aspek.',
                    3 => 'a.UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria penelitian dengan memenuhi 3 aspek.b.UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria penelitian dengan memenuhi 4 aspek.',
                    2 => 'a.UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria penelitian dengan memenuhi 2 aspek.b.UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria penelitian dengan memenuhi 3 aspek.',
                    1 => 'a.UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria penelitian dengan memenuhi 1 aspek.b.UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria penelitian dengan memenuhi < 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 59,
                'id_kriteria'          => 8,
                'elemen'               => 'Produktivitas PkM DTPS',
                'poin'                 => '2.00',
                'indikator'            => <<<TEXT
(a) DTPS memiliki produktivitas PkM dengan dana mandiri/PT, dalam negeri, dan luar negeri dalam 3 tahun terakhir.

RI = NI/3/NDTPS | RN = NN/3/NDTPS | RL = NL/3/NDTPS
Faktor: a = 0,05 | b = 0,3 | c = 1

(b) PS melakukan analisis terhadap produktivitas PkM DTPS, faktor-faktor penyebab, dan dampaknya.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Produktivitas PkM',
                    'options' => [
                        4 => 'Analisis + faktor penyebab + dampak',
                        3 => 'Analisis + faktor penyebab',
                        2 => 'Analisis saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — PRODUKTIVITAS PkM DTPS ━━━
RI = NI/3/NDTPS | RN = NN/3/NDTPS | RL = NL/3/NDTPS
a = 0,05 | b = 0,3 | c = 1

RI ≥ a → Skor = 4
RI < a dan RN ≥ b → Skor = 3 + (RI/a)
0 < RI < a dan 0 < RN < b → Skor = 2 + (RI/a) + (RN/b) − (RI×RN)/(a×b)
RI = 0, RN = 0, RL ≥ c → Skor = 2
RI = 0, RN = 0, RL < c → Skor = 1

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis + faktor penyebab + dampak
3 = Analisis + faktor penyebab
2 = Analisis saja
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 60,
                'id_kriteria'          => 8,
                'elemen'               => 'Pelibatan Mahasiswa dalam PkM DTPS',
                'poin'                 => '1.00',
                'indikator'            => <<<TEXT
(a) DTPS melibatkan mahasiswa dalam kegiatan PkM. PPkDM = (NPkM / NPkDTPS) × 100%

(b) PS melakukan analisis keterlibatan mahasiswa dalam PkM DTPS, faktor-faktor penyebab, dan dampaknya.

Skor Akhir = (3 × Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    'label'   => 'Skor (b) — Analisis Pelibatan Mahasiswa PkM',
                    'options' => [
                        4 => 'Analisis + faktor penyebab + dampak',
                        3 => 'Analisis + faktor penyebab',
                        2 => 'Analisis saja',
                        1 => 'Tidak ada analisis',
                    ],
                ]),
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — PELIBATAN MAHASISWA PkM ━━━
PPkDM = (NPkM / NPkDTPS) × 100%
PPkDM ≥ 75% → Skor = 4
PPkDM < 75% → Skor = 2 + (8 × PPkDM)
Tidak ada skor 1

━━━ SKOR (b) — ANALISIS ━━━
4 = Analisis + faktor penyebab + dampak
3 = Analisis + faktor penyebab
2 = Analisis saja
1 = Tidak ada analisis

━━━ SKOR AKHIR ━━━
(3 × Skor(a) + Skor(b)) / 4
TEXT,
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 61,
                'id_kriteria'          => 8,
                'elemen'               => 'Evaluasi dan Refleksi terhadap Kriteria Pengabdian kepada Masyarakat dan Tindak Lanjut',
                'poin'                 => '1.50',
                'indikator'            => 'UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria PkM serta tindak lanjut dengan ketentuan sebagai berikut.(a) Evaluasi dan refleksi:(1) dilakukan terhadap elemen-elemen PkM dengan cara mengidentifikasi minimal kelebihan dan kelemahannya,(2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif,(3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai,(4) didokumentasikan secara lengkap dan sahih.(b) Tindak lanjut:(1) didasarkan pada hasil evaluasi dan refleksi,(2) dirumuskan secara spesifik,terukur,realistis,dan berbasis waktu,(3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan,(4) didukung bukti pelaksanaan yang lengkap dan sahih,dan (5) digunakan sebagai dasar pengembangan program berkelanjutan.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a.UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria PkM dengan memenuhi 4 aspek.b.UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria PkM dengan memenuhi 5 aspek.',
                    3 => 'a.UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria PkM dengan memenuhi 3 aspek.b.UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria PkM dengan memenuhi 4 aspek.',
                    2 => 'a.UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria PkM dengan memenuhi 2 aspek.b.UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria PkM dengan memenuhi 3 aspek.',
                    1 => 'a.UPPS/PS melakukan evaluasi dan refleksi terhadap kriteria PkM dengan memenuhi 1 aspek.b.UPPS/PS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria PkM dengan memenuhi < 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 62,
                'id_kriteria'          => 9,
                'elemen'               => 'Terbentuknya Unsur Pelaksana Penjaminan Mutu',
                'poin'                 => '1.75',
                'indikator'            => 'UPPS memiliki unsur pelaksana penjaminan mutu di UPPS yang tercermin dari adanya (a) surat keputusan pembentukan unit penjaminan mutu,(b) struktur organisasi penjaminan mutu,(c) deskripsi kerja personil yang ada dalam struktur organisasi,dan (d) personil yang kompeten dalam bidang penjaminan mutu.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'UPPS memiliki unsur pelaksana penjaminan mutu di UPPS yang tercermin dari terpenuhinya 4 aspek.',
                    3 => 'UPPS memiliki unsur pelaksana penjaminan mutu di UPPS yang tercermin dari terpenuhinya 3 aspek.',
                    2 => 'UPPS memiliki unsur pelaksana penjaminan mutu di UPPS yang tercermin dari terpenuhinya 2 aspek.',
                    1 => 'UPPS memiliki unsur pelaksana penjaminan mutu di UPPS yang tercermin dari terpenuhinya hanya < 2 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 63,
                'id_kriteria'          => 9,
                'elemen'               => 'Ketersediaan Perangkat Penjaminan Mutu',
                'poin'                 => '1.75',
                'indikator'            => 'PT/UPPS menetapkan perangkat Sistem Penjaminan Mutu Internal (SPMI) yang minimal mencakup:(1) kebijakan SPMI,(2) pedoman penerapan siklus PPEPP standar pendidikan tinggi dalam SPMI,(3) standar dan/atau kriteria penyelenggaraan pendidikan dan pengelolaan perguruan tinggi,(4) tata cara pendokumentasian implementasi SPMI;dengan pemanfaatan TI untuk mendukung implementasi SPMI.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PT/UPPS menetapkan 4 perangkat SPMI sesuai Standar Pendidikan Tinggi (SN Dikti dan Standar Pendidikan tinggi yang ditetapkan oleh perguruan tinggi) dan memiliki Teknologi Informasi yang lengkap dan andal untuk mendukung implementasi SPMI.',
                    3 => 'PT/UPPS menetapkan 4 perangkat SPMI sesuai Standar Pendidikan Tinggi (SN Dikti dan Standar Pendidikan tinggi yang ditetapkan oleh perguruan tinggi) dan memiliki Teknologi Informasi untuk mendukung implementasi SPMI.',
                    2 => 'PT/UPPS menetapkan 4 perangkat SPMI sesuai Standar Pendidikan Tinggi yang hanya mencakup SN Dikti.',
                    1 => 'PT/UPPS menetapkan < 4 perangkat SPMI dan tidak memanfaatkan Teknologi Informasi untuk mendukung implementasi SPMI.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 64,
                'id_kriteria'          => 9,
                'elemen'               => 'Pelaksanaan SPMI dengan Siklus PPEPP Standar Pendidikan Tinggi',
                'poin'                 => '2.50',
                'indikator'            => 'PT/UPPS/PS melaksanakan SPMI dengan mengikuti 5 tahap dalam siklus (a) Penetapan,(b) Pelaksanaan,(c) Evaluasi,(d) Pengendalian,dan (e) Peningkatan standar pendidikan tinggi (SN Dikti dan Standar Pendidikan tinggi yang ditetapkan oleh perguruan tinggi).',
                'option_pilihan_ganda' => json_encode([
                    4 => 'PT/UPPS/PS melaksanakan SPMI berbasis Teknologi Informasi melalui siklus sebagai berikut:a.menetapkan standar pendidikan tinggi;b.melaksanakan standar pendidikan tinggi;c.mengevaluasi pemenuhan standar pendidikan tinggi;d.mengendalikan pelaksanaan standar pendidikan tinggi;dan e.meningkatkan standar pendidikan tinggi.',
                    3 => 'PT/UPPS/PS melaksanakan SPMI melalui siklus sebagai berikut:a.menetapkan standar pendidikan tinggi;b.melaksanakan standar pendidikan tinggi;c.mengevaluasi pemenuhan standar pendidikan tinggi;d.mengendalikan pelaksanaan standar pendidikan tinggi;dan e.meningkatkan standar pendidikan tinggi.',
                    2 => 'PT/UPPS/PS melaksanakan SPMI melalui siklus sebagai berikut:a.menetapkan standar pendidikan tinggi yang hanya mencakup SN Dikti;b.melaksanakan standar pendidikan tinggi;c.mengevaluasi pemenuhan standar pendidikan tinggi;d.mengendalikan pelaksanaan standar pendidikan tinggi;dan e.meningkatkan standar pendidikan tinggi.',
                    1 => 'PT/UPPS/PS tidak melaksanakan SPMI melalui siklus PPEPP.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],
            [
                'nomor'                => 65,
                'id_kriteria'          => 9,
                'elemen'               => 'Evaluasi dan Refleksi terhadap Kriteria Penjaminan Mutu dan Tindak Lanjut',
                'poin'                 => '1.50',
                'indikator'            => 'PT/UPPS melakukan evaluasi dan refleksi terhadap kriteria penjaminan mutu serta tindak lanjut terhadap penjaminan mutu yang menekankan pada prinsip akuntabilitas,transparansi,nirlaba,efektivitas,efisiensi,dan peningkatan mutu berkelanjutan dengan ketentuan sebagai berikut.(a) Evaluasi dan refleksi:(1) dilakukan terhadap elemen-elemen penjaminan mutu dengan cara mengidentifikasi minimal kelebihan dan kelemahannya,(2) dilakukan berdasarkan pada parameter tertentu secara kuantitatif/kualitatif,(3) dilakukan secara komprehensif berbasis kondisi nyata dengan menggunakan metode yang sesuai,(4) didokumentasikan secara lengkap dan sahih.(b) Tindak lanjut:(1) didasarkan pada hasil evaluasi dan refleksi,(2) dirumuskan secara spesifik,terukur,realistis,dan berbasis waktu,(3) dimonitor untuk memastikan tindak lanjut benar-benar diimplementasikan,(4) didukung bukti pelaksanaan yang lengkap dan sahih,dan (5) digunakan sebagai dasar pengembangan program berkelanjutan.',
                'option_pilihan_ganda' => json_encode([
                    4 => 'a.PT/UPPS melakukan evaluasi dan refleksi terhadap kriteria penjaminan mutu dengan memenuhi 4 aspek.b.PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria penjaminan mutu dengan memenuhi 5 aspek.',
                    3 => 'a.PT/UPPS melakukan evaluasi dan refleksi terhadap kriteria penjaminan mutu dengan memenuhi 3 aspek.b.PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria penjaminan mutu dengan memenuhi 4 aspek.',
                    2 => 'a.PT/UPPS melakukan evaluasi dan refleksi terhadap kriteria penjaminan mutu dengan memenuhi 2 aspek.b.PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria penjaminan mutu dengan memenuhi 3 aspek.',
                    1 => 'a.PT/UPPS melakukan evaluasi dan refleksi terhadap kriteria penjaminan mutu dengan memenuhi 1 aspek.b.PT/UPPS melakukan tindak lanjut berdasarkan hasil evaluasi dan refleksi terhadap kriteria penjaminan mutu dengan memenuhi < 3 aspek.'
                ]),
                'jenis'                => 'pilihan_ganda',
            ],

        ];

        // Extract harkat_penskoran before upsert (keeps column count consistent)
        $harkatUpdates = [];
        foreach ($data as $k => $item) {
            if (isset($item['harkat_penskoran'])) {
                $harkatUpdates[$item['nomor']] = $item['harkat_penskoran'];
                unset($data[$k]['harkat_penskoran']);
            }
        }

        DB::table('matriks_lembar_evaluasi_diri')->upsert(
            $data,
            ['nomor'],
            [
                'id_kriteria',
                'elemen',
                'poin',
                'indikator',
                'option_pilihan_ganda',
                'jenis'
            ]
        );

        // Update harkat_penskoran for items that have it
        foreach ($harkatUpdates as $nomor => $harkat) {
            DB::table('matriks_lembar_evaluasi_diri')
                ->where('nomor', $nomor)
                ->update(['harkat_penskoran' => $harkat]);
        }

    }
}
