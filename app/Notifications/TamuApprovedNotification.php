<?php

namespace App\Notifications;

use App\Models\TamuModel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TamuApprovedNotification extends Notification
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
            'type' => 'tamu_approved',
            'title' => 'Tamu Telah Disetujui',
            'message' => "Tamu {$this->tamu->nama} telah disetujui oleh pegawai. Siap untuk check-out.",
            'tamu_id' => $this->tamu->id,
            'tamu_nama' => $this->tamu->nama,
            'icon' => 'mdi-check-circle',
            'action_url' => route('security.show', $this->tamu->id),
        ];
    }
}
