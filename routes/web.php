<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KelolaBarangController;
use App\Http\Controllers\KelolaKategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RiwayatController; // Riwayat

Route::get('/login', [LoginController::class, 'login']);

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/kelola_barang', [KelolaBarangController::class, 'index'])->name('kelola_barang');

Route::get('/kategori', [KelolaKategoriController::class, 'index'])->name('kelola_kategori');

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// RIWAYAT
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
Route::get('/riwayat/export', [RiwayatController::class, 'exportExcel'])->name('riwayat.export');

Route::post('/supplier/store', function (Request $request) {
    $request->validate([
        'nama_supplier' => 'required|string|max:255',
        'kontak' => 'required|string|max:100',
        'kota' => 'required|string|max:100',
        'email' => 'required|email|max:255',
    ]);

    return redirect()->route('dashboard')->with('success', 'Supplier berhasil ditambahkan.');
})->name('supplier.store');
