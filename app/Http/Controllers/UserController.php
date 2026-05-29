<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditorJurusan;
use App\Models\MatriksLED;
use App\Models\Penetapan;
use App\Models\Pelaksanaan;
use App\Models\Evaluasi;
use App\Models\Pengendalian;
use App\Models\Peningkatan;
use App\Models\SyaratUnggul;
use App\Models\UsersMatrik;
use App\Models\UserSubItemElemen;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::whereIn('role', ['pimpinan', 'admin_jurusan', 'auditor'])->get();

        return view('user.index', compact('data'));
    }

    public function auditor()
    {
        $data = User::where('role', 'auditor')->get();

        return view('user.auditor', compact('data'));
    }

    public function hubungkan(Request $request)
{
    $request->validate([

        'user_id' => 'required',
        'jurusan' => 'required',
        'tahun_audit' => 'required',

    ]);

    AuditorJurusan::create([

        'user_id' => $request->user_id,
        'jurusan' => $request->jurusan,
        'tahun_audit' => $request->tahun_audit,

    ]);

    return back()->with('success', 'Berhasil menghubungkan auditor');

}

public function dashboardAuditor(){
     $data = AuditorJurusan::where('user_id', auth()->id())
            ->orderBy('tahun_audit', 'desc')
            ->get();

    return view('auditor.index', compact('data'));
}

public function auditorJurusanShow($id)
{
    $assigned = AuditorJurusan::where('user_id', auth()->id())->findOrFail($id);
    $target = User::where('homebase', $assigned->jurusan)
        ->where('role', 'admin_jurusan')
        ->first();
    $data = (object) [
        'homebase' => $assigned->jurusan,
        'ketua'    => $target ? $target->name : '-',
        'tahun'    => $assigned->tahun_audit,
    ];
    $userId = $target ? $target->id : null;
    $penetapan    = $userId ? Penetapan::where('id_users', $userId)->get() : collect();
    $pelaksanaan  = $userId ? Pelaksanaan::where('id_users', $userId)->get() : collect();
    $evaluasi     = $userId ? Evaluasi::where('id_users', $userId)->get() : collect();
    $pengendalian = $userId ? Pengendalian::where('id_users', $userId)->get() : collect();
    $peningkatan  = $userId ? Peningkatan::where('id_users', $userId)->get() : collect();
    return view('auditor.jurusan-show', compact('data', 'penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'));
}

