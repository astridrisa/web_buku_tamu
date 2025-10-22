<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use App\Models\Security;
use App\Models\TamuModel;
use App\Models\UserModel;
use App\Models\JenisIdentitasModel;
use App\Services\QrCodeService;
use App\Services\NotificationService;
use App\Mail\TamuQrCodeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class SecurityController extends Controller
{
    protected $qrCodeService;
    protected $notificationService;
    
    public function __construct(QrCodeService $qrCodeService, NotificationService $notificationService)
    {
        $this->middleware('auth');
        $this->qrCodeService = $qrCodeService;
        $this->notificationService = $notificationService;
    }

    // Halaman dashboard
    public function index()
    {
        if (Auth::user()->role_id != 3) {
            abort(403, 'Unauthorized access');
        }

        $tamus = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        
        $stats = [
            'total' => $tamus->count(),
            'belum_checkin' => $tamus->where('status', 'belum_checkin')->count(),
            'checkin' => $tamus->where('status', 'checkin')->count(),
            'approved' => $tamus->where('status', 'approved')->count(),
        ];

        // 🔔 Ambil notifikasi untuk security
        $notifications = $this->notificationService->getUserNotifications(Auth::user());

        return view('pages.security.list', compact('tamus', 'stats'));
    }

    // List tamu dengan pagination
    public function list()
    {
        $tamus = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
                     ->orderBy('created_at', 'asc')
                     ->get();
        
        return view('pages.security.list', compact('tamus'));
    }

    // Detail tamu
    public function show($id)
    {
        $tamu = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
                    ->findOrFail($id);
        
        return view('pages.tamu.show', compact('tamu'));
    }

    public function create()
    {
        $jenisIdentitas = JenisIdentitasModel::all();
        return view('pages.tamu.create', compact('jenisIdentitas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'tujuan' => 'required|string|max:255',
            'nama_pegawai' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'jumlah_rombongan' => 'nullable|integer|min:1',
            'jenis_identitas_id' => 'required|integer|exists:jenis_identitas,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
                Log::error('Validation errors:', $validator->errors()->toArray());
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $data = $validator->validated();

        // Handle upload foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($data['nama']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('tamu_photos', $filename, 'public');
            $data['foto'] = $path;
            
            Log::info('Photo uploaded successfully: ' . $path);
        }
    
        $data['status'] = 'belum_checkin';
        $data['qr_code'] = \Illuminate\Support\Str::uuid();

        if (!isset($data['jumlah_rombongan'])) {
                $data['jumlah_rombongan'] = 1;
            }

        $data['tanggal_kunjungan'] = now()->format('Y-m-d');
        $data['jam_kunjungan'] = now()->format('H:i');

        TamuModel::create($data);

        return redirect()
            ->route('security.list') 
            ->with('success', 'Tamu berhasil ditambahkan');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $tamu = TamuModel::findOrFail($id);
        $jenisIdentitas = JenisIdentitasModel::all();
        
        return view('pages.tamu.edit', compact('tamu', 'jenisIdentitas'));
    }

    // Edit tamu
    public function update(Request $request, $id)
    {
        $tamu = TamuModel::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'tujuan' => 'required|string|max:255',
            'nama_pegawai' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'jumlah_rombongan' => 'nullable|integer|min:1',
            'jenis_identitas_id' => 'required|integer|exists:jenis_identitas,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

         // Handle upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($tamu->foto) {
                Storage::disk('public')->delete($tamu->foto);
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($validated['nama']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('tamu_photos', $filename, 'public');
            $validated['foto'] = $path;
        }

        $tamu->update($validated);

        return redirect()->route('security.list')
            ->with('success', 'Data tamu berhasil diperbarui');
    }

    // Hapus tamu
    public function delete($id)
    {
        $tamu = TamuModel::findOrFail($id);
        $tamu->delete();

        return response()->json([
            'success' => true, 
            'message' => 'Tamu berhasil dihapus'
        ]);
    }

    // Checkin tamu
    public function checkin(Request $request, $id)
    {
        Log::info('Auth ID: ' . Auth::id());
        Log::info('Auth user: ', (array) Auth::user());

        $tamu = TamuModel::findOrFail($id);

        if ($tamu->status !== 'belum_checkin') {
            return redirect()->back()->with('error', 'Tamu sudah di-checkin');
        }   

        $tamu->update([
            'status' => 'checkin',
            'checkin_at' => now(),
            'checkin_by' => (int) Auth::user()->id
        ]);
        try {
            // GENERATE QR CODE
            $qrCodePath = $this->qrCodeService->generateTamuQrCode($tamu);
            Log::info("QR Code generated at: {$qrCodePath}");

            // 📧 Kirim email ke tamu dengan QR baru
            Mail::to($tamu->email)->send(new TamuQrCodeMail($tamu, $qrCodePath));
            Log::info("Email sent to: {$tamu->email}");
        } catch (\Exception $e) {
            Log::error("Error sending email: " . $e->getMessage());
            // Tidak return error, karena checkin sudah berhasil
        }

        try {
            // KIRIM NOTIFIKASI KE PEGAWAI
            $this->notificationService->notifyPegawaiCheckedIn($tamu);
            Log::info("Notification sent to pegawai");
        } catch (\Exception $e) {
            Log::error("Error sending notification: " . $e->getMessage());
        }

        return redirect()->route('security.list')->with('success', 'Tamu berhasil di-checkin');
    }

    // Checkout tamu
    public function checkout(Request $request, $id)
    {
        $tamu = TamuModel::findOrFail($id);
        
        if ($tamu->status !== 'approved') {
             return redirect()->back()->with('warning', 'Tamu belum disetujui pegawai.');
        }

        $tamu->update([
            'status' => 'checkout',
            'checkout_at' => now(),
            'checkout_by' => (int) Auth::user()->id
        ]);

        return redirect()->back()->with('success', 'Tamu berhasil checkout.');
    }

    /**
     * ✅ PERBAIKAN: Get notifications untuk security
     */
    public function notifications()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan',
                    'notifications' => [],
                    'unread_count' => 0
                ], 401);
            }

            Log::info('Loading notifications for security user: ' . $user->id);

            $notifications = $user->notifications()
                ->latest()
                ->limit(10)
                ->get()
                ->map(function($notification) {
                    // Decode data jika string
                    $data = $notification->data;
                    if (is_string($data)) {
                        $data = json_decode($data, true);
                    }
                    
                    return [
                        'id' => $notification->id,
                        'data' => $data ?: [],  // ✅ Pastikan data ada di property 'data'
                        'read_at' => $notification->read_at,
                        'created_at' => $notification->created_at->toISOString(),
                    ];
                });

            $unreadCount = $user->unreadNotifications()->count();

            Log::info('Security notifications loaded', [
                'count' => $notifications->count(),
                'unread' => $unreadCount
            ]);

            return response()->json([
                'success' => true,
                'notifications' => $notifications,
                'unread_count' => $unreadCount
            ]);

        } catch (\Exception $e) {
            Log::error('Error in Security notifications: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'notifications' => [],
                'unread_count' => 0
            ], 500);
        }
    }
    /**
     * ✅ PERBAIKAN: Mark notification sebagai dibaca
     */
    public function markNotificationRead($id)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $success = $this->notificationService->markAsRead($user->id, $id);

            return response()->json(['success' => $success]);

        } catch (\Exception $e) {
            Log::error('Error marking notification as read: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * ✅ PERBAIKAN: Mark all notifications sebagai dibaca
     */
    public function markAllNotificationsRead()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $this->notificationService->markAllAsRead($user->id);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}