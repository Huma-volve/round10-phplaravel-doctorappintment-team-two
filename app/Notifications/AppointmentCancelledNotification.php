<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Appointment;

class AppointmentCancelledNotification extends Notification
{
    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'appointment_cancelled',
            'title' => 'the appointment has been cancelled',
            'body' => "The appointment has been cancelled for doctor {$this->appointment->doctor->user->name}",
            'related_id' => $this->appointment->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'appointment_cancelled',
            'appointment_id' => $this->appointment->id,
        ];
    }
}
