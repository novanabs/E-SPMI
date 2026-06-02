<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $id = auth()->id();
        $data = Dokumen::all();
        return view('dokumen.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dokumen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'deskripsi'    => 'nullable',
            'tahun'         => 'required|integer|min:2000|max:' . (date('Y') + 10),
            'link_dokumen' => 'required'
        ], [
            'name.required'         => 'Nama dokumen wajib diisi.',
            'tahun.required'        => 'Tahun wajib diisi.',
            'tahun.integer'         => 'Tahun harus berupa angka.',
            'tahun.min'             => 'Tahun tidak valid.',
            'tahun.max'             => 'Tahun tidak valid.',
            'link_dokumen.required' => 'Link dokumen wajib diisi.',
        ]);

        $data = $request->merge([
            'id_users' => auth()->id()
        ]);

        Dokumen::create($data->all());

        return redirect()->route('dokumen.index')->with('success', 'Data berhasil ditambahkan');
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
        $data = Dokumen::findOrFail($id);
        return view('dokumen.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'         => 'required|string',
            'deskripsi'    => 'nullable',
            'tahun'         => 'required|integer|min:2000|max:' . (date('Y') + 10),
            'link_dokumen' => 'required|string',
        ], [
            'name.required'         => 'Nama dokumen wajib diisi.',
            'tahun.required'        => 'Tahun wajib diisi.',
            'tahun.integer'         => 'Tahun harus berupa angka.',
            'tahun.min'             => 'Tahun tidak valid.',
            'tahun.max'             => 'Tahun tidak valid.',
            'link_dokumen.required' => 'Link dokumen wajib diisi.',
        ]);

        Dokumen::where('id', $id)->update(
            $validated
        );

        return redirect()->route('dokumen.index')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Dokumen::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
