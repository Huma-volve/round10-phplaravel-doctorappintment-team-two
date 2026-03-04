<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //display al chats for the authenticated
        $userId = auth()->id();
        // dd($userId);
        $chats = Chat::where(function ($query) use ($userId) {
            $query->where('patient_id', $userId)
                ->orWhere('doctor_id', $userId);
        })->with(['patient:id,name,email', 'doctor:id,name,email', 'messages.sender'])
            ->get();
        return response()->json($chats);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => ['required', 'exists:users,id'],
            'doctor_id' => ['required', 'exists:users,id'],
        ]);

        $patient = User::findOrFail($data['patient_id']);
        $doctor  = User::findOrFail($data['doctor_id']);

        if ($patient->role !== 'patient') {
            return response()->json([
                'message' => 'Selected patient_id is not a patient.'
            ], 403);
        }

        if ($doctor->role !== 'doctor') {
            return response()->json([
                'message' => 'Selected doctor_id is not a doctor.'
            ], 403);
        }

        $existingChat = Chat::where('patient_id', $patient->id)
            ->where('doctor_id', $doctor->id)
            ->first();

        if ($existingChat) {
            return response()->json([
                'message' => 'Chat already exists.',
                'chat' => $existingChat
            ], 200);
        }

        $chat = Chat::create($data);

        return response()->json([
            'message' => 'Chat created successfully',
            'chat' => $chat
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = auth()->id();
        $chatId = $id;
        $chat = Chat::with(['messages.sender'])
            ->where('id', $chatId)
            ->where(function ($query) use ($userId) {
                $query->where('patient_id', $userId)
                    ->orWhere('doctor_id', $userId);
            })
            ->firstOrFail();

        return response()->json($chat);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
