<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class payment extends Model
{
      protected $table='payments';
    protected $guarded = [];


  public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}

