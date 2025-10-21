<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Approval - Sistem Buku Tamu</title>

    <link rel="icon" type="image/png" href="{{ url('img/logopjt2.png') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            max-width: 550px;
            width: 100%;
        }
        
        .login-header {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .login-header h2 {
            margin: 0;
            font-weight: 300;
            font-size: 1.8rem;
        }
        
        .login-header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }
        
        .login-body {
            padding: 30px;
        }

        .tamu-info-box {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: 2px solid #2196f3;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.15);
        }

        .tamu-info-box h5 {
            color: #1976d2;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(33, 150, 243, 0.2);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #455a64;
        }

        .info-value {
            color: #263238;
            text-align: right;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .form-floating {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            border-radius: 15px;
            padding: 15px;
            font-size: 1.1rem;
            font-weight: 500;
            color: white;
            width: 100%;
            transition: transform 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        .alert {
            border-radius: 15px;
            border: none;
            margin-bottom: 20px;
        }
        
        .login-links {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        
        .login-links a {
            color: #28a745;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .login-links a:hover {
            color: #20c997;
        }
        
        .role-indicator {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .logo-container {
            margin: 15px 0 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .company-logo {
            background: rgba(255, 255, 255, 0.95);
            padding: 15px;
            border-radius: 15px;
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.8);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        
        .company-logo:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }
        
        .company-logo img {
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.08));
            display: block;
        }

        .qr-indicator {
            background: linear-gradient(45deg, #ffc107, #ff9800);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2><i class="fas fa-user-check"></i> Login untuk Approval</h2>

            <div class="logo-container">
                <div class="company-logo">
                    <img src="{{ asset('img/logopjt.png') }}" alt="Logo PJT 1" width="100">
                </div>
            </div>

            <p>Silakan login untuk menyetujui tamu</p>
        </div>
        
        <div class="login-body">
            <!-- QR Scan Indicator -->
            <div class="qr-indicator">
                <i class="fas fa-qrcode me-2"></i>
                Login melalui QR Code Scan
            </div>

            <!-- Info Tamu -->
            <div class="tamu-info-box">
                <h5><i class="fas fa-user me-2"></i>Detail Tamu</h5>
                <div class="info-row">
                    <span class="info-label">Nama:</span>
                    <span class="info-value">{{ $tamu->nama }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $tamu->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tujuan:</span>
                    <span class="info-value">{{ Str::limit($tamu->tujuan, 30) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge bg-warning text-dark">
                            {{ ucfirst($tamu->status) }}
                        </span>
                    </span>
                </div>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ $errors->first('login') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login.qr.post', $tamu->id) }}">
                @csrf
                
                <div class="form-floating">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                    <label for="email">
                        <i class="fas fa-envelope me-2"></i>Email
                    </label>
                    <div class="role-indicator">
                        <i class="fas fa-at"></i>
                    </div>
                </div>
                
                <div class="form-floating">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" placeholder="Password" required>
                    <label for="password">
                        <i class="fas fa-lock me-2"></i>Password
                    </label>
                    <div class="role-indicator">
                        <i class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                    </div>
                </div>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Ingat saya
                    </label>
                </div>
                
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Login & Approve Tamu
                </button>
            </form>
            
            <div class="login-links">
                <a href="{{ route('tamu.index') }}">
                    <i class="fas fa-arrow-left me-1"></i>
                    Kembali ke Beranda
                </a>
            </div>

            <div class="text-center mt-4 mb-2" style="font-size: 0.85rem; color: #6c757d;">
                Sistem Buku Tamu &copy; PJT 1. Made By Intern Polinema 2025
                <div class="mt-2">
                    <a href="https://jasatirta1.co.id/" style="color: #667eea; text-decoration: none;">
                        Perusahaan Umum Jasa Tirta 1
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $('#togglePassword').click(function() {
                const passwordField = $('#password');
                const icon = $(this);
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
</body>
</html>