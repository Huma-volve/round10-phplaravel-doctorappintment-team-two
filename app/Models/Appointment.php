<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_time',
        'Status',
    ];
    
       public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function doctor()
{
    return $this->belongsTo(Doctor::class);
}
    public function patient()
{
    return $this->belongsTo(Patient::class);
}
}
