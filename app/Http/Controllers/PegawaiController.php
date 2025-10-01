<?php

namespace App\Http\Controllers;

use App\Models\TamuModel;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        
        return view('pages.pegawai.tamu.detail', compact('tamu'));
    }

    // Approve tamu yang sudah checkin
    public function approve($id)
    {
        try {
            // cek dulu apakah datanya ketemu
            $tamu = TamuModel::find($id);
            if (!$tamu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tamu tidak ditemukan',
                ], 404);
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

            return response()->json([
                'success' => true,
                'message' => 'Tamu approved successfully',
                'data' => $tamu->fresh()
            ]);
        } catch (\Exception $e) {
            Log::error('Approve Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

     /**
     * Get notifications untuk pegawai
     */
    public function notifications()
    {
        $notifications = $this->notificationService->getRecentNotifications(Auth::id());
        $unreadCount = $this->notificationService->getUnreadCount(Auth::id());

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Mark notification sebagai dibaca
     */
    public function markNotificationRead($id)
    {
        $success = $this->notificationService->markAsRead(Auth::id(), $id);

        return response()->json(['success' => $success]);
    }

    /**
     * Mark all notifications sebagai dibaca
     */
    public function markAllNotificationsRead()
    {
        $this->notificationService->markAllAsRead(Auth::id());

        return response()->json(['success' => true]);
    }
}
