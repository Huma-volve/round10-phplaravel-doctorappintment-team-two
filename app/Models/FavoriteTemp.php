<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class favorite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(doctor::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(patient::class);
    }
}
