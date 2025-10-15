<?php

namespace App\Http\Controllers;

use App\Models\TamuModel;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\NotificationService;
use Illuminate\Routing\Controller as BaseController;

class PegawaiController extends BaseController
{
    protected $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->middleware('auth');
        $this->notificationService = $notificationService;
    }

    // Halaman dashboard pegawai
    public function index()
    {
    $tamus = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
                     ->orderBy('created_at', 'desc')
                     ->get();
        
        $stats = [
            'total' => $tamus->count(),
            'belum_checkin' => $tamus->where('status', 'belum_checkin')->count(),
            'checkin' => $tamus->where('status', 'checkin')->count(),
            'approved' => $tamus->where('status', 'approved')->count(),
        ];

        return view('pages.pegawai.dashboard', compact('tamus', 'stats'));
    }

    // List tamu dengan pagination
    public function list()
    {
        $tamus = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);
        
        return view('pages.pegawai.tamu.index', compact('tamus'));
    }

    // Detail tamu
    public function show($id)
    {
        $tamu = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
                    ->findOrFail($id);
        
        return view('pages.pegawai.show', compact('tamu'));
    }

    public function edit($id)
    {
        $tamu = TamuModel::findOrFail($id);
        $jenisIdentitas = JenisIdentitasModel::all();
        
        return view('pages.tamu.edit', compact('tamu', 'jenisIdentitas'));
    }

    // Update tamu
    public function update(Request $request, $id)
    {
        $tamu = TamuModel::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'tujuan' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'jumlah_rombongan' => 'nullable|integer|min:1',
            'jenis_identitas_id' => 'required|integer|exists:jenis_identitas,id',
        ]);

        $tamu->update($validated);

        return redirect()->route('pegawai.list')
            ->with('success', 'Data tamu berhasil diperbarui');
    }

    // Hapus tamu
    public function delete($id)
    {
        try {
            $tamu = TamuModel::findOrFail($id);
            $tamu->delete();

            return response()->json([
                'success' => true, 
                'message' => 'Tamu berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting tamu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data'
            ], 500);
        }
    }

    // Approve tamu yang sudah checkin
    public function approve($id)
    {
        try {
            // cek dulu apakah datanya ketemu
            $tamu = TamuModel::find($id);
            if (!$tamu) {
            return redirect()
                ->route('pegawai.approval')
                ->with('error', 'Data tamu tidak ditemukan');
            }

            // debug: cek data tamu sebelum update
            Log::info('Before update:', $tamu->toArray());

            
            Log::info('DEBUG AUTH:', [
           
                'id' => auth()->id(),
                'user' => auth()->user(),
            ]);

            $update = $tamu->update([
                'status' => 'approved',
                'approved_by' => auth()->user()->id,
                'approved_at' => now(),
            ]);

            // 🔔 KIRIM NOTIFIKASI KE SECURITY
            $this->notificationService->notifySecurityApproved($tamu);
            Log::info('Notification sent to security for approved guest ID: ' . $tamu->id);

            // debug: cek hasil update
            Log::info('Update result:', [$update]);
            Log::info('After update:', $tamu->fresh()->toArray());

             return redirect()
            ->route('pegawai.approval')
            ->with('success', "Kunjungan tamu {$tamu->nama} telah disetujui.");
        } catch (\Exception $e) {
            Log::error('Approve Error: ' . $e->getMessage());
            return redirect()
                ->route('pegawai.approval')
                ->with('error', 'Terjadi kesalahan saat menyetujui tamu.');
        }
    }

     /**
     * Get notifications untuk pegawai
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

        Log::info('Loading notifications for pegawai user: ' . $user->id);

        // Ambil notifikasi langsung dari user object (sama seperti Security)
        $notifications = $user->notifications()
            ->latest()
            ->limit(10)
            ->get()
            ->map(function($notification) {
                $data = $notification->data;
                if (is_string($data)) {
                    $data = json_decode($data, true);
                }
                
                return [
                    'id' => $notification->id,
                    'data' => $data ?: [],
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->toISOString(),
                ];
            });

        $unreadCount = $user->unreadNotifications()->count();

        Log::info('Pegawai notifications loaded', [
            'count' => $notifications->count(),
            'unread' => $unreadCount
        ]);

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);

    } catch (\Exception $e) {
        Log::error('Error in Pegawai notifications: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
            'notifications' => [],
            'unread_count' => 0
        ], 500);
    }
}

    /**
     * Mark notification sebagai dibaca
     */
    public function markNotificationRead($id)
{
    try {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['success' => false], 401);
        }

        $notification = $user->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);

    } catch (\Exception $e) {
        Log::error('Error marking notification: ' . $e->getMessage());
        return response()->json(['success' => false], 500);
    }
}

public function markAllNotificationsRead()
{
    try {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['success' => false], 401);
        }

        $user->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        Log::error('Error marking all notifications: ' . $e->getMessage());
        return response()->json(['success' => false], 500);
    }
}
}
