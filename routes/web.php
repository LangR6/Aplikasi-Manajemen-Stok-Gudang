<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KelolaBarangController;

Route::get('/login', [LoginController::class, 'login']);

Route::get('/kelola_barang', [KelolaBarangController::class, 'index'])->name('kelola_barang');
