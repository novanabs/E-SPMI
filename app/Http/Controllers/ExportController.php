<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\AuditKriteria;
use App\Models\AuditorJurusan;
use App\Models\Kriteria;
use App\Models\MatriksLED;
use App\Models\User;
use App\Models\UsersMatrik;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use setasign\Fpdi\Fpdi;

class ExportController extends Controller
{
    public function previewPdf(Request $request)
    {
        // Ambil Tahun, Id Jurusan

        $jurusanId = $request->idJurusan;

        $jurusan = User::findOrFail($jurusanId);

        $auditHeader = Audit::where(
            'program_studi',
            $jurusanId
        )->latest()->first();

        // Ambil semua kriteria, tapi muat auditKriterias yang filternya sesuai jurusan_id
        $auditKriterias = Kriteria::with([
            'auditKriterias' => function ($query) use ($jurusanId) {
                $query->where('jurusan_id', $jurusanId);
            }
        ])->get();


        $auditor = AuditorJurusan::where('jurusan', $jurusan->homebase)
            ->get();




        $pdf = Pdf::loadView(
            'exports.audit-pdf',
            compact(
                'jurusan',
                'auditHeader',
                'auditKriterias',
                'auditors'
            )
        )->setPaper('a4', 'portrait');

        return $pdf->stream(
            'AMI_' .
            str_replace(' ', '_', $jurusan->homebase) .
            '.pdf'
        );
    }
    public function previewPdfOld()
    {




        $user = auth()->user();
        $userId = auth()->user()->id;
        $tahun = request('tahun');
        $logoPath = public_path('img/ulm.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $elemen = MatriksLED::with([
            'kriteria',
            'userMatrik' => function ($q) use ($userId, $tahun) {
                $q->where('id_users', $userId)->where('tahun', $tahun);
            }
        ])->orderBy('nomor', 'asc')->get();

        $totalNilai = $elemen->sum(function ($item) {
            return $item->userMatrik
                ? $item->userMatrik->jawaban * $item->poin
                : 0;
        });

        $masaBerlaku = match (true) {
            $totalNilai >= 361 => '5 Tahun',
            $totalNilai >= 301 => '4 Tahun',
            $totalNilai >= 200 => '3 Tahun',
            default => '-',
        };

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
        $tahun = request('tahun');

