<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\Auth\AuthController;
use App\Models\JenisIdentitas;

// Root route - cek status auth
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
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

// Protected routes - hanya untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Main dashboard route - akan redirect ke dashboard sesuai role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'getData'])->name('dashboard.data');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // =================== ADMIN ROUTES (role_id = 1) ===================
    Route::middleware('auth')->group(function () {
        // User Management - menggunakan UserController yang sudah ada
        Route::prefix('user')->name('admin.users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/list', [UserController::class, 'list'])->name('list');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::get('/{id}', [UserController::class, 'show'])->name('show');
            Route::delete('/{id}', [UserController::class, 'delete'])->name('delete');
        });
        
        
        // Tamu Management untuk Admin
        Route::prefix('admin/tamu')->name('admin.tamu.')->group(function () {
            Route::get('/', function() {
                $tamus = \App\Models\TamuModel::with('jenisIdentitas')->paginate(15);
                return view('pages.user.index', compact('tamus'));
            })->name('index');
            
            Route::post('/{tamu}/approve', function(\App\Models\TamuModel $tamu) {
                $tamu->update(['status' => 'approved', 'approved_by' => auth()->id(), 'approved_at' => now()]);
                return response()->json(['success' => true, 'message' => 'Tamu approved successfully']);
            })->name('approve');
            
            Route::post('/{tamu}/reject', function(\App\Models\TamuModel $tamu) {
                $tamu->update(['status' => 'rejected']);
                return response()->json(['success' => true, 'message' => 'Tamu rejected successfully']);
            })->name('reject');
            
            Route::delete('/{tamu}', function(\App\Models\TamuModel $tamu) {
                $tamu->delete();
                return response()->json(['success' => true, 'message' => 'Tamu deleted successfully']);
    })->name('delete');
        });
    });
    
    // =================== PEGAWAI ROUTES (role_id = 2) ===================
    Route::middleware('auth')->prefix('pegawai')->name('pegawai.')->group(function () {
        
        Route::get('/dashboard', function() {
            return app(DashboardController::class)->pegawaiDashboard();
        })->name('dashboard');
        
        // Pegawai specific routes bisa ditambah disini
        Route::get('/approval', function() {
            $tamus = \App\Models\TamuModel::where('status', 'checkin')->paginate(10);
            return view('pages.pegawai.index', compact('tamus'));
        })->name('approval');
            
        Route::post('/tamu/{id}/approve', [PegawaiController::class, 'approveTamu'])
        ->name('tamu.approve');

    });

    // =================== SECURITY ROUTES (role_id = 3) ===================
    Route::middleware('auth')->prefix('security')->name('security.')->group(function () {
        Route::get('/', [SecurityController::class, 'index'])->name('index');
        Route::get('/list', [SecurityController::class, 'list'])->name('list');
        Route::get('/create', [SecurityController::class, 'create'])->name('create');
        Route::post('/store', [SecurityController::class, 'store'])->name('store');
        Route::get('/{id}', [SecurityController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SecurityController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SecurityController::class, 'update'])->name('update');
        Route::delete('/{id}', [SecurityController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/checkin', [SecurityController::class, 'checkin'])->name('checkin');
        Route::post('/{id}/checkout', [SecurityController::class, 'checkout'])->name('checkout');
    });

});