<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Http\Resources\Api\FavoriteResource;
use Illuminate\Support\Facades\Auth;

class Favoritecontroller extends Controller
{
    public function index()
    {
        $favorites =FavoriteResource::collection(Favorite::all());

        return response()->json([
            'status' => true,
            'all_data_count' => $favorites->count(),
            'data' => $favorites
        ]);
    }

 public function store(Request $request)
{
     $validate=  $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
        'patient_id' => 'required|exists:patients,id',

    ]);

    $favorite = Favorite::create($validate);

    return response()->json([
        'status' => true, 
        'message' => 'Added to favorites',
        'data' => $favorite
    ]);
}

    // // إزالة من المفضلة
    // public function destroy($id)
    // {
    //     Favorite::where('id', $id)->where('patient_id', Auth::id())->delete();
    //     return response()->json(['status' => true, 'message' => 'Removed from favorites']);
    // }
}
