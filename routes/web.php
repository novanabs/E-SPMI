<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluasiLamdikController;
use App\Http\Controllers\PPEPP\EvaluasiController;
use App\Http\Controllers\EvaluasiLaporanController;
use App\Http\Controllers\PPEPP\PenetapanController;
use App\Http\Controllers\PPEPP\PelaksanaanController;
use App\Http\Controllers\PPEPP\PeningkatanController;
use App\Http\Controllers\PPEPP\PengendalianController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/profil', function () {
    return view('profil');
})->name('profil');

Route::resource('dashboard', DashboardController::class);
Route::resource('dokumen', DokumenController::class);
Route::resource('evaluasi', EvaluasiController::class);
Route::resource('evaluasi.lamdik', EvaluasiLamdikController::class);
Route::resource('evaluasi.laporan', EvaluasiLaporanController::class);
Route::resource('pelaksanaan', PelaksanaanController::class);
Route::resource('penetapan', PenetapanController::class);
Route::resource('pengendalian', PengendalianController::class);
Route::resource('peningkatan', PeningkatanController::class);
Route::resource('survey', SurveyController::class);


// Login by URL
Route::get('/login-jurusan', function () {
    Auth::logout();
    Auth::loginUsingId(1);
    return redirect('/');
})->name('login-jurusan');

Route::get('/login-admin', function () {
    Auth::logout();
    Auth::loginUsingId(3);
    return redirect('/');
})->name('login-admin');

Route::get('/login-pimpinan', function () {
    Auth::logout();
    Auth::loginUsingId(5);
    return redirect('/');
})->name('login-pimpinan');

// Ini sementara log-out lewat sini
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});