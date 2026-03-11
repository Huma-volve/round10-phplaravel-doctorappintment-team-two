<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $fillable = ['title', 'description'];
    public static function rules()
    {
        return [

            "title" => [
                'required',
                'string',
                'max:255',
            ],

            "description" => [
                'required',
                'string',
            ],

        ];
    }
}
