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
                            <h3 class="text-white">{{ $stats['admin'] ?? 0 }}</h3>
                            <p class="card-text mb-0">Admin</p>
                        </div>
                        <div class="align-self-center">
                            <i class="mdi mdi-shield-account mdi-48px"></i>
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
                            <h3 class="text-white">{{ $stats['pegawai'] ?? 0 }}</h3>
                            <p class="card-text mb-0">Pegawai</p>
                        </div>
                        <div class="align-self-center">
                            <i class="mdi mdi-account-tie mdi-48px"></i>
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
                            <h3 class="text-white">{{ $stats['security'] ?? 0 }}</h3>
                            <p class="card-text mb-0">Security</p>
                        </div>
                        <div class="align-self-center">
                            <i class="mdi mdi-security mdi-48px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="text-white">{{ $stats['total'] ?? 0 }}</h3>
                            <p class="card-text mb-0">Total User</p>
                        </div>
                        <div class="align-self-center">
                            <i class="mdi mdi-account-group mdi-48px"></i>
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
            <form method="GET" action="{{ route('admin.users.index') }}" id="filterForm" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label for="search" class="form-label">
                            <i class="mdi mdi-magnify me-1"></i>Pencarian
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="mdi mdi-account-search"></i>
                            </span>
                            <input type="text" class="form-control" id="search" name="search"
                                placeholder="Cari berdasarkan nama atau email..." value="{{ request('search') }}">
                            @if(request('search'))
                                <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()"
                                    title="Hapus pencarian">
                                    <i class="mdi mdi-close"></i>
                                </button>
                            @endif
                        </div>
                        @if(request('search'))
                            <small class="text-muted">
                                <i class="mdi mdi-information me-1"></i>
                                Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                            </small>
                        @endif
                    </div>

                    <div class="col-md-3">
                        <label for="role_filter" class="form-label">
                            <i class="mdi mdi-shield-account me-1"></i>Filter Role
                        </label>
                        <select class="form-select" id="role_filter" name="role_filter">
                            <option value="">Semua Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ request('role_filter') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->nama_role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label d-block">&nbsp;</label>
                        <div class="d-grid gap-2">
                            {{-- <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-filter-variant me-1"></i>
                                Terapkan
                            </button> --}}
                            @if(request()->hasAny(['search', 'role_filter', 'status_filter']))
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                    <i class="mdi mdi-refresh me-1"></i>
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Active Filters Display -->
                @if(request()->hasAny(['search', 'role_filter', 'status_filter']))
                    <div class="mt-3">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <span class="text-muted">
                                <i class="mdi mdi-filter me-1"></i>Filter aktif:
                            </span>

                            @if(request('search'))
                                <span class="badge bg-primary">
                                    <i class="mdi mdi-magnify me-1"></i>
                                    Pencarian: "{{ request('search') }}"
                                    <a href="{{ route('admin.users.index', array_filter(request()->except('search'))) }}"
                                        class="text-white ms-1">
                                        <i class="mdi mdi-close-circle"></i>
                                    </a>
                                </span>
                            @endif

                            @if(request('role_filter'))
                                @php
                                    $selectedRole = $roles->where('id', request('role_filter'))->first();
                                @endphp
                                <span class="badge bg-warning text-dark">
                                    <i class="mdi mdi-shield-account me-1"></i>
                                    Role: {{ $selectedRole ? ucfirst($selectedRole->nama_role) : 'Unknown' }}
                                    <a href="{{ route('admin.users.index', array_filter(request()->except('role_filter'))) }}"
                                        class="text-dark ms-1">
                                        <i class="mdi mdi-close-circle"></i>
                                    </a>
                                </span>
                            @endif

                            @if(request('status_filter'))
                                <span class="badge bg-info">
                                    <i class="mdi mdi-check-circle me-1"></i>
                                    Status: {{ request('status_filter') == 'active' ? 'Aktif' : 'Nonaktif' }}
                                    <a href="{{ route('admin.users.index', array_filter(request()->except('status_filter'))) }}"
                                        class="text-white ms-1">
                                        <i class="mdi mdi-close-circle"></i>
                                    </a>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </form>

            <!-- Users Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama</th>
                            <th width="20%">Email</th>
                            <th width="12%">Role</th>
                            <th width="10%">Status</th>
                            <th width="13%">Terdaftar</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle-sm me-2">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                            @if($user->phone)
                                                <br><small class="text-muted">
                                                    <i class="mdi mdi-phone"></i> {{ $user->phone }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="mdi mdi-email-outline me-1"></i>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    @php
                                        $roleClass = [
                                            1 => 'badge bg-danger',
                                            2 => 'badge bg-warning text-dark',
                                            3 => 'badge bg-info'
                                        ];
                                    @endphp
                                    <span class="{{ $roleClass[$user->role_id] ?? 'badge bg-secondary' }}">
                                        {{ ucfirst($user->role->nama_role ?? 'Unknown') }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->status ?? 'active' === 'active')
                                        <span class="badge bg-success">
                                            <i class="mdi mdi-check-circle me-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="mdi mdi-close-circle me-1"></i>Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="mdi mdi-calendar me-1"></i>
                                        {{ optional($user->created_at)->format('d/m/Y') }}
                                        <br>
                                        <i class="mdi mdi-clock-outline me-1"></i>
                                        {{ optional($user->created_at)->format('H:i') }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.users.show', $user->id) }}">
                                                    <i class="mdi mdi-eye me-2 text-info"></i>
                                                    Lihat Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.users.edit', $user->id) }}">
                                                    <i class="mdi mdi-pencil me-2 text-warning"></i>
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <button type="button" class=" dropdown-item text-danger btn-delete"
                                                    data-url="{{ route('admin.users.delete', $user->id) }}"
                                                    data-name="{{ $user->name }}"><i class="mdi mdi-delete me-2"></i>
                                                    Hapus
                                                </button>

                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="mdi mdi-account-off mdi-48px text-muted d-block mb-3"></i>
                                    <h5 class="text-muted">Tidak ada data user ditemukan</h5>
                                    @if(request()->hasAny(['search', 'role_filter', 'status_filter']))
                                        <p class="text-muted mb-3">Coba ubah kriteria pencarian atau filter Anda</p>
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                                            <i class="mdi mdi-refresh me-1"></i>
                                            Reset Filter
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <p class="text-muted mb-0">
                            Menampilkan <strong>{{ $users->firstItem() ?? 0 }}</strong> -
                            <strong>{{ $users->lastItem() ?? 0 }}</strong>
                            dari <strong>{{ $users->total() }}</strong> data
                        </p>
                    </div>
                    <div>
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="mdi mdi-alert-circle me-2"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="mdi mdi-delete-alert mdi-48px text-danger mb-3 d-block"></i>
                    <p class="mb-2">Apakah Anda yakin ingin menghapus user:</p>
                    <h5 class="mb-3"><strong id="userName"></strong>?</h5>
                    <div class="alert alert-warning" role="alert">
                        <i class="mdi mdi-alert me-2"></i>
                        Tindakan ini tidak dapat dibatalkan!
                    </div>
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
@endsection

@push('scripts')
    <script>
        $('.btn-delete').on('click', function () {
            var url = $(this).data('url');
            var userName = $(this).data('name');
            $('#userName').text(userName);
            $('#deleteForm').attr('action', url);
            $('#deleteModal').modal('show');
        });

        function clearSearch() {
            document.getElementById('search').value = '';
            document.getElementById('filterForm').submit();
        }

        // Auto submit form when role or status filter changes
        document.getElementById('role_filter').addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });

        document.getElementById('status_filter').addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });

        // Show loading state on form submit
        document.getElementById('filterForm').addEventListener('submit', function () {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i>Memuat...';
            submitBtn.disabled = true;
        });
    </script>
@endpush

@push('styles')
    <style>
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0;
        }

        .avatar-circle-sm {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            flex-shrink: 0;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            background-color: #2c3e50;
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .dropdown-toggle::after {
            display: none;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
            font-weight: 500;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: 0;
        }

        .input-group .form-control {
            border-left: 0;
        }

        .input-group .form-control:focus {
            border-color: #ced4da;
            box-shadow: none;
        }

        .badge .mdi-close-circle {
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        .badge .mdi-close-circle:hover {
            opacity: 1;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .mdi-spin {
            animation: spin 1s linear infinite;
        }
    </style>
@endpush