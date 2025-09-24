<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Models\JenisIdentitas;
use App\Http\Controllers\Auth\AuthController;

// Root route - cek status auth
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('tamu.index');
});

// Dashboard - hanya untuk user yang sudah login
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


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
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
