<?php

namespace App\Http\Controllers;

use App\Models\TamuModel;
use App\Models\JenisIdentitasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TamuController extends Controller
{
    // Menampilkan form registrasi
    public function index()
    {
        $jenisIdentitas = JenisIdentitasModel::all(); // Ambil semua jenis identitas
        return view('pages.tamu.register', compact('jenisIdentitas'));
    }

    // Menyimpan data tamu
    public function store(Request $request)
    {
        try {
            // Debug: Log request data
            Log::info('Request data:', $request->all());
            
            // Test database connection
            Log::info('Database connection test');
            $jenisIdentitasCount = JenisIdentitasModel::count();
            Log::info('Jenis Identitas count: ' . $jenisIdentitasCount);
            
            // Validasi dengan Validator untuk error handling yang lebih baik
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'alamat' => 'required|string',
                'no_telepon' => 'required|string|max:20',
                'tujuan' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'jumlah_rombongan' => 'nullable|integer|min:1',
                'jenis_identitas_id' => 'required|integer|exists:jenis_identitas,id',
            ]);

            // Jika validasi gagal, return error 422
            if ($validator->fails()) {
                Log::error('Validation failed:', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();
            $validated['qr_code'] = Str::uuid();
            
            // Set default value jika tidak ada
            if (!isset($validated['jumlah_rombongan'])) {
                $validated['jumlah_rombongan'] = 1;
            }

            Log::info('Validated data:', $validated);

            // PERBAIKAN: Gunakan TamuModel yang konsisten
            $tamu = TamuModel::create($validated);

            Log::info('Tamu created successfully:', $tamu->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Registrasi tamu berhasil',
                'tamu' => $tamu
            ], 201);

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error saat menyimpan tamu: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::error('Request data pada error:', $request->all());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }
}