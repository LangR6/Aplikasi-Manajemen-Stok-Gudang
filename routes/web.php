<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;

Route::get('/login', [LoginController::class, 'login']);

Route::get('/kategori', [KategoriController::class, 'kategori']);
