<?php

use App\Http\Controllers\AkreditasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\EvaluasiDiriJurusan;
use App\Http\Controllers\EvaluasiLamdikController;
use App\Http\Controllers\EvaluasiLaporanController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\PPEPP\EvaluasiController;
use App\Http\Controllers\PPEPP\PelaksanaanController;
use App\Http\Controllers\PPEPP\PenetapanController;
use App\Http\Controllers\PPEPP\PengendalianController;
use App\Http\Controllers\PPEPP\PeningkatanController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SyaratController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AkreditasiController::class, 'index'])
    ->name('akreditasi');


Route::get('/profil', function () {
    return view('profil');
})->name('profil');

Route::resource('dashboard', DashboardController::class);
Route::resource('akreditasi', AkreditasiController::class);

Route::middleware('auth')->group(function () {

    Route::resource('dokumen', DokumenController::class);
    Route::resource('evaluasi', EvaluasiController::class);
    Route::resource('evaluasi_lamdik', EvaluasiLamdikController::class);
    Route::resource('evaluasi_laporan', EvaluasiLaporanController::class);
    Route::resource('pelaksanaan', PelaksanaanController::class);
    Route::resource('penetapan', PenetapanController::class);
    Route::resource('pengendalian', PengendalianController::class);
    Route::resource('peningkatan', PeningkatanController::class);
    Route::resource('survey', SurveyController::class);


    // Masalah nya karena tadi mnenggunaan /akreditasi/---

    Route::get('/export/preview', [ExportController::class, 'previewPdf']);
    Route::get('/export/preview/perbandingan', [ExportController::class, 'previewPdfPerbandingan']);
    Route::get('/export/preview/perbandingan/upm/{id}', [ExportController::class, 'previewPdfPerbandinganUpm']);

    Route::get('/export/export-pdf', [ExportController::class, 'exportPdf']);
    Route::get('/export/export-pdf/perbandingan', [ExportController::class, 'exportPdfPerbandingan']);
    Route::get('/export/export-pdf/perbandingan/upm/{id}', [ExportController::class, 'exportPdfPerbandinganUpm']);

    // routes/web.php
    Route::get('/debug-fetch', function () {
        return response('<h2>HELLO DARI LARAVEL</h2>', 200);
    });


});

// Auth role admin FKIP
Route::middleware(['auth', 'role:admin_FKIP'])->group(function () {
    // GANTI URL EDIT RESOURCE
    Route::get(
        '/isi-evaluasi/{evaluasi_diri_jurusan}',
        [EvaluasiDiriJurusan::class, 'edit']
    )->name('evaluasi_diri_jurusan.edit.custom');

    Route::post(
        '/admin/reset-password/{user}',
        [UserController::class, 'resetPassword']
    );

    Route::resource('evaluasi_diri_jurusan', EvaluasiDiriJurusan::class);
    Route::resource('user', UserController::class);
    Route::resource('jurusan', JurusanController::class);
});

// Auth role admin Jurusan
Route::middleware(['auth', 'role:admin_jurusan'])->group(function () {

});

// Auth role pimpinan
Route::middleware(['auth', 'role:pimpinan'])->group(function () {
    Route::resource('pimpinan', PimpinanController::class);
    Route::get('/evaluasi-diri-jurusan', [PimpinanController::class, 'perbandingan'])->name('evaluasi_diri_jurusan.perbandingan');
    Route::get('/pimpinan/perbandingan/evaluasi-diri-jurusan/{id}', [PimpinanController::class, 'perbandinganJurusan'])->name('evaluasi_diri_jurusan.perbandinganJurusan');
});



// Route::middleware(['role:admin_FKIP'])->group(function () {

// });




// Login by URL
// Route::get('/login', function () {
//     Auth::logout();
//     Auth::loginUsingId(1);
//     return redirect()->back();
// })->name('login');
Route::get(
    '/login',
    [AuthController::class, 'index']
)->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.auth');

// Halaman Reset Password
Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('reset.password');
Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('update.auth');

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

// Ini untuk controller SyaratUnggul
Route::get('/syarat-unggul', [SyaratController::class, 'index']);