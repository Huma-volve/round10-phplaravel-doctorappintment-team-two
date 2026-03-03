<?php

namespace App\Repositories;

use App\Models\doctor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DoctorRepository
{
    public function findDetails(int $doctorId, ?int $patientId = null): ?doctor
    {
        $query = doctor::query()
            ->with([
                'user',
                'specialization',
                'clinic',
                'reviews.patient.user',
            ])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if ($patientId !== null) {
            $query->withExists([
                'favorites as is_favorite' => function ($q) use ($patientId) {
                    $q->where('patient_id', $patientId);
                },
            ]);
        }

        return $query->find($doctorId);
    }

    public function getNearby(?float $lat, ?float $lng, ?int $patientId = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = doctor::query()
            ->with([
                'specialization',
                'clinic',
            ])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if ($patientId !== null) {
            $query->withExists([
                'favorites as is_favorite' => function ($q) use ($patientId) {
                    $q->where('patient_id', $patientId);
                },
            ]);
        }

        // Case A: coordinates provided – use distance calculation
        if ($lat !== null && $lng !== null) {
            $haversine = '(6371 * acos(cos(radians(?)) * cos(radians(clinics.latitude)) * cos(radians(clinics.longitude) - radians(?)) + sin(radians(?)) * sin(radians(clinics.latitude))))';

            $query
                ->select('doctors.*')
                ->selectRaw($haversine . ' as distance_km', [$lat, $lng, $lat])
                ->join('clinics', 'doctors.clinic_id', '=', 'clinics.id')
                ->orderBy('distance_km');
        } else {
            // Case B: missing coordinates – fallback to top-rated doctors
            $query
                ->orderByDesc('reviews_avg_rating')
                ->orderByDesc('reviews_count');
        }

        return $query->paginate($perPage);
    }

    public function addFavorite(int $doctorId, int $patientId): void
    {
        \App\Models\favorite::firstOrCreate([
            'patient_id' => $patientId,
            'doctor_id' => $doctorId,
        ]);
    }

    public function removeFavorite(int $doctorId, int $patientId): void
    {
        \App\Models\favorite::where('patient_id', $patientId)
            ->where('doctor_id', $doctorId)
            ->delete();
    }
}

