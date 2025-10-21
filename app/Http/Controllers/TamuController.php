<?php

namespace App\Http\Controllers;

use App\Models\TamuModel;
use App\Models\JenisIdentitasModel;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Services\QrCodeService;


class TamuController extends Controller
{
    protected $notificationService;
    protected $qrCodeService;

    public function __construct(NotificationService $notificationService, QrCodeService $qrCodeService)
    {
        $this->notificationService = $notificationService;
        $this->qrCodeService = $qrCodeService;
    }

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
                'nama_pegawai' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'jumlah_rombongan' => 'nullable|integer|min:1',
                'jenis_identitas_id' => 'required|integer|exists:jenis_identitas,id',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
                'privacy_consent' => 'required|accepted', // Validasi privacy consent
            ], [
                'privacy_consent.required' => 'Anda harus menyetujui kebijakan privasi dan keamanan data untuk melanjutkan registrasi.',
                'privacy_consent.accepted' => 'Anda harus menyetujui kebijakan privasi dan keamanan data untuk melanjutkan registrasi.',
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
            $validated['status'] = 'belum_checkin';
            
            // Set default value jika tidak ada
            if (!isset($validated['jumlah_rombongan'])) {
                $validated['jumlah_rombongan'] = 1;
            }

            // Handle upload foto
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . Str::slug($validated['nama']) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('tamu_photos', $filename, 'public');
                $validated['foto'] = $path;
                
                Log::info('Photo uploaded: ' . $path);
            }

            // Hapus privacy_consent dari data yang akan disimpan (tidak perlu disimpan ke database)
            unset($validated['privacy_consent']);

            Log::info('Validated data:', $validated);

            // PERBAIKAN: Gunakan TamuModel yang konsisten
            $tamu = TamuModel::create($validated);

            // 🔔 KIRIM NOTIFIKASI KE SECURITY
            $this->notificationService->notifySecurityNewGuest($tamu);

            Log::info('Tamu registered and notification sent to security');

            // Log::info('Tamu created successfully:', $tamu->toArray());

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

    public function showQrCode($qrCode)
    {
        $tamu = TamuModel::where('qr_code', $qrCode)->firstOrFail();
        
        // Generate QR Code as base64
        $qrCodeBase64 = $this->qrCodeService->generateQrCodeBase64(
            route('tamu.qr.show', $qrCode)
        );
        
        return view('tamu.qrcode', compact('tamu'));
    }
}