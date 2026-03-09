<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reviews';
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
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function appointment(): BelongsTo    
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
    }
}
