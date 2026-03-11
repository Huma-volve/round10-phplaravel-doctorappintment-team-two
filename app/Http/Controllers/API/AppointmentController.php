<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Payment;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
     public function index()
    {
        $appointments = Appointment::with(['doctor', 'patient'])->get();

        return response()->json($appointments);
    }

   public function store(Request $request)
    {
        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending'
        ]);
          

          return response()->json([
            'message' => 'Appointment created',
            'appointment' => $appointment,
        ]);
    }

         public function confirm(Request $request,$id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'status' => 'confirmed'
        ]);
          $payment = Payment::create([
            'appointment_id' => $appointment->id,
            'amount' => $request->amount,
            'payment_method' => 'stripe',
            'payment_status' => 'pending',
            'transaction_id'=>$request->transaction_id
        ]);

        return response()->json(['message'=>'Appointment confirmed']);
    }


      public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'status'=>'cancelled'
        ]);

        return response()->json(['message'=>'Appointment cancelled']);
    }




}
