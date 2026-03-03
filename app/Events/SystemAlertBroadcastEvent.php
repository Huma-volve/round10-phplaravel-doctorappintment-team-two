<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SystemAlertBroadcastEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $alert;
    public $severity;

    public function __construct($alert, $severity = 'info')
    {
        $this->alert = $alert;
        $this->severity = $severity;
    }

    public function broadcastOn()
    {
        return new Channel('admin-alerts');
    }

    public function broadcastAs()
    {
        return 'system.alert';
    }

    public function broadcastWith()
    {
        return [
            'alert' => $this->alert,
            'severity' => $this->severity,
            'timestamp' => now(),
        ];
    }
}
