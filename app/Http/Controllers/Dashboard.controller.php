<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TamuModel;
use App\Models\UserModel;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request and redirect to appropriate dashboard
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Redirect based on user role
        switch ($user->role) {
            case 'security':
                return $this->securityDashboard();
                
            case 'pegawai':
                return $this->pegawaiDashboard();
                
            default:
                // If role is not recognized, logout and redirect to login
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak dikenali. Silakan hubungi administrator.');
        }
    }
    
    /**
     * Security Dashboard
     */
    private function securityDashboard()
    {
        $tamus = Tamu::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
                     ->orderBy('created_at', 'desc')
                     ->get();
        
        $stats = [
            'total' => $tamus->count(),
            'belum_checkin' => $tamus->where('status', 'belum_checkin')->count(),
            'checkin' => $tamus->where('status', 'checkin')->count(),
            'approved' => $tamus->where('status', 'approved')->count(),
            'checkout' => $tamus->where('status', 'checkout')->count(),
        ];

        // Additional stats for security
        $todayStats = [
            'checkin_today' => $tamus->where('status', '!=', 'belum_checkin')
                                    ->filter(function($tamu) {
                                        return $tamu->checkin_at && $tamu->checkin_at->isToday();
                                    })->count(),
            'checkout_today' => $tamus->where('status', 'checkout')
                                     ->filter(function($tamu) {
                                         return $tamu->checkout_at && $tamu->checkout_at->isToday();
                                     })->count(),
        ];

        return view('security.dashboard', compact('tamus', 'stats', 'todayStats'));
    }
    
    /**
     * Pegawai Dashboard  
     */
    private function pegawaiDashboard()
    {
        $tamus = Tamu::where('status', 'checkin')
                     ->with(['jenisIdentitas', 'checkinBy'])
                     ->orderBy('checkin_at', 'desc')
                     ->get();
        
        $stats = [
            'pending_approval' => $tamus->count(),
            'approved_today' => Tamu::whereDate('approved_at', today())
                                   ->where('approved_by', Auth::id())
                                   ->count(),
            'total_approved' => Tamu::where('approved_by', Auth::id())->count(),
            'approval_rate' => $this->calculateApprovalRate(),
        ];
        
        return view('pegawai.dashboard', compact('tamus', 'stats'));
    }
    
    /**
     * Calculate approval rate for current pegawai
     */
    private function calculateApprovalRate()
    {
        $totalTamus = Tamu::count();
        $approvedByUser = Tamu::where('approved_by', Auth::id())->count();
        
        if ($totalTamus == 0) {
            return 0;
        }
        
        return round(($approvedByUser / $totalTamus) * 100, 1);
    }
    
    /**
     * Get dashboard data as JSON (for AJAX requests)
     */
    public function getData(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role === 'security') {
            return $this->getSecurityData();
        } elseif ($user->role === 'pegawai') {
            return $this->getPegawaiData();
        }
        
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    /**
     * Get security dashboard data
     */
    private function getSecurityData()
    {
        $tamus = Tamu::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
                     ->orderBy('created_at', 'desc')
                     ->get();
        
        return response()->json([
            'stats' => [
                'total' => $tamus->count(),
                'belum_checkin' => $tamus->where('status', 'belum_checkin')->count(),
                'checkin' => $tamus->where('status', 'checkin')->count(),
                'approved' => $tamus->where('status', 'approved')->count(),
                'checkout' => $tamus->where('status', 'checkout')->count(),
            ],
            'recent_tamus' => $tamus->take(5)->map(function($tamu) {
                return [
                    'id' => $tamu->id,
                    'nama' => $tamu->nama,
                    'status' => $tamu->status_text,
                    'status_color' => $tamu->status_color,
                    'created_at' => $tamu->created_at->format('H:i')
                ];
            })
        ]);
    }
    
    /**
     * Get pegawai dashboard data
     */
    private function getPegawaiData()
    {
        $pendingCount = Tamu::where('status', 'checkin')->count();
        $approvedToday = Tamu::whereDate('approved_at', today())
                            ->where('approved_by', Auth::id())
                            ->count();
        
        return response()->json([
            'stats' => [
                'pending_approval' => $pendingCount,
                'approved_today' => $approvedToday,
                'total_approved' => Tamu::where('approved_by', Auth::id())->count(),
                'approval_rate' => $this->calculateApprovalRate()
            ]
        ]);
    }
    
    /**
     * Redirect to role-specific dashboard (alternative method)
     */
    public function redirectToDashboard()
    {
        $user = Auth::user();
        
        if ($user->role === 'security') {
            return redirect()->route('security.dashboard');
        } elseif ($user->role === 'pegawai') {
            return redirect()->route('pegawai.dashboard');
        }
        
        return redirect()->route('login')->with('error', 'Role tidak dikenali.');
    }
}