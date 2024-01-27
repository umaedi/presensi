<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\OpratorController;
use Illuminate\Support\Facades\Route;

//route login
Route::get('/', Users\LoginController::class)->middleware('guest');

//route user 
Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/dashboard', Users\DashboardController::class);

    Route::get('/presensi', [Users\PersensiController::class, 'index']);
    Route::post('/presensi/store', [Users\PersensiController::class, 'store']);
    Route::post('/presensi/store_file', [Users\PersensiController::class, 'storeFile']);
    Route::post('/presensi/remove_file', [Users\PersensiController::class, 'removeFile']);

    Route::get('/izin', [Users\IzinController::class, 'index']);
    Route::post('/izin/store', [Users\IzinController::class, 'store']);
    Route::put('/izin/update', [Users\IzinController::class, 'update']);
    Route::get('/izin/print', [Users\IzinController::class, 'print']);

    Route::get('/dl', [Users\DlController::class, 'index']);
    Route::post('/presensi_dl/store', [Users\DlController::class, 'store']);

    Route::get('/apel', [Users\ApelController::class, 'index']);
    Route::post('/presensi_apel/store', [Users\ApelController::class, 'store']);

    Route::get('/histories', [Users\HistoryController::class, 'index']);
    Route::get('/history/print', [Users\HistoryController::class, 'print']);

    Route::get('/profile', [Users\ProfileController::class, 'index']);
    Route::get('/scan', Users\ScanController::class);
});

//route for oprator
Route::middleware(['auth', 'oprator'])->prefix('oprator')->group(function () {
    Route::get('/dashboard', [Oprator\DashboardController::class, 'index']);
    Route::get('/pegawai', [Oprator\PegawaiController::class, 'index']);
    Route::post('/pegawai/store', [Oprator\PegawaiController::class, 'store']);
    Route::get('/pegawai/show/{id}', [Oprator\PegawaiController::class, 'show']);
    Route::put('/pegawai/update/{id}', [Oprator\PegawaiController::class, 'update']);

    Route::get('/cuti', [Oprator\CutiController::class, 'index']);
    Route::get('/cuti/show/{id}', [Oprator\CutiController::class, 'show']);

    //mster presensi
    Route::get('/presensi', [Oprator\PresensiController::class, 'index']);

    //import pegawai
    Route::post('/importuser', ImportuserController::class);

    //export presensi
    Route::get('/presensi/export', Oprator\ExportpresensiController::class);

    Route::get('profile', Oprator\ProfileController::class);
});

//route for admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index']);

    Route::get('/opd', [Admin\OpdController::class, 'index']);
    Route::get('/opd/create', [Admin\OpdController::class, 'create']);
    Route::post('/opd/store', [Admin\OpdController::class, 'store']);
    Route::get('/opd/show/{id}', [Admin\OpdController::class, 'show']);
    Route::put('/opd/update/{id}', [Admin\OpdController::class, 'update']);

    Route::get('/presensi/opd/show/{id}', [Admin\PresensiopdController::class, 'show']);

    Route::get('/pegawai', [Admin\UserController::class, 'index']);
    Route::post('/pegawai/store', [Admin\UserController::class, 'store']);
    Route::get('/pegawai/show/{id}', [Admin\UserController::class, 'show']);
    Route::get('/user/destroy/{id}', [Admin\UserController::class, 'destroy']);

    Route::get('/oprator', [Admin\OpratorController::class, 'index']);
    Route::post('/oprator/store', [Admin\OpratorController::class, 'store']);

    //import pegawai
    Route::post('/importuser', ImportuserController::class);

    //report
    Route::get('/laporan', [Admin\LaporanController::class, 'index']);
});
