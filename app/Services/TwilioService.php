<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $this->from = env('TWILIO_WHATSAPP_FROM');
        $this->client = new Client($sid, $token);
    }

    public function sendWhatsAppMessage($to, $message)
    {
        return $this->client->messages->create(
            "whatsapp:" . $to,
            [
                'from' => "whatsapp:" . $this->from,
                'body' => $message,
            ]
        );
    }
}
