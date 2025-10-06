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
        // ✅ Normalisasi path untuk Windows
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
        // ✅ Cek apakah file exists
        if (!file_exists($this->qrCodePath)) {
            Log::error("QR Code file not found: {$this->qrCodePath}");
            $qrCodeSvg = '<p>QR Code tidak tersedia</p>';
        } else {
            $qrCodeSvg = file_get_contents($this->qrCodePath);
            Log::info("QR Code file loaded successfully from: {$this->qrCodePath}");
        }

        return new Content(
            view: 'pages.emails.tamu-qrcode',
            with: [
                'tamu' => $this->tamu,
                'qrCodeUrl' => route('tamu.qr.show', $this->tamu->qr_code),
                // 'qrCodeSvg' => $qrCodeSvg
            ]
        );
    }

    public function attachments(): array
    {
        // // ✅ Hanya attach jika file exists
        // if (file_exists($this->qrCodePath)) {
        //     return [
        //         Attachment::fromPath($this->qrCodePath)
        //             ->as('qrcode.svg')
        //             ->withMime('image/svg+xml'),
        //     ];
        // }
        
        return [];
    }
}