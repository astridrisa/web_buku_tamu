<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Models\JenisIdentitas;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return redirect()->route('tamu.index');
});

// Menampilkan halaman registrasi tamu
Route::get('/register', [TamuController::class, 'index'])->name('tamu.index');

// Menyimpan data tamu
Route::post('/register', [TamuController::class, 'store'])->name('tamu.store');


// login, logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
