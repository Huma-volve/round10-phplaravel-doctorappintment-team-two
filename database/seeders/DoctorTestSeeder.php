<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Favorite;
use App\Models\Patient;
use App\Models\Review;
use App\Models\Specialization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorTestSeeder extends Seeder
{
    public function run(): void
    {
        // Specializations
        $cardiology = Specialization::create(['name' => 'Cardiology']);
        $dermatology = Specialization::create(['name' => 'Dermatology']);

        // Clinics around a fixed point (latitude/longitude roughly in the same city)
        $clinicA = Clinic::create([
            'name_clinic' => 'Central Clinic',
            'phone' => '+201000000001',
            'address' => 'Downtown',
            'latitude' => 30.0444,
            'longitude' => 31.2357,
        ]);

        $clinicB = Clinic::create([
            'name_clinic' => 'North Clinic',
            'phone' => '+201000000002',
            'address' => 'North District',
            'latitude' => 30.0644,
            'longitude' => 31.2357,
        ]);

        // Doctor users
        $doctorUser1 = User::create([
            'name' => 'Dr. Ahmed',
            'email' => 'dr.ahmed@example.com',
            'mobile_number' => '+201111111111',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'latitude' => 30.0444,
            'longitude' => 31.2357,
        ]);

        $doctorUser2 = User::create([
            'name' => 'Dr. Sara',
            'email' => 'dr.sara@example.com',
            'mobile_number' => '+201122222222',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'latitude' => 30.0644,
            'longitude' => 31.2357,
        ]);

        // Patient user
        $patientUser = User::create([
            'name' => 'Patient Ali',
            'email' => 'patient.ali@example.com',
            'mobile_number' => '+201133333333',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'latitude' => 30.0544,
            'longitude' => 31.2357,
        ]);

        $patient = Patient::create([
            'user_id' => $patientUser->id,
        ]);

        // Doctors
        $doctor1 = Doctor::create([
            'user_id' => $doctorUser1->id,
            'clinic_id' => $clinicA->id,
            'specialization_id' => $cardiology->id,
            'clinic_address' => $clinicA->address,
            'license_number' => 'LIC-001',
            'bio' => 'Experienced cardiologist with a focus on preventive care.',
            'session_price' => 500.0,
        ]);

        $doctor2 = Doctor::create([
            'user_id' => $doctorUser2->id,
            'clinic_id' => $clinicB->id,
            'specialization_id' => $dermatology->id,
            'clinic_address' => $clinicB->address,
            'license_number' => 'LIC-002',
            'bio' => 'Dermatologist specializing in skin allergies and cosmetic treatments.',
            'session_price' => 400.0,
        ]);

        // Appointments (required by reviews FK)
        $appointment1 = Appointment::create([
            'doctor_id' => $doctor1->id,
            'patient_id' => $patient->id,
            'appointment_time' => Carbon::now()->subDays(10),
            'Status' => 'completed',
        ]);
        $appointment2 = Appointment::create([
            'doctor_id' => $doctor1->id,
            'patient_id' => $patient->id,
            'appointment_time' => Carbon::now()->subDays(5),
            'Status' => 'completed',
        ]);
        $appointment3 = Appointment::create([
            'doctor_id' => $doctor2->id,
            'patient_id' => $patient->id,
            'appointment_time' => Carbon::now()->subDays(3),
            'Status' => 'completed',
        ]);

        // Reviews (different ratings to test averages and ordering)
        Review::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor1->id,
            'appointment_id' => $appointment1->id,
            'rating' => 5,
            'comment' => 'Excellent doctor, very helpful.',
        ]);

        Review::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor1->id,
            'appointment_id' => $appointment2->id,
            'rating' => 4,
            'comment' => 'Good experience overall.',
        ]);

        Review::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor2->id,
            'appointment_id' => $appointment3->id,
            'rating' => 3,
            'comment' => 'Average visit.',
        ]);

        // Favorites
        Favorite::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor1->id,
        ]);
    }
}

