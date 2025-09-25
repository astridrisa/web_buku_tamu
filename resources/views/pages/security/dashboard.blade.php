@extends('layouts.app')

@section('title', 'Dashboard Security')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="mdi mdi-view-dashboard me-2"></i>Dashboard Security</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="location.reload()">
                <i class="mdi mdi-refresh"></i> Refresh
            </button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Tamu
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Belum Check In
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['belum_checkin'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Sudah Check In
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['checkin'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Disetujui
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['approved'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Guests Table -->
<div class="card shadow mb-4">
    {{-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="mdi mdi-account-group me-2"></i>Daftar Tamu Terbaru
        </h6>
        <a href="{{ route('security.tamu.index') }}" class="btn btn-primary btn-sm">
            <i class="mdi mdi-view-list me-1"></i>Lihat Semua
        </a>
    </div> --}}
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tujuan</th>
                        <th>Identitas</th>
                        <th>Status</th>
                        <th>Waktu Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tamus->take(10) as $tamu)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            {{ substr($tamu->nama, 0, 1) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $tamu->nama }}</h6>
                                        @if($tamu->jumlah_rombongan > 1)
                                            <small class="text-muted">{{ $tamu->jumlah_rombongan }} orang</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $tamu->email }}</td>
                            <td>{{ Str::limit($tamu->tujuan, 30) }}</td>
                            <td>{{ $tamu->jenisIdentitas->nama }}</td>
                            <td>
                                <span class="badge bg-{{ $tamu->status_color }}">
                                    {{ $tamu->status_text }}
                                </span>
                            </td>
                            <td>{{ $tamu->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    {{-- <a href="{{ route('security.tamu.detail', $tamu->id) }}" 
                                       class="btn btn-outline-primary" title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </a> --}}
                                    
                                    @if($tamu->status === 'belum_checkin')
                                        <button type="button" class="btn btn-outline-success checkin-btn" 
                                                data-id="{{ $tamu->id }}" data-name="{{ $tamu->nama }}" title="Check In">
                                            <i class="mdi mdi-login"></i>
                                        </button>
                                    @elseif($tamu->status === 'approved')
                                        <button type="button" class="btn btn-outline-danger checkout-btn" 
                                                data-id="{{ $tamu->id }}" data-name="{{ $tamu->nama }}" title="Check Out">
                                            <i class="mdi mdi-logout"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="mdi mdi-account-off mdi-48px text-muted mb-2"></i>
                                    <p class="text-muted">Belum ada data tamu</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">QR Code Tamu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div id="qrContent">
                    <!-- QR Code will be loaded here -->
                </div>
                <p class="mt-3 text-muted">
                    Tunjukkan QR Code ini kepada tamu untuk ditunjukkan ke pegawai
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="printQr">
                    <i class="mdi mdi-printer me-1"></i>Print QR
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    
    .avatar {
        width: 2.5rem;
        height: 2.5rem;
    }
    
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-weight: 600;
    }
    
    .card {
        transition: transform 0.15s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        
        #printArea * {
            visibility: visible;
        }
        
        #printArea {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Check-in functionality
    $('.checkin-btn').click(function() {
        const tamuId = $(this).data('id');
        const tamuName = $(this).data('name');
        const button = $(this);
        
        if (confirm(`Apakah Anda yakin akan check-in tamu ${tamuName}?`)) {
            button.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i>');
            
            $.ajax({
                url: `/security/tamu/${tamuId}/checkin`,
                method: 'POST',
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        showAlert('success', response.message);
                        
                        // Show QR Code
                        showQrCode(response.qr_code, tamuName);
                        
                        // Reload page after modal closes
                        $('#qrModal').on('hidden.bs.modal', function() {
                            location.reload();
                        });
                    } else {
                        showAlert('danger', response.message);
                        button.prop('disabled', false).html('<i class="mdi mdi-login"></i>');
                    }
                },
                error: function(xhr) {
                    showAlert('danger', 'Terjadi kesalahan saat check-in');
                    button.prop('disabled', false).html('<i class="mdi mdi-login"></i>');
                }
            });
        }
    });
    
    // Check-out functionality
    $('.checkout-btn').click(function() {
        const tamuId = $(this).data('id');
        const tamuName = $(this).data('name');
        const button = $(this);
        
        if (confirm(`Apakah Anda yakin akan check-out tamu ${tamuName}?`)) {
            button.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i>');
            
            $.ajax({
                url: `/security/tamu/${tamuId}/checkout`,
                method: 'POST',
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        location.reload();
                    } else {
                        showAlert('danger', response.message);
                        button.prop('disabled', false).html('<i class="mdi mdi-logout"></i>');
                    }
                },
                error: function(xhr) {
                    showAlert('danger', 'Terjadi kesalahan saat check-out');
                    button.prop('disabled', false).html('<i class="mdi mdi-logout"></i>');
                }
            });
        }
    });
    
    // Show QR Code
    function showQrCode(qrUrl, tamuName) {
        const qrContent = `
            <div id="printArea">
                <h5>${tamuName}</h5>
                <div class="mb-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(qrUrl)}" 
                         alt="QR Code" class="img-fluid">
                </div>
                <p class="small">Tunjukkan QR Code ini ke pegawai</p>
                <p class="small text-muted">${new Date().toLocaleString('id-ID')}</p>
            </div>
        `;
        
        $('#qrContent').html(qrContent);
        $('#qrModal').modal('show');
    }
    
    // Print QR functionality
    $('#printQr').click(function() {
        window.print();
    });
    
    // Show alert function
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Remove existing alerts
        $('.alert').remove();
        
        // Add new alert at the top
        $('main').prepend(alertHtml);
        
        // Auto hide after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
    
    // Auto refresh every 30 seconds
    setInterval(function() {
        // Only refresh if no modal is open
        if (!$('.modal.show').length) {
            location.reload();
        }
    }, 30000);
});
</script>
@endpush