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
    public function index()
    {
        $messages = Message::with(['sender', 'chat'])
            ->latest()
            ->get();

        return response()->json([
            'messages' => $messages
        ], 200);
    }


    public function create()
    {
        //
    }

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


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }

    /*************  ✨ Windsurf Command 🌟  *************/
    /**
     * Update a message
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, string $id)
    {
        // Update a message with the given ID
        // TODO: Implement this
        //
    }


    /*******  7dbfc0c9-da29-42ec-9ac6-4a15c5fcacd1  *******/
    public function destroy(string $id)
    {
        //
    }
}
