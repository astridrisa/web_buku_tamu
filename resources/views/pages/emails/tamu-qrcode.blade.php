<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Check-in</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            margin: -30px -30px 30px -30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .qr-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }
        .qr-section svg {
            max-width: 250px;
            border: 3px solid #667eea;
            border-radius: 10px;
            padding: 10px;
            background-color: white;
        }
        .info-box {
            background-color: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-box h3 {
            margin-top: 0;
            color: #1976D2;
        }
        .detail-row {
            display: flex;
            margin: 10px 0;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }
        .detail-value {
            flex: 1;
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            color: #777;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Check-in Berhasil</h1>
            <p>{{ config('app.name') }}</p>
        </div>

        <p>Halo <strong>{{ $tamu->nama }}</strong>,</p>
        
        <p>Terima kasih telah melakukan check-in. Berikut adalah QR Code Anda:</p>

        <div style="text-align: center; margin: 30px 0; padding: 20px; background: #f8f9fa; border-radius: 10px;">
            <h3 style="color: #667eea; margin-top: 0;">QR Code Anda</h3>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($qrCodeUrl) }}" 
                alt="QR Code" 
                style="max-width: 250px; border: 3px solid #667eea; border-radius: 10px; padding: 10px; background: white;">
            <p style="color: #666; font-size: 14px; margin-top: 15px;">
                Scan QR Code ini saat bertemu dengan pegawai
            </p>
        </div>
                <div class="info-box">
            <h3>Detail Kunjungan</h3>
            <div class="detail-row">
                <div class="detail-label">Nama</div>
                <div class="detail-value">{{ $tamu->nama }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Tujuan</div>
                <div class="detail-value">{{ $tamu->tujuan }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Waktu Check-in</div>
                <div class="detail-value">{{ $tamu->checkin_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}</div>
            </div>
            @if($tamu->jumlah_rombongan > 1)
            <div class="detail-row">
                <div class="detail-label">Jumlah Rombongan</div>
                <div class="detail-value">{{ $tamu->jumlah_rombongan }} orang</div>
            </div>
            @endif
        </div>

        <div class="warning">
            <strong>Penting:</strong>
            <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                <li>Simpan email ini atau screenshot QR Code</li>
                <li>Tunjukkan QR Code kepada pegawai yang dituju</li>
                <li>QR Code ini berlaku hanya untuk satu kali kunjungan</li>
            </ul>
        </div>

        {{-- <div style="text-align: center;">
            <a href="{{ $qrCodeUrl }}" class="button">
                Lihat QR Code Online
            </a>
        </div> --}}

        <div class="footer">
            <p>Email ini dikirim otomatis oleh sistem {{ config('app.name') }}</p>
            <p>Jika ada pertanyaan, silakan hubungi security kami</p>
            <p style="color: #999; font-size: 12px;">
                {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>