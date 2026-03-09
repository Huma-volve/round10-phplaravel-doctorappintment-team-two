<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\SearchHistory;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
     public function search(Request $request)
    {
        $query = Doctor::with(['user', 'specialization', 'clinic']);

        // 1. البحث حسب الاسم أو التخصص
        if ($request->name) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
            // حفظ سجل البحث (فقط إذا كان المستخدم مسجلاً دخولاً)
            if (Auth::check()) {
                SearchHistory::create([
                    'patient_id' => Auth::id(),
                    'keyword' => $request->name
                ]);
            }
        }

        if ($request->specialization_id) {
            $query->where('specialization_id', $request->specialization_id);
        }

        if ($request->latitude && $request->longitude) {
            $lat = $request->latitude;
            $lng = $request->longitude;
            $radius = 10;  

            $query->whereHas('clinic', function ($q) use ($lat, $lng, $radius) {
                $q->selectRaw("id, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance", [$lat, $lng, $lat])
                  ->having("distance", "<", $radius);
            });
        }

        $doctors = $query->get();

        if ($doctors->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No doctors found'], 404);
        }

        return response()->json(['status' => true, 'data' => $doctors]);
    }
}
