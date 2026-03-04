<?php

namespace App\Notifications;

use App\Notifications\Channels\CustomDatabaseChannel;
use Illuminate\Notifications\Notification;

class BroadcastNotification extends Notification
{
    protected $title;
    protected $message;
    protected $targetRoles;

    public function __construct($title, $message, $targetRoles = ['all'])
    {
        $this->title = $title;
        $this->message = $message;
        $this->targetRoles = $targetRoles;
    }

    public function via($notifiable): array
    {
        return [CustomDatabaseChannel::class];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'broadcast',
            'title' => $this->title,
            'body' => $this->message,
            'target_roles' => $this->targetRoles,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'broadcast',
            'title' => $this->title,
            'message' => $this->message,
        ];
    }
}
