<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubItemElemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nomor_elemen' => 7,
                'variabel'     => 'RK',
                'deskripsi'    => '-'
            ],
            [
                'nomor_elemen' => 7,
                'variabel'     => 'N1',
                'deskripsi'    => 'Jumlah kerjasama pendidikan'
            ],
            [
                'nomor_elemen' => 7,
                'variabel'     => 'N2',
                'deskripsi'    => 'Jumlah kerjasama penelitian'
            ],
            [
                'nomor_elemen' => 7,
                'variabel'     => 'N3',
                'deskripsi'    => 'Jumlah kerjasama PkM'
            ],
            [
                'nomor_elemen' => 7,
                'variabel'     => 'NDTPS',
                'deskripsi'    => 'Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi'
            ],
            [
                'nomor_elemen' => 7,
                'variabel'     => 'NI',
                'deskripsi'    => 'Jumlah kerjasama tingkat internasional'
            ],
            [
                'nomor_elemen' => 7,
                'variabel'     => 'NN',
                'deskripsi'    => 'Jumlah kerjasama tingkat nasioanal'
            ],
            [
                'nomor_elemen' => 7,
                'variabel'     => 'NW',
                'deskripsi'    => 'Jumlah kerjasama tingkat wilayah/lokal'
            ],
            [
                'nomor_elemen' => 11,
                'variabel'     => 'NM',
                'deskripsi'    => 'Jumlah mahasiswa pada saat TS.'
            ],
            [
                'nomor_elemen' => 11,
                'variabel'     => 'NDTPS',
                'deskripsi'    => 'Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi.  '
            ],
            [
                'nomor_elemen' => 11,
                'variabel'     => 'RMD',
                'deskripsi'    => 'NM/NDTPS'
            ],
            // Ini harusnya perhitungan by sistem
            [
                'nomor_elemen' => 14,
                'variabel'     => 'RI',
                'deskripsi'    => 'NI/NM'
            ],
            [
                'nomor_elemen' => 14,
                'variabel'     => 'RN',
                'deskripsi'    => 'NN/NM'
            ],
            [
                'nomor_elemen' => 14,
                'variabel'     => 'RW',
                'deskripsi'    => 'NW/NM'
            ],
            // ---
            [
                'nomor_elemen' => 14,
                'variabel'     => 'NI',
                'deskripsi'    => 'Jumlah prestasi akademik dan non akademik tingkat internasional.'
            ],
            [
                'nomor_elemen' => 14,
                'variabel'     => 'NN',
                'deskripsi'    => ' Jumlah prestasi akademik dan non akademik tingkat nasional.'
            ],
            [
                'nomor_elemen' => 14,
                'variabel'     => 'NW',
                'deskripsi'    => 'Jumlah prestasi akademik dan non akademik tingkat wilayah/lokal.'
            ],
            [
                'nomor_elemen' => 14,
                'variabel'     => 'NM',
                'deskripsi'    => 'Jumlah mahasiswa pada saat TS.'
            ],
            [
                'nomor_elemen' => 16,
                'variabel'     => 'JUMLAH_ASPEK',
                'deskripsi'    => 'Jumlah aspek pengukuran kepuasan yang terpenuhi (0-6)'
            ],
            [
                'nomor_elemen' => 16,
                'variabel'     => 'TKM',
                'deskripsi'    => 'Tingkat Kepuasan Mahasiswa dalam % (isi 75 untuk 75%)'
            ],
            [
                'nomor_elemen' => 19,
                'variabel'     => 'NDS3',
                'deskripsi'    => 'Jumlah DTPS yang dengan kualifikasi akademik tertinggi Doktor.'
            ],
            [
                'nomor_elemen' => 19,
                'variabel'     => 'NDTPS',
                'deskripsi'    => 'Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi.'
            ],
            [
                'nomor_elemen' => 19,
                'variabel'     => 'NDGB',
                'deskripsi'    => 'Jumlah DTPS yang memiliki jabatan akademik Guru Besar.'
            ],
            [
                'nomor_elemen' => 19,
                'variabel'     => 'NDLK',
                'deskripsi'    => 'Jumlah DTPS yang memiliki jabatan akademik Lektor Kepala.'
            ],
            [
                'nomor_elemen' => 19,
                'variabel'     => 'NDL',
                'deskripsi'    => 'Jumlah DTPS yang memiliki jabatan akademik Lektor.'
            ],
            [
                'nomor_elemen' => 19,
                'variabel'     => 'PDS3',
                'deskripsi'    => '(NDS3/NDTPS) x 100%'
            ],
            [
                'nomor_elemen' => 19,
                'variabel'     => 'PGBLKL',
                'deskripsi'    => '(NDGB + NDLK + NDL) / NDTPS) x 100%'
            ],
            [
                'nomor_elemen' => 20,
                'variabel'     => 'BKD',
                'deskripsi'    => ''
            ],
            [
                'nomor_elemen' => 21,
                'variabel'     => 'RRD',
                'deskripsi'    => 'NRD / NDTPS'
            ],
            [
                'nomor_elemen' => 21,
                'variabel'     => 'NRD',
                'deskripsi'    => 'Jumlah pengakuan atas prestasi/kinerja DTPS yang relevan dengan bidang keahlian dalam 3 tahun terakhir.'
            ],
            [
                'nomor_elemen' => 21,
                'variabel'     => 'NDTPS',
                'deskripsi'    => 'Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi.'
            ],
            [
                'nomor_elemen' => 22,
                'variabel'     => 'NDTPSPK',
                'deskripsi'    => 'Persentase DTPS yang mengikuti kegiatan pengembangan kompetensi (postdoct/ARP, sertifikasi BNSP/internasional, workshop ≥ 32 jam, seminar/konferensi relevan) dalam 3 tahun terakhir.'
            ],
            [
                'nomor_elemen' => 23,
                'variabel'     => 'NTENDIKPK',
                'deskripsi'    => 'Persentase tenaga kependidikan yang mengikuti kegiatan pengembangan kompetensi (studi lanjut, sertifikasi BNSP/internasional, workshop ≥ 16 jam relevan) dalam 3 tahun terakhir.'
            ],
            [
                'nomor_elemen' => 33,
                'variabel'     => 'PDIPPKM',
                'deskripsi'    => '(NDIPPKM / NDTPS) x 100%'
            ],
            [
                'nomor_elemen' => 33,
                'variabel'     => 'NDIPPKM',
                'deskripsi'    => 'Jumlah DTPS yang melakukan integrasi kegiatan penelitian dan PkM dalam pembelajaran dalam 3 tahun terakhir.'
            ],
            [
                'nomor_elemen' => 33,
                'variabel'     => 'NDTPS',
                'deskripsi'    => 'Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi.'
            ],
            [
                'nomor_elemen' => 33,
                'variabel'     => 'NMKI',
                'deskripsi'    => 'Jumlah mata kuliah yang dikembangkan berdasarkan integrasi hasil penelitian/PkM DTPS dalam 3 tahun terakhir.'
            ],
            [
                'nomor_elemen' => 33,
                'variabel'     => 'NMK',
                'deskripsi'    => 'Jumlah mata kuliah.'
            ],
            [
                'nomor_elemen' => 33,
                'variabel'     => 'PMKI',
                'deskripsi'    => '(NMKI / NMK) x 100%'
            ],
            [
                'nomor_elemen' => 40,
                'variabel'     => 'RIPK',
                'deskripsi'    => 'Rata-rata masa studi lulusan (dalam tahun)'
            ],
            [
                'nomor_elemen' => 41,
                'variabel'     => 'RMS',
                'deskripsi'    => 'Rata-rata masa studi lulusan (dalam tahun)'
            ],
            [
                'nomor_elemen' => 42,
                'variabel'     => 'PMTK',
                'deskripsi'    => 'Persentase mahasiswa dapat menyelesaikan studi sesuai masa tempuh kurikulum (MTK)'
            ],
            [
                'nomor_elemen' => 43,
                'variabel'     => 'PKMS',
                'deskripsi'    => 'Persentase keberhasilan studi mahasiswa'
            ],
            [
                'nomor_elemen' => 44,
                'variabel'     => 'PKSM',
                'deskripsi'    => 'Persentase keberhasilan studi lulusan'
            ],
            [
                'nomor_elemen' => 45,
                'variabel'     => 'PLB',
                'deskripsi'    => 'Persentase jumlah lulusan yang bekerja, usaha mandiri, studi lanjut, mengikuti PPG (a + b + c + d)'
            ],
            [
                'nomor_elemen' => 45,
                'variabel'     => 'NL',
                'deskripsi'    => 'Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2)'
            ],
            [
                'nomor_elemen' => 45,
                'variabel'     => 'NJ',
                'deskripsi'    => 'Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) yang terlacak'
            ],
            [
                'nomor_elemen' => 46,
                'variabel'     => 'WTMP',
                'deskripsi'    => 'aktu tunggu lulusan untuk mendapatkan pekerjaan pertama dalam 3 tahun, mulai TS-4 s.d. TS-2.'
            ],
            [
                'nomor_elemen' => 46,
                'variabel'     => 'NL',
                'deskripsi'    => 'Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2)'
            ],
            [
                'nomor_elemen' => 46,
                'variabel'     => 'NJ',
                'deskripsi'    => 'Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) yang terlacak'
            ],
            [
                'nomor_elemen' => 47,
                'variabel'     => 'PBS',
                'deskripsi'    => 'Kesesuaian bidang kerja lulusan saat mendapatkan pekerjaan pertama dalam 3 tahun, mulai TS-4 s.d. TS-2.'
            ],
            [
                'nomor_elemen' => 47,
                'variabel'     => 'NL',
                'deskripsi'    => 'Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2)'
            ],
            [
                'nomor_elemen' => 47,
                'variabel'     => 'NJ',
                'deskripsi'    => 'Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) yang terlacak'
            ],
            ['nomor_elemen' => 48, 'variabel' => 'NL', 'deskripsi' => 'Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2)'],
            ['nomor_elemen' => 48, 'variabel' => 'NJ', 'deskripsi' => 'Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) yang terlacak'],
            ['nomor_elemen' => 48, 'variabel' => 'TK1', 'deskripsi' => 'TKi aspek 1: Etika'],
            ['nomor_elemen' => 48, 'variabel' => 'TK2', 'deskripsi' => 'TKi aspek 2: Keahlian bidang ilmu'],
            ['nomor_elemen' => 48, 'variabel' => 'TK3', 'deskripsi' => 'TKi aspek 3: Kemampuan bahasa asing'],
            ['nomor_elemen' => 48, 'variabel' => 'TK4', 'deskripsi' => 'TKi aspek 4: Penggunaan TI'],
            ['nomor_elemen' => 48, 'variabel' => 'TK5', 'deskripsi' => 'TKi aspek 5: Kemampuan berkomunikasi'],
            ['nomor_elemen' => 48, 'variabel' => 'TK6', 'deskripsi' => 'TKi aspek 6: Kerjasama'],
            ['nomor_elemen' => 48, 'variabel' => 'TK7', 'deskripsi' => 'TKi aspek 7: Pengembangan diri'],
            ['nomor_elemen' => 48, 'variabel' => 'TK8', 'deskripsi' => 'TKi aspek 8: Berpikir kritis'],
            ['nomor_elemen' => 48, 'variabel' => 'TK9', 'deskripsi' => 'TKi aspek 9: Kreativitas'],
            [
                'nomor_elemen' => 53,
                'variabel'     => 'NI',
                'deskripsi'    => 'Jumlah penelitian dengan sumber pembiayaan luar negeri dalam 3 tahun terakhir.'
            ],
            [
                'nomor_elemen' => 53,
                'variabel'     => 'NN',
                'deskripsi'    => 'Jumlah penelitian dengan sumber pembiayaan dalam negeri dalam 3 tahun terakhir'
            ],
            [
                'nomor_elemen' => 53,
                'variabel'     => 'NL',
                'deskripsi'    => 'Jumlah penelitian dengan sumber pembiayaan PT/ mandiri dalam 3 tahun terakhir'
            ],
            [
                'nomor_elemen' => 53,
                'variabel'     => 'NDTPS',
                'deskripsi'    => 'Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi.'
            ],
            [
                'nomor_elemen' => 54,
                'variabel'     => 'NPM',
                'deskripsi'    => 'Jumlah judul penelitian DTPS yang dalam pelaksanaannya melibatkan mahasiswa program studi dalam 3 tahun terakhir.'
            ],
            [
                'nomor_elemen' => 54,
                'variabel'     => 'NPD',
                'deskripsi'    => 'Jumlah judul penelitian DTPS dalam 3 tahun terakhir.'
            ],
            [
                'nomor_elemen' => 55,
                'variabel'     => 'NA1',
                'deskripsi'    => 'Jumlah publikasi di jurnal nasional tidak terakreditasi.'
            ],
            [
                'nomor_elemen' => 55,
                'variabel'     => 'NA2',
                'deskripsi'    => 'Jumlah publikasi di jurnal nasional terakreditasi.'
            ],
            [
                'nomor_elemen' => 55,
                'variabel'     => 'NA3',
                'deskripsi'    => 'Jumlah publikasi di jurnal internasional.'
            ],
            [
                'nomor_elemen' => 55,
                'variabel'     => 'NA4',
                'deskripsi'    => 'Jumlah publikasi di jurnal internasional bereputasi.'
            ],

            [
                'nomor_elemen' => 55,
                'variabel'     => 'NB1',
                'deskripsi'    => 'Jumlah publikasi di seminar wilayah/lokal/PT.'
            ],
            [
                'nomor_elemen' => 55,
                'variabel'     => 'NB2',
                'deskripsi'    => 'Jumlah publikasi di seminar nasional.'
            ],
            [
                'nomor_elemen' => 55,
                'variabel'     => 'NB3',
                'deskripsi'    => 'Jumlah publikasi di seminar internasional.'
            ],

            [
                'nomor_elemen' => 55,
                'variabel'     => 'NC1',
                'deskripsi'    => 'Jumlah tulisan di media massa wilayah.'
            ],
            [
                'nomor_elemen' => 55,
                'variabel'     => 'NC2',
                'deskripsi'    => 'Jumlah tulisan di media massa nasional.'
            ],
            [
                'nomor_elemen' => 55,
                'variabel'     => 'NC3',
                'deskripsi'    => 'Jumlah tulisan di media massa internasional.'
            ],
            [
                'nomor_elemen' => 55,
                'variabel'     => 'NDTPS',
                'deskripsi'    => 'Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah dengan bidang keahlian yang sesuai dengan kompetensi inti program studi yang diakreditasi.'
            ],
            [
                'nomor_elemen' => 57,
                'variabel'     => 'NAS',
                'deskripsi'    => 'Jumlah artikel ilmiah DTPS yang disitasi'
            ],
            [
                'nomor_elemen' => 57,
                'variabel'     => 'NDTPS',
                'deskripsi'    => 'Jumlah dosen tetap pengampu MK sesuai kompetensi inti PS'
            ],
            [
                'nomor_elemen' => 59,
                'variabel'     => 'NI',
                'deskripsi'    => 'Jumlah PkM pembiayaan luar negeri dalam 3 tahun terakhir'
            ],

            [
                'nomor_elemen' => 59,
                'variabel'     => 'NN',
                'deskripsi'    => 'Jumlah PkM pembiayaan dalam negeri dalam 3 tahun terakhir'
            ],
            [
                'nomor_elemen' => 59,
                'variabel'     => 'NL',
                'deskripsi'    => 'Jumlah PkM pembiayaan PT/mandiri dalam 3 tahun terakhir'
            ],
            [
                'nomor_elemen' => 59,
                'variabel'     => 'NDTPS',
                'deskripsi'    => 'Jumlah dosen tetap pengampu MK sesuai kompetensi inti PS'
            ],
            [
                'nomor_elemen' => 60,
                'variabel'     => 'NPkM',
                'deskripsi'    => 'Jumlah PkM DTPS yang melibatkan mahasiswa PS dalam 3 tahun terakhir'
            ],
            [
                'nomor_elemen' => 60,
                'variabel'     => 'NPkDTPS',
                'deskripsi'    => 'Jumlah PkM DTPS dalam 3 tahun terakhir'
            ],
            // 🔥 TAMBAHAN BARU

            /* =========================================
               🔥 ELEMEN 5
               Produktivitas Karya Inovatif Mahasiswa
            ========================================= */

            [
                'nomor_elemen' => 15,
                'variabel'     => 'NM',
                'deskripsi'    => 'Jumlah total mahasiswa'
            ],

            [
                'nomor_elemen' => 15,
                'variabel'     => 'SINTA1_MHS',
                'deskripsi'    => 'Jumlah publikasi mahasiswa pada jurnal Sinta 1'
            ],
            [
                'nomor_elemen' => 15,
                'variabel'     => 'SINTA2_MHS',
                'deskripsi'    => 'Jumlah publikasi mahasiswa pada jurnal Sinta 2'
            ],
            [
                'nomor_elemen' => 15,
                'variabel'     => 'SINTA3_MHS',
                'deskripsi'    => 'Jumlah publikasi mahasiswa pada jurnal Sinta 3'
            ],
            [
                'nomor_elemen' => 15,
                'variabel'     => 'SINTA4_MHS',
                'deskripsi'    => 'Jumlah publikasi mahasiswa pada jurnal Sinta 4'
            ],
            [
                'nomor_elemen' => 15,
                'variabel'     => 'SINTA5_MHS',
                'deskripsi'    => 'Jumlah publikasi mahasiswa pada jurnal Sinta 5'
            ],
            [
                'nomor_elemen' => 15,
                'variabel'     => 'SINTA6_MHS',
                'deskripsi'    => 'Jumlah publikasi mahasiswa pada jurnal Sinta 6'
            ],

            [
                'nomor_elemen' => 15,
                'variabel'     => 'INT_MHS',
                'deskripsi'    => 'Jumlah publikasi internasional mahasiswa'
            ],

            [
                'nomor_elemen' => 15,
                'variabel'     => 'ISBN_MHS',
                'deskripsi'    => 'Jumlah book chapter / buku ISBN mahasiswa'
            ],

            [
                'nomor_elemen' => 15,
                'variabel'     => 'PATEN_MHS',
                'deskripsi'    => 'Jumlah paten / paten sederhana mahasiswa'
            ],




            /* =========================================
               🔥 ELEMEN 6
               Produktivitas Publikasi DTPS
            ========================================= */

[
                'nomor_elemen' => 56,
                'variabel'     => 'NDTPS',
                'deskripsi'    => 'Jumlah Dosen Tetap Program Studi'
            ],

            [
                'nomor_elemen' => 56,
                'variabel'     => 'NDTPS_PUB',
                'deskripsi'    => 'Jumlah DTPS yang memiliki publikasi di jurnal nasional terakreditasi min. Sinta 4 dan/atau internasional sebagai penulis pertama atau corresponding author'
            ],


        ];

        foreach ($data as $item) {
            DB::table('sub_item_elemen')->updateOrInsert(
                [
                    'nomor_elemen' => $item['nomor_elemen'],
                    'variabel'     => $item['variabel']
                ],
                [
                    'deskripsi' => $item['deskripsi']
                ]
            );
        }

    }
}
