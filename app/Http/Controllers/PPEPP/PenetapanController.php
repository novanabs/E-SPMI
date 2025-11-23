<?php

namespace App\Http\Controllers\PPEPP;

use App\Models\Penetapan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class PenetapanController extends Controller
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
        $data = Penetapan::where('id_users', $id)->latest()->get();
        return view('PPEPP.penetapan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ppepp.penetapan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'link_bukti_dokumen' => 'required'
        ]);

        $data = $request->merge([
            'id_users' => auth()->id()
        ]);

        Penetapan::create($data->all());

        return redirect()->route('penetapan.index')->with('success', 'Data berhasil ditambahkan');
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
        $data = Penetapan::findOrFail($id);
        return view('ppepp.penetapan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'link_bukti_dokumen' => 'required|string',
        ]);

        Penetapan::where('id', $id)->update(
            $validated
        );

        return redirect()->route('penetapan.index')->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Penetapan::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
