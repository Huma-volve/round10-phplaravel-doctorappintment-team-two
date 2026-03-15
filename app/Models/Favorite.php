<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'favorites';
    protected $guarded = [];

    
    public function doctor()
    {
        return $this->belongsTo(doctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(patient::class, 'patient_id');
    }
}
