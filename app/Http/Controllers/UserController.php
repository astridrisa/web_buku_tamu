<?php

    namespace App\Http\Controllers;

    use App\Models\UserModel;
    use App\Models\RoleModel;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Auth;

    class UserController extends \Illuminate\Routing\Controller
    {
        public function __construct()
        {
            // Middleware biar hanya Admin (role_id = 1) yang bisa create user
            // $this->middleware(function ($request, $next) {
            //     if (in_array($request->route()->getActionMethod(), ['create', 'store'])) {
            //         if (Auth::user()->role_id != 1) {
            //             abort(403, 'Hanya Administrator yang dapat membuat user.');
            //         }
            //     }
            //     return $next($request);
            // });
            
            $this->middleware('auth');
        }

        // Tampilkan semua user
        // public function index()
        // {
        //     $users = UserModel::with('role')
        //         ->when(request('search'), function($query) {
        //             $query->where('name', 'like', '%' . request('search') . '%')
        //                 ->orWhere('email', 'like', '%' . request('search') . '%');
        //         })
        //         ->when(request('role_filter'), function($query) {
        //             $query->where('role_id', request('role_filter'));
        //         })
        //         ->orderBy('created_at', 'desc')
        //         ->paginate(10); // Changed from get() to paginate()
            
        //     // Get role statistics for the cards
        //     $stats = [
        //         'admin' => UserModel::where('role_id', 1)->count(),
        //         'pegawai' => UserModel::where('role_id', 2)->count(),
        //         'security' => UserModel::where('role_id', 3)->count(),
        //     ];
            
        //     // Get all roles for filter dropdown
        //     $roles = RoleModel::all(); // Or RoleModel::all() depending on your model name
            
        //     return view('pages.user.index', compact('users', 'stats', 'roles'));
        // }

        public function index(Request $request)
        {
            $query = UserModel::with('role');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
                });
            }

            // Role filter
            if ($request->has('role_filter') && !empty($request->role_filter)) {
                $query->where('role_id', $request->role_filter);
            }

            // Status filter
            if ($request->has('status_filter') && !empty($request->status_filter)) {
                $query->where('status', $request->status_filter);
            }

            // Get stats for dashboard cards
            $stats = [
                'admin' => UserModel::where('role_id', 1)->count(),
                'pegawai' => UserModel::where('role_id', 2)->count(),
                'security' => UserModel::where('role_id', 3)->count(),
                'total' => UserModel::count(),
            ];

            // Get roles for filter dropdown
            $roles = RoleModel::all();

            // Paginate results
            $users = $query->orderBy('name', 'asc')->paginate(15);

            return view('pages.user.index', compact('users', 'stats', 'roles'));
        }

        // Form create user (hanya admin)
        public function create()
        {
            $roles = RoleModel::all(); // biar admin bisa pilih role
            return view('pages.user.create', compact('roles'));
        }

        // Simpan user baru (hanya admin)
        public function store(Request $request)
        {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users',
                'password' => 'required|min:5',
                'role_id'  => 'required|in:2,3', // admin tidak boleh buat admin baru
            ]);

            UserModel::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role_id'  => $request->role_id,
            ]);

            return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
        }

        public function list(Request $request)
        {
            $query = UserModel::with('role');

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
                });
            }

            if ($request->has('role_filter') && !empty($request->role_filter)) {
                $query->where('role_id', $request->role_filter);
            }

            if ($request->has('status_filter') && !empty($request->status_filter)) {
                $query->where('status', $request->status_filter);
            }

            $users = $query->orderBy('name', 'asc')->paginate(15);

            $stats = [
                'admin' => UserModel::where('role_id', 1)->count(),
                'pegawai' => UserModel::where('role_id', 2)->count(),
                'security' => UserModel::where('role_id', 3)->count(),
                'total' => UserModel::count(),
            ];

            $roles = RoleModel::all(); // 🔥 ini wajib ada

            return view('pages.user.index', compact('users', 'stats', 'roles'));
        }

    
        public function show($id)
        {
            $user = UserModel::with('role')->findOrFail($id);
            
            // Optional: Get user's activity log atau data terkait lainnya
            // $activities = $user->activities()->latest()->take(5)->get();
            
            return view('pages.user.show', compact('user'));
        }

        // Form edit user
        public function edit($id)
        {
            $user = UserModel::findOrFail($id);
            $roles = RoleModel::all();
            return view('pages.user.edit', compact('user', 'roles'));
        }

        // Update user
        public function update(Request $request, $id)
        {
            $user = UserModel::findOrFail($id);

            $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'role_id' => 'required|in:1,2,3',
            ]);

            $data = $request->only(['name', 'email', 'role_id']);
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()->route('admin.users.list')->with('success', 'User berhasil diperbarui.');
        }

        // Hapus user
        public function delete($id)
        {
            $user = UserModel::findOrFail($id);
            $user->delete();

            return redirect()->route('admin.users.list')->with('success', 'User berhasil dihapus.');
        }
    }
