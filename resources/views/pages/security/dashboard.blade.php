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

    @push('styles')
        <!-- DataTables Bootstrap 5 CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    @endpush

    <!-- Recent Guests Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="recentGuestsTable">
                    <thead>
                        <tr>
                            <th>No</th>
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
                        @forelse($tamus as $tamu)
                            <tr>
                                <td></td> <!-- nomor otomatis diisi oleh DataTables -->
                                <td>
                                    <h6 class="mb-0">{{ $tamu->nama }}</h6>
                                    @if($tamu->jumlah_rombongan > 1)
                                        <small class="text-muted">{{ $tamu->jumlah_rombongan }} orang</small>
                                    @endif
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

    @push('scripts')
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function () {
                // Inisialisasi DataTable dengan responsive
                $('#recentGuestsTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    order: [[6, 'desc']], // urut berdasarkan waktu daftar
                    responsive: true,
                    columnDefs: [
                        { orderable: false, targets: 0 } // kolom nomor tidak bisa diurutkan
                    ],
                    rowCallback: function (row, data, index) {
                        var table = $('#recentGuestsTable').DataTable();
                        var pageInfo = table.page.info();
                        $('td:eq(0)', row).html(pageInfo.start + index + 1);
                    },
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        infoEmpty: "Tidak ada data tersedia",
                        zeroRecords: "Data tidak ditemukan",
                        paginate: {
                            first: "Awal",
                            last: "Akhir",
                            next: "›",
                            previous: "‹"
                        }
                    }
                });


                // Check-in dan Check-out
                $('.checkin-btn').click(function () {
                    const tamuId = $(this).data('id');
                    const tamuName = $(this).data('name');
                    const button = $(this);
                    if (confirm(`Apakah Anda yakin akan check-in tamu ${tamuName}?`)) {
                        button.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i>');
                        $.ajax({
                            url: `/security/${tamuId}/checkin`,
                            method: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                                    success: function (response) {
                                if (response.success) {
                                    showAlert('success', response.message);
                                    showQrCode(response.qr_code, tamuName);
                                    $('#qrModal').on('hidden.bs.modal', function () {
                                        location.reload();
                                    });
                                } else {
                                    showAlert('danger', response.message);
                                    button.prop('disabled', false).html('<i class="mdi mdi-login"></i>');
                                }
                            },
                            error: function () {
                                showAlert('danger', 'Terjadi kesalahan saat check-in');
                                button.prop('disabled', false).html('<i class="mdi mdi-login"></i>');
                            }
                        });
                    }
                });

                $('.checkout-btn').click(function () {
                    const tamuId = $(this).data('id');
                    const tamuName = $(this).data('name');
                    const button = $(this);
                    if (confirm(`Apakah Anda yakin akan check-out tamu ${tamuName}?`)) {
                        button.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i>');
                        $.ajax({
                            url: `/security/tamu/${tamuId}/checkout`,
                            method: 'POST',
                            success: function (response) {
                                if (response.success) {
                                    showAlert('success', response.message);
                                    location.reload();
                                } else {
                                    showAlert('danger', response.message);
                                    button.prop('disabled', false).html('<i class="mdi mdi-logout"></i>');
                                }
                            },
                            error: function () {
                                showAlert('danger', 'Terjadi kesalahan saat check-out');
                                button.prop('disabled', false).html('<i class="mdi mdi-logout"></i>');
                            }
                        });
                    }
                });

                // Fungsi alert sederhana
                function showAlert(type, message) {
                    const alertHtml = `
                                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                                        ${message}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>`;
                    $('main').prepend(alertHtml);
                    setTimeout(() => $('.alert').fadeOut(), 5000);
                }

                // Fungsi QR Code sederhana
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
                                    </div>`;
                    $('#qrContent').html(qrContent);
                    $('#qrModal').modal('show');
                }
            });
        </script>
    @endpush
@endsection