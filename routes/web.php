<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Socialite;


Route::get('/', function () {
    return view('welcome');
});



