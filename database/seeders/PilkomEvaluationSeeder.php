<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PilkomEvaluationSeeder extends Seeder
{
    const JURUSAN_ID = 1;  // Pendidikan Komputer
    const AUDITOR_IDS = [4, 5];  // Madhan, Ari

    private array $syarat3Elements = [35, 49, 64];

    private array $temuanSaran = [
        7  => ['temuan' => 'Belum semua kerjasama memiliki dokumen MoU yang lengkap dan terdokumentasi dalam sistem.', 'saran' => 'Lengkapi dokumen MoU untuk seluruh kerjasama dan unggah ke dalam sistem informasi kerjasama.'],
        14 => ['temuan' => 'Dokumentasi prestasi mahasiswa belum terpusat dan beberapa sertifikat belum tervalidasi.', 'saran' => 'Buat database prestasi mahasiswa terpusat dan lakukan validasi berkala setiap semester.'],
        33 => ['temuan' => 'Integrasi hasil penelitian ke dalam bahan ajar masih terbatas pada mata kuliah tertentu.', 'saran' => 'Dorong DTPS untuk mengintegrasikan hasil penelitian ke dalam RPS dan bahan ajar secara merata.'],
        35 => ['temuan' => 'Pelaksanaan microteaching belum dilakukan secara merata, beberapa dosen belum mengikuti sesi peer-review.', 'saran' => 'Jadwalkan microteaching secara berkala dengan sistem peer-review dan dokumentasikan hasilnya.'],
        45 => ['temuan' => 'Data tracer study belum menjangkau seluruh lulusan, response rate masih di bawah 60%.', 'saran' => 'Tingkatkan upaya penjangkauan alumni melalui media sosial dan jaringan alumni untuk meningkatkan response rate.'],
        64 => ['temuan' => 'Dokumentasi siklus PPEPP belum lengkap untuk seluruh standar, beberapa tahap evaluasi belum terdokumentasi.', 'saran' => 'Lengkapi dokumentasi seluruh tahap PPEPP dan lakukan audit internal secara berkala setiap tahun.'],
    ];

    public function run(): void
    {
        $this->addMissingSubItemElemen();
        $this->seedAuditorJurusan();
        $this->seedAuditHeader();
        $this->seedJurusanSelfAssessment();
        $this->seedAuditorAssessment();
        $this->seedSubItemValues();
        $this->seedAuditorTemuanSaran();

        $this->command->info('PilkomEvaluationSeeder: Pendidikan Komputer seeded — Self (Unggul 5 Thn) + Auditor (Unggul 3 Thn).');
    }

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
     * Jurusan self-assessment — all max scores → Terakreditasi Unggul 5 Tahun.
     */
    protected function seedJurusanSelfAssessment(): void
    {
        $matriksList = DB::table('matriks_lembar_evaluasi_diri')->orderBy('id')->get(['id', 'nomor', 'poin', 'jenis']);

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
                    'id_users'         => self::JURUSAN_ID,
                    'id_matriks_led'   => $m->id,
                    'id_user_jurusan'  => null,
                ],
                [
                    'link_bukti'           => 'https://drive.google.com/drive/folders/1PilkomSelf',
                    'jawaban'              => $jawaban,
                    'skor_a'               => $skorA,
                    'skor_b'               => $skorB,
                    'nilai_total'          => $nilaiTotal,
                    'kepemilikan_kriteria' => 'jurusan',
                    'temuan'               => '-',
                    'saran'                => '-',
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ]
            );
        }
    }

    /**
     * Auditor assessment — stored with id_users = JURUSAN_ID (virtual auditor pattern).
     * Syarat elements scored 3.20 → Terakreditasi Unggul 3 Tahun.
     * (Passes 3-year threshold ≥3.0, fails 5-year threshold ≥3.5 on elements 35, 49, 64)
     */
    protected function seedAuditorAssessment(): void
    {
        $matriksList = DB::table('matriks_lembar_evaluasi_diri')->orderBy('id')->get(['id', 'nomor', 'poin', 'jenis']);

        foreach ($matriksList as $m) {
            $nomor = (int) $m->nomor;
            $poin = (float) trim($m->poin);

            $isSyarat3 = in_array($nomor, $this->syarat3Elements);
            $jawaban = $isSyarat3 ? '3.20' : '4.00';
            $nilaiTotal = $poin * (float) $jawaban;
            $skorA = null;
            $skorB = null;

            if ($nomor === 7) {
                $skorA = 4;
                $skorB = 4;
            }

            $temuan = $this->temuanSaran[$nomor]['temuan'] ?? '-';
            $saran  = $this->temuanSaran[$nomor]['saran'] ?? '-';

            DB::table('users_matrik')->updateOrInsert(
                [
                    'id_users'         => self::JURUSAN_ID,
                    'id_matriks_led'   => $m->id,
                    'id_user_jurusan'  => self::JURUSAN_ID,
                ],
                [
                    'link_bukti'           => 'https://drive.google.com/drive/folders/1AriPilkom',
                    'jawaban'              => $jawaban,
                    'skor_a'               => $skorA,
                    'skor_b'               => $skorB,
                    'nilai_total'          => $nilaiTotal,
                    'kepemilikan_kriteria' => 'fakultas',
                    'temuan'               => $temuan,
                    'saran'                => $saran,
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ]
            );
        }
    }

    /**
     * Sub-item values for both jurusan and auditor — meet 5-year thresholds.
     */
    protected function seedSubItemValues(): void
    {
        $allSubDefs = DB::table('sub_item_elemen')->orderBy('nomor_elemen')->get(['id', 'nomor_elemen', 'variabel']);
        $matriksByNomor = DB::table('matriks_lembar_evaluasi_diri')->get(['id', 'nomor'])->keyBy('nomor');

        $users = [
            ['id_users' => self::JURUSAN_ID, 'id_user_jurusan' => null],
            ['id_users' => self::JURUSAN_ID, 'id_user_jurusan' => self::JURUSAN_ID],
        ];

        foreach ($allSubDefs as $subDef) {
            $nomorElemen = (int) $subDef->nomor_elemen;
            $variabel = $subDef->variabel;

            if (!isset($matriksByNomor[$nomorElemen])) continue;

            $matriksId = $matriksByNomor[$nomorElemen]->id;
            $nilai = $this->resolveSubItemValue($nomorElemen, $variabel);
            if ($nilai === null) continue;

            foreach ($users as $u) {
                DB::table('users_sub_item_elemen')->updateOrInsert(
                    [
                        'id_sub_item_elemen' => $subDef->id,
                        'id_matriks'         => $matriksId,
                        'id_users'           => $u['id_users'],
                        'id_user_jurusan'    => $u['id_user_jurusan'],
                    ],
                    [
                        'nilai'           => $nilai,
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ]
                );
            }
        }
    }

    protected function resolveSubItemValue(int $nomorElemen, string $variabel): float|int|null
    {
        $map = [
            19 => ['NDS3' => 2, 'NDTPS' => 18, 'NDGB' => 0, 'NDLK' => 1, 'NDL' => 2],
            15 => ['NM' => 100, 'SINTA1_MHS' => 5, 'SINTA2_MHS' => 5, 'SINTA3_MHS' => 5, 'SINTA4_MHS' => 5, 'SINTA5_MHS' => 5, 'SINTA6_MHS' => 0, 'INT_MHS' => 5, 'ISBN_MHS' => 5, 'PATEN_MHS' => 0],
            56 => ['NDTPS' => 18, 'NDTPS_PUB' => 6, 'S1_DTPS' => 3, 'S2_DTPS' => 3, 'S3_DTPS' => 0, 'S4_DTPS' => 0, 'INT_DTPS' => 3],
            7  => ['RK' => 5, 'N1' => 10, 'N2' => 8, 'N3' => 6, 'NDTPS' => 18, 'NI' => 3, 'NN' => 10, 'NW' => 15],
            11 => ['NM' => 200, 'NDTPS' => 18],
            14 => ['NM' => 200, 'NI' => 2, 'NN' => 15, 'NW' => 30],
            16 => ['JUMLAH_ASPEK' => 6, 'TKM' => 85],
            20 => ['BKD' => 14],
            21 => ['NRD' => 20, 'NDTPS' => 18],
            22 => ['NDTPSPK' => 90],
            23 => ['NTENDIKPK' => 60],
            33 => ['NDIPPKM' => 14, 'NDTPS' => 18, 'NMKI' => 25, 'NMK' => 50],
            40 => ['RIPK' => 3.50],
            42 => ['RMS' => 3.8],
            43 => ['PMTK' => 65],
            45 => ['NL' => 150, 'NJ' => 135, 'PLB' => 85],
            46 => ['NL' => 150, 'NJ' => 135, 'WTMP' => 4],
            47 => ['NL' => 150, 'NJ' => 135, 'PBS' => 75],
            48 => ['NL' => 150, 'NJ' => 135, 'TK1' => 85, 'TK2' => 85, 'TK3' => 80, 'TK4' => 85, 'TK5' => 82, 'TK6' => 84, 'TK7' => 83, 'TK8' => 80, 'TK9' => 81],
            53 => ['NI' => 3, 'NN' => 20, 'NL' => 30, 'NDTPS' => 18],
            54 => ['NPM' => 45, 'NPD' => 50],
            55 => ['NA1' => 5, 'NA2' => 10, 'NA3' => 8, 'NA4' => 5, 'NB1' => 8, 'NB2' => 12, 'NB3' => 6, 'NC1' => 3, 'NC2' => 5, 'NC3' => 2, 'NDTPS' => 18],
            57 => ['NAS' => 150, 'NDTPS' => 18],
            59 => ['NI' => 2, 'NN' => 15, 'NL' => 20, 'NDTPS' => 18],
            60 => ['NPkM' => 35, 'NPkDTPS' => 40],
        ];

        if (!isset($map[$nomorElemen])) return null;
        if (!array_key_exists($variabel, $map[$nomorElemen])) return null;

        return $map[$nomorElemen][$variabel];
    }

    protected function seedAuditorJurusan(): void
    {
        foreach (self::AUDITOR_IDS as $aid) {
            DB::table('auditor_jurusan')->updateOrInsert(
                ['user_id' => $aid, 'jurusan' => 'Pendidikan Komputer'],
                ['tahun_audit' => date('Y'), 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    protected function seedAuditHeader(): void
    {
        DB::table('audits')->updateOrInsert(
            ['program_studi' => (string) self::JURUSAN_ID],
            [
                'fakultas'      => 'Keguruan dan Ilmu Pendidikan',
                'tanggal_audit' => now()->format('Y-m-d'),
                'catatan_umum'  => 'Audit mutu internal Pendidikan Komputer tahun ' . date('Y'),
                'auditor_1_id'  => self::AUDITOR_IDS[0],
                'auditor_2_id'  => self::AUDITOR_IDS[1],
                'jurusan_submitted_at' => now(),
                'jurusan_submitted_by' => self::JURUSAN_ID,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        );
    }

    protected function seedAuditorTemuanSaran(): void
    {
        $matriksByNomor = DB::table('matriks_lembar_evaluasi_diri')->get(['id','nomor'])->keyBy('nomor');

        // Clean old virtual-auditor temuan_saran
        DB::table('auditor_temuan_saran')
            ->where('id_users', self::JURUSAN_ID)
            ->where('id_user_jurusan', self::JURUSAN_ID)
            ->delete();

        // Distribute temuan/saran across real auditors
        $auditorIds = self::AUDITOR_IDS;
        $idx = 0;
        foreach ($this->temuanSaran as $nomor => $data) {
            if (!isset($matriksByNomor[$nomor])) continue;
            $aid = $auditorIds[$idx % 2];
            $idx++;

            DB::table('auditor_temuan_saran')->updateOrInsert(
                [
                    'id_users'         => $aid,
                    'id_user_jurusan'  => self::JURUSAN_ID,
                    'id_matriks_led'   => $matriksByNomor[$nomor]->id,
                ],
                [
                    'temuan'     => $data['temuan'],
                    'saran'      => $data['saran'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
