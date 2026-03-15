<?php
use App\Http\Controllers\LoginController;

Route::get('/', [LoginController::class, 'index']);

Route::post('/login', [LoginController::class, 'login']);
?>
