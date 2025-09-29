@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h1 class="h2"><i class="mdi mdi-view-dashboard me-2"></i>Dashboard Admin</h1>
                {{-- <h3 class="font-weight-bold">Welcome, {{ auth()->user()->name }}!</h3>
                <h6 class="font-weight-normal mb-0">Admin Dashboard - {{ auth()->user()->role->role_name ?? 'Administrator' }}</h6> --}}
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                        <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="mdi mdi-calendar"></i> Today ({{ date('d M Y') }})
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-md-6 col-xl-3 mb-4 mb-md-2">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-primary">{{ $stats['total_users'] }}</h3>
                        <p class="text-muted mb-0">Total Users</p>
                    </div>
                    <div class="icon-large text-primary">
                        <i class="mdi mdi-account-group"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4 mb-md-2">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-success">{{ $stats['total_tamu'] }}</h3>
                        <p class="text-muted mb-0">Total Tamu</p>
                    </div>
                    <div class="icon-large text-success">
                        <i class="mdi mdi-account-multiple"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4 mb-md-2">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-info">{{ $stats['total_tamu_today'] }}</h3>
                        <p class="text-muted mb-0">Tamu Today</p>
                    </div>
                    <div class="icon-large text-info">
                        <i class="mdi mdi-calendar-today"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4 mb-md-2">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-warning">{{ $stats['total_pending_tamu'] }}</h3>
                        <p class="text-muted mb-0">Pending Approval</p>
                    </div>
                    <div class="icon-large text-warning">
                        <i class="mdi mdi-clock-outline"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Users -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Recent Users</p>
                    <a href="{{ route('admin.users.index') }}" class="text-info">View all</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsers as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="d-flex flex-column justify-content-around">
                                                <p class="mb-0 text-sm">{{ $user->name }}</p>
                                                <p class="text-muted mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $user->role_id == 1 ? 'danger' : ($user->role_id == 2 ? 'warning' : 'info') }}">
                                            {{ $user->role->nama_role ?? 'Unknown' }}
                                        </span>
                                    </td>
                                    <td><i class="mdi mdi-circle text-success"></i> Active</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Tamu -->
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-title">Recent Tamu</p>
                    <a href="{{ route('admin.tamu.index') }}" class="text-info">View all</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Purpose</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTamu as $tamu)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="d-flex flex-column justify-content-around">
                                                <p class="mb-0 text-sm">{{ $tamu->nama }}</p>
                                                <p class="text-muted mb-0">{{ $tamu->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($tamu->tujuan, 20) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $tamu->status === 'approved' ? 'success' : ($tamu->status === 'belum_checkin' ? 'warning' : 'danger') }}">
                                            {{ ucfirst(str_replace('_', ' ', $tamu->status)) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No tamu found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title card-title-dash">Quick Actions</h4>
                        </div>
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-lg btn-block">
                                        <i class="mdi mdi-account-plus"></i> Add New User
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-info btn-lg btn-block">
                                        <i class="mdi mdi-account-group"></i> Manage Users
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.tamu.index') }}" class="btn btn-success btn-lg btn-block">
                                        <i class="mdi mdi-account-multiple"></i> Manage Tamu
                                    </a>
                                </div>
                                {{-- <div class="col-md-3 mb-3">
                                    <a href="{{ route('security.index') }}" class="btn btn-warning btn-lg btn-block">
                                        <i class="mdi mdi-shield-account"></i> Security Panel
                                    </a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-large {
        font-size: 2.5rem;
        opacity: 0.8;
    }
</style>
@endpush