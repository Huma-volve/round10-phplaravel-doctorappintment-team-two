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
        $faker = fake();

        // Specializations (firstOrCreate to avoid duplicates when re-seeding)
        $cardiology = Specialization::firstOrCreate(
            ['name' => 'Cardiology'],
            ['name' => 'Cardiology']
        );
        $dermatology = Specialization::firstOrCreate(
            ['name' => 'Dermatology'],
            ['name' => 'Dermatology']
        );

        // Clinics with random data
        $clinicA = Clinic::create([
            'name_clinic' => $faker->company() . ' Clinic',
            'phone' => $faker->numerify('+20##########'),
            'address' => $faker->streetAddress(),
            'latitude' => $faker->latitude(30.0, 30.1),
            'longitude' => $faker->longitude(31.2, 31.3),
        ]);

        $clinicB = Clinic::create([
            'name_clinic' => $faker->company() . ' Clinic',
            'phone' => $faker->numerify('+20##########'),
            'address' => $faker->streetAddress(),
            'latitude' => $faker->latitude(30.0, 30.1),
            'longitude' => $faker->longitude(31.2, 31.3),
        ]);

        // Doctor users (random emails/names so no duplicate key)
        $doctorUser1 = User::create([
            'name' => 'Dr. ' . $faker->firstName(),
            'email' => $faker->unique()->safeEmail(),
            'mobile_number' => $faker->numerify('+20##########'),
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'latitude' => $faker->latitude(30.0, 30.1),
            'longitude' => $faker->longitude(31.2, 31.3),
        ]);

        $doctorUser2 = User::create([
            'name' => 'Dr. ' . $faker->firstName(),
            'email' => $faker->unique()->safeEmail(),
            'mobile_number' => $faker->numerify('+20##########'),
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'latitude' => $faker->latitude(30.0, 30.1),
            'longitude' => $faker->longitude(31.2, 31.3),
        ]);

        // Patient user
        $patientUser = User::create([
            'name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'mobile_number' => $faker->numerify('+20##########'),
            'password' => Hash::make('password'),
            'role' => 'patient',
            'latitude' => $faker->latitude(30.0, 30.1),
            'longitude' => $faker->longitude(31.2, 31.3),
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
            'license_number' => 'LIC-' . $faker->unique()->numerify('######'),
            'bio' => $faker->paragraph(),
            'session_price' => $faker->randomFloat(2, 200, 800),
        ]);

        $doctor2 = Doctor::create([
            'user_id' => $doctorUser2->id,
            'clinic_id' => $clinicB->id,
            'specialization_id' => $dermatology->id,
            'clinic_address' => $clinicB->address,
            'license_number' => 'LIC-' . $faker->unique()->numerify('######'),
            'bio' => $faker->paragraph(),
            'session_price' => $faker->randomFloat(2, 200, 800),
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
            'rating' => $faker->numberBetween(3, 5),
            'comment' => $faker->sentence(),
        ]);

        Review::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor1->id,
            'appointment_id' => $appointment2->id,
            'rating' => $faker->numberBetween(3, 5),
            'comment' => $faker->sentence(),
        ]);

        Review::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor2->id,
            'appointment_id' => $appointment3->id,
            'rating' => $faker->numberBetween(3, 5),
            'comment' => $faker->sentence(),
        ]);

        // Favorites
        Favorite::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor1->id,
        ]);
    }
}

