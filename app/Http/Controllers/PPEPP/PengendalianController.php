<?php

namespace App\Http\Controllers\PPEPP;

use App\Models\Pengendalian;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class PengendalianController extends Controller
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
        $data = Pengendalian::where('id_users', $id)->latest()->paginate(10);
        return view('PPEPP.pengendalian.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('PPEPP.pengendalian.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required',
            'tahun'              => 'required|integer|min:2000|max:' . (date('Y') + 10),
            'jenis'              => 'required|in:Tahun,Semester Ganjil,Semester Genap',
            'link_bukti_laporan' => 'required'
        ], [
            'link_bukti_laporan.required' => 'Link laporan wajib diisi.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun tidak boleh kurang dari 2000.',
            'tahun.max' => 'Tahun tidak boleh lebih dari ' . (date('Y') + 10) . '.',
            'jenis.required' => 'Jenis laporan wajib dipilih.',
            'jenis.in' => 'Jenis laporan tidak valid.',
        ]);

        $data = $request->merge([
            'id_users' => auth()->id()
        ]);

        Pengendalian::create($data->all());

        return redirect()->route('pengendalian.index')->with('success', 'Data berhasil ditambahkan');
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
        $data = Pengendalian::findOrFail($id);
        return view('PPEPP.pengendalian.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'               => 'required|string',
            'link_bukti_laporan' => 'required|string',
            'tahun'              => 'required|integer|min:2000|max:' . (date('Y') + 10),
            'jenis'              => 'required|in:Tahun,Semester Ganjil,Semester Genap',
        ], [
            'name.required' => 'Nama laporan wajib diisi.',
            'link_bukti_laporan.required' => 'Link Laporan wajib diisi.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun tidak boleh kurang dari 2000.',
            'tahun.max' => 'Tahun tidak boleh lebih dari ' . (date('Y') + 10) . '.',
            'jenis.required' => 'Jenis laporan wajib dipilih.',
            'jenis.in' => 'Jenis laporan tidak valid.',
        ]);

        Pengendalian::where('id', $id)->update(
            $validated
        );

        return redirect()->route('pengendalian.index')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Pengendalian::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
