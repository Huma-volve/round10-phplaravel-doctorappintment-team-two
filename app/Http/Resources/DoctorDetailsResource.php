<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorDetailsResource extends JsonResource
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
            'clinic' => $this->when(
                $this->relationLoaded('clinic'),
                function () {
                    return [
                        'id' => $this->clinic->id,
                        'name' => $this->clinic->name_clinic,
                        'phone' => $this->clinic->phone,
                        'address' => $this->clinic->address,
                        'latitude' => $this->clinic->latitude,
                        'longitude' => $this->clinic->longitude,
                    ];
                }
            ),
            'session_price' => $this->session_price,
            'about' => $this->bio,
            'rating' => $this->when(
                isset($this->reviews_avg_rating),
                fn () => $this->reviews_avg_rating !== null ? round((float) $this->reviews_avg_rating, 2) : null
            ),
            'reviews_count' => $this->when(
                isset($this->reviews_count),
                fn () => (int) $this->reviews_count
            ),
            'is_favorite' => (bool) ($this->is_favorite ?? false),
            'reviews' => ReviewResource::collection(
                $this->whenLoaded('reviews')
            ),
        ];
    }
}

