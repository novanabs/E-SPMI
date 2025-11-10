<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenetapanController;
use App\Http\Controllers\PelaksanaanController;
use App\Http\Controllers\PeningkatanController;
use App\Http\Controllers\PengendalianController;
use App\Http\Controllers\EvaluasiLamdikController;
use App\Http\Controllers\EvaluasiLaporanController;

Route::get('/', function () {
    return view('dashboard');
});

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