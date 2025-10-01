<?php


namespace App\Mail;

use App\Models\TamuModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;

class TamuQrCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tamu;
    public $qrCodePath;

    public function __construct(TamuModel $tamu, $qrCodePath)
    {
        $this->tamu = $tamu;
        $this->qrCodePath = $qrCodePath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'QR Code Check-in Anda - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tamu-qrcode',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->qrCodePath)
                ->as('qr-code-' . $this->tamu->id . '.png')
                ->withMime('image/png'),
        ];
    }
}