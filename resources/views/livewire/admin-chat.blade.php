<div class="flex flex-col h-screen bg-gray-100 p-4">
  <div class="max-w-3xl mx-auto w-full bg-white rounded-2xl shadow-lg flex flex-col h-full overflow-hidden">

    {{-- Header --}}
    <div class="bg-indigo-600 text-white px-6 py-4 text-lg font-semibold flex justify-between items-center">
      <span>Chat con {{ $chat->name ?? 'Cliente desconocido' }}</span>
      <span class="text-sm opacity-80">ID: {{ $chat->id }}</span>
    </div>

    {{-- Mensajes --}}
    <div wire:poll.2s="loadMessages" class="flex-1 overflow-y-auto px-6 py-4 space-y-3 bg-gray-50">
      @forelse ($messages as $message)
        <div class="flex {{ $message->sender === 'admin' ? 'justify-end' : 'justify-start' }}">
          <div
            class="px-4 py-2 rounded-2xl max-w-xs break-words
                   {{ $message->sender === 'admin'
                      ? 'bg-indigo-500 text-white rounded-br-none'
                      : 'bg-gray-200 text-gray-800 rounded-bl-none' }}">
            <span class="block text-sm font-semibold mb-1">
              {{ $message->sender === 'admin' ? 'Tú' : $message->sender }}
            </span>
            <span>{{ $message->message }}</span>
            <div class="text-[10px] text-right opacity-70 mt-1">
              {{ $message->created_at->format('H:i') }}
            </div>
          </div>
        </div>
      @empty
        <p class="text-center text-gray-500">No hay mensajes todavía.</p>
      @endforelse
    </div>

    {{-- Input --}}
    <form wire:submit.prevent="sendMessage" class="bg-white border-t border-gray-200 p-4 flex items-center gap-2">
      <input
        type="text"
        wire:model.defer="newMessage"
        placeholder="Escribe un mensaje..."
        class="flex-1 px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
      >
      <button
        type="submit"
        class="bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-700 transition"
      >
        Enviar
      </button>
    </form>

  </div>
</div>