        $logoPath = public_path('img/ulm.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));


        $elemen = MatriksLED::with([
            'kriteria',
            'userMatrik' => function ($q) use ($userId, $tahun) {
                $q->where('id_users', $userId)->where('tahun', $tahun);
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
        $tahun = request('tahun');

        $userUpm = User::where('email', 'upmfkip1@ulm.ac.id')->first();
        $idJurusan = $userJurusan->id;
        $idUserUpm = $userUpm?->id;

        $auditorId = request('auditor_id');
        $showAuditor = $auditorId && (int) $auditorId === (int) $idJurusan;

        // Logo base64
        $logoPath = public_path('img/ulm.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $elemen = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userMatrik'       => function ($q) use ($idJurusan, $tahun) {
                $q->where('id_users', $idJurusan)->whereNull('id_user_jurusan')->where('tahun', $tahun);
            },
            'userMatrikByUser' => function ($q) use ($idUserUpm, $idJurusan, $tahun) {
                $q->where('id_users', $idUserUpm)
                    ->where('id_user_jurusan', $idJurusan)
                    ->where('tahun', $tahun);
            },
        ])
            ->orderBy('nomor', 'asc')
            ->get();

        // Load shared auditor scores if showing auditor
        $auditorScores = collect();
        $auditorTemuanSaran = collect();
        $auditorLabelMap = [];
        $auditorNameMap = [];
        $auditorNipMap = [];

        if ($showAuditor) {
            $auditorScores = UsersMatrik::where('id_users', $idJurusan)
                ->where('id_user_jurusan', $idJurusan)
                ->where('tahun', $tahun)
                ->get()
                ->keyBy('id_matriks_led');

            $auditorTemuanSaran = \DB::table('auditor_temuan_saran')
                ->where('id_user_jurusan', $idJurusan)
                ->get()
                ->groupBy('id_matriks_led');

            $auditorIds = \DB::table('auditor_jurusan')
                ->join('users', 'auditor_jurusan.user_id', '=', 'users.id')
                ->where('auditor_jurusan.jurusan', $userJurusan->homebase)
                ->where('users.role', 'auditor')
                ->where('auditor_jurusan.tahun_audit', $tahun)
                ->orderBy('auditor_jurusan.created_at')
                ->pluck('auditor_jurusan.user_id');

            $counter = 1;
            foreach ($auditorIds as $aid) {
                $u = User::find($aid);
                if ($u) {
                    $auditorLabelMap[$aid] = 'Auditor ' . $counter;
                    $auditorNameMap['Auditor ' . $counter] = $u->name;
                    $auditorNipMap['Auditor ' . $counter] = $u->nip ?? '';
                    $counter++;
                }
            }
        }

        /* ===============================
         * HITUNG AKUMULASI NILAI
         * =============================== */

        $totalJurusan = 0;
        $totalAuditor = 0;

        foreach ($elemen as $item) {
            $nilaiJurusan = data_get($item, 'userMatrik.nilai_total', 0);
            $totalJurusan += $nilaiJurusan;

            if ($showAuditor) {
                $nilaiAuditor = $auditorScores->get($item->id)?->nilai_total ?? 0;
                $totalAuditor += $nilaiAuditor;
            } else {
                $nilaiAuditor = data_get($item, 'userMatrikByUser.nilai_total', 0);
                $totalAuditor += $nilaiAuditor;
            }
        }

        // Selisih
        $selisih = abs($totalJurusan - $totalAuditor);

        /* ===============================
         * FUNGSI HITUNG AKREDITASI
         * =============================== */
        [$syarat3, $syarat5] = $this->computeSyaratForUser($idJurusan, $tahun);
        $hasilJurusan = $this->hitungAkreditasiDenganSyarat($totalJurusan, $syarat3, $syarat5);
        $hasilAuditor = $this->hitungAkreditasiDenganSyarat($totalAuditor, $syarat3, $syarat5);

        // Per-aspek data for chart
        [$perAspekJurusan, $perAspekAuditor, $perAspekMax] = $this->computePerAspekData($elemen, $showAuditor, $idJurusan, $idUserUpm, $auditorScores);
        $radarChart = $this->generateRadarChartBase64($perAspekJurusan, $perAspekAuditor, $perAspekMax, $showAuditor);

        return view('pdf.preview_perbandingan', [
            'logo'               => $logoBase64,
            'generated_by'       => $user->name,
            'tanggal'            => now()->translatedFormat('j F Y'),
            'waktu'              => now()->format('H:i:s'),

            'userJurusan'        => $userJurusan,
            'userUpm'            => $userUpm,

            'elemen'             => $elemen,
            'showAuditor'        => $showAuditor,
            'auditorScores'      => $auditorScores,
            'auditorTemuanSaran' => $auditorTemuanSaran,
            'auditorLabelMap'    => $auditorLabelMap,
            'auditorNameMap'     => $auditorNameMap,
            'auditorNipMap'      => $auditorNipMap,

            // HASIL PERHITUNGAN
            'totalJurusan'       => $totalJurusan,
            'totalAuditor'       => $totalAuditor,
            'selisih'            => $selisih,

            'statusJurusan'      => $hasilJurusan['status'],
            'masaJurusan'        => $hasilJurusan['masa'],

            'statusAuditor'      => $hasilAuditor['status'],
            'masaAuditor'        => $hasilAuditor['masa'],

            // Per-aspek untuk chart
            'perAspekJurusan'    => $perAspekJurusan,
            'perAspekAuditor'    => $perAspekAuditor,
            'perAspekMax'        => $perAspekMax,

            // Radar chart PNG (GD)
            'radarChart'         => $radarChart,
        ]);
    }


    public function exportPdfPerbandingan()
    {
        $user = auth()->user();
        $userJurusan = auth()->user();
        $tahun = request('tahun');

        $userUpm = User::where('email', 'upmfkip1@ulm.ac.id')->first();
        $idJurusan = $userJurusan->id;
        $idUserUpm = $userUpm?->id;

        $auditorId = request('auditor_id');
        $showAuditor = $auditorId && (int) $auditorId === (int) $idJurusan;

        // Logo base64 (cepat & aman untuk PDF)
        $logoPath = public_path('img/ulm.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $elemen = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userMatrik'       => function ($q) use ($idJurusan, $tahun) {
                $q->where('id_users', $idJurusan)->whereNull('id_user_jurusan')->where('tahun', $tahun);
            },
            'userMatrikByUser' => function ($q) use ($idUserUpm, $idJurusan, $tahun) {
                $q->where('id_users', $idUserUpm)
                    ->where('id_user_jurusan', $idJurusan)
                    ->where('tahun', $tahun);
            },
        ])
            ->orderBy('nomor', 'asc')
            ->get();

        // Load shared auditor scores if showing auditor
        $auditorScores = collect();
        $auditorTemuanSaran = collect();
        $auditorLabelMap = [];
        $auditorNameMap = [];
        $auditorNipMap = [];

        if ($showAuditor) {
            $auditorScores = UsersMatrik::where('id_users', $idJurusan)
                ->where('id_user_jurusan', $idJurusan)
                ->where('tahun', $tahun)
                ->get()
                ->keyBy('id_matriks_led');

            $auditorTemuanSaran = \DB::table('auditor_temuan_saran')
                ->where('id_user_jurusan', $idJurusan)
                ->get()
                ->groupBy('id_matriks_led');

            $auditorIds = \DB::table('auditor_jurusan')
                ->join('users', 'auditor_jurusan.user_id', '=', 'users.id')
                ->where('auditor_jurusan.jurusan', $userJurusan->homebase)
                ->where('users.role', 'auditor')
                ->where('auditor_jurusan.tahun_audit', $tahun)
                ->orderBy('auditor_jurusan.created_at')
                ->pluck('auditor_jurusan.user_id');

            $counter = 1;
            foreach ($auditorIds as $aid) {
                $u = User::find($aid);
                if ($u) {
                    $auditorLabelMap[$aid] = 'Auditor ' . $counter;
                    $auditorNameMap['Auditor ' . $counter] = $u->name;
                    $auditorNipMap['Auditor ' . $counter] = $u->nip ?? '';
                    $counter++;
                }
            }
        }

        /* ===============================
         * HITUNG AKUMULASI NILAI
         * =============================== */

        $totalJurusan = 0;
        $totalAuditor = 0;

        foreach ($elemen as $item) {
            $nilaiJurusan = data_get($item, 'userMatrik.nilai_total', 0);
            $totalJurusan += $nilaiJurusan;

            if ($showAuditor) {
                $nilaiAuditor = $auditorScores->get($item->id)?->nilai_total ?? 0;
                $totalAuditor += $nilaiAuditor;
            } else {
                $nilaiAuditor = data_get($item, 'userMatrikByUser.nilai_total', 0);
                $totalAuditor += $nilaiAuditor;
            }
        }

        // Selisih
        $selisih = abs($totalJurusan - $totalAuditor);

        /* ===============================
         * FUNGSI HITUNG AKREDITASI
         * =============================== */
        [$syarat3, $syarat5] = $this->computeSyaratForUser($idJurusan, $tahun);
        $hasilJurusan = $this->hitungAkreditasiDenganSyarat($totalJurusan, $syarat3, $syarat5);
        $hasilAuditor = $this->hitungAkreditasiDenganSyarat($totalAuditor, $syarat3, $syarat5);

        // Per-aspek data for chart
        [$perAspekJurusan, $perAspekAuditor, $perAspekMax] = $this->computePerAspekData($elemen, $showAuditor, $idJurusan, $idUserUpm, $auditorScores);
        $radarChart = $this->generateRadarChartBase64($perAspekJurusan, $perAspekAuditor, $perAspekMax, $showAuditor);

        $data = [
            'logo'               => $logoBase64,
            'generated_by'       => $user->name,
            'tanggal'            => now()->translatedFormat('j F Y'),
            'waktu'              => now()->format('H:i:s'),

            'userJurusan'        => $userJurusan,
            'userUpm'            => $userUpm,

            'elemen'             => $elemen,
            'showAuditor'        => $showAuditor,
            'auditorScores'      => $auditorScores,
            'auditorTemuanSaran' => $auditorTemuanSaran,
            'auditorLabelMap'    => $auditorLabelMap,
            'auditorNameMap'     => $auditorNameMap,
            'auditorNipMap'      => $auditorNipMap,

            // HASIL PERHITUNGAN
            'totalJurusan'       => $totalJurusan,
            'totalAuditor'       => $totalAuditor,
            'selisih'            => $selisih,

            'statusJurusan'      => $hasilJurusan['status'],
            'masaJurusan'        => $hasilJurusan['masa'],

            'statusAuditor'      => $hasilAuditor['status'],
            'masaAuditor'        => $hasilAuditor['masa'],

            // Per-aspek untuk chart
            'perAspekJurusan'    => $perAspekJurusan,
            'perAspekAuditor'    => $perAspekAuditor,
            'perAspekMax'        => $perAspekMax,

            // Radar chart PNG (GD)
            'radarChart'         => $radarChart,
        ];

        // Render portrait page + landscape pages, then merge
        $pdfPortrait = Pdf::loadView('pdf.preview_perbandingan_portrait', $data);
        $pdfPortrait->setPaper('A4', 'portrait');
        $outPortrait = $pdfPortrait->output();

        $pdfLandscape = Pdf::loadView('pdf.preview_perbandingan_landscape', $data);
        $pdfLandscape->setPaper('A4', 'landscape');
        $outLandscape = $pdfLandscape->output();

        $tmp1 = tempnam(sys_get_temp_dir(), 'pp_');
        $tmp2 = tempnam(sys_get_temp_dir(), 'pl_');
        file_put_contents($tmp1, $outPortrait);
        file_put_contents($tmp2, $outLandscape);

        $merged = new Fpdi();
        $pc = $merged->setSourceFile($tmp1);
        for ($i = 1; $i <= $pc; $i++) {
            $merged->AddPage('P');
            $tpl = $merged->importPage($i);
            $merged->useTemplate($tpl);
        }
        $pc = $merged->setSourceFile($tmp2);
        for ($i = 1; $i <= $pc; $i++) {
            $merged->AddPage('L');
            $tpl = $merged->importPage($i);
            $merged->useTemplate($tpl);
        }

        unlink($tmp1);
        unlink($tmp2);

        $fname = 'perbandingan-hasil-evaluasi-diri_' . auth()->user()->homebase . '_' . Carbon::now()->format('d-m-Y') . '.pdf';

        return response($merged->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fname . '"');
    }
    public function previewPdfPerbandinganUpm(string $id)
    {

        $tahun = request('tahun');

        $userUpm = User::where('email', 'upmfkip1@ulm.ac.id')->first();
        $userJurusan = User::findOrFail($id);
        $idJurusan = $userJurusan->id;
        $idUserUpm = $userUpm?->id;

        // Logo base64
        $logoPath = public_path('img/ulm.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $elemen = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userMatrik'       => function ($q) use ($idJurusan, $tahun) {
                $q->where('id_users', $idJurusan)->whereNull('id_user_jurusan')->where('tahun', $tahun);
            },
            'userMatrikByUser' => function ($q) use ($idUserUpm, $idJurusan, $tahun) {
                $q->where('id_users', $idUserUpm)
                    ->where('id_user_jurusan', $idJurusan)
                    ->where('tahun', $tahun);
            },
        ])
            ->orderBy('nomor', 'asc')
            ->get();

        $showAuditor = auth()->user()->role === 'auditor';

        $auditorScores = collect();
        $auditorTemuanSaran = collect();
        $auditorLabelMap = [];
        $auditorNameMap = [];
        $auditorNipMap = [];

        if ($showAuditor) {
            $auditorScores = UsersMatrik::where('id_users', $idJurusan)
                ->where('id_user_jurusan', $idJurusan)
                ->where('tahun', $tahun)
                ->get()
                ->keyBy('id_matriks_led');

            $auditorTemuanSaran = \DB::table('auditor_temuan_saran')
                ->where('id_user_jurusan', $idJurusan)
                ->get()
                ->groupBy('id_matriks_led');

            $auditorIds = \DB::table('auditor_jurusan')
                ->join('users', 'auditor_jurusan.user_id', '=', 'users.id')
                ->where('auditor_jurusan.jurusan', $userJurusan->homebase)
                ->where('users.role', 'auditor')
                ->where('auditor_jurusan.tahun_audit', $tahun)
                ->orderBy('auditor_jurusan.created_at')
                ->pluck('auditor_jurusan.user_id');

            $counter = 1;
            foreach ($auditorIds as $aid) {
                $u = User::find($aid);
                if ($u) {
                    $auditorLabelMap[$aid] = 'Auditor ' . $counter;
                    $auditorNameMap['Auditor ' . $counter] = $u->name;
                    $auditorNipMap['Auditor ' . $counter] = $u->nip ?? '';
                    $counter++;
                }
            }
        }

        /* ===============================
         * HITUNG AKUMULASI NILAI
         * =============================== */

        $totalJurusan = 0;
        $totalAuditor = 0;

        foreach ($elemen as $item) {
            $nilaiJurusan = data_get($item, 'userMatrik.nilai_total', 0);
            $totalJurusan += $nilaiJurusan;

            if ($showAuditor) {
                $nilaiAuditor = $auditorScores->get($item->id)?->nilai_total ?? 0;
                $totalAuditor += $nilaiAuditor;
            } else {
                $nilaiAuditor = data_get($item, 'userMatrikByUser.nilai_total', 0);
                $totalAuditor += $nilaiAuditor;
            }
        }

        // Selisih
        $selisih = abs($totalJurusan - $totalAuditor);

        /* ===============================
         * FUNGSI HITUNG AKREDITASI
         * =============================== */
        [$syarat3, $syarat5] = $this->computeSyaratForUser($idJurusan, $tahun);
        $hasilJurusan = $this->hitungAkreditasiDenganSyarat($totalJurusan, $syarat3, $syarat5);
        $hasilAuditor = $this->hitungAkreditasiDenganSyarat($totalAuditor, $syarat3, $syarat5);

        // Per-aspek data for chart
        [$perAspekJurusan, $perAspekAuditor, $perAspekMax] = $this->computePerAspekData($elemen, $showAuditor, $idJurusan, $idUserUpm, $auditorScores);
        $radarChart = $this->generateRadarChartBase64($perAspekJurusan, $perAspekAuditor, $perAspekMax, $showAuditor);

        return view('pdf.preview_perbandingan', [
            'logo'               => $logoBase64,
            'generated_by'       => $userJurusan->name,
            'tanggal'            => now()->translatedFormat('j F Y'),
            'waktu'              => now()->format('H:i:s'),

            'userJurusan'        => $userJurusan,
            'userUpm'            => $userUpm,

            'elemen'             => $elemen,
            'showAuditor'        => $showAuditor,
            'auditorScores'      => $auditorScores,
            'auditorTemuanSaran' => $auditorTemuanSaran,
            'auditorLabelMap'    => $auditorLabelMap,
            'auditorNameMap'     => $auditorNameMap,
            'auditorNipMap'      => $auditorNipMap,

            // HASIL PERHITUNGAN
            'totalJurusan'       => $totalJurusan,
            'totalAuditor'       => $totalAuditor,
            'selisih'            => $selisih,

            'statusJurusan'      => $hasilJurusan['status'],
            'masaJurusan'        => $hasilJurusan['masa'],

            'statusAuditor'      => $hasilAuditor['status'],
            'masaAuditor'        => $hasilAuditor['masa'],

            // Per-aspek untuk chart
            'perAspekJurusan'    => $perAspekJurusan,
            'perAspekAuditor'    => $perAspekAuditor,
            'perAspekMax'        => $perAspekMax,

            // Radar chart PNG (GD)
            'radarChart'         => $radarChart,
        ]);
    }


