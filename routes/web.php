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

Route::prefix('security')->name('security.')->group(function () {
    Route::get('/', [SecurityController::class, 'index'])->name('index');
    Route::get('/list', [SecurityController::class, 'list'])->name('list');
    Route::get('/create', [SecurityController::class, 'create'])->name('create'); // BARU
    Route::post('/store', [SecurityController::class, 'store'])->name('store');
    Route::get('/{id}', [SecurityController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [SecurityController::class, 'edit'])->name('edit'); // BARU
    Route::put('/{id}', [SecurityController::class, 'update'])->name('update');
    Route::delete('/{id}', [SecurityController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/checkin', [SecurityController::class, 'checkin'])->name('checkin');
    Route::post('/{id}/checkout', [SecurityController::class, 'checkout'])->name('checkout');
});
