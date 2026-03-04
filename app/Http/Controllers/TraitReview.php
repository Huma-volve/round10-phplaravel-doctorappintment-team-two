<?php

namespace App\Http\Controllers;



trait TraitReview
{
    public function apiresponse($data = null, $msg = null, $status = 200)
    {
        $array = [
            'key' => $data,
            'msg' => $msg,
            'stutes' => $status
        ];
        return response($array);
    }
}
