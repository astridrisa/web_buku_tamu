<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\DashboardController;
use App\Models\JenisIdentitas;
use App\Http\Controllers\Auth\AuthController;

// Root route - cek status auth
Route::get('/', function () {
    // if (auth()->check()) {
    //     return redirect()->route('dashboard');
    // }
    return redirect()->route('tamu.index');
});

// Tamu registration routes - bisa diakses semua orang
Route::get('/register', [TamuController::class, 'index'])->name('tamu.index');
Route::post('/register', [TamuController::class, 'store'])->name('tamu.store');

// Auth routes - hanya untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Logout - hanya untuk user yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
