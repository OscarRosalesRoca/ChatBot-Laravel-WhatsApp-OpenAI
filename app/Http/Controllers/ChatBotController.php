<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class ChatBotController extends Controller
{
    // Método para recibir un mensaje y generar respuesta
    public function receive(Request $request)
    {
        // Recibir datos del mensaje
        $from = $request->input('from', '123456789'); // número de prueba si no se pasa
        $message = $request->input('message', 'Hola bot!');

        // Guardar el mensaje en la base de datos
        $msg = Message::create([
            'from' => $from,
            'message' => $message,
            'status' => 'received',
        ]);

        // Generar respuesta (simulada por ahora)
        $reply = $this->generateReply($message);

        // Guardar la respuesta en la base de datos
        $msg->update([
            'response' => $reply,
            'status' => 'sent',
        ]);

        // Devolver JSON con mensaje y respuesta
        return response()->json([
            'from' => $from,
            'message' => $message,
            'reply' => $reply
        ]);
    }

    // Función que simula la respuesta del bot
    private function generateReply($message)
    {
        $message = strtolower($message);

        if (strpos($message, 'hola') !== false) {
            return "¡Hola! ¿Cómo puedo ayudarte hoy?";
        } elseif (strpos($message, 'adios') !== false) {
            return "¡Hasta luego! Que tengas un buen día.";
        } else {
            return "Gracias por tu mensaje. En breve alguien te responderá.";
        }
    }
}
