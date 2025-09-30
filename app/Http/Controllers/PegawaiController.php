<?php

namespace App\Http\Controllers;

use App\Models\TamuModel;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:pegawai'); // hanya pegawai
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
public function approveTamu($id)
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
        \Log::info('Before update:', $tamu->toArray());

        $update = $tamu->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // debug: cek hasil update
        \Log::info('Update result:', [$update]);
        \Log::info('After update:', $tamu->fresh()->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Tamu approved successfully',
            'data' => $tamu->fresh()
        ]);
    } catch (\Exception $e) {
        \Log::error('Approve Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}





    // Notifikasi
    public function notifications()
    {
        $notifications = Auth::user()->notifications()->latest()->take(10)->get();
        return response()->json($notifications);
    }

    // Tandai notifikasi sudah dibaca
    public function markNotificationRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(['success' => true]);
    }
}
