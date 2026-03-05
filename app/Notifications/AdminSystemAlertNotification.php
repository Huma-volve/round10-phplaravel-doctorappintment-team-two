<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AdminSystemAlertNotification extends Notification
{
    protected $title;
    protected $message;
    protected $severity;

    public function __construct($title, $message, $severity = 'info')
    {
        $this->title = $title;
        $this->message = $message;
        $this->severity = $severity;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'admin_alert',
            'severity' => $this->severity,
            'title' => $this->title,
            'body' => $this->message,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'admin_alert',
            'severity' => $this->severity,
            'title' => $this->title,
        ];
    }
}
