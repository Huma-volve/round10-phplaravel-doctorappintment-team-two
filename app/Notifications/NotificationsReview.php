<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationsReview extends Notification
{
    use Queueable;
    private $Review_id;


    public function __construct($Review_id)
    {
        $this->Review_id = $Review_id;
    }


    public function via(object $notifiable): array
    {
        return ['database'];
    }


    public function toArray(object $notifiable): array
    {
        return [
            "Review_id"=>$this->Review_id
        ];
    }
}
