<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Payment;

class PaymentReceivedNotification extends Notification
{
    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'payment_received',
            'title' => 'Payment received',
            'body' => "Payment of {$this->payment->amount} Riyal has been received",
            'amount' => $this->payment->amount,
            'related_id' => $this->payment->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'payment_received',
            'payment_id' => $this->payment->id,
            'amount' => $this->payment->amount,
        ];
    }
}
