<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evaluasi;
use App\Models\Penetapan;
use App\Models\MatriksLED;
use App\Models\Pelaksanaan;
use App\Models\Peningkatan;
use App\Models\Pengendalian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PimpinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::whereIn('role', ['admin_jurusan', 'admin_FKIP'])->get();
        return view('pimpinan.index', compact('data'));
    }

    public function perbandingan()
    {
        $data = User::where('role', 'admin_jurusan')->get();
        return view('pimpinan.perbandingan', compact('data'));
    }

    public function perbandinganJurusan(string $idJurusan)
    {
        $user = User::findOrFail($idJurusan);

        $userUpm = User::where('email', 'upmfkip1@ulm.ac.id')->first();

        $idUserUpm = $userUpm?->id; // aman, tidak error kalau null

        $data = MatriksLED::with([
            'kriteria',
            'userMatrik'       => function ($q) use ($idJurusan) {
                $q->where('id_users', $idJurusan);
            },
            'userMatrikByUser' => function ($q) use ($idUserUpm, $idJurusan) {
                $q->where('id_users', $idUserUpm)
                    ->where('id_user_jurusan', $idJurusan);
            }

        ])->orderBy('nomor', 'asc')->get();


        return view('pimpinan.perbandinganJurusan', compact('data', 'user'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::findOrFail($id);
        $penetapan = Penetapan::where('id_users', $id)->get();
        $pelaksanaan = Pelaksanaan::where('id_users', $id)->get();
        $evaluasi = Evaluasi::where('id_users', $id)->get();
        $pengendalian = Pengendalian::where('id_users', $id)->get();
        $peningkatan = Peningkatan::where('id_users', $id)->get();
        return view('pimpinan.show', compact('data', 'penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
