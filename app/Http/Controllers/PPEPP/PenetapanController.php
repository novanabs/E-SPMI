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
            return redirect()->route('login');
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
        return view('PPEPP.penetapan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name'                   => 'required',
        'bidang'                 => 'required|in:Pendidikan,Penelitian,Pengabdian kepada Masyarakat',
        'tanggal_penetapan'      => 'required|date',
        'tanggal_berakhir'       => 'nullable|date',
        'link_bukti_dokumen'     => 'required'
    ], [
        'name.required'                  => 'Nama dokumen wajib diisi.',
        'bidang.required'                => 'Bidang wajib dipilih.',
        'bidang.in'                      => 'Bidang tidak valid.',
        'tanggal_penetapan.required'     => 'Tanggal penetapan wajib diisi.',
        'tanggal_berakhir.date'          => 'Tanggal berakhir harus berupa tanggal yang valid.',
        'link_bukti_dokumen.required'    => 'Link dokumen wajib diisi.',
    ]);

    $data = $request->merge([
        'id_users' => auth()->id(),
        'tanggal_berakhir' => $request->tanggal_berakhir ?: null
    ]);

    Penetapan::create($data->all());

    return redirect()
        ->route('penetapan.index')
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
        $data = Penetapan::findOrFail($id);
        return view('PPEPP.penetapan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $validated = $request->validate([
        'name'                   => 'required|string',
        'bidang'                 => 'required|in:Pendidikan,Penelitian,Pengabdian kepada Masyarakat',
        'tanggal_penetapan'      => 'required|date',
        'tanggal_berakhir'       => 'nullable|date',
        'link_bukti_dokumen'     => 'required|string',
    ], [
        'name.required'                  => 'Nama dokumen wajib diisi.',
        'bidang.required'                => 'Bidang wajib dipilih.',
        'bidang.in'                      => 'Bidang tidak valid.',
        'tanggal_penetapan.required'     => 'Tanggal penetapan wajib diisi.',
        'tanggal_berakhir.date'          => 'Tanggal berakhir harus berupa tanggal yang valid.',
        'link_bukti_dokumen.required'    => 'Link dokumen wajib diisi.',
    ]);

    $validated['tanggal_berakhir'] = $request->tanggal_berakhir ?: null;

    Penetapan::where('id', $id)->update($validated);

    return redirect()
        ->route('penetapan.index')
        ->with('success', 'Data berhasil diupdate!');
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
