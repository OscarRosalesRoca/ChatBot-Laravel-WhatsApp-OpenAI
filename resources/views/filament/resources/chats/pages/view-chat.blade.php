<div>
    <h2 class="text-lg font-semibold mb-3">Chat Messages</h2>

    <div class="space-y-2 border p-3 rounded bg-gray-50 max-h-96 overflow-y-auto">
        @foreach($messages as $msg)
            <div class="@if($msg->sender === 'admin') text-right @endif">
                <div class="inline-block px-3 py-2 rounded-lg
                    @if($msg->sender === 'admin') bg-blue-500 text-white @else bg-gray-200 @endif">
                    <strong>{{ ucfirst($msg->sender) }}:</strong> {{ $msg->message }}
                </div>
                <div class="text-xs text-gray-400 mt-1">
                    {{ $msg->created_at->format('H:i d/m/Y') }}
                </div>
            </div>
        @endforeach
    </div>

    <form wire:submit.prevent="sendMessage" class="mt-4 flex space-x-2">
        <input type="text" wire:model="newMessage" class="border rounded px-3 py-2 flex-1"
               placeholder="Write a message..." />
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Send
        </button>
    </form>
</div>
