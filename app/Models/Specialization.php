<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'specializations';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];
    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'specialization_id');
    }
}
