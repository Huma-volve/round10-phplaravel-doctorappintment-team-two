<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = ['patient_id', 'doctor_id', 'appointment_id', 'rating', 'comment'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public static function rules()
    {
        return [

            "patient_id" => [
                'required',
                'integer',
                'exists:patients,id',
            ],

            "doctor_id" => [
                'required',
                'integer',
                'exists:doctors,id',
            ],
            "appointment_id" => [
                'required',
                'integer',
                'exists:appointments,id',
            ],

            "rating" => [
                'required',
                'numeric',
                'min:0',
                'max:5'
            ],

            "comment" => [
                'required',
                'string',
                'min:3',
                'max:255',

            ],


        ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'rating',
        'comment',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(doctor::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(patient::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(appointment::class);
    }
}
