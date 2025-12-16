<?php

namespace App\Http\Controllers\PPEPP;

use App\Models\Peningkatan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class PeningkatanController extends Controller
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
        $data = Peningkatan::where('id_users', $id)->latest()->paginate(10);
        return view('PPEPP.peningkatan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('PPEPP.peningkatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required',
            'link_bukti_laporan' => 'required'
        ], [
            'link_bukti_laporan.required' => 'Link laporan wajib diisi.',
        ]);

        $data = $request->merge([
            'id_users' => auth()->id()
        ]);

        Peningkatan::create($data->all());

        return redirect()->route('peningkatan.index')->with('success', 'Data berhasil ditambahkan');
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
        $data = Peningkatan::findOrFail($id);
        return view('PPEPP.peningkatan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'               => 'required|string',
            'link_bukti_laporan' => 'required|string',
        ], [
            'link_bukti_laporan.required' => 'Link Laporan wajib diisi.',
        ]);

        Peningkatan::where('id', $id)->update(
            $validated
        );

        return redirect()->route('peningkatan.index')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Peningkatan::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
