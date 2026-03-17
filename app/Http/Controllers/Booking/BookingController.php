<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Patient;
use App\Models\Doctor;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['doctor.user', 'patient'])->get();
        return view('booking.index', compact('appointments'));
    }

    public function create(){
        return view('booking.create');
    }
}
