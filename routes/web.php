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

Route::get('/login', [LoginController::class, 'login']);
Route::post('/loginaction', [LoginController::class, 'loginAction'])->name('loginaction');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/kelola_barang', [KelolaBarangController::class, 'index'])->name('kelola_barang');

Route::get('/kategori', [KelolaKategoriController::class, 'index'])->name('kelola_kategori');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// RIWAYAT
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
Route::get('/riwayat/export', [RiwayatController::class, 'exportExcel'])->name('riwayat.export');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// SUPPLIER
Route::get('/kelola_supplier', [SupplierController::class, 'index'])->name('kelola_supplier');
Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
