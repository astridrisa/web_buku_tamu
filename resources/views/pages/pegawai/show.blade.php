@extends('layouts.app')

@section('page-title', 'Detail Tamu')
@section('page-description', 'Informasi lengkap data tamu')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Data Tamu -->
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="mdi mdi-account-details me-2"></i>
                    Informasi Tamu
                </h5>
            </div>
            <div class="card-body">
                <!-- Foto Tamu -->
                <div class="text-center mb-4">
                    <div class="tamu-photo-display">
                        @if($tamu->foto)
                            <img src="{{ asset('storage/' . $tamu->foto) }}" alt="{{ $tamu->nama }}">
                        @else
                            <div class="no-photo">
                                <i class="mdi mdi-account-circle"></i>
                            </div>
                        @endif
                    </div>
                    {{-- <h4 class="mt-3 mb-1">{{ $tamu->nama }}</h4>
                    <p class="text-muted">{{ $tamu->email }}</p> --}}
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small">Nama Lengkap</label>
                            <h6>{{ $tamu->nama }}</h6>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Email</label>
                            <h6>
                                <i class="mdi mdi-email me-1"></i>
                                {{ $tamu->email }}
                            </h6>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">No. Telepon</label>
                            <h6>
                                <i class="mdi mdi-phone me-1"></i>
                                {{ $tamu->no_telepon }}
                            </h6>
                        </div>
                        {{-- <div class="mb-3">
                            <label class="text-muted small">Instansi/Perusahaan</label>
                            <h6>{{ $tamu->instansi ?? '-' }}</h6>
                        </div> --}}
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-muted small">Jenis Identitas</label>
                            <h6>{{ $tamu->jenisIdentitas->nama ?? '-' }}</h6>
                        </div>
                        {{-- <div class="mb-3">
                            <label class="text-muted small">No. Identitas</label>
                            <h6>{{ $tamu->no_identitas }}</h6>
                        </div> --}}
                        <div class="mb-3">
                            <label class="text-muted small">Jumlah Rombongan</label>
                            <h6>
                                <i class="mdi mdi-account-multiple me-1"></i>
                                {{ $tamu->jumlah_rombongan ?? 1 }} Orang
                            </h6>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Pegawai yang Dituju</label>
                            <h6>
                                <i class="mdi mdi-account-tie me-1"></i>
                                {{ $tamu->nama_pegawai }}
                            </h6>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Status</label>
                            <h6>
                                @if($tamu->status == 'belum_checkin')
                                    <span class="badge bg-warning">Belum Check In</span>
                                @elseif($tamu->status == 'checkin')
                                    <span class="badge bg-info">Check In</span>
                                @elseif($tamu->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($tamu->status == 'checkout')
                                    <span class="badge bg-secondary">Check Out</span>
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="text-muted small">Alamat</label>
                        <p>{{ $tamu->alamat }}</p>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="text-muted small">Tujuan Kunjungan</label>
                        <p>{{ $tamu->tujuan }}</p>
                    </div>
                </div>

                <hr>

                {{-- <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Tanggal Kunjungan</label>
                        <h6>
                            <i class="mdi mdi-calendar me-1"></i>
                            {{ $tamu->tanggal_kunjungan ? \Carbon\Carbon::parse($tamu->tanggal_kunjungan)->format('d F Y') : '-' }}
                        </h6>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Jam Kunjungan</label>
                        <h6>
                            <i class="mdi mdi-clock-outline me-1"></i>
                            {{ $tamu->jam_kunjungan ?? '-' }}
                        </h6>
                    </div>
                </div> --}}
            </div>
        </div>

        <!-- Timeline Aktivitas -->
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="mdi mdi-timeline-clock text-primary me-2"></i>
                    Timeline Aktivitas
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <!-- Registrasi -->
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary">
                            <i class="mdi mdi-account-plus"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>Registrasi</strong>
                                    <p class="text-muted mb-0 small">Tamu melakukan registrasi</p>
                                </div>
                                <small class="text-muted">
                                    {{ $tamu->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Check In -->
                    @if($tamu->checkin_at)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info">
                            <i class="mdi mdi-login"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>Check In</strong>
                                    <p class="text-muted mb-0 small">
                                        Oleh: {{ $tamu->checkinBy->name ?? '-' }}
                                    </p>
                                </div>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($tamu->checkin_at)->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Approved -->
                    @if($tamu->approved_at)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success">
                            <i class="mdi mdi-check-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>Disetujui</strong>
                                    <p class="text-muted mb-0 small">
                                        Oleh: {{ $tamu->approvedBy->name ?? '-' }}
                                    </p>
                                </div>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($tamu->approved_at)->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Check Out -->
                    @if($tamu->checkout_at)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-secondary">
                            <i class="mdi mdi-logout"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>Check Out</strong>
                                    <p class="text-muted mb-0 small">
                                        Oleh: {{ $tamu->checkoutBy->name ?? '-' }}
                                    </p>
                                </div>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($tamu->checkout_at)->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- QR Code -->
        <div class="card shadow mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="mdi mdi-qrcode text-primary me-2"></i>
                    QR Code
                </h5>
            </div>
            <div class="card-body text-center">
                @if($tamu->qr_code)
                    <div id="qrcode" class="mb-3"></div>
                    <p class="text-muted small mb-2">Kode: {{ $tamu->qr_code }}</p>
                    <button class="btn btn-sm btn-primary" onclick="downloadQR()">
                        <i class="mdi mdi-download me-1"></i>
                        Download QR Code
                    </button>
                @else
                    <p class="text-muted">QR Code belum tersedia</p>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="mdi mdi-lightning-bolt text-warning me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($tamu->status == 'belum_checkin')
                        <form action="{{ route('security.checkin', $tamu->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="mdi mdi-login me-1"></i>
                                Check In
                            </button>
                        </form>
                    @endif

                    @if($tamu->status == 'checkin' && auth()->user()->role_id == 2)
                        <form action="{{ route('pegawai.tamu.approve', $tamu->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="mdi mdi-check-circle me-1"></i>
                                Setujui Kunjungan
                            </button>
                        </form>
                    @endif

                    {{-- @if(in_array($tamu->status, ['checkin', 'approved']))
                        <form action="{{ route('security.checkout', $tamu->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="mdi mdi-logout me-1"></i>
                                Check Out
                            </button>
                        </form>
                    @endif --}}

                    {{-- <a href="{{ route('security.edit', $tamu->id) }}" class="btn btn-warning">
                        <i class="mdi mdi-pencil me-1"></i>
                        Edit Data
                    </a> --}}

                    <a href="{{ route('security.list') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
@if($tamu->qr_code)
// Generate QR Code
new QRCode(document.getElementById("qrcode"), {
    text: "{{ $tamu->qr_code }}",
    width: 200,
    height: 200,
    colorDark : "#000000",
    colorLight : "#ffffff",
    correctLevel : QRCode.CorrectLevel.H
});

// Download QR Code
function downloadQR() {
    const canvas = document.querySelector('#qrcode canvas');
    const url = canvas.toDataURL('image/png');
    const link = document.createElement('a');
    link.download = 'QR-{{ $tamu->nama }}.png';
    link.href = url;
    link.click();
}
@endif
</script>
@endpush

@push('styles')
<style>
.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: none;
    border-radius: 8px;
}

.tamu-photo-display {
    width: 100%;
    max-width: 400px;
    height: 300px;
    margin: 0 auto;
    border-radius: 10px;
    overflow: hidden;
    border: 4px solid #17a2b8;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
}

.tamu-photo-display img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.tamu-photo-display .no-photo {
    font-size: 120px;
    color: #dee2e6;
}


.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
    border-left: 2px solid #e9ecef;
}

.timeline-item:last-child {
    border-left: none;
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -31px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border: 3px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-marker i {
    font-size: 14px;
}

.timeline-content {
    padding-left: 15px;
    padding-bottom: 10px;
}

#qrcode {
    display: flex;
    justify-content: center;
}
</style>
@endpush