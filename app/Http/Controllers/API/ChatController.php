<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
        ]);

        $patient = Patient::findOrFail($data['patient_id']);
        $doctor  = Doctor::findOrFail($data['doctor_id']);

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
        // Attach both patient and doctor to the chat with default pivot values
        $chat->users()->attach([$patient->id, $doctor->id], [
            'is_favorite' => false,
            'last_read_at' => now()
        ]);

        return response()->json([
            'message' => 'Chat created successfully',
            'chat' => $chat
        ], 201);
    }


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


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id) {}



    // Mark a chat as read for the authenticated user
    public function markAsRead(Chat $chat)
    {
        $user = auth()->user();
        $user->chats()->updateExistingPivot($chat->id, [
            'last_read_at' => now()
        ]);
        return response()->json([

            'message' => 'Chat marked as read'
        ]);
    }
    public function unreadMessagesCount()
    {
        $user = auth()->user();
        $unreadCount = $user->chats()
            ->withCount(['messages as unread_messages_count' => function ($query) use ($user) {
                $query->where('created_at', '>', now()->subMinutes(5))
                    ->where('sender_id', '!=', $user->id);
            }])
            ->get()
            ->sum('unread_messages_count');

        return response()->json([
            'unread_messages_count' => $unreadCount
        ]);
    }
    // Toggle favorite status of a chat for the authenticated user
    public function toggleFavorite(Chat $chat)
    {
        $user = auth()->user();
        // dd($user);
        $chatUser = $user->chats()->where('chat_id', $chat->id)->first();
        if (!$chatUser) {
            return response()->json([
                'message' => 'User not part of this chat'
            ], 403);
        }
        $newValue = !$chatUser->pivot->is_favorite;
        $user->chats()->updateExistingPivot($chat->id, [
            'is_favorite' => $newValue
        ]);
        return response()->json([
            'message' => 'Favorite status updated',
            'is_favorite' => $newValue
        ]);
    }
    public function allFavoriteChats()
    {
        $user = auth()->user();
        $favoriteChats = $user->chats()
            ->wherePivot('is_favorite', true)
            ->with(['patient:id,name,email', 'doctor:id,name,email', 'messages.sender'])
            ->get();

        return response()->json($favoriteChats);
    }
    public function destroy(string $id)
    {
        $userId = auth()->id();
        $chat = Chat::where('id', $id)
            ->where(function ($query) use ($userId) {
                $query->where('patient_id', $userId)
                    ->orWhere('doctor_id', $userId);
            })
            ->firstOrFail();

        $chat->delete();

        return response()->json([
            'message' => 'Chat deleted successfully'
        ]);
    }
}
