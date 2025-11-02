<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Registrasi Tamu - PJT 1</title>
    <link rel="icon" type="image/png" href="{{ url('img/logopjt2.png') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Login Button */
        .login-button {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .btn-login {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(102, 126, 234, 0.3);
            border-radius: 10px;
            color: #667eea;
            padding: 10px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        /* Container */
        .tutorial-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .tutorial-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            max-width: 1100px;
            width: 100%;
            overflow: hidden;
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

        /* Header */
        .tutorial-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .tutorial-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .tutorial-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .logo-container {
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }

        .company-logo {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 20px;
            display: inline-block;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .company-logo:hover {
            transform: scale(1.05);
        }

        .company-logo img {
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.1));
        }

        .tutorial-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .tutorial-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        /* Body */
        .tutorial-body {
            padding: 50px 40px;
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 50px;
        }

        .welcome-section h2 {
            color: #667eea;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .welcome-section p {
            color: #6c757d;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        /* Steps */
        .steps-container {
            margin: 40px 0;
        }

        .step-item {
            display: flex;
            gap: 25px;
            margin-bottom: 35px;
            padding: 25px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            border-radius: 20px;
            border: 2px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
            animation: fadeIn 0.6s ease-out backwards;
        }

        .step-item:nth-child(1) { animation-delay: 0.1s; }
        .step-item:nth-child(2) { animation-delay: 0.2s; }
        .step-item:nth-child(3) { animation-delay: 0.3s; }
        .step-item:nth-child(4) { animation-delay: 0.4s; }
        .step-item:nth-child(5) { animation-delay: 0.5s; }
        .step-item:nth-child(6) { animation-delay: 0.6s; }
        .step-item:nth-child(7) { animation-delay: 0.7s; }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .step-item:hover {
            transform: translateX(10px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.15);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .step-number {
            flex-shrink: 0;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .step-content h3 {
            color: #667eea;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .step-content p {
            color: #6c757d;
            font-size: 1rem;
            line-height: 1.6;
            margin: 0;
        }

        .step-content .icon {
            color: #764ba2;
            margin-right: 8px;
        }

        .step-badge {
            display: inline-block;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .step-badge.security {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .step-badge.pegawai {
            background: linear-gradient(135deg, #ffc107, #ff9800);
        }

        /* Important Notes */
        .important-notes {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 152, 0, 0.1));
            border: 2px solid rgba(255, 193, 7, 0.3);
            border-radius: 20px;
            padding: 30px;
            margin: 40px 0;
        }

        .important-notes h3 {
            color: #ff9800;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .important-notes ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .important-notes li {
            padding: 12px 0;
            color: #495057;
            font-size: 1rem;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .important-notes li i {
            color: #ff9800;
            font-size: 1.2rem;
            margin-top: 2px;
        }

        /* Flow Diagram */
        .flow-section {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.05), rgba(32, 201, 151, 0.05));
            border: 2px solid rgba(40, 167, 69, 0.2);
            border-radius: 20px;
            padding: 30px;
            margin: 40px 0;
        }

        .flow-section h3 {
            color: #28a745;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .flow-timeline {
            position: relative;
            padding-left: 40px;
        }

        .flow-timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 10px;
            bottom: 10px;
            width: 3px;
            background: linear-gradient(180deg, #667eea, #764ba2);
            border-radius: 10px;
        }

        .flow-step {
            position: relative;
            padding: 15px 0;
            margin-bottom: 20px;
        }

        .flow-step::before {
            content: '';
            position: absolute;
            left: -32px;
            top: 20px;
            width: 15px;
            height: 15px;
            background: white;
            border: 3px solid #667eea;
            border-radius: 50%;
            z-index: 1;
        }

        .flow-step h4 {
            color: #495057;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .flow-step p {
            color: #6c757d;
            font-size: 0.95rem;
            margin: 0;
            line-height: 1.6;
        }

        /* Action Button */
        .action-section {
            text-align: center;
            margin-top: 50px;
            padding-top: 40px;
            border-top: 2px solid rgba(102, 126, 234, 0.1);
        }

        .btn-start {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 18px 60px;
            font-size: 1.2rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .btn-start:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-start i {
            font-size: 1.3rem;
        }

        /* Footer */
        .tutorial-footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .tutorial-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .tutorial-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .tutorial-header {
                padding: 40px 25px;
            }

            .tutorial-header h1 {
                font-size: 1.8rem;
            }

            .tutorial-body {
                padding: 40px 25px;
            }

            .step-item {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .step-number {
                margin: 0 auto;
            }

            .welcome-section h2 {
                font-size: 1.6rem;
            }

            .btn-start {
                padding: 15px 40px;
                font-size: 1.1rem;
            }

            .login-button {
                top: 15px;
                right: 15px;
            }

            .btn-login {
                padding: 8px 15px;
                font-size: 0.85rem;
            }

            .flow-timeline {
                padding-left: 35px;
            }
        }
    </style>
</head>
<body>
    <!-- Login Button -->
    <div class="login-button">
        <a href="{{ route('login') }}" class="btn-login">
            <i class="fas fa-sign-in-alt"></i>
            <span>Login</span>
        </a>
    </div>

    <div class="tutorial-container">
        <div class="tutorial-card">
            <!-- Header -->
            <div class="tutorial-header">
                <div class="logo-container">
                    <div class="company-logo">
                        <img src="{{ asset('img/logopjt.png') }}" alt="Logo PJT 1" width="120">
                    </div>
                </div>
                <h1><i class="fas fa-book-open me-2"></i>Panduan Registrasi Tamu</h1>
                <p>Selamat datang di Sistem Buku Tamu Digital PJT 1</p>
            </div>

            <!-- Body -->
            <div class="tutorial-body">
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <h2>Selamat Datang! 👋</h2>
                    <p>Terima kasih telah berkunjung ke Perusahaan Umum Jasa Tirta 1.<br>
                    Silakan ikuti panduan lengkap berikut untuk melakukan kunjungan Anda.</p>
                </div>

                <!-- Steps -->
                <div class="steps-container">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h3><i class="fas fa-user-edit icon"></i>Registrasi Online</h3>
                            <p>Lengkapi formulir registrasi dengan data diri Anda yang akurat, termasuk nama lengkap, alamat, nomor telepon, email, tujuan kunjungan, dan nama pegawai yang akan Anda temui.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h3><i class="fas fa-camera icon"></i>Upload Foto & Setujui Kebijakan</h3>
                            <p>Unggah foto diri Anda (opsional) dan baca serta setujui kebijakan privasi & keamanan data. Data Anda akan dijaga kerahasiaannya sesuai standar keamanan yang berlaku.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h3>
                                <i class="fas fa-shield-alt icon"></i>Check-in di Security
                                <span class="step-badge security">Security</span>
                            </h3>
                            <p>Datang ke lokasi dan tunjukkan identitas asli Anda (KTP/SIM/Paspor) kepada petugas security. Petugas akan melakukan verifikasi dan check-in di sistem.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h3>
                                <i class="fas fa-envelope icon"></i>Terima Email QR Code
                                <span class="step-badge">Otomatis</span>
                            </h3>
                            <p>Setelah check-in berhasil, Anda akan menerima email yang berisi <strong>QR Code unik</strong>. QR Code ini wajib ditunjukkan kepada pegawai yang Anda tuju untuk mendapatkan persetujuan kunjungan.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">5</div>
                        <div class="step-content">
                            <h3>
                                <i class="fas fa-user-check icon"></i>Approval dari Pegawai
                                <span class="step-badge pegawai">Pegawai</span>
                            </h3>
                            <p>Tunjukkan QR Code dari email kepada pegawai yang Anda temui. Pegawai akan melakukan scan dan menyetujui kunjungan Anda di sistem. Setelah disetujui, Anda dapat memulai kunjungan.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">6</div>
                        <div class="step-content">
                            <h3><i class="fas fa-handshake icon"></i>Lakukan Kunjungan</h3>
                            <p>Setelah mendapat persetujuan, Anda dapat melakukan kunjungan sesuai dengan tujuan yang telah Anda daftarkan. Pastikan mematuhi peraturan dan protokol yang berlaku di area PJT 1.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-number">7</div>
                        <div class="step-content">
                            <h3>
                                <i class="fas fa-sign-out-alt icon"></i>Check-out di Security
                                <span class="step-badge security">Security</span>
                            </h3>
                            <p>Setelah selesai berkunjung, lakukan check-out kepada petugas security di pintu keluar. Petugas akan mencatat waktu keluar Anda dan menyelesaikan proses kunjungan di sistem.</p>
                        </div>
                    </div>
                </div>

                <!-- Flow Diagram -->
                <div class="flow-section">
                    <h3>
                        <i class="fas fa-route"></i>
                        Alur Proses Kunjungan
                    </h3>
                    <div class="flow-timeline">
                        <div class="flow-step">
                            <h4>📝 Registrasi Online → ✅ Data Tersimpan</h4>
                            <p>Isi formulir registrasi dan data Anda akan tersimpan dalam sistem</p>
                        </div>
                        <div class="flow-step">
                            <h4>🛡️ Check-in Security → 📧 Terima Email QR Code</h4>
                            <p>Petugas security verifikasi identitas dan sistem mengirim QR Code ke email Anda</p>
                        </div>
                        <div class="flow-step">
                            <h4>📱 Tunjukkan QR → 👔 Pegawai Approve</h4>
                            <p>Pegawai scan QR Code dan menyetujui kunjungan Anda</p>
                        </div>
                        <div class="flow-step">
                            <h4>💼 Kunjungan Selesai → 🚪 Check-out Security</h4>
                            <p>Selesaikan kunjungan dan lakukan check-out di security</p>
                        </div>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="important-notes">
                    <h3>
                        <i class="fas fa-exclamation-triangle"></i>
                        Hal Penting yang Perlu Diperhatikan
                    </h3>
                    <ul>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Pastikan <strong>email aktif</strong> yang Anda daftarkan karena QR Code akan dikirim ke email tersebut</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Siapkan <strong>identitas asli</strong> (KTP/SIM/Paspor) untuk ditunjukkan ke petugas security</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span><strong>QR Code wajib ditunjukkan</strong> kepada pegawai yang Anda tuju untuk mendapat persetujuan</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Foto yang diupload maksimal <strong>2MB</strong> dengan format JPG/PNG</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Data Anda akan <strong>dijaga kerahasiaannya</strong> sesuai kebijakan privasi kami</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Jangan lupa melakukan <strong>check-out</strong> setelah kunjungan selesai</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Proses registrasi online hanya membutuhkan waktu <strong>2-3 menit</strong></span>
                        </li>
                    </ul>
                </div>

                <!-- Action Button -->
                <div class="action-section">
                    <a href="{{ route('tamu.index') }}" class="btn-start">
                        <span>Mulai Registrasi</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <p class="text-muted mt-3 mb-0">Siap untuk mendaftar? Klik tombol di atas untuk memulai!</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="tutorial-footer">
                <p class="mb-2">Sistem Buku Tamu &copy; PJT 1. Made By Intern Polinema 2025</p>
                <a href="https://jasatirta1.co.id/" target="_blank">Perusahaan Umum Jasa Tirta 1</a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>