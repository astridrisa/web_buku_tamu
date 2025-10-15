<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\Auth\AuthController;
use App\Models\JenisIdentitas;
use App\Http\Controllers\ProfileController;

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

// Route untuk display QR Code (tanpa auth)
Route::get('/tamu/qr/{qr_code}', [App\Http\Controllers\TamuController::class, 'showQrCode'])
    ->name('tamu.qr.show');

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

         // Notifications
        Route::get('/notifications', [PegawaiController::class, 'notifications'])->name('notifications');
        Route::post('/notifications/{id}/read', [PegawaiController::class, 'markNotificationRead'])->name('notifications.read');
        Route::post('/notifications/mark-all-read', [PegawaiController::class, 'markAllNotificationsRead'])->name('notifications.mark-all-read');

            
        Route::post('/tamu/{id}/approve', [PegawaiController::class, 'approve'])
        ->name('tamu.approve');

        Route::get('/{id}', [PegawaiController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PegawaiController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PegawaiController::class, 'update'])->name('update');
        Route::delete('/{id}', [PegawaiController::class, 'delete'])->name('delete');
        // Route::post('/{id}/approve', [PegawaiController::class, 'approve'])->name('tamu.approve');
    
       
    });

    // =================== SECURITY ROUTES (role_id = 3) ===================
    Route::middleware('auth')->prefix('security')->name('security.')->group(function () {
        Route::get('/', [SecurityController::class, 'index'])->name('index');
        Route::get('/list', [SecurityController::class, 'list'])->name('list');
        Route::get('/create', [SecurityController::class, 'create'])->name('create');
        Route::post('/store', [SecurityController::class, 'store'])->name('store');
        
        // ✅ PINDAHKAN NOTIFICATIONS KE ATAS SEBELUM /{id}
        Route::get('/notifications', [SecurityController::class, 'notifications'])->name('notifications');
        Route::post('/notifications/{id}/read', [SecurityController::class, 'markNotificationRead'])->name('notifications.read');
        Route::post('/notifications/mark-all-read', [SecurityController::class, 'markAllNotificationsRead'])->name('notifications.mark-all-read');
        
        // Route dengan parameter {id} harus di bawah
        Route::get('/{id}', [SecurityController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SecurityController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SecurityController::class, 'update'])->name('update');
        Route::delete('/{id}', [SecurityController::class, 'delete'])->name('delete');
        Route::post('/{id}/checkin', [SecurityController::class, 'checkin'])->name('checkin');
        Route::post('/{id}/checkout', [SecurityController::class, 'checkout'])->name('checkout');
    });


    // try profile page


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});