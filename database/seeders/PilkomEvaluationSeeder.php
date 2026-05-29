<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PilkomEvaluationSeeder extends Seeder
{
    private const PILKOM_EMAIL = 'pilkom@ulm.ac.id';
    private const UPM_EMAIL = 'upmfkip1@ulm.ac.id';
    private const AUDITOR_EMAIL = 'madhan@ulm.ac.id';
    private const LINK_BUKTI = 'https://drive.google.com/drive/folders/1AriPilkom';

    private const USER_SCORES = [
        'pilkom'  => 3.15,
        'upm'     => 3.80,
        'auditor' => 3.35,
    ];

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
        'auditor' => [
            19 => ['NDS3' => 0, 'NDL' => 1, 'NDLK' => 0, 'NDGB' => 1],
            2 => ['skor' => 2.5],
            3 => ['skor' => 2.5],
            4 => ['skor' => 2.5],
            15 => ['NM' => 40, 'SINTA1_MHS' => 1, 'SINTA2_MHS' => 1, 'SINTA3_MHS' => 1, 'SINTA4_MHS' => 1, 'SINTA5_MHS' => 0, 'SINTA6_MHS' => 0, 'INT_MHS' => 0, 'ISBN_MHS' => 0, 'PATEN_MHS' => 0],
            56 => ['NDTPS' => 20, 'NDTPS_PUB' => 0],
        ],
    ];

    public function run(): void
    {
        $pilkom = User::where('email', self::PILKOM_EMAIL)->first();
        $upm = User::where('email', self::UPM_EMAIL)->first();
        $auditor = User::where('email', self::AUDITOR_EMAIL)->first();

        if (!$pilkom || !$upm || !$auditor) {
            $this->command->error('PilkomEvaluationSeeder: One or more required users are missing.');
            return;
        }

        $usersByRole = [
            'pilkom'  => $pilkom,
            'upm'     => $upm,
            'auditor' => $auditor,
        ];

        $matriksList = DB::table('matriks_lembar_evaluasi_diri')
            ->orderBy('id')
            ->get(['id', 'nomor', 'poin']);

        foreach ($matriksList as $matriks) {
            foreach ($usersByRole as $role => $user) {
                $jawaban = self::USER_SCORES[$role];
                $nilaiTotal = (float) $matriks->poin * $jawaban;
                $skorA = null;
                $skorB = null;

                if ((int) $matriks->nomor === 7) {
                    $skorA = 4;
                    $skorB = 4;
                }

                DB::table('users_matrik')->updateOrInsert(
                    [
                        'id_users'       => $user->id,
                        'id_matriks_led' => $matriks->id,
                    ],
                    [
                        'id_user_jurusan'      => $pilkom->id,
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

        $this->seedSubItemValues($usersByRole, $pilkom->id);

        $this->command->info('PilkomEvaluationSeeder: Evaluasi 65 elemen seeded for Pilkom, UPM, and Auditor.');
    }

    protected function seedSubItemValues(array $usersByRole, int $pilkomId): void
    {
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

            foreach ($usersByRole as $role => $user) {
                $nilai = $this->resolveSubItemValue($nomorElemen, $variabel, $role);
                if ($nilai === null) {
                    continue;
                }
                DB::table('users_sub_item_elemen')->updateOrInsert(
                    [
                        'id_sub_item_elemen' => $subDef->id,
                        'id_matriks'         => $matriksId,
                        'id_users'           => $user->id,
                    ],
                    [
                        'nilai'           => $nilai,
                        'id_user_jurusan' => $pilkomId,
                        'created_at'      => now(),
                        'updated_at'      => now(),
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
