<?php
namespace App\Services;

use App\Models\UserModel;
use App\Models\TamuModel;
use App\Notifications\TamuRegisteredNotification;
use App\Notifications\TamuCheckedInNotification;
use App\Notifications\TamuApprovedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Kirim notifikasi ke semua security saat tamu register
     */
    public function notifySecurityNewGuest(TamuModel $tamu)
    {
        try {
            $securityUsers = UserModel::where('role_id', 3)->get();
            
            Log::info('Sending notification to ' . $securityUsers->count() . ' security users');
            
            if ($securityUsers->isEmpty()) {
                Log::warning('No security users found to notify');
                return;
            }
            
            Notification::send($securityUsers, new TamuRegisteredNotification($tamu));
            
            Log::info('Notification sent successfully');
        } catch (\Exception $e) {
            Log::error('Error sending notification to security: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Kirim notifikasi ke semua pegawai saat tamu check-in
     */
   public function notifyPegawaiCheckedIn($tamu)
{
    Log::info("Memulai notifikasi check-in untuk tamu ID {$tamu->id}");

    // Ambil semua pegawai dari tabel users
    $pegawai = UserModel::where('role_id', 2)->get();

    if ($pegawai->isEmpty()) {
        Log::warning("Tidak ada pegawai (role_id = 2) untuk menerima notifikasi check-in tamu ID {$tamu->id}");
        return;
    }

    foreach ($pegawai as $user) {
        try {
            $user->notify(new TamuCheckedInNotification($tamu));
            Log::info("Notifikasi check-in tamu ID {$tamu->id} dikirim ke pegawai ID {$user->id} ({$user->name})");
        } catch (\Exception $e) {
            Log::error("Gagal mengirim notifikasi ke pegawai ID {$user->id}: " . $e->getMessage());
        }
    }

    Log::info("Notifikasi check-in untuk tamu ID {$tamu->id} selesai dikirim ke pegawai.");
}


    /**
     * Kirim notifikasi ke security saat tamu di-approve pegawai
     */
    public function notifySecurityApproved(TamuModel $tamu)
    {
        try {
            $securityUsers = UserModel::where('role_id', 3)->get();
            
            Log::info('Sending approved notification to ' . $securityUsers->count() . ' security users');
            
            if ($securityUsers->isEmpty()) {
                Log::warning('No security users found to notify');
                return;
            }
            
            Notification::send($securityUsers, new TamuApprovedNotification($tamu));
            
            Log::info('Approved notification sent successfully');
        } catch (\Exception $e) {
            Log::error('Error sending approved notification: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount($userId)
    {
        try {
            $user = UserModel::find($userId);
            
            if (!$user) {
                Log::warning('User not found for unread count: ' . $userId);
                return 0;
            }
            
            return $user->unreadNotifications()->count();
        } catch (\Exception $e) {
            Log::error('Error getting unread count: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get recent notifications
     */
    public function getRecentNotifications($userId, $limit = 10)
    {
        try {
            $user = UserModel::find($userId);

            if (!$user) {
                Log::warning('User not found for notifications: ' . $userId);
                return collect([]);
            }

            return $user->notifications()
                ->latest()
                ->limit($limit)
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'title' => $notification->data['title'] ?? 'No Title',
                        'type' => $notification->data['type'] ?? null,
                        'read_at' => $notification->read_at,
                        'created_at' => $notification->created_at->diffForHumans(),
                    ];
                });
        } catch (\Exception $e) {
            Log::error('Error getting recent notifications: ' . $e->getMessage());
            return collect([]);
        }
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($userId, $notificationId)
    {
        try {
            $user = UserModel::find($userId);
            
            if (!$user) {
                Log::warning('User not found for mark as read: ' . $userId);
                return false;
            }
            
            $notification = $user->notifications()->find($notificationId);
            
            if ($notification) {
                $notification->markAsRead();
                Log::info('Notification marked as read: ' . $notificationId);
                return true;
            }
            
            Log::warning('Notification not found: ' . $notificationId);
            return false;
        } catch (\Exception $e) {
            Log::error('Error marking notification as read: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mark all as read
     */
    public function markAllAsRead($userId)
    {
        try {
            $user = UserModel::find($userId);
            
            if (!$user) {
                Log::warning('User not found for mark all as read: ' . $userId);
                return false;
            }
            
            $user->unreadNotifications->markAsRead();
            Log::info('All notifications marked as read for user: ' . $userId);
            return true;
        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read: ' . $e->getMessage());
            return false;
        }
    }
}