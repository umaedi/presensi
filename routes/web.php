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

// Route::get('opd/admin', function () {
//     return view('opd.login.index');
// });

// Route::prefix('opd')->group(function () {
//     Route::middleware(['opd', 'pegawai'])->group(function () {
//         Route::get('/dashboard', \App\Http\Controllers\Opd\Dashboard::class)->name('opd.dashboard');

//         Route::controller(\App\Http\Controllers\Opd\PegawaiController::class)->group(function () {
//             Route::get('/pegawai', 'index');
//             Route::get('/pegawai/tambah', 'create')->name('opd.pegawai.create');
//             Route::post('/pegawai/tambah/store', 'store')->name('opd.pegawai.store');
//             Route::get('/pegawai/{id}', 'show')->name('opd.pejabat.show');
//             Route::post('/pegawai/update/{id}', 'update')->name('opd.pegawai.update');
//         });

//         Route::controller(\App\Http\Controllers\Opd\PersensiController::class)->group(function () {
//             Route::get('/pegawai/persensi/{id}', 'index');
//             Route::get('/persensi/print/{id}', 'print');
//         });

//         Route::controller(\App\Http\Controllers\Opd\ImportController::class)->group(function () {
//             Route::get('/pegawai/imoort/excel', 'index')->name('opd.pegawai.import');
//             // Route::post('/pegawai/import/store', 'store')->name('opd.pegawai.store');
//         });
//     });
// });

// Route::get('/', function () {

//     if (auth()->guard('pegawai')->check()) {
//         return redirect('/pegawai/dashboard');
//     }
//     return view('pegawai.login.index');
// });

// Route::prefix('pegawai')->group(function () {
//     //route login stap
//     Route::post('/login', \App\Http\Controllers\Pegawai\loginController::class)->name('pegawai.login');

//     Route::middleware('pegawai')->group(function () {
//         //route dashboard stap
//         Route::get('/dashboard', \App\Http\Controllers\Pegawai\DashboardController::class)->name('pegawai.dashboard');

//         //route absensi
//         Route::controller(\App\Http\Controllers\Pegawai\AbsenController::class)->group(function () {
//             Route::get('absent', 'index')->name('pegawai.absent');
//             Route::post('absent/store', 'store')->name('pegawai.absen.store');
//         });

//         //histori absensi
//         Route::get('/history', [\App\Http\Controllers\Pegawai\HistoryController::class, 'index'])->name('pegawai.histories');
//         Route::get('/history/print', [\App\Http\Controllers\Pegawai\HistoryController::class, 'print'])->name('pegawai.histories.print');

//         Route::controller(\App\Http\Controllers\Pegawai\ProfileController::class)->group(function () {
//             Route::get('/profile', 'index')->name('pegawai.profile');
//             Route::post('/profile/update', 'updateProfile');
//             Route::post('/profile/update/password', 'updatePassword');
//         });

//         Route::controller(\App\Http\Controllers\Pegawai\CutyController::class)->group(function () {
//             Route::get('/izin', 'index')->name('pegawai.izin');
//             Route::post('/izin/store', 'store');
//             Route::post('/izin/update', 'update');
//             Route::get('/izin/print', 'print');
//         });

//         Route::get('/logout', \App\Http\Controllers\Pegawai\LogoutController::class)->name('pegawai.logout');
//     });

//     Route::get('/ayokabsent', function () {
//         return view('pegawai.qrcode.index');
//     });
// });
