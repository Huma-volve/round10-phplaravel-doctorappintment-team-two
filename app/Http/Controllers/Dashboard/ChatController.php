<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Display a list of all chats for the doctor.
     */
    public function index()
    {
        $user = $this->getAuthUser();
        
        if (!$user) {
            return "No doctor found with ID 2. Please create a doctor or log in.";
        }

        // Fetch all chats involving this user
        $chats = Chat::whereHas('doctor', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->orWhereHas('patient', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['patient.user', 'doctor.user', 'messages' => function($query) {
            $query->latest()->limit(1);
        }, 'users' => function($q) use ($user) {
            $q->where('users.id', $user->id);
        }])->get()
        ->map(function ($chat) use ($user) {
            // Calculate unread count for this user
            $chat->unread_count = $chat->messages()
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->count();
            
            // Get the other user's info
            if ($chat->doctor && $chat->doctor->user_id === $user->id) {
                $chat->other_user = $chat->patient->user ?? null;
            } else {
                $chat->other_user = $chat->doctor->user ?? null;
            }
            
            $chat->last_message = $chat->messages->first();

            // Get favorite status from pivot
            $pivot = $chat->users->first();
            $chat->is_favorite = $pivot ? (bool)$pivot->pivot->is_favorite : false;
            
            return $chat;
        })
        ->sort(function($a, $b) {
            // Priority 1: Favorites first
            if ($a->is_favorite && !$b->is_favorite) return -1;
            if (!$a->is_favorite && $b->is_favorite) return 1;
            
            // Priority 2: Latest message
            $timeA = $a->last_message ? $a->last_message->created_at : $a->created_at;
            $timeB = $b->last_message ? $b->last_message->created_at : $b->created_at;
            
            return $timeB <=> $timeA;
        });

        return view('chat.index', [
            'chats' => $chats,
            'currentUser' => $user
        ]);
    }

    /**
     * Show a specific chat conversation.
     */
    public function show(Chat $chat)
    {
        $user = $this->getAuthUser();
        
        if (!$user) {
            return redirect()->route('login-dash');
        }
        
        // Ensure user is part of the chat
        if ($chat->doctor->user_id !== $user->id && $chat->patient->user_id !== $user->id) {
            abort(403);
        }

        // Mark messages as read
        $chat->messages()->where('sender_id', '!=', $user->id)->update(['is_read' => true]);

        $chat->load(['messages.sender', 'patient.user', 'doctor.user']);
        
        // Get the other user's info
        if ($chat->doctor->user_id === $user->id) {
            $other_user = $chat->patient->user;
        } else {
            $other_user = $chat->doctor->user;
        }

        // Fetch all chats for the sidebar
        $chats = Chat::whereHas('doctor', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->orWhereHas('patient', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['patient.user', 'doctor.user', 'messages' => function($query) {
            $query->latest()->limit(1);
        }, 'users' => function($q) use ($user) {
            $q->where('users.id', $user->id);
        }])->get()
        ->map(function ($c) use ($user) {
            $c->unread_count = $c->messages()
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->count();
            
            if ($c->doctor && $c->doctor->user_id === $user->id) {
                $c->other_user = $c->patient->user ?? null;
            } else {
                $c->other_user = $c->doctor->user ?? null;
            }
            
            $c->last_message = $c->messages->first();

            // Get favorite status from pivot
            $pivot = $c->users->first();
            $c->is_favorite = $pivot ? (bool)$pivot->pivot->is_favorite : false;

            return $c;
        })
        ->sort(function($a, $b) {
            if ($a->is_favorite && !$b->is_favorite) return -1;
            if (!$a->is_favorite && $b->is_favorite) return 1;
            
            $timeA = $a->last_message ? $a->last_message->created_at : $a->created_at;
            $timeB = $b->last_message ? $b->last_message->created_at : $b->created_at;
            
            return $timeB <=> $timeA;
        });

        return view('chat.show', [
            'chat' => $chat,
            'other_user' => $other_user,
            'chats' => $chats,
            'currentUser' => $user
        ]);
    }

    /**
     * Store a new message.
     */
    public function store(Request $request, Chat $chat)
    {
        $user = $this->getAuthUser();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Ensure user is part of the chat
        if ($chat->doctor->user_id !== $user->id && $chat->patient->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'message_type' => 'required|in:text,image,audio',
            'content' => $request->message_type === 'text' ? 'required|string' : 'required|file|max:10240',
        ]);

        $content = $request->content;
        if ($request->message_type !== 'text') {
            $path = $request->file('content')->store('messages', 'public');
            $content = Storage::url($path);
        }

        $senderType = ($chat->doctor->user_id === $user->id) ? 'doctor' : 'patient';

        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'sender_type' => $senderType,
            'message_type' => $request->message_type,
            'content' => $content,
            'is_read' => false,
        ]);

        $message->load('sender');

        if ($request->ajax()) {
            return view('chat.partials.message', [
                'message' => $message,
                'currentUser' => $user
            ])->render();
        }

        return back();
    }

    public function destroyMessage(Message $message)
    {
        $user = $this->getAuthUser();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $chat = $message->chat;
        
        if ($message->sender_id !== $user->id && $chat->doctor->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->delete();

        return response()->json(['success' => true]);
    }

    public function toggleFavorite(Chat $chat)
    {
        $user = $this->getAuthUser();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Ensure user is part of the chat
        if ($chat->doctor->user_id !== $user->id && $chat->patient->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $chatUser = DB::table('chat_user')
            ->where('chat_id', $chat->id)
            ->where('user_id', $user->id)
            ->first();
        
        if (!$chatUser) {
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
            DB::table('chat_user')
                ->where('chat_id', $chat->id)
                ->where('user_id', $user->id)
                ->update(['is_favorite' => $newValue, 'updated_at' => now()]);
        }
        
        return response()->json([
            'is_favorite' => $newValue
        ]);
    }

    private function getAuthUser()
    {
        $user = Auth::user();
        if (!$user) {
            $user = User::with('doctor.specialization')->find(2); 
        } else {
            $user->load('doctor.specialization');
        }
        return $user;
    }
}
