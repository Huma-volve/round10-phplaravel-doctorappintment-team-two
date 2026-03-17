<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Events\MessageSent;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\ApiResponseTrait;

class MessageController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $userId = auth()->id();
        // Find all chats the user is a part of
        $chatIds = Chat::whereHas('patient', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->orWhereHas('doctor', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->pluck('id');

        // Get messages only for those chats
        $messages = Message::with(['sender', 'chat'])
            ->whereIn('chat_id', $chatIds)
            ->latest()
            ->paginate(50); // Using pagination for better performance

        return $this->apiResponse([
            'messages' => $messages->items(),
            'pagination' => [
                'total' => $messages->total(),
                'per_page' => $messages->perPage(),
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
            ]
        ], 'Messages fetched successfully');
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'chat_id'      => ['required', 'exists:chats,id'],
            'message_type' => ['required', 'in:text,image,video,audio'],
            'content'      => ['required'],   // text string OR uploaded file, both accepted
        ]);

        $user = auth()->user();
        $chat = Chat::with(['patient.user', 'doctor.user'])->findOrFail($request->chat_id);

        // Determine if the authenticated user is the patient or doctor in this chat
        if ($chat->patient && $chat->patient->user_id === $user->id) {
            $senderType = 'patient';
        } elseif ($chat->doctor && $chat->doctor->user_id === $user->id) {
            $senderType = 'doctor';
        } else {
            return $this->errorResponse('You are not part of this chat.', 403);
        }

        // Handle the content depending on message type
        if ($request->message_type === 'text') {
            $content = $request->content; // plain text
        } else {
            // content is an uploaded file
            if (!$request->hasFile('content')) {
                return $this->errorResponse('A file is required for message type: ' . $request->message_type, 422);
            }
            $content = $request->file('content')->store('messages', 'public');
            $content = Storage::url($content);
        }

        $message = Message::create([
            'chat_id'      => $request->chat_id,
            'sender_id'    => $user->id,
            'sender_type'  => $senderType,
            'message_type' => $request->message_type,
            'content'      => $content,
            'is_read'      => false,
        ]);

        $message->load('sender');
        broadcast(new MessageSent($message))->toOthers();
        
        return $this->apiResponse(new MessageResource($message), 'Message sent successfully', 201);
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
    
    }

    public function destroy(string $id)
    {
    }
}
