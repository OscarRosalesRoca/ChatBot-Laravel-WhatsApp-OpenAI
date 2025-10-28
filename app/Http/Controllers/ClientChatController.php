<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;

class ClientChatController extends Controller
{
    public function index(Request $request)
    {
        // Recuperar sesión y nombre
        $sessionId = $request->session()->get('chat_session_id');
        $name = $request->session()->get('chat_name', 'guest');

        if (!$sessionId) {
            $chat = Chat::create([
                'session_id' => uniqid('chat_', true),
                'name' => $name,
            ]);
            $request->session()->put('chat_session_id', $chat->session_id);
            $request->session()->put('chat_name', $chat->name);
        } else {
            $chat = Chat::where('session_id', $sessionId)->first();
            if (!$chat) {
                $chat = Chat::create([
                    'session_id' => $sessionId,
                    'name' => $name,
                ]);
            }
        }

        return view('client.chat', ['chat' => $chat]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $chat = Chat::where('session_id', $request->session()->get('chat_session_id'))->first();

        if (!$chat) {
            return response()->json(['error' => 'Chat not found'], 404);
        }

        $message = $chat->messages()->create([
            'sender' => $request->session()->get('chat_name', 'guest'),
            'message' => $request->message,
        ]);

        return response()->json([
            'id' => $message->id,
            'sender' => $message->sender,
            'message' => $message->message,
            'created_at' => $message->created_at->format('H:i'),
        ]);
    }

    public function setName(Request $request)
    {
        $request->validate(['name' => 'required|string|max:50']);
        $request->session()->put('chat_name', $request->name);

        $chat = Chat::where('session_id', $request->session()->get('chat_session_id'))->first();
        if ($chat) {
            $chat->update(['name' => $request->name]);
        }

        return response()->json(['status' => 'ok']);
    }
}
