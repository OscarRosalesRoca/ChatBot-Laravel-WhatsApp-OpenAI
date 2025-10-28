<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Models\Message;

class AdminChat extends Component
{
    // Puede ser Chat object o null si no se ha resuelto todavía
    public $chat;
    public $chatId;
    public $messages = [];
    public $newMessage = '';

    protected $listeners = [
        'messageSent' => 'loadMessages',
    ];

    /**
     * Soportamos ambas formas de inicialización:
     * - mount(Chat $chat) cuando Livewire inyecta el modelo (ruta /admin/chat/{chat})
     * - mount($chatId) cuando lo incrustamos desde Filament con :chat-id="$record->id"
     */
    public function mount($chat = null)
    {
        // Si $chat es una instancia de Chat (inyección automática)
        if ($chat instanceof Chat) {
            $this->chat = $chat;
            $this->chatId = $chat->id;
        } elseif (is_numeric($chat)) {
            // Si nos pasaron un id directamente como parámetro
            $this->chatId = (int) $chat;
            $this->chat = Chat::find($this->chatId);
        } elseif ($this->chatId) {
            // Caso en que Livewire haya seteado public $chatId por binding
            $this->chat = Chat::find($this->chatId);
        } else {
            $this->chat = null;
        }

        $this->loadMessages();
    }

    public function loadMessages()
    {
        if (! $this->chat) {
            $this->messages = [];
            return;
        }

        $this->messages = $this->chat->messages()
            ->latest()
            ->take(100)
            ->get()
            ->reverse();
    }

    public function sendMessage()
    {
        if (! $this->chat) {
            $this->dispatchBrowserEvent('toast', ['type' => 'error', 'message' => 'Chat not loaded.']);
            return;
        }

        if (trim($this->newMessage) === '') return;

        $this->chat->messages()->create([
            'sender' => 'admin',
            'message' => $this->newMessage,
        ]);

        $this->newMessage = '';
        $this->loadMessages();

        // Notifica listeners (por ejemplo el cliente)
        $this->dispatch('messageSent');
    }

    public function render()
    {
        return view('livewire.admin-chat');
    }
}
