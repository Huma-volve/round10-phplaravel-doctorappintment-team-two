<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorDetailsRequest;
use App\Http\Resources\DoctorDetailsResource;
use App\Http\Resources\DoctorSummaryResource;
use App\Models\Doctor;
use App\Models\Patient;
use App\Services\DoctorService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function __construct(
        protected DoctorService $doctorService
    ) {
    }

    public function show(Doctor $doctor, DoctorDetailsRequest $request): JsonResponse
    {
        $patient = $this->currentPatient();

        $doctorModel = $this->doctorService->getDoctorDetails($doctor->id, $patient);

        return ApiResponse::success(
            new DoctorDetailsResource($doctorModel),
            'Doctor details fetched successfully.'
        );
    }

    public function nearby(DoctorDetailsRequest $request): JsonResponse
    {
        $patient = $this->currentPatient();

        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $paginator = $this->doctorService->getNearbyDoctors(
            $lat !== null ? (float) $lat : null,
            $lng !== null ? (float) $lng : null,
            $patient
        );

        return ApiResponse::success(
            DoctorSummaryResource::collection($paginator),
            'Nearby doctors fetched successfully.'
        );
    }

    public function favorite(Doctor $doctor, Request $request): JsonResponse
    {
        $patient = $this->requiredPatient($request);

        $this->doctorService->favoriteDoctor($doctor, $patient);

        return ApiResponse::success(
            ['is_favorite' => true],
            'Doctor added to favorites.'
        );
    }

    public function unfavorite(Doctor $doctor, Request $request): JsonResponse
    {
        $patient = $this->requiredPatient($request);

        $this->doctorService->unfavoriteDoctor($doctor, $patient);

        return ApiResponse::success(
            ['is_favorite' => false],
            'Doctor removed from favorites.'
        );
    }

    protected function currentPatient(): ?Patient
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'patient') {
            return null;
        }

        return $user->patient;
    }

    protected function requiredPatient(Request $request): Patient
    {
        $user = $request->user();

        if (! $user || $user->role !== 'patient') {
            abort(403, 'Only patients can manage favorites.');
        }

        $patient = $user->patient;

        if (! $patient) {
            abort(403, 'Patient profile not found for this user.');
        }

        return $patient;
    }
}

