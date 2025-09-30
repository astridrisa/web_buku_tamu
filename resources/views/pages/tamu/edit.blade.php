@extends('layouts.app')

@section('page-title', 'Edit Tamu')
@section('page-description', 'Perbarui informasi data tamu')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="mdi mdi-pencil me-2"></i>
                        Form Edit Tamu
                    </h5>
                    <a href="{{ route('security.index') }}" class="btn btn-light btn-sm">
                        <i class="mdi mdi-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi Kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('security.update', $tamu->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Nama Lengkap -->
                        <div class="col-md-12 mb-3">
                            <label for="nama" class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="mdi mdi-account"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" 
                                       name="nama" 
                                       value="{{ old('nama', $tamu->nama) }}" 
                                       placeholder="Masukkan nama lengkap"
                                       required>
                            </div>
                            @error('nama')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="mdi mdi-email"></i>
                                </span>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $tamu->email) }}" 
                                       placeholder="contoh@email.com"
                                       required>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No. Telepon -->
                        <div class="col-md-12 mb-3">
                            <label for="no_telepon" class="form-label">
                                No. Telepon <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="mdi mdi-phone"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('no_telepon') is-invalid @enderror" 
                                       id="no_telepon" 
                                       name="no_telepon" 
                                       value="{{ old('no_telepon', $tamu->no_telepon) }}" 
                                       placeholder="08xxxxxxxxxx"
                                       required>
                            </div>
                            @error('no_telepon')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Identitas -->
                       <div class="col-md-6 mb-3">
                            <label for="jenis_identitas_id" class="form-label">
                                Jenis Identitas <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('jenis_identitas_id') is-invalid @enderror" 
                                    id="jenis_identitas_id" 
                                    name="jenis_identitas_id" 
                                    required>
                                <option value="">-- Pilih Jenis Identitas --</option>
                                @foreach($jenisIdentitas as $jenis)
                                    <option value="{{ $jenis->id }}" 
                                        {{ old('jenis_identitas_id', $tamu->jenis_identitas_id) == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_identitas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- No. Identitas -->
                        {{-- <div class="col-md-6 mb-3">
                            <label for="no_identitas" class="form-label">
                                No. Identitas <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="mdi mdi-card-account-details"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('no_identitas') is-invalid @enderror" 
                                       id="no_identitas" 
                                       name="no_identitas" 
                                       value="{{ old('no_identitas', $tamu->no_identitas) }}" 
                                       placeholder="Masukkan nomor identitas"
                                       required>
                            </div>
                            @error('no_identitas')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <!-- Alamat -->
                        <div class="col-md-12 mb-3">
                            <label for="alamat" class="form-label">
                                Alamat <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" 
                                      name="alamat" 
                                      rows="3" 
                                      placeholder="Masukkan alamat lengkap"
                                      required>{{ old('alamat', $tamu->alamat) }}</textarea>
                            @error('alamat')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tujuan Kunjungan -->
                        <div class="col-md-12 mb-3">
                            <label for="tujuan" class="form-label">
                                Tujuan Kunjungan <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('tujuan') is-invalid @enderror" 
                                      id="tujuan" 
                                      name="tujuan" 
                                      rows="3" 
                                      placeholder="Jelaskan tujuan kunjungan Anda"
                                      required>{{ old('tujuan', $tamu->tujuan) }}</textarea>
                            @error('tujuan')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Kunjungan -->
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_kunjungan" class="form-label">
                                Tanggal Kunjungan
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="mdi mdi-calendar"></i>
                                </span>
                                <input type="date" 
                                       class="form-control @error('tanggal_kunjungan') is-invalid @enderror" 
                                       id="tanggal_kunjungan" 
                                       name="tanggal_kunjungan" 
                                       value="{{ old('tanggal_kunjungan', $tamu->tanggal_kunjungan) }}">
                            </div>
                            @error('tanggal_kunjungan')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jam Kunjungan -->
                        <div class="col-md-6 mb-3">
                            <label for="jam_kunjungan" class="form-label">
                                Jam Kunjungan
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="mdi mdi-clock-outline"></i>
                                </span>
                                <input type="time" 
                                       class="form-control @error('jam_kunjungan') is-invalid @enderror" 
                                       id="jam_kunjungan" 
                                       name="jam_kunjungan" 
                                       value="{{ old('jam_kunjungan', $tamu->jam_kunjungan) }}">
                            </div>
                            @error('jam_kunjungan')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Rombongan -->
                        <div class="col-md-12 mb-3">
                            <label for="jumlah_rombongan" class="form-label">
                                Jumlah Rombongan
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="mdi mdi-account-multiple"></i>
                                </span>
                                <input type="number" 
                                       class="form-control @error('jumlah_rombongan') is-invalid @enderror" 
                                       id="jumlah_rombongan" 
                                       name="jumlah_rombongan" 
                                       value="{{ old('jumlah_rombongan', $tamu->jumlah_rombongan ?? 1) }}" 
                                       min="1"
                                       placeholder="Kosongkan jika hanya 1 orang">
                            </div>
                            @error('jumlah_rombongan')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Default: 1 orang</small>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tamu.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-close me-1"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="mdi mdi-content-save me-1"></i>
                            Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tamu Info -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="mdi mdi-clock-outline text-muted me-2"></i>
                    Informasi Data
                </h6>
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">Terdaftar pada:</small>
                        <p class="mb-0">{{ $tamu->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Terakhir diupdate:</small>
                        <p class="mb-0">{{ $tamu->updated_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: none;
}

.input-group-text {
    background-color: #f8f9fa;
}

.form-label {
    font-weight: 500;
    color: #495057;
}

.text-danger {
    font-weight: 600;
}
</style>
@endpush