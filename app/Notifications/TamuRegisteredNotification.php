<?php

namespace App\Notifications;

use App\Models\TamuModel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TamuRegisteredNotification extends Notification
{
    use Queueable;

    protected $tamu;

    public function __construct(TamuModel $tamu)
    {
        $this->tamu = $tamu;
    }

    public function via($notifiable)
    {
        return ['database']; // Bisa tambah 'mail' jika mau kirim email juga
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'tamu_registered',
            'title' => 'Tamu Baru Terdaftar',
            'message' => "Tamu baru atas nama {$this->tamu->nama} telah mendaftar. Menunggu check-in.",
            'tamu_id' => $this->tamu->id,
            'tamu_nama' => $this->tamu->nama,
            'tamu_email' => $this->tamu->email,
            'tamu_tujuan' => $this->tamu->tujuan,
            'icon' => 'mdi-account-plus',
            'action_url' => route('security.show', $this->tamu->id),
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}