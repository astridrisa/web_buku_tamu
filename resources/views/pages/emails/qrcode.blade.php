<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code - {{ $tamu->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .qr-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 500px;
            text-align: center;
        }
        .qr-code {
            border: 5px solid #667eea;
            border-radius: 15px;
            padding: 20px;
            background: white;
            display: inline-block;
            margin: 20px 0;
        }
        .qr-code svg {
            max-width: 300px;
            height: auto;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="qr-card">
        <h2 class="mb-4">QR Code Check-in</h2>
        
        <div class="qr-code">
            {!! QrCode::size(300)->margin(2)->generate(route('tamu.qr.show', $tamu->qr_code)) !!}
        </div>
        
        <h4 class="mt-4">{{ $tamu->nama }}</h4>
        <p class="text-muted">{{ $tamu->tujuan }}</p>
        
        <div class="mt-4">
            <strong>Status:</strong><br>
            <span class="status-badge bg-{{ $tamu->status_color }}">
                {{ $tamu->status_text }}
            </span>
        </div>
        
        <p class="text-muted small mt-4">
            Tunjukkan QR Code ini kepada pegawai yang dituju
        </p>
        
        <div class="mt-3">
            <small class="text-muted">
                <strong>Waktu Check-in:</strong><br>
                {{ $tamu->checkin_at?->format('d M Y, H:i') ?? '-' }}
            </small>
        </div>
    </div>
</body>
</html>