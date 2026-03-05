<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Message;

class NewChatMessageNotification extends Notification
{
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'new_message',
            'title' => 'New message received',
            'body' => "You have a new message from chat {$this->message->chat_id}",
            'related_id' => $this->message->chat_id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'new_message',
            'chat_id' => $this->message->chat_id,
            'message_id' => $this->message->id,
        ];
    }
}
