## Doctor APIs JSON Responses

This document explains the JSON structures returned by the Doctor Details and Home/Nearby endpoints, and how they map to Laravel API resources.

---

## 1. Doctor Details – `GET /api/doctors/{id}`

### Example response

```json
{
  "success": true,
  "message": "Doctor details fetched successfully.",
  "data": {
    "id": 1,
    "name": "Dr. Ahmed",
    "profile_photo": "https://example.com/photos/dr-ahmed.jpg",
    "specialization": "Cardiology",
    "clinic": {
      "id": 1,
      "name": "Central Clinic",
      "phone": "+201000000001",
      "address": "Downtown",
      "latitude": 30.0444,
      "longitude": 31.2357
    },
    "session_price": 500,
    "about": "Experienced cardiologist with a focus on preventive care.",
    "rating": 4.5,
    "reviews_count": 12,
    "is_favorite": true,
    "reviews": [
      {
        "id": 10,
        "rating": 5,
        "comment": "Excellent doctor, very helpful.",
        "patient": {
          "id": 3,
          "name": "Patient Ali"
        },
        "created_at": "2026-03-03T10:15:00.000000Z"
      }
    ]
  }
}
```

### Mapping to code

- The outer envelope (`success`, `message`, `data`) is created by `App\Support\ApiResponse::success()`.
- The `data` value is produced by `App\Http\Resources\DoctorDetailsResource`, which wraps an `App\Models\doctor` instance loaded with:
  - `user`, `clinic`, `specialization`, and `reviews.patient.user` relations.
  - Aggregated fields `reviews_avg_rating` and `reviews_count` from:
    - `->withAvg('reviews', 'rating')`
    - `->withCount('reviews')`
  - Favorite flag `is_favorite` from:
    - `->withExists(['favorites as is_favorite' => fn ($q) => $q->where('patient_id', $patientId)])`
- Each review item is transformed by `App\Http\Resources\ReviewResource`.

---

## 2. Nearby / Home doctors list – `GET /api/doctors/nearby`

This endpoint supports two modes:

1. **Location-based nearby doctors** when `lat` and `lng` are provided.
2. **Fallback to top-rated doctors** when either `lat` or `lng` is missing/null.

### 2.1 Location-based nearby (with `lat` and `lng`)

#### Request

```http
GET /api/doctors/nearby?lat=30.05&lng=31.23
```

#### Example response

```json
{
  "success": true,
  "message": "Nearby doctors fetched successfully.",
  "data": {
    "data": [
      {
        "id": 1,
        "name": "Dr. Ahmed",
        "profile_photo": "https://example.com/photos/dr-ahmed.jpg",
        "specialization": "Cardiology",
        "clinic_name": "Central Clinic",
        "session_price": 500,
        "rating": 4.5,
        "reviews_count": 12,
        "is_favorite": true,
        "distance_km": 1.2
      },
      {
        "id": 2,
        "name": "Dr. Sara",
        "profile_photo": "https://example.com/photos/dr-sara.jpg",
        "specialization": "Dermatology",
        "clinic_name": "North Clinic",
        "session_price": 400,
        "rating": 3.0,
        "reviews_count": 5,
        "is_favorite": false,
        "distance_km": 3.8
      }
    ],
    "links": {
      "first": "http://localhost/api/doctors/nearby?page=1",
      "last": "http://localhost/api/doctors/nearby?page=1",
      "prev": null,
      "next": null
    },
    "meta": {
      "current_page": 1,
      "from": 1,
      "last_page": 1,
      "path": "http://localhost/api/doctors/nearby",
      "per_page": 10,
      "to": 2,
      "total": 2
    }
  }
}
```

#### Mapping to code

- Controller: `DoctorController@nearby` calls:
  - `DoctorService::getNearbyDoctors($lat, $lng, $patient)` which delegates to `DoctorRepository::getNearby()`.
- Repository:
  - Uses clinic `latitude`/`longitude` and a Haversine expression to compute `distance_km`.
  - Orders by `distance_km`.
  - Adds:
    - `withAvg('reviews', 'rating')`
    - `withCount('reviews')`
    - `withExists(['favorites as is_favorite' => ...])`
- Resource:
  - `DoctorSummaryResource::collection($paginator)` transforms each doctor into the minimal card:
    - `id`, `name`, `profile_photo`, `specialization`, `clinic_name`, `session_price`, `rating`, `reviews_count`, `is_favorite`, `distance_km` (rounded).
  - Because it wraps a paginator, Laravel automatically adds `data`, `links`, and `meta` keys inside `data`.

### 2.2 Fallback mode (no `lat`/`lng`)

If `lat` or `lng` is missing or null, the same endpoint returns the **top-rated doctors**, without distance information.

#### Request

```http
GET /api/doctors/nearby
```

#### Example response (truncated)

```json
{
  "success": true,
  "message": "Nearby doctors fetched successfully.",
  "data": {
    "data": [
      {
        "id": 1,
        "name": "Dr. Ahmed",
        "specialization": "Cardiology",
        "clinic_name": "Central Clinic",
        "session_price": 500,
        "rating": 4.5,
        "reviews_count": 12,
        "is_favorite": true
      }
    ],
    "links": { "...": "..." },
    "meta": { "...": "..." }
  }
}
```

#### Mapping to code

- In `DoctorRepository::getNearby()`:
  - When `lat` or `lng` is null, we **do not** join on clinics or compute distance.
  - Instead we order by:
    - `reviews_avg_rating` descending
    - Then `reviews_count` descending
  - `DoctorSummaryResource` still shapes each item, but **does not** include `distance_km` because that attribute is not set.

---

## 3. Favorites – `POST/DELETE /api/doctors/{id}/favorite`

These endpoints require an authenticated user with `role = "patient"` and an attached `patient` record.

### Add favorite – `POST /api/doctors/{id}/favorite`

```json
{
  "success": true,
  "message": "Doctor added to favorites.",
  "data": {
    "is_favorite": true
  }
}
```

### Remove favorite – `DELETE /api/doctors/{id}/favorite`

```json
{
  "success": true,
  "message": "Doctor removed from favorites.",
  "data": {
    "is_favorite": false
  }
}
```

### Mapping to code

- Controller: `DoctorController@favorite` / `DoctorController@unfavorite`:
  - Resolve the current `patient` (403 if not a patient or patient profile missing).
  - Call `DoctorService::favoriteDoctor()` or `DoctorService::unfavoriteDoctor()`.
  - Return via `ApiResponse::success(['is_favorite' => true/false], ...)`.
- Repository:
  - Uses `favorite::firstOrCreate()` and `favorite::where(...)->delete()` against the `favorites` table.

---

## 4. Summary

- **Resources**
  - `DoctorDetailsResource` → detailed doctor view (details screen).
  - `DoctorSummaryResource` → compact doctor card for Home/Nearby.
  - `ReviewResource` → individual review items.
- **Helper**
  - `App\Support\ApiResponse` wraps all responses in a consistent envelope with `success`, optional `message`, and `data`.
- **Behavior**
  - Nearby endpoint:
    - With `lat`/`lng`: uses distance ordering and includes `distance_km`.
    - Without `lat`/`lng`: falls back to top-rated doctors, ordered by `reviews_avg_rating` then `reviews_count`, without `distance_km`.

