<?php

namespace App\Http\Controllers;

use App\Models\SubItemElemen;
use App\Models\User;
use App\Models\MatriksLED;
use App\Models\UsersMatrik;
use Illuminate\Http\Request;
use App\Models\UserSubItemElemen;
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

        // dd($data->first()->userMatrik);


        return view('EvaluasiLamdik.index', compact('data'));
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
