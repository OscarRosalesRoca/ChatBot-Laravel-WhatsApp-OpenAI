<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;

class TwilioWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $from = $request->input('From');
        $body = $request->input('Body');

        // Buscamos o creamos el chat correspondiente
        $chat = Chat::firstOrCreate(
            ['whatsapp_number' => $from],
            ['name' => 'Cliente ' . substr($from, -4)]
        );

        // Guardamos el mensaje
        Message::create([
            'chat_id' => $chat->id,
            'sender' => 'client',
            'message' => $body,
        ]);

        return response('OK', 200);
    }
}
