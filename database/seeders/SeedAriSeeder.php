<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedAriSeeder extends Seeder
{
    const USER_ID = 6;
    const USER_JURUSAN_ID = 1;

    public function run(): void
    {
        $this->addMissingSubItemElemen();
        $this->seedMatrikScores();
        $this->seedSubItemValues();

        $this->command->info('SeedAriSeeder: Ari (user 6) data seeded successfully.');
    }

    /**
     * Add missing sub_item_elemen for syarat 6 (Element 56 — Publikasi DTPS).
     * The controller expects variabels S1_DTPS–S4_DTPS, INT_DTPS.
     */
    protected function addMissingSubItemElemen(): void
    {
        $missing = [
            ['nomor_elemen' => 56, 'variabel' => 'S1_DTPS',     'deskripsi' => 'Jumlah DTPS publikasi Sinta 1 (penulis pertama/corresponding)'],
            ['nomor_elemen' => 56, 'variabel' => 'S2_DTPS',     'deskripsi' => 'Jumlah DTPS publikasi Sinta 2 (penulis pertama/corresponding)'],
            ['nomor_elemen' => 56, 'variabel' => 'S3_DTPS',     'deskripsi' => 'Jumlah DTPS publikasi Sinta 3 (penulis pertama/corresponding)'],
            ['nomor_elemen' => 56, 'variabel' => 'S4_DTPS',     'deskripsi' => 'Jumlah DTPS publikasi Sinta 4 (penulis pertama/corresponding)'],
            ['nomor_elemen' => 56, 'variabel' => 'INT_DTPS',    'deskripsi' => 'Jumlah DTPS publikasi jurnal internasional (penulis pertama/corresponding)'],
        ];

        foreach ($missing as $item) {
            DB::table('sub_item_elemen')->updateOrInsert(
                ['nomor_elemen' => $item['nomor_elemen'], 'variabel' => $item['variabel']],
                ['deskripsi' => $item['deskripsi']]
            );
        }
    }

    /**
     * Seed users_matrik for all 65 elements with max scores.
     */
    protected function seedMatrikScores(): void
    {
        $userId = self::USER_ID;
        $userJurusanId = self::USER_JURUSAN_ID;
        $linkBukti = 'https://drive.google.com/drive/folders/1AriPilkom';

        $matriksList = DB::table('matriks_lembar_evaluasi_diri')
            ->orderBy('id')
            ->get(['id', 'nomor', 'poin', 'jenis']);

        foreach ($matriksList as $m) {
            $poin = (float) trim($m->poin);
            $jawaban = '4.00';
            $nilaiTotal = $poin * 4;
            $skorA = null;
            $skorB = null;

            if ((int) $m->nomor === 7) {
                $skorA = 4;
                $skorB = 4;
            }

            DB::table('users_matrik')->updateOrInsert(
                [
                    'id_users'       => $userId,
                    'id_matriks_led' => $m->id,
                ],
                [
                    'id_user_jurusan'       => $userJurusanId,
                    'jawaban'               => $jawaban,
                    'skor_a'                => $skorA,
                    'skor_b'                => $skorB,
                    'nilai_total'           => $nilaiTotal,
                    'link_bukti'            => $linkBukti,
                    'kepemilikan_kriteria'  => 'fakultas',
                    'temuan'                => '-',
                    'saran'                 => '-',
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ]
            );
        }
    }

    /**
     * Seed users_sub_item_elemen for all elements that have sub-item definitions.
     * For syarat elements, values are chosen to meet "Terakreditasi Unggul" thresholds.
     */
    protected function seedSubItemValues(): void
    {
        $userId = self::USER_ID;
        $userJurusanId = self::USER_JURUSAN_ID;

        $allSubDefs = DB::table('sub_item_elemen')
            ->orderBy('nomor_elemen')
            ->get(['id', 'nomor_elemen', 'variabel']);

        $matriksByNomor = DB::table('matriks_lembar_evaluasi_diri')
            ->get(['id', 'nomor'])
            ->keyBy('nomor');

        foreach ($allSubDefs as $subDef) {
            $nomorElemen = (int) $subDef->nomor_elemen;
            $variabel = $subDef->variabel;

            if (!isset($matriksByNomor[$nomorElemen])) {
                continue;
            }

            $matriksId = $matriksByNomor[$nomorElemen]->id;

            $nilai = $this->resolveSubItemValue($nomorElemen, $variabel);

            if ($nilai === null) {
                continue;
            }

            DB::table('users_sub_item_elemen')->updateOrInsert(
                [
                    'id_sub_item_elemen' => $subDef->id,
                    'id_matriks'         => $matriksId,
                    'id_users'           => $userId,
                ],
                [
                    'nilai'           => $nilai,
                    'id_user_jurusan' => $userJurusanId,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]
            );
        }
    }

    /**
     * Resolve the value for a given sub-item element/variable.
     * Returns null to skip that sub-item.
     */
    protected function resolveSubItemValue(int $nomorElemen, string $variabel): float|int|null
    {
        $map = [

            /* ========= Syarat 1 — Elemen 19 (Kualifikasi/Jabatan DTPS) ========= */
            19 => [
                'NDS3'  => 2,
                'NDTPS' => 18,
                'NDGB'  => 0,
                'NDLK'  => 1,
                'NDL'   => 2,
                // PDS3 and PGBLKL are computed percentages — skip
            ],

            /* ========= Syarat 5 — Elemen 15 (Produktivitas Karya Mahasiswa) ========= */
            15 => [
                'NM'          => 100,
                'SINTA1_MHS'  => 5,
                'SINTA2_MHS'  => 5,
                'SINTA3_MHS'  => 5,
                'SINTA4_MHS'  => 5,
                'SINTA5_MHS'  => 5,
                'SINTA6_MHS'  => 0,
                'INT_MHS'     => 5,
                'ISBN_MHS'    => 5,
                'PATEN_MHS'   => 0,
            ],

            /* ========= Syarat 6 — Elemen 56 (Publikasi DTPS) ========= */
            56 => [
                'NDTPS'       => 18,
                'NDTPS_PUB'   => 6,
                'S1_DTPS'     => 3,
                'S2_DTPS'     => 3,
                'S3_DTPS'     => 0,
                'S4_DTPS'     => 0,
                'INT_DTPS'    => 3,
            ],

            /* ========= Elemen 7 — Kerjasama Tridharma ========= */
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

            /* ========= Elemen 11 — Rasio Dosen/Mahasiswa ========= */
            11 => [
                'NM'    => 200,
                'NDTPS' => 18,
            ],

            /* ========= Elemen 14 — Prestasi Mahasiswa ========= */
            14 => [
                'NM' => 200,
                'NI' => 2,
                'NN' => 15,
                'NW' => 30,
            ],

            /* ========= Elemen 16 — Kepuasan Mahasiswa ========= */
            16 => [
                'JUMLAH_ASPEK' => 6,
                'TKM'          => 85,
            ],

            /* ========= Elemen 20 — Beban Kerja DTPS ========= */
            20 => [
                'BKD' => 14,
            ],

            /* ========= Elemen 21 — Pengakuan Kepakaran DTPS ========= */
            21 => [
                'NRD'   => 20,
                'NDTPS' => 18,
            ],

            /* ========= Elemen 22 — Pengembangan Kompetensi DTPS ========= */
            22 => [
                'NDTPSPK' => 90,
            ],

            /* ========= Elemen 23 — Pengembangan Kompetensi Tendik ========= */
            23 => [
                'NTENDIKPK' => 60,
            ],

            /* ========= Elemen 33 — Integrasi Penelitian/PkM ========= */
            33 => [
                'NDIPPKM' => 14,
                'NDTPS'   => 18,
                'NMKI'    => 25,
                'NMK'     => 50,
            ],

            /* ========= Elemen 40 — IPK Rata-rata ========= */
            40 => [
                'RIPK' => 3.50,
            ],

            /* ========= Elemen 42 — Lama Studi ========= */
            42 => [
                'RMS' => 3.8,
            ],

            /* ========= Elemen 43 — Kelulusan Tepat Waktu ========= */
            43 => [
                'PMTK' => 65,
            ],

            /* ========= Elemen 45 — Employability ========= */
            45 => [
                'NL' => 150,
                'NJ' => 135,
                'PLB' => 85,
            ],

            /* ========= Elemen 46 — Waktu Tunggu ========= */
            46 => [
                'NL'   => 150,
                'NJ'   => 135,
                'WTMP' => 4,
            ],

            /* ========= Elemen 47 — Kesesuaian Bidang Kerja ========= */
            47 => [
                'NL'  => 150,
                'NJ'  => 135,
                'PBS' => 75,
            ],

            /* ========= Elemen 48 — Kepuasan Pengguna Lulusan ========= */
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

            /* ========= Elemen 53 — Produktivitas Penelitian DTPS ========= */
            53 => [
                'NI'    => 3,
                'NN'    => 20,
                'NL'    => 30,
                'NDTPS' => 18,
            ],

            /* ========= Elemen 54 — Pelibatan Mahasiswa dalam Penelitian ========= */
            54 => [
                'NPM' => 45,
                'NPD' => 50,
            ],

            /* ========= Elemen 55 — Karya Ilmiah DTPS ========= */
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

            /* ========= Elemen 57 — Karya Ilmiah Disitasi ========= */
            57 => [
                'NAS'   => 150,
                'NDTPS' => 18,
            ],

            /* ========= Elemen 59 — Produktivitas PkM DTPS ========= */
            59 => [
                'NI'    => 2,
                'NN'    => 15,
                'NL'    => 20,
                'NDTPS' => 18,
            ],

            /* ========= Elemen 60 — Pelibatan Mahasiswa dalam PkM ========= */
            60 => [
                'NPkM'    => 35,
                'NPkDTPS' => 40,
            ],
        ];

        if (!isset($map[$nomorElemen])) {
            return null;
        }

        $elementMap = $map[$nomorElemen];

        if (!array_key_exists($variabel, $elementMap)) {
            return null;
        }

        return $elementMap[$variabel];
    }
}
