<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TamuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // bikin view login.blade.php
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',  // bisa email / username
            'password' => 'required|string',
        ]);

        // cek apakah input berupa email atau username
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // coba login
        if (Auth::attempt([$fieldType => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'login' => 'Email/Username atau password salah.',
        ])->onlyInput('login');
    }

     // Tampilkan form login khusus dari QR scan
    public function showQrLoginForm($id)
    {
        $tamu = TamuModel::with(['jenisIdentitas'])->findOrFail($id);
        
        // Jika sudah login, langsung redirect ke approve
        if (Auth::check() && Auth::user()->role === 'pegawai') {
            return redirect()->route('pegawai.show', $id);
        }
        
        return view('auth.login-qr', compact('tamu'));
    }

    // Proses login dari QR scan
    public function loginFromQr(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari data tamu berdasarkan ID
        $tamu = TamuModel::findOrFail($id);

        // Tentukan apakah input login berupa email atau username
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // Coba login dengan guard default (web)
        if (Auth::attempt([$fieldType => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Jika user role-nya Pegawai (role_id = 2)
            if ($user->role_id == 2) {
                Log::info('Pegawai logged in from QR scan', [
                    'pegawai_id' => $user->id,
                    'tamu_id' => $id
                ]);

                // Redirect ke halaman detail tamu / approval
                return redirect()->route('pegawai.show', $id)
                    ->with('success', 'Tamu berhasil check-in melalui QR.');
            }

            // Kalau bukan Pegawai, logout dan beri error
            Auth::logout();
            return back()->withErrors([
                'login' => 'Hanya pegawai yang dapat melakukan approval melalui QR.',
            ]);
        }

        // Jika login gagal
        return back()->withErrors([
            'login' => 'Email/Username atau password salah.',
        ])->withInput();
    }


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('tamu.index'); // balik ke tamu/register
    }
}