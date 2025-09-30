@extends('layouts.app')

@section('page-title', 'Tambah Tamu')
@section('page-description', 'Form pendaftaran tamu baru')

@section('content')
<div class="row">
     <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="mdi mdi-account-plus me-2"></i>
                        Form Tambah Tamu
                    </h5>
                    <a href="{{ route('security.list') }}" class="btn btn-light btn-sm">
                        <i class="mdi mdi-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                <form action="{{ route('security.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <!-- Nama -->
                        <div class="col-md-12 mb-3">
                            <label for="nama" class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" 
                                   name="nama" 
                                   value="{{ old('nama') }}" 
                                   placeholder="Masukkan nama lengkap"
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="contoh@email.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No Telepon -->
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon" class="form-label">
                                No. Telepon <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('no_telepon') is-invalid @enderror" 
                                   id="no_telepon" 
                                   name="no_telepon" 
                                   value="{{ old('no_telepon') }}" 
                                   placeholder="08xxxxxxxxxx"
                                   required>
                            @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jenis Identitas -->
                        <div class="col-md-12 mb-3">
                            <label for="jenis_identitas_id" class="form-label">
                                Jenis Identitas <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('jenis_identitas_id') is-invalid @enderror" 
                                    id="jenis_identitas_id" 
                                    name="jenis_identitas_id" 
                                    required>
                                <option value="">Pilih Jenis Identitas</option>
                                @foreach($jenisIdentitas as $identitas)
                                    <option value="{{ $identitas->id }}">{{ $identitas->nama }}</option>
                                @endforeach
                            </select>
                            @error('jenis_identitas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
                                      required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tujuan -->
                        <div class="col-md-12 mb-3">
                            <label for="tujuan" class="form-label">
                                Tujuan Kunjungan <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('tujuan') is-invalid @enderror" 
                                      id="tujuan" 
                                      name="tujuan" 
                                      rows="3" 
                                      required>{{ old('tujuan') }}</textarea>
                            @error('tujuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Kunjungan -->
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_kunjungan" class="form-label">
                                Tanggal Kunjungan
                            </label>
                            <input type="date" 
                                   class="form-control @error('tanggal_kunjungan') is-invalid @enderror" 
                                   id="tanggal_kunjungan" 
                                   name="tanggal_kunjungan" 
                                   value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}">
                            @error('tanggal_kunjungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jam Kunjungan -->
                        <div class="col-md-6 mb-3">
                            <label for="jam_kunjungan" class="form-label">
                                Jam Kunjungan
                            </label>
                            <input type="time" 
                                   class="form-control @error('jam_kunjungan') is-invalid @enderror" 
                                   id="jam_kunjungan" 
                                   name="jam_kunjungan" 
                                   value="{{ old('jam_kunjungan', date('H:i')) }}">
                            @error('jam_kunjungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Rombongan -->
                        <div class="col-md-12 mb-3">
                            <label for="jumlah_rombongan" class="form-label">
                                Jumlah Rombongan
                            </label>
                            <input type="number" 
                                   class="form-control @error('jumlah_rombongan') is-invalid @enderror" 
                                   id="jumlah_rombongan" 
                                   name="jumlah_rombongan" 
                                   value="{{ old('jumlah_rombongan', 1) }}" 
                                   min="1">
                            @error('jumlah_rombongan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('security.list') }}" class="btn btn-secondary">
                            <i class="mdi mdi-close me-1"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save me-1"></i>
                            Simpan Data
                        </button>
                    </div>
                </form>
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
    border-radius: 8px;
}
</style>
@endpush