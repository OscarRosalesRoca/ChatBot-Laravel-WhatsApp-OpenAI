<div>
    <h2 class="text-lg font-semibold mb-3">Chat del Cliente</h2>

    @if($chat->name === 'guest')
        <div class="mb-4">
            <input type="text" wire:model.defer="name" placeholder="Escribe tu nombre"
                class="border p-2 rounded w-full">
            <button wire:click="setClientName"
                class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Guardar nombre
            </button>
        </div>
    @else
        <div class="space-y-2 border p-3 rounded max-h-96 overflow-y-auto bg-gray-50"
             wire:poll.2000ms="loadMessages">
            @foreach($messages as $msg)
                <div class="{{ $msg->sender === $chat->name ? 'text-right bg-green-500 text-white' : 'text-left bg-gray-200' }} p-2 rounded">
                    <strong>{{ $msg->sender }}:</strong> {{ $msg->message }}
                </div>
            @endforeach
        </div>

        <div class="mt-2 flex space-x-2">
            <input type="text" wire:model="newMessage" placeholder="Escribe un mensaje..."
                class="border rounded px-3 py-2 flex-1">
            <button wire:click="sendMessage"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Enviar
            </button>
        </div>
    @endif
</div>
