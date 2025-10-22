@extends('layouts.app')

@section('page-title', 'Tambah User Baru')
@section('page-description', 'Tambahkan pengguna baru ke sistem')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="mdi mdi-account-plus me-2"></i>
                        Form Tambah User
                    </h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm">
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

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Nama Lengkap -->
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="pmdi mdi-account"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Masukkan nama lengkap"
                                       required>
                            </div>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kode Pegawai -->
                        <div class="col-md-6 mb-3">
                            <label for="kopeg" class="form-label">
                                Kode Pegawai <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="mdi mdi-badge-account"></i>
                                </span>
                                <input type="text" class="form-control @error('kopeg') is-invalid @enderror"
                                        id="kopeg" name="kopeg" value="{{ old('kopeg') }}"
                                        placeholder="Contoh: PEGAWAI1" required>
                            </div>
                            @error('kopeg')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kode unik untuk identifikasi pegawai</small>
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
                                       value="{{ old('email') }}" 
                                       placeholder="contoh@email.com"
                                       required>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No. Telepon -->
                        <div class="col-md-12 mb-3">
                            <label for="phone" class="form-label">
                                No. Telepon
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="mdi mdi-phone"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}" 
                                       placeholder="08xxxxxxxxxx">
                            </div>
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="col-md-6 mb-3">
                            <label for="role_id" class="form-label">
                                Role <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('role_id') is-invalid @enderror" 
                                    id="role_id" 
                                    name="role_id" 
                                    required>
                                <option value="">-- Pilih Role --</option>
                                @foreach($roles as $role)
                                    @if($role->id != 1)
                                        <option value="{{ $role->id }}" 
                                                {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ ucfirst($role->nama_role) }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                    Nonaktif
                                </option>
                            </select>
                            @error('status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="mdi mdi-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Minimal 5 karakter"
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="togglePassword('password')">
                                    <i class="mdi mdi-eye" id="password-icon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">
                                Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="mdi mdi-lock-check"></i>
                                </span>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Ulangi password"
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="togglePassword('password_confirmation')">
                                    <i class="mdi mdi-eye" id="password_confirmation-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.list') }}" class="btn btn-secondary">
                            <i class="mdi mdi-close me-1"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save me-1"></i>
                            Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card mt-4">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="mdi mdi-information text-info me-2"></i>
                    Informasi
                </h6>
                <ul class="mb-0">
                    <li>Pastikan email yang digunakan valid dan belum terdaftar</li>
                    <li>Password minimal 5 karakter</li>
                    <li>Role akan menentukan akses pengguna di sistem</li>
                    <li>Status dapat diubah kapan saja setelah user dibuat</li>
                </ul>
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

        .photo-preview-container {
            display: inline-block;
        }

        .photo-preview {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-preview i {
            font-size: 80px;
            color: #dee2e6;
        }

        .input-group-text {
            background-color: #f8f9fa;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
            // Preview foto
            $('#profile_photo').on('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    // Validasi ukuran
                    if (file.size > 2048000) {
                        alert('Ukuran file terlalu besar. Maksimal 2MB');
                        $(this).val('');
                        return;
                    }

                    // Validasi tipe file
                    if (!file.type.match('image.*')) {
                        alert('File harus berupa gambar');
                        $(this).val('');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#photoPreview').html(`<img src="${e.target.result}" alt="Preview">`);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Format nomor telepon
            $('#phone').on('input', function () {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length > 0 && value.startsWith('8')) {
                    value = '0' + value;
                }
                $(this).val(value);
            });

            // Toggle password visibility
            $('#togglePassword').on('click', function () {
                const passwordField = $('#password');
                const icon = $(this).find('i');
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('mdi-eye').addClass('mdi-eye-off');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('mdi-eye-off').addClass('mdi-eye');
                }
            });

            $('#togglePasswordConfirm').on('click', function () {
                const passwordField = $('#password_confirmation');
                const icon = $(this).find('i');
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('mdi-eye').addClass('mdi-eye-off');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('mdi-eye-off').addClass('mdi-eye');
                }
            });

            // Uppercase kode pegawai
            $('#kopeg').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });
        });
    </script>
@endpush