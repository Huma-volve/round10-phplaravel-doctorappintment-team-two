<?php

namespace App\Services;

use App\Models\doctor;
use App\Models\patient;
use App\Repositories\DoctorRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DoctorService
{
    public function __construct(
        protected DoctorRepository $doctorRepository
    ) {
    }

    public function getDoctorDetails(int $doctorId, ?patient $patient = null): doctor
    {
        $doctor = $this->doctorRepository->findDetails($doctorId, $patient?->id);

        if (! $doctor) {
            throw (new ModelNotFoundException())->setModel(doctor::class, [$doctorId]);
        }

        return $doctor;
    }

    public function getNearbyDoctors(?float $lat, ?float $lng, ?patient $patient = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->doctorRepository->getNearby($lat, $lng, $patient?->id, $perPage);
    }

    public function favoriteDoctor(doctor $doctor, patient $patient): void
    {
        $this->doctorRepository->addFavorite($doctor->id, $patient->id);
    }

    public function unfavoriteDoctor(doctor $doctor, patient $patient): void
    {
        $this->doctorRepository->removeFavorite($doctor->id, $patient->id);
    }
}

