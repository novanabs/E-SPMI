<?php

namespace App\Http\Controllers\PPEPP;

use App\Models\Evaluasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluasiController extends Controller
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
        $data = Evaluasi::where('id_users', $id)->latest()->paginate(10);
        return view('PPEPP.evaluasi.3-evaluasi', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ppepp.evaluasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'aspek' => 'required',
            'jenis_laporan' => 'required',
            'link_bukti_laporan' => 'required',
        ], [
            'aspek.required' => 'Aspek wajib diisi.',
            'jenis_laporan.required' => 'Jenis laporan wajib diisi.',
            'link_bukti_laporan.required' => 'Link bukti laporan wajib diisi.'
        ]);

        $data = $request->merge([
            'id_users' => auth()->id()
        ]);

        Evaluasi::create($data->all());

        return redirect()->route('evaluasi.index')->with('success', 'Data berhasil ditambahkan');
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
        $data = Evaluasi::findOrFail($id);
        return view('ppepp.evaluasi.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'aspek' => 'required',
            'jenis_laporan' => 'required',
            'link_bukti_laporan' => 'required',
        ], [
            'aspek.required' => 'Aspek wajib diisi.',
            'jenis_laporan.required' => 'Jenis laporan wajib diisi.',
            'link_bukti_laporan.required' => 'Link bukti laporan wajib diisi.'
        ]);

        Evaluasi::where('id', $id)->update(
            $validated
        );

        return redirect()->route('evaluasi.index')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Evaluasi::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
