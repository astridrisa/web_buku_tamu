<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Models\JenisIdentitas;


Route::get('/', function () {
    return view('welcome');
});

// Menampilkan halaman registrasi tamu
Route::get('/tamu/register', [TamuController::class, 'index'])->name('tamu.index');

// Menyimpan data tamu
Route::post('/tamu/register', [TamuController::class, 'store'])->name('tamu.store');
