<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MatriksLED;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\User;

class ExportController extends Controller
{
    public function previewPdf()
    {
        $user = auth()->user();
        $userId = auth()->user()->id;
        $logoPath = public_path('img/ulm.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $elemen = MatriksLED::with([
            'kriteria',
            'userMatrik' => function ($q) use ($userId) {
                $q->where('id_users', $userId);
            }
        ])->orderBy('nomor', 'asc')->get();

        $totalNilai = $elemen->sum(function ($item) {
            return $item->userMatrik
                ? $item->userMatrik->jawaban * $item->poin
                : 0;
        });

        if ($totalNilai >= 361) {
            $status = 'Terakreditasi';
            $peringkat = 'Unggul';
        } elseif ($totalNilai >= 301) {
            $status = 'Terakreditasi';
            $peringkat = 'Baik Sekali';
        } elseif ($totalNilai >= 200) {
            $status = 'Terakreditasi';
            $peringkat = 'Baik';
        } else {
            $status = 'Tidak Terakreditasi';
            $peringkat = '-';
        }

        return view('pdf.preview', [
            'generated_by' => $user->name,
            'tanggal'      => now()->format('d-m-Y'),
            'waktu'        => now()->format('H:i:s'),
            'logo'         => $logoBase64,

            'nilai'        => $totalNilai,
            'status'       => $status,
            'peringkat'    => $peringkat,

            'elemen'       => $elemen,
        ])->render();


    }

    public function exportPdf()
    {
        $user = auth()->user();
        $userId = auth()->user()->id;

        $logoPath = public_path('img/ulm.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));


        $elemen = MatriksLED::with([
            'kriteria',
            'userMatrik' => function ($q) use ($userId) {
                $q->where('id_users', $userId);
            }
        ])->orderBy('nomor', 'asc')->get();

        // 🔢 Hitung total nilai (NA)
        $totalNilai = $elemen->sum(function ($item) {
            return $item->userMatrik
                ? $item->userMatrik->jawaban * $item->poin
                : 0;
        });

        // 🏆 Tentukan status & peringkat
        if ($totalNilai >= 361) {
            $status = 'Terakreditasi';
            $peringkat = 'Unggul';
        } elseif ($totalNilai >= 301) {
            $status = 'Terakreditasi';
            $peringkat = 'Baik Sekali';
        } elseif ($totalNilai >= 200) {
            $status = 'Terakreditasi';
            $peringkat = 'Baik';
        } else {
            $status = 'Tidak Terakreditasi';
            $peringkat = '-';
        }

        $data = [
            'generated_by' => $user->name,
            'tanggal'      => now()->format('d-m-Y'),
            'waktu'        => now()->format('H:i:s'),
            'logo'         => $logoBase64,

            'nilai'        => $totalNilai,
            'status'       => $status,
            'peringkat'    => $peringkat,

            'elemen'       => $elemen,
        ];

        $pdf = Pdf::loadView('pdf.preview', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream('evaluasi-diri_' . auth()->user()->homebase . '_' . Carbon::now()->format('d-m-Y') . '.pdf');
    }

    public function previewPdfPerbandingan()
    {
        $user = auth()->user();
        $userJurusan = auth()->user();

        $userUpm = User::where('email', 'upmfkip1@ulm.ac.id')->first();
        $idJurusan = $userJurusan->id;
        $idUserUpm = $userUpm?->id;

        // Logo base64 (cepat & aman untuk PDF)
        $logoPath = public_path('img/ulm.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $elemen = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userMatrik'       => function ($q) use ($idJurusan) {
                $q->where('id_users', $idJurusan);
            },
            'userMatrikByUser' => function ($q) use ($idUserUpm, $idJurusan) {
                $q->where('id_users', $idUserUpm)
                    ->where('id_user_jurusan', $idJurusan);
            },
        ])
            ->orderBy('nomor', 'asc')
            ->get();

        /* ===============================
         * HITUNG AKUMULASI NILAI
         * =============================== */

        $totalJurusan = 0;
        $totalUpm = 0;

        foreach ($elemen as $item) {
            $nilaiJurusan = data_get($item, 'userMatrik.nilai_total', 0);
            $nilaiUpm = data_get($item, 'userMatrikByUser.nilai_total', 0);

            $totalJurusan += $nilaiJurusan;
            $totalUpm += $nilaiUpm;
        }

        // Selisih
        $selisih = abs($totalJurusan - $totalUpm);

        /* ===============================
         * FUNGSI HITUNG AKREDITASI
         * =============================== */
        $hitungAkreditasi = function ($nilai) {
            if ($nilai >= 361) {
                return ['status' => 'Terakreditasi', 'peringkat' => 'Unggul'];
            } elseif ($nilai >= 301) {
                return ['status' => 'Terakreditasi', 'peringkat' => 'Baik Sekali'];
            } elseif ($nilai >= 200) {
                return ['status' => 'Terakreditasi', 'peringkat' => 'Baik'];
            }
            return ['status' => 'Tidak Terakreditasi', 'peringkat' => '-'];
        };

        $hasilJurusan = $hitungAkreditasi($totalJurusan);
        $hasilUpm = $hitungAkreditasi($totalUpm);

        return view('pdf.preview_perbandingan', [
            'logo'             => $logoBase64,
            'generated_by'     => $user->name,
            'tanggal'          => now()->format('d-m-Y'),
            'waktu'            => now()->format('H:i:s'),

            'userJurusan'      => $userJurusan,
            'userUpm'          => $userUpm,

            'elemen'           => $elemen,

            // HASIL PERHITUNGAN
            'totalJurusan'     => $totalJurusan,
            'totalUpm'         => $totalUpm,
            'selisih'          => $selisih,

            'statusJurusan'    => $hasilJurusan['status'],
            'peringkatJurusan' => $hasilJurusan['peringkat'],

            'statusUpm'        => $hasilUpm['status'],
            'peringkatUpm'     => $hasilUpm['peringkat'],
        ]);
    }


    public function exportPdfPerbandingan()
    {
        $user = auth()->user();
        $userJurusan = auth()->user();

        $userUpm = User::where('email', 'upmfkip1@ulm.ac.id')->first();
        $idJurusan = $userJurusan->id;
        $idUserUpm = $userUpm?->id;

        // Logo base64 (cepat & aman untuk PDF)
        $logoPath = public_path('img/ulm.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $elemen = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userMatrik'       => function ($q) use ($idJurusan) {
                $q->where('id_users', $idJurusan);
            },
            'userMatrikByUser' => function ($q) use ($idUserUpm, $idJurusan) {
                $q->where('id_users', $idUserUpm)
                    ->where('id_user_jurusan', $idJurusan);
            },
        ])
            ->orderBy('nomor', 'asc')
            ->get();

        /* ===============================
         * HITUNG AKUMULASI NILAI
         * =============================== */

        $totalJurusan = 0;
        $totalUpm = 0;

        foreach ($elemen as $item) {
            $nilaiJurusan = data_get($item, 'userMatrik.nilai_total', 0);
            $nilaiUpm = data_get($item, 'userMatrikByUser.nilai_total', 0);

            $totalJurusan += $nilaiJurusan;
            $totalUpm += $nilaiUpm;
        }

        // Selisih
        $selisih = abs($totalJurusan - $totalUpm);

        /* ===============================
         * FUNGSI HITUNG AKREDITASI
         * =============================== */
        $hitungAkreditasi = function ($nilai) {
            if ($nilai >= 361) {
                return ['status' => 'Terakreditasi', 'peringkat' => 'Unggul'];
            } elseif ($nilai >= 301) {
                return ['status' => 'Terakreditasi', 'peringkat' => 'Baik Sekali'];
            } elseif ($nilai >= 200) {
                return ['status' => 'Terakreditasi', 'peringkat' => 'Baik'];
            }
            return ['status' => 'Tidak Terakreditasi', 'peringkat' => '-'];
        };

        $hasilJurusan = $hitungAkreditasi($totalJurusan);
        $hasilUpm = $hitungAkreditasi($totalUpm);

        $data = [
            'logo'             => $logoBase64,
            'generated_by'     => $user->name,
            'tanggal'          => now()->format('d-m-Y'),
            'waktu'            => now()->format('H:i:s'),

            'userJurusan'      => $userJurusan,
            'userUpm'          => $userUpm,

            'elemen'           => $elemen,

            // HASIL PERHITUNGAN
            'totalJurusan'     => $totalJurusan,
            'totalUpm'         => $totalUpm,
            'selisih'          => $selisih,

            'statusJurusan'    => $hasilJurusan['status'],
            'peringkatJurusan' => $hasilJurusan['peringkat'],

            'statusUpm'        => $hasilUpm['status'],
            'peringkatUpm'     => $hasilUpm['peringkat'],
        ];

        $pdf = Pdf::loadView('pdf.preview_perbandingan', $data)
            ->setPaper('A4', 'landscape');

        return $pdf->stream('perbandingan-hasil-evaluasi-diri_' . auth()->user()->homebase . '_' . Carbon::now()->format('d-m-Y') . '.pdf');
    }
    public function previewPdfPerbandinganUpm(string $id)
    {

        $userJurusan = auth()->user();

        $userUpm = User::where('email', 'upmfkip1@ulm.ac.id')->first();
        $userJurusan = User::findOrFail($id);
        $idJurusan = $userJurusan->id;
        $idUserUpm = $userUpm?->id;

        // Logo base64 (cepat & aman untuk PDF)
        $logoPath = public_path('img/ulm.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $elemen = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userMatrik'       => function ($q) use ($idJurusan) {
                $q->where('id_users', $idJurusan);
            },
            'userMatrikByUser' => function ($q) use ($idUserUpm, $idJurusan) {
                $q->where('id_users', $idUserUpm)
                    ->where('id_user_jurusan', $idJurusan);
            },
        ])
            ->orderBy('nomor', 'asc')
            ->get();

        /* ===============================
         * HITUNG AKUMULASI NILAI
         * =============================== */

        $totalJurusan = 0;
        $totalUpm = 0;

        foreach ($elemen as $item) {
            $nilaiJurusan = data_get($item, 'userMatrik.nilai_total', 0);
            $nilaiUpm = data_get($item, 'userMatrikByUser.nilai_total', 0);

            $totalJurusan += $nilaiJurusan;
            $totalUpm += $nilaiUpm;
        }

        // Selisih
        $selisih = abs($totalJurusan - $totalUpm);

        /* ===============================
         * FUNGSI HITUNG AKREDITASI
         * =============================== */
        $hitungAkreditasi = function ($nilai) {
            if ($nilai >= 361) {
                return ['status' => 'Terakreditasi', 'peringkat' => 'Unggul'];
            } elseif ($nilai >= 301) {
                return ['status' => 'Terakreditasi', 'peringkat' => 'Baik Sekali'];
            } elseif ($nilai >= 200) {
                return ['status' => 'Terakreditasi', 'peringkat' => 'Baik'];
            }
            return ['status' => 'Tidak Terakreditasi', 'peringkat' => '-'];
        };

        $hasilJurusan = $hitungAkreditasi($totalJurusan);
        $hasilUpm = $hitungAkreditasi($totalUpm);

        return view('pdf.preview_perbandingan', [
            'logo'             => $logoBase64,
            'generated_by'     => $userJurusan->name,
            'tanggal'          => now()->format('d-m-Y'),
            'waktu'            => now()->format('H:i:s'),

            'userJurusan'      => $userJurusan,
            'userUpm'          => $userUpm,

            'elemen'           => $elemen,

            // HASIL PERHITUNGAN
            'totalJurusan'     => $totalJurusan,
            'totalUpm'         => $totalUpm,
            'selisih'          => $selisih,

            'statusJurusan'    => $hasilJurusan['status'],
            'peringkatJurusan' => $hasilJurusan['peringkat'],

            'statusUpm'        => $hasilUpm['status'],
            'peringkatUpm'     => $hasilUpm['peringkat'],
        ]);
    }


    public function exportPdfPerbandinganUpm(string $id)
    {
        $userJurusan = auth()->user();

        $userUpm = User::where('email', 'upmfkip1@ulm.ac.id')->first();
        $userJurusan = User::findOrFail($id);
        $idJurusan = $userJurusan->id;
        $idUserUpm = $userUpm?->id;

        // Logo base64 (cepat & aman untuk PDF)
        $logoPath = public_path('img/ulm.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $elemen = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userMatrik'       => function ($q) use ($idJurusan) {
                $q->where('id_users', $idJurusan);
            },
            'userMatrikByUser' => function ($q) use ($idUserUpm, $idJurusan) {
                $q->where('id_users', $idUserUpm)
                    ->where('id_user_jurusan', $idJurusan);
            },
        ])
            ->orderBy('nomor', 'asc')
            ->get();

        /* ===============================
         * HITUNG AKUMULASI NILAI
         * =============================== */

        $totalJurusan = 0;
        $totalUpm = 0;

        foreach ($elemen as $item) {
            $nilaiJurusan = data_get($item, 'userMatrik.nilai_total', 0);
            $nilaiUpm = data_get($item, 'userMatrikByUser.nilai_total', 0);

            $totalJurusan += $nilaiJurusan;
            $totalUpm += $nilaiUpm;
        }

        // Selisih
        $selisih = abs($totalJurusan - $totalUpm);

        /* ===============================
         * FUNGSI HITUNG AKREDITASI
         * =============================== */
        $hitungAkreditasi = function ($nilai) {
            if ($nilai >= 361) {
                return ['status' => 'Terakreditasi', 'peringkat' => 'Unggul'];
            } elseif ($nilai >= 301) {
                return ['status' => 'Terakreditasi', 'peringkat' => 'Baik Sekali'];
            } elseif ($nilai >= 200) {
                return ['status' => 'Terakreditasi', 'peringkat' => 'Baik'];
            }
            return ['status' => 'Tidak Terakreditasi', 'peringkat' => '-'];
        };

        $hasilJurusan = $hitungAkreditasi($totalJurusan);
        $hasilUpm = $hitungAkreditasi($totalUpm);

        $data = [
            'logo'             => $logoBase64,
            'generated_by'     => $userJurusan->name,
            'tanggal'          => now()->format('d-m-Y'),
            'waktu'            => now()->format('H:i:s'),

            'userJurusan'      => $userJurusan,
            'userUpm'          => $userUpm,

            'elemen'           => $elemen,

            // HASIL PERHITUNGAN
            'totalJurusan'     => $totalJurusan,
            'totalUpm'         => $totalUpm,
            'selisih'          => $selisih,

            'statusJurusan'    => $hasilJurusan['status'],
            'peringkatJurusan' => $hasilJurusan['peringkat'],

            'statusUpm'        => $hasilUpm['status'],
            'peringkatUpm'     => $hasilUpm['peringkat'],
        ];

        $pdf = Pdf::loadView('pdf.preview_perbandingan', $data)
            ->setPaper('A4', 'landscape');

        return $pdf->stream('perbandingan-hasil-evaluasi-diri_' . auth()->user()->homebase . '_' . Carbon::now()->format('d-m-Y') . '.pdf');
    }
}
