<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->when(
                $this->relationLoaded('user'),
                fn () => $this->user?->name
            ),
            'profile_photo' => $this->when(
                $this->relationLoaded('user'),
                fn () => $this->user?->profile_photo
            ),
            'specialization' => $this->when(
                $this->relationLoaded('specialization'),
                fn () => $this->specialization?->name
            ),
            'clinic_name' => $this->when(
                $this->relationLoaded('clinic'),
                fn () => $this->clinic?->name_clinic
            ),
            'session_price' => $this->session_price,
            'rating' => $this->when(
                isset($this->reviews_avg_rating),
                fn () => $this->reviews_avg_rating !== null ? round((float) $this->reviews_avg_rating, 2) : null
            ),
            'reviews_count' => $this->when(
                isset($this->reviews_count),
                fn () => (int) $this->reviews_count
            ),
            'is_favorite' => (bool) ($this->is_favorite ?? false),
            'distance_km' => $this->when(
                isset($this->distance_km),
                fn () => round((float) $this->distance_km, 2)
            ),
        ];
    }
}

