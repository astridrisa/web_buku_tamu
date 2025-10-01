<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use App\Models\Security;
use App\Models\TamuModel;
use App\Models\JenisIdentitasModel;
use Illuminate\Support\Facades\Validator;
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
            'email' => 'required|email|max:255',
            'jumlah_rombongan' => 'nullable|integer|min:1',
            'jenis_identitas_id' => 'required|integer|exists:jenis_identitas,id',
        ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        $tamu = TamuModel::create($validator->validated());

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
            'email' => 'required|email|max:255',
            'jumlah_rombongan' => 'nullable|integer|min:1',
            'jenis_identitas_id' => 'required|integer|exists:jenis_identitas,id',
        ]);

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
        // Debug Auth
         \Log::info('Auth ID: ' . Auth::id());
        \Log::info('Auth user: ', (array) Auth::user());

        $tamu = TamuModel::findOrFail($id);
        
        if ($tamu->status !== 'belum_checkin') {
            return response()->json(['success' => false, 'message' => 'Tamu sudah di-checkin']);
        }

        $tamu->update([
            'status' => 'checkin',
            'checkin_at' => now(),
            'checkin_by' =>  (int) Auth::user()->id
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
    public function checkout($id)
    {
        try {
            \Log::info("Checkout request masuk untuk tamu ID: {$id}, user: " . auth()->id());

            $tamu = TamuModel::findOrFail($id);
            \Log::info('AUTH ID TYPE:', [gettype(auth()->id())]);
            \Log::info('AUTH ID VALUE:', [auth()->id()]);
            \Log::info('AUTH USER:', ['user' => auth()->user()]);
            \Log::info('USER ID TYPE:', [gettype(auth()->user()->id)]);
            \Log::info('USER ID VALUE:', [auth()->user()->id]);


            $tamu->update([
                'status' => 'checkout',
            
                'checkout_at' => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Tamu berhasil checkout']);
        } catch (\Exception $e) {
            \Log::error('Checkout Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
