<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MatriksLED;
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        $data = MatriksLED::with([
            'kriteria',
            'userMatrikByUser' => function ($q) use ($id) {
                $q->where('id_users', $id);
            }
        ])
            ->orderBy('nomor', 'asc')
            ->get();

        // dd($data->first()->userMatrikByUser);

        return view('EvaluasiDiriJurusan.show', compact('data', 'user'));
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
