{{-- {{ dd($jenisIdentitas) }} --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Tamu - Sistem Buku Tamu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .registration-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .registration-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 600px;
            width: 100%;
            overflow: hidden;
        }
        
        /* Login buttons styling */
        .login-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }
        
        .btn-login {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(102, 126, 234, 0.3);
            border-radius: 10px;
            color: #667eea;
            padding: 8px 15px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .btn-login:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-login.security {
            border-color: rgba(40, 167, 69, 0.3);
            color: #28a745;
        }
        
        .btn-login.security:hover {
            background: #28a745;
            color: white;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        
        .btn-login.employee {
            border-color: rgba(255, 193, 7, 0.3);
            color: #ffc107;
        }
        
        .btn-login.employee:hover {
            background: #ffc107;
            color: #212529;
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
        }
        
        .card-header {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 30px;
            text-align: center;
            border: none;
            position: relative;
        }
        
        .card-header h2 {
            margin: 0;
            font-weight: 300;
            font-size: 2rem;
        }
        
        .card-header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        
        .logo-container {
            margin: 20px 0 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .company-logo {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 20px;
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.8);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .company-logo::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.4), 
                transparent);
            transition: left 0.6s;
        }
        
        .company-logo:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 15px 40px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }
        
        .company-logo:hover::before {
            left: 100%;
        }
        
        .company-logo img {
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.08));
            transition: all 0.3s ease;
            display: block;
        }
        
        .card-body {
            padding: 40px;
        }
        
        .form-floating {
            margin-bottom: 20px;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }
        
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-submit {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 15px;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 500;
            color: white;
            width: 100%;
            transition: transform 0.3s ease;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        .success-message {
            background: rgba(40, 167, 69, 0.1);
            border: 2px solid #28a745;
            border-radius: 15px;
            padding: 20px;
            color: #155724;
            text-align: center;
            margin-top: 20px;
        }
        
        .error-message {
            background: rgba(220, 53, 69, 0.1);
            border: 2px solid #dc3545;
            border-radius: 15px;
            padding: 20px;
            color: #721c24;
            margin-top: 20px;
        }
        
        .floating-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .position-relative .form-control {
            padding-right: 50px;
        }
        
        .loading {
            display: none;
        }
        
        .loading.show {
            display: inline-block;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .login-buttons {
                position: static;
                justify-content: center;
                margin-bottom: 20px;
                flex-wrap: wrap;
            }
            
            .btn-login {
                font-size: 0.8rem;
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Login Buttons -->
    <div class="login-buttons">
        <a href="{{ route('login') }}"class="btn-login security" onclick="loginSatpam()">
            <i class="fas fa-user-tie me-1"></i>Login
        </a>
    </div>

    <div class="registration-container">
        <div class="registration-card">
            <div class="card-header">
                <h2><i class="fas fa-user-plus"></i> Registrasi Tamu</h2>
                
                <!-- Logo Perusahaan -->
                <div class="logo-container">
                    <div class="company-logo">
                        <img src="{{ asset('img/logopjt.png') }}" alt="Logo PJT 1" width="120">
                    </div>
                </div>
                
                <p>Silakan isi data diri Anda untuk melakukan kunjungan</p>
            </div>
            
            <div class="card-body">
                <form id="registrationForm" method="POST" action="{{ route('tamu.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required>
                                <label for="nama"><i class="fas fa-user me-2"></i>Nama Lengkap</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-floating">
                        <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" style="height: 100px" required></textarea>
                        <label for="alamat"><i class="fas fa-map-marker-alt me-2"></i>Alamat</label>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" class="form-control" id="no_telepon" name="no_telepon" placeholder="Nomor Telepon" required>
                                <label for="no_telepon"><i class="fas fa-phone me-2"></i>Nomor Telepon</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="jumlah_rombongan" name="jumlah_rombongan" min="1" value="1" placeholder="Jumlah Rombongan" required>
                                <label for="jumlah_rombongan"><i class="fas fa-users me-2"></i>Jumlah Rombongan</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-floating">
                        <input type="text" class="form-control" id="tujuan" name="tujuan" placeholder="Tujuan Kunjungan" required>
                        <label for="tujuan"><i class="fas fa-bullseye me-2"></i>Tujuan Kunjungan</label>
                    </div>
                    
                    <div class="form-floating">
                        <select class="form-select" id="jenis_identitas_id" name="jenis_identitas_id" required>
                            <option value="">Pilih Jenis Identitas</option>
                            @foreach($jenisIdentitas as $identitas)
                                <option value="{{ $identitas->id }}">{{ $identitas->nama }}</option>
                            @endforeach
                        </select>
                        <label for="jenis_identitas_id"><i class="fas fa-id-card me-2"></i>Jenis Identitas</label>
                    </div>
                    
                    <button type="submit" class="btn btn-submit">
                        <span class="submit-text">
                            <i class="fas fa-paper-plane me-2"></i>Daftar Sekarang
                        </span>
                        <span class="loading">
                            <i class="fas fa-spinner fa-spin me-2"></i>Mendaftar...
                        </span>
                    </button>
                </form>
                
                <div id="successMessage" class="success-message" style="display: none;">
                    <h5><i class="fas fa-check-circle me-2"></i>Registrasi Berhasil!</h5>
                    <p class="mb-0">Data Anda telah tersimpan. Silakan tunjukkan identitas Anda ke petugas security untuk melakukan check-in.</p>
                </div>
                
                <div id="errorMessage" class="error-message" style="display: none;"></div>
            </div>

            <div class="text-center mt-4 mb-2">
                Sistem Buku Tamu &copy; PJT 1. Made By Intern Polinema 2025
                <div class="mt-2">
                <a href="https://jasatirta1.co.id/">Perusahaan Umum Jasa Tirta 1</a>
                {{-- <a href="#">Terms of Service</a> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // CSRF Token setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $('#registrationForm').on('submit', function(e) {
                e.preventDefault();
                
                // Show loading state
                const submitBtn = $('.btn-submit');
                const submitText = $('.submit-text');
                const loadingText = $('.loading');
                
                submitBtn.prop('disabled', true);
                submitText.hide();
                loadingText.show();
                
                // Hide previous messages
                $('#successMessage, #errorMessage').hide();
                $('.form-control, .form-select').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                
                // Submit form
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#successMessage').fadeIn();
                            $('#registrationForm')[0].reset();
                            
                            // Auto reset form after 5 seconds
                            setTimeout(function() {
                                $('#successMessage').fadeOut();
                            }, 10000);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Terjadi kesalahan saat mendaftar.';
                        
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorHtml = '<h6><i class="fas fa-exclamation-triangle me-2"></i>Kesalahan Validasi:</h6><ul class="mb-0">';
                            
                            $.each(errors, function(field, messages) {
                                // Add error class to field
                                $(`#${field}`).addClass('is-invalid');
                                
                                // Add error messages
                                messages.forEach(function(message) {
                                    errorHtml += `<li>${message}</li>`;
                                });
                            });
                            
                            errorHtml += '</ul>';
                            errorMessage = errorHtml;
                        }
                        
                        $('#errorMessage').html(errorMessage).fadeIn();
                    },
                    complete: function() {
                        // Reset button state
                        submitBtn.prop('disabled', false);
                        loadingText.hide();
                        submitText.show();
                    }
                });
            });
            
            // Remove error styling on input change
            $('.form-control, .form-select').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').remove();
            });
            
            // Format phone number
            $('#no_telepon').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length > 0) {
                    if (value.startsWith('8')) {
                        value = '0' + value;
                    }
                    $(this).val(value);
                }
            });
        });
        
        // // Login functions (untuk sementara menggunakan alert, nanti bisa dihubungkan ke halaman login)
        // function loginSatpam() {
        //     alert('Login Satpam - Akan diarahkan ke halaman login satpam');
        //     // Nanti bisa diganti dengan: window.location.href = '/satpam/login';
        // }
        
        // function loginPegawai() {
        //     alert('Login Pegawai - Akan diarahkan ke halaman login pegawai');
        //     // Nanti bisa diganti dengan: window.location.href = '/pegawai/login';
        // }
    </script>
</body>
</html>