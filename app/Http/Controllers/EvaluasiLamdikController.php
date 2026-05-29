<?php

namespace App\Http\Controllers;

use App\Models\AuditorJurusan;
use App\Models\MatriksLED;
use App\Models\SubItemElemen;
use App\Models\SyaratUnggul;
use App\Models\User;
use App\Models\UsersMatrik;
use App\Models\UserSubItemElemen;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class EvaluasiLamdikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUser = auth()->id();


        $data = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userSubItemElements' => function ($q) use ($idUser) {
                $q->where('id_users', $idUser)->whereNull('id_user_jurusan');
            },
            'userMatrik' => function ($q) use ($idUser) {
                $q->where('id_users', $idUser)->whereNull('id_user_jurusan');
            }
        ])->orderBy('nomor', 'asc')->get();

        // dd($data->first()->userMatrik->nilai_total);

        // Ini untuk mengetahui syarat unggul

        $dataSyaratUnggul = SyaratUnggul::with([
            'matriks.subItemElemen',
            'matriks.userSubItemElements' => function ($q) use ($idUser) {
                $q->where('id_users', $idUser)->whereNull('id_user_jurusan');
            },
            'matriks.userMatrik' => function ($q) use ($idUser) {
                $q->where('id_users', $idUser)->whereNull('id_user_jurusan');
            }
        ])->get();

        foreach ($dataSyaratUnggul as $item) {

            $item->memenuhi_3_tahun = false;
            $item->memenuhi_5_tahun = false;

            $matriks = $item->matriks;

            if (!$matriks)
                continue;

            /* =========================
               🔥 AMBIL RELASI (FIX)
            ========================= */
            $subItems = $matriks->subItemElemen ?? collect();
            $userValues = $matriks->userSubItemElements ?? collect();

            // 🔥 mapping id_sub_item → nilai
            $nilaiMap = $userValues->pluck('nilai', 'id_sub_item_elemen');

            /* =========================
               🔥 ELEMEN 1
            ========================= */
            if ($item->nomor == 1) {

                $NDS3 = $NDL = $NDLK = $NDGB = 0;

                foreach ($subItems as $sub) {
                    $id = $sub->id;
                    $var = $sub->variabel;
                    $nilai = (float) ($nilaiMap[$id] ?? 0);

                    if ($var == 'NDS3')
                        $NDS3 = $nilai;
                    if ($var == 'NDL')
                        $NDL = $nilai;
                    if ($var == 'NDLK')
                        $NDLK = $nilai;
                    if ($var == 'NDGB')
                        $NDGB = $nilai;
                }

                $totalLektor = $NDL + $NDLK + $NDGB;

                if ($NDS3 >= 1 && $totalLektor >= 2) {
                    $item->memenuhi_3_tahun = true;
                }

                if ($NDS3 >= 2 && $totalLektor >= 2 && $NDLK >= 1) {
                    $item->memenuhi_5_tahun = true;
                }
            }

            /* =========================
               🔥 ELEMEN 2,3,4
            ========================= */ elseif (in_array($item->nomor, [2, 3, 4])) {

                $nilai = (float) ($matriks->userMatrik->jawaban ?? 0);

                if ($nilai >= 3.0)
                    $item->memenuhi_3_tahun = true;
                if ($nilai >= 3.5)
                    $item->memenuhi_5_tahun = true;
            }

            /* =========================
      🔥 ELEMEN 5
   ========================= */ elseif ($item->nomor == 5) {

                $NM = 0;

                // 🔥 Mahasiswa
                $S1 = $S2 = $S3 = $S4 = $S5 = $S6 = 0;
                $INT = $ISBN = $PATEN = 0;

                foreach ($subItems as $sub) {

                    $id = $sub->id;
                    $var = $sub->variabel;

                    $nilai = (float) ($nilaiMap[$id] ?? 0);

                    if ($var == 'NM')
                        $NM = $nilai;

                    if ($var == 'SINTA1_MHS')
                        $S1 = $nilai;
                    if ($var == 'SINTA2_MHS')
                        $S2 = $nilai;
                    if ($var == 'SINTA3_MHS')
                        $S3 = $nilai;
                    if ($var == 'SINTA4_MHS')
                        $S4 = $nilai;
                    if ($var == 'SINTA5_MHS')
                        $S5 = $nilai;
                    if ($var == 'SINTA6_MHS')
                        $S6 = $nilai;

                    if ($var == 'INT_MHS')
                        $INT = $nilai;
                    if ($var == 'ISBN_MHS')
                        $ISBN = $nilai;
                    if ($var == 'PATEN_MHS')
                        $PATEN = $nilai;
                }

                if ($NM > 0) {

                    /*
                    =========================
                    🔥 3 Tahun
                    Minimal Sinta 5
                    =========================
                    */
                    $total3 =
                        $S1 + $S2 + $S3 + $S4 + $S5 +
                        $INT + $ISBN + $PATEN;

                    $persen3 = ($total3 / $NM) * 100;

                    if ($persen3 >= 15) {
                        $item->memenuhi_3_tahun = true;
                    }

                    /*
                    =========================
                    🔥 5 Tahun
                    Minimal Sinta 4
                    =========================
                    */
                    $total5 =
                        $S1 + $S2 + $S3 + $S4 +
                        $INT + $ISBN + $PATEN;

                    $persen5 = ($total5 / $NM) * 100;

                    if ($persen5 >= 25) {
                        $item->memenuhi_5_tahun = true;
                    }
                }
            }

            /* =========================
               🔥 ELEMEN 6
            ========================= */ elseif ($item->nomor == 6) {

                $NDTPS = 0;
                $NDTPS_PUB = 0;

                foreach ($subItems as $sub) {
                    $id = $sub->id;
                    $var = $sub->variabel;
                    $nilai = (float) ($nilaiMap[$id] ?? 0);

                    if ($var == 'NDTPS') $NDTPS = $nilai;
                    if ($var == 'NDTPS_PUB') $NDTPS_PUB = $nilai;
                }

                if ($NDTPS > 0) {
                    $persen3 = ($NDTPS_PUB / $NDTPS) * 100;
                    $persen5 = $persen3;
                    if ($persen3 >= 20) {
                        $item->memenuhi_3_tahun = true;
                    }
                    if ($persen5 >= 20) {
                        $item->memenuhi_5_tahun = true;
                    }
                }
            }
        }

        /* =========================
           🔥 GLOBAL CHECK
        ========================= */
        $syarat3 = $dataSyaratUnggul->every(fn($i) => $i->memenuhi_3_tahun);
        $syarat5 = $dataSyaratUnggul->every(fn($i) => $i->memenuhi_5_tahun);

        /* =========================
           🔥 DEBUG
        ========================= */
        // dd($data->map(function ($i) {
        //     return [
        //         'elemen'  => $i->nomor,
        //         '3_tahun' => $i->memenuhi_3_tahun,
        //         '5_tahun' => $i->memenuhi_5_tahun,
        //     ];
        // }), $syarat3, $syarat5);

        // dd($syarat3, $syarat5);

        // nanti baru return view
        // return view('syarat.index', compact('data', 'syarat3', 'syarat5'));

        $dataUnggul = SyaratUnggul::with([
            'matriks.subItemElemen',
            'matriks.userSubItemElements' => function ($q) use ($idUser) {
                $q->where('id_users', $idUser);
            },
            'matriks.userMatrik'          => function ($q) use ($idUser) {
                $q->where('id_users', $idUser);
            }
        ])->get();


        return view('EvaluasiLamdik.index', compact('data', 'syarat3', 'syarat5', 'dataUnggul'));
    }

    public function indexOld()
    {
        return view('EvaluasiLamdik.indexOld');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request);

        $validated = $request->validate([
            'jawaban'              => 'required|numeric',
            'skor_a'               => 'nullable|numeric|min:0|max:4',
            'skor_b'               => 'nullable|numeric|min:0|max:4',
            'link_bukti'           => 'nullable|url',
            'temuan'               => 'nullable',
            'saran'                => 'nullable',
            'nilai_total'          => 'required|numeric',
            'id_matriks_led'       => 'required|integer',
            'kepemilikan_kriteria' => 'required|string|in:jurusan,fakultas',
            'id_users'             => 'required|integer',
        ]);

        UsersMatrik::updateOrCreate(
            [
                'id_users'       => $validated['id_users'],
                'id_matriks_led' => $validated['id_matriks_led'],
                'id_user_jurusan' => null,
            ],
            $validated
        );

        // dd($request->variabel);

        if (!empty($request->variabel)) {

            $idUserJurusan = null;

            DB::transaction(function () use ($request, $idUserJurusan) {

                foreach ($request->variabel as $idSubItem => $nilai) {

                    // skip kosong
                    if ($nilai === null || $nilai === '') {
                        continue;
                    }

                    UserSubItemElemen::updateOrCreate(
                        [
                            'id_matriks'         => $request->id_matriks_led,
                            'id_sub_item_elemen' => $idSubItem,
                            'id_users'           => $request->id_users,
                            'id_user_jurusan'    => null,
                        ],
                        [
                            'nilai'           => $nilai,
                            'id_user_jurusan' => $idUserJurusan,
                        ]
                    );
                }
            });
        }

        return redirect()->route('evaluasi_lamdik.index')
            ->with('success', 'Data berhasil diperbarui');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $idJurusan)
    {
        $userJurusan = User::findOrFail($idJurusan);

        // Load UPM as default comparison
        $userUpm = User::where('email', 'upmfkip1@ulm.ac.id')->first();

        // Build auditors collection: UPM + shared Auditor (virtual entry using jurusan's ID)
        $auditors = collect();
        if ($userUpm) {
            $userUpm->auditor_label = 'Penilaian UPM';
            $auditors->push($userUpm);
        }
        $auditorVirtual = (object) [
            'id' => $idJurusan,
            'name' => 'Auditor',
            'auditor_label' => 'Auditor',
        ];
        $auditors->push($auditorVirtual);

        // Load jurusan self-evaluation data
        $data = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userMatrik' => function ($q) use ($idJurusan) {
                $q->where('id_users', $idJurusan)->whereNull('id_user_jurusan');
            },
        ])->orderBy('nomor', 'asc')->get();

        // Load shared auditor scores: id_users = jurusan_id, id_user_jurusan = jurusan_id
        // and UPM scores: id_users = upm_id, id_user_jurusan = jurusan_id
        $auditorIds = $auditors->pluck('id');
        $allAuditorScores = UsersMatrik::where('id_user_jurusan', $idJurusan)
            ->whereIn('id_users', $auditorIds)
            ->get()
            ->groupBy('id_matriks_led');

        // Build a lookup: [id_matriks_led][id_users] => UsersMatrik
        $auditorScores = [];
        foreach ($allAuditorScores as $matriksId => $scores) {
            foreach ($scores as $score) {
                $auditorScores[$matriksId][$score->id_users] = $score;
            }
        }

        // Load combined temuan/saran from auditor_temuan_saran for display
        $allTemuanSaran = \DB::table('auditor_temuan_saran')
            ->join('users', 'auditor_temuan_saran.id_users', '=', 'users.id')
            ->where('auditor_temuan_saran.id_user_jurusan', $idJurusan)
            ->select('auditor_temuan_saran.*', 'users.name as auditor_name')
            ->get()
            ->groupBy('id_matriks_led');

        // Build auditor numbering ("Auditor 1", "Auditor 2") and name mapping
        // Order by auditor_jurusan.created_at to ensure consistent display order
        $auditorIdsWithData = \DB::table('auditor_jurusan')
            ->join('users', 'auditor_jurusan.user_id', '=', 'users.id')
            ->where('auditor_jurusan.jurusan', $userJurusan->homebase)
            ->where('users.role', 'auditor')
            ->orderBy('auditor_jurusan.created_at')
            ->pluck('auditor_jurusan.user_id');

        $auditorLabelMap = []; // [userId => 'Auditor 1']
        $auditorNameMap = [];  // ['Auditor 1' => 'Madhan, SPd.']
        $counter = 1;
        foreach ($auditorIdsWithData as $aid) {
            $user = User::find($aid);
            if ($user) {
                $label = 'Auditor ' . $counter;
                $auditorLabelMap[$aid] = $label;
                $auditorNameMap[$label] = $user->name;
                $counter++;
            }
        }

        // Attach auditor data onto $data collection
        $data->each(function ($item) use ($auditorScores, $auditors, $allTemuanSaran, $idJurusan, $auditorLabelMap) {
            $item->auditorMatriks = collect();
            foreach ($auditors as $auditor) {
                $score = $auditorScores[$item->id][$auditor->id] ?? null;
                $tsItems = $allTemuanSaran[$item->id] ?? collect();

                $temuanHtml = '-';
                $saranHtml = '-';
                if ((int)$auditor->id === (int)$idJurusan) {
                    // For shared Auditor (virtual), combine temuan/saran from both auditors
                    $filteredTemuan = $tsItems->filter(fn($ts) => !empty($ts->temuan));
                    if ($filteredTemuan->isNotEmpty()) {
                        $temuanHtml = $filteredTemuan->map(function ($ts) use ($auditorLabelMap) {
                            $label = $auditorLabelMap[$ts->id_users] ?? 'Auditor';
                            return '<strong>' . e($label) . '</strong> : ' . e($ts->temuan);
                        })->implode('<br>');
                    }
                    $filteredSaran = $tsItems->filter(fn($ts) => !empty($ts->saran));
                    if ($filteredSaran->isNotEmpty()) {
                        $saranHtml = $filteredSaran->map(function ($ts) use ($auditorLabelMap) {
                            $label = $auditorLabelMap[$ts->id_users] ?? 'Auditor';
                            return '<strong>' . e($label) . '</strong> : ' . e($ts->saran);
                        })->implode('<br>');
                    }
                } elseif ($score) {
                    // For UPM, use users_matrik.temuan/saran
                    $temuanHtml = $score->temuan ?? '-';
                    $saranHtml = $score->saran ?? '-';
                }

                $item->auditorMatriks->push((object)[
                    'id_users'   => $auditor->id,
                    'nama'       => $auditor->name,
                    'nilai_total'=> $score?->nilai_total,
                    'jawaban'    => $score?->jawaban,
                    'temuan'     => $temuanHtml,
                    'saran'      => $saranHtml,
                    'skor_a'     => $score?->skor_a,
                    'skor_b'     => $score?->skor_b,
                    'exists'     => !is_null($score),
                ]);
            }
        });

        /* =========================
           🔥 SYARAT UNGGUL — HELPER
        ========================= */
        $computeSyarat = function ($syaratList, $nilaiMapCallback, $matrikJawabanCallback) {
            $syaratResult = [];
            foreach ($syaratList as $item) {
                $memenuhi3 = false;
                $memenuhi5 = false;
                $matriks = $item->matriks;
                if (!$matriks) continue;

                $subItems = $matriks->subItemElemen ?? collect();
                $nilaiMap = $nilaiMapCallback($matriks);

                $detail = [];

                if ($item->nomor == 1) {
                    $NDS3 = $NDL = $NDLK = $NDGB = 0;
                    foreach ($subItems as $sub) {
                        $id = $sub->id; $var = $sub->variabel;
                        $n = (float) ($nilaiMap[$id] ?? 0);
                        if ($var == 'NDS3') $NDS3 = $n;
                        if ($var == 'NDL') $NDL = $n;
                        if ($var == 'NDLK') $NDLK = $n;
                        if ($var == 'NDGB') $NDGB = $n;
                    }
                    $totalLektor = $NDL + $NDLK + $NDGB;
                    $memenuhi3 = $NDS3 >= 1 && $totalLektor >= 2;
                    $memenuhi5 = $NDS3 >= 2 && $totalLektor >= 2 && $NDLK >= 1;
                    $detail = ['NDS3' => $NDS3, 'NDL' => $NDL, 'NDLK' => $NDLK, 'NDGB' => $NDGB, 'totalLektor' => $totalLektor];
                } elseif (in_array($item->nomor, [2, 3, 4])) {
                    $nilai = (float) ($matrikJawabanCallback($matriks) ?? 0);
                    $memenuhi3 = $nilai >= 3.0;
                    $memenuhi5 = $nilai >= 3.5;
                    $detail = ['skor' => $nilai];
                } elseif ($item->nomor == 5) {
                    $NM = 0; $S1=$S2=$S3=$S4=$S5=$S6=0; $INT=$ISBN=$PATEN=0;
                    foreach ($subItems as $sub) {
                        $id = $sub->id; $var = $sub->variabel;
                        $n = (float) ($nilaiMap[$id] ?? 0);
                        if ($var == 'NM') $NM = $n;
                        if ($var == 'SINTA1_MHS') $S1 = $n;
                        if ($var == 'SINTA2_MHS') $S2 = $n;
                        if ($var == 'SINTA3_MHS') $S3 = $n;
                        if ($var == 'SINTA4_MHS') $S4 = $n;
                        if ($var == 'SINTA5_MHS') $S5 = $n;
                        if ($var == 'SINTA6_MHS') $S6 = $n;
                        if ($var == 'INT_MHS') $INT = $n;
                        if ($var == 'ISBN_MHS') $ISBN = $n;
                        if ($var == 'PATEN_MHS') $PATEN = $n;
                    }
                    if ($NM > 0) {
                        $total3 = $S1+$S2+$S3+$S4+$S5+$INT+$ISBN+$PATEN;
                        $persen3 = ($total3/$NM)*100;
                        $memenuhi3 = $persen3 >= 15;
                        $total5 = $S1+$S2+$S3+$S4+$INT+$ISBN+$PATEN;
                        $persen5 = ($total5/$NM)*100;
                        $memenuhi5 = $persen5 >= 25;
                        $detail = ['NM' => $NM, 'S1' => $S1, 'S2' => $S2, 'S3' => $S3, 'S4' => $S4, 'S5' => $S5, 'S6' => $S6, 'INT' => $INT, 'ISBN' => $ISBN, 'PATEN' => $PATEN, 'total3' => $total3, 'persen3' => $persen3, 'total5' => $total5, 'persen5' => $persen5];
                    } else {
                        $detail = ['NM' => 0];
                    }
                } elseif ($item->nomor == 6) {
                    $NDTPS = 0; $NDTPS_PUB = 0;
                    foreach ($subItems as $sub) {
                        $id = $sub->id; $var = $sub->variabel;
                        $n = (float) ($nilaiMap[$id] ?? 0);
                        if ($var == 'NDTPS') $NDTPS = $n;
                        if ($var == 'NDTPS_PUB') $NDTPS_PUB = $n;
                    }
                    if ($NDTPS > 0) {
                        $persen3 = ($NDTPS_PUB / $NDTPS) * 100;
                        $persen5 = $persen3;
                        $memenuhi3 = $persen3 >= 20;
                        $memenuhi5 = $persen5 >= 20;
                        $detail = ['NDTPS' => $NDTPS, 'NDTPS_PUB' => $NDTPS_PUB, 'persen3' => $persen3, 'persen5' => $persen5];
                    } else {
                        $detail = ['NDTPS' => 0];
                    }
                }
                $syaratResult[] = [
                    'nomor'        => $item->nomor,
                    'elemen'       => $item->elemen,
                    'indikator'    => $item->indikator,
                    'kriteria'     => $item->matriks?->kriteria?->name ?? '-',
                    'memenuhi_3'   => $memenuhi3,
                    'memenuhi_5'   => $memenuhi5,
                    'detail'       => $detail,
                    'syarat_3'     => json_decode($item->syarat_tahun, true)['3_tahun'] ?? '-',
                    'syarat_5'     => json_decode($item->syarat_tahun, true)['5_tahun'] ?? '-',
                ];
            }
            return $syaratResult;
        };

        /* =========================
           🔥 SYARAT UNGGUL — JURUSAN
        ========================= */
        $dataSyaratUnggul = SyaratUnggul::with([
            'matriks.subItemElemen',
            'matriks.userSubItemElements' => function ($q) use ($idJurusan) {
                $q->where('id_users', $idJurusan);
            },
            'matriks.userMatrik' => function ($q) use ($idJurusan) {
                $q->where('id_users', $idJurusan);
            },
        ])->get();

        $jurusanSyarat = $computeSyarat(
            $dataSyaratUnggul,
            fn($m) => $m->userSubItemElements?->pluck('nilai', 'id_sub_item_elemen') ?? collect(),
            fn($m) => $m->userMatrik?->jawaban ?? 0
        );
        $syarat3 = collect($jurusanSyarat)->every(fn($i) => $i['memenuhi_3']);
        $syarat5 = collect($jurusanSyarat)->every(fn($i) => $i['memenuhi_5']);

        /* =========================
           🔥 SYARAT UNGGUL — PER AUDITOR
        ========================= */
        // Load all sub-item elements for all auditors at once
        $allAuditorSubItems = UserSubItemElemen::whereIn('id_users', $auditorIds)
            ->where('id_user_jurusan', $idJurusan)
            ->get()
            ->groupBy('id_matriks');

        $auditorSyaratData = [];
        foreach ($auditors as $auditor) {
            $auditorSyaratData[$auditor->id] = $computeSyarat(
                $dataSyaratUnggul,
                function ($m) use ($allAuditorSubItems, $auditor) {
                    $items = $allAuditorSubItems[$m->id] ?? collect();
                    return collect($items)->where('id_users', $auditor->id)->pluck('nilai', 'id_sub_item_elemen');
                },
                function ($m) use ($auditorScores, $auditor) {
                    return $auditorScores[$m->id][$auditor->id]->jawaban ?? null;
                }
            );
        }

        /* =========================
           🔥 PER-ASPEK DATA FOR RADAR
        ========================= */
        $perAspekJurusan = [];
        $perAspekAuditor = []; // [auditor_id][kriteria_name] => total
        foreach ($data as $item) {
            $nama = $item->kriteria->name;
            $perAspekJurusan[$nama] = ($perAspekJurusan[$nama] ?? 0) + ($item->userMatrik->nilai_total ?? 0);
            foreach ($auditors as $auditor) {
                $score = $auditorScores[$item->id][$auditor->id] ?? null;
                $perAspekAuditor[$auditor->id][$nama] = ($perAspekAuditor[$auditor->id][$nama] ?? 0) + ($score?->nilai_total ?? 0);
            }
        }
        // Also compute max per aspek
        $perAspekMax = [];
        foreach ($data->groupBy('id_kriteria') as $kId => $items) {
            $nama = $items->first()->kriteria->name;
            $max = $items->sum(fn($i) => $i->poin * 4);
            $perAspekMax[$nama] = $max;
        }

        return view('EvaluasiLamdik.show', compact(
            'data', 'syarat3', 'syarat5', 'auditors', 'userJurusan',
            'jurusanSyarat', 'auditorSyaratData', 'perAspekJurusan', 'perAspekAuditor', 'perAspekMax',
            'auditorLabelMap', 'auditorNameMap'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
