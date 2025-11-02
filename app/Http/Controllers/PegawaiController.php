<?php

namespace App\Http\Controllers;

use App\Models\TamuModel;
use App\Models\TamuApprovalModel;
use App\Models\UserModel;
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
        $tamus = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy', 'approvals.pegawai'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Total semua orang yang datang (hitung jumlah rombongan)
        $totalPengunjung = $tamus->sum('jumlah_rombongan');
        
        // Pending approval = tamu yang sudah checkin tapi belum diverifikasi
        $pendingApproval = $tamus->where('status', 'checkin')->count();

        // Disetujui hari ini
        $approvedToday = $tamus->where('status', 'approved')
                            ->whereBetween('updated_at', [now()->startOfDay(), now()->endOfDay()])
                            ->count();

        // Total approval yang dilakukan oleh pegawai ini
        $myApprovals = TamuApprovalModel::where('pegawai_id', auth()->id())->count();

        // Total disetujui
        $totalApproved = $tamus->where('status', 'approved')->count();

        // Total tamu bulan ini
        $tamuBulanIni = $tamus->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                            ->count();


        // Hitung approval rate
        $approvalRate = $tamus->count() > 0 
            ? round(($totalApproved / $tamus->count()) * 100, 1)
            : 0;

        $stats = [
            'total' => $tamus->count(),
            'total_pengunjung' => $totalPengunjung,
            'belum_checkin' => $tamus->where('status', 'belum_checkin')->count(),
            'checkin' => $tamus->where('status', 'checkin')->count(),
            'approved' => $tamus->where('status', 'approved')->count(),
            'pending_approval' => $pendingApproval,
            'approved_today' => $approvedToday,
            'total_approved' => $totalApproved,
            'approval_rate' => $approvalRate,
            'tamu_bulan_ini' => $tamuBulanIni,
            'my_approvals' => $myApprovals,

        ];

        return view('pages.pegawai.dashboard', compact('tamus', 'stats'));
    }


    // List tamu dengan pagination
    // public function list()
    // {
    //     $tamus = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
    //                  ->orderBy('created_at', 'desc')
    //                  ->paginate(10);
        
    //     return view('pages.pegawai.tamu.index', compact('tamus'));
    // }

    // Detail tamu
    public function show($id)
    {
        $tamu = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy', 'approvals.pegawai'])
                    ->findOrFail($id);

        $userId = auth()->user()->id;
        $isApprovedByUser = $tamu->isApprovedBy($userId);
        
        return view('pages.pegawai.show', compact('tamu', 'isApprovedByUser'));
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

    public function approval()
    {
        // Ambil ID user login
        $userName = auth()->user()->name;
        $userId   = UserModel::where('name', $userName)->value('id');

        // Ambil semua tamu yang status approved (semua kolom)
        // $tamus = TamuModel::approved()->get();
        $tamus = TamuModel::with(['approvals.pegawai', 'jenisIdentitas', 'approvedBy'])
                    ->whereIn('status', ['checkin', 'approved']) // PENTING: termasuk yang sudah approved
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function($tamu) use ($userId) {
                        // Tambahkan info apakah user ini sudah approve
                        $tamu->is_approved_by_me = $tamu->isApprovedBy($userId);
                        return $tamu;
                    });

        // Filter collection di PHP berdasarkan user login
        $tamusForUser = $tamus->filter(fn($tamu) => $tamu->isApprovedBy($userId));

        // Siapkan stats
        $stats = [
            'approved' => $tamusForUser->count()
        ];

        return view('pages.pegawai.index', [
            'tamus' => $tamusForUser,
            'stats' => $stats
        ]);
    }

    // Approve tamu yang sudah checkin
    public function approve($id)
    {
        try {
            // Cek apakah tamu ada
            $tamu = TamuModel::with('approvals')->find($id);
            
            if (!$tamu) {
                return redirect()
                    ->route('pegawai.approval')
                    ->with('error', 'Data tamu tidak ditemukan');
            }

            $userId = auth()->user()->id;
            // Cek apakah pegawai ini sudah pernah approve
            if ($tamu->isApprovedBy($userId)) {
                return redirect()
                    ->route('pegawai.approval')
                    ->with('warning', "Anda sudah menyetujui kunjungan tamu {$tamu->nama} sebelumnya.");
            }

            // Cek status tamu - harus sudah checkin atau approved
            if (!in_array($tamu->status, ['checkin', 'approved'])) {
                return redirect()
                    ->route('pegawai.approval')
                    ->with('error', 'Tamu harus sudah checkin untuk bisa disetujui.');
            }

            // Tambahkan approval baru ke tabel tamu_approvals
            TamuApprovalModel::create([
                'tamu_id' => $tamu->id,
                'pegawai_id' => $userId,
                'approved_at' => now(),
                'catatan' => request('catatan') // opsional dari form
            ]);

            // Update status tamu menjadi 'approved' HANYA jika ini approval pertama
            if ($tamu->status !== 'approved') {
                $tamu->update([
                    'status' => 'approved',
                    'approved_by' => $userId, // first approver
                    'approved_at' => now(),
                ]);
            }
            // Jika sudah approved, TIDAK perlu update status lagi
            // Cukup tambahkan record di tamu_approvals

            // Reload untuk mendapatkan data terbaru
            $tamu->load('approvals.pegawai');

            // Log approval
            Log::info('Tamu approved', [
                'tamu_id' => $tamu->id,
                'tamu_nama' => $tamu->nama,
                'pegawai_id' => $userId,
                'pegawai_name' => auth()->user()->name,
                'total_approvers' => $tamu->approvals->count(),
                'is_first_approval' => $tamu->approvals->count() == 1
            ]);

            // Kirim notifikasi ke security
            $this->notificationService->notifySecurityApproved($tamu);

            // Pesan sukses
            $totalApprovers = $tamu->approvals->count();
            $message = "Kunjungan tamu {$tamu->nama} telah Anda setujui.";
            
            if ($totalApprovers > 1) {
                $message .= " (Total {$totalApprovers} pegawai telah menyetujui)";
            }

            return redirect()
                ->route('pegawai.approval')
                ->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Approve Error: ' . $e->getMessage(), [
                'tamu_id' => $id,
                'user_id' => auth()->user()->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->route('pegawai.approval')
                ->with('error', 'Terjadi kesalahan saat menyetujui tamu: ' . $e->getMessage());
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
