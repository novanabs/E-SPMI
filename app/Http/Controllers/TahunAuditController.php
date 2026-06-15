<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TahunAudit;
use Illuminate\Http\Request;

class TahunAuditController extends Controller
{
    public function index()
    {
        $tahunAudits = TahunAudit::orderBy('tahun', 'desc')->get();

        return view('EvaluasiDiriJurusan.tahun-audit', compact('tahunAudits'));
    }

    /**
     * Menyimpan tahun audit baru.
     */
    public function store(Request $request)
    {
        $exists = TahunAudit::where('tahun', $request->tahun)->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Tahun audit sudah ada.');
        }

        TahunAudit::create([
            'tahun' => $request->tahun,
        ]);

        return back()->with('success', 'Tahun audit berhasil ditambahkan.');
    }

    /**
     * Menghapus tahun audit.
     */
    public function destroy($id)
    {
        $tahunAudit = TahunAudit::findOrFail($id);

        $tahunAudit->delete();

        return back()->with('success', 'Tahun audit berhasil dihapus.');
    }
}