    public function exportPdfPerbandinganUpm(string $id)
    {
        $tahun = request('tahun');

        $userUpm = User::where('email', 'upmfkip1@ulm.ac.id')->first();
        $userJurusan = User::findOrFail($id);
        $idJurusan = $userJurusan->id;
        $idUserUpm = $userUpm?->id;

        // Logo base64
        $logoPath = public_path('img/ulm.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        $elemen = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userMatrik'       => function ($q) use ($idJurusan, $tahun) {
                $q->where('id_users', $idJurusan)->whereNull('id_user_jurusan')->where('tahun', $tahun);
            },
            'userMatrikByUser' => function ($q) use ($idUserUpm, $idJurusan, $tahun) {
                $q->where('id_users', $idUserUpm)
                    ->where('id_user_jurusan', $idJurusan)
                    ->where('tahun', $tahun);
            },
        ])
            ->orderBy('nomor', 'asc')
            ->get();

        $showAuditor = auth()->user()->role === 'auditor';

        $auditorScores = collect();
        $auditorTemuanSaran = collect();
        $auditorLabelMap = [];
        $auditorNameMap = [];
        $auditorNipMap = [];

        if ($showAuditor) {
            $auditorScores = UsersMatrik::where('id_users', $idJurusan)
                ->where('id_user_jurusan', $idJurusan)
                ->where('tahun', $tahun)
                ->get()
                ->keyBy('id_matriks_led');

            $auditorTemuanSaran = \DB::table('auditor_temuan_saran')
                ->where('id_user_jurusan', $idJurusan)
                ->get()
                ->groupBy('id_matriks_led');

            $auditorIds = \DB::table('auditor_jurusan')
                ->join('users', 'auditor_jurusan.user_id', '=', 'users.id')
                ->where('auditor_jurusan.jurusan', $userJurusan->homebase)
                ->where('users.role', 'auditor')
                ->where('auditor_jurusan.tahun_audit', $tahun)
                ->orderBy('auditor_jurusan.created_at')
                ->pluck('auditor_jurusan.user_id');

            $counter = 1;
            foreach ($auditorIds as $aid) {
                $u = User::find($aid);
                if ($u) {
                    $auditorLabelMap[$aid] = 'Auditor ' . $counter;
                    $auditorNameMap['Auditor ' . $counter] = $u->name;
                    $auditorNipMap['Auditor ' . $counter] = $u->nip ?? '';
                    $counter++;
                }
            }
        }

