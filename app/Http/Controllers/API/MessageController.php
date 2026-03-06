<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $messages = Message::with(['sender', 'chat'])
            ->latest()
            ->get();

        return response()->json([
            'messages' => $messages
        ], 200);
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
            'chat_id' => ['required', 'exists:chats,id'],
            'sender_id' => ['required', 'exists:users,id'],
            'sender_type' => ['required', 'in:patient,doctor'],
            'message_type' => ['required', 'in:text,image,video,audio'],
            'content' => ['required', 'string'],
        ]);


        $user = User::findOrFail($data['sender_id']);
        if ($user->role !== $data['sender_type']) {
            return response()->json([
                'message' => 'Sender type does not match user role.'
            ], 422);
        }


        $chat = Chat::findOrFail($data['chat_id']);
        if (!in_array($data['sender_id'], [$chat->patient_id, $chat->doctor_id])) {
            return response()->json([
                'message' => 'User not part of this chat.'
            ], 403);
        }


        $message = Message::create($data);


        $message->load('sender');
        broadcast(new MessageSent($message))->toOthers();
        return new MessageResource($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
