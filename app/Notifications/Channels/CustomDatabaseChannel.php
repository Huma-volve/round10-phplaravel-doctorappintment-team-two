<?php

namespace App\Notifications\Channels;

use App\Models\Notification as NotificationModel;
use Illuminate\Notifications\Notification;

class CustomDatabaseChannel
{
    /**
     * Send the notification to the custom notifications table (title, body, type, user_id).
     */
    public function send(object $notifiable, Notification $notification): void
    {
        $data = $notification->toArray($notifiable);

        NotificationModel::create([
            'user_id' => $notifiable->getKey(),
            'title' => $data['title'] ?? '',
            'body' => $data['body'] ?? '',
            'type' => $data['type'] ?? 'broadcast',
            'is_read' => false,
        ]);
    }
}