        /* ===============================
         * HITUNG AKUMULASI NILAI
         * =============================== */

        $totalJurusan = 0;
        $totalAuditor = 0;

        foreach ($elemen as $item) {
            $nilaiJurusan = data_get($item, 'userMatrik.nilai_total', 0);
            $totalJurusan += $nilaiJurusan;

            if ($showAuditor) {
                $nilaiAuditor = $auditorScores->get($item->id)?->nilai_total ?? 0;
                $totalAuditor += $nilaiAuditor;
            } else {
                $nilaiAuditor = data_get($item, 'userMatrikByUser.nilai_total', 0);
                $totalAuditor += $nilaiAuditor;
            }
        }

        // Selisih
        $selisih = abs($totalJurusan - $totalAuditor);

        /* ===============================
         * FUNGSI HITUNG AKREDITASI
         * =============================== */
        [$syarat3, $syarat5] = $this->computeSyaratForUser($idJurusan, $tahun);
        $hasilJurusan = $this->hitungAkreditasiDenganSyarat($totalJurusan, $syarat3, $syarat5);
        $hasilAuditor = $this->hitungAkreditasiDenganSyarat($totalAuditor, $syarat3, $syarat5);

        // Per-aspek data for chart
        [$perAspekJurusan, $perAspekAuditor, $perAspekMax] = $this->computePerAspekData($elemen, $showAuditor, $idJurusan, $idUserUpm, $auditorScores);
        $radarChart = $this->generateRadarChartBase64($perAspekJurusan, $perAspekAuditor, $perAspekMax, $showAuditor);

