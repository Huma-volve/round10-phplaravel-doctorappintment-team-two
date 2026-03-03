<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationBroadcastEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $notification;
    public $userRole;

    public function __construct($userId, $notification, $userRole = null)
    {
        $this->userId = $userId;
        $this->notification = $notification;
        $this->userRole = $userRole;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("notifications.user.{$this->userId}");
    }

    public function broadcastAs()
    {
        return 'notification.received';
    }

    public function broadcastWith()
    {
        return [
            'notification' => $this->notification,
            'timestamp' => now(),
        ];
    }
}
