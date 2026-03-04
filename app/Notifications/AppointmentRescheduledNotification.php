<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Appointment;

class AppointmentRescheduledNotification extends Notification
{
    protected $appointment;
    protected $oldTime;

    public function __construct(Appointment $appointment, $oldTime)
    {
        $this->appointment = $appointment;
        $this->oldTime = $oldTime;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'appointment_rescheduled',
            'title' => 'Appointment Rescheduled',
            'body' => "Your appointment has been rescheduled to {$this->appointment->appointment_time->format('Y-m-d H:i')}",
            'old_time' => $this->oldTime,
            'new_time' => $this->appointment->appointment_time,
            'related_id' => $this->appointment->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'appointment_rescheduled',
            'appointment_id' => $this->appointment->id,
            'new_time' => $this->appointment->appointment_time,
        ];
    }
}
