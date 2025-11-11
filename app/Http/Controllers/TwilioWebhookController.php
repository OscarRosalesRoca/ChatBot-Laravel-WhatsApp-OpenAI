<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;

class TwilioWebhookController extends Controller
{

    public function handle(Request $request)
    {
        Log::info('Twilio webhook hit', $request->all());

        $from = $request->input('From');
        $body = $request->input('Body');

        if (!$from || !$body) {
            Log::warning('Twilio webhook missing data', ['from' => $from, 'body' => $body]);
            return response('Bad Request', 400);
        }

        $chat = Chat::firstOrCreate(
            ['whatsapp_number' => $from],
            ['name' => 'Cliente ' . substr($from, -4)]
        );

        Message::create([
            'chat_id' => $chat->id,
            'sender' => 'client',
            'message' => $body,
        ]);

        Log::info('Message saved from Twilio', ['from' => $from, 'body' => $body]);

        return response('OK', 200);
    }

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
