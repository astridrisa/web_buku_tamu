@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
            <h1 class="h2"><i class="mdi mdi-briefcase-account me-2"></i>Dashboard Pegawai</h1>
            <p class="text-muted mb-0">Kelola persetujuan dan monitoring tamu kunjungan</p>
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

    <!-- Welcome Alert -->
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="mdi mdi-account-check-outline me-2"></i>
        <strong>Halo, {{ Auth::user()->name }}!</strong> Anda memiliki {{ $stats['pending_approval'] }} permintaan tamu yang menunggu persetujuan.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0"><i class="mdi mdi-lightning-bolt me-2"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <a href="{{ route('pegawai.approval') }}" class="btn btn-outline-primary w-100 py-3 position-relative">
                                <i class="mdi mdi-clock-check-outline d-block mb-2" style="font-size: 2rem;"></i>
                                <span class="fw-bold">Approval Tamu</span>
                                @if($stats['pending_approval'] > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $stats['pending_approval'] }}
                                    </span>
                                @endif
                            </a>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <a href="{{ route('profile.index') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="mdi mdi-account-cog d-block mb-2" style="font-size: 2rem;"></i>
                                <span class="fw-bold">Pengaturan</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('pegawai.dashboard') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="mdi mdi-refresh d-block mb-2" style="font-size: 2rem;"></i>
                                <span class="fw-bold">Refresh Data</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card stat-card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="text-primary fw-bold mb-1">{{ number_format($stats['total_pengunjung']) }}</h3>
                                <p class="text-muted mb-0 small">Total Pengunjung</p>
                                <small class="text-primary"><i class="mdi mdi-account-group"></i> Semua Rombongan</small>
                            </div>
                            <div class="icon-large text-primary">
                                <i class="mdi mdi-account-multiple"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-primary bg-opacity-10 border-0">
                        <small class="text-primary"><i class="mdi mdi-information"></i> Total orang yang datang berkunjung</small>
                    </div>
                </div>
            </div>
    {{-- <div class="row mb-4">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card stat-card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-primary fw-bold mb-1">{{ $stats['pending_approval'] }}</h3>
                            <p class="text-muted mb-0 small">Pending Approval</p>
                            <small class="text-warning"><i class="mdi mdi-clock-alert-outline"></i> Memerlukan Aksi</small>
                        </div>
                        <div class="icon-large text-primary">
                            <i class="mdi mdi-account-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary bg-opacity-10 border-0">
                    <small class="text-primary"><i class="mdi mdi-information"></i> Tamu menunggu persetujuan Anda</small>
                </div>
            </div>
        </div> --}}

        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card stat-card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-warning fw-bold mb-1">{{ $stats['approved_today'] }}</h3>
                            <p class="text-muted mb-0 small">Disetujui Hari Ini</p>
                            <small class="text-success"><i class="mdi mdi-trending-up"></i> Produktif</small>
                        </div>
                        <div class="icon-large text-warning">
                            <i class="mdi mdi-calendar-check"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-warning bg-opacity-10 border-0">
                    <small class="text-warning"><i class="mdi mdi-information"></i> Persetujuan hari ini</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card stat-card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-info fw-bold mb-1">{{ $stats['total_approved'] }}</h3>
                            <p class="text-muted mb-0 small">Total Disetujui</p>
                            <small class="text-info"><i class="mdi mdi-chart-timeline-variant"></i> All Time</small>
                        </div>
                        <div class="icon-large text-info">
                            <i class="mdi mdi-check-all"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-info bg-opacity-10 border-0">
                    <small class="text-info"><i class="mdi mdi-information"></i> Total kumulatif persetujuan</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card stat-card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-success fw-bold mb-1">{{ $stats['tamu_bulan_ini'] }}</h3>
                            <p class="text-muted mb-0 small">Tamu Bulan Ini</p>
                            <small class="text-success"><i class="mdi mdi-calendar-month"></i> {{ now()->format('F Y') }}</small>
                        </div>
                        <div class="icon-large text-success">
                            <i class="mdi mdi-account-group"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-success bg-opacity-10 border-0">
                    <small class="text-success"><i class="mdi mdi-information"></i> Total registrasi bulan ini</small>
                </div>
            </div>
        </div>

        {{-- <div class="col-md-6 col-xl-3 mb-4">
            <div class="card stat-card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-success fw-bold mb-1">{{ $stats['approval_rate'] }}%</h3>
                            <p class="text-muted mb-0 small">Approval Rate</p>
                            <small class="text-success"><i class="mdi mdi-trending-up"></i> Performance</small>
                        </div>
                        <div class="icon-large text-success">
                            <i class="mdi mdi-chart-line"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-success bg-opacity-10 border-0">
                    <small class="text-success"><i class="mdi mdi-information"></i> Tingkat persetujuan Anda</small>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Main Content Grid -->
    <div class="row mb-4">
        <!-- Panduan Approval -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="mdi mdi-clipboard-check-outline me-2"></i>Panduan Approval Tamu</h5>
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
                                        <h6 class="fw-bold mb-2">Review Permintaan</h6>
                                        <p class="text-muted small mb-0">Periksa detail tamu, tujuan kunjungan, dan waktu yang diminta dengan teliti.</p>
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
                                        <h6 class="fw-bold mb-2">Verifikasi Data</h6>
                                        <p class="text-muted small mb-0">Pastikan identitas tamu valid dan tujuan kunjungan sesuai dengan keperluan bisnis.</p>
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
                                        <h6 class="fw-bold mb-2">Approve/Reject</h6>
                                        <p class="text-muted small mb-0">Berikan persetujuan atau tolak dengan alasan yang jelas untuk transparansi.</p>
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
                                        <h6 class="fw-bold mb-2">Notifikasi Otomatis</h6>
                                        <p class="text-muted small mb-0">Sistem akan mengirim notifikasi otomatis ke tamu dan security setelah approval.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Section -->
                    <div class="mt-4 p-3 bg-info bg-opacity-10 rounded">
                        <h6 class="text-info fw-bold mb-2">
                            <i class="mdi mdi-lightbulb-on-outline me-2"></i>Tips Approval yang Efektif
                        </h6>
                        <ul class="mb-0 small text-muted">
                            <li class="mb-2">Respons cepat terhadap permintaan untuk meningkatkan produktivitas</li>
                            <li class="mb-2">Gunakan catatan untuk mencatat informasi tambahan yang penting</li>
                            <li class="mb-2">Koordinasi dengan tim jika ada permintaan yang memerlukan validasi lebih lanjut</li>
                            <li class="mb-0">Dokumentasikan alasan penolakan dengan jelas untuk audit trail</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4 mb-4">
            <!-- Checklist Approval -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0"><i class="mdi mdi-checkbox-marked-circle-outline me-2"></i>Checklist Approval</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="mdi mdi-check-circle text-success me-2 mt-1"></i>
                            <span class="small">Verifikasi identitas dan nomor kontak tamu</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="mdi mdi-check-circle text-success me-2 mt-1"></i>
                            <span class="small">Pastikan tujuan kunjungan jelas dan valid</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="mdi mdi-check-circle text-success me-2 mt-1"></i>
                            <span class="small">Cek ketersediaan jadwal dan ruang meeting</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="mdi mdi-check-circle text-success me-2 mt-1"></i>
                            <span class="small">Konfirmasi dengan departemen terkait jika perlu</span>
                        </li>
                        <li class="mb-0 d-flex align-items-start">
                            <i class="mdi mdi-check-circle text-success me-2 mt-1"></i>
                            <span class="small">Berikan approval dalam waktu maksimal 24 jam</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Reminder Card -->
            <div class="card shadow-sm border-0 border-start border-4 border-warning mb-4">
                <div class="card-body">
                    <h6 class="text-warning fw-bold mb-2">
                        <i class="mdi mdi-bell-ring-outline me-2"></i>Reminder
                    </h6>
                    <p class="small text-muted mb-2">Anda memiliki <strong>{{ $stats['pending_approval'] }}</strong> permintaan yang belum diproses.</p>
                    <a href="{{ route('pegawai.approval') }}" class="btn btn-sm btn-warning w-100">
                        <i class="mdi mdi-eye-outline me-1"></i>Lihat Permintaan
                    </a>
                </div>
            </div>

            <!-- Notifications Card -->
            {{-- <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="mdi mdi-bell-outline me-2"></i>Notifikasi
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-2">Kelola notifikasi approval Anda</p>
                    <a href="{{ route('pegawai.notifications') }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="mdi mdi-bell-check-outline me-1"></i>Lihat Notifikasi
                    </a>
                </div>
            </div> --}}

            <!-- Help Card -->
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body text-center">
                    <i class="mdi mdi-help-circle-outline text-primary mb-2" style="font-size: 3rem;"></i>
                    <h6 class="fw-bold mb-2">Butuh Bantuan?</h6>
                    <p class="small text-muted mb-3">Hubungi admin atau IT support jika mengalami kendala</p>
                        <a href="https://jasatirta1.co.id/" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="mdi mdi-phone me-1"></i>Hubungi Support
                        </a>
                    {{-- <button class="btn btn-sm btn-outline-primary">
                        <i class="mdi mdi-phone me-1"></i>Hubungi Support
                    </button>
                </div> --}}
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
    
    .position-relative .badge {
        font-size: 0.7rem;
    }
</style>
@endpush