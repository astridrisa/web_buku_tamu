<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Buku Tamu</title>

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
            max-width: 450px;
            width: 100%;
        }
        
        .login-header {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        
        .login-header h2 {
            margin: 0;
            font-weight: 300;
            font-size: 2rem;
        }
        
        .login-header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        
        .login-body {
            padding: 40px 30px;
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
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(45deg, #667eea, #764ba2);
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
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        
        .login-links a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .login-links a:hover {
            color: #764ba2;
        }
        
        .role-indicator {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .demo-credentials {
            background: rgba(13, 202, 240, 0.1);
            border: 1px solid #0dcaf0;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .demo-credentials h6 {
            color: #0dcaf0;
            margin-bottom: 10px;
        }
        
        .demo-item {
            margin-bottom: 8px;
        }
        
        .demo-item strong {
            color: #495057;
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
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2><i class="fas fa-user-shield"></i> Login</h2>

             <div class="logo-container">
                    <div class="company-logo">
                        <img src="{{ asset('img/logopjt.png') }}" alt="Logo PJT 1" width="120">
                    </div>
                </div>

            <p>Silakan login untuk melanjutkan</p>
        </div>
        
        <div class="login-body">
            {{-- <!-- Demo Credentials Info -->
            <div class="demo-credentials">
                <h6><i class="fas fa-info-circle me-2"></i>Demo Akun:</h6>
                <div class="demo-item">
                    <strong>Security:</strong> security@example.com
                </div>
                <div class="demo-item">
                    <strong>Pegawai:</strong> pegawai@example.com
                </div>
                <div class="demo-item">
                    <strong>Password:</strong> password
                </div>
            </div> --}}
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                
                <div class="form-floating">
                    <input type="text" class="form-control @error('kopeg') is-invalid @enderror" 
                           id="kopeg" name="kopeg" placeholder="kopeg" value="{{ old('kopeg') }}" required autofocus>
                    <label for="kopeg">
                        <i class="fas fa-envelope me-2"></i>Username
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
                    Masuk
                </button>
            </form>
            
            <div class="login-links">
                <a href="{{ route('tamu.index') }}">
                    <i class="fas fa-user-plus me-1"></i>
                    Registrasi Tamu
                </a>
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
            
            // Auto-fill demo credentials
            $('.demo-item').click(function() {
                const text = $(this).text();
                if (text.includes('security@example.com')) {
                    $('#kopeg').val('security@example.com');
                    $('#password').val('password');
                } else if (text.includes('pegawai@example.com')) {
                    $('#kopeg').val('pegawai@example.com');
                    $('#password').val('password');
                }
            });
            
            // Form validation
            $('form').on('submit', function(e) {
                const kopeg = $('#kopeg').val();
                const password = $('#password').val();
                
                if (!kopeg || !password) {
                    e.preventDefault();
                    alert('Email dan password harus diisi!');
                }
            });
        });
    </script>
</body>
</html>