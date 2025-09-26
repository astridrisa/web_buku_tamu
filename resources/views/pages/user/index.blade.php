@extends('layouts.app')

@section('page-title', 'User Management')
@section('page-description', 'Kelola daftar pengguna sistem')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        {{-- <h3 class="card-title">{{ $stats['admin'] }}</h3> --}}
                        <p class="card-text">Admin</p>
                    </div>
                    <div class="align-self-center">
                        <i class="mdi mdi-shield-account mdi-24px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        {{-- <h3 class="card-title">{{ $stats['pegawai'] }}</h3> --}}
                        <p class="card-text">Pegawai</p>
                    </div>
                    <div class="align-self-center">
                        <i class="mdi mdi-account-tie mdi-24px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        {{-- <h3 class="card-title">{{ $stats['security'] }}</h3> --}}
                        <p class="card-text">Security</p>
                    </div>
                    <div class="align-self-center">
                        <i class="mdi mdi-security mdi-24px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter and Search Section -->
<div class="card mb-4">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">
                    <i class="mdi mdi-account-multiple text-primary me-2"></i>
                    Daftar User
                </h5>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus me-1"></i>
                    Tambah User
                </a>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('admin.users.list') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="search" class="form-label">Cari User</label>
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   placeholder="Nama atau email..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="role_filter" class="form-label">Filter Role</label>
                        <select class="form-select" id="role_filter" name="role_filter">
                            <option value="">Semua Role</option>
                            {{-- @foreach($roles as $role)
                                <option value="{{ $role->id }}" 
                                        {{ request('role_filter') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="mdi mdi-filter me-1"></i>
                                Filter
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary flex-fill">
                                <i class="mdi mdi-refresh me-1"></i>
                                Reset
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th width="20%">Nama</th>
                        <th width="25%">Email</th>
                        <th width="15%">Role</th>
                        <th width="15%">Status</th>
                        <th width="15%">Terdaftar</th>
                        <th width="5%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3">
                                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/faces/face1.jpg') }}" 
                                             alt="Avatar" 
                                             class="rounded-circle" 
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    </div>
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        @if($user->phone)
                                            <br><small class="text-muted">{{ $user->phone }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    $roleClass = [
                                        1 => 'badge bg-danger',
                                        2 => 'badge bg-warning text-dark',
                                        3 => 'badge bg-info'
                                    ];
                                @endphp
                                <span class="{{ $roleClass[$user->role_id] ?? 'badge bg-secondary' }}">
                                    {{ ucfirst($user->role->name ?? 'Unknown') }}
                                </span>
                            </td>
                            <td>
                                @if($user->status ?? 'active' === 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $user->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                            type="button" 
                                            data-bs-toggle="dropdown">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.users.show', $user->id) }}">
                                                <i class="mdi mdi-eye me-2"></i>
                                                Lihat Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.users.edit', $user->id) }}">
                                                <i class="mdi mdi-pencil me-2"></i>
                                                Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-danger" 
                                                    onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')">
                                                <i class="mdi mdi-delete me-2"></i>
                                                Hapus
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="mdi mdi-account-off mdi-48px text-muted"></i>
                                <p class="text-muted mt-2">Tidak ada data user ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                <p class="text-muted mb-0">
                    Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} 
                    dari {{ $users->total() }} data
                </p>
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus user <strong id="userName"></strong>?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteUser(userId, userName) {
    document.getElementById('userName').textContent = userName;
    document.getElementById('deleteForm').action = `{{ url('user') }}/${userId}`;
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Auto submit form when role filter changes
document.getElementById('role_filter').addEventListener('change', function() {
    this.form.submit();
});
</script>
@endpush

@push('styles')
<style>
.avatar img {
    border: 2px solid #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.table th {
    border-top: none;
    font-weight: 600;
}

.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: none;
}

.dropdown-toggle::after {
    display: none;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}
</style>
@endpush