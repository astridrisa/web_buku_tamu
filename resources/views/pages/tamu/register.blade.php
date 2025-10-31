{{-- {{ dd($jenisIdentitas) }} --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Tamu - Sistem Buku Tamu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ url('img/logopjt2.png') }}">
    
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

         /* Photo Upload Styling */
        .photo-upload-container {
            text-align: center;
            margin-bottom: 25px;
            padding: 20px;
            border: 2px dashed #e9ecef;
            border-radius: 15px;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }
        
        .photo-upload-container:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }
        
        .photo-preview {
            width: 300px;
            height: 200px;
            margin: 0 auto 15px;
            border-radius: 10px;
            overflow: hidden;
            border: 3px solid #667eea;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
        }
        
        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .photo-preview i {
            font-size: 60px;
            color: #ccc;
        }
        
        .custom-file-upload {
            display: inline-block;
            padding: 10px 20px;
            cursor: pointer;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 10px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .custom-file-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        #foto {
            display: none;
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

       /* Privacy Agreement Styling */
        .privacy-agreement {
            background: rgba(102, 126, 234, 0.05);
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .privacy-agreement.checked {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.05);
        }

        .privacy-agreement.error {
            border-color: #dc3545;
            background: rgba(220, 53, 69, 0.05);
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .privacy-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin-bottom: 15px;
            background: white;
        }

        .privacy-header:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        .privacy-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: #667eea;
            font-size: 1rem;
        }

        .privacy-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .privacy-toggle i {
            transition: transform 0.3s ease;
            font-size: 1rem;
        }

        .privacy-toggle i.rotated {
            transform: rotate(180deg);
        }

        .privacy-content {
            background: white;
            border-radius: 10px;
            padding: 0;
            margin-bottom: 15px;
            max-height: 0;
            overflow: hidden;
            font-size: 0.9rem;
            line-height: 1.6;
            color: #495057;
            transition: max-height 0.4s ease, padding 0.3s ease;
        }

        .privacy-content.show {
            max-height: 400px;
            overflow-y: auto;
            padding: 15px;
        }

        .privacy-content::-webkit-scrollbar {
            width: 8px;
        }

        .privacy-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .privacy-content::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }

        .privacy-content ul {
            padding-left: 20px;
            margin: 10px 0;
        }

        .privacy-content li {
            margin-bottom: 8px;
        }

        .privacy-checkbox-wrapper {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .privacy-checkbox-wrapper:hover {
        background: rgba(102, 126, 234, 0.05);
    }

    .privacy-checkbox-wrapper input[type="checkbox"] {
        width: 20px;
        height: 20px;
        min-width: 20px;
        cursor: pointer;
        margin-top: 3px;
        flex-shrink: 0;
        accent-color: #667eea;
    }

    .privacy-checkbox-label {
        flex: 1;
        font-size: 0.95rem;
        color: #495057;
        line-height: 1.6;
        cursor: pointer;
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
                <form id="registrationForm" method="POST" action="{{ route('tamu.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Photo Upload -->
                    <div class="photo-upload-container">
                        <div class="photo-preview" id="photoPreview">
                            <i class="fas fa-user"></i>
                        </div>
                        <label for="foto" class="custom-file-upload">
                            <i class="fas fa-camera me-2"></i>Upload Foto
                        </label>
                        <input type="file" id="foto" name="foto" accept="image/*">
                        <p class="text-muted small mt-2 mb-0">Format: JPG, PNG (Max 2MB)</p>
                    </div>
                    
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
                        <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" placeholder="Nama Pegawai yang Dituju" required>
                        <label for="nama_pegawai"><i class="fas fa-user-tie me-2"></i>Nama Pegawai yang Dituju</label>
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

                    <!-- Privacy Agreement Section -->
                    <div class="privacy-agreement" id="privacyAgreement">
                        <!-- Clickable Header -->
                        <div class="privacy-header" id="privacyHeader" style="cursor: pointer; user-select: none;">
                            <div class="privacy-title">
                                <i class="fas fa-shield-alt"></i>
                                <span>Kebijakan Privasi & Keamanan Data</span>
                            </div>
                            <div class="privacy-toggle">
                                <span id="toggleText">Baca Detail</span>
                                <i class="fas fa-chevron-down" id="toggleIcon"></i>
                            </div>
                        </div>
                        
                        <!-- Collapsible Content -->
                        <div class="privacy-content" id="privacyContent">
                            <p><strong>Dengan mendaftar, Anda menyetujui hal-hal berikut:</strong></p>
                            <ul>
                                <li><strong>Pengumpulan Data:</strong> Kami mengumpulkan data pribadi Anda (nama, alamat, nomor telepon, email, foto, dan informasi kunjungan) untuk keperluan administrasi dan keamanan.</li>
                                <li><strong>Penggunaan Data:</strong> Data Anda akan digunakan untuk:
                                    <ul>
                                        <li>Verifikasi identitas dan keamanan gedung</li>
                                        <li>Pencatatan buku tamu digital</li>
                                        <li>Komunikasi terkait kunjungan Anda</li>
                                        <li>Keperluan keamanan dan kedaruratan</li>
                                    </ul>
                                </li>
                                <li><strong>Penyimpanan Data:</strong> Data Anda akan disimpan secara aman dalam sistem kami dan hanya dapat diakses oleh petugas yang berwenang.</li>
                                <li><strong>Keamanan:</strong> Kami berkomitmen untuk menjaga keamanan data Anda dengan standar keamanan yang tinggi.</li>
                                <li><strong>Hak Anda:</strong> Anda memiliki hak untuk mengakses, memperbaiki, atau menghapus data pribadi Anda dengan menghubungi administrator sistem.</li>
                            </ul>
                            <p class="mb-0"><em>Jika Anda tidak menyetujui kebijakan ini, mohon untuk tidak melanjutkan registrasi.</em></p>
                        </div>
                        
                        <!-- Checkbox -->
                        <div class="privacy-checkbox-wrapper">
                            <input type="checkbox" id="privacyConsent" name="privacy_consent" required>
                            <label for="privacyConsent" class="privacy-checkbox-label">
                                Saya telah membaca dan <strong>menyetujui</strong> kebijakan privasi dan keamanan data di atas, serta memberikan izin untuk penggunaan data pribadi saya dalam sistem buku tamu PJT 1.
                            </label>
                        </div>
                        
                        <div class="privacy-error" id="privacyError">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Anda harus menyetujui kebijakan privasi untuk melanjutkan registrasi
                        </div>
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
    // Privacy header toggle (accordion)
        $('#privacyHeader').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const content = $('#privacyContent');
            const icon = $('#toggleIcon');
            const text = $('#toggleText');
            
            content.toggleClass('show');
            icon.toggleClass('rotated');
            
            if (content.hasClass('show')) {
                text.text('Tutup');
            } else {
                text.text('Baca Detail');
            }
        });

        // Privacy consent checkbox handler
        $('#privacyConsent').on('change', function() {
            const privacyAgreement = $('#privacyAgreement');
            const privacyError = $('#privacyError');
            
            if ($(this).is(':checked')) {
                privacyAgreement.addClass('checked').removeClass('error');
                privacyError.removeClass('show');
            } else {
                privacyAgreement.removeClass('checked');
            }
        });

        // Preview foto
        $('#foto').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validasi ukuran
                if (file.size > 2048000) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB');
                    $(this).val('');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#photoPreview').html(`<img src="${e.target.result}" alt="Preview">`);
                };
                reader.readAsDataURL(file);
            }
        });
        
        // ✅ FORM SUBMISSION - TANPA AJAX
        $('#registrationForm').on('submit', function(e) {
            // Validasi privacy consent
            if (!$('#privacyConsent').is(':checked')) {
                e.preventDefault(); // Hanya prevent jika validasi gagal
                $('#privacyAgreement').addClass('error');
                $('#privacyError').addClass('show');
                
                // Scroll ke privacy agreement
                $('html, body').animate({
                    scrollTop: $('#privacyAgreement').offset().top - 100
                }, 500);
                
                return false;
            }
            
            // Show loading state
            const submitBtn = $('.btn-submit');
            submitBtn.prop('disabled', true);
            $('.submit-text').hide();
            $('.loading').show();
            
            // Clear previous errors
            $('.form-control, .form-select').removeClass('is-invalid');
            $('#privacyAgreement').removeClass('error');
            $('#privacyError').removeClass('show');
            
            // Biarkan form submit secara normal (redirect dari controller akan bekerja)
            // TIDAK ADA e.preventDefault() di sini!
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
</script>
</body>
</html>