<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KelolaBarangController;
use App\Http\Controllers\KelolaKategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'login'])
    ->name('login');

Route::post('/loginaction', [LoginController::class, 'loginAction'])
    ->name('loginaction');

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| ROUTE YANG HARUS LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::put('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | KELOLA BARANG
    |--------------------------------------------------------------------------
    */

    Route::get('/kelola_barang', [KelolaBarangController::class, 'index'])
        ->name('kelola_barang');

    Route::post('/kelola_barang', [KelolaBarangController::class, 'store'])
        ->name('kelola_barang.store');

    Route::put('/kelola_barang/{kode}', [KelolaBarangController::class, 'update'])
        ->name('kelola_barang.update');

    Route::post('/kelola_barang/masuk', [KelolaBarangController::class, 'masuk'])
        ->name('kelola_barang.masuk');

    Route::post('/kelola_barang/keluar', [KelolaBarangController::class, 'keluar'])
        ->name('kelola_barang.keluar');

    /*
    |--------------------------------------------------------------------------
    | KATEGORI
    |--------------------------------------------------------------------------
    */

    Route::get('/kategori', [KelolaKategoriController::class, 'index'])
        ->name('kelola_kategori');

    Route::post('/kategori', [KelolaKategoriController::class, 'store'])
        ->name('kelola_kategori.store');

    Route::put('/kategori/{id}', [KelolaKategoriController::class, 'update'])
        ->name('kelola_kategori.update');

    Route::delete('/kategori/{id}', [KelolaKategoriController::class, 'destroy'])
        ->name('kelola_kategori.destroy');

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT
    |--------------------------------------------------------------------------
    */

    Route::get('/riwayat', [RiwayatController::class, 'index'])
        ->name('riwayat');

    Route::get('/riwayat/export', [RiwayatController::class, 'exportExcel'])
        ->name('riwayat.export');

    /*
    |--------------------------------------------------------------------------
    | SUPPLIER
    |--------------------------------------------------------------------------
    */

    Route::get('/kelola_supplier', [SupplierController::class, 'index'])
        ->name('kelola_supplier');

    Route::post('/supplier/store', [SupplierController::class, 'store'])
        ->name('supplier.store');

    Route::put('/supplier/update/{id}', [SupplierController::class, 'update'])
        ->name('supplier.update');

    Route::delete('/supplier/delete/{id}', [SupplierController::class, 'destroy'])
        ->name('supplier.destroy');
});
