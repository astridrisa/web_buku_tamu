<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use App\Models\Security;
use App\Models\TamuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class SecurityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Halaman dashboard
   public function index()
    {
        if (Auth::user()->role_id != 3) {
            // kalau bukan role security, balikin 403
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

        return view('pages.security.list', compact('tamus', 'stats'));
    }


    // List tamu dengan pagination
    public function list()
    {
        $tamus = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
                     ->orderBy('created_at', 'desc')
                     ->get();
        
        return view('pages.security.list', compact('tamus'));
    }

    // Detail tamu
    public function show($id)
    {
        $tamu = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
                    ->findOrFail($id);
        
        return view('pages.security.show', compact('tamu'));
    }

    // Tambah tamu
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_identitas_id' => 'required|exists:jenis_identitas,id',
            'no_identitas' => 'required|string|max:50',
            'tujuan' => 'nullable|string|max:255',
        ]);

        $tamu = TamuModel::create($validated);

        return response()->json([
            'success' => true, 
            'message' => 'Tamu berhasil ditambahkan', 
            'tamu' => $tamu
        ]);
    }

    // Edit tamu
    public function update(Request $request, $id)
    {
        $tamu = TamuModel::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_identitas_id' => 'required|exists:jenis_identitas,id',
            'no_identitas' => 'required|string|max:50',
            'tujuan' => 'nullable|string|max:255',
            'status' => 'nullable|in:belum_checkin,checkin,approved,checkout',
        ]);

        $tamu->update($validated);

        return response()->json([
            'success' => true, 
            'message' => 'Tamu berhasil diperbarui', 
            'tamu' => $tamu
        ]);
    }

    // Hapus tamu
    public function destroy($id)
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
        $tamu = TamuModel::findOrFail($id);
        
        if ($tamu->status !== 'belum_checkin') {
            return response()->json(['success' => false, 'message' => 'Tamu sudah di-checkin']);
        }

        $tamu->update([
            'status' => 'checkin',
            'checkin_at' => now(),
            'checkin_by' => Auth::id()
        ]);

        // Generate QR Code
        $tamu->generateQrCode();

        return response()->json([
            'success' => true, 
            'message' => 'Tamu berhasil di-checkin',
            'qr_code' => route('tamu.qr.show', $tamu->qr_code)
        ]);
    }

    // Checkout tamu
    public function checkout(Request $request, $id)
    {
        $tamu = TamuModel::findOrFail($id);
        
        if ($tamu->status !== 'approved') {
            return response()->json(['success' => false, 'message' => 'Tamu belum disetujui pegawai']);
        }

        $tamu->update([
            'status' => 'checkout',
            'checkout_at' => now(),
            'checkout_by' => Auth::id()
        ]);

        return response()->json(['success' => true, 'message' => 'Tamu berhasil checkout']);
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
