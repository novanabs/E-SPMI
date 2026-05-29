<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LEDSeeder2 extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nomor'                => 7,
                'id_kriteria'          => 2,
                'elemen'               => 'Kerjasama Tridharma Perguruan Tinggi',
                'poin'                 => '1.50',
                'indikator'            => <<<TEXT
(a) PT/UPPS menjalin kerjasama dalam bidang pendidikan, penelitian, dan PkM dengan pihak lain di tingkat wilayah/lokal, nasional dan internasional dalam 3 tahun terakhir. Skor(a) = ((2 x A) + B) / 3

(b) Analisis keefektifan kerja sama yang dijalin PS dalam memberikan kontribusi nyata, berkelanjutan, dan terukur bagi peningkatan mutu tridharma serta peningkatan reputasi PS di tingkat lokal, nasional, maupun internasional.

Skor Akhir = (3 x Skor(a) + Skor(b)) / 4
TEXT,
                'harkat_penskoran'     => <<<TEXT
━━━ SKOR (a) — KUANTITATIF ━━━

Jika RK ≥ 4, maka A = 4
Jika RK < 4, maka A = RK

RK = ((a x N1) + (b x N2) + (c x N3)) / NDTPS  Faktor: a = 3, b = 2, c = 1

N1 = Jumlah kerjasama pendidikan
N2 = Jumlah kerjasama penelitian
N3 = Jumlah kerjasama PkM
NDTPS = Jumlah dosen tetap pengampu MK sesuai kompetensi inti PS

Jika NI ≥ a (a=2), maka B = 4
Jika NI < a dan NN ≥ b (b=6), maka B = 3 + (NI/a)
Jika 0 < NI < a dan 0 < NN < b, maka B = 2 + (2 x NI/a) + (NN/b) - (NI x NN)/(a x b)
Jika NI = 0, NN = 0, NW ≥ c (c=9), maka B = 2
Jika NI = 0, NN = 0, NW < c, maka B = 1

NI = Jumlah kerjasama internasional
NN = Jumlah kerjasama nasional
NW = Jumlah kerjasama wilayah/lokal

━━━ SKOR (b) — KUALITATIF ━━━

4 = PS menganalisis keefektifan kerjasama: kontribusi nyata, berkelanjutan, terukur bagi peningkatan mutu tridharma serta peningkatan reputasi PS tingkat lokal, nasional, internasional.
3 = PS menganalisis keefektifan kerjasama: kontribusi nyata, berkelanjutan, terukur bagi peningkatan mutu tridharma.
2 = PS menganalisis keefektifan kerjasama: kontribusi nyata bagi peningkatan mutu tridharma.
1 = PS tidak menganalisis keefektifan kerja sama.

━━━ SKOR AKHIR ━━━
Skor Akhir = (3 x Skor(a) + Skor(b)) / 4
TEXT,
                'option_pilihan_ganda' => json_encode([
                    4 => 'PS menganalisis keefektifan kerjasama: kontribusi nyata, berkelanjutan, terukur bagi peningkatan mutu tridharma serta peningkatan reputasi PS tingkat lokal, nasional, internasional.',
                    3 => 'PS menganalisis keefektifan kerjasama: kontribusi nyata, berkelanjutan, terukur bagi peningkatan mutu tridharma.',
                    2 => 'PS menganalisis keefektifan kerjasama: kontribusi nyata bagi peningkatan mutu tridharma.',
                    1 => 'PS tidak menganalisis keefektifan kerja sama.',
                ]),
                'jenis'                => 'isian',
            ],
        ];

        DB::table('matriks_lembar_evaluasi_diri')->upsert(
            $data,
            ['nomor'],
            [
                'id_kriteria',
                'elemen',
                'poin',
                'indikator',
                'harkat_penskoran',
                'option_pilihan_ganda',
                'jenis'
            ]
        );
    }
}