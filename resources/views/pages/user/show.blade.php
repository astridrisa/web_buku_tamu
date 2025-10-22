@extends('layouts.app')

@section('page-title', 'Detail User')
@section('page-description', 'Informasi lengkap pengguna')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <!-- User Profile Card -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="mdi mdi-account-circle me-2"></i>
                        Detail Informasi User
                    </h5>
                    <div>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-light btn-sm me-2">
                            <i class="mdi mdi-pencil me-1"></i>
                            Edit
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm">
                            <i class="mdi mdi-arrow-left me-1"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Profile Avatar Section -->
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        <div class="avatar-container mb-3">
                            <div class="avatar-circle">
                                <span class="avatar-initials">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="mb-3">
                            @if($user->status ?? 'active' === 'active')
                                <span class="badge bg-success px-4 py-2">
                                    <i class="mdi mdi-check-circle me-1"></i>
                                    Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary px-4 py-2">
                                    <i class="mdi mdi-close-circle me-1"></i>
                                    Nonaktif
                                </span>
                            @endif
                        </div>

                        <!-- Role Badge -->
                        @php
                            $roleClass = [
                                1 => 'bg-danger',
                                2 => 'bg-warning text-dark',
                                3 => 'bg-info'
                            ];
                            $roleIcon = [
                                1 => 'mdi-shield-account',
                                2 => 'mdi-account-tie',
                                3 => 'mdi-security'
                            ];
                        @endphp
                        <div class="badge {{ $roleClass[$user->role_id] ?? 'bg-secondary' }} px-4 py-2">
                            <i class="mdi {{ $roleIcon[$user->role_id] ?? 'mdi-account' }} me-1"></i>
                            {{ ucfirst($user->role->nama_role ?? 'Unknown') }}
                        </div>
                    </div>

                    <!-- User Information -->
                    <div class="col-md-8">
                        <h4 class="mb-3">{{ $user->name }}</h4>
                        
                        <div class="info-section">

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small mb-1">
                                    <i class="mdi mdi-badge-account me-1"></i>
                                    Kode Pegawai
                                </label>
                                <h6 class="mb-0">
                                    <span class="badge bg-dark">{{ $user->kopeg }}</span>
                                </h6>
                            </div>
                            <!-- Email -->
                            <div class="info-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="info-icon">
                                        <i class="mdi mdi-email text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="info-label">Email</label>
                                        <p class="info-value mb-0">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="info-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="info-icon">
                                        <i class="mdi mdi-phone text-success"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="info-label">No. Telepon</label>
                                        <p class="info-value mb-0">
                                            {{ $user->phone ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- User ID -->
                            <div class="info-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="info-icon">
                                        <i class="mdi mdi-identifier text-secondary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="info-label">User ID</label>
                                        <p class="info-value mb-0">
                                            <code>#{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</code>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Registered Date -->
                            <div class="info-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="info-icon">
                                        <i class="mdi mdi-calendar text-info"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="info-label">Terdaftar Sejak</label>
                                        <p class="info-value mb-0">
                                            {{ $user->created_at->format('d F Y') }}
                                            <small class="text-muted">({{ $user->created_at->diffForHumans() }})</small>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Last Update -->
                            <div class="info-item">
                                <div class="d-flex align-items-start">
                                    <div class="info-icon">
                                        <i class="mdi mdi-update text-warning"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="info-label">Terakhir Diupdate</label>
                                        <p class="info-value mb-0">
                                            {{ $user->updated_at->format('d F Y, H:i') }}
                                            <small class="text-muted">({{ $user->updated_at->diffForHumans() }})</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons Card -->
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-3">
                    <i class="mdi mdi-cog text-muted me-2"></i>
                    Aksi
                </h6>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                        <i class="mdi mdi-pencil me-1"></i>
                        Edit User
                    </a>
                    
                    @if($user->status ?? 'active' === 'active')
                        <button type="button" class="btn btn-secondary" onclick="toggleStatus({{ $user->id }}, 'inactive')">
                            <i class="mdi mdi-account-off me-1"></i>
                            Nonaktifkan User
                        </button>
                    @else
                        <button type="button" class="btn btn-success" onclick="toggleStatus({{ $user->id }}, 'active')">
                            <i class="mdi mdi-account-check me-1"></i>
                            Aktifkan User
                        </button>
                    @endif
                    
                    <button type="button" class="btn btn-danger" onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')">
                        <i class="mdi mdi-delete me-1"></i>
                        Hapus User
                    </button>
                </div>
            </div>
        </div>

        <!-- Additional Information Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="mdi mdi-information text-info me-2"></i>
                    Informasi Tambahan
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="stat-box">
                            <div class="stat-icon bg-primary">
                                <i class="mdi mdi-clock-outline"></i>
                            </div>
                            <div class="stat-content">
                                <small class="text-muted">Akun Berusia</small>
                                <h5 class="mb-0">{{ $user->created_at->diffInDays(now()) }} Hari</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="stat-box">
                            <div class="stat-icon bg-success">
                                <i class="mdi mdi-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <small class="text-muted">Status Akun</small>
                                <h5 class="mb-0">{{ $user->status ?? 'active' === 'active' ? 'Aktif' : 'Nonaktif' }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-light border mt-3" role="alert">
                    <i class="mdi mdi-shield-check text-success me-2"></i>
                    <strong>Catatan Keamanan:</strong> Pastikan data user selalu dijaga kerahasiaannya. 
                    Jangan membagikan informasi akun kepada pihak yang tidak berkepentingan.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="mdi mdi-alert me-2"></i>
                    Konfirmasi Hapus User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="mdi mdi-alert-circle text-danger" style="font-size: 64px;"></i>
                </div>
                <p class="text-center">Apakah Anda yakin ingin menghapus user <strong id="userName"></strong>?</p>
                <p class="text-danger text-center mb-0">
                    <i class="mdi mdi-information me-1"></i>
                    Tindakan ini tidak dapat dibatalkan!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="mdi mdi-close me-1"></i>
                    Batal
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="mdi mdi-delete me-1"></i>
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Toggle Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="mdi mdi-account-cog me-2"></i>
                    Konfirmasi Ubah Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin mengubah status user <strong>{{ $user->name }}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="statusForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-primary">Ya, Ubah Status</button>
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
    document.getElementById('deleteForm').action = `{{ url('admin/users') }}/${userId}`;
    
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

function toggleStatus(userId, newStatus) {
    document.getElementById('statusForm').action = `{{ url('admin/users') }}/${userId}/status`;
    
    // Add hidden input for status
    let statusInput = document.createElement('input');
    statusInput.type = 'hidden';
    statusInput.name = 'status';
    statusInput.value = newStatus;
    document.getElementById('statusForm').appendChild(statusInput);
    
    var statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
    statusModal.show();
}
</script>
@endpush

@push('styles')
<style>
.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: none;
}

.avatar-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.avatar-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    border: 4px solid #fff;
}

.avatar-initials {
    font-size: 48px;
    font-weight: bold;
    color: white;
}

.info-section {
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
}

.info-item {
    padding-bottom: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.info-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 24px;
}

.info-label {
    display: block;
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
    font-weight: 500;
}

.info-value {
    font-size: 1rem;
    color: #212529;
    font-weight: 500;
}

.stat-box {
    display: flex;
    align-items: center;
    padding: 1rem;
    background-color: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: white;
    font-size: 24px;
}

.stat-content {
    flex-grow: 1;
}

.badge {
    font-size: 0.875rem;
}

code {
    background-color: #f8f9fa;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
}
</style>
@endpush