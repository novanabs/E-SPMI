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
            return redirect()->route('login');
        }

        $id = auth()->id();
        $data = Evaluasi::where('id_users', $id)->latest()->paginate(10);
        return view('PPEPP.evaluasi.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('PPEPP.evaluasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'bidang'             => 'required|in:Pendidikan,Penelitian,Pengabdian kepada Masyarakat',
            'jenis_laporan'      => 'required',
            'tahun'              => 'required|integer|min:2000|max:' . (date('Y') + 10),
            'jenis'              => 'required|in:Tahun,Semester Ganjil,Semester Genap',
            'link_bukti_laporan' => 'required',
        ], [
            'bidang.required'             => 'Bidang wajib dipilih.',
            'bidang.in'                   => 'Bidang tidak valid.',
            'jenis_laporan.required'      => 'Jenis laporan wajib diisi.',
            'tahun.required'              => 'Tahun wajib diisi.',
            'tahun.integer'               => 'Tahun harus berupa angka.',
            'tahun.min'                   => 'Tahun tidak boleh kurang dari 2000.',
            'tahun.max'                   => 'Tahun tidak boleh lebih dari ' . (date('Y') + 10) . '.',
            'jenis.required'              => 'Jenis pelaksanaan wajib dipilih.',
            'jenis.in'                    => 'Jenis pelaksanaan tidak valid.',
            'link_bukti_laporan.required' => 'Link bukti laporan wajib diisi.',
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
        return view('PPEPP.evaluasi.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'bidang'             => 'required|in:Pendidikan,Penelitian,Pengabdian kepada Masyarakat',
            'jenis_laporan'      => 'required',
            'tahun'              => 'required|integer|min:2000|max:' . (date('Y') + 10),
            'jenis'              => 'required|in:Tahun,Semester Ganjil,Semester Genap',
            'link_bukti_laporan' => 'required',
        ], [
            'bidang.required'             => 'Bidang wajib dipilih.',
            'bidang.in'                   => 'Bidang tidak valid.',
            'jenis_laporan.required'      => 'Jenis laporan wajib diisi.',
            'tahun.required'              => 'Tahun wajib diisi.',
            'tahun.integer'               => 'Tahun harus berupa angka.',
            'tahun.min'                   => 'Tahun tidak boleh kurang dari 2000.',
            'tahun.max'                   => 'Tahun tidak boleh lebih dari ' . (date('Y') + 10) . '.',
            'jenis.required'              => 'Jenis pelaksanaan wajib dipilih.',
            'jenis.in'                    => 'Jenis pelaksanaan tidak valid.',
            'link_bukti_laporan.required' => 'Link bukti laporan wajib diisi.',
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
