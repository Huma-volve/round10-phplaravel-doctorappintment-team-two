<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'clinic_id' => ['nullable', 'integer'],
            'specialization_id' => ['nullable', 'integer'],
            'license_number' => ['required', 'string', 'unique:doctors,license_number'],
            'bio' => ['nullable', 'string'],
            'clinic_address' => ['nullable', 'string'],
            'session_price' => ['nullable', 'numeric'],
        ]);


        $user = User::findOrFail($data['user_id']);

        if ($user->role !== 'doctor') {
            return response()->json([
                'message' => 'This user is not a doctor.'
            ], 403);
        }


        if (Doctor::where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'Doctor profile already exists.'
            ], 409);
        }

        $doctor = Doctor::create($data);

        return response()->json([
            'message' => 'Doctor profile created successfully',
            'doctor' => $doctor
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
