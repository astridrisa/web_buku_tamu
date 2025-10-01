<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Untuk Security
    public function getSecurityNotifications()
    {
        $notifications = Auth::user()->notifications;
        $unreadCount = Auth::user()->unreadNotifications->count();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    // Untuk Pegawai
    public function getPegawaiNotifications()
    {
        $notifications = Auth::user()->notifications;
        $unreadCount = Auth::user()->unreadNotifications->count();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    // Tandai satu notif sudah dibaca
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    }

    // Tandai semua notif sudah dibaca
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }
}
