<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'rating' => $this->rating,
            'comment' => $this->comment,
            'patient' => $this->when(
                $this->relationLoaded('patient') && $this->patient?->relationLoaded('user'),
                function () {
                    return [
                        'id' => $this->patient->id,
                        'name' => $this->patient->user?->name,
                    ];
                }
            ),
            'created_at' => $this->created_at,
        ];
    }
}

