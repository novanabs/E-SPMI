<?php

namespace App\Http\Controllers;

use App\Models\Akreditasi;
use Illuminate\Http\Request;

class AkreditasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Akreditasi::all();
        return view('akreditasi.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('akreditasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan'       => 'required',
            'akreditasi'         => 'required',
            'nomor_sk'           => 'required',
            'tanggal_sk'         => 'required|date',
            'tanggal_kadaluarsa' => 'required|date',
            'dokumen'            => 'required|string',
        ], [
            'nama_jurusan.required'       => 'Nama jurusan wajib diisi.',
            'akreditasi.required'         => 'Akreditasi wajib dipilih.',
            'nomor_sk.required'           => 'Nomor SK wajib diisi.',
            'tanggal_sk.required'         => 'Tanggal SK wajib diisi.',
            'tanggal_kadaluarsa.required' => 'Tanggal kadaluarsa wajib diisi.',
            'dokumen.required'            => 'Link dokumen wajib diisi.',
        ]);

        $data = $request->merge([
            'id_users' => auth()->id()
        ]);

        Akreditasi::create($data->all());

        return redirect()
            ->route('akreditasi.index')
            ->with('success', 'Data akreditasi berhasil ditambahkan');
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
        $data = Akreditasi::findOrFail($id);
        return view('akreditasi.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_jurusan'       => 'required|string',
            'akreditasi'         => 'required|string',
            'nomor_sk'           => 'required|string',
            'tanggal_sk'         => 'required|date',
            'tanggal_kadaluarsa' => 'required|date',
            'dokumen'            => 'required|string',
        ], [
            'nama_jurusan.required'       => 'Nama jurusan wajib diisi.',
            'akreditasi.required'         => 'Akreditasi wajib dipilih.',
            'nomor_sk.required'           => 'Nomor SK wajib diisi.',
            'tanggal_sk.required'         => 'Tanggal SK wajib diisi.',
            'tanggal_kadaluarsa.required' => 'Tanggal kadaluarsa wajib diisi.',
            'dokumen.required'            => 'Link dokumen wajib diisi.',
        ]);

        Akreditasi::where('id', $id)->update($validated);

        return redirect()
            ->route('akreditasi.index')
            ->with('success', 'Data akreditasi berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Akreditasi::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
