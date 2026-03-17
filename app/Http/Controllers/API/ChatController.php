<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponseTrait;

class ChatController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        //display all chats for the authenticated
        $userId = auth()->id();
        // dd($userId);
        $chats = Chat::whereHas('patient', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->orWhereHas('doctor', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['patient:id,user_id', 'patient.user:id,name,email', 'doctor:id,user_id', 'doctor.user:id,name,email', 'messages.sender'])
            ->get();
        return $this->apiResponse($chats, 'Chats fetched successfully');
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

        if ($patient->user->role !== 'patient') {
            return $this->errorResponse('Selected patient_id is not a patient.', 403);
        }

        if ($doctor->user->role !== 'doctor') {
            return $this->errorResponse('Selected doctor_id is not a doctor.', 403);
        }

        $existingChat = Chat::where('patient_id', $patient->id)
            ->where('doctor_id', $doctor->id)
            ->first();

        if ($existingChat) {
            return $this->apiResponse($existingChat, 'Chat already exists.');
        }

        $chat = Chat::create($data);
        // Attach both patient's user and doctor's user to the chat with default pivot values
        $chat->users()->attach([$patient->user_id, $doctor->user_id], [
            'is_favorite' => false,
            'last_read_at' => now()
        ]);

        return $this->apiResponse($chat, 'Chat created successfully', 201);
    }


    public function show(string $id)
    {
        $userId = auth()->id();
        $chatId = $id;
        $chat = Chat::with(['messages.sender'])
            ->where('id', $chatId)
            ->where(function ($query) use ($userId) {
                $query->whereHas('patient', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->orWhereHas('doctor', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                });
            })
            ->firstOrFail();

        return $this->apiResponse($chat, 'Chat details fetched successfully');
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
        $chat->loadMissing(['patient', 'doctor']);
        // Check if the authenticated user's ID matches the chat's patient's user_id OR doctor's user_id
        if ($user->id !== $chat->patient->user_id && $user->id !== $chat->doctor->user_id) {
            return response()->json([
                'message' => 'User not part of this chat'
            ], 403);
        }
        // Mark messages as read directly on the messages table
        $chat->messages()->where('sender_id', '!=', $user->id)->update(['is_read' => true]);
        // Also update the pivot for legacy support
        DB::table('chat_user')->where('chat_id', $chat->id)->where('user_id', $user->id)
            ->update(['last_read_at' => now()]);
        return $this->apiResponse(null, 'Chat marked as read');
    }

    public function unreadMessagesCount($id)
    {
        $userId = auth()->id();
        $chat = Chat::with(['patient', 'doctor'])->findOrFail($id);
        // Authenticate the user is in this chat
        if ($userId !== $chat->patient->user_id && $userId !== $chat->doctor->user_id) {
            return $this->errorResponse('User not part of this chat', 403);
        }
        // Count messages in this specific chat where is_read is false and the authenticated user did NOT send it
        $unreadCount = $chat->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
        return $this->apiResponse(['unread_messages_count' => $unreadCount], 'Unread messages count fetched successfully');
    }

    // Toggle favorite status of a chat for the authenticated user
    public function toggleFavorite(Chat $chat)
    {
        $user = auth()->user();
        $chat->loadMissing(['patient', 'doctor']);
        // Check if the authenticated user's ID matches the chat's patient's user_id OR doctor's user_id
        if ($user->id !== $chat->patient->user_id && $user->id !== $chat->doctor->user_id) {
            return response()->json([
                'message' => 'User not part of this chat'
            ], 403);
        }
        $chatUser = DB::table('chat_user')->where('chat_id', $chat->id)->where('user_id', $user->id)->first();
        
        if (!$chatUser) {
            // If they aren't in the pivot but they are the patient/doctor, add them
            DB::table('chat_user')->insert([
                'chat_id' => $chat->id,
                'user_id' => $user->id,
                'is_favorite' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $newValue = true;
        } else {
            $newValue = !(bool)$chatUser->is_favorite;
            DB::table('chat_user')->where('chat_id', $chat->id)->where('user_id', $user->id)
                ->update(['is_favorite' => $newValue, 'updated_at' => now()]);
        }
        
        return $this->apiResponse(['is_favorite' => $newValue], 'Favorite status updated');
    }
    public function allFavoriteChats()
    {
        $user = auth()->user();
        $favoriteChats = $user->chats()
            ->wherePivot('is_favorite', true)
            ->with(['patient:id,user_id', 'patient.user:id,name,email', 'doctor:id,user_id', 'doctor.user:id,name,email', 'messages.sender'])
            ->get();

        return $this->apiResponse($favoriteChats, 'Favorite chats fetched successfully');
    }
    public function destroy(string $id)
    {
        $userId = auth()->id();
        $chat = Chat::where('id', $id)
            ->where(function ($query) use ($userId) {
                $query->whereHas('patient', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->orWhereHas('doctor', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                });
            })
            ->firstOrFail();

        $chat->delete();

        return $this->apiResponse(null, 'Chat deleted successfully');
    }
}