public function auditorEvaluasi($id)
{
    $assigned = AuditorJurusan::where('user_id', auth()->id())->findOrFail($id);
    $userJurusan = User::where('homebase', $assigned->jurusan)
        ->where('role', 'admin_jurusan')->first();
    if (!$userJurusan) {
        return redirect()->route('auditor.index')->with('error', 'Jurusan "' . $assigned->jurusan . '" belum memiliki pengguna terdaftar.');
    }

    $data = MatriksLED::with([
        'kriteria',
        'userSubItemElements' => function ($q) use ($userJurusan) {
            $q->where('id_users', auth()->id())
              ->where('id_user_jurusan', $userJurusan->id);
        },
        'userMatrik' => function ($q) use ($userJurusan) {
            $q->where('id_user_jurusan', $userJurusan->id)
              ->where('id_users', auth()->id());
        }
    ])->orderBy('nomor', 'asc')->get();

    // Hitung syarat unggul (berdasarkan data auditor yang login)
    $dataSyaratUnggul = SyaratUnggul::with([
        'matriks.subItemElemen',
        'matriks.userSubItemElements' => function ($q) use ($userJurusan) {
            $q->where('id_users', auth()->id())
              ->where('id_user_jurusan', $userJurusan->id);
        },
        'matriks.userMatrik' => function ($q) use ($userJurusan) {
            $q->where('id_users', auth()->id())
              ->where('id_user_jurusan', $userJurusan->id);
        }
    ])->get();

    foreach ($dataSyaratUnggul as $item) {
        $item->memenuhi_3_tahun = false;
        $item->memenuhi_5_tahun = false;
        $matriks = $item->matriks;
        if (!$matriks) continue;
        $subItems = $matriks->subItemElemen ?? collect();
        $userValues = $matriks->userSubItemElements ?? collect();
        $nilaiMap = $userValues->pluck('nilai', 'id_sub_item_elemen');

        if ($item->nomor == 1) {
            $NDS3 = $NDL = $NDLK = $NDGB = 0;
            foreach ($subItems as $sub) {
                $id = $sub->id;
                $var = $sub->variabel;
                $nilai = (float) ($nilaiMap[$id] ?? 0);
                if ($var == 'NDS3') $NDS3 = $nilai;
                if ($var == 'NDL') $NDL = $nilai;
                if ($var == 'NDLK') $NDLK = $nilai;
                if ($var == 'NDGB') $NDGB = $nilai;
            }
            $totalLektor = $NDL + $NDLK + $NDGB;
            if ($NDS3 >= 1 && $totalLektor >= 2) $item->memenuhi_3_tahun = true;
            if ($NDS3 >= 2 && $totalLektor >= 2 && $NDLK >= 1) $item->memenuhi_5_tahun = true;
        } elseif (in_array($item->nomor, [2, 3, 4])) {
            $nilai = (float) ($matriks->userMatrik->jawaban ?? 0);
            if ($nilai >= 3.0) $item->memenuhi_3_tahun = true;
            if ($nilai >= 3.5) $item->memenuhi_5_tahun = true;
        } elseif ($item->nomor == 5) {
            $NM = 0;
            $S1 = $S2 = $S3 = $S4 = $S5 = $S6 = 0;
            $INT = $ISBN = $PATEN = 0;
            foreach ($subItems as $sub) {
                $id = $sub->id; $var = $sub->variabel;
                $nilai = (float) ($nilaiMap[$id] ?? 0);
                if ($var == 'NM') $NM = $nilai;
                if ($var == 'SINTA1_MHS') $S1 = $nilai;
                if ($var == 'SINTA2_MHS') $S2 = $nilai;
                if ($var == 'SINTA3_MHS') $S3 = $nilai;
                if ($var == 'SINTA4_MHS') $S4 = $nilai;
                if ($var == 'SINTA5_MHS') $S5 = $nilai;
                if ($var == 'SINTA6_MHS') $S6 = $nilai;
                if ($var == 'INT_MHS') $INT = $nilai;
                if ($var == 'ISBN_MHS') $ISBN = $nilai;
                if ($var == 'PATEN_MHS') $PATEN = $nilai;
            }
            if ($NM > 0) {
                $total3 = $S1 + $S2 + $S3 + $S4 + $S5 + $INT + $ISBN + $PATEN;
                if (($total3 / $NM) * 100 >= 15) $item->memenuhi_3_tahun = true;
                $total5 = $S1 + $S2 + $S3 + $S4 + $INT + $ISBN + $PATEN;
                if (($total5 / $NM) * 100 >= 25) $item->memenuhi_5_tahun = true;
            }
        } elseif ($item->nomor == 6) {
            $NDTPS = 0; $NDTPS_PUB = 0;
            foreach ($subItems as $sub) {
                $id = $sub->id; $var = $sub->variabel;
                $nilai = (float) ($nilaiMap[$id] ?? 0);
                if ($var == 'NDTPS') $NDTPS = $nilai;
                if ($var == 'NDTPS_PUB') $NDTPS_PUB = $nilai;
            }
            if ($NDTPS > 0) {
                $persen3 = ($NDTPS_PUB / $NDTPS) * 100;
                $persen5 = $persen3;
                if ($persen3 >= 20) $item->memenuhi_3_tahun = true;
                if ($persen5 >= 20) $item->memenuhi_5_tahun = true;
            }
        }
    }
    $syarat3 = $dataSyaratUnggul->every(fn($i) => $i->memenuhi_3_tahun);
    $syarat5 = $dataSyaratUnggul->every(fn($i) => $i->memenuhi_5_tahun);
    $dataUnggul = $dataSyaratUnggul;

    return view('auditor.evaluasi', compact('data', 'userJurusan', 'assigned', 'syarat3', 'syarat5', 'dataUnggul'));
}

