<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil - Sistem Buku Tamu</title>
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

        .success-container {
            max-width: 700px;
            width: 100%;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .success-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .success-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .success-icon {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: scaleIn 0.5s ease-out 0.2s backwards;
            position: relative;
            z-index: 1;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        .success-icon i {
            font-size: 60px;
            color: #28a745;
            animation: checkmark 0.6s ease-out 0.4s backwards;
        }

        @keyframes checkmark {
            0% {
                transform: scale(0) rotate(-45deg);
            }
            50% {
                transform: scale(1.2) rotate(0deg);
            }
            100% {
                transform: scale(1) rotate(0deg);
            }
        }

        .success-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .success-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            position: relative;
            z-index: 1;
            margin: 0;
        }

        .success-body {
            padding: 50px 40px;
        }

        .info-box {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .info-box h3 {
            color: #667eea;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-item {
            display: flex;
            align-items: start;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item i {
            color: #667eea;
            font-size: 1.3rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .info-item-content h4 {
            color: #495057;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item-content p {
            color: #212529;
            font-size: 1.1rem;
            margin: 0;
            font-weight: 500;
        }

        .next-steps {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 152, 0, 0.1));
            border: 2px solid rgba(255, 193, 7, 0.3);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .next-steps h3 {
            color: #ff9800;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .step-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .step-list li {
            display: flex;
            align-items: start;
            gap: 15px;
            padding: 15px 0;
        }

        .step-number {
            flex-shrink: 0;
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #ff9800, #ff6f00);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
        }

        .step-list li p {
            margin: 0;
            color: #495057;
            font-size: 1rem;
            line-height: 1.6;
            padding-top: 5px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 15px 35px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .btn-primary-action {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .btn-secondary-action {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-secondary-action:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .success-footer {
            background: #f8f9fa;
            padding: 25px;
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .success-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .success-footer a:hover {
            text-decoration: underline;
        }

        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background: #667eea;
            position: absolute;
            animation: confetti-fall 3s linear infinite;
        }

        @keyframes confetti-fall {
            to {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        @media (max-width: 768px) {
            .success-header {
                padding: 40px 25px;
            }

            .success-header h1 {
                font-size: 1.8rem;
            }

            .success-body {
                padding: 40px 25px;
            }

            .info-box, .next-steps {
                padding: 25px 20px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-card">
            <!-- Header -->
            <div class="success-header">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1>Registrasi Berhasil!</h1>
                <p>Selamat! Data Anda telah berhasil tersimpan dalam sistem kami</p>
            </div>

            <!-- Body -->
            <div class="success-body">
                <!-- Informasi Tamu -->
                <div class="info-box">
                    <h3>
                        <i class="fas fa-user-circle"></i>
                        Informasi Registrasi Anda
                    </h3>
                    <div class="info-item">
                        <i class="fas fa-user"></i>
                        <div class="info-item-content">
                            <h4>Nama Lengkap</h4>
                            <p>{{ $tamu->nama }}</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div class="info-item-content">
                            <h4>Email</h4>
                            <p>{{ $tamu->email }}</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div class="info-item-content">
                            <h4>Nomor Telepon</h4>
                            <p>{{ $tamu->no_telepon }}</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-bullseye"></i>
                        <div class="info-item-content">
                            <h4>Tujuan Kunjungan</h4>
                            <p>{{ $tamu->tujuan }}</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-user-tie"></i>
                        <div class="info-item-content">
                            <h4>Pegawai yang Dituju</h4>
                            <p>{{ $tamu->nama_pegawai }}</p>
                        </div>
                    </div>
                </div>

                <!-- Langkah Selanjutnya -->
                <div class="next-steps">
                    <h3>
                        <i class="fas fa-clipboard-list"></i>
                        Langkah Selanjutnya
                    </h3>
                    <ul class="step-list">
                        <li>
                            <div class="step-number">1</div>
                            <p><strong>Datang ke Lokasi:</strong> Silakan menuju ke lokasi Perusahaan Umum Jasa Tirta 1 sesuai jadwal kunjungan Anda.</p>
                        </li>
                        <li>
                            <div class="step-number">2</div>
                            <p><strong>Tunjukkan Identitas:</strong> Tunjukkan identitas asli Anda (KTP/SIM/Paspor) kepada petugas security di pintu masuk.</p>
                        </li>
                        <li>
                            <div class="step-number">3</div>
                            <p><strong>Check-in:</strong> Petugas security akan memverifikasi data Anda dan melakukan proses check-in di sistem.</p>
                        </li>
                        <li>
                            <div class="step-number">4</div>
                            <p><strong>Terima Email:</strong> Anda akan menerima email secara otomatis ketika security sudah memverivikasi dan update check-in anda di sistem.</p>
                        </li>
                        <li>
                            <div class="step-number">5</div>
                            <p><strong>Mulai Kunjungan:</strong> Setelah check-in berhasil, Anda dapat melanjutkan kunjungan sesuai dengan tujuan yang telah Anda daftarkan.</p>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('tamu.tutorial') }}" class="btn-action btn-primary-action">
                        <i class="fas fa-home"></i>
                        <span>Kembali ke Beranda</span>
                    </a>
                    <a href="{{ route('tamu.index') }}" class="btn-action btn-secondary-action">
                        <i class="fas fa-user-plus"></i>
                        <span>Daftar Tamu Lain</span>
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="success-footer">
                <p class="mb-2">Sistem Buku Tamu &copy; PJT 1. Made By Intern Polinema 2025</p>
                <a href="https://jasatirta1.co.id/" target="_blank">Perusahaan Umum Jasa Tirta 1</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>