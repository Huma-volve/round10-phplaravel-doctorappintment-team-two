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

    public function create()
    {
        $doctors = Doctor::with('user')->get();
        $patients = Patient::with('user')->get();

        return view('booking.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_time' => 'required|date',
            'payment_method' => 'required|in:cash,stripe'
        ]);

        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($exists) {
            return back()->withErrors(['Time already booked']);
        }

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending'
        ]);

        $appointment->payment()->create([
            'amount' => 200,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_method == 'cash' ? 'pending' : 'pending'
        ]);

      
        return redirect()->back()->with('success', 'Appointment booked successfully');
    }

    public function confirm($id)
{
    $appointment = Appointment::with('payment')->findOrFail($id);

    $appointment->update([
        'status' => 'confirmed'
    ]);

    if ($appointment->payment) {
        $appointment->payment->update([
            'payment_status' => 'paid'
        ]);
    }

    return redirect()->back()->with('success', 'Appointment confirmed successfully');
}
}
