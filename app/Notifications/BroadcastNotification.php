<?php

namespace App\Notifications;

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

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
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
