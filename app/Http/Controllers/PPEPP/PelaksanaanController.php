<?php

namespace App\Http\Controllers\PPEPP;

use App\Models\Pelaksanaan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PelaksanaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login-jurusan');
        }

        $id = auth()->id();
        $data = Pelaksanaan::where('id_users', $id)->latest()->paginate(10);
        return view('PPEPP.pelaksanaan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('PPEPP.pelaksanaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required',
            'link_bukti_laporan' => 'required',
        ], [
            'name.required'               => 'Nama laporan wajib diisi.',
            'link_bukti_laporan.required' => 'Link laporan wajib diisi.',
        ]);

        $data = $request->merge([
            'id_users' => auth()->id()
        ]);

        Pelaksanaan::create($data->all());

        return redirect()->route('pelaksanaan.index')->with('success', 'Data berhasil ditambahkan');
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
        $data = Pelaksanaan::findOrFail($id);
        return view('PPEPP.pelaksanaan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'                 => 'required',
            'link_bukti_laporan'   => 'required',
            'nama_mitra'           => 'nullable',
            'link_bukti_kerjasama' => 'nullable'
        ], [
            'name.required'               => 'Nama laporan wajib diisi.',
            'link_bukti_laporan.required' => 'Link laporan wajib diisi.',
        ]);

        Pelaksanaan::where('id', $id)->update(
            $validated
        );

        return redirect()->route('pelaksanaan.index')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Pelaksanaan::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