        $data = [
            'logo'               => $logoBase64,
            'generated_by'       => $userJurusan->name,
            'tanggal'            => now()->translatedFormat('j F Y'),
            'waktu'              => now()->format('H:i:s'),

            'userJurusan'        => $userJurusan,
            'userUpm'            => $userUpm,

            'elemen'             => $elemen,
            'showAuditor'        => $showAuditor,
            'auditorScores'      => $auditorScores,
            'auditorTemuanSaran' => $auditorTemuanSaran,
            'auditorLabelMap'    => $auditorLabelMap,
            'auditorNameMap'     => $auditorNameMap,
            'auditorNipMap'      => $auditorNipMap,

            // HASIL PERHITUNGAN
            'totalJurusan'       => $totalJurusan,
            'totalAuditor'       => $totalAuditor,
            'selisih'            => $selisih,

            'statusJurusan'      => $hasilJurusan['status'],
            'masaJurusan'        => $hasilJurusan['masa'],

            'statusAuditor'      => $hasilAuditor['status'],
            'masaAuditor'        => $hasilAuditor['masa'],

            // Per-aspek untuk chart
            'perAspekJurusan'    => $perAspekJurusan,
            'perAspekAuditor'    => $perAspekAuditor,
            'perAspekMax'        => $perAspekMax,

            // Radar chart PNG (GD)
            'radarChart'         => $radarChart,
        ];

