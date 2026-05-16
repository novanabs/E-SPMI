<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use App\Models\Pelaksanaan;
use App\Models\Penetapan;
use App\Models\Pengendalian;
use App\Models\Peningkatan;
use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::where('role', 'admin_jurusan')->get();
        return view('jurusan.index', compact('data'));
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

        return view('jurusan.show', compact('data', 'penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'));
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
