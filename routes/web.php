<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Models\JenisIdentitas;


Route::get('/', function () {
    return redirect()->route('tamu.index');
});

// Menampilkan halaman registrasi tamu
Route::get('/register', [TamuController::class, 'index'])->name('tamu.index');

// Menyimpan data tamu
Route::post('/register', [TamuController::class, 'store'])->name('tamu.store');
