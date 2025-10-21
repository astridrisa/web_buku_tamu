<?php

namespace App\Mail;

use App\Models\TamuModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TamuQrCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tamu;
    public $qrCodePath;

    public function __construct(TamuModel $tamu, $qrCodePath)
    {
        $this->tamu = $tamu;
        $this->qrCodePath = str_replace('/', DIRECTORY_SEPARATOR, $qrCodePath);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'QR Code Check-in - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        // Generate URL QR Code dengan ID tamu
        $qrCodeUrl = route('login.qr', $this->tamu->id);
        
        Log::info('Preparing QR Code email', [
            'tamu_id' => $this->tamu->id,
            'tamu_name' => $this->tamu->nama,
            'qr_url' => $qrCodeUrl,
            'qr_file_path' => $this->qrCodePath,
            'file_exists' => file_exists($this->qrCodePath)
        ]);

        // Cek apakah file QR Code PNG exists
        $qrCodeBase64 = null;
        if (file_exists($this->qrCodePath)) {
            // Convert PNG to base64 untuk embed di email
            $imageData = file_get_contents($this->qrCodePath);
            $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($imageData);
            Log::info("QR Code PNG loaded successfully from: {$this->qrCodePath}");
        } else {
            Log::error("QR Code PNG file not found: {$this->qrCodePath}");
        }

        return new Content(
            view: 'pages.emails.tamu-qrcode',
            with: [
                'tamu' => $this->tamu,
                'qrCodeUrl' => $qrCodeUrl, // URL untuk link button
                'qrCodeBase64' => $qrCodeBase64, // Base64 image untuk display
            ]
        );
    }

    public function attachments(): array
    {
        // Attach QR code PNG jika file exists
        if (file_exists($this->qrCodePath)) {
            Log::info("Attaching QR Code PNG to email");
            return [
                Attachment::fromPath($this->qrCodePath)
                    ->as('qrcode-' . $this->tamu->nama . '.png')
                    ->withMime('image/png'),
            ];
        }
        
        Log::warning("QR Code file not found, no attachment added");
        return [];
    }
}