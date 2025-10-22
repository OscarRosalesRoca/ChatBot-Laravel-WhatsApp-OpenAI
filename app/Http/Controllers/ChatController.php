<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    // Recibir mensaje del cliente
    public function receive(Request $request)
    {
        // Identificador de sesión del cliente (cookie o generado si no existe)
        $sessionId = $request->cookie('session_id', Str::uuid());

        // Buscar chat existente o crear uno nuevo
        $chat = Chat::firstOrCreate(
            ['session_id' => $sessionId],
            ['name' => 'Cliente '.$sessionId]
        );

        // Guardar el mensaje del cliente
        $msg = $chat->messages()->create([
            'sender' => 'client',
            'message' => $request->input('message', 'Hola!'),
        ]);

        // Devolver JSON con todos los mensajes del chat
        return response()->json([
            'chat_id' => $chat->id,
            'messages' => $chat->messages()->get(),
        ])->withCookie(cookie('session_id', $sessionId, 60*24)); // cookie válida 1 día
    }

    // Recuperar todos los mensajes de un chat (para admin)
    public function getChatMessages($chatId)
    {
        $chat = Chat::with('messages')->findOrFail($chatId);

        return response()->json([
            'chat_id' => $chat->id,
            'messages' => $chat->messages,
        ]);
    }

    // Enviar mensaje como admin
    public function sendMessage(Request $request, $chatId)
    {
        $chat = Chat::findOrFail($chatId);

        $msg = $chat->messages()->create([
            'sender' => 'admin',
            'message' => $request->input('message'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => $msg,
        ]);
    }
}
