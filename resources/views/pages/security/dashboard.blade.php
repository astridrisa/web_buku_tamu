@extends('layouts.app')

@section('title', 'Dashboard Security')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
            <h1 class="h2"><i class="mdi mdi-shield-check me-2"></i>Dashboard Security</h1>
            <p class="text-muted mb-0">Monitoring dan manajemen tamu secara real-time</p>
        </div>
        <div class="col-12 col-xl-4">
            <div class="justify-content-end d-flex">
                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                    <button class="btn btn-sm btn-light bg-white dropdown-toggle shadow-sm" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="mdi mdi-calendar"></i> Today ({{ date('d M Y') }})
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Info -->
    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
        <i class="mdi mdi-information-outline me-2"></i>
        <strong>Selamat Datang!</strong> Dashboard ini menampilkan ringkasan data tamu hari ini. Gunakan menu navigasi untuk mengelola data tamu.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card stat-card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-primary fw-bold mb-1">{{ $stats['total'] }}</h3>
                            <p class="text-muted mb-0 small">Total Tamu</p>
                            <small class="text-success"><i class="mdi mdi-trending-up"></i> Hari ini</small>
                        </div>
                        <div class="icon-large text-primary">
                            <i class="mdi mdi-account-multiple"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary bg-opacity-10 border-0">
                    <small class="text-primary"><i class="mdi mdi-information"></i> Total registrasi tamu</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card stat-card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-warning fw-bold mb-1">{{ $stats['belum_checkin'] }}</h3>
                            <p class="text-muted mb-0 small">Belum Check In</p>
                            <small class="text-warning"><i class="mdi mdi-clock-alert-outline"></i> Menunggu</small>
                        </div>
                        <div class="icon-large text-warning">
                            <i class="mdi mdi-clock-outline"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-warning bg-opacity-10 border-0">
                    <small class="text-warning"><i class="mdi mdi-information"></i> Tamu belum melakukan check in</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card stat-card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-info fw-bold mb-1">{{ $stats['checkin'] }}</h3>
                            <p class="text-muted mb-0 small">Sudah Check In</p>
                            <small class="text-info"><i class="mdi mdi-account-check"></i> Aktif</small>
                        </div>
                        <div class="icon-large text-info">
                            <i class="mdi mdi-check-all"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-info bg-opacity-10 border-0">
                    <small class="text-info"><i class="mdi mdi-information"></i> Tamu yang sudah check in</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card stat-card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-success fw-bold mb-1">{{ $stats['approved'] }}</h3>
                            <p class="text-muted mb-0 small">Disetujui</p>
                            <small class="text-success"><i class="mdi mdi-shield-check"></i> Verified</small>
                        </div>
                        <div class="icon-large text-success">
                            <i class="mdi mdi-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-success bg-opacity-10 border-0">
                    <small class="text-success"><i class="mdi mdi-information"></i> Tamu yang telah diverifikasi</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Guide Section -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="mdi mdi-book-open-page-variant me-2"></i>Panduan Penggunaan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="guide-item p-3 bg-light rounded">
                                <div class="d-flex align-items-start">
                                    <div class="guide-number me-3">
                                        <span class="badge bg-primary rounded-circle">1</span>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-2">Registrasi Tamu</h6>
                                        <p class="text-muted small mb-0">Tambahkan data tamu baru melalui menu "Tambah Tamu" atau scan QR code untuk registrasi cepat.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="guide-item p-3 bg-light rounded">
                                <div class="d-flex align-items-start">
                                    <div class="guide-number me-3">
                                        <span class="badge bg-primary rounded-circle">2</span>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-2">Verifikasi & Approval</h6>
                                        <p class="text-muted small mb-0">Periksa dan setujui permintaan kunjungan tamu melalui menu "Daftar Tamu".</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="guide-item p-3 bg-light rounded">
                                <div class="d-flex align-items-start">
                                    <div class="guide-number me-3">
                                        <span class="badge bg-primary rounded-circle">3</span>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-2">Check In/Out</h6>
                                        <p class="text-muted small mb-0">Lakukan check in saat tamu tiba dan check out saat tamu meninggalkan area.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="guide-item p-3 bg-light rounded">
                                <div class="d-flex align-items-start">
                                    <div class="guide-number me-3">
                                        <span class="badge bg-primary rounded-circle">4</span>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-2">Laporan & Monitoring</h6>
                                        <p class="text-muted small mb-0">Pantau aktivitas tamu secara real-time dan unduh laporan kunjungan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0"><i class="mdi mdi-information-outline me-2"></i>Informasi Penting</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="mdi mdi-check-circle text-success me-2 mt-1"></i>
                            <span class="small">Pastikan data tamu terverifikasi sebelum memberikan akses</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="mdi mdi-check-circle text-success me-2 mt-1"></i>
                            <span class="small">Lakukan check in/out untuk tracking akurat</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="mdi mdi-check-circle text-success me-2 mt-1"></i>
                            <span class="small">Monitor tamu yang belum check in secara berkala</span>
                        </li>
                        <li class="mb-0 d-flex align-items-start">
                            <i class="mdi mdi-check-circle text-success me-2 mt-1"></i>
                            <span class="small">Backup data secara rutin untuk keamanan</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm border-0 border-start border-4 border-danger">
                <div class="card-body">
                    <h6 class="text-danger fw-bold mb-2">
                        <i class="mdi mdi-alert-circle-outline me-2"></i>Peringatan Keamanan
                    </h6>
                    <p class="small text-muted mb-0">Segera hubungi supervisor jika menemukan aktivitas mencurigakan atau tamu yang tidak terdaftar.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0"><i class="mdi mdi-lightning-bolt me-2"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <a href="{{ route('security.create') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="mdi mdi-account-plus d-block mb-2" style="font-size: 2rem;"></i>
                                <span class="fw-bold">Tambah Tamu</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <a href="{{ route('security.list') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="mdi mdi-format-list-bulleted d-block mb-2" style="font-size: 2rem;"></i>
                                <span class="fw-bold">Daftar Tamu</span>
                            </a>
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
        font-size: 3rem;
        opacity: 0.7;
    }
    
    .stat-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
    
    .guide-item {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .guide-item:hover {
        border-color: #667eea;
        background: #f8f9ff !important;
        transform: translateX(5px);
    }
    
    .guide-number .badge {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }
    
    .card-header h5 {
        font-weight: 600;
    }
    
    .alert {
        border-radius: 10px;
        border: none;
    }
    
    .btn-outline-primary:hover,
    .btn-outline-info:hover,
    .btn-outline-success:hover,
    .btn-outline-warning:hover {
        transform: scale(1.05);
        transition: all 0.3s ease;
    }
</style>
@endpush