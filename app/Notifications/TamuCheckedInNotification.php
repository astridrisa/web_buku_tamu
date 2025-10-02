<?php

namespace App\Notifications;

use App\Models\TamuModel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TamuCheckedInNotification extends Notification
{
    use Queueable;

    protected $tamu;

    public function __construct(TamuModel $tamu)
    {
        $this->tamu = $tamu;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'tamu_checkin',
            'title' => 'Tamu Telah Check-in',
            'message' => "Tamu {$this->tamu->nama} telah check-in. Menunggu approval dari pegawai.",
            'tamu_id' => $this->tamu->id,
            'tamu_nama' => $this->tamu->nama,
            'tamu_email' => $this->tamu->email,
            'tamu_tujuan' => $this->tamu->tujuan,
            'icon' => 'mdi-login',
            'action_url' => route('pegawai.tamu.approve', $this->tamu->id),
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}