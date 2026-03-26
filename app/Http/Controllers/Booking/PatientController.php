<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Doctor;

class PatientController extends Controller
{
    public function index()
{
    $appointments = Appointment::with([ 'patient.user','payment'])->get();

    return view('patientbooking.index', compact('appointments'));
}
}
