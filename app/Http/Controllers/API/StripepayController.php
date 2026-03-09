<?php

namespace App\Http\Controllers\Api;

use Stripe\StripeClient;
use App\Models\Appointment;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripepayController extends Controller
{
    private $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.api_key.secret'));
    }

    // إنشاء Checkout Session
    public function checkout($appointment_id)
    {
        $appointment = Appointment::with('doctor')->findOrFail($appointment_id);

        $session = $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Doctor Appointment'
                    ],
                    'unit_amount' => $appointment->doctor->session_price * 100, // السعر بالـ cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/api/payment/success/'.$appointment->id),
            'cancel_url' => url('/api/payment/cancel/'.$appointment->id),
        ]);

        return response()->json([
            'checkout_url' => $session->url
            // 'checkout_url'=>'Payment Successful'
        ]);
    }

    // بعد الدفع الناجح
    public function success($appointment_id)
    {
        $appointment = Appointment::with('doctor')->findOrFail($appointment_id);

        Payment::create([
            'appointment_id' => $appointment->id,
            'amount' => $appointment->doctor->session_price,
            'payment_method' => 'stripe',
            'payment_status' => 'paid',
            'transaction_id' => uniqid()
        ]);

        $appointment->update([
            'status' => 'confirmed'
        ]);

        return response()->json([
            'message' => 'Payment Successful'
        ]);
    }

    // عند إلغاء الدفع
    public function cancel($appointment_id)
    {
        Payment::create([
            'appointment_id' => $appointment_id,
            'amount' => 0,
            'payment_method' => 'stripe',
            'payment_status' => 'failed',
            'transaction_id' => uniqid(),
        ]);

        return response()->json([
            'message' => 'Payment Cancelled'
        ]);
    }
}