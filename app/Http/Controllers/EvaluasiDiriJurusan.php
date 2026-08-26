<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\AuditKriteria;
use App\Models\AuditorJurusan;
use App\Models\MatriksLED;
use App\Models\SyaratUnggul;
use App\Models\TahunAudit;
use App\Models\User;
use App\Models\UsersMatrik;
use App\Models\UserSubItemElemen;
use Illuminate\Http\Request;

class EvaluasiDiriJurusan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = User::where('role', 'admin_jurusan')->get();
        return view('EvaluasiDiriJurusan.index', compact('data'));
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
        $validated = $request->validate([
            'jawaban'              => 'required|numeric',
            'skor_a'               => 'nullable|numeric',
            'skor_b'               => 'nullable|integer',
            'link_bukti'           => 'nullable|url',
            'temuan'               => 'nullable',
            'saran'                => 'nullable',
            'nilai_total'          => 'required|numeric',
            'id_matriks_led'       => 'required|integer',
            'kepemilikan_kriteria' => 'required|string|in:jurusan,fakultas',
            'id_users'             => 'required|integer',
            'id_user_jurusan'      => 'required|integer',
            'tahun'                => 'required|digits:4|integer|min:2000|max:2099',
        ]);

        $tahun = $validated['tahun'];

        // Cek apakah penilaian AMI sudah disubmit oleh jurusan/admin
        $audit = Audit::where('program_studi', (string) $validated['id_user_jurusan'])
            ->where('tahun', $tahun)
            ->first();
        if ($audit && $audit->jurusan_submitted_at) {
            return redirect()->back()->with('error', 'Penilaian AMI sudah disubmit, tidak dapat diubah lagi.');
        }

        UsersMatrik::updateOrCreate(
            [
                'id_users'        => $validated['id_users'],
                'id_user_jurusan' => $validated['id_user_jurusan'],
                'id_matriks_led'  => $validated['id_matriks_led'],
                'tahun'           => $tahun,
            ],
            $validated
        );

        if ($request->has('variabel')) {
            foreach ($request->variabel as $idSubItem => $nilai) {
                if ($nilai === null || $nilai === '') {
                    continue;
                }
                UserSubItemElemen::updateOrCreate(
                    [
                        'id_matriks'         => $validated['id_matriks_led'],
                        'id_sub_item_elemen' => $idSubItem,
                        'id_users'           => $validated['id_users'],
                        'id_user_jurusan'    => $validated['id_user_jurusan'],
                        'tahun'              => $tahun,
                    ],
                    ['nilai' => $nilai, 'tahun' => $tahun]
                );
            }
        }

        return redirect()->route('evaluasi_diri_jurusan.edit.custom', [
            'evaluasi_diri_jurusan' => $validated['id_user_jurusan'],
            'tahun'                 => $tahun,
        ])->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $tahun = $request->query('tahun');

        if (!$tahun) {
            $tahunList = TahunAudit::pluck('tahun');

            if (!$tahunList->contains(now()->year)) {
                $tahunList->push(now()->year);
                $tahunList = $tahunList->sort()->values();
            }

            $user = User::findOrFail($id);
            $userJurusan = $user;

            return view('EvaluasiLamdik.show', compact('tahunList', 'userJurusan'))->with([
                'routeName'         => 'evaluasi_diri_jurusan.show',
                'routeParamName'    => 'evaluasi_diri_jurusan',
                'routeParamValue'   => $user->id,
                'addYearRouteName'  => 'evaluasi_diri_jurusan.show',
                'addYearRouteValue' => $user->id,
            ]);
        }

        $user = User::findOrFail($id);
        $idJurusan = $id;

        $data = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userMatrik' => function ($q) use ($id, $tahun) {
                $q->where('id_users', $id)->whereNull('id_user_jurusan')->where('tahun', $tahun);
            },
        ])->orderBy('nomor', 'asc')->get();

        $auditors = collect([
            (object) [
                'id'            => $idJurusan,
                'name'          => 'Auditor',
                'auditor_label' => 'Auditor',
            ],
        ]);

        $auditorIds = $auditors->pluck('id');
        $allAuditorScores = UsersMatrik::where('id_user_jurusan', $idJurusan)
            ->whereIn('id_users', $auditorIds)
            ->where('tahun', $tahun)
            ->get()
            ->groupBy('id_matriks_led');

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
            ->where('auditor_jurusan.jurusan', $user->homebase)
            ->where('users.role', 'auditor')
            ->where('auditor_jurusan.tahun_audit', $tahun)
            ->orderBy('auditor_jurusan.created_at')
            ->pluck('auditor_jurusan.user_id');

        $auditorLabelMap = [];
        $auditorNameMap = [];
        $counter = 1;
        foreach ($auditorIdsWithData as $aid) {
            $auditorUser = User::find($aid);
            if ($auditorUser) {
                $label = 'Auditor ' . $counter;
                $auditorLabelMap[$aid] = $label;
                $auditorNameMap[$label] = $auditorUser->name;
                $counter++;
            }
        }

        $data->each(function ($item) use ($auditorScores, $auditors, $allTemuanSaran, $idJurusan, $auditorLabelMap) {
            $item->auditorMatriks = collect();
            foreach ($auditors as $auditor) {
                $score = $auditorScores[$item->id][$auditor->id] ?? null;
                $tsItems = $allTemuanSaran[$item->id] ?? collect();

                $temuanHtml = '-';
                $saranHtml = '-';
                if ((int) $auditor->id === (int) $idJurusan) {
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

                $item->auditorMatriks->push((object) [
                    'id_users'    => $auditor->id,
                    'nama'        => $auditor->name,
                    'nilai_total' => $score?->nilai_total,
                    'jawaban'     => $score?->jawaban,
                    'temuan'      => $temuanHtml,
                    'saran'       => $saranHtml,
                    'skor_a'      => $score?->skor_a,
                    'skor_b'      => $score?->skor_b,
                    'exists'      => !is_null($score),
                ]);
            }
        });

        $computeSyarat = function ($syaratList, $nilaiMapCallback, $matrikJawabanCallback) {
            $syaratResult = [];
            foreach ($syaratList as $item) {
                $memenuhi3 = false;
                $memenuhi5 = false;
                $matriks = $item->matriks;
                if (!$matriks)
                    continue;

                $subItems = $matriks->subItemElemen ?? collect();
                $nilaiMap = $nilaiMapCallback($matriks);
                $detail = [];

                if ($item->nomor == 1) {
                    $NDS3 = $NDL = $NDLK = $NDGB = 0;
                    foreach ($subItems as $sub) {
                        $id = $sub->id;
                        $var = $sub->variabel;
                        $n = (float) ($nilaiMap[$id] ?? 0);
                        if ($var == 'NDS3')
                            $NDS3 = $n;
                        if ($var == 'NDL')
                            $NDL = $n;
                        if ($var == 'NDLK')
                            $NDLK = $n;
                        if ($var == 'NDGB')
                            $NDGB = $n;
                    }
                    $totalLektor = $NDL + $NDLK + $NDGB;
                    $efektifLK = $NDLK + $NDGB;

                    $memenuhi3 = $NDS3 >= 1 && $totalLektor >= 2;
                    $memenuhi5 = $NDS3 >= 2 && $totalLektor >= 2 && $efektifLK >= 1;
                    $detail = ['NDS3' => $NDS3, 'NDL' => $NDL, 'NDLK' => $NDLK, 'NDGB' => $NDGB, 'totalLektor' => $totalLektor, 'efektifLK' => $efektifLK];
                } elseif (in_array($item->nomor, [2, 3, 4])) {
                    $nilai = (float) ($matrikJawabanCallback($matriks) ?? 0);
                    $memenuhi3 = $nilai >= 3.0;
                    $memenuhi5 = $nilai >= 3.5;
                    $detail = ['skor' => $nilai];
                } elseif ($item->nomor == 5) {
                    $NM = 0;
                    foreach ($subItems as $sub) {
                        $id = $sub->id;
                        $var = $sub->variabel;
                        $n = (float) ($nilaiMap[$id] ?? 0);
                        if ($var == 'NM')
                            $NM = $n;
                    }
                    $S1 = $S2 = $S3 = $S4 = $S5 = $S6 = $INT = $ISBN = $PATEN = 0;
                    foreach ($subItems as $sub) {
                        $var = $sub->variabel;
                        $n = (float) ($nilaiMap[$sub->id] ?? 0);
                        if ($var == 'SINTA1_MHS')
                            $S1 = $n;
                        if ($var == 'SINTA2_MHS')
                            $S2 = $n;
                        if ($var == 'SINTA3_MHS')
                            $S3 = $n;
                        if ($var == 'SINTA4_MHS')
                            $S4 = $n;
                        if ($var == 'SINTA5_MHS')
                            $S5 = $n;
                        if ($var == 'SINTA6_MHS')
                            $S6 = $n;
                        if ($var == 'INT_MHS')
                            $INT = $n;
                        if ($var == 'ISBN_MHS')
                            $ISBN = $n;
                        if ($var == 'PATEN_MHS')
                            $PATEN = $n;
                    }
                    if ($NM > 0) {
                        $total3 = $S1 + $S2 + $S3 + $S4 + $S5 + $INT + $ISBN + $PATEN;
                        $persen3 = ($total3 / $NM) * 100;
                        $memenuhi3 = $persen3 >= 15;
                        $total5 = $S1 + $S2 + $S3 + $S4 + $INT + $ISBN + $PATEN;
                        $persen5 = ($total5 / $NM) * 100;
                        $memenuhi5 = $persen5 >= 25;
                        $detail = ['NM' => $NM, 'S1' => $S1, 'S2' => $S2, 'S3' => $S3, 'S4' => $S4, 'S5' => $S5, 'S6' => $S6, 'INT' => $INT, 'ISBN' => $ISBN, 'PATEN' => $PATEN, 'total3' => $total3, 'persen3' => $persen3, 'total5' => $total5, 'persen5' => $persen5];
                    } else {
                        $detail = ['NM' => 0];
                    }
                } elseif ($item->nomor == 6) {
                    $NDTPS = 0;
                    $S4 = $S3 = $S2 = $S1 = $INT = 0;
                    foreach ($subItems as $sub) {
                        $id = $sub->id;
                        $var = $sub->variabel;
                        $n = (float) ($nilaiMap[$id] ?? 0);
                        if ($var == 'NDTPS')
                            $NDTPS = $n;
                        if ($var == 'S4_DTPS')
                            $S4 = $n;
                        if ($var == 'S3_DTPS')
                            $S3 = $n;
                        if ($var == 'S2_DTPS')
                            $S2 = $n;
                        if ($var == 'S1_DTPS')
                            $S1 = $n;
                        if ($var == 'INT_DTPS')
                            $INT = $n;
                    }
                    if ($NDTPS > 0) {
                        $total3 = $S4 + $S3 + $S2 + $S1 + $INT;
                        $total5 = $S2 + $S1 + $INT;
                        $persen3 = ($total3 / $NDTPS) * 100;
                        $persen5 = ($total5 / $NDTPS) * 100;
                        $memenuhi3 = $persen3 >= 20;
                        $memenuhi5 = $persen5 >= 20;
                        $detail = ['NDTPS' => $NDTPS, 'S4' => $S4, 'S3' => $S3, 'S2' => $S2, 'S1' => $S1, 'INT' => $INT, 'total3' => $total3, 'persen3' => $persen3, 'total5' => $total5, 'persen5' => $persen5];
                    } else {
                        $detail = ['NDTPS' => 0];
                    }
                }
                $syaratResult[] = [
                    'nomor'      => $item->nomor,
                    'elemen'     => $item->elemen,
                    'indikator'  => $item->indikator,
                    'kriteria'   => $item->matriks?->kriteria?->name ?? '-',
                    'memenuhi_3' => $memenuhi3,
                    'memenuhi_5' => $memenuhi5,
                    'detail'     => $detail,
                    'syarat_3'   => json_decode($item->syarat_tahun, true)['3_tahun'] ?? '-',
                    'syarat_5'   => json_decode($item->syarat_tahun, true)['5_tahun'] ?? '-',
                ];
            }
            return $syaratResult;
        };

        $dataSyaratUnggul = SyaratUnggul::with([
            'matriks.subItemElemen',
            'matriks.userSubItemElements' => function ($q) use ($idJurusan, $tahun) {
                $q->where('id_users', $idJurusan)->where('tahun', $tahun);
            },
            'matriks.userMatrik'          => function ($q) use ($idJurusan, $tahun) {
                $q->where('id_users', $idJurusan)->where('tahun', $tahun);
            },
        ])->get();

        $jurusanSyarat = $computeSyarat(
            $dataSyaratUnggul,
            fn($m) => $m->userSubItemElements?->pluck('nilai', 'id_sub_item_elemen') ?? collect(),
            fn($m) => $m->userMatrik?->jawaban ?? 0
        );
        $syarat3 = collect($jurusanSyarat)->every(fn($i) => $i['memenuhi_3']);
        $syarat5 = collect($jurusanSyarat)->every(fn($i) => $i['memenuhi_5']);

        $allAuditorSubItems = UserSubItemElemen::whereIn('id_users', $auditorIds)
            ->where('id_user_jurusan', $idJurusan)
            ->where('tahun', $tahun)
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

        $perAspekJurusan = [];
        $perAspekAuditor = [];
        foreach ($data as $item) {
            $nama = $item->kriteria->name;
            $perAspekJurusan[$nama] = ($perAspekJurusan[$nama] ?? 0) + ($item->userMatrik->nilai_total ?? 0);
            foreach ($auditors as $auditor) {
                $score = $auditorScores[$item->id][$auditor->id] ?? null;
                $perAspekAuditor[$auditor->id][$nama] = ($perAspekAuditor[$auditor->id][$nama] ?? 0) + ($score?->nilai_total ?? 0);
            }
        }
        $perAspekMax = [];
        foreach ($data->groupBy('id_kriteria') as $kId => $items) {
            $nama = $items->first()->kriteria->name;
            $max = $items->sum(fn($i) => $i->poin * 4);
            $perAspekMax[$nama] = $max;
        }

        $userJurusan = $user;
        $auditHeader = Audit::where('program_studi', (string) $idJurusan)
            ->where('tahun', $tahun)
            ->first();
        $auditKriterias = AuditKriteria::where('jurusan_id', $idJurusan)->get();
        $auditor = AuditorJurusan::where('jurusan', $userJurusan->homebase)
            ->get();


        return view('EvaluasiLamdik.show', compact(
            'data',
            'userJurusan',
            'auditors',
            'syarat3',
            'syarat5',
            'jurusanSyarat',
            'auditorSyaratData',
            'perAspekJurusan',
            'perAspekAuditor',
            'perAspekMax',
            'auditorLabelMap',
            'auditorNameMap',
            'tahun',
            'auditHeader',
            'auditKriterias',
            'auditor',
            'idJurusan'
        ))->with([
                    'routeName'         => 'evaluasi_diri_jurusan.show',
                    'routeParamName'    => 'evaluasi_diri_jurusan',
                    'routeParamValue'   => $user->id,
                    'addYearRouteName'  => 'evaluasi_diri_jurusan.show',
                    'addYearRouteValue' => $user->id,
                ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $tahun = $request->query('tahun');

        if (!$tahun) {
            $tahunList = UsersMatrik::where('id_users', auth()->id())
                ->where('id_user_jurusan', $id)
                ->whereNotNull('tahun')
                ->distinct()
                ->pluck('tahun')
                ->sort()
                ->values();

            if (!$tahunList->contains(now()->year)) {
                $tahunList->push(now()->year);
                $tahunList = $tahunList->sort()->values();
            }

            $userJurusan = User::findOrFail($id);

            return view('EvaluasiDiriJurusan.edit', compact('tahunList', 'userJurusan'));
        }

        $userJurusan = User::findOrFail($id);
        $idUserLogin = auth()->user()->id;

        $data = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userSubItemElements' => function ($q) use ($idUserLogin, $id, $tahun) {
                $q->where('id_users', $idUserLogin)
                    ->where('id_user_jurusan', $id)
                    ->where('tahun', $tahun);
            },
            'userMatrikByUser'    => function ($q) use ($idUserLogin, $id, $tahun) {
                $q->where('id_users', $idUserLogin)
                    ->where('id_user_jurusan', $id)
                    ->where('tahun', $tahun);
            }
        ])->orderBy('nomor', 'asc')->get();

        $dataUnggul = SyaratUnggul::with([
            'matriks.subItemElemen',
            'matriks.userSubItemElements',
            'matriks.userMatrik' => function ($q) use ($idUserLogin, $id, $tahun) {
                $q->where('id_users', $idUserLogin)
                    ->where('id_user_jurusan', $id)
                    ->where('tahun', $tahun);
            }
        ])->get();

        foreach ($dataUnggul as $item) {
            $item->memenuhi_3_tahun = false;
            $item->memenuhi_5_tahun = false;

            $subItems = $item->matriks->subItemElemen ?? collect();
            $userValues = $item->matriks->userSubItemElements ?? collect();
            $nilaiMap = [];
            foreach ($userValues as $val) {
                $nilaiMap[$val['id_sub_item_elemen']] = $val['nilai'];
            }

            if ($item->nomor == 1) {
                $NDS3 = $NDL = $NDLK = $NDGB = 0;
                foreach ($subItems as $sub) {
                    $v = $sub['variabel'];
                    $n = $nilaiMap[$sub['id']] ?? 0;
                    if ($v == 'NDS3')
                        $NDS3 = $n;
                    if ($v == 'NDL')
                        $NDL = $n;
                    if ($v == 'NDLK')
                        $NDLK = $n;
                    if ($v == 'NDGB')
                        $NDGB = $n;
                }
                $totalLektor = $NDL + $NDLK + $NDGB;
                $efektifLK = $NDLK + $NDGB;

                $item->memenuhi_3_tahun = $NDS3 >= 1 && $totalLektor >= 2;
                $item->memenuhi_5_tahun = $NDS3 >= 2 && $totalLektor >= 2 && $efektifLK >= 1;
            } elseif (in_array($item->nomor, [2, 3, 4])) {
                $jawaban = (float) ($item->matriks->userMatrik->jawaban ?? 0);
                $item->memenuhi_3_tahun = $jawaban >= 3.0;
                $item->memenuhi_5_tahun = $jawaban >= 3.5;
            } elseif ($item->nomor == 5) {
                $NM = 0;
                $S1 = $S2 = $S3 = $S4 = $S5 = $S6 = 0;
                $INT = $ISBN = $PATEN = 0;
                foreach ($subItems as $sub) {
                    $v = $sub['variabel'];
                    $n = $nilaiMap[$sub['id']] ?? 0;
                    if ($v == 'NM')
                        $NM = $n;
                    if ($v == 'SINTA1_MHS')
                        $S1 = $n;
                    if ($v == 'SINTA2_MHS')
                        $S2 = $n;
                    if ($v == 'SINTA3_MHS')
                        $S3 = $n;
                    if ($v == 'SINTA4_MHS')
                        $S4 = $n;
                    if ($v == 'SINTA5_MHS')
                        $S5 = $n;
                    if ($v == 'SINTA6_MHS')
                        $S6 = $n;
                    if ($v == 'INT_MHS')
                        $INT = $n;
                    if ($v == 'ISBN_MHS')
                        $ISBN = $n;
                    if ($v == 'PATEN_MHS')
                        $PATEN = $n;
                }
                if ($NM > 0) {
                    $total3 = $S1 + $S2 + $S3 + $S4 + $S5 + $INT + $ISBN + $PATEN;
                    $item->memenuhi_3_tahun = (($total3 / $NM) * 100) >= 15;
                    $total5 = $S1 + $S2 + $S3 + $S4 + $INT + $ISBN + $PATEN;
                    $item->memenuhi_5_tahun = (($total5 / $NM) * 100) >= 25;
                }
            } elseif ($item->nomor == 6) {
                $NDTPS = 0;
                $NDTPS_PUB = 0;
                foreach ($subItems as $sub) {
                    $v = $sub['variabel'];
                    $n = $nilaiMap[$sub['id']] ?? 0;
                    if ($v == 'NDTPS')
                        $NDTPS = $n;
                    if ($v == 'NDTPS_PUB')
                        $NDTPS_PUB = $n;
                }
                if ($NDTPS > 0) {
                    $persen3 = ($NDTPS_PUB / $NDTPS) * 100;
                    $persen5 = $persen3;
                    $item->memenuhi_3_tahun = ($persen3 >= 20);
                    $item->memenuhi_5_tahun = ($persen5 >= 20);
                }
            }
        }

        $syarat3 = $dataUnggul->every(fn($i) => $i->memenuhi_3_tahun);
        $syarat5 = $dataUnggul->every(fn($i) => $i->memenuhi_5_tahun);

        $auditHeader = Audit::where('program_studi', $id)->where('tahun', $tahun)->first();

        return view('EvaluasiDiriJurusan.edit', compact('data', 'userJurusan', 'dataUnggul', 'syarat3', 'syarat5', 'auditHeader', 'tahun'));
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
