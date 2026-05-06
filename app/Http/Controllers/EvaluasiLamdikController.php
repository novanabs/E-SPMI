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

                $NM = $NKM3 = $NKM5 = 0;

                foreach ($subItems as $sub) {
                    $id = $sub->id;
                    $var = $sub->variabel;
                    $nilai = (float) ($nilaiMap[$id] ?? 0);

                    if ($var == 'NM')
                        $NM = $nilai;
                    if ($var == 'NKM_3')
                        $NKM3 = $nilai;
                    if ($var == 'NKM_5')
                        $NKM5 = $nilai;
                }

                if ($NM > 0) {

                    if (($NKM3 / $NM) * 100 >= 15) {
                        $item->memenuhi_3_tahun = true;
                    }

                    if (($NKM5 / $NM) * 100 >= 25) {
                        $item->memenuhi_5_tahun = true;
                    }
                }
            }

            /* =========================
               🔥 ELEMEN 6
            ========================= */ elseif ($item->nomor == 6) {

                $NDTPS = $NDTPUB3 = $NDTPUB5 = 0;

                foreach ($subItems as $sub) {
                    $id = $sub->id;
                    $var = $sub->variabel;
                    $nilai = (float) ($nilaiMap[$id] ?? 0);

                    if ($var == 'NDTPS')
                        $NDTPS = $nilai;
                    if ($var == 'NDTPUB_3')
                        $NDTPUB3 = $nilai;
                    if ($var == 'NDTPUB_5')
                        $NDTPUB5 = $nilai;
                }

                if ($NDTPS > 0) {

                    if (($NDTPUB3 / $NDTPS) * 100 >= 20) {
                        $item->memenuhi_3_tahun = true;
                    }

                    if (($NDTPUB5 / $NDTPS) * 100 >= 20) {
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



        return view('EvaluasiLamdik.index', compact('data', 'syarat3', 'syarat5'));
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

        if ($request->variabel != null) {

            // Ambil Nomor menggunakan id_matriks_led
            $nomor = MatriksLED::where('id', $request->id_matriks_led)->value('nomor');

            // Ambil id di tabel sub_item_elemen
            $subItems = SubItemElemen::where('nomor_elemen', $nomor)->whereIn(
                'variabel',
                array_keys($request->variabel)
            )->pluck('id', 'variabel');
            ;
            // dd($subItems);

            $idUserJurusan = null;

            // if ($request->role !== 'admin_jurusan') {
            //     $idUserJurusan = $request->id_users;
            // }


            // Ini yang memasukkan per variabel
            DB::transaction(function () use ($request, $subItems, $idUserJurusan) {

                foreach ($request->variabel as $kodeVariabel => $nilai) {

                    UserSubItemElemen::updateOrCreate(
                        [
                            'id_matriks'         => $request->id_matriks_led,
                            'id_sub_item_elemen' => $kodeVariabel,
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
