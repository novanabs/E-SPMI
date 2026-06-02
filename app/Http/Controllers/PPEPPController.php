<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evaluasi;
use App\Models\Penetapan;
use App\Models\Pelaksanaan;
use App\Models\Peningkatan;
use App\Models\Pengendalian;
use Illuminate\Http\Request;

class PPEPPController extends Controller
{
    public function index()
    {
        $entities = User::whereIn('role', ['admin_jurusan', 'admin_FKIP'])->get();
        return view('ppep.index', compact('entities'));
    }

    public function show(string $id)
    {
        $data = User::findOrFail($id);
        $penetapan = Penetapan::where('id_users', $id)->get();
        $pelaksanaan = Pelaksanaan::where('id_users', $id)->get();
        $evaluasi = Evaluasi::where('id_users', $id)->get();
        $pengendalian = Pengendalian::where('id_users', $id)->get();
        $peningkatan = Peningkatan::where('id_users', $id)->get();
        return view('ppep.show', compact('data', 'penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'));
    }
}
