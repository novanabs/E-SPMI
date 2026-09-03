<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\AuditKriteria;
use App\Models\AuditorJurusan;
use App\Models\Evaluasi;
use App\Models\Kriteria;
use App\Models\MatriksLED;
use App\Models\Pelaksanaan;
use App\Models\Penetapan;
use App\Models\Pengendalian;
use App\Models\Peningkatan;
use App\Models\SyaratUnggul;
use App\Models\User;
use App\Models\UsersMatrik;
use App\Models\UserSubItemElemen;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::whereIn('role', ['pimpinan', 'admin_jurusan', 'auditor', 'admin_fkip'])->get();

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
            'user_id'     => 'required',
            'jurusan'     => 'required',
            'tahun_audit' => 'required',
        ]);

        $exists = AuditorJurusan::where('user_id', $request->user_id)
            ->where('jurusan', $request->jurusan)
            ->where('tahun_audit', $request->tahun_audit)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Auditor ini sudah terhubung dengan jurusan tersebut');
        }

        $count = AuditorJurusan::where('jurusan', $request->jurusan)
            ->where('tahun_audit', $request->tahun_audit)
            ->count();

        if ($count >= 2) {
            return back()->with('error', 'Jurusan ini sudah memiliki 2 auditor, tidak dapat menambahkan lagi');
        }

        AuditorJurusan::create([
            'user_id'     => $request->user_id,
            'jurusan'     => $request->jurusan,
            'tahun_audit' => $request->tahun_audit,
        ]);

        return back()->with('success', 'Berhasil menghubungkan auditor');
    }

    public function dashboardAuditor()
    {
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
        $penetapan = $userId ? Penetapan::where('id_users', $userId)->get() : collect();
        $pelaksanaan = $userId ? Pelaksanaan::where('id_users', $userId)->get() : collect();
        $evaluasi = $userId ? Evaluasi::where('id_users', $userId)->get() : collect();
        $pengendalian = $userId ? Pengendalian::where('id_users', $userId)->get() : collect();
        $peningkatan = $userId ? Peningkatan::where('id_users', $userId)->get() : collect();
        return view('auditor.jurusan-show', compact('data', 'penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'));
    }

    public function auditorEvaluasi($id)
    {
        $assigned = AuditorJurusan::where('user_id', auth()->id())->findOrFail($id);
        $tahun = $assigned->tahun_audit;
        $userJurusan = User::where('homebase', $assigned->jurusan)
            ->where('role', 'admin_jurusan')->first();
        if (!$userJurusan) {
            return redirect()->route('auditor.index')->with('error', 'Jurusan "' . $assigned->jurusan . '" belum memiliki pengguna terdaftar.');
        }


        $sharedId = $userJurusan->id;

        // Load shared scores: id_users = jurusan_id, id_user_jurusan = jurusan_id
        // Load current auditor's temuan/saran from auditor_temuan_saran
        $data = MatriksLED::with([
            'kriteria',
            'subItemElemen',
            'userSubItemElements' => function ($q) use ($sharedId, $tahun) {
                $q->where('id_users', $sharedId)
                    ->where('id_user_jurusan', $sharedId)
                    ->where('tahun', $tahun);
            },
            'userMatrik'          => function ($q) use ($sharedId, $tahun) {
                $q->where('id_user_jurusan', $sharedId)
                    ->where('id_users', $sharedId)
                    ->where('tahun', $tahun);
            }
        ])->orderBy('nomor', 'asc')->get();



        // Load current auditor's temuan/saran from auditor_temuan_saran
        $myTemuanSaran = \DB::table('auditor_temuan_saran')
            ->where('id_users', auth()->id())
            ->where('id_user_jurusan', $sharedId)
            ->get()
            ->keyBy('id_matriks_led');


        // Attach temuan/saran to each data item
        $data->each(function ($item) use ($myTemuanSaran) {
            $ts = $myTemuanSaran->get($item->id);
            $item->myTemuan = $ts?->temuan ?? '';
            $item->mySaran = $ts?->saran ?? '';
        });

        // Hitung syarat unggul (berdasarkan shared data)
        $dataSyaratUnggul = SyaratUnggul::with([
            'matriks.subItemElemen',
            'matriks.userSubItemElements' => function ($q) use ($sharedId, $tahun) {
                $q->where('id_users', $sharedId)
                    ->where('id_user_jurusan', $sharedId)
                    ->where('tahun', $tahun);
            },
            'matriks.userMatrik'          => function ($q) use ($sharedId, $tahun) {
                $q->where('id_users', $sharedId)
                    ->where('id_user_jurusan', $sharedId)
                    ->where('tahun', $tahun);
            }
        ])->get();

        foreach ($dataSyaratUnggul as $item) {
            $item->memenuhi_3_tahun = false;
            $item->memenuhi_5_tahun = false;
            $matriks = $item->matriks;
            if (!$matriks)
                continue;
            $subItems = $matriks->subItemElemen ?? collect();
            $userValues = $matriks->userSubItemElements ?? collect();
            $nilaiMap = $userValues->pluck('nilai', 'id_sub_item_elemen');

            if ($item->nomor == 1) {
                $NDS3 = $NDL = $NDLK = $NDGB = 0;
                foreach ($subItems as $sub) {
                    $id = $sub->id;
                    $var = $sub->variabel;
                    $nilai = (float) ($nilaiMap[$id] ?? 0);
                    if ($var == 'NDS3')
                        $NDS3 = $nilai;
                    if ($var == 'NDL')
                        $NDL = $nilai;
                    if ($var == 'NDLK')
                        $NDLK = $nilai;
                    if ($var == 'NDGB')
                        $NDGB = $nilai;
                }
                $totalLektor = $NDL + $NDLK + $NDGB;
                $efektifLK = $NDLK + $NDGB;
                if ($NDS3 >= 1 && $totalLektor >= 2)
                    $item->memenuhi_3_tahun = true;
                if ($NDS3 >= 2 && $totalLektor >= 2 && $efektifLK >= 1)
                    $item->memenuhi_5_tahun = true;
            } elseif (in_array($item->nomor, [2, 3, 4])) {
                $nilai = (float) ($matriks->userMatrik->jawaban ?? 0);
                if ($nilai >= 3.0)
                    $item->memenuhi_3_tahun = true;
                if ($nilai >= 3.5)
                    $item->memenuhi_5_tahun = true;
            } elseif ($item->nomor == 5) {
                $NM = 0;
                $S1 = $S2 = $S3 = $S4 = $S5 = $S6 = 0;
                $INT = $ISBN = $PATEN = 0;
                foreach ($subItems as $sub) {
                    $id = $sub->id;
                    $var = $sub->variabel;
                    $nilai = (float) ($nilaiMap[$id] ?? 0);
                    if ($var == 'NM')
                        $NM = $nilai;
                    if ($var == 'SINTA1_MHS')
                        $S1 = $nilai;
                    if ($var == 'SINTA2_MHS')
                        $S2 = $nilai;
                    if ($var == 'SINTA3_MHS')
                        $S3 = $nilai;
                    if ($var == 'SINTA4_MHS')
                        $S4 = $nilai;
                    if ($var == 'SINTA5_MHS')
                        $S5 = $nilai;
                    if ($var == 'SINTA6_MHS')
                        $S6 = $nilai;
                    if ($var == 'INT_MHS')
                        $INT = $nilai;
                    if ($var == 'ISBN_MHS')
                        $ISBN = $nilai;
                    if ($var == 'PATEN_MHS')
                        $PATEN = $nilai;
                }
                if ($NM > 0) {
                    $total3 = $S1 + $S2 + $S3 + $S4 + $S5 + $INT + $ISBN + $PATEN;
                    if (($total3 / $NM) * 100 >= 15)
                        $item->memenuhi_3_tahun = true;
                    $total5 = $S1 + $S2 + $S3 + $S4 + $INT + $ISBN + $PATEN;
                    if (($total5 / $NM) * 100 >= 25)
                        $item->memenuhi_5_tahun = true;
                }
            } elseif ($item->nomor == 6) {
                $NDTPS = 0;
                $S4 = $S3 = $S2 = $S1 = $INT = 0;
                foreach ($subItems as $sub) {
                    $id = $sub->id;
                    $var = $sub->variabel;
                    $nilai = (float) ($nilaiMap[$id] ?? 0);
                    if ($var == 'NDTPS')
                        $NDTPS = $nilai;
                    if ($var == 'S4_DTPS')
                        $S4 = $nilai;
                    if ($var == 'S3_DTPS')
                        $S3 = $nilai;
                    if ($var == 'S2_DTPS')
                        $S2 = $nilai;
                    if ($var == 'S1_DTPS')
                        $S1 = $nilai;
                    if ($var == 'INT_DTPS')
                        $INT = $nilai;
                }
                if ($NDTPS > 0) {
                    $total3 = $S4 + $S3 + $S2 + $S1 + $INT;
                    $total5 = $S2 + $S1 + $INT;
                    if (($total3 / $NDTPS) * 100 >= 20)
                        $item->memenuhi_3_tahun = true;
                    if (($total5 / $NDTPS) * 100 >= 20)
                        $item->memenuhi_5_tahun = true;
                }
            }
        }
        $syarat3 = $dataSyaratUnggul->every(fn($i) => $i->memenuhi_3_tahun);
        $syarat5 = $dataSyaratUnggul->every(fn($i) => $i->memenuhi_5_tahun);
        $dataUnggul = $dataSyaratUnggul;

        // Borang, Ambil data auditor
        $kriteria = Kriteria::get();
        $auditor = AuditorJurusan::with('user')->where('jurusan', $userJurusan->homebase)->where('tahun_audit', $tahun)->get();
        // dd($auditor);
// Ambil id jurusan
        $auditHeader = Audit::where('program_studi', $userJurusan->id ?? '')
            ->where('tahun', $tahun)
            ->first();

        // dd($auditHeader);


        $auditKriterias = AuditKriteria::where('jurusan_id', $userJurusan->id)->get();

        // Load jurusan's original self-assessment data (id_user_jurusan = null)
        $jurusanMatrik = UsersMatrik::where('id_users', $sharedId)
            ->whereNull('id_user_jurusan')
            ->where('tahun', $tahun)
            ->get()
            ->keyBy('id_matriks_led');

        $jurusanSubItems = UserSubItemElemen::where('id_users', $sharedId)
            ->whereNull('id_user_jurusan')
            ->where('tahun', $tahun)
            ->get()
            ->groupBy('id_matriks');

        // dd($auditKriterias);
        // dd($userJurusan->homebase, $auditor);

        return view('auditor.evaluasi', compact('data', 'userJurusan', 'assigned', 'syarat3', 'syarat5', 'dataUnggul', 'kriteria', 'auditor', 'auditKriterias', 'auditHeader', 'jurusanMatrik', 'jurusanSubItems', 'tahun'));
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
            'tahun'                => 'required|digits:4|integer|min:2000|max:2099',
        ]);

        $tahun = $validated['tahun'];

        $target = User::findOrFail($validated['id_user_jurusan']);
        $assigned = AuditorJurusan::where('user_id', auth()->id())
            ->where('jurusan', $target->homebase)
            ->where('tahun_audit', $tahun)
            ->firstOrFail();

        $sharedId = $target->id;

        $incomingNilaiTotal = $validated['nilai_total'];
        $incomingJawaban = $validated['jawaban'];

        Log::debug('auditorEvaluasiStore', [
            'incomingNilaiTotal' => $incomingNilaiTotal,
            'incomingJawaban'    => $incomingJawaban,
            'id_matriks_led'     => $validated['id_matriks_led'],
        ]);

        // Bersihkan duplikat lama yang mungkin terbentuk akibat race-condition auto-save
        // (tanpa unique constraint di DB, updateOrCreate bisa menghasilkan baris ganda)
        UsersMatrik::where('id_users', $sharedId)
            ->where('id_user_jurusan', $sharedId)
            ->where('id_matriks_led', $validated['id_matriks_led'])
            ->where('tahun', $tahun)
            ->where('id', '<>', function ($q) use ($sharedId, $validated, $tahun) {
                $q->select('id')
                    ->from('users_matrik')
                    ->where('id_users', $sharedId)
                    ->where('id_user_jurusan', $sharedId)
                    ->where('id_matriks_led', $validated['id_matriks_led'])
                    ->where('tahun', $tahun)
                    ->orderBy('id')
                    ->limit(1);
            })
            ->delete();

        // Save shared score to UsersMatrik: id_users = jurusan_id, id_user_jurusan = jurusan_id
        UsersMatrik::updateOrCreate(
            [
                'id_users'        => $sharedId,
                'id_user_jurusan' => $sharedId,
                'id_matriks_led'  => $validated['id_matriks_led'],
                'tahun'           => $tahun,
            ],
            [
                'jawaban'              => $incomingJawaban,
                'skor_a'               => $validated['skor_a'] ?? null,
                'skor_b'               => $validated['skor_b'] ?? null,
                'nilai_total'          => $incomingNilaiTotal,
                'link_bukti'           => $validated['link_bukti'] ?? '',
                'kepemilikan_kriteria' => $validated['kepemilikan_kriteria'],
                'tahun'                => $tahun,
            ]
        );

        // Save per-auditor temuan/saran to auditor_temuan_saran
        \DB::table('auditor_temuan_saran')->updateOrInsert(
            [
                'id_users'        => auth()->id(),
                'id_user_jurusan' => $sharedId,
                'id_matriks_led'  => $validated['id_matriks_led'],
            ],
            [
                'temuan'     => $validated['temuan'] ?? '',
                'saran'      => $validated['saran'] ?? '',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Save sub-items as shared (id_users = jurusan_id)
        if ($request->has('variabel')) {
            foreach ($request->variabel as $idSubItem => $nilai) {
                if ($nilai === null || $nilai === '') {
                    continue;
                }
                UserSubItemElemen::updateOrCreate(
                    [
                        'id_matriks'         => $validated['id_matriks_led'],
                        'id_sub_item_elemen' => $idSubItem,
                        'id_users'           => $sharedId,
                        'id_user_jurusan'    => $sharedId,
                        'tahun'              => $tahun,
                    ],
                    ['nilai' => $nilai, 'tahun' => $tahun]
                );
            }
        }

        return redirect()->route('auditor.evaluasi', $assigned->id)
            ->with('success', 'Data berhasil diperbarui');
    }

    public function auditorPerbandingan($id)
    {
        $assigned = AuditorJurusan::where('user_id', auth()->id())->findOrFail($id);
        $tahun = $assigned->tahun_audit;


        $userJurusan = User::where('homebase', $assigned->jurusan)
            ->where('role', 'admin_jurusan')->first();
        if (!$userJurusan) {
            return redirect()->route('auditor.index')->with('error', 'Belum ada data jurusan.');
        }

        $sharedId = $userJurusan->id;

        // Load shared auditor scores + combined temuan/saran from auditor_temuan_saran
        $allTemuanSaran = \DB::table('auditor_temuan_saran')
            ->join('users', 'auditor_temuan_saran.id_users', '=', 'users.id')
            ->where('auditor_temuan_saran.id_user_jurusan', $sharedId)
            ->select('auditor_temuan_saran.*', 'users.name as auditor_name')
            ->get()
            ->groupBy('id_matriks_led');


        $data = MatriksLED::with([
            'kriteria',
            'userMatrik'       => function ($q) use ($userJurusan, $tahun) {
                $q->where('id_users', $userJurusan->id)->where('tahun', $tahun);
            },
            'userMatrikByUser' => function ($q) use ($sharedId, $tahun) {
                $q->where('id_users', $sharedId)
                    ->where('id_user_jurusan', $sharedId)
                    ->where('tahun', $tahun);
            }
        ])->orderBy('nomor', 'asc')->get();

        // Attach combined temuan/saran to each item
        $data->each(function ($item) use ($allTemuanSaran) {
            $tsItems = $allTemuanSaran[$item->id] ?? collect();
            if ($tsItems->isNotEmpty()) {
                $item->auditorTemuan = $tsItems->map(function ($ts) {
                    return e($ts->auditor_name) . ' : ' . e($ts->temuan);
                })->implode('<br>');
                $item->auditorSaran = $tsItems->map(function ($ts) {
                    return e($ts->auditor_name) . ' : ' . e($ts->saran);
                })->implode('<br>');
            } else {
                $item->auditorTemuan = '-';
                $item->auditorSaran = '-';
            }
        });

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
            'jabatan'  => 'required',
            'nip'      => 'nullable',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required',
        ], [
            'name.required'    => 'Nama user wajib diisi.',
            'nip.required'     => 'NIP wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'email.unique'     => 'Email sudah terdaftar.',
            'role.required'    => 'Role wajib diisi.',
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
            'jabatan'  => 'required',
            'nip'      => 'nullable',
            'email'    => 'required|email',
            'role'     => 'required',
        ], [
            'name.required'    => 'Nama user wajib diisi.',
            'nip.required'     => 'NIP wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'role.required'    => 'Role wajib diisi.',
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