        // Render portrait page + landscape pages, then merge
        $pdfPortrait = Pdf::loadView('pdf.preview_perbandingan_portrait', $data);
        $pdfPortrait->setPaper('A4', 'portrait');
        $outPortrait = $pdfPortrait->output();

        $pdfLandscape = Pdf::loadView('pdf.preview_perbandingan_landscape', $data);
        $pdfLandscape->setPaper('A4', 'landscape');
        $outLandscape = $pdfLandscape->output();

        $tmp1 = tempnam(sys_get_temp_dir(), 'pp_');
        $tmp2 = tempnam(sys_get_temp_dir(), 'pl_');
        file_put_contents($tmp1, $outPortrait);
        file_put_contents($tmp2, $outLandscape);

        $merged = new Fpdi();
        $pc = $merged->setSourceFile($tmp1);
        for ($i = 1; $i <= $pc; $i++) {
            $merged->AddPage('P');
            $tpl = $merged->importPage($i);
            $merged->useTemplate($tpl);
        }
        $pc = $merged->setSourceFile($tmp2);
        for ($i = 1; $i <= $pc; $i++) {
            $merged->AddPage('L');
            $tpl = $merged->importPage($i);
            $merged->useTemplate($tpl);
        }

        unlink($tmp1);
        unlink($tmp2);

        $fname = 'perbandingan-hasil-evaluasi-diri_' . auth()->user()->homebase . '_' . Carbon::now()->format('d-m-Y') . '.pdf';

