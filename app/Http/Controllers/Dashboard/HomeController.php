<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all();
        $patientsCount = Patient::count();
        $doctorsCount = Doctor::count();
        $appointmentsCount = Appointment::count();

        // Get recent data with relationships for details
        $doctors = Doctor::with(['user', 'specialization', 'clinic'])
            ->latest()
            ->take(5)
            ->get();

        $recentAppointments = Appointment::with(['doctor.user', 'patient.user'])
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard.index', compact(
            'users', 
            'patientsCount', 
            'doctorsCount', 
            'appointmentsCount', 
            'doctors', 
            'recentAppointments'
        ));
    }
}
