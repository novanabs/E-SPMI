<?php

namespace App\Http\Controllers;

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
            'userSubItemElements',
            'userMatrik' => function ($q) use ($idUser) {
                $q->where('id_users', $idUser);
            }
        ])->orderBy('nomor', 'asc')->get();

        // dd($data->first()->userMatrik->nilai_total);

        // Ini untuk mengetahui syarat unggul

        $dataSyaratUnggul = SyaratUnggul::with([
            'matriks.subItemElemen',
            'matriks.userSubItemElements',
            'matriks.userMatrik'
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

                // 🔥 DTPS
                $S1 = $S2 = $S3 = $S4 = 0;
                $INT = $INTREP = 0;

                foreach ($subItems as $sub) {

                    $id = $sub->id;
                    $var = $sub->variabel;

                    $nilai = (float) ($nilaiMap[$id] ?? 0);

                    if ($var == 'NDTPS')
                        $NDTPS = $nilai;

                    if ($var == 'S1_DTPS')
                        $S1 = $nilai;
                    if ($var == 'S2_DTPS')
                        $S2 = $nilai;
                    if ($var == 'S3_DTPS')
                        $S3 = $nilai;
                    if ($var == 'S4_DTPS')
                        $S4 = $nilai;

                    if ($var == 'INT_DTPS')
                        $INT = $nilai;
                    if ($var == 'INTREP_DTPS')
                        $INTREP = $nilai;
                }

                if ($NDTPS > 0) {

                    /*
                    =========================
                    🔥 3 Tahun
                    Minimal Sinta 4 / Internasional
                    =========================
                    */
                    $total3 =
                        $S1 + $S2 + $S3 + $S4 + $INT;

                    $persen3 = ($total3 / $NDTPS) * 100;

                    if ($persen3 >= 20) {
                        $item->memenuhi_3_tahun = true;
                    }

                    /*
                    =========================
                    🔥 5 Tahun
                    Minimal Sinta 2 / Internasional Bereputasi
                    =========================
                    */
                    $total5 =
                        $S1 + $S2 + $INTREP;

                    $persen5 = ($total5 / $NDTPS) * 100;

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
            'jawaban'              => 'required|integer',
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
        $userUpm = User::where('email', 'upmfkip1@ulm.ac.id')->first();

        $idUserUpm = $userUpm?->id; // aman, tidak error kalau null

        $data = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userMatrik'       => function ($q) use ($idJurusan) {
                $q->where('id_users', $idJurusan);
            },
            'userMatrikByUser' => function ($q) use ($idUserUpm, $idJurusan) {
                $q->where('id_users', $idUserUpm)
                    ->where('id_user_jurusan', $idJurusan);
            },

        ])->orderBy('nomor', 'asc')->get();



        return view('EvaluasiLamdik.show', compact('data'));
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
