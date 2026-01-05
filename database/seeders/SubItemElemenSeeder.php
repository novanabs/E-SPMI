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
                'deskripsi'    => 'NI/NW'
            ],
            [
                'nomor_elemen' => 14,
                'variabel'     => 'RN',
                'deskripsi'    => 'NN/NW'
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
                'variabel'     => 'TKM',
                'deskripsi'    => 'ƩTKMi / 5'
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
                'nomor_elemen' => 42,
                'variabel'     => 'RMS',
                'deskripsi'    => 'Rata-rata IPK lulusan dalam 3 tahun terakhir'
            ],
            [
                'nomor_elemen' => 43,
                'variabel'     => 'PMTK',
                'deskripsi'    => 'Persentase mahasiswa dapat menyelesaikan studi sesuai masa tempuh kurikulum'
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
                'nomor_elemen' => 45,
                'variabel'     => 'PJ',
                'deskripsi'    => 'Persentase lulusan yang terlacak = (NL / NJ) x 100%'
            ],
            [
                'nomor_elemen' => 45,
                'variabel'     => 'Prmin',
                'deskripsi'    => 'Persentase responden minimum'
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
                'nomor_elemen' => 46,
                'variabel'     => 'PJ',
                'deskripsi'    => 'Persentase lulusan yang terlacak = (NL / NJ) x 100%'
            ],
            [
                'nomor_elemen' => 46,
                'variabel'     => 'Prmin',
                'deskripsi'    => 'Persentase responden minimum'
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
            [
                'nomor_elemen' => 47,
                'variabel'     => 'PJ',
                'deskripsi'    => 'Persentase lulusan yang terlacak = (NL / NJ) x 100%'
            ],
            [
                'nomor_elemen' => 47,
                'variabel'     => 'Prmin',
                'deskripsi'    => 'Persentase responden minimum'
            ],
            [
                'nomor_elemen' => 48,
                'variabel'     => 'TKi',
                'deskripsi'    => '(4 x ai) + (3 x bi) + (2 x ci) + di i = 1, 2, ..., 9'
            ],
            [
                'nomor_elemen' => 48,
                'variabel'     => 'NL',
                'deskripsi'    => 'Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2)'
            ],
            [
                'nomor_elemen' => 48,
                'variabel'     => 'NJ',
                'deskripsi'    => 'Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2) yang terlacak'
            ],
            [
                'nomor_elemen' => 48,
                'variabel'     => 'PJ',
                'deskripsi'    => 'Persentase lulusan yang terlacak = (NL / NJ) x 100%'
            ],
            [
                'nomor_elemen' => 48,
                'variabel'     => 'Prmin',
                'deskripsi'    => 'Persentase responden minimum'
            ],
            // Ini diisi otomatis oleh sistem
            [
                'nomor_elemen' => 53,
                'variabel'     => 'RI',
                'deskripsi'    => 'NI / 3 / NDTPS'
            ],
            [
                'nomor_elemen' => 53,
                'variabel'     => 'RN',
                'deskripsi'    => 'NN / 3 / NDTPS'
            ],
            [
                'nomor_elemen' => 53,
                'variabel'     => 'RL',
                'deskripsi'    => 'NL / 3 / NDTPS'
            ],
            // ---
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
                'variabel'     => 'PPDM',
                'deskripsi'    => '(NPM / NPD) x 100%'
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
            // Ini dihitung otomatis
            [
                'nomor_elemen' => 55,
                'variabel'     => 'RW',
                'deskripsi'    => '(NA1 + NB1 + NC1) / NDTPS'
            ],
            [
                'nomor_elemen' => 55,
                'variabel'     => 'RN',
                'deskripsi'    => '(NA2 + NA3 + NB2 + NC2) / NDTPS'
            ],
            [
                'nomor_elemen' => 55,
                'variabel'     => 'RI',
                'deskripsi'    => '(NA4 + NB3 + NC3) / NDTPS'
            ],
            // ---
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
                'variabel'     => 'RSA',
                'deskripsi'    => 'NAS/NDTPS'
            ],
            [
                'nomor_elemen' => 57,
                'variabel'     => 'NAS',
                'deskripsi'    => 'Jumlah artikel ilmiah yang disitasi.'
            ],
            [
                'nomor_elemen' => 57,
                'variabel'     => 'NDTPS',
                'deskripsi'    => 'Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah sesuai kompetensi inti program studi.'
            ],
            [
                'nomor_elemen' => 59,
                'variabel'     => 'NI',
                'deskripsi'    => 'Jumlah kegiatan PkM dengan sumber pembiayaan luar negeri dalam 3 tahun terakhir.'
            ],
            // Ini dihitung otomatis
            [
                'nomor_elemen' => 59,
                'variabel'     => 'RI',
                'deskripsi'    => 'NI / 3 / NDTPS'
            ],
            [
                'nomor_elemen' => 59,
                'variabel'     => 'RN',
                'deskripsi'    => 'RN = NN / 3 / NDTPS'
            ],
            [
                'nomor_elemen' => 59,
                'variabel'     => 'RL',
                'deskripsi'    => 'NL / 3 / NDTPS'
            ],
            // ---
            [
                'nomor_elemen' => 59,
                'variabel'     => 'NN',
                'deskripsi'    => 'Jumlah kegiatan PkM dengan sumber pembiayaan dalam negeri dalam 3 tahun terakhir.'
            ],
            [
                'nomor_elemen' => 59,
                'variabel'     => 'NL',
                'deskripsi'    => 'Jumlah kegiatan PkM dengan sumber pembiayaan PT/mandiri dalam 3 tahun terakhir.'
            ],
            [
                'nomor_elemen' => 59,
                'variabel'     => 'NDTPS',
                'deskripsi'    => 'Jumlah dosen tetap yang ditugaskan sebagai pengampu mata kuliah sesuai kompetensi inti program studi.'
            ],
            [
                'nomor_elemen' => 60,
                'variabel'     => 'PPkDM',
                'deskripsi'    => '(NPM / NPDTPS) x 100%'
            ],
            [
                'nomor_elemen' => 60,
                'variabel'     => 'NPkM',
                'deskripsi'    => 'Jumlah judul PkM DTPS yang dalam pelaksanaannya melibatkan mahasiswa program studi dalam 3 tahun terakhir.'
            ],
            [
                'nomor_elemen' => 60,
                'variabel'     => 'NPkDTPS',
                'deskripsi'    => 'Jumlah judul PkM DTPS dalam 3 tahun terakhir.'
            ],
        ];

        DB::table('sub_item_elemen')->insertOrIgnore($data);

    }
}
