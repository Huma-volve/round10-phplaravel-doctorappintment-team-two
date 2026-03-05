<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Appointment;

class NewBookingNotification extends Notification
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
            'type' => 'new_booking',
            'title' => 'New booking received',
            'body' => "You have a new booking from {$this->appointment->patient->user->name}",
            'patient_name' => $this->appointment->patient->user->name,
            'appointment_time' => $this->appointment->appointment_time,
            'related_id' => $this->appointment->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'new_booking',
            'appointment_id' => $this->appointment->id,
            'patient_name' => $this->appointment->patient->user->name,
        ];
    }
}
