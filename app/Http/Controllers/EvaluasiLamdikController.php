<?php

namespace App\Http\Controllers;

use App\Models\MatriksLED;
use App\Models\UsersMatrik;
use Illuminate\Http\Request;

class EvaluasiLamdikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = MatriksLED::with(['kriteria', 'userMatrik'])->orderBy('nomor', 'asc')   // atau 'desc'
            ->get();

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

        return redirect()->route('evaluasi_lamdik.index')
            ->with('success', 'Data berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
