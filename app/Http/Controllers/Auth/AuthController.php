<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TamuModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // login.blade.php
    }

    // Proses login (biasa)
    public function login(Request $request)
    {
        // Validasi input

        $request->validate([
            'kopeg' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = UserModel::where('kopeg', $request->kopeg)->first();

    if ($user && Auth::attempt(['kopeg' => $request->kopeg, 'password' => $request->password], $request->filled('remember'))) {
        // User berhasil login lokal
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
 // redirect ke dashboard
    }

        try {
            $token = env('API_TOKEN', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkYXRhIjoiSGVsbG8sIFdvcmxkISIsImV4cGlyZWRfdG9rZW4iOiIyMDI2LTA2LTAzIDE0OjQ0OjA1In0.81M6qkPwrHN4qON2KKXZLjsGxMs0nNjW10TDQrYkzVs'); // Ganti dengan token yang sesuai
            $curl = curl_init();

            // Header Authorization dengan token
            $auth_data = array(
                'Bearer:' . $token,
            );

            // Data yang dikirimkan
            $data = array(
                'kopeg' => ($request->kopeg),
                'password' => ($request->password)
            );

            // Encode data menjadi JSON
            $body = json_encode($data);

            // Set cURL options
            curl_setopt($curl, CURLOPT_URL, 'https://hadir.jasatirta1.co.id/api/login');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $auth_data); // Header Authorization
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body); // Kirimkan data JSON sebagai body
            curl_setopt($curl, CURLOPT_TIMEOUT, 10); // timeout optional, untuk keamanan

            // Eksekusi cURL
            $result = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if (!$result) {
                throw new \Exception('Gagal menghubungi server API');
            }

            if ($httpCode !== 200) {
                throw new \Exception('Server API mengembalikan status ' . $httpCode);
            }

            $response = json_decode($result, true);

            if (isset($response['status']) && $response['status'] === true) {
                $personal = $response['data']['personal_data'];


                    $user = UserModel::firstOrCreate(
                        [
                            'kopeg' => $personal['kopeg'],
                            'name' => $personal['full_name'],
                        ],
                        [
                            'email' => $personal['email'] ?? null,
                            'password' => bcrypt(\Str::random(12)),
                            'role_id' => 2,
                        ]
                    );

                    Auth::login($user);
                $request->session()->regenerate();

                return redirect()->intended($this->redirectTo);
            }

            // Jika login gagal (status false)
            return back()->withErrors([
                'kopeg' => 'Login gagal. Periksa kembali data Anda.',
            ])->withInput();
        } catch (\Exception $e) {
            Log::error('Login API error: ' . $e->getMessage());

            return back()->withErrors([
                'kopeg' => 'Terjadi kesalahan saat menghubungi sistem Hadir. Silakan coba lagi nanti.',
            ])->withInput();
        }
    }


    //     // Login biasa email/username
    //     $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
    //     if (Auth::attempt([$fieldType => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
    //         $request->session()->regenerate();
    //         return redirect()->route('dashboard');
    //     }

    //     return back()->withErrors([
    //         'login' => 'Email/Username atau password salah.',
    //     ])->onlyInput('email');
    // }




    // Form login QR scan
    public function showQrLoginForm($id)
    {
        $tamu = TamuModel::with(['jenisIdentitas'])->findOrFail($id);

        // Kalau sudah login dan role pegawai, redirect ke approve
        if (Auth::check() && Auth::user()->role_id == 2) {
            return redirect()->route('pegawai.show', $id);
        }

        return view('auth.login-qr', compact('tamu'));
    }

    // Login dari QR scan
   /**
     * Show login form
     */
    // public function showLoginForm()
    // {
    //     return view('auth.login');
    // }

    /**
     * Custom login logic — local first, then API fallback.
     */
    public function loginFromQR(Request $request)
    {
        $request->validate([
            'kopeg' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $token = env('API_TOKEN', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkYXRhIjoiSGVsbG8sIFdvcmxkISIsImV4cGlyZWRfdG9rZW4iOiIyMDI2LTA2LTAzIDE0OjQ0OjA1In0.81M6qkPwrHN4qON2KKXZLjsGxMs0nNjW10TDQrYkzVs'); // Ganti dengan token yang sesuai
            $curl = curl_init();

            // Header Authorization dengan token
            $auth_data = array(
                'Bearer:' . $token,
            );

            // Data yang dikirimkan
            $data = array(
                'kopeg' => ($request->kopeg),
                'password' => ($request->password)
            );

            // Encode data menjadi JSON
            $body = json_encode($data);

            // Set cURL options
            curl_setopt($curl, CURLOPT_URL, 'https://hadir.jasatirta1.co.id/api/login');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $auth_data); // Header Authorization
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body); // Kirimkan data JSON sebagai body
            curl_setopt($curl, CURLOPT_TIMEOUT, 10); // timeout optional, untuk keamanan

            // Eksekusi cURL
            $result = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if (!$result) {
                throw new \Exception('Gagal menghubungi server API');
            }

            if ($httpCode !== 200) {
                throw new \Exception('Server API mengembalikan status ' . $httpCode);
            }

            $response = json_decode($result, true);

            if (isset($response['status']) && $response['status'] === true) {
                $personal = $response['data']['personal_data'];

                    $user = UserModel::firstOrCreate(
                        [
                            'kopeg' => $personal['kopeg'],
                            'name' => $personal['full_name'],
                        ],
                        [
                            'email' => $personal['email'] ?? null,
                            'password' => bcrypt(\Str::random(12)),
                            'role_id' => 2,
                        ]
                    );

                Auth::login($user);
                $request->session()->regenerate();

                return redirect()->intended($this->redirectTo);
            }
            // Jika login gagal (status false)
            return back()->withErrors([
                'kopeg' => 'Login gagal. Periksa kembali data Anda.',
            ])->withInput();
        } catch (\Exception $e) {
            Log::error('Login API error: ' . $e->getMessage());

            return back()->withErrors([
                'kopeg' => 'Terjadi kesalahan saat menghubungi sistem Hadir. Silakan coba lagi nanti.',
            ])->withInput();
        }
    }


    /**
     * Logout user safely
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Anda telah logout.');
    }


    // Logout
    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect()->route('tamu.index'); // balik ke halaman tamu/register
    // }
}
