<?php

use App\Http\Controllers\AkreditasiController;
use App\Http\Controllers\EvaluasiDiriJurusan;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PimpinanController;
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
    if (!auth()->check()) {
        Auth::loginUsingId(1);
    }
    return view('dashboard');
})->name('dashboard');

Route::get('/profil', function () {
    return view('profil');
})->name('profil');

Route::middleware('auth')->group(function () {

    Route::resource('dashboard', DashboardController::class);
    Route::resource('dokumen', DokumenController::class);
    Route::resource('evaluasi', EvaluasiController::class);
    Route::resource('evaluasi_lamdik', EvaluasiLamdikController::class);
    Route::resource('evaluasi_laporan', EvaluasiLaporanController::class);
    Route::resource('pelaksanaan', PelaksanaanController::class);
    Route::resource('penetapan', PenetapanController::class);
    Route::resource('pengendalian', PengendalianController::class);
    Route::resource('peningkatan', PeningkatanController::class);
    Route::resource('survey', SurveyController::class);
    Route::resource('pimpinan', PimpinanController::class);
    Route::resource('akreditasi', AkreditasiController::class);
    Route::resource('evaluasi_diri_jurusan', EvaluasiDiriJurusan::class);



});

Route::middleware(['role:admin_FKIP'])->group(function () {
    Route::resource('jurusan', JurusanController::class);
});




// Login by URL
Route::get('/login', function () {
    Auth::logout();
    Auth::loginUsingId(1);
    return redirect()->back();
})->name('login');

Route::get('/login-jurusan-pilkom', function () {
    Auth::logout();
    Auth::loginUsingId(1);
    return redirect()->back();
})->name('login-jurusan-pilkom');

Route::get('/login-jurusan-penko', function () {
    Auth::logout();
    Auth::loginUsingId(2);
    return redirect()->back();
})->name('login-jurusan-penko');

Route::get('/login-admin', function () {
    Auth::logout();
    Auth::loginUsingId(3);
    return redirect()->back();
})->name('login-admin');

Route::get('/login-pimpinan', function () {
    Auth::logout();
    Auth::loginUsingId(5);
    return redirect()->back();
})->name('login-pimpinan');

// Ini sementara log-out lewat sini
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->back();
});

// Ini sementara log-out lewat sini
Route::get('/lamdik-old', function () {
    return view('EvaluasiLamdik.indexOld');
});