public function auditorEvaluasiStore(Request $request)
{
    $validated = $request->validate([
        'jawaban'              => 'required|numeric',
        'skor_a'               => 'nullable|numeric|min:0|max:4',
        'skor_b'               => 'nullable|numeric|min:0|max:4',
        'link_bukti'           => 'nullable|url',
        'temuan'               => 'nullable',
        'saran'                => 'nullable',
        'nilai_total'          => 'required|numeric',
        'id_matriks_led'       => 'required|integer',
        'kepemilikan_kriteria' => 'required|string|in:jurusan,fakultas',
        'id_users'             => 'required|integer',
        'id_user_jurusan'      => 'required|integer',
    ]);

    $target = User::findOrFail($validated['id_user_jurusan']);
    $assigned = AuditorJurusan::where('user_id', auth()->id())
        ->where('jurusan', $target->homebase)->firstOrFail();

    UsersMatrik::updateOrCreate(
        [
            'id_users'        => auth()->id(),
            'id_user_jurusan' => $validated['id_user_jurusan'],
            'id_matriks_led'  => $validated['id_matriks_led'],
        ],
        $validated
    );

    if ($request->has('variabel')) {
        foreach ($request->variabel as $idSubItem => $nilai) {
            UserSubItemElemen::updateOrCreate(
                [
                    'id_matriks'         => $validated['id_matriks_led'],
                    'id_sub_item_elemen' => $idSubItem,
                    'id_users'           => auth()->id(),
                    'id_user_jurusan'    => $validated['id_user_jurusan'],
                ],
                ['nilai' => $nilai]
            );
        }
    }

    return redirect()->route('auditor.evaluasi', $assigned->id)
        ->with('success', 'Data berhasil diperbarui');
}

public function auditorPerbandingan($id)
{
    $assigned = AuditorJurusan::where('user_id', auth()->id())->findOrFail($id);
    $userJurusan = User::where('homebase', $assigned->jurusan)
        ->where('role', 'admin_jurusan')->first();
    if (!$userJurusan) {
        return redirect()->route('auditor.index')->with('error', 'Belum ada data jurusan.');
    }

    $data = MatriksLED::with([
        'kriteria',
        'userMatrik'       => function ($q) use ($userJurusan) {
            $q->where('id_users', $userJurusan->id);
        },
        'userMatrikByUser' => function ($q) use ($userJurusan) {
            $q->where('id_users', auth()->id())
              ->where('id_user_jurusan', $userJurusan->id);
        }
    ])->orderBy('nomor', 'asc')->get();

    $user = $userJurusan;
    return view('auditor.perbandingan', compact('data', 'user', 'assigned'));
}

   public function hapusHubungan($id)
    {

        AuditorJurusan::findOrFail($id)->delete();

        return back()->with('success', 'Hubungan berhasil dihapus');

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required',
            'homebase' => 'required',
            'jabatan'    => 'required',
            'nip'    => 'nullable',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required',
        ], [
            'name.required'  => 'Nama user wajib diisi.',
            'nip.required' => 'NIP wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'role.required'  => 'Role wajib diisi.',
        ]);

        if ($validated['role'] === 'admin_jurusan') {
            $exists = User::where('homebase', $validated['homebase'])
                ->where('role', 'admin_jurusan')
                ->exists();
            if ($exists) {
                return back()->withErrors([
                    'homebase' => 'Sudah ada Admin Jurusan untuk homebase "' . $validated['homebase'] . '".',
                ])->withInput();
            }
        }

        $passwordPlain = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $validated['password'] = Hash::make($passwordPlain);
        $validated['generated_password'] = $passwordPlain;
        $validated['password_changed'] = false;


        User::create($validated);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');

    }

    public function resetPassword($user)
    {

        $passwordPlain = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        User::updateOrCreate(
            ['id' => $user],
            [
                'password'           => Hash::make($passwordPlain),
                'generated_password' => $passwordPlain,
                'password_changed'   => false,
            ]
        );

        return response()->json([
            'password' => $passwordPlain
        ]);
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
        $data = User::findOrFail($id);
        return view('user.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'     => 'required',
            'homebase' => 'required',
            'jabatan'    => 'required',
            'nip'    => 'nullable',
            'email'    => 'required|email',
            'role'     => 'required',
        ], [
            'name.required'  => 'Nama user wajib diisi.',
            'nip.required' => 'NIP wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'role.required'  => 'Role wajib diisi.',
        ]);

        User::where('id', $id)->update($validated);

        return redirect()->route('user.index')->with('success', 'User berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }
}
