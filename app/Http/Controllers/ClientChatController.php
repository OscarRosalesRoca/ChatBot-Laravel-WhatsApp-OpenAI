<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;

class ClientChatController extends Controller
{
    public function index(Request $request)
    {
        // Guardar o recuperar la sesión del cliente
        $sessionId = $request->session()->get('chat_session_id');
        if (!$sessionId) {
            $chat = Chat::create([
                'session_id' => uniqid('chat_', true),
                'name' => 'guest',
            ]);
            $request->session()->put('chat_session_id', $chat->session_id);
        } else {
            $chat = Chat::where('session_id', $sessionId)->first();
            if (!$chat) {
                $chat = Chat::create([
                    'session_id' => $sessionId,
                    'name' => 'guest',
                ]);
            }
        }

        return view('client.chat', [
            'chat' => $chat,
            'messages' => $chat->messages()->latest()->get(),
        ]);
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
            'sender' => 'client',
            'message' => $request->message,
        ]);

        // Devolver JSON para actualizar la vista sin recargar
        return response()->json([
            'id' => $message->id,
            'sender' => $message->sender,
            'message' => $message->message,
            'created_at' => $message->created_at->format('H:i'),
        ]);
    }
}
