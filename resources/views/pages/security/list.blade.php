@extends('layouts.app')

@section('title', 'List Tamu')

@section('content')



    @push('styles')
        <!-- DataTables Bootstrap 5 CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    @endpush

    <!-- Recent Guests Table -->
    <div class="card mb-4">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <i class="mdi mdi-account-multiple text-primary me-2"></i>
                        Daftar Tamu
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus me-1"></i>
                        Tambah Tamu
                    </a>
                </div>
            </div>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle" id="recentGuestsTable">
                    <thead class="table-dark" style="background-color: #2c3e50;">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama</th>
                            <th width="20%">Email</th>
                            <th width="12%">Tujuan</th>
                            <th width="10%">Identitas</th>
                            <th width="13%">Status</th>
                            <th width="13%">Waktu Daftar</th>
                            <th width="10%">Aksi</th>
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
                    order: [[6, 'desc']],
                    responsive: true,
                    dom: '<"d-flex justify-content-between align-items-end mb-3 flex-wrap"<"d-flex gap-3"f><"d-flex gap-2"B>>rtip',
                    buttons: [
                        {
                            text: '<i class="mdi mdi-filter me-1"></i> Filter',
                            className: 'btn btn-primary btn-sm',
                            action: function () {
                                $('#statusFilter').trigger('change');
                            }
                        },
                        {
                            text: '<i class="mdi mdi-refresh me-1"></i> Reset',
                            className: 'btn btn-outline-secondary btn-sm',
                            action: function (e, dt) {
                                dt.search('').columns().search('').draw();
                                $('#statusFilter').val('');
                            }
                        }
                    ],
                    columnDefs: [
                        {
                            targets: 0,          // kolom pertama (No)
                            orderable: false,    // supaya nggak bisa di-sort
                            searchable: false,   // supaya nggak ikut search
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        }
                    ],
                    initComplete: function () {
                        var api = this.api();

                        // === Styling search bawaan ===
                        var $search = $('#recentGuestsTable_filter input')
                            .attr('placeholder', '...')
                            .addClass('form-control');
                        $('#recentGuestsTable_filter label').contents().filter(function () {
                            return this.nodeType === 3;
                        }).remove(); // hapus label "Search:"

                        $('#recentGuestsTable_filter').addClass('form-group mb-0 me-3');
                        $('#recentGuestsTable_filter').prepend('<label class="form-label d-block"><i class="mdi mdi-account-search"></i> Cari Tamu</label>');

                        $search.wrap('<div class="input-group"></div>');
                        $search.after('<button class="btn btn-outline-primary" type="button"><i class="mdi mdi-magnify"></i></button>');

                        // === Tambah filter status + refresh sebaris ===
                        var filterHtml = $(
                            '<div class="d-flex align-items-end mb-3">' +
                            '  <div class="form-group mb-0 me-4">' +
                            '    <label class="form-label"><i class="mdi mdi-shield-account me-1"></i> Filter Status</label>' +
                            '    <select id="statusFilter" class="form-select form-select-sm">' +
                            '      <option value="">Semua Status</option>' +
                            '    </select>' +
                            '  </div>' +
                            '  <button type="button" class="btn btn-sm btn-outline-secondary" onclick="location.reload()">' +
                            '    <i class="mdi mdi-refresh"></i> Refresh' +
                            '  </button>' +
                            '</div>'
                        );

                        $('#recentGuestsTable_filter').after(filterHtml);

                        // isi dropdown otomatis dari kolom status (index 5)
                        api.column(5).data().unique().sort().each(function (d) {
                            $('#statusFilter').append('<option value="' + d + '">' + d + '</option>');
                        });

                        // event filter status
                        $('#statusFilter').on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            api.column(5).search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                    },

                    language: {
                        search: "",
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
                // Check-in
                $(document).on('click', '.checkin-btn', function () {
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
                            error: function (xhr) {
                                console.log(xhr.responseText); // debug server
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

        <style>
            .table th {
                border-top: none;
                font-weight: 600;
                background-color: #2c3e50;
                color: white;
            }

            /* Samain ukuran tombol search dengan tinggi input */
            .dataTables_filter .input-group .btn {
                padding: 0.375rem 0.5rem;
                /* lebih kecil */
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }

            /* Iconnya biar pas */
            .dataTables_filter .input-group .btn i {
                font-size: 1rem;
                /* default text size */
                line-height: 1;
            }
        </style>
    @endpush
@endsection