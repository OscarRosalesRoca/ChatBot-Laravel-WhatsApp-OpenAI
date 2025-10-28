<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Models\Message;

class ClientChat extends Component
{
    public Chat $chat;
    public $name = '';
    public $newMessage = '';
    public $messages = [];

    public function mount()
    {
        // Buscar o crear el chat de la sesión
        $sessionId = session('chat_session_id');
        if (!$sessionId) {
            $chat = Chat::create([
                'session_id' => uniqid('chat_', true),
                'name' => 'guest',
            ]);
            session(['chat_session_id' => $chat->session_id]);
        } else {
            $chat = Chat::where('session_id', $sessionId)->first();
        }

        $this->chat = $chat;
        $this->name = $chat->name;
        $this->loadMessages();
    }

    public function setClientName()
    {
        if (trim($this->name) === '') {
            $this->name = 'guest';
        }

        $this->chat->update(['name' => $this->name]);
    }

    public function loadMessages()
    {
        $this->messages = $this->chat->messages()->latest()->take(50)->get()->reverse();
    }

    public function sendMessage()
    {
        if (trim($this->newMessage) === '') return;

        $this->chat->messages()->create([
            'sender' => $this->name ?? 'guest',
            'message' => $this->newMessage,
        ]);

        $this->newMessage = '';
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.client-chat');
    }
}