        return response($merged->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $fname . '"');
    }

    private function generateRadarChartBase64($perAspekJurusan, $perAspekAuditor, $perAspekMax, $showAuditor): string
    {
        $labels = array_keys($perAspekJurusan);
        $n = count($labels);
        if ($n === 0)
            return '';

        $pctJur = [];
        $pctAud = [];
        foreach ($labels as $lbl) {
            $max = ($perAspekMax[$lbl] ?? 1);
            $max = $max > 0 ? $max : 1;
            $pctJur[] = min(100, round(($perAspekJurusan[$lbl] / $max) * 100));
            $pctAud[] = min(100, round((($perAspekAuditor[$lbl] ?? 0) / $max) * 100));
        }

        $width = 520;
        $height = 480;
        $cx = 250;
        $cy = 225;
        $r = 170;

        $img = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($img, 255, 255, 255);
        imagefill($img, 0, 0, $bg);

        $gridColor = imagecolorallocate($img, 200, 200, 200);
        $axisColor = imagecolorallocate($img, 180, 180, 180);
        $textColor = imagecolorallocate($img, 0, 0, 0);
        $jurColor = imagecolorallocate($img, 23, 59, 112);
        $audColor = imagecolorallocate($img, 212, 160, 48);
        $jurFill = imagecolorallocate($img, 220, 230, 242);
        $audFill = imagecolorallocate($img, 255, 242, 217);

        $angles = [];
        for ($i = 0; $i < $n; $i++) {
            $angles[] = -M_PI / 2 + $i * 2 * M_PI / $n;
        }

        $levels = [0.2, 0.4, 0.6, 0.8, 1.0];

        // Build polygon arrays first
        $ptsJur = [];
        $ptsAud = [];
        for ($i = 0; $i < $n; $i++) {
            $ptsJur[] = $cx + $r * ($pctJur[$i] / 100) * cos($angles[$i]);
            $ptsJur[] = $cy + $r * ($pctJur[$i] / 100) * sin($angles[$i]);
            $ptsAud[] = $cx + $r * ($pctAud[$i] / 100) * cos($angles[$i]);
            $ptsAud[] = $cy + $r * ($pctAud[$i] / 100) * sin($angles[$i]);
        }

        // 1. Grid polygons (draw first, behind everything)
        foreach ($levels as $lv) {
            $pts = [];
            for ($i = 0; $i < $n; $i++) {
                $pts[] = $cx + $r * $lv * cos($angles[$i]);
                $pts[] = $cy + $r * $lv * sin($angles[$i]);
            }
            if ($n >= 3) {
                imagepolygon($img, $pts, $gridColor);
            }
        }

        // 2. Axis lines
        for ($i = 0; $i < $n; $i++) {
            $x2 = $cx + $r * cos($angles[$i]);
            $y2 = $cy + $r * sin($angles[$i]);
            imageline($img, $cx, $cy, (int) $x2, (int) $y2, $axisColor);
        }

        // 3. Data polygons (fill + outline)
        if ($n >= 3) {
            imagefilledpolygon($img, $ptsJur, $jurFill);
            imagefilledpolygon($img, $ptsAud, $audFill);
            imagepolygon($img, $ptsJur, $jurColor);
            imagepolygon($img, $ptsAud, $audColor);
        }

        // 4. Y-axis labels (on top)
        foreach ($levels as $lv) {
            $pct = $lv * 100;
            $yy = $cy - $r * $lv;
            $label = "{$pct}%";
            $fw = imagefontwidth(2) * strlen($label);
            imagestring($img, 2, (int) ($cx - $fw / 2), (int) ($yy - 8), $label, $textColor);
        }
        $zLabel = '0%';
        $zFw = imagefontwidth(2) * strlen($zLabel);
        imagestring($img, 2, (int) ($cx - $zFw / 2), (int) ($cy - 8), $zLabel, $textColor);

        // 5. Data point circles (on top of everything)
        for ($i = 0; $i < $n; $i++) {
            $xj = $cx + $r * ($pctJur[$i] / 100) * cos($angles[$i]);
            $yj = $cy + $r * ($pctJur[$i] / 100) * sin($angles[$i]);
            imagefilledellipse($img, (int) round($xj), (int) round($yj), 8, 8, $jurColor);

            $xa = $cx + $r * ($pctAud[$i] / 100) * cos($angles[$i]);
            $ya = $cy + $r * ($pctAud[$i] / 100) * sin($angles[$i]);
            imagefilledellipse($img, (int) round($xa), (int) round($ya), 8, 8, $audColor);
        }

        // 6. Kriteria labels
        $labelOffset = 22;
        for ($i = 0; $i < $n; $i++) {
            $lx = $cx + ($r + $labelOffset) * cos($angles[$i]);
            $ly = $cy + ($r + $labelOffset) * sin($angles[$i]);
            $label = $labels[$i];
            $fw = imagefontwidth(2) * strlen($label);
            $fh = imagefontheight(2);

            $ax = (int) round($lx);
            $ay = (int) round($ly);
            if (cos($angles[$i]) > 0.1) {
                $ax = (int) round($lx);
            } elseif (cos($angles[$i]) < -0.1) {
                $ax = (int) round($lx - $fw);
            } else {
                $ax = (int) round($lx - $fw / 2);
            }
            if (sin($angles[$i]) > 0.1) {
                $ay = (int) round($ly + $fh);
            } elseif (sin($angles[$i]) < -0.1) {
                $ay = (int) round($ly);
            } else {
                $ay = (int) round($ly - $fh / 2);
            }

            imagestring($img, 2, $ax, $ay, $label, $textColor);
        }

        // 7. Legend
        imagefilledrectangle($img, 130, 440, 144, 454, $jurColor);
        imagestring($img, 2, 148, 442, 'Jurusan', $textColor);
        imagefilledrectangle($img, 270, 440, 284, 454, $audColor);
        imagestring($img, 2, 288, 442, $showAuditor ? 'Auditor' : 'UPM', $textColor);

        ob_start();
        imagepng($img);
        $data = ob_get_clean();
        imagedestroy($img);

        return 'data:image/png;base64,' . base64_encode($data);
    }

    private function computePerAspekData($elemen, $showAuditor, $idJurusan, $idUserUpm, $auditorScores)
    {
        $perAspekJurusan = [];
        $perAspekMax = [];

        foreach ($elemen as $item) {
            $nama = $item->kriteria->name ?? '-';
            $perAspekJurusan[$nama] = ($perAspekJurusan[$nama] ?? 0) + (float) (data_get($item, 'userMatrik.nilai_total') ?: 0);
        }

        $perAspekAuditor = [];
        foreach ($elemen as $item) {
            $nama = $item->kriteria->name ?? '-';
            if ($showAuditor) {
                $nilai = (float) ($auditorScores->get($item->id)?->nilai_total ?? 0);
            } else {
                $nilai = (float) (data_get($item, 'userMatrikByUser.nilai_total') ?: 0);
            }
            $perAspekAuditor[$nama] = ($perAspekAuditor[$nama] ?? 0) + $nilai;
        }

        foreach ($elemen->groupBy('id_kriteria') as $items) {
            $nama = $items->first()->kriteria->name ?? '-';
            $perAspekMax[$nama] = $items->sum(fn($i) => ($i->poin ?? 0) * 4);
        }

        return [$perAspekJurusan, $perAspekAuditor, $perAspekMax];
    }

    private function computeSyaratForUser(int $userId, $tahun = null): array
    {
        $dataSyaratUnggul = \App\Models\SyaratUnggul::with([
            'matriks.subItemElemen',
            'matriks.userSubItemElements' => function ($q) use ($userId, $tahun) {
                $q->where('id_users', $userId)->where('tahun', $tahun);
            },
            'matriks.userMatrik'          => function ($q) use ($userId, $tahun) {
                $q->where('id_users', $userId)->where('tahun', $tahun);
            },
        ])->get();

        $syarat3 = true;
        $syarat5 = true;

        foreach ($dataSyaratUnggul as $item) {
            $matriks = $item->matriks;
            if (!$matriks)
                continue;

            $subItems = $matriks->subItemElemen ?? collect();
            $userValues = $matriks->userSubItemElements ?? collect();
            $nilaiMap = $userValues->pluck('nilai', 'id_sub_item_elemen');

            $m3 = false;
            $m5 = false;

            if ($item->nomor == 1) {
                $NDS3 = $NDL = $NDLK = $NDGB = 0;
                foreach ($subItems as $sub) {
                    $n = (float) ($nilaiMap[$sub->id] ?? 0);
                    if ($sub->variabel == 'NDS3')
                        $NDS3 = $n;
                    if ($sub->variabel == 'NDL')
                        $NDL = $n;
                    if ($sub->variabel == 'NDLK')
                        $NDLK = $n;
                    if ($sub->variabel == 'NDGB')
                        $NDGB = $n;
                }
                $totalLektor = $NDL + $NDLK + $NDGB;
                $m3 = $NDS3 >= 1 && $totalLektor >= 2;
                $m5 = $NDS3 >= 2 && $totalLektor >= 2 && $NDLK >= 1;
            } elseif (in_array($item->nomor, [2, 3, 4])) {
                $jawaban = (float) ($matriks->userMatrik?->jawaban ?? 0);
                $m3 = $jawaban >= 3.0;
                $m5 = $jawaban >= 3.5;
            } elseif ($item->nomor == 5) {
                $NM = 0;
                $S1 = $S2 = $S3 = $S4 = $S5 = $S6 = 0;
                $INT = $ISBN = $PATEN = 0;
                foreach ($subItems as $sub) {
                    $n = (float) ($nilaiMap[$sub->id] ?? 0);
                    if ($sub->variabel == 'NM')
                        $NM = $n;
                    if ($sub->variabel == 'SINTA1_MHS')
                        $S1 = $n;
                    if ($sub->variabel == 'SINTA2_MHS')
                        $S2 = $n;
                    if ($sub->variabel == 'SINTA3_MHS')
                        $S3 = $n;
                    if ($sub->variabel == 'SINTA4_MHS')
                        $S4 = $n;
                    if ($sub->variabel == 'SINTA5_MHS')
                        $S5 = $n;
                    if ($sub->variabel == 'SINTA6_MHS')
                        $S6 = $n;
                    if ($sub->variabel == 'INT_MHS')
                        $INT = $n;
                    if ($sub->variabel == 'ISBN_MHS')
                        $ISBN = $n;
                    if ($sub->variabel == 'PATEN_MHS')
                        $PATEN = $n;
                }
                if ($NM > 0) {
                    $total3 = $S1 + $S2 + $S3 + $S4 + $S5 + $INT + $ISBN + $PATEN;
                    $persen3 = ($total3 / $NM) * 100;
                    $m3 = $persen3 >= 15;
                    $total5 = $S1 + $S2 + $S3 + $S4 + $INT + $ISBN + $PATEN;
                    $persen5 = ($total5 / $NM) * 100;
                    $m5 = $persen5 >= 25;
                }
            } elseif ($item->nomor == 6) {
                $NDTPS = 0;
                $S4 = $S3 = $S2 = $S1 = $INT = 0;
                foreach ($subItems as $sub) {
                    $n = (float) ($nilaiMap[$sub->id] ?? 0);
                    if ($sub->variabel == 'NDTPS')
                        $NDTPS = $n;
                    if ($sub->variabel == 'S4_DTPS')
                        $S4 = $n;
                    if ($sub->variabel == 'S3_DTPS')
                        $S3 = $n;
                    if ($sub->variabel == 'S2_DTPS')
                        $S2 = $n;
                    if ($sub->variabel == 'S1_DTPS')
                        $S1 = $n;
                    if ($sub->variabel == 'INT_DTPS')
                        $INT = $n;
                }
                if ($NDTPS > 0) {
                    $total3 = $S4 + $S3 + $S2 + $S1 + $INT;
                    $total5 = $S2 + $S1 + $INT;
                    $persen3 = ($total3 / $NDTPS) * 100;
                    $persen5 = ($total5 / $NDTPS) * 100;
                    $m3 = $persen3 >= 20;
                    $m5 = $persen5 >= 20;
                }
            }

            if (!$m3)
                $syarat3 = false;
            if (!$m5)
                $syarat5 = false;
        }

        return [$syarat3, $syarat5];
    }

    private function hitungAkreditasiDenganSyarat(float $nilai, bool $syarat3, bool $syarat5): array
    {
        if ($nilai >= 361) {
            if ($syarat5)
                return ['status' => 'Terakreditasi Unggul', 'masa' => '5 Tahun'];
            if ($syarat3)
                return ['status' => 'Terakreditasi Unggul', 'masa' => '3 Tahun'];
            return ['status' => 'Terakreditasi', 'masa' => '5 Tahun'];
        }
        if ($nilai >= 321) {
            if ($syarat5)
                return ['status' => 'Terakreditasi Unggul', 'masa' => '5 Tahun'];
            if ($syarat3)
                return ['status' => 'Terakreditasi Unggul', 'masa' => '3 Tahun'];
            return ['status' => 'Terakreditasi', 'masa' => '5 Tahun'];
        }
        if ($nilai >= 200) {
            return ['status' => 'Terakreditasi', 'masa' => '5 Tahun'];
        }
        return ['status' => 'Tidak Terakreditasi', 'masa' => '-'];
    }
}
