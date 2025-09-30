<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TamuModel;
use App\Models\UserModel;
use App\Models\RoleModel;
class DashboardController extends Controller
{
    /**
     * Handle the incoming request and redirect to appropriate dashboard
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Redirect based on user role
        switch ($user->role_id) {
            case 1:
                return $this->adminDashboard();

            case 2:
                return $this->pegawaiDashboard();

            case 3:
                return $this->securityDashboard();
                
            default:
                // If role is not recognized, logout and redirect to login
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak dikenali. Silakan hubungi administrator.');
        }
    }

        private function adminDashboard()
    {
        // Get comprehensive statistics
        $stats = [
            'total_users' => UserModel::count(),
            'total_tamu' => TamuModel::count(),
            'total_tamu_today' => TamuModel::whereDate('created_at', today())->count(),
            'total_pending_tamu' => TamuModel::where('status', 'belum_checkin')->count(),
        ];

        // Get recent data
        $recentUsers = UserModel::with('role')->latest()->limit(5)->get();
        $recentTamu = TamuModel::with('jenisIdentitas')->latest()->limit(5)->get();
        
        // Get tamu data with additional info for admin view
        $tamus = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);

        return view('pages.user.dashboard', compact('stats', 'recentUsers', 'recentTamu', 'tamus'));
    }

    
    /**
     * Security Dashboard
     */
    private function securityDashboard()
    {
        $tamus = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
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

        return view('pages.security.dashboard', compact('tamus', 'stats', 'todayStats'));
    }
    
    /**
     * Pegawai Dashboard  
     */
    public function pegawaiDashboard()
    {
        $tamus = TamuModel::where('status', 'checkin')
                     ->with(['jenisIdentitas', 'checkinBy'])
                     ->orderBy('checkin_at', 'desc')
                     ->get();
        
        $stats = [
            'pending_approval' => $tamus->count(),
            'approved_today' => TamuModel::whereDate('approved_at', today())
                                   ->where('approved_by', Auth::id())
                                   ->count(),
            'total_approved' =>TamuModel::where('approved_by', Auth::id())->count(),
            'approval_rate' => $this->calculateApprovalRate(),
        ];
        
        return view('pages.pegawai.dashboard', compact('tamus', 'stats'));
    }
    
    /**
     * Calculate approval rate for current pegawai
     */
    private function calculateApprovalRate()
    {
        $totalTamus = TamuModel::count();
        $approvedByUser = TamuModel::where('approved_by', Auth::id())->count();
        
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
        
        switch ($user->role_id) {
            case 1:
                return $this->getAdminData();
            case 2:
                return $this->getSecurityData();
            case 3:
                return $this->getPegawaiData();
            default:
                return response()->json(['error' => 'Unauthorized'], 403);
        }
    }

       /**
     * Get admin dashboard data
     */
    private function getAdminData()
    {
        return response()->json([
            'stats' => [
                'total_users' => UserModel::count(),
                'total_tamu' => TamuModel::count(),
                'total_tamu_today' => TamuModel::whereDate('created_at', today())->count(),
                'total_pending_tamu' => TamuModel::where('status', 'belum_checkin')->count(),
            ],
            'recent_activities' => TamuModel::with('jenisIdentitas')
                                          ->latest()
                                          ->limit(5)
                                          ->get()
                                          ->map(function($tamu) {
                                              return [
                                                  'id' => $tamu->id,
                                                  'nama' => $tamu->nama,
                                                  'status' => $tamu->status,
                                                  'created_at' => $tamu->created_at->format('H:i')
                                              ];
                                          })
        ]);
    }
    
    /**
     * Get security dashboard data
     */
    private function getSecurityData()
    {
        $tamus = TamuModel::with(['jenisIdentitas', 'approvedBy', 'checkinBy', 'checkoutBy'])
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
        $pendingCount = TamuModel::where('status', 'checkin')->count();
        $approvedToday = TamuModel::whereDate('approved_at', today())
                            ->where('approved_by', Auth::id())
                            ->count();
        
        return response()->json([
            'stats' => [
                'pending_approval' => $pendingCount,
                'approved_today' => $approvedToday,
                'total_approved' => TamuModel::where('approved_by', Auth::id())->count(),
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
        
        switch ($user->role_id) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 2:
                return redirect()->route('security.dashboard');
            case 3:
                return redirect()->route('pegawai.dashboard');
            default:
                return redirect()->route('dashboard')->with('error', 'Role tidak dikenali.');
        }
    }
}