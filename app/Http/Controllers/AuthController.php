<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required'  => 'Password baru harus diisi!',
            'password.min'       => 'Password minimal 6 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
        ]);

        $user = Auth::user(); // Ambil user yang sedang login

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan!');
        }

        // Update password di tabel users
        $user->update([
            'password'           => Hash::make($request->password),
            'generated_password' => null,
            'password_changed'   => true,
        ]);


        return redirect()->route('login')->with('success', 'Password berhasil diperbarui! Silakan login kembali.');
    }
}
