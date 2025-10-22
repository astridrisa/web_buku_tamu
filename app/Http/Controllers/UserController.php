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
            $this->middleware('auth');
        }

        public function index(Request $request)
        {
            $query = UserModel::with('role');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('kopeg', 'like', '%' . $search . '%');
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
                'phone'         => 'required|string|max:20',
                'kopeg'         => 'required|string|max:50|unique:users',
                'password' => 'required|min:5',
                'role_id'  => 'required|in:2,3', // admin tidak boleh buat admin baru
            ]);

            UserModel::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'kopeg'    => strtoupper($request->kopeg),
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
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('kopeg', 'like', '%' . $search . '%');
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
                'phone'         => 'required|string|max:20',
                'kopeg'         => 'required|string|max:50|unique:users,kopeg,' . $id,
                'role_id' => 'required|in:1,2,3',
            ]);

            $data = $request->only(['name', 'email', 'phone', 'role_id']);
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
