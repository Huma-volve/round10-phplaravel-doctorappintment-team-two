<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Appointment;

class AppointmentCreatedNotification extends Notification
{
    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'id' => $this->appointment->id,
            'type' => 'appointment_created',
            'title' => 'new appointment confirmed',
            'body' => "You have a new appointment with Dr. {$this->appointment->doctor->user->name}",
            'doctor_name' => $this->appointment->doctor->user->name,
            'appointment_time' => $this->appointment->appointment_time,
            'related_id' => $this->appointment->id,
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'appointment_created',
            'title' => 'new appointment confirmed',
            'body' => "You have a new appointment with Dr. {$this->appointment->doctor->user->name}",
            'related_id' => $this->appointment->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'appointment_created',
            'title' => 'new appointment confirmed',
            'appointment_id' => $this->appointment->id,
            'doctor_name' => $this->appointment->doctor->user->name,
            'appointment_time' => $this->appointment->appointment_time,
        ];
    }
}
