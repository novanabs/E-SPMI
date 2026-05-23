<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditorJurusan;
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
            'email'    => 'required|email',
            'role'     => 'required',
        ], [
            'name.required'  => 'Nama user wajib diisi.',
            'nip.required' => 'NIP wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'role.required'  => 'Role wajib diisi.',
        ]);

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
