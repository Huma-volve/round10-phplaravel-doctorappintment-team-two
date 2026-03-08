<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\Patient;
use App\Repositories\DoctorRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DoctorService
{
    public function __construct(
        protected DoctorRepository $doctorRepository
    ) {
    }

    public function getDoctorDetails(int $doctorId, ?Patient $patient = null): Doctor
    {
        $doctor = $this->doctorRepository->findDetails($doctorId, $patient?->id);

        if (! $doctor) {
            throw (new ModelNotFoundException())->setModel(Doctor::class, [$doctorId]);
        }

        return $doctor;
    }

    public function getNearbyDoctors(?float $lat, ?float $lng, ?Patient $patient = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->doctorRepository->getNearby($lat, $lng, $patient?->id, $perPage);
    }

    public function favoriteDoctor(Doctor $doctor, Patient $patient): void
    {
        $this->doctorRepository->addFavorite($doctor->id, $patient->id);
    }

    public function unfavoriteDoctor(Doctor $doctor, Patient $patient): void
    {
        $this->doctorRepository->removeFavorite($doctor->id, $patient->id);
    }
}

