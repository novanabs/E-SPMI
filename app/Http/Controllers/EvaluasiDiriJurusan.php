<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MatriksLED;
use App\Models\UsersMatrik;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            'jawaban'              => 'required|integer',
            'link_bukti'           => 'nullable|url',
            'temuan'               => 'nullable',
            'saran'                => 'nullable',
            'nilai_total'          => 'required|numeric',
            'id_matriks_led'       => 'required|integer',
            'kepemilikan_kriteria' => 'required|string|in:jurusan,fakultas',
            'id_users'             => 'required|integer',
            'id_user_jurusan'      => 'required|integer',
        ]);

        UsersMatrik::updateOrCreate(
            [
                'id_users'        => $validated['id_users'], //ini upm
                'id_user_jurusan' => $validated['id_user_jurusan'], // ini id jurusan yang di evaluasi
                'id_matriks_led'  => $validated['id_matriks_led'], // ini id matriks yang 65
            ],
            $validated
        );

        return redirect()->route('evaluasi_diri_jurusan.edit.custom', $validated['id_user_jurusan'])
            ->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $user = User::findOrFail($id);

        $idUserLogin = auth()->user()->id;

        $data = MatriksLED::with([
            'kriteria',
            'userMatrik'       => function ($q) use ($id) {
                $q->where('id_users', $id);
            },
            'userMatrikByUser' => function ($q) use ($idUserLogin, $id) {
                $q->where('id_users', $idUserLogin)
                    ->where('id_user_jurusan', $id);
            }

        ])->orderBy('nomor', 'asc')->get();


        return view('EvaluasiDiriJurusan.show', compact('data', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userJurusan = User::findOrFail($id);

        $data = MatriksLED::with([
            'kriteria',
            'userMatrikByUser' => function ($q) use ($id) {
                $q->where('id_user_jurusan', $id);
            }
        ])->orderBy('nomor', 'asc')->get();

        // dd($data->first()->userMatrikByUser);

        return view('EvaluasiDiriJurusan.edit', compact('data', 'userJurusan'));
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
