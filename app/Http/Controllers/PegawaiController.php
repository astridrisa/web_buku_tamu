<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
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
        $tamus = Tamu::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
                     ->orderBy('created_at', 'desc')
                     ->get();
        
        $stats = [
            'total' => $tamus->count(),
            'belum_checkin' => $tamus->where('status', 'belum_checkin')->count(),
            'checkin' => $tamus->where('status', 'checkin')->count(),
            'approved' => $tamus->where('status', 'approved')->count(),
        ];

        return view('pegawai.dashboard', compact('tamus', 'stats'));
    }

    // List tamu dengan pagination
    public function list()
    {
        $tamus = Tamu::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);
        
        return view('pegawai.tamu.index', compact('tamus'));
    }

    // Detail tamu
    public function show($id)
    {
        $tamu = Tamu::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
                    ->findOrFail($id);
        
        return view('pegawai.tamu.detail', compact('tamu'));
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
