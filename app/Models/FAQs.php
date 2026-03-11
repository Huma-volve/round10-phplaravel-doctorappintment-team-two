<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQs extends Model
{
        
    protected $fillable = [
        'question',
        'answer'
    ];
    public static function rules()
    {
        return [

            "question" => [
                'required',
                'string',

            ],

            "answer" => [
                'required',
                'string',
                'max:255',
            ],


        ];
    }
}
